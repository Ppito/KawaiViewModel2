<?php

use Zend\Db\ResultSet\ResultSet;

class Groups_Controller extends Knb_Controller
{
  private static  $fieldGroup = array(
     'group_name'           => array( 'type'    => 'string',    'required'  => true,  'error' =>  'Nom',          'name'  =>  'Nom'          )
    ,'group_description'    => array( 'type'    => 'string',    'required'  => false, 'error' =>  'Description',  'name'  =>  'Description'  )
  );

  // GET /admin/groups
  public function getListAction()
  {
    $this->getConnectedUser()->assertRight('group_view');

    $this->setTitle('Gestion des groupes');
    $groupTable = new Groups();
    $result     = $groupTable->findAll();
    $this->setParameter('groups', $result);
  }

  // GET /admin/groups/{group_id}/edit
  public function getEditAction($group_id = 0)
  {
    $this->getConnectedUser()->assertRight('group_edit');

    $this->setGlobalView('popup');
    $this->setTitle((!$group_id ? "Ajouter" : "Modifier") . " un groupe");

    if ( array_key_exists('FormGroup', $_SESSION) && !empty($_SESSION['FormGroup']) ) {
      $params = $_SESSION['FormGroup'];
    }

    if ( !empty($_GET) ) {
      $params = array_replace($params, $_GET);
    }
    if ( $group_id != 0 && (!array_key_exists('FormGroup', $_SESSION) || empty($_SESSION['FormGroup'])) ) {
      $groupTable = new Groups();
      $params = $groupTable->findOneByGroupId($group_id);
    }
    $params['group_id'] = $group_id;
    $this->setParameters($params);
  }

    // POST /admin/groups/{group_id}/edit
  public function postEditAction($group_id = 0)
  {
    $this->getConnectedUser()->assertRight('group_edit');

    global $g_options;
    global $g_user;

    $this->setGlobalView('popup');
    $this->setTitle((!$group_id ? "Ajouter" : "Modifier") . " un groupe");

    $_SESSION['FormGroup'] = $_POST;
    /*
     * Check all input type
     */
    if ( ($errors = Form::check(self::$fieldGroup, $_POST)) !== true ) {

      $_SESSION['FormGroup']['errors'] = Utils::formatError($errors);
      $this->back();

    } else {

      foreach ( $_SESSION['FormGroup'] as $col => $val ) {
        if ( !array_key_exists($col, self::$fieldGroup) || $val == '')
          unset($_SESSION['FormGroup'][$col]);
      }
      $_SESSION['FormGroup']['group_id'] = $group_id;

      $group      = new Knb_Group();
      $group->exchangeArray($_SESSION['FormGroup']);
      $groupTable = new Groups();

      if ($groupTable->saveGroup($group) == false)
        $this->back();

      $this->setParameters($_SESSION['FormGroup']);
      unset($_SESSION['FormGroup']);
    }
  }

  // GET /admin/groups/{group_id}/delete
  public function getDeleteAction($group_id)
  {
    $this->getConnectedUser()->assertRight('group_delete');

    $this->setGlobalView('popup');
    $this->disablePageTitle();
    $this->setParameter("group_id", $group_id);
  }
  
  // POST /admin/groups/{group_id}/delete
  public function postDeleteAction($group_id)
  {
    $this->getConnectedUser()->assertRight('group_delete');

    $res = false;
    if ( Is::alphaNumerique($group_id) ) {
      $groupTable = new Groups();
      $res = $groupTable->deleteGroup($group_id);
    }
    $this->setParameter('result', $res);
  }

  public function getMainmenu() {
    global $g_user;

    $admin = array();
    $admin['Accueil'] = array("link" => "/");
    if ( $g_user->haveRight("admin_view") ) { $admin["Admin"]  = array('link' => "/admin"); }

    return $admin;
  }

  public function getSubmenu() {
    global $g_user;

    $menu = array();
    $groups = array();
    $admin = array();
    if ( $g_user->haveRight("admin_view") ) {
      if ( $g_user->haveRight("user_view") )      { $admin['Users']     = array('link' => "/admin/users"); }
      if ( $g_user->haveRight("group_view") )     { $admin['Groups']    = array('link' => "/admin/groups"); }
      if ( $g_user->haveRight("right_view") )     { $admin['Rights']    = array('link' => "/admin/rights"); }
      if ( $g_user->haveRight('group_view') )     { $groups['Voir la liste'] = array('link' => ''); }
      if ( $g_user->haveRight('right_view') )     { $groups['Liste des droits'] = array('link' => '/admin/rights/listGroup'); }

      if ( !empty($admin) ) { $menu['Admin'] = $admin; }
      if ( !empty($groups) ) { $menu['Groups'] = $groups; }
    }

    return $menu;
  }
}
?>