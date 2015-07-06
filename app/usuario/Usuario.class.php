<?php

include_once realpath(dirname(__FILE__) . '/../../lib/lib.inc.php');
include_once realpath(dirname(__FILE__) . '/../../lib/Validacion.php');

class Usuario extends Util {
    function __construct () {
        parent::__construct ();
    }
    
    public $tabla = "usuario";
    public $pk    = "id";
    public $validar = array();
    public $clases  = array('documento','perfil');
    
    /**
     * Funcion que muestra el listado de Perfiles
     * @return void
     */
    function listar() {
        global $db;
    	
        // Database connection
      	$odbconn = MDB2 :: connect($db['dsn'], $db['opts']);
      	$odbconn->setFetchMode(MDB2_FETCHMODE_ASSOC);
    	$sql     = "SELECT id,ARRAY_TO_STRING(ARRAY[nombre1,nombre2,apellido1,apellido2], ' ') as nombre 
                    FROM {$this->tabla}
                    WHERE activo = '1'";
    	
    	$pager_options = array(
            'mode'       => 'Sliding',
            'perPage'    => 16,
            'delta'      => 2,
            'extraVars'  => array('a'=> $_REQUEST['a'])
        );
    	
        $data = Pager_Wrapper_MDB2($odbconn, $sql, $pager_options);
        
        // Mensaje a mostrar en el template
        $msj   = flashData();
      	
        include(getTemplate('usuario.lista.php'));
        return;
    } 
    
    /**
     * Funcion que muestra el formulario para crear perfiles
     * @return void
     */
    function ingresarForm() {
        // template
        // Consulta para el tipo de documento
        $sql        = "SELECT tipo, nombre 
                       FROM  tipo_documento";
        
        $tipo       = $this->queryAll($sql,"normal");
        
        $perfil = $this->Perfil->lista();
        include(getTemplate('usuario.nuevo.php'));
        return;
    }
    
    /**
     * Funcion para guardar los datos
     * @return void
     */
    function ingresar() {
        
        // Se aplica la validacion
        $datos             = array();
        $datos['tipo_identificacion'] = $_REQUEST['tipo_identificacion'];
        $datos['numero_documento']    = $_REQUEST['numero_documento'];
        $datos['nombre1']   = strtoupper($_REQUEST['nombre1']);
        $datos['nombre2']   = strtoupper($_REQUEST['nombre2']);
        $datos['apellido1'] = strtoupper($_REQUEST['apellido1']);
        $datos['apellido2'] = strtoupper($_REQUEST['apellido2']);
        $datos['id_rol']   = $_REQUEST['id_rol'];
        $datos['usuario']  = $_REQUEST['usuario'];
        $datos['clave']    = $_REQUEST['clave'];
        $datos['cclave']   = $_REQUEST['cclave'];
        
        if(isset($_REQUEST['tipo'])) {
            $datos['tipo']              = $_REQUEST['tipo'];
            $datos['registro_medico']   = $_REQUEST['registro_medico'];
        }
        
        $existe            = false;
        $diferente         = false;
        
        $validar = new Validacion();
        $validar->add($datos['tipo_identificacion'],'tipo_identificacion',Validacion::$validarSoloTexto,1,2,true); 
        $validar->add($datos['numero_documento'],'numero_documento',Validacion::$validarAlfanumerico, 1,20,true);
        $validar->add($datos['nombre1'],'nombre1',Validacion::$validarSoloTextoConEspacios, 1,40,true);
        $validar->add($datos['nombre2'],'nombre2',Validacion::$validarSoloTextoConEspacios, 1,40,false);
        $validar->add($datos['apellido1'],'apellido1',Validacion::$validarSoloTextoConEspacios, 1,40,true);
        $validar->add($datos['apellido2'],'apellido2',Validacion::$validarSoloTextoConEspacios, 1,40,false);
        $validar->add($datos['usuario'],'usuario',Validacion::$validarAlfanumerico, 1,30,true);
        $validar->add($datos['clave'],'clave',Validacion::$validarAlfanumerico, 1,30,true);
        $validar->add($datos['cclave'],'cclave',Validacion::$validarAlfanumerico, 1,30,true);
        if($datos['tipo']) {
            $validar->add($datos['registro_medico'],'registro_medico',Validacion::$validarAlfanumerico, 1,16,true);
        }
        
        // Valida que no exista el medico en el sistema
        $rst = $this->consultarUsuario($datos['usuario']);
        if($rst['id']) {
            $existe = true;
        }
        
        if(strcmp ($datos['clave'],$datos['cclave'] ) != 0) {
            $diferente = true;
        }
        
        if(!$validar->esValido() || $existe == true || $diferente == true) {
            $camposError = $validar->getCamposError();
            foreach($camposError as $valor) {
                $mensaje[$valor[0]] = $valor[1];
            }
            
            if($existe) {
                $mensaje['usuario'] = 'El usuario ya existe';
            }
            if($diferente == true) {
                $mensaje['cclave'] = 'Las claves no coinciden';
            }
        } else {
            $datos['clave'] = md5($datos['clave']);
            if($this->guardar($datos)) {
                // Mensaje en el template
                $mensaje['mensaje'] = "<div class=\"success\">El usuario se ha ingresado exitosamente</div>";
            } else {
                // Mensaje en el template
                $mensaje['mensaje'] = "<div class=\"warning\">Problema al guardar los datos</div>";
            }
            
            flashDataSet($mensaje);
            header('Location: ../../app/usuario/usuario.php?a=listar');
            return;
        }
        
        $respuesta = json_encode($mensaje);
        header( "Content-type: application/json" );
        echo $respuesta;
        return;
    }
    
