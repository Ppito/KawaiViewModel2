<?php

class Users_Controller extends Knb_Controller
{
  private static $fieldUser = array(
     'user_login'       => array( 'type'    => 'string',    'required'  => true,  'error' =>  'Identifiant',        'name'  =>  'Identifiant'         )
    ,'user_last_name'   => array( 'type'    => 'string',    'required'  => true,  'error' =>  'Nom',                'name'  =>  'Nom'                 )
    ,'user_first_name'  => array( 'type'    => 'string',    'required'  => true,  'error' =>  'Prénom',             'name'  =>  'Prénom'              )
    ,'user_birthday'    => array( 'type'    => 'date',      'required'  => true,  'error' =>  'Date de naissance',  'name'  =>  'Date de naissance'   )
    ,'user_mail'        => array( 'type'    => 'mail',      'required'  => false, 'error' =>  'Adresse mail',       'name'  =>  'Adresse mail'        )
    ,'user_phone'       => array( 'type'    => 'phone',     'required'  => false, 'error' =>  'Téléphone',          'name'  =>  'Téléphone'           )
    ,'user_sexe'        => array( 'type'    => 'bool',      'required'  => true,  'error' =>  'Sexe',               'name'  =>  'Sexe'                )
    ,'user_password'    => array(
       'type'      => 'string'
      ,'required'  => false
      ,'error'     => 'Mot de passe'
      ,'name'      => 'Mot de passe'
      ,'export'    => false
      ,'sameField' => array(
        'field'  => 'user_verif_password'
        ,'error' => 'Les mots de passe saisis ne sont pas identiques.'
        )
      )
  );

  private static function getUserAsArrayOr404($user_id)
  {
    $userArray = Users::getUserAsArray($user_id);
    if ($userArray === NULL) throw new Vbf_Mvc_Exception404("Unknown user : $username");
    return $userArray;
  }

  // GET /admin/users/
  public function getListAction()
  {
    $this->getConnectedUser()->assertRight('user_view');

    $this->setTitle('Gestion des utilisateurs');
    $userTable = new Users();
    $users     = $userTable->findAll();
    foreach ( $users as $user ) {
      $grp   = $userTable->getGroupForUser($user->user_id);
      $group = array();
      foreach ($grp as $value) {
        $group[] = $value->group_name;
      }
      $user->user_groups = $group;
    }
    $this->setParameter('users', $users);
  }

  // GET /admin/users/{user_id}/edit
  public function getEditAction($user_id = 0)
  {
    $this->getConnectedUser()->assertRight('user_edit');

    $this->setGlobalView('popup');
    $this->setTitle((!$user_id ? "Ajouter" : "Modifier") . " l'utilisateur");

    if ( array_key_exists('FormUser', $_SESSION) && !empty($_SESSION['FormUser']) ) {
      $params = $_SESSION['FormUser'];
    }

    if ( !empty($_GET) ) {
      $params = array_replace($params, $_GET);
    }

    if ( $user_id != 0 && (!array_key_exists('FormUser', $_SESSION) || empty($_SESSION['FormUser'])) ) {
      $userTable = new Users();
      $params = $userTable->findOneByUserId($user_id);
    }
    if ( isset($params) && array_key_exists('user_birthday', $params) ) {
      $params['user_birthday'] = Utils::dateUkToFr($params['user_birthday']);
    }

    $params['user_id'] = $user_id;
    $this->setParameters($params);
  }

    // POST /admin/users/{user_id}/edit
  public function postEditAction($user_id = 0)
  {
    $this->getConnectedUser()->assertRight('user_edit');

    global $g_options;
    global $g_user;

    $this->setGlobalView('popup');
    $this->setTitle((!$user_id ? "Ajouter" : "Modifier") . " l'utilisateur ");

    $_SESSION['FormUser'] = $_POST;

    /*
     *  Check all input type
     */
    if ( ($errors = Form::check(self::$fieldUser, $_POST)) !== true ) {

      $_SESSION['FormUser']['errors'] = Utils::formatError($errors);
      $this->back();

    } else {

      $_SESSION['FormUser']['user_birthday'] = Utils::dateFrToUk($_SESSION['FormUser']['user_birthday']);

      foreach ( $_SESSION['FormUser'] as $col => $val ) {
        if ( !array_key_exists($col, self::$fieldUser) || $val == '')
          unset($_SESSION['FormUser'][$col]);
      }

      $_SESSION['FormUser']['user_id'] = $user_id;
      if (array_key_exists('user_password', $_SESSION['FormUser'])) {
        $_SESSION['FormUser']['user_password_md5'] = $_SESSION['FormUser']['user_password'];
      }

      $user = new Knb_User();
      $user->exchangeArray($_SESSION['FormUser']);
      $userTable = new Users();

      if ($userTable->saveUser($user) == false)
        $this->back();

      $this->setParameters($_SESSION['FormUser']);
      unset($_SESSION['FormUser']);
    }
  }

  // GET /admin/users/{user_id}/delete
  public function getDeleteAction($user_id)
  {
    $this->getConnectedUser()->assertRight('user_delete');

    $this->setGlobalView('popup');
    $this->disablePageTitle();
    $this->setParameter("user_id", $user_id);
  }
  
  // POST /admin/users/{user_id}/delete
  public function postDeleteAction($user_id)
  {
    $this->getConnectedUser()->assertRight('user_delete');
    $res = false;
    if ( $user_id != $this->getConnectedUser()->getId() ) {
      $userTable = new Users();
      $res = $userTable->deleteUser($user_id);
    }
    $this->setParameter('result', $res);
  }

  public function getMainmenu() {
    global $g_user;

    $admin = array();
    $admin['Accueil'] = array("link" => "/");
    if ( $g_user->haveRight("admin_view") ) $admin["Admin"]  = array('link' => "/admin");

    return $admin;
  }

  public function getSubmenu()
  {
    global $g_user;

    $menu  = array();
    $users = array();
    $admin = array();
    if ( $g_user->haveRight("admin_view") ) {
      if ( $g_user->haveRight("user_view") )      $admin['Users']             = array('link' => "/admin/users");
      if ( $g_user->haveRight("group_view") )     $admin['Groups']            = array('link' => "/admin/groups");
      if ( $g_user->haveRight("right_view") )     $admin['Rights']            = array('link' => "/admin/rights");
      if ( $g_user->haveRight('user_view') )      $users['Voir la liste']     = array('link' => '');

      if ( !empty($admin) ) $menu['Admin'] = $admin;
      if ( !empty($users) ) $menu['User']  = $users;
    }

    return $menu;
  }
}

?>
