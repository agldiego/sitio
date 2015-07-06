<?php

include_once realpath(dirname(__FILE__) . '/Usuario.class.php');

$Usuario = new Usuario();

switch ($_REQUEST['a']) {
    case 'listar':
        permisos(USUARIOS, 'r');
        $Usuario->listar();
        break;
    case 'ingresarForm':
        permisos(USUARIOS, 'w');
        $Usuario->ingresarForm();
        break;
     case 'ingresar':
        permisos(USUARIOS, 'w');
        $Usuario->ingresar();
        break;
    case 'actualizarForm':
        permisos(USUARIOS, 'u');
        $Usuario->actualizarForm();
        break;
    case 'actualizar':
        permisos(USUARIOS, 'u');
        $Usuario->actualizarDatos();
        break;
    case 'cambiarPasswordForm':
        //permisos(USUARIOS, 'u');
        $Usuario->cambiarPasswordForm();
        break;
    case 'cambiarPassword':
        //permisos(USUARIOS, 'u');
        $Usuario->cambiarPassword();
        break;
}
?>