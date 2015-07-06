<?php

class Util {
	
	
	public $tabla   = "";
	public $errores = array();
	public $error   = array();
	public $pk      = "";
        public $debug   = FALSE;
        public $clases;
        
	function __construct() {
	
            $this->loader();
	}
        
        
        public function loader() {
            if (is_array($this->clases)) {
                foreach ($this->clases as $valor) {  
                    
                    if(is_array($valor)) {
                        $this->instanciar(strtolower($valor['modulo']),ucfirst($valor['clase']));
                        
                    } else {
                        $this->instanciar(strtolower($valor),ucfirst($valor));
                    }
                }
            }
            $this->clases = '';
        }
        
     
        private function instanciar($modulo,$clase) {
            global $fileupd;
            $ruta = "{$fileupd['webroot']}app/{$modulo}/{$clase}.class.php";
            if (file_exists($ruta)) {
                require_once ($ruta);
                eval("\$this->$clase = new $clase();");
            } else {
                die ('<b>ERROR FATAL</b>: El archivo <strong>' . $ruta . '</strong> no esta incluido en el sistema');
                return false;
            }
        }
        
        function agregarIndice($datos) {
		global $db;
		$odbconn = MDB2::connect ( $db ['dsn'], $db ['opts'] );
		$odbconn->setFetchMode ( MDB2_FETCHMODE_ASSOC );
		$sql = "SELECT column_name AS field 
                        FROM information_schema.columns 
                        WHERE table_name = '{$this->tabla}'
                       order by ordinal_position";
		$rst = $odbconn->queryAll ( $sql );
		$odbconn->disconnect();
                
                $arreglo = array();
                $contador = 0;
		foreach ( $rst as $valor ) {
                    $campos .= $valor['field'];
                    $arreglo[$valor['field']] = $datos[$contador][0]; 
                    $contador++;
		}
                return $arreglo;
	}
        
	
	function guardar($datos) {
		global $db;
		$odbconn = MDB2::connect ( $db ['dsn'], $db ['opts'] );
		$odbconn->setFetchMode ( MDB2_FETCHMODE_ASSOC );
		$sql = "SELECT column_name AS field FROM information_schema.columns WHERE table_name = '{$this->tabla}'";
		$rst = $odbconn->queryAll ( $sql );
		
                // Campo utilizado por el sistema 
                $datos['fecha_creacion'] = date("Y-m-d H:i:s");
                
		$sql = "INSERT INTO {$this->tabla}(";
		
		$campos  = "";
		$valores = "";
		
		foreach ( $rst as $valor ) {
			if (isset($datos[$valor['field']])) {
                            if(!empty($datos[$valor['field']])) {
                                $campos .= "{$valor['field']},";
                                $valores .= "'{$datos[$valor['field']]}',";
                            }
                            
			}
		}
		$campos = substr ( $campos, 0, (strlen ( $campos ) - 1) );
		$valores = substr ( $valores, 0, (strlen ( $valores ) - 1) );
		$sql .= "{$campos}) VALUES({$valores})";

                if($this->debug == TRUE) {
                    echo $sql."<br>";
                }
               
		$rst = $odbconn->query ( $sql );
		$odbconn->disconnect();
		$debug = debug_backtrace();
		if (PEAR :: isError($rst)) {
			print_r($debug);
    		$odbconn->disconnect();
      		infoMessage('Error Cr&iacute;tico en la aplicaci&oacute;n',
                  "<b>Error::</b>: Select Query Problem: ".$sql.$rst->getMessage(), '90%', 1);
      		return false;
                }
                
		return true;
	}
	
	function actualizar($datos) {
		global $db;
		$odbconn = MDB2::connect ( $db ['dsn'], $db ['opts'] );
		$odbconn->setFetchMode ( MDB2_FETCHMODE_ASSOC );
		$sql = "SELECT column_name AS field FROM information_schema.columns WHERE table_name = '{$this->tabla}'";
		$rst = $odbconn->queryAll ( $sql );
		
                // Campo utilizado por el sistema 
                $datos['fecha_modificacion'] = date("Y-m-d H:i:s");
                
		$sql = "UPDATE {$this->tabla} SET ";
		
		$campos  = "";
		$where   = "";
		
		foreach ( $rst as $valor ) {
			if (isset($datos[$valor['field']])) {
				if($this->pk == $valor['field']) {
					$where = " {$this->pk} = '{$datos[$valor['field']]}' ";
				} else {
                                        if(strlen(trim($datos[$valor['field']])) > 0) {
                                            $campos .= "{$valor['field']} = '{$datos[$valor['field']]}',";
                                        } else {
                                            $campos .= "{$valor['field']} = NULL,";
                                        }
				}
			}
		}
		$campos = substr ( $campos, 0, (strlen ( $campos ) - 1) );
		$sql .= "{$campos} WHERE {$where}";
		 
                if($this->debug == TRUE) {
                    echo $sql."<br>";
                }
                
		$rst = $odbconn->query ( $sql );
		$odbconn->disconnect();
		$debug = debug_backtrace();
		if (PEAR :: isError($rst)) {
                    print_r($debug);
                    $odbconn->disconnect();
                    infoMessage('Error Cr&iacute;tico en la aplicaci&oacute;n',
                    "<b>Error::</b>: Select Query Problem: ".$sql.$rst->getMessage(), '90%', 1);
                    return false;
                }
		return true;
	}
	