    /**
     *Formulario de actualizacion 
     */
    function actualizarForm() {
        
        // Datos del medico
        $sql = "SELECT *
                FROM {$this->tabla}
                WHERE id = '{$_REQUEST['id']}'";
        $rst = $this->queryRow($sql);
       
        $perfil = $this->Perfil->lista();
        
         // Consulta para el tipo de documento
        $sql        = "SELECT tipo, nombre 
                       FROM  tipo_documento";
        
        $tipo       = $this->queryAll($sql,"normal");
        
        // Template
        include(getTemplate('usuario.editar.php'));
    }
    
    /**
     *  Funcion para actualizar Datos
     * @return type 
     */
    function actualizarDatos() {
        // Se aplica la validacion
        $datos             = array();
        $datos['id']       = $_REQUEST['id'];
        $datos['tipo_identificacion'] = $_REQUEST['tipo_identificacion'];
        $datos['numero_documento']    = $_REQUEST['numero_documento'];
        $datos['nombre1']   = strtoupper($_REQUEST['nombre1']);
        $datos['nombre2']   = strtoupper($_REQUEST['nombre2']);
        $datos['apellido1'] = strtoupper($_REQUEST['apellido1']);
        $datos['apellido2'] = strtoupper($_REQUEST['apellido2']);
        $datos['id_rol']   = $_REQUEST['id_rol'];
        
         if(isset($_REQUEST['tipo'])) {
            $datos['tipo']              = $_REQUEST['tipo'];
            $datos['registro_medico']   = $_REQUEST['registro_medico'];
        }
        
        $diferente         = false;
         
        if(!empty($_REQUEST['clave'])) {
            $datos['clave']    = $_REQUEST['clave'];
            $datos['cclave']   = $_REQUEST['cclave'];
            
            if(strcmp ($datos['clave'],$datos['cclave'] ) != 0) {
                $diferente = true;
            }
        }
        
        $validar = new Validacion();
        $validar->add($datos['tipo_identificacion'],'tipo_identificacion',Validacion::$validarSoloTexto,1,2,true); 
        $validar->add($datos['numero_documento'],'numero_documento',Validacion::$validarAlfanumerico, 1,20,true);
        $validar->add($datos['nombre1'],'nombre1',Validacion::$validarSoloTextoConEspacios, 1,40,true);
        $validar->add($datos['nombre2'],'nombre2',Validacion::$validarSoloTextoConEspacios, 1,40,false);
        $validar->add($datos['apellido1'],'apellido1',Validacion::$validarSoloTextoConEspacios, 1,40,true);
        $validar->add($datos['apellido2'],'apellido2',Validacion::$validarSoloTextoConEspacios, 1,40,false);
        
        if(isset($datos['clave'])){
            $validar->add($datos['clave'],'clave',Validacion::$validarAlfanumerico, 1,30,true);
            $validar->add($datos['cclave'],'cclave',Validacion::$validarAlfanumerico, 1,30,true);
        }
        
        if($datos['tipo']) {
            $validar->add($datos['registro_medico'],'registro_medico',Validacion::$validarAlfanumerico, 1,16,true);
        }
        
        if(!$validar->esValido() || $diferente == true) {
            $camposError = $validar->getCamposError();
            foreach($camposError as $valor) {
                $mensaje[$valor[0]] = $valor[1];
            }
            
            if($diferente == true) {
                $mensaje['cclave'] = 'Las claves no coinciden';
            }
        } else {
            $datos['clave'] = md5($datos['clave']);
            if($this->actualizar($datos)) {
                // Mensaje en el template
                $mensaje['mensaje'] = "<div class=\"success\">El usuario se ha actualizado exitosamente</div>";
            } else {
                // Mensaje en el template
                $mensaje['mensaje'] = "<div class=\"warning\">Problema al guardar los datos</div>";
            }
            
            flashDataSet($mensaje);
            header('Location: ../../app/usuario/usuario.php?a=listar');
            return;
        }
        
        $respuesta = json_encode($mensaje);
        header( "Content-type: application/json" );
        echo $respuesta;
        return;
    }
    
