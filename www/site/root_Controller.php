<?php

class Root_Controller extends Knb_Controller {
  private static  $fieldUser = array(
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

  public function getAction() {
    $this->setTitle('Bienvenue');
  }

  public function postLoginAction() {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $this->setParameter('error', null);

    try {
      Knb_ConnectedUser::login($login, $password);
      if ($this->getExtension() == 'html')
        $this->back();
    } catch ( Exception $error ) {
      $this->setParameter('error', $error);
    }
  }

  public function getLogoutAction() {
    $this->getConnectedUser()->logout();

    if ($this->getExtension() == 'html') {
      header('Location: ' . ROOT_URL);
      exit();
    }
  }

  public function getInscriptionAction() {
    $this->setTitle('Inscription');
    
    if ( array_key_exists('FormUser', $_SESSION) && !empty($_SESSION['FormUser']) ) {
      $params = $_SESSION['FormUser'];
    }

    if ( !empty($_GET) ) {
      $params = array_replace($params, $_GET);
    }

    if ( isset($params) && array_key_exists('user_birthday', $params) ) {
      $params['user_birthday'] = Utils::dateUkToFr($params['user_birthday']);
    }

    $params['user_id'] = 0;
    $this->setParameters($params);
  }

  public function postInscriptionAction() {

    global $g_options;
    global $g_user;

    $this->setTitle('Inscription');

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

      $user = new Knb_User();
      $user->exchangeArray($_SESSION['FormUser']);
      $userTable = new Users();

      if ($userTable->saveUser($user) == false)
        $this->back();

      $this->setParameters($_SESSION['FormUser']);
      unset($_SESSION['FormUser']);
    }
  }

  public function getMainmenu() {
    global $g_user;

    $admin = array();
    $admin['Accueil'] = array("link" => "/");
    if ($g_user->haveRight("admin_view")) {
       $admin["Admin"] = array('link' => "/admin");
    }

    return $admin;
  }

}
?>
