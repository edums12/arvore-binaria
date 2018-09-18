<?php 

/* Defines
----------------- */
define('APPPATH', dirname(__FILE__));

define('DS', DIRECTORY_SEPARATOR);

/* Ini set
----------------- */
ini_set('default_charset', 'UTF-8');

/* App
----------------- */
require_once 'App/App.php';
require_once 'App/Arvore.php';
require_once 'App/Elemento.php';
require_once 'App/Ordem.php';

new App();