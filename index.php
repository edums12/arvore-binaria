<?php 

/* Defines
----------------- */
define('APPPATH', dirname(__FILE__));

define('DS', DIRECTORY_SEPARATOR);

define('BASE_URL', 'http://localhost/arvoreBinaria/');

/* Ini set
----------------- */
ini_set('default_charset', 'UTF-8');

/* Functions
----------------- */
function redirect($to = null)
{
    header("Location: ". BASE_URL . $to);
    die();
}

@session_start();

/* App
----------------- */
require_once 'App/App.php';
require_once 'App/DB.php';
require_once 'App/Arvore.php';
require_once 'App/Elemento.php';
require_once 'App/Alert.php';

new App();