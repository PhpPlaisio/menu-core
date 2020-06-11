<?php
declare(strict_types=1);

namespace Plaisio\Menu;

use Plaisio\Helper\Html;
use Plaisio\PlaisioInterface;

/**
 * Generator of HTML code of menus.
 */
class CoreMenuGenerator implements MenuGenerator, PlaisioInterface
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The details of the menu.
   *
   * @var array
   */
  private $menu;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Object constructor.
   *
   * @param PlaisioInterface $object The parent Plaisio object.
   */
  public function __construct(PlaisioInterface $object)
  {
    $this->nub = $object->nub;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Normalizes the name of the menu.
   *
   * @param string $name The name of the menu.
   *
   * @return string
   */
  private static function normalizeMenuName(string $name): string
  {
    $name = mb_strtolower($name);
    $name = preg_replace('/[^0-9a-z]/', '-', $name);
    $name = str_replace('--', '-', $name);

    return trim($name, '-');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritDoc
   */
  public function menu(int $mnuId, ?string $name): string
  {
    $this->menu = $this->getMenuDetails($mnuId, $name);
    $items      = $this->getMenuItems($mnuId);

    $items = $this->removeUnauthorizedItems($items);
    $items = $this->organizeItems($items);
    $items = $this->removeEmptyFolders($items);

    return $this->generateHtml($items);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Generates the HTML code of the menu.
   *
   * @param array $items The tree menu items.
   *
   * @return string
   */
  protected function generateHtml(array $items): string
  {
    if (empty($items)) return '';

    $html = Html::generateTag('nav', ['id' => 'menu-'.$this->menu['mnu_name'], 'class' => $this->classes()]);
    $html .= $this->generateHtmlHelper1($items, 0);
    $html .= '</nav>';

    return $html;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Helps to generate the HTML code of the menu.
   *
   * @param array $items The sub-tree menu of items.
   * @param int   $level The current level of the sub-tree.
   *
   * @return string
   */
  protected function generateHtmlHelper1(array $items, int $level): string
  {
    $classes = $this->classes(false, $level);
    $html    = Html::generateTag('ul', ['class' => $classes]);

    foreach ($items as $key => $item)
    {
      $classes = $this->classes(empty($item['children']),
        $level,
        ($key===array_key_first($items)),
        ($key===array_key_last($items)));

      if ($item['mni_text']!==null)
      {
        if ($item['pag_alias']===null)
        {
          $url = $this->nub->cgi->putId('pag', $item['pag_id'], 'pag');
        }
        else
        {
          $url = '/'.$item['pag_alias'];
        }

        $id   = 'mni-'.$this->nub->obfuscator::encode($item['mni_id'], 'mni');
        $html .= Html::generateTag('li', ['id' => $id, 'class' => $classes]);
        $html .= Html::generateElement('a', ['href' => $url], $item['mni_text']);
      }

      if (!empty($item['children']))
      {
        $html .= $this->generateHtmlHelper1($item['children'], $level + 1);
      }
      $html .= '</li>';
    }

    $html .= '</ul>';

    return $html;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the details of a menu.
   *
   * @param int         $mnuId The ID of the menu.
   * @param string|null $name  The name of the menu. If null the default menu name will be used.
   *
   * @return array
   */
  protected function getMenuDetails(int $mnuId, ?string $name): array
  {
    $menu             = $this->nub->DL->abcMenuCoreMenuGetDetails($mnuId);
    $menu['mnu_name'] = self::normalizeMenuName($name ?? $menu['mnu_name']);

    return $menu;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the items of a menu.
   *
   * @param int $mnuId The ID of the menu.
   *
   * @return array
   */
  protected function getMenuItems(int $mnuId): array
  {
    return $this->nub->DL->abcMenuCoreMenuGetItems($mnuId, $this->nub->babel->lanId);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Organizes the flat row set with menu items into a tree with menu items.
   *
   * @param array $items The flat row set with menu items.
   *
   * @return array The tree of menu items.
   */
  protected function organizeItems(array $items): array
  {
    $tmp1 = [];
    foreach ($items as &$item)
    {
      $item['children']      = [];
      $tmp1[$item['mni_id']] = $item;
    }

    $tmp2 = [];
    foreach ($tmp1 as &$item)
    {
      if ($item['mni_id_parent']===null)
      {
        $tmp2[] = &$item;
      }
      else
      {
        $tmp1[$item['mni_id_parent']]['children'][] = &$item;
      }
    }

    return $tmp2;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Removes empty sub-tree from the menu items.
   *
   * @param array $items The flat row set with menu items.
   *
   * @return array
   */
  protected function removeEmptyFolders(array $items): array
  {
    foreach ($items as $i => &$item)
    {
      $item['children'] = $this->removeEmptyFolders($item['children']);

      if (empty($item['children']) && $item['pag_id']===null)
      {
        unset($items[$i]);
      }
    }

    return $items;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Removes menu items for which the current user agent does not have access to.
   *
   * @param array $items The flat row set with menu items.
   *
   * @return array
   */
  protected function removeUnauthorizedItems(array $items): array
  {
    foreach ($items as $i => $item)
    {
      $unset = ($item['pag_id']!==null && !$this->nub->authority->hasAccessToPage($item['pag_id']));
      $unset = $unset || ($item['mni_hide_anonymous']===1 && $this->nub->session->isAnonymous());
      $unset = $unset || ($item['mni_hide_identified']===1 && !$this->nub->session->isAnonymous());

      if ($unset)
      {
        unset($items[$i]);
      }
    }

    return $items;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the classes for a ul, li, and nav element.
   *
   * @param bool     $isLeave Must be tree if and only if the menu item is a leave.
   * @param int|null $level   The level of the menu item in the tree.
   * @param bool     $isFirst Must true if and only if a leave is the first menu item.
   * @param bool     $isLast  Must true if and only if a leave is the last menu item.
   *
   * @return array
   */
  private function classes(bool $isLeave = false,
                           ?int $level = null,
                           bool $isFirst = false,
                           bool $isLast = false): array
  {
    $classes = ['menu-'.$this->menu['mnu_name']];

    if ($level!==null)
    {
      $classes[] = 'menu-level-'.$level;
    }

    if ($isLeave)
    {
      $classes[] = 'menu-leave';
    }

    if ($isFirst)
    {
      $classes[] = 'menu-first';
    }

    if ($isLast)
    {
      $classes[] = 'menu-last';
    }

    return $classes;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
