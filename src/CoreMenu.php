<?php
declare(strict_types=1);

namespace Plaisio\Menu;

use Plaisio\PlaisioObject;

/**
 * Core implementation of Menu.
 */
class CoreMenu extends PlaisioObject implements Menu
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the ID of the HTML element of the menu item associated with a page.
   *
   * @param int $mnuId The ID of the menu.
   * @param int $pagId The ID of the page.
   *
   * @return string|null
   */
  public function itemId(int $mnuId, int $pagId): ?string
  {
    $mniId = $this->nub->DL->abcMenuCoreLinkGetItemByPage($mnuId, $pagId);

    return ($mniId===null) ? null : 'mni-'.$this->nub->obfuscator::encode($mniId, 'mni');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritdoc
   */
  public function menu(int $mnuId, ?string $name = null): string
  {
    $row = $this->nub->DL->abcMenuCoreCacheGet($this->nub->company->cmpId,
                                               $mnuId,
                                               $this->nub->babel->lanId,
                                               $this->nub->session->proId);

    if ($row===null)
    {
      $html = $this->generateMenu($mnuId, $name);
    }
    else
    {
      $html = $row['mnc_html'];
    }

    $this->markActiveMenuItem($mnuId);

    return $html;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Generates the HTML code of a menu.
   *
   * @param int         $mnuId The ID of the menu.
   * @param string|null $name  The name of the menu. If null the default menu name will be used.
   *
   * @return string
   */
  private function generateMenu(int $mnuId, ?string $name): string
  {
    $menu  = $this->nub->DL->abcMenuCoreMenuGetDetails($mnuId);
    $class = $menu['mnu_class'];
    /** @var MenuGenerator $generator */
    $generator = new $class($this);
    $html      = $generator->menu($mnuId, $name);

    $this->nub->DL->abcMenuCoreCachePut($this->nub->company->cmpId,
                                        $mnuId,
                                        $this->nub->babel->lanId,
                                        $this->nub->session->proId,
                                        $html);

    return $html;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Highlights the active menu item.
   *
   * @param int $mnuId The ID of the menu.
   */
  private function markActiveMenuItem(int $mnuId): void
  {
    $pagId = $this->nub->pageInfo['pag_id'];
    $mniId = $this->nub->DL->abcMenuCoreLinkGetItemByPage($mnuId, $pagId);

    if ($mniId!==null)
    {
      $id = 'mni-'.$this->nub->obfuscator::encode($mniId, 'mni');
      $this->nub->assets->jsAdmFunctionCall(__CLASS__, 'markActiveMenuItem', [$id]);
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
