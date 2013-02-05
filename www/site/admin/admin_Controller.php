<?php

class Admin_Controller extends Knb_Controller
{
  public function getAction()
  {
    $this->getConnectedUser()->assertRight('admin_view');

    $this->setTitle('Administration');
  }

  public function getMainmenu() {
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
    $admin = array();
    if ( $g_user->haveRight("admin_view") ) {
      if ( $g_user->haveRight("user_view") )      { $admin['Users']     = array('link' => "/admin/users"); }
      if ( $g_user->haveRight("group_view") )     { $admin['Groups']    = array('link' => "/admin/groups"); }
      if ( $g_user->haveRight("right_view") )     { $admin['Rights']    = array('link' => "/admin/rights"); }
      if ( !empty($admin) ) { $menu['Admin'] = $admin; }
    }

    return $menu;
  }
}

?>