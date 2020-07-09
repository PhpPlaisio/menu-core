/**
 * Utility class for marking active menu items.
 */
export class CoreMenu
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Adds class menu-active tot the active menu item.
   *
   * @param id The ID of the menu element.
   */
  public static markActiveMenuItem(id: string): void
  {
    $('#' + $.escapeSelector(id)).addClass('menu-active');
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
