<?php

class Rights_Controller extends Knb_Controller
{
  private static  $fieldRight = array(
     'right_name'           => array( 'type'    => 'string',    'required'  => true,  'error' =>  'Nom',          'name'  =>  'Nom'          )
    ,'right_description'    => array( 'type'    => 'string',    'required'  => false, 'error' =>  'Description',  'name'  =>  'Description'  )
  );
  private static  $fieldRightGroup = array(
     'group_id'           => array( 'type'    => 'integer',    'required'  => true, 'error' =>  'Groupe',        'name'  =>  'Groupe'        )
    ,'right_id'           => array( 'type'    => 'integer',    'required'  => true, 'error' =>  'Droit',         'name'  =>  'Droit'         )
    ,'group__right_value' => array( 'type'    => 'string',     'required'  => true, 'error' =>  'Autorisation',  'name'  =>  'Autorisation'  )
  );

  // GET /admin/rights
  public function getListAction()
  {
    $this->getConnectedUser()->assertRight('right_view');

    $this->setTitle('Gestion des droits');
    $rightTable = new Rights();
    $rights     = $rightTable->findAll();
    $this->setParameter('rights', $rights);
  }

  // GET /admin/rights/listGroup
  public function getListGroupAction()
  {
    $this->getConnectedUser()->assertRight('right_view');

    $this->setTitle('Gestion des droits de groupe');
    $rightTable = new Rights();
    $rights     = $rightTable->getGroupList();
    $this->setParameter('rights_group', $rights);
  }

  // GET /admin/rights/{right_id}/edit
  public function getEditAction($right_id = 0)
  {
    $this->getConnectedUser()->assertRight('right_edit');

    $this->setGlobalView('popup');
    $this->setTitle((!$right_id ? "Ajouter" : "Modifier") . " un droit");

    if ( array_key_exists('FormRight', $_SESSION) && !empty($_SESSION['FormRight']) ) {
      $params = $_SESSION['FormRight'];
    }

    if ( !empty($_GET) ) {
      $params = array_replace($params, $_GET);
    }
    if ( $right_id != 0 && (!array_key_exists('FormRight', $_SESSION) || empty($_SESSION['FormRight'])) ) {
      $rightTable = new Rights();
      $params = $rightTable->findOneByRightId($right_id);
    }
    $params['right_id'] = $right_id;
    $this->setParameters($params);
  }

    // POST /admin/rights/{right_id}/edit
  public function postEditAction($right_id = 0)
  {
    $this->getConnectedUser()->assertRight('right_edit');

    global $g_options;
    global $g_user;

    $this->setGlobalView('popup');
    $this->setTitle((!$right_id ? "Ajouter" : "Modifier") . " un droit");

    $_SESSION['FormRight'] = $_POST;
    /*
     *  Check all input type
     */
    if ( ($errors = Form::check(self::$fieldRight, $_POST)) !== true ) {

      $_SESSION['FormRight']['errors'] = Utils::formatError($errors);
      $this->back();

    } else {

      foreach ( $_SESSION['FormRight'] as $col => $val ) {
        if ( !array_key_exists($col, self::$fieldRight) || $val == '')
          unset($_SESSION['FormRight'][$col]);
      }
      $_SESSION['FormRight']['right_id'] = $right_id;

      $right      = new Knb_Right();
      $right->exchangeArray($_SESSION['FormRight']);
      $rightTable = new Rights();

      if ($rightTable->saveRight($right) == false)
        $this->back();

      $this->setParameters($_SESSION['FormRight']);
      unset($_SESSION['FormRight']);
    }
  }

  // GET /admin/rights/newGroup
  public function getNewGroupAction()
  {
    $this->getConnectedUser()->assertRight('right_edit');

    $this->setGlobalView('popup');
    $this->setTitle("Ajouter un droit de groupe");

    $groupTable = new Groups();
    $groups     = $groupTable->findAll();
    foreach ($groups as $group) {
      $gList[$group->group_id] = $group->group_name;
    }

    $rightTable = new Rights();
    $rights     = $rightTable->findAll();
    foreach ($rights as $right) {
      $rList[$right->right_id] = $right->right_name;
    }

    $params['group'] = $gList;
    $params['right'] = $rList;
    $this->setParameters($params);
  }

