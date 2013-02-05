<?php
session_start();

require_once 'globals.inc.php';

try {
  if ( !defined('KNB_NO_DATABASE_ACCESS') ) {
    $g_user = new Knb_ConnectedUser();
    $frontController = new Knb_FrontController();
    $frontController->initializeFromServerArray();
    if ( array_key_exists('_debug_mvc', $_GET) && $g_options['mvc']['debug'] ) {
      print('<pre id="debug-mvc">');
      print("<strong>MVC debug values</strong>\n\n");
      $frontController->printDebugInfos();
      print("</pre>");
    }
    $frontController->run();
  }
} catch (Exception $error) {
  print($error->getMessage()."\?>");
}

?>