	function query($sql) {
		global $db;
		$odbconn = MDB2::connect ( $db ['dsn'], $db ['opts'] );
		$rst = $odbconn->query($sql);
		$odbconn->disconnect();
		if (PEAR :: isError($rst)) {
                    
                        /*
			$debug = debug_backtrace();
			print_r($debug);
			infoMessage('Error Cr&iacute;tico en la aplicaci&oacute;n',
                        "<b>Error::</b>: Select Query Problem: ".$sql.$rst->getMessage(), '90%', 1);
                         */
                    
                    $this->error['codigo']  =  $rst->getCode();
                    $this->error['mensaje'] =  $rst->getMessage();    
                         
                    return false;
                }
		return $rst;
	}
	
	function queryRow($sql, $modo = null) {
		global $db;
		$odbconn = MDB2::connect ( $db ['dsn'], $db ['opts'] );
		if(!$modo){
			$odbconn->setFetchMode ( MDB2_FETCHMODE_ASSOC );
		}
		
		$rst = $odbconn->queryRow($sql);
		$odbconn->disconnect();
		if (PEAR :: isError($rst)) {
			$debug = debug_backtrace();
			print_r($debug);
			infoMessage('Error Cr&iacute;tico en la aplicaci&oacute;n',
                  "<b>Error::</b>: Select Query Problem: ".$sql.$rst->getMessage(), '90%', 1);
      		return false;
                }
		return $rst;
		
	}
	
	function queryAll($sql, $modo = null) {
		global $db;
		$odbconn = MDB2::connect ( $db ['dsn'], $db ['opts'] );
		if(!$modo){
			$odbconn->setFetchMode ( MDB2_FETCHMODE_ASSOC );
		}
		
		$rst = $odbconn->queryAll($sql);
		$odbconn->disconnect();
		if (PEAR :: isError($rst)) {
			$debug = debug_backtrace();
			print_r($debug);
			infoMessage('Error Cr&iacute;tico en la aplicaci&oacute;n',
                  "<b>Error::</b>: Select Query Problem: ".$sql.$rst->getMessage(), '90%', 1);
      		return false;
                }
		return $rst;	
	}
	
        
	/**
	 * Funcion que cambia la tabla relacionada a la clase
	 * @param $tabla string
	 * @return bool
	 */
	function setTabla($tabla) {
		$this->tabla = $tabla;
		return true;
	}
	
	/**
	 * Funcion que cambia la clave primaria relacionada a la clase
	 * @param $pk string
	 * @return bool
	 */
	function setPk($pk) {
		$this->pk = $pk;
		return true;
	}
	
	
	/**
	 * Funcion que crear un arreglo con codigo de indice y nombre de valor
	 * @param $array array
	 * @return array
	 */
	function crearLista($array) {
		if(is_array($array)) {
			foreach($array as $valor) {
				$lista[$valor[0]] = $valor[1]; 
			}
			return $lista;
		} 
		return array(array());
	}
        
        
        /**
         * Funcion para validar los datos de un formulario
         * @param type $dato
         * @param type $regla 
         */
        function validarForm($dato,$regla) {
            
            foreach($regla as $valor){
            
                if(isset($valor['obligatorio'])) {
                    
                    // Valida si el campo es obligatorio
                    if($valor['obligatorio'] == TRUE) {
                        if(empty($_REQUEST[$valor['campo']])) {
                            //$this->errores[$valor['campo']] = "Campo Obligatorio";
                            $this->error[$valor['campo']] = "Campo Obligatorio";
                        }
                    }
                }
            }
            //return $this->errores;
            return $this->error;
        }
        
        
        function mensajeVal($nombre) {
            if(isset($this->error[$nombre])) {
                echo $this->error[$nombre];
            }
            return;
        }
        
}
?>