    // POST /admin/rights/newGroup
  public function postNewGroupAction()
  {
    $this->getConnectedUser()->assertRight('right_edit');

    global $g_options;
    global $g_user;

    $this->setGlobalView('popup');
    $this->setTitle("Ajouter un droit de groupe");

    $_SESSION['FormRightGroup'] = $_POST;
    /*
     *  Check all input type
     */
    if ( ($errors = Form::check(self::$fieldRightGroup, $_POST)) !== true ) {

      $_SESSION['FormRightGroup']['errors'] = Utils::formatError($errors);
      $this->back();

    } else {

      foreach ( $_SESSION['FormRightGroup'] as $col => $val ) {
        if ( !array_key_exists($col, self::$fieldRightGroup) || $val == '')
          unset($_SESSION['FormRightGroup'][$col]);
      }

      $rightTable = new Rights();
      if ($rightTable->createRightGroup($_SESSION['FormRightGroup']) == false) {
        $this->back();
      }

      $this->setParameters($_SESSION['FormRightGroup']);
      unset($_SESSION['FormRightGroup']);
    }
  }
  
  // GET /admin/rights/{right_id}/delete
  public function getDeleteAction($right_id)
  {
    $this->getConnectedUser()->assertRight('right_delete');

    $this->setGlobalView('popup');
    $this->disablePageTitle();
    $this->setParameter("right_id", $right_id);
  }
  
  // POST /admin/rights/{right_id}/delete
  public function postDeleteAction($right_id)
  {
    $this->getConnectedUser()->assertRight('right_delete');
    $res = false;
    if ( Is::alphaNumerique($right_id) ) {
      $rightTable = new Rights();
      $res = $rightTable->deleteRight($right_id);
    }
    $this->setParameter('result', $res);
  }
  
  // GET /admin/rights/{right_id}/{group_id}/delete
  public function getDeleteGroupAction($right_id, $group_id)
  {
    $this->getConnectedUser()->assertRight('right_delete');

    $this->setGlobalView('popup');
    $this->disablePageTitle();
    $this->setParameter("right_id", $right_id);
    $this->setParameter("group_id", $group_id);
  }
  
  // POST /admin/rights/{right_id}/{group_id}/deleteGroup
  public function postDeleteGroupAction($right_id, $group_id)
  {
    $this->getConnectedUser()->assertRight('right_delete');
    $res = false;
    if ( Is::alphaNumerique($right_id) && Is::alphaNumerique($group_id) ) {
      $rightTable = new Rights();
      $res = $rightTable->deleteRightGroup($right_id, $group_id);
    }
    $this->setParameter('result', $res);
  }

  // POST /admin/rights/changeRight
  public function postChangeRightAction($right_id, $group_id)
  {
    $this->getConnectedUser()->assertRight('right_edit');
    $res = false;
    if ( Is::alphaNumerique($group_id) && Is::alphaNumerique($right_id) ) {
      $rightTable = new Rights();
      $res = $rightTable->updateGroupRight($group_id, $right_id);
    }
    $this->setParameter('result', $res);
  }

  public function getMainmenu()
  {
    global $g_user;

    $admin = array();
    $admin['Accueil'] = array("link" => "/");
    if ( $g_user->haveRight("admin_view") ) { $admin["Admin"]  = array('link' => "/admin"); }

    return $admin;
  }

  public function getSubmenu()
  {
    global $g_user;

    $menu = array();
    $rights = array();
    $admin = array();
    if ( $g_user->haveRight("admin_view") ) {
      if ( $g_user->haveRight("user_view") )      { $admin['Users']     = array('link' => "/admin/users"); }
      if ( $g_user->haveRight("group_view") )     { $admin['Groups']    = array('link' => "/admin/groups"); }
      if ( $g_user->haveRight("right_view") )     { $admin['Rights']    = array('link' => "/admin/rights"); }
      if ( $g_user->haveRight('right_view') )     { $rights['Liste des droits']               = array('link' => ''); }
      if ( $g_user->haveRight('right_view') )     { $rights['Liste des droits de groupe']     = array('link' => '/admin/rights/listGroup'); }
      if ( !empty($admin) ) { $menu['Admin'] = $admin; }
      if ( !empty($rights) ) { $menu['Rights'] = $rights; }
    }

    return $menu;
  }

}
?>