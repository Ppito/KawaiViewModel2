<?php
/*
 * This file contain the default values for options and should never be
 * touched when installing. If different values are needed they should be
 * set in the 'options.php' file.
 */

$g_options = array();

/*
 * Set this option to TRUE to display error and exception details instead of
 * just a short page saying that an error hapenned.
 *
 * Don't let this enabled in prodution as it leak lot of informations to a
 * potential attacker.
 */
$g_options['error']['debug']        = FALSE;

/*
 * This option could either contain the url (as passed to a location header) of
 * a page explaining to the user that an error hapenned or FALSE to let the
 * engine display a small error message.
 */
$g_options['error']['redirect']     = FALSE;
$g_options['mvc']['debug']          = FALSE;

/*
 * By default the minified version of javascript is used in the knb views, set this
 * option to TRUE to get the standard version.
 */
$g_options['javascript']['debug']     = TRUE;

/*
 * This option is for specifying the autoload class map files.
 */
$g_options['autoload_classmap'][]     = ROOT_PATH . 'libs/Knb/autoload_classmap.php';
$g_options['autoload_classmap'][]     = ROOT_PATH . 'libs/Vbf/autoload_classmap.php';
$g_options['autoload_classmap'][]     = ROOT_PATH . 'libs/Utils/autoload_classmap.php';
$g_options['autoload_classmap'][]     = ROOT_PATH . 'site/autoload_classmap.php';

/*
 * Configure skin option
 */
$g_options['skin']['debug']           = FALSE;
$g_options['skin']['dir']             = ROOT_PATH . 'skins';
$g_options['skin']['url']             = ROOT_URL  . 'skins';
$g_options['skin']['default']         = 'default';
$g_options['skin']['mask'][]          = array(
					  'token' => '#SKIN#',
					  'name'  => 'default'
					);

/*
 * The database type is MySQL by default, the different options are 'mysql/oracle/mssql/db2'.
 */
$g_options['db']['driver']   = 'Pdo_Mysql';
$g_options['db']['port']     = '3306';
$g_options['db']['hostname'] = '127.0.0.1';
$g_options['db']['username'] = 'user';
$g_options['db']['password'] = '';
$g_options['db']['database'] = 'database';

?>
