<div id="tabs">
	<ul>
		<li><a href="#editar">ACTUALIZAR DATOS</a></li>
		<li><a href="app/medico/medico.php?a=listar" id="listar">LISTADO DE MEDICOS</a></li>
		<li><a href="app/medico/medico.php?a=ingresarForm">INGRESAR MEDICO</a></li>
	</ul>
<div id="editar">
<div id="info"></div>
<fieldset>
  <legend><strong>INGRESAR MEDICO</strong></legend>
<form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"  id="medicoformulariou">
<input type="hidden" name="a" value="actualizar">
<input type="hidden" name="id" value="<?php echo $rst['id'];?>">

<table width="100%" align="left">
	<tr>
		<td align="left">Tipo de Documento:(*)</td>
		<td align="left"><?php print_selectmenu($tipo, "tipo_identificacion",$rst['tipo_identificacion'],'','tipo_identificacion')?><span class="validar"></span></td>
	</tr>
        <tr>
		<td align="left">Numero:(*)</td>
                <td align="left"><input type="text" name="numero_documento" value="<?php echo $rst['numero_documento'];?>" id="numero_documento"/><span class="validar"></span></td>
        </tr>
        <tr>
                <td align="left">Primer Nombre:(*)</td>
                <td align="left"><input type="text" name="nombre1" value="<?php echo $rst['nombre1'];?>" id="nombre1"/><span class="validar"></span></td>
        </tr>
        <tr>
                <td align="left">Segundo Nombre:</td>
                <td align="left"><input type="text" name="nombre2" value="<?php echo $rst['nombre2'];?>" id="nombre2"/><span class="validar"></span></td>
        </tr>
        <tr>         
                <td align="left">Primer Apellido:(*)</td>
                <td align="left"><input type="text" name="apellido1" value="<?php echo $rst['apellido1'];?>" id="apellido1"/><span class="validar"></span></td>
	</tr>
        <tr>         
                <td align="left">Segundo Apellido:</td>
                <td align="left"><input type="text" name="apellido2" value="<?php echo $rst['apellido2'];?>" id="apellido2"/><span class="validar"></span></td>
	</tr>
         <tr>         
                <td align="left">Registro Medico:(*)</td>
                <td align="left"><input type="text" name="registro_medico" value="<?php echo $rst['registro_medico'];?>" id="registro_medico"/><span class="validar"></span></td>
	</tr>
        <tr>         
             <td colspan="2"><input type=submit value="Enviar" name="submitbutton" class="formulario"/></td>
         </tr>
</table>
</form>
</fieldset>
</div>
</div>    
<script type = "text/javascript">
$('#medicoformulariou').submit(function(event) {
    
   	 event.preventDefault();
   	 var url = $(this).attr('action');
   	 var datos = $(this).serialize();
   	 $.get(url, datos, function(resultado) {
            if(typeof(resultado)=== 'string'){
                 $('#resultado').html(resultado);
            } else {
                $.each(resultado,function(indice,valor) {
                    var $indice    =  $("#"+indice);
                    var $siguiente =  $("#"+indice).next('.validar');
                    $indice.addClass('validarCampo');
                    $siguiente.html('<br/>'+valor).css('display', 'inline');
                    
                    $indice.change(function() {
                        $indice.removeClass('validarCampo');
                        $siguiente.css('display', 'none');
                    });
                });
                $("#info").html('<div class="warning">Asegurese de completar los campos necesarios </div>');   
            }
         return false;
 	 });
     
});
$( "#tabs" ).tabs({
    ajaxOptions: {
        error: function( xhr, status, index, anchor ) {
                $( anchor.hash ).html(
                            "No se han podido cargar los datos" );
                    }
		}
               
});

$('#listar').on('click', function() {
$.get('app/medico/medico.php?a=listar', function(data) {
    $("#resultado").html(data); 
});
return false;
});
</script>