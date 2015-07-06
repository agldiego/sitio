<?php

include_once realpath(dirname(__FILE__) . '/Medico.class.php');

$Medico = new Medico();

switch ($_REQUEST['a']) {
    case 'listar':
        permisos(CONFIGURACION, 'r');
        $Medico->listar();
        break;
    case 'ingresarForm':
        permisos(CONFIGURACION, 'w');
        $Medico->ingresarForm();
        break;
     case 'ingresar':
        permisos(CONFIGURACION, 'w');
        $Medico->ingresar();
        break;
    case 'actualizarForm':
        permisos(CONFIGURACION, 'u');
        $Medico->actualizarForm();
        break;
    case 'actualizar':
        permisos(CONFIGURACION, 'u');
        $Medico->actualizar();
        break;
    case 'eliminar':
        permisos(CONFIGURACION, 'd');
        $Medico->eliminar($_REQUEST['id']);
        break;
}
?>