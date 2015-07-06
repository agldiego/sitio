<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Math
 *
 * @author yeison
 */
class Math {
  
    //Clase base para la validación de datos comunes
    
    public function validarSoloTexto($min,$max,$cadena)
    {
      return (preg_match("/^[a-zA-Z]{{$min},{$max}}+$/i",$cadena));            
    }
    
    public function validarSoloTextoConEspacios($min,$max,$cadena)
    {
      return (preg_match("/^[a-zA-Z\s]{{$min},{$max}}+$/i",$cadena));
    }
    
    public function validarAlfanumerico($min,$max,$cadena)
    {
       return (preg_match("/^[a-z0-9ñ\,\(\)\.\á\é\í\ó\ú]{{$min},{$max}}+$/i",$cadena));
    }
    
    public function validarAlfanumericoConEspacios($min,$max,$cadena)
    {
       return (preg_match("/^[\w ñ Ñ \,\(\)\.\á\é\í\ó\ú\Á\É\Í\Ó\Ú\"\'\-]{{$min},{$max}}+$/i",$cadena));
    }
    
    public function validarNumeros($min,$max,$cadena)
    {
       return (preg_match("/^[[:digit:]]{{$min},{$max}}+$/",$cadena));
    }
    
    public function validarNumerosConEspacios($min,$max,$cadena)
    {
       return (preg_match("/^[0-9\s]{{$min},{$max}}+$/i",$cadena));
    }
    
    public function validarReal($min,$max,$cadena)
    {
       return (preg_match("/^[0-9]{{$min},{$max}}+[\.]+[0-9]+$/i",$cadena)); 
    }	


    public function ValidarFecha($min,$max,$date) {
        $date = str_replace('/', '-', $date);
        if (preg_match('/^\d{1,2}\-\d{1,2}\-\d{4}$/', $date)) {
            $new_date = explode('-', $date);
            $result = checkdate($new_date[1], $new_date[0], $new_date[2]);
            return $result;
	} else {
            return false;
	}
    }
    
    public function validarEmail($min,$max = NULL,$cadena = NULL)
    {
       return (preg_match("/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/",$cadena)); 
    }
    
    public function validarSoloObligatorio($min, $max, $cadena) {
        if($cadena) {
            $total = strlen($cadena);
            if($total >= $min && $total <= $max) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
?>