<?php
declare(strict_types=1);

namespace Plaisio\Menu\Test;

use SetBased\Stratum\MySql\Exception\MySqlDataLayerException;
use SetBased\Stratum\Middle\Exception\ResultException;
use SetBased\Stratum\MySql\Exception\MySqlQueryErrorException;
use SetBased\Stratum\MySql\MySqlDataLayer;

/**
 * The data layer.
 */
class TestDataLayer extends MySqlDataLayer
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects non-zero if a user has the proper authorization for page. Otherwise, selects 0.
   *
   * @param int|null $pCmpId The ID of the company of the user (safe guard).
   *                         smallint(5) unsigned
   * @param int|null $pUsrId The ID of the user.
   *                         int(10) unsigned
   * @param int|null $pPagId The ID of the page.
   *                         smallint(5) unsigned
   *
   * @return bool
   *
   * @throws MySqlDataLayerException;
   * @throws ResultException;
   */
  public function abcAuthorityCoreUserHasAccessToPage(?int $pCmpId, ?int $pUsrId, ?int $pPagId): bool
  {
    return !empty($this->executeSingleton1('call abc_authority_core_user_has_access_to_page('.$this->quoteInt($pCmpId).','.$this->quoteInt($pUsrId).','.$this->quoteInt($pPagId).')'));
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all language codes as map from language code to language ID.
   *
   * @return array
   *
   * @throws MySqlQueryErrorException;
   */
  public function abcBabelCoreInternalCodeMap(): array
  {
    $result = $this->query('call abc_babel_core_internal_code_map()');
    $ret = [];
    while (($row = $result->fetch_array(MYSQLI_NUM))) $ret[$row[0]] = $row[1];
    $result->free();
    if ($this->mysqli->more_results()) $this->mysqli->next_result();

    return $ret;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the details of a language.
   *
   * @param int|null $pLanId The ID of the language.
   *                         tinyint(3) unsigned
   *
   * @return array
   *
   * @throws MySqlQueryErrorException;
   * @throws ResultException;
   */
  public function abcBabelCoreLanguageGetDetails(?int $pLanId): array
  {
    return $this->executeRow1('call abc_babel_core_language_get_details('.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the value of a text in a language.
   *
   * @param int|null $pTxtId The ID of the text.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the language.
   *                         tinyint(3) unsigned
   *
   * @return string
   *
   * @throws MySqlDataLayerException;
   * @throws ResultException;
   */
  public function abcBabelCoreTextGetText(?int $pTxtId, ?int $pLanId): string
  {
    return $this->executeSingleton1('call abc_babel_core_text_get_text('.$this->quoteInt($pTxtId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the value of a word in a language.
   *
   * @param int|null $pWrdId The ID of the word.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the language.
   *                         tinyint(3) unsigned
   *
   * @return string
   *
   * @throws MySqlDataLayerException;
   * @throws ResultException;
   */
  public function abcBabelCoreWordGetWord(?int $pWrdId, ?int $pLanId): string
  {
    return $this->executeSingleton1('call abc_babel_core_word_get_word('.$this->quoteInt($pWrdId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Deletes cached menu HTML code for a company.
   *
   * @param int|null $pCmpId The ID of the company.
   *                         smallint(5) unsigned
   *
   * @return int
   *
   * @throws MySqlQueryErrorException;
   */
  public function abcMenuCoreCacheFlush(?int $pCmpId): int
  {
    return $this->executeNone('call abc_menu_core_cache_flush('.$this->quoteInt($pCmpId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Deletes cached menu HTML code for a profile
   *
   * @param int|null $pCmpId The ID of the company (safe guard).
   *                         smallint(5) unsigned
   * @param int|null $pProId The ID of the profile.
   *                         smallint(5) unsigned
   *
   * @return int
   *
   * @throws MySqlQueryErrorException;
   */
  public function abcMenuCoreCacheFlushByProId(?int $pCmpId, ?int $pProId): int
  {
    return $this->executeNone('call abc_menu_core_cache_flush_by_pro_id('.$this->quoteInt($pCmpId).','.$this->quoteInt($pProId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the cached (if any) HTML code of a menu.
   *
   * @param int|null $pCmpId The ID of the company (safe guard).
   *                         smallint(5) unsigned
   * @param int|null $pMnuId The ID of the menu.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         tinyint(3) unsigned
   * @param int|null $pProId The ID of the profile.
   *                         smallint(5) unsigned
   *
   * @return array|null
   *
   * @throws MySqlQueryErrorException;
   * @throws ResultException;
   */
  public function abcMenuCoreCacheGet(?int $pCmpId, ?int $pMnuId, ?int $pLanId, ?int $pProId): ?array
  {
    return $this->executeRow0('call abc_menu_core_cache_get('.$this->quoteInt($pCmpId).','.$this->quoteInt($pMnuId).','.$this->quoteInt($pLanId).','.$this->quoteInt($pProId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Caches the HTML code of a menu.
   *
   * @param int|null    $pCmpId   The ID of the company (safe guard).
   *                              smallint(5) unsigned
   * @param int|null    $pMnuId   The ID of the menu.
   *                              smallint(5) unsigned
   * @param int|null    $pLanId   The ID of the language for linguistic entities.
   *                              tinyint(3) unsigned
   * @param int|null    $pProId   The ID of the profile.
   *                              smallint(5) unsigned
   * @param string|null $pMncHtml The HTML code of the menu.
   *                              longtext character set latin1 collation latin1_swedish_ci
   *
   * @return int
   *
   * @throws MySqlDataLayerException;
   * @throws MySqlQueryErrorException;
   * @throws ResultException;
   */
  public function abcMenuCoreCachePut(?int $pCmpId, ?int $pMnuId, ?int $pLanId, ?int $pProId, ?string $pMncHtml)
  {
    $query = 'call abc_menu_core_cache_put('.$this->quoteInt($pCmpId).','.$this->quoteInt($pMnuId).','.$this->quoteInt($pLanId).','.$this->quoteInt($pProId).',?)';
    $stmt  = @$this->mysqli->prepare($query);
    if (!$stmt) throw $this->dataLayerError('mysqli::prepare');

    $null = null;
    $success = @$stmt->bind_param('b', $null);
    if (!$success) throw $this->dataLayerError('mysqli_stmt::bind_param');

    $this->getMaxAllowedPacket();

    $this->sendLongData($stmt, 0, $pMncHtml);

    if ($this->logQueries)
    {
      $time0 = microtime(true);

      $success = @$stmt->execute();
      if (!$success) throw $this->queryError('mysqli_stmt::execute', $query);

      $this->queryLog[] = ['query' => $query,
                           'time'  => microtime(true) - $time0];
    }
    else
    {
      $success = $stmt->execute();
      if (!$success) throw $this->queryError('mysqli_stmt::execute', $query);
    }

    $ret = $this->mysqli->affected_rows;

    $stmt->close();
    if ($this->mysqli->more_results()) $this->mysqli->next_result();

    return $ret;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the ID of the menu item given the ID of the menu and page.
   *
   * @param int|null $pMnuId The ID of the menu.
   *                         smallint(5) unsigned
   * @param int|null $pPagId The ID of the page.
   *                         smallint(5) unsigned
   *
   * @return int|null
   *
   * @throws MySqlDataLayerException;
   * @throws ResultException;
   */
  public function abcMenuCoreLinkGetItemByPage(?int $pMnuId, ?int $pPagId): ?int
  {
    return $this->executeSingleton0('call abc_menu_core_link_get_item_by_page('.$this->quoteInt($pMnuId).','.$this->quoteInt($pPagId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects details of a menu.
   *
   * @param int|null $pMnuId The ID of the menu.
   *                         smallint(5) unsigned
   *
   * @return array
   *
   * @throws MySqlQueryErrorException;
   * @throws ResultException;
   */
  public function abcMenuCoreMenuGetDetails(?int $pMnuId): array
  {
    return $this->executeRow1('call abc_menu_core_menu_get_details('.$this->quoteInt($pMnuId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects items of a menu.
   *
   * @param int|null $pMnuId The ID of the menu.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException;
   */
  public function abcMenuCoreMenuGetItems(?int $pMnuId, ?int $pLanId): array
  {
    return $this->executeRows('call abc_menu_core_menu_get_items('.$this->quoteInt($pMnuId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
