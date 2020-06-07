<?php
declare(strict_types=1);

namespace Plaisio\Menu;

use Plaisio\Cache\Event\FlushAllCacheEvent;
use Plaisio\PlaisioInterface;
use Plaisio\Profile\Event\ChangedProfileEvent;
use Plaisio\Profile\Event\ObsoleteProfileEvent;

/**
 * Event handler for obsolete and changed profiles and flush caches events.
 */
class CoreMenuEventHandler
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Handles a changed profile event.
   *
   * @param PlaisioInterface    $object The parent Plaisio object.
   * @param ChangedProfileEvent $event  The event.
   */
  public static function handleChangedProfileEvent(PlaisioInterface $object, ChangedProfileEvent $event): void
  {
    $object->nub->DL->abcMenuCoreCacheFlushByProId($object->nub->company->cmpId, $event->getProId());
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Handles a changed profile event.
   *
   * @param PlaisioInterface   $object The parent Plaisio object.
   * @param FlushAllCacheEvent $event  The event.
   */
  public static function handleFlushAllCacheEvent(PlaisioInterface $object, FlushAllCacheEvent $event): void
  {
    unset($event);

    $object->nub->DL->abcMenuCoreCacheFlush($object->nub->company->cmpId);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Handles an obsolete profile event.
   *
   * @param PlaisioInterface     $object The parent Plaisio object.
   * @param ObsoleteProfileEvent $event  The event.
   */
  public static function handleObsoleteProfileEvent(PlaisioInterface $object, ObsoleteProfileEvent $event): void
  {
    $object->nub->DL->abcMenuCoreCacheFlushByProId($object->nub->company->cmpId, $event->getProId());
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
