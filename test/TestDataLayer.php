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
   * Selects the value of a configuration parameter of a company.
   *
   * @param int|null $pCmpId The ID of the company.
   *                         smallint(5) unsigned
   * @param int|null $pCfgId The ID of the configuration parameter.
   *                         smallint(5) unsigned
   *
   * @return string|null
   *
   * @throws MySqlDataLayerException
   * @throws ResultException
   */
  public function abcAuthGetConfigValue(?int $pCmpId, ?int $pCfgId): ?string
  {
    return $this->executeSingleton0('call abc_auth_get_config_value('.$this->quoteInt($pCmpId).','.$this->quoteInt($pCfgId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects non-zero if a user has the proper authorization for page. Otherwise, selects 0.
   *
   * @param int|null $pCmpId The ID of the company of the user (safeguard).
   *                         smallint(5) unsigned
   * @param int|null $pProId The ID of the profile of the user.
   *                         smallint(5) unsigned
   * @param int|null $pPagId The ID of the page.
   *                         smallint(5) unsigned
   *
   * @return bool
   *
   * @throws MySqlDataLayerException
   * @throws ResultException
   */
  public function abcAuthGetPageAuth(?int $pCmpId, ?int $pProId, ?int $pPagId): bool
  {
    return !empty($this->executeSingleton1('call abc_auth_get_page_auth('.$this->quoteInt($pCmpId).','.$this->quoteInt($pProId).','.$this->quoteInt($pPagId).')'));
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects info about a page for a user.
   *
   * @param int|null    $pCmpId    The ID of the company of the user (safeguard).
   *                               smallint(5) unsigned
   * @param int|null    $pPagId    The ID of the page.
   *                               smallint(5) unsigned
   * @param int|null    $pProId    The ID of the profile of the user.
   *                               smallint(5) unsigned
   * @param int|null    $pLanId    The ID of the language for linguistic entities.
   *                               tinyint(3) unsigned
   * @param string|null $pPagAlias The alias for the request page.
   *                               varchar(65532) character set latin1 collation latin1_swedish_ci
   *
   * @return array|null
   *
   * @throws MySqlQueryErrorException
   * @throws ResultException
   */
  public function abcAuthGetPageInfo(?int $pCmpId, ?int $pPagId, ?int $pProId, ?int $pLanId, ?string $pPagAlias): ?array
  {
    return $this->executeRow0('call abc_auth_get_page_info('.$this->quoteInt($pCmpId).','.$this->quoteInt($pPagId).','.$this->quoteInt($pProId).','.$this->quoteInt($pLanId).','.$this->quoteString($pPagAlias).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the page tabs for a user.
   *
   * @param int|null $pCmpId The ID of the company of the user (safeguard).
   *                         smallint(5) unsigned
   * @param int|null $pPtbId The ID of the page tab.
   *                         tinyint(3) unsigned
   * @param int|null $pProId The ID of the profile of the user.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcAuthGetPageTabs(?int $pCmpId, ?int $pPtbId, ?int $pProId, ?int $pLanId): array
  {
    $result = $this->query('call abc_auth_get_page_tabs('.$this->quoteInt($pCmpId).','.$this->quoteInt($pPtbId).','.$this->quoteInt($pProId).','.$this->quoteInt($pLanId).')');
    $ret = [];
    while (($row = $result->fetch_array(MYSQLI_ASSOC))) $ret[$row['pag_id']] = $row;
    $result->free();
    if ($this->mysqli->more_results()) $this->mysqli->next_result();

    return $ret;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects whether a user has the proper authorization for page.
   *
   * @param int|null $pCmpId The ID of the company of the user (safeguard).
   *                         smallint(5) unsigned
   * @param int|null $pUsrId The ID of the user.
   *                         int(10) unsigned
   * @param int|null $pPagId The ID of the page.
   *                         smallint(5) unsigned
   *
   * @return bool
   *
   * @throws MySqlDataLayerException
   * @throws ResultException
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
   * @throws MySqlQueryErrorException
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
   * @throws MySqlQueryErrorException
   * @throws ResultException
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
   * @throws MySqlDataLayerException
   * @throws ResultException
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
   * @throws MySqlDataLayerException
   * @throws ResultException
   */
  public function abcBabelCoreWordGetWord(?int $pWrdId, ?int $pLanId): string
  {
    return $this->executeSingleton1('call abc_babel_core_word_get_word('.$this->quoteInt($pWrdId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all languages.
   *
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcBabelLanguageGetAllLanguages(?int $pLanId): array
  {
    return $this->executeRows('call abc_babel_language_get_all_languages('.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the name of a language.
   *
   * @param int|null $pLanIdTar The ID of the language of which the name is selected.
   *                            tinyint(3) unsigned
   * @param int|null $pLanId    The ID of the language for linguistic entities.
   *                            tinyint(3) unsigned
   *
   * @return string|null
   *
   * @throws MySqlDataLayerException
   * @throws ResultException
   */
  public function abcBabelLanguageGetName(?int $pLanIdTar, ?int $pLanId): ?string
  {
    return $this->executeSingleton0('call abc_babel_language_get_name('.$this->quoteInt($pLanIdTar).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Deletes a text.
   *
   * @param int|null $pTxtId The ID of the text to be deleted.
   *                         smallint(5) unsigned
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcBabelTextDeleteText(?int $pTxtId): int
  {
    return $this->executeNone('call abc_babel_text_delete_text('.$this->quoteInt($pTxtId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the details of a text.
   *
   * @param int|null $pTxtId The ID of the text.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the reference language.
   *                         tinyint(3) unsigned
   *
   * @return array
   *
   * @throws MySqlQueryErrorException
   * @throws ResultException
   */
  public function abcBabelTextGetDetails(?int $pTxtId, ?int $pLanId): array
  {
    return $this->executeRow1('call abc_babel_text_get_details('.$this->quoteInt($pTxtId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all text groups.
   *
   * @param int|null $pLanId The ID of the target language.
   *                         tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcBabelTextGroupGetAll(?int $pLanId): array
  {
    return $this->executeRows('call abc_babel_text_group_get_all('.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all texts in a text group in alphabetical order.
   *
   * @param int|null $pTtgId The ID of the text group.
   *                         tinyint(3) unsigned
   * @param int|null $pLanId The ID of the target language.
   *                         tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcBabelTextGroupGetAllTexts(?int $pTtgId, ?int $pLanId): array
  {
    return $this->executeRows('call abc_babel_text_group_get_all_texts('.$this->quoteInt($pTtgId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all text in a text group in the reference and target language.
   *
   * @param int|null $pTtgId    The ID of the text group.
   *                            tinyint(3) unsigned
   * @param int|null $pLanIdTar The ID of the target language.
   *                            tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcBabelTextGroupGetAllTextsTranslator(?int $pTtgId, ?int $pLanIdTar): array
  {
    return $this->executeRows('call abc_babel_text_group_get_all_texts_translator('.$this->quoteInt($pTtgId).','.$this->quoteInt($pLanIdTar).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the details of a text group.
   *
   * @param int|null $pTtgId The ID of the text group.
   *                         tinyint(3) unsigned
   *
   * @return array
   *
   * @throws MySqlQueryErrorException
   * @throws ResultException
   */
  public function abcBabelTextGroupGetDetails(?int $pTtgId): array
  {
    return $this->executeRow1('call abc_babel_text_group_get_details('.$this->quoteInt($pTtgId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Inserts a text group.
   *
   * @param string|null $pTtgName  The name of the text group.
   *                               varchar(64) character set latin1 collation latin1_swedish_ci
   * @param string|null $pTtgLabel The label of the text group.
   *                               varchar(30) character set ascii collation ascii_general_ci
   *
   * @return int
   *
   * @throws MySqlDataLayerException
   * @throws ResultException
   */
  public function abcBabelTextGroupInsertDetails(?string $pTtgName, ?string $pTtgLabel): int
  {
    return $this->executeSingleton1('call abc_babel_text_group_insert_details('.$this->quoteString($pTtgName).','.$this->quoteString($pTtgLabel).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Updates the details of a text group.
   *
   * @param int|null    $pTtgId    The ID of the text group.
   *                               tinyint(3) unsigned
   * @param string|null $pTtgName  The new name of the text group.
   *                               varchar(64) character set latin1 collation latin1_swedish_ci
   * @param string|null $pTtgLabel The new label of the text group.
   *                               varchar(30) character set ascii collation ascii_general_ci
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcBabelTextGroupUpdateDetails(?int $pTtgId, ?string $pTtgName, ?string $pTtgLabel): int
  {
    return $this->executeNone('call abc_babel_text_group_update_details('.$this->quoteInt($pTtgId).','.$this->quoteString($pTtgName).','.$this->quoteString($pTtgLabel).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Inserts a text.
   *
   * @param int|null    $pTtgId      The ID of the text group of the new word.
   *                                 tinyint(3) unsigned
   * @param string|null $pTxtLabel   The label of the new text.
   *                                 varchar(50) character set ascii collation ascii_general_ci
   * @param string|null $pTxtComment The comment on the new text.
   *                                 tinytext character set latin1 collation latin1_swedish_ci
   * @param string|null $pTttText    The value of the new text.
   *                                 mediumtext character set latin1 collation latin1_swedish_ci
   *
   * @return int
   *
   * @throws MySqlDataLayerException
   * @throws MySqlQueryErrorException
   * @throws ResultException
   */
  public function abcBabelTextInsertText(?int $pTtgId, ?string $pTxtLabel, ?string $pTxtComment, ?string $pTttText): int
  {
    $query = 'call abc_babel_text_insert_text('.$this->quoteInt($pTtgId).','.$this->quoteString($pTxtLabel).',?,?)';
    $stmt  = @$this->mysqli->prepare($query);
    if (!$stmt) throw $this->dataLayerError('mysqli::prepare');

    $null = null;
    $success = @$stmt->bind_param('bb', $null, $null);
    if (!$success) throw $this->dataLayerError('mysqli_stmt::bind_param');

    $this->getMaxAllowedPacket();

    $this->sendLongData($stmt, 0, $pTxtComment);
    $this->sendLongData($stmt, 1, $pTttText);

    if ($this->logQueries)
    {
      $time0 = microtime(true);
    }

    try
    {
      $success = @$stmt->execute();
    }
    catch (\mysqli_sql_exception)
    {
      $success = false;
    }
    if (!$success)
    {
      throw $this->queryError('mysqli_stmt::execute', $query);
    }

    if ($this->logQueries)
    {
      $this->queryLog[] = ['query' => $query,
                           'time'  => microtime(true) - $time0];
    }

    $row = [];
    $this->bindAssoc($stmt, $row);

    $tmp = [];
    while (($b = $stmt->fetch()))
    {
      $new = [];
      foreach($row as $value)
      {
        $new[] = $value;
      }
      $tmp[] = $new;
    }

    $stmt->close();
    if ($this->mysqli->more_results()) $this->mysqli->next_result();

    if ($b===false) throw $this->dataLayerError('mysqli_stmt::fetch');
    if (sizeof($tmp)!=1) throw new ResultException([1], sizeof($tmp), $query);

    return $tmp[0][0];
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Translates a text.
   *
   * @param int|null    $pTxtId   The ID of text that has been translated.
   *                              smallint(5) unsigned
   * @param int|null    $pLanId   The ID of the language in which the text has been translated.
   *                              tinyint(3) unsigned
   * @param string|null $pTttText The translated text.
   *                              mediumtext character set latin1 collation latin1_swedish_ci
   *
   * @return int
   *
   * @throws MySqlDataLayerException
   * @throws MySqlQueryErrorException
   * @throws ResultException
   */
  public function abcBabelTextTranslateText(?int $pTxtId, ?int $pLanId, ?string $pTttText): int
  {
    $query = 'call abc_babel_text_translate_text('.$this->quoteInt($pTxtId).','.$this->quoteInt($pLanId).',?)';
    $stmt  = @$this->mysqli->prepare($query);
    if (!$stmt) throw $this->dataLayerError('mysqli::prepare');

    $null = null;
    $success = @$stmt->bind_param('b', $null);
    if (!$success) throw $this->dataLayerError('mysqli_stmt::bind_param');

    $this->getMaxAllowedPacket();

    $this->sendLongData($stmt, 0, $pTttText);

    if ($this->logQueries)
    {
      $time0 = microtime(true);
    }

    try
    {
      $success = @$stmt->execute();
    }
    catch (\mysqli_sql_exception)
    {
      $success = false;
    }
    if (!$success)
    {
      throw $this->queryError('mysqli_stmt::execute', $query);
    }

    if ($this->logQueries)
    {
      $this->queryLog[] = ['query' => $query,
                           'time'  => microtime(true) - $time0];
    }

    $ret = $this->mysqli->affected_rows;

    $stmt->close();
    if ($this->mysqli->more_results()) $this->mysqli->next_result();

    return $ret;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Updates the details of a text.
   *
   * @param int|null    $pTxtId      The ID of the text.
   *                                 smallint(5) unsigned
   * @param int|null    $pTtgId      The ID of the new text group of the text.
   *                                 tinyint(3) unsigned
   * @param string|null $pTxtLabel   The new label of the text.
   *                                 varchar(50) character set ascii collation ascii_general_ci
   * @param string|null $pTxtComment The new comment of the text.
   *                                 tinytext character set latin1 collation latin1_swedish_ci
   * @param string|null $pTttText    The new value of the text.
   *                                 mediumtext character set latin1 collation latin1_swedish_ci
   *
   * @return int
   *
   * @throws MySqlDataLayerException
   * @throws MySqlQueryErrorException
   * @throws ResultException
   */
  public function abcBabelTextUpdateDetails(?int $pTxtId, ?int $pTtgId, ?string $pTxtLabel, ?string $pTxtComment, ?string $pTttText): int
  {
    $query = 'call abc_babel_text_update_details('.$this->quoteInt($pTxtId).','.$this->quoteInt($pTtgId).','.$this->quoteString($pTxtLabel).',?,?)';
    $stmt  = @$this->mysqli->prepare($query);
    if (!$stmt) throw $this->dataLayerError('mysqli::prepare');

    $null = null;
    $success = @$stmt->bind_param('bb', $null, $null);
    if (!$success) throw $this->dataLayerError('mysqli_stmt::bind_param');

    $this->getMaxAllowedPacket();

    $this->sendLongData($stmt, 0, $pTxtComment);
    $this->sendLongData($stmt, 1, $pTttText);

    if ($this->logQueries)
    {
      $time0 = microtime(true);
    }

    try
    {
      $success = @$stmt->execute();
    }
    catch (\mysqli_sql_exception)
    {
      $success = false;
    }
    if (!$success)
    {
      throw $this->queryError('mysqli_stmt::execute', $query);
    }

    if ($this->logQueries)
    {
      $this->queryLog[] = ['query' => $query,
                           'time'  => microtime(true) - $time0];
    }

    $ret = $this->mysqli->affected_rows;

    $stmt->close();
    if ($this->mysqli->more_results()) $this->mysqli->next_result();

    return $ret;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Deletes a word.
   *
   * @param int|null $pWrdId The ID of the word to be deleted.
   *                         smallint(5) unsigned
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcBabelWordDeleteWord(?int $pWrdId): int
  {
    return $this->executeNone('call abc_babel_word_delete_word('.$this->quoteInt($pWrdId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the details of a word.
   *
   * @param int|null $pWrdId The ID of the word.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the reference language.
   *                         tinyint(3) unsigned
   *
   * @return array
   *
   * @throws MySqlQueryErrorException
   * @throws ResultException
   */
  public function abcBabelWordGetDetails(?int $pWrdId, ?int $pLanId): array
  {
    return $this->executeRow1('call abc_babel_word_get_details('.$this->quoteInt($pWrdId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all word groups.
   *
   * @param int|null $pLanId The ID of the target language.
   *                         tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcBabelWordGroupGetAll(?int $pLanId): array
  {
    return $this->executeRows('call abc_babel_word_group_get_all('.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all words in a word group in alphabetical order.
   *
   * @param int|null $pWgdId The ID of the word group.
   *                         tinyint(3) unsigned
   * @param int|null $pLanId The ID of the target language.
   *                         tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcBabelWordGroupGetAllWords(?int $pWgdId, ?int $pLanId): array
  {
    return $this->executeRows('call abc_babel_word_group_get_all_words('.$this->quoteInt($pWgdId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all words in a word group in the reference and target language.
   *
   * @param int|null $pWgdId    The ID of the word group.
   *                            tinyint(3) unsigned
   * @param int|null $pLanIdTar The ID of the target language.
   *                            tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcBabelWordGroupGetAllWordsTranslator(?int $pWgdId, ?int $pLanIdTar): array
  {
    return $this->executeRows('call abc_babel_word_group_get_all_words_translator('.$this->quoteInt($pWgdId).','.$this->quoteInt($pLanIdTar).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the details of a word group.
   *
   * @param int|null $pWdgId The ID of the word group.
   *                         tinyint(3) unsigned
   *
   * @return array
   *
   * @throws MySqlQueryErrorException
   * @throws ResultException
   */
  public function abcBabelWordGroupGetDetails(?int $pWdgId): array
  {
    return $this->executeRow1('call abc_babel_word_group_get_details('.$this->quoteInt($pWdgId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Inserts a word group.
   *
   * @param string|null $pWdgName  The name of the word group.
   *                               varchar(32) character set latin1 collation latin1_swedish_ci
   * @param string|null $pWdgLabel The label of the word group.
   *                               varchar(30) character set ascii collation ascii_general_ci
   *
   * @return int
   *
   * @throws MySqlDataLayerException
   * @throws ResultException
   */
  public function abcBabelWordGroupInsertDetails(?string $pWdgName, ?string $pWdgLabel): int
  {
    return $this->executeSingleton1('call abc_babel_word_group_insert_details('.$this->quoteString($pWdgName).','.$this->quoteString($pWdgLabel).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Updates the details of a word group.
   *
   * @param int|null    $pWdgId    The ID of the word group.
   *                               tinyint(3) unsigned
   * @param string|null $pWdgName  The new name of the word group.
   *                               varchar(32) character set latin1 collation latin1_swedish_ci
   * @param string|null $pWdgLabel The new label of the word group.
   *                               varchar(30) character set ascii collation ascii_general_ci
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcBabelWordGroupUpdateDetails(?int $pWdgId, ?string $pWdgName, ?string $pWdgLabel): int
  {
    return $this->executeNone('call abc_babel_word_group_update_details('.$this->quoteInt($pWdgId).','.$this->quoteString($pWdgName).','.$this->quoteString($pWdgLabel).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Inserts a word.
   *
   * @param int|null    $pWdgId      The ID of the word group of the new word.
   *                                 tinyint(3) unsigned
   * @param string|null $pWrdLabel   The label of the new word.
   *                                 varchar(50) character set ascii collation ascii_general_ci
   * @param string|null $pWrdComment The comment on the new word.
   *                                 varchar(255) character set latin1 collation latin1_swedish_ci
   * @param string|null $pWdtText    The value of the new word.
   *                                 varchar(80) character set latin1 collation latin1_swedish_ci
   *
   * @return int
   *
   * @throws MySqlDataLayerException
   * @throws ResultException
   */
  public function abcBabelWordInsertWord(?int $pWdgId, ?string $pWrdLabel, ?string $pWrdComment, ?string $pWdtText): int
  {
    return $this->executeSingleton1('call abc_babel_word_insert_word('.$this->quoteInt($pWdgId).','.$this->quoteString($pWrdLabel).','.$this->quoteString($pWrdComment).','.$this->quoteString($pWdtText).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Translates a word.
   *
   * @param int|null    $pUsrId   The ID of the user that has translated the word.
   *                              int(10) unsigned
   * @param int|null    $pWrdId   The ID of word that has been translated.
   *                              smallint(5) unsigned
   * @param int|null    $pLanId   The ID of the language in which the word has been translated.
   *                              tinyint(3) unsigned
   * @param string|null $pWdtText The translated word.
   *                              varchar(80) character set latin1 collation latin1_swedish_ci
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcBabelWordTranslateWord(?int $pUsrId, ?int $pWrdId, ?int $pLanId, ?string $pWdtText): int
  {
    return $this->executeNone('call abc_babel_word_translate_word('.$this->quoteInt($pUsrId).','.$this->quoteInt($pWrdId).','.$this->quoteInt($pLanId).','.$this->quoteString($pWdtText).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Updates the details of a word.
   *
   * @param int|null    $pWrdId      The ID of the word.
   *                                 smallint(5) unsigned
   * @param int|null    $pWdgId      The ID of the new word group of the word.
   *                                 tinyint(3) unsigned
   * @param string|null $pWrdLabel   The new label of the word.
   *                                 varchar(50) character set ascii collation ascii_general_ci
   * @param string|null $pWrdComment The new comment of the word.
   *                                 varchar(255) character set latin1 collation latin1_swedish_ci
   * @param string|null $pWdtText    The new value of the word.
   *                                 varchar(80) character set latin1 collation latin1_swedish_ci
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcBabelWordUpdateDetails(?int $pWrdId, ?int $pWdgId, ?string $pWrdLabel, ?string $pWrdComment, ?string $pWdtText): int
  {
    return $this->executeNone('call abc_babel_word_update_details('.$this->quoteInt($pWrdId).','.$this->quoteInt($pWdgId).','.$this->quoteString($pWrdLabel).','.$this->quoteString($pWrdComment).','.$this->quoteString($pWdtText).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Insets or updates the value of a configuration parameter of a company.
   *
   * @param int|null    $pCmpId    The ID of the company.
   *                               smallint(5) unsigned
   * @param int|null    $pCfgId    The ID of the configuration parameter.
   *                               smallint(5) unsigned
   * @param string|null $pCfgValue The value of the configuration parameter.
   *                               varchar(4000) character set latin1 collation latin1_swedish_ci
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcCompanyConfigUpdateValue(?int $pCmpId, ?int $pCfgId, ?string $pCfgValue): int
  {
    return $this->executeNone('call abc_company_config_update_value('.$this->quoteInt($pCmpId).','.$this->quoteInt($pCfgId).','.$this->quoteString($pCfgValue).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all functionalities of all granted modules to a company.
   *
   * @param int|null $pCmpId The ID of the company.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         smallint(5) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcCompanyFunctionalitiesGetAllEnabled(?int $pCmpId, ?int $pLanId): array
  {
    return $this->executeRows('call abc_company_functionalities_get_all_enabled('.$this->quoteInt($pCmpId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all companies.
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcCompanyGetAll(): array
  {
    return $this->executeRows('call abc_company_get_all()');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the company ID given a company abbreviation.
   *
   * @param string|null $pCmpAbbr The company abbreviation.
   *                              varchar(65532) character set latin1 collation latin1_swedish_ci
   *
   * @return int|null
   *
   * @throws MySqlDataLayerException
   * @throws ResultException
   */
  public function abcCompanyGetCmpIdByCmpAbbr(?string $pCmpAbbr): ?int
  {
    return $this->executeSingleton0('call abc_company_get_cmp_id_by_cmp_abbr('.$this->quoteString($pCmpAbbr).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the details of a company.
   *
   * @param int|null $pCmpId The ID of the company.
   *                         smallint(5) unsigned
   *
   * @return array
   *
   * @throws MySqlQueryErrorException
   * @throws ResultException
   */
  public function abcCompanyGetDetails(?int $pCmpId): array
  {
    return $this->executeRow1('call abc_company_get_details('.$this->quoteInt($pCmpId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Inserts a new company.
   *
   * @param string|null $pCmpAbbr  The abbreviation of the new company.
   *                               varchar(15) character set latin1 collation latin1_swedish_ci
   * @param string|null $pCmpLabel The label of the new company.
   *                               varchar(20) character set ascii collation ascii_general_ci
   *
   * @return int
   *
   * @throws MySqlDataLayerException
   * @throws ResultException
   */
  public function abcCompanyInsert(?string $pCmpAbbr, ?string $pCmpLabel): int
  {
    return $this->executeSingleton1('call abc_company_insert('.$this->quoteString($pCmpAbbr).','.$this->quoteString($pCmpLabel).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Disables a module for a company.
   *
   * @param int|null $pCmpId The ID of the company.
   *                         smallint(5) unsigned
   * @param int|null $pMdlId The ID of the module to be disabled.
   *                         smallint(5) unsigned
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcCompanyModuleDisable(?int $pCmpId, ?int $pMdlId): int
  {
    return $this->executeNone('call abc_company_module_disable('.$this->quoteInt($pCmpId).','.$this->quoteInt($pMdlId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Enables a module for a company.
   *
   * @param int|null $pCmpId The ID of the company.
   *                         smallint(5) unsigned
   * @param int|null $pMdlId The ID of module to be enabled.
   *                         smallint(5) unsigned
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcCompanyModuleEnable(?int $pCmpId, ?int $pMdlId): int
  {
    return $this->executeNone('call abc_company_module_enable('.$this->quoteInt($pCmpId).','.$this->quoteInt($pMdlId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all modules including a flag indication the module is granted to the company.
   *
   * @param int|null $pCmpId The ID of the company.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         smallint(5) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcCompanyModuleGetAllAvailable(?int $pCmpId, ?int $pLanId): array
  {
    return $this->executeRows('call abc_company_module_get_all_available('.$this->quoteInt($pCmpId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all granted modules granted to a company.
   *
   * @param int|null $pCmpId The ID of the company.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         smallint(5) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcCompanyModuleGetAllEnabled(?int $pCmpId, ?int $pLanId): array
  {
    return $this->executeRows('call abc_company_module_get_all_enabled('.$this->quoteInt($pCmpId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Revokes a granted functionality from a role.
   *
   * @param int|null $pCmpId The ID of the company.
   *                         smallint(5) unsigned
   * @param int|null $pRolId The ID of the role.
   *                         smallint(5) unsigned
   * @param int|null $pFunId The ID of functionality revoked.
   *                         smallint(5) unsigned
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcCompanyRoleDeleteFunctionality(?int $pCmpId, ?int $pRolId, ?int $pFunId): int
  {
    return $this->executeNone('call abc_company_role_delete_functionality('.$this->quoteInt($pCmpId).','.$this->quoteInt($pRolId).','.$this->quoteInt($pFunId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all roles of a company.
   *
   * @param int|null $pCmpId The ID of the company.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcCompanyRoleGetAll(?int $pCmpId, ?int $pLanId): array
  {
    return $this->executeRows('call abc_company_role_get_all('.$this->quoteInt($pCmpId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all functionalities of all modules granted to a company including a flag indication the functionality
   * is granted to a role.
   *
   * @param int|null $pCmpId The ID of the company.
   *                         smallint(5) unsigned
   * @param int|null $pRolId The ID of the role.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcCompanyRoleGetAvailableFunctionalities(?int $pCmpId, ?int $pRolId, ?int $pLanId): array
  {
    return $this->executeRows('call abc_company_role_get_available_functionalities('.$this->quoteInt($pCmpId).','.$this->quoteInt($pRolId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the details of a role.
   *
   * @param int|null $pCmpId The ID of the company (safeguard).
   *                         smallint(5) unsigned
   * @param int|null $pRolId The ID of the role.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the language use for linguistic entities.
   *                         tinyint(3) unsigned
   *
   * @return array
   *
   * @throws MySqlQueryErrorException
   * @throws ResultException
   */
  public function abcCompanyRoleGetDetails(?int $pCmpId, ?int $pRolId, ?int $pLanId): array
  {
    return $this->executeRow1('call abc_company_role_get_details('.$this->quoteInt($pCmpId).','.$this->quoteInt($pRolId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all the roles that are granted a functionality.
   *
   * @param int|null $pCmpId The ID of the company (safeguard).
   *                         smallint(5) unsigned
   * @param int|null $pRolId The ID of the role.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcCompanyRoleGetFunctionalities(?int $pCmpId, ?int $pRolId, ?int $pLanId): array
  {
    return $this->executeRows('call abc_company_role_get_functionalities('.$this->quoteInt($pCmpId).','.$this->quoteInt($pRolId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the pages to which a role grants access to.
   *
   * @param int|null $pCmpId The ID of the company (safeguard).
   *                         smallint(5) unsigned
   * @param int|null $pRolId The ID of the role.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcCompanyRoleGetPages(?int $pCmpId, ?int $pRolId, ?int $pLanId): array
  {
    return $this->executeRows('call abc_company_role_get_pages('.$this->quoteInt($pCmpId).','.$this->quoteInt($pRolId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all roles in a role group of a company.
   *
   * @param int|null $pCmpId The ID of the company (safeguard).
   *                         smallint(5) unsigned
   * @param int|null $pRlgId The ID of the role group.
   *                         smallint(5) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcCompanyRoleGroupGetAllRoles(?int $pCmpId, ?int $pRlgId): array
  {
    return $this->executeRows('call abc_company_role_group_get_all_roles('.$this->quoteInt($pCmpId).','.$this->quoteInt($pRlgId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Insert a new role.
   *
   * @param int|null    $pCmpId     The company ID.
   *                                smallint(5) unsigned
   * @param int|null    $pRlgId     The rol ID of the role group.
   *                                smallint(5) unsigned
   * @param string|null $pRolName   The name of the role.
   *                                varchar(32) character set latin1 collation latin1_swedish_ci
   * @param int|null    $pRolWeight The weight of the role.
   *                                smallint(6)
   * @param string|null $pRolLabel  The label of the role.
   *                                varchar(50) character set ascii collation ascii_general_ci
   *
   * @return int
   *
   * @throws MySqlDataLayerException
   * @throws ResultException
   */
  public function abcCompanyRoleInsert(?int $pCmpId, ?int $pRlgId, ?string $pRolName, ?int $pRolWeight, ?string $pRolLabel): int
  {
    return $this->executeSingleton1('call abc_company_role_insert('.$this->quoteInt($pCmpId).','.$this->quoteInt($pRlgId).','.$this->quoteString($pRolName).','.$this->quoteInt($pRolWeight).','.$this->quoteString($pRolLabel).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Grants a functionality ro a role.
   *
   * @param int|null $pCmpId The ID of the company.
   *                         smallint(5) unsigned
   * @param int|null $pRolId The ID of the role.
   *                         smallint(5) unsigned
   * @param int|null $pFunId The ID of functionality granted.
   *                         smallint(5) unsigned
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcCompanyRoleInsertFunctionality(?int $pCmpId, ?int $pRolId, ?int $pFunId): int
  {
    return $this->executeNone('call abc_company_role_insert_functionality('.$this->quoteInt($pCmpId).','.$this->quoteInt($pRolId).','.$this->quoteInt($pFunId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Updates the details of a role.
   *
   * @param int|null    $pCmpId     The company ID (safeguard).
   *                                smallint(5) unsigned
   * @param int|null    $pRolId     The ID of the role to be updated.
   *                                smallint(5) unsigned
   * @param int|null    $pRlgId     The ID of the role group.
   *                                smallint(5) unsigned
   * @param string|null $pRolName   The name of the role.
   *                                varchar(32) character set latin1 collation latin1_swedish_ci
   * @param int|null    $pRolWeight The weight of the role.
   *                                smallint(6)
   * @param string|null $pRolLabel  The label of the role.
   *                                varchar(50) character set ascii collation ascii_general_ci
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcCompanyRoleUpdate(?int $pCmpId, ?int $pRolId, ?int $pRlgId, ?string $pRolName, ?int $pRolWeight, ?string $pRolLabel): int
  {
    return $this->executeNone('call abc_company_role_update('.$this->quoteInt($pCmpId).','.$this->quoteInt($pRolId).','.$this->quoteInt($pRlgId).','.$this->quoteString($pRolName).','.$this->quoteInt($pRolWeight).','.$this->quoteString($pRolLabel).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Deletes a company specific page.
   *
   * @param int|null $pCmpId The ID of the company.
   *                         smallint(5) unsigned
   * @param int|null $pPagId The ID of the page that must be deleted.
   *                         smallint(5) unsigned
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcCompanySpecificPageDelete(?int $pCmpId, ?int $pPagId): int
  {
    return $this->executeNone('call abc_company_specific_page_delete('.$this->quoteInt($pCmpId).','.$this->quoteInt($pPagId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all company specific pages.
   *
   * @param int|null $pCmpId The ID of the company.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         smallint(5) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcCompanySpecificPageGetAll(?int $pCmpId, ?int $pLanId): array
  {
    return $this->executeRows('call abc_company_specific_page_get_all('.$this->quoteInt($pCmpId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects details of a company specific page.
   *
   * @param int|null $pCmpId The ID of the company.
   *                         smallint(5) unsigned
   * @param int|null $pPagId The ID of the page that must be deleted.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         smallint(5) unsigned
   *
   * @return array
   *
   * @throws MySqlQueryErrorException
   * @throws ResultException
   */
  public function abcCompanySpecificPageGetDetails(?int $pCmpId, ?int $pPagId, ?int $pLanId): array
  {
    return $this->executeRow1('call abc_company_specific_page_get_details('.$this->quoteInt($pCmpId).','.$this->quoteInt($pPagId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Inserts a company specific page.
   *
   * @param int|null    $pCmpId    The ID of the company.
   *                               smallint(5) unsigned
   * @param int|null    $pPagId    The ID of the page must be overridden with a company specific page.
   *                               smallint(5) unsigned
   * @param string|null $pPagClass The class of the company specific page.
   *                               varchar(128) character set latin1 collation latin1_swedish_ci
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcCompanySpecificPageInsert(?int $pCmpId, ?int $pPagId, ?string $pPagClass): int
  {
    return $this->executeNone('call abc_company_specific_page_insert('.$this->quoteInt($pCmpId).','.$this->quoteInt($pPagId).','.$this->quoteString($pPagClass).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Updates a company specific page.
   *
   * @param int|null    $pCmpId    The ID of the company.
   *                               smallint(5) unsigned
   * @param int|null    $pPagId    The ID of the page must be overridden with a company specific page.
   *                               smallint(5) unsigned
   * @param string|null $pPagClass The class of the company specific page.
   *                               varchar(128) character set latin1 collation latin1_swedish_ci
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcCompanySpecificPageUpdate(?int $pCmpId, ?int $pPagId, ?string $pPagClass): int
  {
    return $this->executeNone('call abc_company_specific_page_update('.$this->quoteInt($pCmpId).','.$this->quoteInt($pPagId).','.$this->quoteString($pPagClass).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Updates the details of a company.
   *
   * @param int|null    $pCmpId    The ID of the company.
   *                               smallint(5) unsigned
   * @param string|null $pCmpAbbr  The abbreviation of the company.
   *                               varchar(15) character set latin1 collation latin1_swedish_ci
   * @param string|null $pCmpLabel The label of the company.
   *                               varchar(20) character set ascii collation ascii_general_ci
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcCompanyUpdate(?int $pCmpId, ?string $pCmpAbbr, ?string $pCmpLabel): int
  {
    return $this->executeNone('call abc_company_update('.$this->quoteInt($pCmpId).','.$this->quoteString($pCmpAbbr).','.$this->quoteString($pCmpLabel).')');
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
   * @throws MySqlQueryErrorException
   */
  public function abcMenuCoreCacheFlush(?int $pCmpId): int
  {
    return $this->executeNone('call abc_menu_core_cache_flush('.$this->quoteInt($pCmpId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Deletes cached menu HTML code for a profile
   *
   * @param int|null $pCmpId The ID of the company (safeguard).
   *                         smallint(5) unsigned
   * @param int|null $pProId The ID of the profile.
   *                         smallint(5) unsigned
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcMenuCoreCacheFlushByProId(?int $pCmpId, ?int $pProId): int
  {
    return $this->executeNone('call abc_menu_core_cache_flush_by_pro_id('.$this->quoteInt($pCmpId).','.$this->quoteInt($pProId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the cached (if any) HTML code of a menu.
   *
   * @param int|null $pCmpId The ID of the company (safeguard).
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
   * @throws MySqlQueryErrorException
   * @throws ResultException
   */
  public function abcMenuCoreCacheGet(?int $pCmpId, ?int $pMnuId, ?int $pLanId, ?int $pProId): ?array
  {
    return $this->executeRow0('call abc_menu_core_cache_get('.$this->quoteInt($pCmpId).','.$this->quoteInt($pMnuId).','.$this->quoteInt($pLanId).','.$this->quoteInt($pProId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Caches the HTML code of a menu.
   *
   * @param int|null    $pCmpId   The ID of the company (safeguard).
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
   * @throws MySqlDataLayerException
   * @throws MySqlQueryErrorException
   * @throws ResultException
   */
  public function abcMenuCoreCachePut(?int $pCmpId, ?int $pMnuId, ?int $pLanId, ?int $pProId, ?string $pMncHtml): int
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
    }

    try
    {
      $success = @$stmt->execute();
    }
    catch (\mysqli_sql_exception)
    {
      $success = false;
    }
    if (!$success)
    {
      throw $this->queryError('mysqli_stmt::execute', $query);
    }

    if ($this->logQueries)
    {
      $this->queryLog[] = ['query' => $query,
                           'time'  => microtime(true) - $time0];
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
   * @throws MySqlDataLayerException
   * @throws ResultException
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
   * @throws MySqlQueryErrorException
   * @throws ResultException
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
   * @throws MySqlQueryErrorException
   */
  public function abcMenuCoreMenuGetItems(?int $pMnuId, ?int $pLanId): array
  {
    return $this->executeRows('call abc_menu_core_menu_get_items('.$this->quoteInt($pMnuId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Recomputes all profiles and makes tables ABC_AUTH_PRO_ROL and ABC_AUTH_PRO_PAG proper.
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcProfileProper(): int
  {
    return $this->executeNone('call abc_profile_proper()');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Recomputes all profiles and makes tables ABC_AUTH_PRO_ROL and ABC_AUTH_PRO_PAG proper as SP abc_profile_proper() but it removes
   * obsolete profiles.
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcProfileProperClean(): int
  {
    return $this->executeNone('call abc_profile_proper_clean()');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Updates the profile of a user.
   *
   * @param int|null $pCmpId The ID of the company (safeguard).
   *                         smallint(5) unsigned
   * @param int|null $pUsrId The ID of the user.
   *                         int(10) unsigned
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcProfileProperUser(?int $pCmpId, ?int $pUsrId): int
  {
    return $this->executeNone('call abc_profile_proper_user('.$this->quoteInt($pCmpId).','.$this->quoteInt($pUsrId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Removes a page from a functionality.
   *
   * @param int|null $pFunId The ID of the functionality.
   *                         smallint(5) unsigned
   * @param int|null $pPagId The ID of the page.
   *                         smallint(5) unsigned
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemFunctionalityDeletePage(?int $pFunId, ?int $pPagId): int
  {
    return $this->executeNone('call abc_system_functionality_delete_page('.$this->quoteInt($pFunId).','.$this->quoteInt($pPagId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all functionalities.
   *
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemFunctionalityGetAll(?int $pLanId): array
  {
    return $this->executeRows('call abc_system_functionality_get_all('.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all pages including a flag indication the page is part of a functionality.
   *
   * @param int|null $pFunId The ID of the functionality.
   *                         smallint(5) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemFunctionalityGetAvailablePages(?int $pFunId): array
  {
    return $this->executeRows('call abc_system_functionality_get_available_pages('.$this->quoteInt($pFunId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all roles including a flag indication the role is granted access to a functionality.
   *
   * @param int|null $pFunId The ID of the functionality.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the language use for linguistic entities.
   *                         tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemFunctionalityGetAvailableRoles(?int $pFunId, ?int $pLanId): array
  {
    return $this->executeRows('call abc_system_functionality_get_available_roles('.$this->quoteInt($pFunId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the details of a functionality.
   *
   * @param int|null $pFunId The ID of the functionality.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         tinyint(3) unsigned
   *
   * @return array
   *
   * @throws MySqlQueryErrorException
   * @throws ResultException
   */
  public function abcSystemFunctionalityGetDetails(?int $pFunId, ?int $pLanId): array
  {
    return $this->executeRow1('call abc_system_functionality_get_details('.$this->quoteInt($pFunId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all companies that are granted a functionality.
   *
   * @param int|null $pFunId The ID of the functionality.
   *                         smallint(5) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemFunctionalityGetGrantedCompanies(?int $pFunId): array
  {
    return $this->executeRows('call abc_system_functionality_get_granted_companies('.$this->quoteInt($pFunId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the pages to which a functionality grants access to.
   *
   * @param int|null $pFunId The ID of the functionality.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemFunctionalityGetPages(?int $pFunId, ?int $pLanId): array
  {
    return $this->executeRows('call abc_system_functionality_get_pages('.$this->quoteInt($pFunId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all the roles that are granted a functionality.
   *
   * @param int|null $pFunId The ID of the functionality.
   *                         smallint(5) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemFunctionalityGetRoles(?int $pFunId): array
  {
    return $this->executeRows('call abc_system_functionality_get_roles('.$this->quoteInt($pFunId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Inserts a new functionality.
   *
   * @param int|null $pMdlId The ID on the module of the new functionality.
   *                         smallint(5) unsigned
   * @param int|null $pWrdId The ID of the word of the name of the new functionality.
   *                         smallint(5) unsigned
   *
   * @return int
   *
   * @throws MySqlDataLayerException
   * @throws ResultException
   */
  public function abcSystemFunctionalityInsertDetails(?int $pMdlId, ?int $pWrdId): int
  {
    return $this->executeSingleton1('call abc_system_functionality_insert_details('.$this->quoteInt($pMdlId).','.$this->quoteInt($pWrdId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Adds a page to a functionality.
   *
   * @param int|null $pFunId The ID of the functionality.
   *                         smallint(5) unsigned
   * @param int|null $pPagId The ID of the page.
   *                         smallint(5) unsigned
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemFunctionalityInsertPage(?int $pFunId, ?int $pPagId): int
  {
    return $this->executeNone('call abc_system_functionality_insert_page('.$this->quoteInt($pFunId).','.$this->quoteInt($pPagId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Updates a functionality.
   *
   * @param int|null $pFunId The ID on the functionality.
   *                         smallint(5) unsigned
   * @param int|null $pMdlId The ID on the module.
   *                         smallint(5) unsigned
   * @param int|null $pWrdId The ID of the word of the name of the functionality.
   *                         smallint(5) unsigned
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemFunctionalityUpdateDetails(?int $pFunId, ?int $pMdlId, ?int $pWrdId): int
  {
    return $this->executeNone('call abc_system_functionality_update_details('.$this->quoteInt($pFunId).','.$this->quoteInt($pMdlId).','.$this->quoteInt($pWrdId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all modules.
   *
   * @param int|null $pLanId The ID of the language used for names.
   *                         tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemModuleGetAll(?int $pLanId): array
  {
    return $this->executeRows('call abc_system_module_get_all('.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all companies include a flag indicating that company is granted a module.
   *
   * @param int|null $pMdlId The ID of the module.
   *                         smallint(5) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemModuleGetAvailableCompanies(?int $pMdlId): array
  {
    return $this->executeRows('call abc_system_module_get_available_companies('.$this->quoteInt($pMdlId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the details of a module.
   *
   * @param int|null $pMdlId The ID of the module.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         tinyint(3) unsigned
   *
   * @return array
   *
   * @throws MySqlQueryErrorException
   * @throws ResultException
   */
  public function abcSystemModuleGetDetails(?int $pMdlId, ?int $pLanId): array
  {
    return $this->executeRow1('call abc_system_module_get_details('.$this->quoteInt($pMdlId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all functionalities of a module.
   *
   * @param int|null $pMdlId The ID of the module.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemModuleGetFunctions(?int $pMdlId, ?int $pLanId): array
  {
    return $this->executeRows('call abc_system_module_get_functions('.$this->quoteInt($pMdlId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all companies that are granted a module.
   *
   * @param int|null $pMdlId The ID of the module.
   *                         smallint(5) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemModuleGetGrantedCompanies(?int $pMdlId): array
  {
    return $this->executeRows('call abc_system_module_get_granted_companies('.$this->quoteInt($pMdlId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Inserts a new module.
   *
   * @param int|null $pWrdId The ID of the word of the name of the module.
   *                         smallint(5) unsigned
   *
   * @return int
   *
   * @throws MySqlDataLayerException
   * @throws ResultException
   */
  public function abcSystemModuleInsert(?int $pWrdId): int
  {
    return $this->executeSingleton1('call abc_system_module_insert('.$this->quoteInt($pWrdId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Modifies the name a module.
   *
   * @param int|null $pMdlId The ID of the module.
   *                         smallint(5) unsigned
   * @param int|null $pWrdId The ID of the word of the name of the module.
   *                         smallint(5) unsigned
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemModuleModify(?int $pMdlId, ?int $pWrdId): int
  {
    return $this->executeNone('call abc_system_module_modify('.$this->quoteInt($pMdlId).','.$this->quoteInt($pWrdId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all pages.
   *
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemPageGetAll(?int $pLanId): array
  {
    return $this->executeRows('call abc_system_page_get_all('.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all master pages.
   *
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemPageGetAllMasters(?int $pLanId): array
  {
    return $this->executeRows('call abc_system_page_get_all_masters('.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all functionalities including a flag indication the functionality grant access to a page.
   *
   * @param int|null $pPagId The ID of the page.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemPageGetAvailableFunctionalities(?int $pPagId, ?int $pLanId): array
  {
    return $this->executeRows('call abc_system_page_get_available_functionalities('.$this->quoteInt($pPagId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the details of a page.
   *
   * @param int|null $pPagId The ID of the page.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         tinyint(3) unsigned
   *
   * @return array
   *
   * @throws MySqlQueryErrorException
   * @throws ResultException
   */
  public function abcSystemPageGetDetails(?int $pPagId, ?int $pLanId): array
  {
    return $this->executeRow1('call abc_system_page_get_details('.$this->quoteInt($pPagId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all companies that are granted access to a page.
   *
   * @param int|null $pPagId The ID of the page.
   *                         smallint(5) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemPageGetGrantedCompanies(?int $pPagId): array
  {
    return $this->executeRows('call abc_system_page_get_granted_companies('.$this->quoteInt($pPagId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the functionalities that grant access to a page.
   *
   * @param int|null $pPagId The ID of the page.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemPageGetGrantedFunctionalities(?int $pPagId, ?int $pLanId): array
  {
    return $this->executeRows('call abc_system_page_get_granted_functionalities('.$this->quoteInt($pPagId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the roles that are granted access to a page.
   *
   * @param int|null $pPagId The ID of the page.
   *                         smallint(5) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemPageGetGrantedRoles(?int $pPagId): array
  {
    return $this->executeRows('call abc_system_page_get_granted_roles('.$this->quoteInt($pPagId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Inserts a new page.
   *
   * @param int|null    $pWrdId     The ID of the word of the page title.
   *                                smallint(5) unsigned
   * @param int|null    $pPtbId     The ID of the page tab to which the page belongs (optional).
   *                                tinyint(3) unsigned
   * @param int|null    $pPagIdOrg  The ID of master page of the new page (optional).
   *                                smallint(5) unsigned
   * @param string|null $pPagAlias  The alias of the new page.
   *                                varchar(32) character set latin1 collation latin1_swedish_ci
   * @param string|null $pPagClass  The class of the new page.
   *                                varchar(128) character set latin1 collation latin1_swedish_ci
   * @param string|null $pPagLabel  The label of the new page.
   *                                varchar(128) character set ascii collation ascii_general_ci
   * @param int|null    $pPagWeight The weight of the page inside a page group.
   *                                int(11)
   *
   * @return int
   *
   * @throws MySqlDataLayerException
   * @throws ResultException
   */
  public function abcSystemPageInsertDetails(?int $pWrdId, ?int $pPtbId, ?int $pPagIdOrg, ?string $pPagAlias, ?string $pPagClass, ?string $pPagLabel, ?int $pPagWeight): int
  {
    return $this->executeSingleton1('call abc_system_page_insert_details('.$this->quoteInt($pWrdId).','.$this->quoteInt($pPtbId).','.$this->quoteInt($pPagIdOrg).','.$this->quoteString($pPagAlias).','.$this->quoteString($pPagClass).','.$this->quoteString($pPagLabel).','.$this->quoteInt($pPagWeight).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Updates a page.
   *
   * @param int|null    $pPagId     The ID of the page.
   *                                smallint(5) unsigned
   * @param int|null    $pWrdId     The ID of the word of the page title.
   *                                smallint(5) unsigned
   * @param int|null    $pPtbId     The ID of the page tab to which the page belongs (optional).
   *                                tinyint(3) unsigned
   * @param int|null    $pPagIdOrg  The ID of master page of the page (optional).
   *                                smallint(5) unsigned
   * @param string|null $pPagAlias  The alias of the page.
   *                                varchar(32) character set latin1 collation latin1_swedish_ci
   * @param string|null $pPagClass  The class of the page.
   *                                varchar(128) character set latin1 collation latin1_swedish_ci
   * @param string|null $pPagLabel  The label of the page.
   *                                varchar(128) character set ascii collation ascii_general_ci
   * @param int|null    $pPagWeight The weight of the page inside a page group.
   *                                int(11)
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemPageUpdateDetails(?int $pPagId, ?int $pWrdId, ?int $pPtbId, ?int $pPagIdOrg, ?string $pPagAlias, ?string $pPagClass, ?string $pPagLabel, ?int $pPagWeight): int
  {
    return $this->executeNone('call abc_system_page_update_details('.$this->quoteInt($pPagId).','.$this->quoteInt($pWrdId).','.$this->quoteInt($pPtbId).','.$this->quoteInt($pPagIdOrg).','.$this->quoteString($pPagAlias).','.$this->quoteString($pPagClass).','.$this->quoteString($pPagLabel).','.$this->quoteInt($pPagWeight).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all role groups.
   *
   * @param int|null $pLanId The ID of the language use for linguistic entities.
   *                         tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemRoleGroupGetAll(?int $pLanId): array
  {
    return $this->executeRows('call abc_system_role_group_get_all('.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the details of a role group.
   *
   * @param int|null $pRlgId The ID of the role group.
   *                         smallint(5) unsigned
   * @param int|null $pLanId The ID of the language use for linguistic entities.
   *                         tinyint(3) unsigned
   *
   * @return array
   *
   * @throws MySqlQueryErrorException
   * @throws ResultException
   */
  public function abcSystemRoleGroupGetDetails(?int $pRlgId, ?int $pLanId): array
  {
    return $this->executeRow1('call abc_system_role_group_get_details('.$this->quoteInt($pRlgId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all roles in a role group.
   *
   * @param int|null $pRlgId The ID of the role group.
   *                         smallint(5) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemRoleGroupGetRoles(?int $pRlgId): array
  {
    return $this->executeRows('call abc_system_role_group_get_roles('.$this->quoteInt($pRlgId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Inserts a new role group and selects the ID of the new role group.
   *
   * @param int|null    $pWrdId     The ID of the word for the name of the role group.
   *                                smallint(5) unsigned
   * @param int|null    $pRlgWeight The weight for sorting of the role group.
   *                                smallint(6)
   * @param string|null $pRlgLabel  The label of the word group.
   *                                varchar(50) character set ascii collation ascii_general_ci
   *
   * @return int
   *
   * @throws MySqlDataLayerException
   * @throws ResultException
   */
  public function abcSystemRoleGroupInsert(?int $pWrdId, ?int $pRlgWeight, ?string $pRlgLabel): int
  {
    return $this->executeSingleton1('call abc_system_role_group_insert('.$this->quoteInt($pWrdId).','.$this->quoteInt($pRlgWeight).','.$this->quoteString($pRlgLabel).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   *
   * @param int|null    $pRlgId     @todo describe parameter
   *                                smallint(5) unsigned
   * @param int|null    $pWrdId     @todo describe parameter
   *                                smallint(5) unsigned
   * @param int|null    $pRlgWeight @todo describe parameter
   *                                smallint(6)
   * @param string|null $pRlgLabel  @todo describe parameter
   *                                varchar(50) character set ascii collation ascii_general_ci
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemRoleGroupUpdate(?int $pRlgId, ?int $pWrdId, ?int $pRlgWeight, ?string $pRlgLabel): int
  {
    return $this->executeNone('call abc_system_role_group_update('.$this->quoteInt($pRlgId).','.$this->quoteInt($pWrdId).','.$this->quoteInt($pRlgWeight).','.$this->quoteString($pRlgLabel).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all page tabs.
   *
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemTabGetAll(?int $pLanId): array
  {
    return $this->executeRows('call abc_system_tab_get_all('.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the details of a page tab.
   *
   * @param int|null $pPtbId The ID of the page tab.
   *                         tinyint(3) unsigned
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         tinyint(3) unsigned
   *
   * @return array
   *
   * @throws MySqlQueryErrorException
   * @throws ResultException
   */
  public function abcSystemTabGetDetails(?int $pPtbId, ?int $pLanId): array
  {
    return $this->executeRow1('call abc_system_tab_get_details('.$this->quoteInt($pPtbId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all master pages of a page tab.
   *
   * @param int|null $pPtbId The ID of the page tab.
   *                         tinyint(3) unsigned
   * @param int|null $pLanId The ID of the language for linguistic entities.
   *                         tinyint(3) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemTabGetMasterPages(?int $pPtbId, ?int $pLanId): array
  {
    return $this->executeRows('call abc_system_tab_get_master_pages('.$this->quoteInt($pPtbId).','.$this->quoteInt($pLanId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Inserts a page tab.
   *
   * @param int|null    $pWrdId    The ID of the word of the title of the page tab.
   *                               smallint(5) unsigned
   * @param string|null $pPtbLabel The label of the page tab.
   *                               varchar(30) character set ascii collation ascii_general_ci
   *
   * @return int
   *
   * @throws MySqlDataLayerException
   * @throws ResultException
   */
  public function abcSystemTabInsertDetails(?int $pWrdId, ?string $pPtbLabel): int
  {
    return $this->executeSingleton1('call abc_system_tab_insert_details('.$this->quoteInt($pWrdId).','.$this->quoteString($pPtbLabel).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Updates the details of a page tab.
   *
   * @param int|null    $pPtbId    The ID of the page tab.
   *                               tinyint(3) unsigned
   * @param int|null    $pWrdId    The ID of the word of the title of the page tab.
   *                               smallint(5) unsigned
   * @param string|null $pPtbLabel The label of the page tab.
   *                               varchar(30) character set ascii collation ascii_general_ci
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcSystemTabUpdateDetails(?int $pPtbId, ?int $pWrdId, ?string $pPtbLabel): int
  {
    return $this->executeNone('call abc_system_tab_update_details('.$this->quoteInt($pPtbId).','.$this->quoteInt($pWrdId).','.$this->quoteString($pPtbLabel).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects the password hash of a user account.
   *
   * @param int|null $pCmpId The ID of the company (safeguard).
   *                         smallint(5) unsigned
   * @param int|null $pUsrId The ID of the user.
   *                         int(10) unsigned
   *
   * @return string
   *
   * @throws MySqlDataLayerException
   * @throws ResultException
   */
  public function abcUserPasswordGetHash(?int $pCmpId, ?int $pUsrId): string
  {
    return $this->executeSingleton1('call abc_user_password_get_hash('.$this->quoteInt($pCmpId).','.$this->quoteInt($pUsrId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Updates the password hash of a user.
   *
   * @param int|null    $pCmpId           The ID of the company (safeguard).
   *                                      smallint(5) unsigned
   * @param int|null    $pUsrId           The ID of the user.
   *                                      int(10) unsigned
   * @param string|null $pUsrPasswordHash The new password hash.
   *                                      varchar(60) character set ascii collation ascii_general_ci
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcUserPasswordUpdateHash(?int $pCmpId, ?int $pUsrId, ?string $pUsrPasswordHash): int
  {
    return $this->executeNone('call abc_user_password_update_hash('.$this->quoteInt($pCmpId).','.$this->quoteInt($pUsrId).','.$this->quoteString($pUsrPasswordHash).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Selects all the roles granted to a user.
   *
   * @param int|null $pCmpId The ID of the company (safeguard).
   *                         smallint(5) unsigned
   * @param int|null $pUsrId The ID of the user.
   *                         int(10) unsigned
   *
   * @return array[]
   *
   * @throws MySqlQueryErrorException
   */
  public function abcUserRoleGetAll(?int $pCmpId, ?int $pUsrId): array
  {
    return $this->executeRows('call abc_user_role_get_all('.$this->quoteInt($pCmpId).','.$this->quoteInt($pUsrId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Select the details of a granted role to a user.
   *
   * @param int|null $pCmpId The ID of the company (safeguard).
   *                         smallint(5) unsigned
   * @param int|null $pUsrId The ID of the user.
   *                         int(10) unsigned
   * @param int|null $pRolId The ID of the role.
   *                         smallint(5) unsigned
   *
   * @return array|null
   *
   * @throws MySqlQueryErrorException
   * @throws ResultException
   */
  public function abcUserRoleGetDetails(?int $pCmpId, ?int $pUsrId, ?int $pRolId): ?array
  {
    return $this->executeRow0('call abc_user_role_get_details('.$this->quoteInt($pCmpId).','.$this->quoteInt($pUsrId).','.$this->quoteInt($pRolId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Grants a role to a user. If the role is already granted the granted interval will be updated.
   *
   * @param int|null    $pCmpId        The ID of the company.
   *                                   smallint(5) unsigned
   * @param int|null    $pUsrId        The ID of the user.
   *                                   int(10) unsigned
   * @param int|null    $pRolId        The ID of the role.
   *                                   smallint(5) unsigned
   * @param string|null $pAurDateStart The date from which the role is granted.
   *                                   date
   * @param string|null $pAurDateStop  The date after which the role is revoked.
   *                                   date
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcUserRoleGrantRole(?int $pCmpId, ?int $pUsrId, ?int $pRolId, ?string $pAurDateStart, ?string $pAurDateStop): int
  {
    return $this->executeNone('call abc_user_role_grant_role('.$this->quoteInt($pCmpId).','.$this->quoteInt($pUsrId).','.$this->quoteInt($pRolId).','.$this->quoteString($pAurDateStart).','.$this->quoteString($pAurDateStop).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Revokes a role from a user.
   *
   * @param int|null $pCmpId The ID of the company (safeguard).
   *                         smallint(5) unsigned
   * @param int|null $pUsrId The ID of the user.
   *                         int(10) unsigned
   * @param int|null $pRolId The ID of the role.
   *                         smallint(5) unsigned
   *
   * @return int
   *
   * @throws MySqlQueryErrorException
   */
  public function abcUserRoleRevokeRole(?int $pCmpId, ?int $pUsrId, ?int $pRolId): int
  {
    return $this->executeNone('call abc_user_role_revoke_role('.$this->quoteInt($pCmpId).','.$this->quoteInt($pUsrId).','.$this->quoteInt($pRolId).')');
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
