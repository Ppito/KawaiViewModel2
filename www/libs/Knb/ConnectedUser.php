<?php

use Zend\Db\Sql\Select,
    Zend\Db\Sql\Expression;

/**
 * Store an user session, it is persisted on the user-side via cookies.
 */
class Knb_ConnectedUser extends Knb_UserTable
{
  private $sessionId;

  private $user;
  private $rights;
  private $userId;

  public function __construct() {
    parent::__construct();

    $session = new Knb_SessionTable();
    $session->clear();

    $this->sessionId = Knb_Cookie::getSessionIdFromCookie();
    $key             = $session->findOneBySessionKey($this->sessionId);
    $this->userId    = $key['user_id'];
    $this->rights    = NULL;

    $this->updateUsers();
  }

  public static function login($login, $password) {

    $sessionTable = new Knb_SessionTable();
    $sessionTable->clear();

    $userTable     = new Knb_UserTable();
    $session_infos = $userTable->findOneByUserLoginAndUserPasswordMd5(
      $login, 
      new Expression('MD5(CONCAT(user_password_nonce, "'.$password.'"))')
    );
    
    if ($session_infos === false) 
      throw new Exception("Invalid user name or password");

    $session_key = Knb_Cookie::generateSessionKey();
    $user_id     = $session_infos['user_id'];

    $session              = new Knb_Session();
    $session->user_id     = $user_id;
    $session->session_key = $session_key;
    $sessionTable->saveSession($session);

    Knb_Cookie::createCookie($session_key);
  }

  public function logout() {
    if (!$this->isAnonymous()) {
      $session = new Knb_SessionTable();
      $session->delete(array('session_key' => $this->sessionId));
      session_destroy();
    }
  }

  public function updateUsers() {
    if ($this->isAnonymous()) return;
    $this->user = $this->findOneByUserId($this->userId);
  }

  public function getId() {
    if ($this->isAnonymous()) return NULL;
    return $this->userId; 
  }

  public function getLoginForDisplay() {
    if ($this->isAnonymous()) return "Anonymous";
    return $this->user->user_login;
  }

  public function getLogin() {
    if ($this->isAnonymous()) return NULL;
    return $this->user->user_login;
  }

  public function getBirthday() {
    if ($this->isAnonymous()) return NULL;
    return $this->user->user_birthday;
  }

  public function getMail() {
    if ($this->isAnonymous()) return NULL;
    return $this->user->user_mail;
  }

  public function getPhone() {
    if ($this->isAnonymous()) return NULL;
    return $this->user->user_phone;
  }

  public function getFullName() {
    if ($this->isAnonymous()) return 'Anonymous';
    return $this->user->user_last_name . ' ' . $this->user->user_first_name;
  }

  public function getFirstName() {
    if ($this->isAnonymous()) return 'Anonymous';
    return $this->user->user_first_name;
  }

  public function getLastName() {
    if ($this->isAnonymous()) return 'Anonymous';
    return $this->user->user_last_name;
  }

  public function isAnonymous() {
    return ($this->userId === NULL);
  }

  private function ensureRightsLoaded() {
    if ($this->rights == NULL) $this->updateRights();
  }

  /**
   * Update the rights stored in this class from the database.
   */
  public function updateRights() {

    $this->rights = array();
    if (!$this->isAnonymous()) {
      $id     = $this->userId;
      $rights = array();

      $dbRights = $this->select(function (Select $select) use ($id) {
        $select
          ->columns(array())
          ->join(array('ug' => 'user__group'), 'ug.user_id = user.user_id', array())
          ->join(array('g'  => 'group_'), 'g.group_id = ug.group_id', array())
          ->join(array('gr' => 'group__right'), 'gr.group_id = g.group_id', array('value' => 'group__right_value'))
          ->join(array('r'  => 'right_'), 'r.right_id = gr.right_id', array('name'  => 'right_name'))
          ->where(array(
            'r.is_deleted'    => 0,
            'user.is_deleted' => 0,
            'g.is_deleted'    => 0,
            'user.user_id'    => $id
          ));
      });
      
      foreach ($dbRights as $dbRight) {
        $value = ($dbRight->value === 'allow');
        if (!array_key_exists($dbRight->name, $rights)) {
          $rights[$dbRight->name] = $value;
        } else if ($rights[$dbRight->name] && ($value === false)) {
          $rights[$dbRight->name] = false;
        }
      }

      $this->rights = array_keys(array_filter($rights));
    }
  }
  
  public function assertRight($rightName) {
    if (!$this->haveRight($rightName)) {
      
      $rightTable = new Knb_RightTable();
      $right      = $rightTable->findOneByRightName($rightName);
      throw new Vbf_Mvc_Exception404("You (".$this->getLoginForDisplay().") don't have the needed right to do this action : " . $right['right_description']);
    }
  }

  public function getRights() {
    $this->ensureRightsLoaded();
    return $this->rights;
  }

  public function haveRight($right)
  {
    $this->ensureRightsLoaded();
    $rights = !is_array($right) ? array($right) : $right;
    foreach ($rights as $value) {
      if (!in_array($value, $this->rights))
        return false;
    }
    return true;
  }
  
  public function haveOneRight($rights) {
    $this->ensureRightsLoaded();
    $rights = !is_array($right) ? array($right) : $right;
    foreach ($rights as $value) {
      if (!in_array($value, $this->rights))
        return true;
    }
    return false;
  }
}

?>
