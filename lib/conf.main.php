<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    
    // Ruta de la aplicacion en el servidor
    
    //$fileupd['webroot'] = "c:/wamp/www/salud/trunk/";
    $ruta = str_replace('\\','/',dirname(__DIR__.'../'));
    $fileupd['webroot'] = "{$ruta}/";
    $fileupd['logo']    = "{$ruta}/upload";
    
 
    /* Database Parameters */
    $db['motor']        = "pgsql";  // Motor de postgresql
    $db['host']         = "localhost";
    $db['port']         = "5432";
    $db['name']         = "salud";
    $db['user']         = "postgres";
    $db['pass']         = "root";
    $db['opts']         = array('debug' => 0);
    $db['pagesize']     = 15; //Number of registrations for page when a listing process is executed
    $db['dsn']          = "pgsql://".$db['user'].":".$db['pass']."@".$db['host']."/".$db['name'];
    
    
    // Establece la zona horaria
    date_default_timezone_set("America/Bogota");


/**
 * Plantilla tomada por defecto
 */
define('TEMPLATE', 'tpl');

// Dependiendo del sistema operativo:
if (!defined('SEPARATOR')){
    define('SEPARATOR', (substr(PHP_OS, 0, 3) == 'WIN' ? '\\' : '/'), true);
}
?>