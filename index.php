<?php
include_once realpath(dirname(__FILE__) . '/lib/lib.inc.php');
?>
<html>
<head>
<title>TEST</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="tpl/css/style.css" media="screen">
<link type="text/css" href="tpl/css/smoothness/jquery-ui-1.8.20.custom.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="tpl/css/jquery.tablescroll.css"/>
<link type="text/css" rel="stylesheet" href="tpl/css/autocomplete.css" />
<script type="text/javascript" src="tpl/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="tpl/js/jquery-ui-1.8.20.custom.min.js"></script>
<script type="text/javascript" src="tpl/js/jquery.ui.datepicker-es.js"></script>
<script type="text/javascript" src="tpl/js/jquery.form.js"></script>
<script type="text/javascript" src="tpl/js/jquery.tablescroll.js"></script>
<script type="text/javascript" src="tpl/js/util.js"></script>
<script src="tpl/js/autocomplete.jquery.js"></script>
<script src="tpl/js/jquery.jkey-1.2.js"></script>
<script type="text/javascript" src="tpl/js/jquery.dropotron-1.0.js"></script>
<script type="text/javascript" src="tpl/js/jquery.qtip-1.0.0.min.js"></script> 

<script type = "text/javascript">
$(document).ready(function(){
    $(function() {
            $('#menu > ul').dropotron({
                    mode: 'fade',
                    globalOffsetY: 11,
                    offsetY: -15
            });
            
    });
    
        
   $('#menulinks li a').on('click',function() {
    var href = $(this).attr("data-link");
    var confirmed = false;
    if(preguntar) {
        confirmed = window.confirm("Esta seguro de salir sin guardar?");
        if(confirmed) {
            preguntar = false;
            $("#resultado").load(href);
        }
    } else {
        $("#resultado").load(href);
    }
    return false;
   });
     
   $("#cargando").ajaxStart(function(){
        $(this).show();
    });
   $("#cargando").ajaxStop(function(){
        $(this).hide();
   });

    $(function() {
        $(window).bind('beforeunload', function() {
            if(salir == false){
                return 'Por favor recuerde salir correctamente de la aplicacion.';
            }
        });   });
   
   $('#salir').on('click', function() {
    var href = $(this).attr("href");
    salir = true;
    window.location = href;
    return false;
   });
   
});
</script>
</head>
<body>
<div id="wrapper">
    
	<div id="header">
		<div id="logo">
                        <a href="index.php"><img src=""  align="left" /></a>
                        <span style="font-size:25px;"></span>
		</div>
		<div id="slogan">
                    <h2>Test</h2>
		</div>
	</div>
        <div id="panelusuario">
            <div id="panelu1">&nbsp;</div>
            <div id="panelu2"><div align="center" id="cargando" style="display:none;">&nbsp;</div></div>
            <div id="panelu3"><div align="right"><img src="tpl/img/usuario.png" alt="usuario" height="24" width="24" valign="top"/>&nbsp;<?php echo getUserNombre();?><a href="salir.php" id="salir">&nbsp;&nbsp;<img src="tpl/img/logout.png" alt="Salir" height="22" width="22" valign="top"></a>&nbsp;&nbsp;</div></div>
        </div>
	<div id="menu">
		<ul id="menulinks">
			<li class="first">
				<span class="opener">Configuraci&oacute;n<b></b></span>
				<ul>
                    <li><a href="#" data-link="app/configuracion/configuracion.php?a=ingresarForm">Configuracion</a></li>
                    
                    <li>
						<span>Usuarios y Perfiles<b></b></span>
						<ul>
                            <li><a href="#" data-link="app/usuario/usuario.php?a=listar">Usuarios</a></li>
                            <li><a href="#" data-link="app/perfil/perfil.php?a=listar">Perfiles</a></li>
                        </ul>
                    </li>        
                </ul>
			</li>              
		</ul>
		<br class="clearfix" />
	</div>
       
        <div id="resultado">
        <br/><br/><br/><strong>Bienvenid@,&nbsp;<?php echo getUserNombre();?></strong>    
        </div>    
</div>
<div id="footer">
	Copyright (c). Todos los derechos reservados.
</div>
</body>
</html>