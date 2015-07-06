<?php

  include_once 'Math.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Validacion
 *
 * @author yeison
 */
class Validacion extends Math{
        
    public static $validarSoloTexto="validarSoloTexto";
    public static $validarSoloTextoConEspacios="validarSoloTextoConEspacios";
    public static $validarAlfanumerico="validarAlfanumerico";
    public static $validarAlfanumericoConEspacios="validarAlfanumericoConEspacios";   //Variables estaticas que determinan el metodo a ejecutarse
    public static $validarNumeros="validarNumeros";
    public static $validarNumerosConEspacios="validarNumerosConEspacios";    
    public static $validarFecha="validarFecha";    
    public static $validarReal="validarReal";
    public static $validarEmail="validarEmail";
    public static $validarSoloObligatorio="validarSoloObligatorio";

    public $tipo = array('validarSoloTexto'  => 'Campo tipo texto',
                            'validarSoloTextoConEspacios' => 'Campo tipo texto',
                            'validarAlfanumerico'  => 'Campo tipo alfanumerico',
                            'validarAlfanumericoConEspacios' => 'Campo tipo alfanumerico',
                            'validarNumeros' => 'Campo tipo numerico', 
                            'validarNumerosConEspacios' => 'Campo tipo numerico',
                            'validarFecha' => 'Fecha no valida',
			    'validarReal' => 'Campo de tipo decimal',
			    'validarEmail' => 'Correo no valido',
                            'validarSoloObligatorio' => 'Campo Obligatorio'
                            );
	
    private $datos=array();    //Arreglo que incluye cada uno de los valores de los campos
    private $camposError=array(); //Arreglo que incluye todos los id que poseen error de validación de datos.
    private $contador;
    
    function __construct() {
        $this->contador=0;
    }
    
    function add($elemento,$id,$validador,$min,$max,$obligatorio)  //Metodo que permite agregar un elemento para ser validado
    {      
		
        //$this->datos[$id]=$this->$validador($min,$max,$elemento);  //Dentro de un arreglo cuya clave es el id del elemento se almacena una instancia del metodo de validación con sus respectivos parametros        
        $this->datos[$this->contador]["validacion"]=$this->$validador($min,$max,$elemento);
        $this->datos[$this->contador]["id"]=$id;
        $this->datos[$this->contador]["obligatorio"]=$obligatorio;
        $this->datos[$this->contador]["elemento"]=$elemento;
	$this->datos[$this->contador]["tipo"]=$validador;
        
        $this->contador++;
    }       
    
    function esValido()  // Es valido es un metodo que verifica si en algun campo existe error de validación  y almacena los campos con error
    {        
        $valido=true;        
        
        for($i=0;$i<count($this->datos);$i++)
        {                        
          if($this->datos[$i]["validacion"]==false && $this->datos[$i]["obligatorio"]==true)
          {
             $valido=false;
             $this->camposError[$i][0]=$this->datos[$i]["id"]; 
	     $this->camposError[$i][1]=$this->tipo[$this->datos[$i]["tipo"]];
          }else if($this->datos[$i]["validacion"]==false && $this->datos[$i]["obligatorio"]==false && strlen($this->datos[$i]["elemento"])>0)
          {
             $valido=false;
             $this->camposError[$i][0]=$this->datos[$i]["id"]; 
	     $this->camposError[$i][1]=$this->tipo[$this->datos[$i]["tipo"]];
          }
        }
     
        return $valido;
    }
 
    public function getCamposError() {  //Obtiene el id de los campos con error de validación.
        return $this->camposError;
    }

    
}
?>