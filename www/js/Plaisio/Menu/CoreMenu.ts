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
// Plaisio\Console\Helper\TypeScript\TypeScriptMarkHelper::md5: a69ae74b4cd6f65042ba77f8988ebedb
