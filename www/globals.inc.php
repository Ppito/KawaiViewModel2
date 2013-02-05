<?php

/******************************************************************************
 * Initialize all the global variables
 *****************************************************************************/

function    get_base_url()
{
  $url      = $_SERVER['SCRIPT_NAME'];
  $urlParts = explode('/', $url);
  array_pop($urlParts);
  return implode('/', $urlParts).'/';
}

/******************************************************************************
 * Constants
 *****************************************************************************/

define('ROOT_PATH',     dirname(__file__) . '/');
define('ROOT_URL',      get_base_url());
define('ZF2_PATH',      ROOT_PATH.'/libs/Zend/');
ini_set("include_path", ROOT_PATH . '/libs/');

/******************************************************************************
 * Exception Handler
 *****************************************************************************/
require_once 'exception_handler.php';
set_exception_handler("knb_exception_handler");

if ( get_magic_quotes_gpc() ) throw new Exception("magic_quotes_gpc is not supported.");

/******************************************************************************
 * Loading of the options (default & user)
 *****************************************************************************/

if ( !file_exists(ROOT_PATH."options.php") )
  die("The file options.php should exists, please read the instructions inside of 'options.php-example'.");

require_once ROOT_PATH."options_default.php";
require_once ROOT_PATH."options.php";

/******************************************************************************
 * Initialize autoloader
 *****************************************************************************/

require_once 'init_autoloader.php';

require_once ZF2_PATH . '/Loader/ClassMapAutoloader.php';
$autoLoader = new Zend\Loader\ClassMapAutoloader($g_options['autoload_classmap']);
// register with the SPL autoloader
$autoLoader->register();  

/******************************************************************************
 * Initialaze database & user connexion
 *****************************************************************************/

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

$g_database = new Adapter($g_options['db']);
$g_sql      = new Sql($g_database);

//$g_skins = new Vbf_Skins($g_options['skin']['dir'], $g_options['skin']['url'], $g_options['skin']['default']);
//$g_database = new Vbf_MySQL($g_options['mysql']['host'], $g_options['mysql']['user'],
//    $g_options['mysql']['password'], $g_options['mysql']['database'], $g_options['mysql']['port']);


?>
