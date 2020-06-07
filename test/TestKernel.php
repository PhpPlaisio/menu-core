<?php
declare(strict_types=1);

namespace Plaisio\Menu\Test;

use Plaisio\Authority\CoreAuthority;
use Plaisio\Babel\Babel;
use Plaisio\Babel\CoreBabel;
use Plaisio\C;
use Plaisio\Cgi\CoreCgi;
use Plaisio\CompanyResolver\CompanyResolver;
use Plaisio\CompanyResolver\UniCompanyResolver;
use Plaisio\LanguageResolver\CoreLanguageResolver;
use Plaisio\LanguageResolver\LanguageResolver;
use Plaisio\Menu\CoreMenu;
use Plaisio\Obfuscator\DevelopmentObfuscatorFactory;
use Plaisio\PlaisioKernel;
use SetBased\Stratum\MySql\MySqlDefaultConnector;

/**
 * Kernel for testing purposes.
 */
class TestKernel extends PlaisioKernel
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the helper object for deriving the company.
   *
   * @return CompanyResolver
   */
  public function getCompany(): CompanyResolver
  {
    return new UniCompanyResolver(C::CMP_ID_SYS);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @return CoreAuthority
   */
  protected function getAuthority(): CoreAuthority
  {
    return new CoreAuthority($this);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the helper object for retrieving linguistic entities.
   *
   * @return Babel
   */
  protected function getBabel(): Babel
  {
    $babel = new CoreBabel($this);
    $babel->setLanguage(C::LAN_ID_EN);

    return $babel;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @return CoreCgi
   */
  protected function getCgi(): CoreCgi
  {
    return new CoreCgi($this);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the data layer generated by PhpStratum.
   *
   * @return TestDataLayer
   */
  protected function getDL(): TestDataLayer
  {
    $connector = new MySqlDefaultConnector('localhost', 'test', 'test', 'test');
    $dl        = new TestDataLayer($connector);
    $dl->connect();
    $dl->begin();
    $dl->commit();

    return $dl;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @return LanguageResolver
   */
  protected function getLanguageResolver(): LanguageResolver
  {
    return new CoreLanguageResolver($this, C::LAN_ID_EN);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @return CoreMenu
   */
  protected function getMenu(): CoreMenu
  {
    return new CoreMenu($this);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @return DevelopmentObfuscatorFactory
   */
  protected function getObfuscator(): DevelopmentObfuscatorFactory
  {
    return new DevelopmentObfuscatorFactory();
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @return TestSession
   */
  protected function getSession(): TestSession
  {
    return new TestSession();
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
