<?php

include_once realpath(dirname(__FILE__) . '/../../lib/lib.inc.php');
include_once realpath(dirname(__FILE__) . '/../../lib/Validacion.php');

class Medico extends Util{

    
    function __construct () {
        parent::__construct ();
    }
    
    public $tabla = "usuario";
    public $pk    = "id";
    public $validar = array();
    public $clases  = array('documento');
    
    /**
     * Funcion que muestra el listado de Perfiles
     * @return void
     */
    function listar() {
        global $db;
    	
        // Database connection
      	$odbconn = MDB2 :: connect($db['dsn'], $db['opts']);
      	$odbconn->setFetchMode(MDB2_FETCHMODE_ASSOC);
    	$sql     = "SELECT id,ARRAY_TO_STRING(ARRAY[nombre1, nombre2, apellido1,apellido2], ' ') as nombre 
                    FROM usuario
                    WHERE activo = '1'
                    AND tipo     = '1'";
    	
    	$pager_options = array(
            'mode'       => 'Sliding',
            'perPage'    => 16,
            'delta'      => 2,
            'extraVars'  => array('a'=> $_REQUEST['a'])
        );
    	
        $data = Pager_Wrapper_MDB2($odbconn, $sql, $pager_options);
        
        // Mensaje a mostrar en el template
        $msj   = flashData();
      	
        include(getTemplate('medico.lista.php'));
        return;
    } 
    
    
     /**
     * Funcion que muestra el formulario para crear perfiles
     * @return void
     */
    function ingresarForm() {
        
        $titulo = "Ingresar Medico";
        
	 // Consulta para el tipo de documento
        $sql        = "SELECT tipo, nombre 
                       FROM  tipo_documento";
        
        $tipo       = $this->queryAll($sql,"normal");
        
        include(getTemplate('medico.nuevo.php'));
        return;
    }
    
   		
    /**
     * Funcion que muestra el listado de Perfiles
     * @return void
     */
    function ingresar() {
        
        // Se aplica la validacion
        foreach($_REQUEST as $key => $valor) {
            $datos[$key] = strtoupper($valor);
        }
        
        // activo 
        $datos['activo'] = '1';
        
        $validar = new Validacion();
        $validar->add($datos['tipo_identificacion'],'tipo_identificacion',Validacion::$validarSoloTexto,1,2,true); 
        $validar->add($datos['numero_documento'],'numero_documento',Validacion::$validarAlfanumerico, 1,20,true);
        $validar->add($datos['nombre1'],'nombre1',Validacion::$validarSoloTexto, 1,40,true);
        $validar->add($datos['nombre2'],'nombre2',Validacion::$validarSoloTexto, 1,40,false);
        $validar->add($datos['apellido1'],'apellido1',Validacion::$validarSoloTexto, 1,40,true);
        $validar->add($datos['apellido2'],'apellido2',Validacion::$validarSoloTexto, 1,40,false);
        $validar->add($datos['registro_medico'],'registro_medico',Validacion::$validarAlfanumerico, 1,16,true);
        $existe = false;
        
        // Valida que no exista el medico en el sistema
        $rst = $this->consultarMedico($_REQUEST['tipo_identificacion'],$_REQUEST['numero_documento']);
        if($rst['id']) {
            $existe = true;
        }
        
        if(!$validar->esValido() || $existe == true) {
            $camposError = $validar->getCamposError();
            foreach($camposError as $valor) {
                $mensaje[$valor[0]] = $valor[1];
            }
            
            if($existe) {
                $mensaje['numero_documento'] = 'El usuario ya existe';
            }
        } else {
            if($this->guardar($datos)) {
                // Mensaje en el template
                $mensaje['mensaje'] = "<div class=\"success\">El medico se ha ingresado exitosamente</div>";
            } else {
                // Mensaje en el template
                $mensaje['mensaje'] = "<div class=\"warning\">Problema al guardar los datos</div>";
            }
            
            flashDataSet($mensaje);
            header('Location: ../../app/medico/medico.php?a=listar');
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
        $sql = "SELECT nombre1,nombre2,apellido1,apellido2,
                tipo_identificacion,numero_documento,id,registro_medico
                FROM {$this->tabla}
                WHERE id = '{$_REQUEST['id']}'";
        $rst = $this->queryRow($sql);
       
        // Variables para el template
        $tipo = $this->Documento->lista();
        
        // Template
        include(getTemplate('medico.editar.php'));
    }
    
    /**
     *Funcion que actualiza el medico 
     */
    function actualizar() {
        $datos = array();
        foreach($_REQUEST as $key => $valor) {
            $datos[$key] = strtoupper($valor);
        }
        
        // Se aplica la validacion
        $validar = new Validacion();
        $validar->add($_REQUEST['tipo_identificacion'],'tipo_identificacion',Validacion::$validarSoloTexto,1,2,true); 
        $validar->add($_REQUEST['numero_documento'],'numero_documento',Validacion::$validarAlfanumerico, 1,20,true);
        $validar->add($_REQUEST['nombre1'],'nombre1',Validacion::$validarSoloTexto, 1,40,true);
        $validar->add($_REQUEST['nombre2'],'nombre2',Validacion::$validarSoloTexto, 1,40,false);
        $validar->add($_REQUEST['apellido1'],'apellido1',Validacion::$validarSoloTexto, 1,40,true);
        $validar->add($_REQUEST['apellido2'],'apellido2',Validacion::$validarSoloTexto, 1,40,false);
        $validar->add($_REQUEST['registro_medico'],'registro_medico',Validacion::$validarAlfanumerico, 1,16,true);
        $existe = false;
        
        // Valida que no exista el medico en el sistema
        $rst = $this->consultarMedico($_REQUEST['tipo_identificacion'],$_REQUEST['numero_documento']);
        if($_REQUEST['id'] != $rst['id'] ) {
            if(!empty($rst['id'])) { 
                $existe = true;
            }
        }
        
        if(!$validar->esValido() || $existe == true) {
            $camposError = $validar->getCamposError();
            foreach($camposError as $valor) {
                $mensaje[$valor[0]] = $valor[1];
            }
            
            if($existe) {
                $mensaje['numero_documento'] = 'El usuario ya existe';
            }
        } else {
            if(parent::actualizar($datos)) {
                // Mensaje en el template
                $mensaje['mensaje'] = "<div class=\"success\">El medico se ha actualizado exitosamente</div>";
            } else {
                // Mensaje en el template
                $mensaje['mensaje'] = "<div class=\"warning\">Problema al guardar los datos</div>";
            }
            
            flashDataSet($mensaje);
            header('Location: ../../app/medico/medico.php?a=listar');
            return;
        }
        
        $respuesta = json_encode($mensaje);
        header( "Content-type: application/json" );
        echo $respuesta;
        return;
    }
    
    /**
     * Funcion que consulta los datos primarios de un medico
     */
    function consultarMedico($tipo, $documento) {
        $sql = "SELECT id,tipo_identificacion,numero_documento,
                nombre1,nombre2,apellido1,apellido2
                FROM {$this->tabla}
                WHERE tipo_identificacion = '{$tipo}'
                AND   numero_documento    = '{$documento}'";
        $rst = $this->queryRow($sql);
        return $rst;
    }
    
    /**
     * 
     */
    function lista($id = NULL) {
        //$sql = "SELECT id, ARRAY_TO_STRING(ARRAY[nombre1, nombre2, apellido1,apellido2], ' ') as nombre  FROM {$this->tabla}";
        $sql = "SELECT id, ARRAY_TO_STRING(ARRAY[nombre1, nombre2, apellido1,apellido2], ' ') as nombre  FROM usuario WHERE tipo = '1' ";
        if($id) {
            $sql .= " AND id = '{$id}'";
        }
        
        $rst = $this->queryAll($sql,"normal");
        return $rst;
    }
    
    /**
     * Funcion para eliminar 
     */
    function eliminar($id) {
        $sql = "DELETE FROM {$this->tabla} WHERE id = '{$id}'";
        
        $rst = $this->query($sql);
        if($rst) {
           $mensaje['mensaje'] = "<div class=\"success\">El medico se ha eliminado exitosamente</div>"; 
        } else {
            if($this->error['codigo'] == -1) {
                $mensaje['mensaje'] = "<div class=\"warning\">El medico esta referenciado en otras tablas y no se puede eliminar</div>";
            } else {
                $mensaje['mensaje'] = "<div class=\"warning\">Problema al eliminar los datos</div>";
            }
        }
        
        flashDataSet($mensaje);
        header('Location: ../../app/medico/medico.php?a=listar');
    }
    
    function getMedico($id) {
        $sql     = "SELECT id,ARRAY_TO_STRING(ARRAY[nombre1, nombre2, apellido1,apellido2], ' ') as nombre 
                    FROM usuario
                    WHERE id = '{$id}'";
        $rst     =  $this->queryRow($sql);
        return $rst;
    }
    
}
?>