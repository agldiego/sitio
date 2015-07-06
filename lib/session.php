<?php
    session_start();
    if(!isset($_SESSION['flashdata'])) {
       $_SESSION['flashdata'] = array(); 
    }
    
    function flashDataSet($arreglo) {
        
        foreach($arreglo as $key => $valor) {
            $_SESSION['flashdata'][$key] = $valor; 
        }
        return;
    }
    
        
    function flashData() {
        $dato = $_SESSION['flashdata'];
        $_SESSION['flashdata'] = array();
        return $dato;
    }
?>
