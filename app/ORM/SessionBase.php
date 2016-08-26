<?php
/**
 * Abstract base class for table "session"
 *
 * *** NEVER EVER EDIT THIS FILE! ***
 *
 * To extend the functionallity, edit "Session.php"
 *
 * If you make changes here, they will be lost on next build!
 *
 * @author     Knut Kohl <github@knutkohl.de>
 * @copyright  2016 Knut Kohl
 * @license    MIT License (MIT) http://opensource.org/licenses/MIT
 *
 * @author     ORM class builder
 * @version    1.4.0 / 2016-07-18
 */
namespace ORM;

/**
 *
 */
abstract class SessionBase extends \ORM
{

    // -----------------------------------------------------------------------
    // PUBLIC
    // -----------------------------------------------------------------------

    // -----------------------------------------------------------------------
    // Setter methods
    // -----------------------------------------------------------------------

    /**
     * Basic setter for field "user"
     *
     * @param  mixed    $user User value
     * @return Instance For fluid interface
     */
    public function setUser($user)
    {
        $this->fields['user'] = $user;
        return $this;
    }   // setUser()

    /**
     * Raw setter for field "user", for INSERT, REPLACE and UPDATE
     *
     * @param  mixed    $user User value
     * @return Instance For fluid interface
     */
    public function setUserRaw($user)
    {
        $this->raw['user'] = $user;
        return $this;
    }   // setUserRaw()

    /**
     * Basic setter for field "token"
     *
     * @param  mixed    $token Token value
     * @return Instance For fluid interface
     */
    public function setToken($token)
    {
        $this->fields['token'] = $token;
        return $this;
    }   // setToken()

    /**
     * Raw setter for field "token", for INSERT, REPLACE and UPDATE
     *
     * @param  mixed    $token Token value
     * @return Instance For fluid interface
     */
    public function setTokenRaw($token)
    {
        $this->raw['token'] = $token;
        return $this;
    }   // setTokenRaw()

    /**
     * Basic setter for field "until"
     *
     * @param  mixed    $until Until value
     * @return Instance For fluid interface
     */
    public function setUntil($until)
    {
        $this->fields['until'] = $until;
        return $this;
    }   // setUntil()

    /**
     * Raw setter for field "until", for INSERT, REPLACE and UPDATE
     *
     * @param  mixed    $until Until value
     * @return Instance For fluid interface
     */
    public function setUntilRaw($until)
    {
        $this->raw['until'] = $until;
        return $this;
    }   // setUntilRaw()

    // -----------------------------------------------------------------------
    // Getter methods
    // -----------------------------------------------------------------------

    /**
     * Basic getter for field "user"
     *
     * @return mixed User value
     */
    public function getUser()
    {
        return $this->fields['user'];
    }   // getUser()

    /**
     * Basic getter for field "token"
     *
     * @return mixed Token value
     */
    public function getToken()
    {
        return $this->fields['token'];
    }   // getToken()

    /**
     * Basic getter for field "until"
     *
     * @return mixed Until value
     */
    public function getUntil()
    {
        return $this->fields['until'];
    }   // getUntil()

    // -----------------------------------------------------------------------
    // Filter methods
    // -----------------------------------------------------------------------

    /**
     * Filter for field "user"
     *
     * @param  mixed    $user Filter value
     * @return Instance For fluid interface
     */
    public function filterByUser($user)
    {
        $this->filter[] = '`user` = '.$this->quote($user);
        return $this;
    }   // filterByUser()

    /**
     * Filter for field "token"
     *
     * @param  mixed    $token Filter value
     * @return Instance For fluid interface
     */
    public function filterByToken($token)
    {
        $this->filter[] = '`token` = '.$this->quote($token);
        return $this;
    }   // filterByToken()

    /**
     * Filter for field "until"
     *
     * @param  mixed    $until Filter value
     * @return Instance For fluid interface
     */
    public function filterByUntil($until)
    {
        $this->filter[] = '`until` = '.$this->quote($until);
        return $this;
    }   // filterByUntil()

    // -----------------------------------------------------------------------
    // PROTECTED
    // -----------------------------------------------------------------------

    /**
     * Update fields on insert on duplicate key
     */
    protected function onDuplicateKey()
    {
        return '`token` = '.$this->quote($this->fields['token']).'
              , `until` = '.$this->quote($this->fields['until']).'';
    }   // onDuplicateKey()

    /**
     * Table name
     *
     * @var string $table Table name
     */
    protected $table = 'session';

    /**
     * SQL for creation
     *
     * @var string $createSQL
     */
    protected $createSQL = '
        CREATE TABLE `session` (
          `user` varchar(32) NOT NULL,
          `token` char(40) NOT NULL,
          `until` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          PRIMARY KEY (`user`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ';

    /**
     *
     */
    protected $fields = array(
        'user'  => '',
        'token' => '',
        'until' => ''
    );

    /**
     *
     */
    protected $nullable = array(
        'user'  => false,
        'token' => false,
        'until' => false
    );

    /**
     *
     */
    protected $primary = array(
        'user'
    );

    /**
     *
     */
    protected $autoinc = '';

}
