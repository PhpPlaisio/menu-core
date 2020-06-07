<?php
declare(strict_types=1);

namespace Plaisio\Menu\Test;

use Plaisio\Session\Session;

/**
 * Mock framework for testing purposes.
 */
class TestSession implements Session
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The ID of the profile of the user of the current session.
   *
   * @var int
   */
  public $proId;

  /**
   * The ID of the current session.
   *
   * @var int
   */
  public $sesId;

  /**
   * The ID of the logged in user.
   *
   * @var int
   */
  public $usrId;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritDoc
   */
  public function destroyAllSessions(): void
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritDoc
   */
  public function destroyAllSessionsOfUser(int $usrId): void
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * @inheritDoc
   */
  public function destroyOtherSessions(): void
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns stateful double submit token to prevent CSRF attacks.
   *
   * @return string
   */
  public function getCsrfToken(): string
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the ID of preferred language of the user of the current session.
   *
   * @return int
   */
  public function getLanId(): int
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns a reference to the data of a named section of the session.
   *
   * If the named section does not yet exists a reference to null is returned. Only named sections opened in shared
   * and exclusive mode will be saved by @param string $name The name of the named section.
   *
   * @param int $mode The mode for getting the named section.
   *
   * @return mixed
   *
   * @see   save.
   *
   * @since 1.0.0
   * @api
   */
  public function &getNamedSection(string $name, int $mode)
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the session token.
   *
   * @return string
   */
  public function getSessionToken(): string
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns true if the user is anonymous (i.e. not a user who has logged in). Otherwise, returns false.
   *
   * @return bool
   */
  public function isAnonymous(): bool
  {
    return true;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Updates the session that an user has successfully logged in.
   *
   * @param int $usrId The ID the user.
   *
   * @return void
   */
  public function login(int $usrId): void
  {
    $this->usrId = $usrId;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Terminates the current session.
   *
   * @return void
   */
  public function logout(): void
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Saves the current state op the session.
   *
   * @return void
   */
  public function save(): void
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Changes the language of the current session.
   *
   * @param int $lanId The ID of the new language.
   */
  public function setLanId(int $lanId): void
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Creates a session or resumes the current session based on the session cookie.
   *
   * @return void
   */
  public function start(): void
  {
    throw new \LogicException('Not implemented');
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
