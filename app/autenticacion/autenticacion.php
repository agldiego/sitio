<?php
define('NO_AUTH', true);
include_once realpath(dirname(__FILE__) . '/../../lib/lib.inc.php');

/**
 * Check the login and password
 * @return void
 */
function login() {
    global $db;
    
    $usuario  = sanitize($_POST['usuario']);
    $clave    = sanitize($_POST['clave']);
    
    $sql      = "SELECT id,usuario,nombre1,apellido1,id_rol,tipo
                FROM usuario 
                WHERE usuario = '{$usuario}'
                AND   clave   = MD5('{$clave}')";
                
    $odbconn = MDB2::connect ( $db ['dsn'], $db ['opts'] );
    $odbconn->setFetchMode ( MDB2_FETCHMODE_ASSOC );
    
    $rst = $odbconn->queryRow($sql);
    $odbconn->disconnect();
    if (PEAR :: isError($rst)) {
        return false;
    }

    if ($rst) {
        session_start();
        $_SESSION['user']['startTime']      = date("Y-m-d H:i");
        $_SESSION['user']['id_usuario']     = $rst['id'];
        $_SESSION['user']['usuario']        = $rst['usuario'];
        $_SESSION['user']['nombres']        = $rst['nombre1'];
        $_SESSION['user']['apellidos']      = $rst['apellido1'];
        $_SESSION['user']['rol']            = $rst['id_rol'];
        $_SESSION['user']['tipo']           = $rst['tipo'];
        $Modulo                             = New Modulo();
        $_SESSION['perms']                  = $Modulo->getModulosPermitidos($rst['id_rol']);
        
        header('Location: ../../index.php');
    } else {
        header("Location: ../../login.php?login=false");
    }
}
login();
?>