    function consultarUsuario($usuario) {
        $sql = "SELECT id,nombre1,apellido1,usuario
                FROM {$this->tabla}
                WHERE usuario = '{$usuario}'";
        $rst = $this->queryRow($sql);
        return $rst;
    }
    
    /**
     * Funcion para cambiar el password
     * return void 
     */
    function cambiarPasswordForm() {
        // Template
        include(getTemplate('usuario.password.php'));
    }
    
    /**
     *  Funcion que actualiza el password
     */
    function cambiarPassword() {
        $datos['clave']    = $_REQUEST['clave'];
        $datos['cclave']   = $_REQUEST['cclave'];
        $datos['id']       = getUserId();
        $diferente         = false;
        
        $validar = new Validacion();
        $validar->add($datos['clave'],'clave',Validacion::$validarAlfanumerico, 1,30,true);
        $validar->add($datos['cclave'],'cclave',Validacion::$validarAlfanumerico, 1,30,true);
        
        if(strcmp ($datos['clave'],$datos['cclave'] ) != 0) {
            $diferente = true;
        }
        
        if(!$validar->esValido() || $diferente == true) {
            $camposError = $validar->getCamposError();
            foreach($camposError as $valor) {
                $mensaje[$valor[0]] = $valor[1];
            }
            
            if($diferente == true) {
                $mensaje['cclave'] = 'Las claves no coinciden';
            }
        } else {
            $datos['clave'] = md5($datos['clave']);
            if($this->actualizar($datos)) {
                // Mensaje en el template
                $mensaje['status']  = '1';
                $mensaje['mensaje'] = "<div class=\"success\">Clave actualizada exitosamente</div>";
            } else {
                // Mensaje en el template
                $mensaje['mensaje'] = "<div class=\"warning\">Problema al actualizar los datos</div>";
            }
        }
        
        $respuesta = json_encode($mensaje);
        header( "Content-type: application/json" );
        echo $respuesta;
        return;
    }
    
    /**
     *  Listado de Usuarios
     * @return 
     */
    function lista() {
        $sql = "SELECT id, ARRAY_TO_STRING(ARRAY[nombre1, nombre2, apellido1,apellido2], ' ') as nombre  FROM usuario";
        $rst = $this->queryAll($sql,"normal");
        return $rst;
    }
    
    /**
     * Funcion que obtiene el nombre de la persona
     * @param type $id
     * @return type 
     */
    function getNombre($id) {
        $sql = "SELECT id, ARRAY_TO_STRING(ARRAY[nombre1, nombre2, apellido1,apellido2], ' ') as nombre  
                  FROM usuario 
                  WHERE id = '{$id}'";
        $rst = $this->queryRow($sql);
        return $rst['nombre'];
    }
}
?>