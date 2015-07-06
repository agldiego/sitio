<?php
/**
 * Librerias requeridas para el funcionamiento
 * general de la aplicacion
 */
include_once realpath(dirname(__FILE__) . '/conf.main.php');
require_once realpath(dirname(__FILE__) . '/Util.class.php');
require_once realpath(dirname(__FILE__) . '/pear/PEAR.php');
require_once realpath(dirname(__FILE__) . '/MDB2.php');
include_once realpath(dirname(__FILE__) . '/Pager/Pager.php');
include_once realpath(dirname(__FILE__) . '/Pager/Sliding.php');
require_once realpath(dirname(__FILE__) . '/Pager_Wrapper.php');
require_once realpath(dirname(__FILE__) . '/session.php');
require_once realpath(dirname(__FILE__) . '/Modulo.class.php');
require_once realpath(dirname(__FILE__) . '/swiftmailer/lib/swift_required.php');
//require_once 'MDB2.php';

ini_set('include_path', '/pear/lib' . PATH_SEPARATOR
        . ini_get('include_path'));

if (!defined('NO_AUTH')) {
    include_once realpath(dirname(__FILE__) . '/autorizacion.php');
}

/**
 * Return the template Path
 * Receives a string separated with "/" Slash
 * @param string path
 * @return string
 */
function getTemplate($path) {
    global $fileupd;

    $list = explode('/', $path);
    $realPath = $fileupd['webroot'] . SEPARATOR . TEMPLATE;
    for ($i = 0; $i < sizeof($list); $i++) {
        $realPath = $realPath . SEPARATOR . $list[$i];
    }

    return $realPath;
}

/**
 * Muestra un mensaje de informacion del sistema
 */
function infoMessage($title, $message) {
    //include getTemplate('fheader.php');
    print_title($title, '98%');
    echo '<p align="center">' . $message . '</p>';
    exit;
}

/** Imprime un titulo agradable para un formulario HTML */
function print_title($stitle, $swidth = "100%")
{
  echo "<table width=\"$swidth\" align=\"center\"><tr><td align=\"right\" class=\"Tahoma12_bold\"><hr size=1 color=\"#000000\" noshade><span class=\"title\"><b>$stitle</b></span><hr size=1 color=\"#000000\" noshade></td></tr></table>\n";
}

/**
 * Funcion que muestra un select
 */
function print_selectmenu($aitems, $sname, $nselectedid = "", $sextrahtml = "",$idv=null)
{
  // Deja en blanco el primer elemento del arreglo
    array_unshift($aitems, array("", "- - -"));

  echo "<select name=\"$sname\" class=\"formulario\" {$sextrahtml}   id = '{$idv}' >";

  for ($i = 0; $i < count($aitems); $i++) {
       if (strcmp(strval($aitems[$i][0]),strval($nselectedid)) == 0)
           echo "<option value=\"".$aitems[$i][0]."\" selected>".$aitems[$i][1]."\n";
       else
           echo "<option value=\"".$aitems[$i][0]."\">".$aitems[$i][1]."\n";
  }
  echo "</select>";
}

/**
 * Funcion que recibe un matriz y la retorna
 * como un vector donde el codigo es su indice.
 */
function arregloLista($arreglo) {
    
    foreach($arreglo as $valor) {
        $vector[$valor[0]] = $valor[1];
    }
    return $vector;
    
}

/**
 * Funcion que imprime el valor de una variable si esta definida
 * @param type $nombre
 * @param type $arreglo
 * @return type 
 */
function imprimir($nombre,$arreglo) {
  if(isset($arreglo[$nombre])) {
      echo $arreglo[$nombre];
  }
  return;
}

/**
 * Funcion que retorna el valor de una variable si esta definida
 * @param type $nombre
 * @param type $arreglo
 * @return type 
 */
function retornar($nombre) {
  if(isset($_REQUEST[$nombre])) {
      return $_REQUEST[$nombre];
  }
  return;
}

/**
* Limpia espacios vacios de un array
* y le aplica html_entity_decode
* @param array $array Datos limpios
* @return array
*/
function htmldecode($array){
    if(is_array($array)) {
        foreach ($array as $clave => $valor) {
            if (is_array($valor)) {
                foreach ($valor as $clave2 => $valor2) {
                    $newArray[$clave][$clave2] = html_entity_decode(trim($valor2));
                }
            } else {
                $newArray[$clave] = html_entity_decode(trim($valor));
            }
        }
    } else {
        $newArray = html_entity_decode(trim($array));     
    }
    unset($array);
    return $newArray;
}

/**
    * Funcion que convierte una fecha D-M-A a A-M-D
    * @param type $date
    * @return type $date
    */
function toYMD($date) {
    $new_date = explode('-', $date);
    $result = "{$new_date[2]}-{$new_date[1]}-{$new_date[0]}";
    return $result;
}

/**
    * Funcion que convierte una fecha A-M-D a D-M-A
    * @param type $date
    * @return type $date
    */
function toDMY($date) {
    if($date) {
        $new_date = explode('-', $date);
        $result = "{$new_date[2]}-{$new_date[1]}-{$new_date[0]}";
        return $result;
    }
    return;
}

/**
    *
    * @param type $input
    * @return type 
    */
function sanitize($input) {
    if (is_array($input)) {
        foreach($input as &$value) {
            $value = sanitize($value);
        }
        return $input;
    } else {
        return htmlentities($input, ENT_QUOTES,"UTF-8");
    }
}

   /**
    * Obtiene el id del usuario
    * @return type 
    */
function getUserId() {
    return $_SESSION['user']['id_usuario'];
}

/**
 * 
 */
function getUserNombre() {
     $nombre = $_SESSION['user']['nombres']. ' '. $_SESSION['user']['apellidos'];
     return $nombre;
}

function esMedico() {
    if($_SESSION['user']['tipo'] == '1') {
        return TRUE;
    } else {
        return FALSE;
    }
}
?>