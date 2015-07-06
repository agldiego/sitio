<?php
define('USUARIOS', 1);
define('CONFIGURACION', 2);
define('CITAS', 3);
define('CONSULTAS', 4);
define('ADMISION', 5);
define('REPORTES', 6);


class Modulo extends Util{
    public $modulos;
    function __construct () {
        parent::__construct ();
       $this->modulos = array (array ('Administraci&oacute;n de Usuarios y Perfiles', USUARIOS),
                               array ('Configuraci&oacute;n', CONFIGURACION),
                               array ('Citas', CITAS),
                               array ('Consultas', CONSULTAS),
                               array ('Admision', ADMISION),
                               array ('Reportes', REPORTES)
                              );

        sort($this->modulos);
    }
    
    public $tabla   = "rol_detalle";
    public $pk      = "id";
    
    /**
     * Retorna  los modulos
     * @return array
     */
    function getModulos() {
        return $this->modulos;
    }

    /**
     * Retorna los modulos permitido
     * @return array
     */
    function getModulosPermitidos($id) {
        $sql = "SELECT modulo,leer,escribir,
                modificar, eliminar
                FROM rol_detalle
                WHERE id_rol = ". $id;
       
        $result = $this->queryAll($sql,'normal');
        return $result;
    }
}
?>