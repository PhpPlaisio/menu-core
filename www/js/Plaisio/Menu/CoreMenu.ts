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
    $('#' + $.escapeSelector(id))
      .addClass('menu-is-active')
      .find('*').addClass('menu-is-active');
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
// Plaisio\Console\TypeScript\Helper\MarkHelper::md5: 3951420a7c86828a1bd1af40e2e96b1c
