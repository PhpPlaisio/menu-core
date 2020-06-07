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
   * @inheritDoc
   */
  public function menu(int $mnuId): string
  {
    $row = $this->nub->DL->abcMenuCoreCacheGet($this->nub->company->cmpId,
                                               $mnuId,
                                               $this->nub->babel->lanId,
                                               $this->nub->session->proId);

    if ($row===null)
    {
      $menu  = $this->nub->DL->abcMenuCoreMenuGetDetails($mnuId);
      $class = $menu['mnu_class'];
      /** @var MenuGenerator $generator */
      $generator = new $class($this);
      $html      = $generator->menu($mnuId);

      $this->nub->DL->abcMenuCoreCachePut($this->nub->company->cmpId,
                                          $mnuId,
                                          $this->nub->babel->lanId,
                                          $this->nub->session->proId,
                                          $html);
    }
    else
    {
      $html = $row['mnc_html'];
    }

    return $html;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
