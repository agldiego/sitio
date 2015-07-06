<div id="info"></div>
<fieldset>
  <legend><strong>INGRESAR USUARIO</strong></legend>
<form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"  id="usuarioformulario">
<input type="hidden" name="a" value="ingresar">

<table width="100%" align="left">
        <tr>
		<td align="left">Tipo de Documento:(*)</td>
		<td align="left"><?php print_selectmenu($tipo, "tipo_identificacion",'','','tipo_identificacion')?><span class="validar"></span></td>
	</tr>
        <tr>
		<td align="left">Numero:(*)</td>
                <td align="left"><input type="text" name="numero_documento" id="numero_documento"/><span class="validar"></span></td>
        </tr>
        <tr>
                <td align="left">Primer Nombre:(*)</td>
                <td align="left"><input type="text" name="nombre1" id="nombre1"/><span class="validar"></span></td>
        </tr>
        <tr>
                <td align="left">Segundo Nombre:(*)</td>
                <td align="left"><input type="text" name="nombre2" id="nombre2"/><span class="validar"></span></td>
        </tr>
        <tr>
                <td align="left">Primer Apellido:</td>
                <td align="left"><input type="text" name="apellido1" id="apellido1"/><span class="validar"></span></td>
        </tr>
        <tr>
                <td align="left">Segundo Apellido:</td>
                <td align="left"><input type="text" name="apellido2" id="apellido2"/><span class="validar"></span></td>
        </tr>
        <tr>
                <td align="left">Perfil:</td>
                <td align="left"><?php print_selectmenu($perfil, "id_rol",'','','id_rol')?><span class="validar"></span></td>
        </tr>
        <tr>
                <td align="left">Usuario:</td>
                <td align="left"><input type="text" name="usuario" id="usuario"/><span class="validar"></span></td>
        </tr>
        <tr>
                <td align="left">Clave:</td>
                <td align="left"><input type="password" name="clave" id="clave"/><span class="validar"></span></td>
        </tr>
        <tr>
                <td align="left">Confirmar Clave:</td>
                <td align="left"><input type="password" name="cclave" id="cclave"/><span class="validar"></span></td>
        </tr>
        <tr>
                <td align="left" colspan="2"><label>Medico&nbsp;<input type="checkbox" name="tipo" value="1"></label></td>
        </tr>
        <tr>         
                <td align="left">Registro Medico:(*)</td>
                <td align="left"><input type="text" name="registro_medico" id="registro_medico"/><span class="validar"></span></td>
	</tr>
       <tr>
            <td colspan="2"><input type=submit value="Guardar" name="submitbutton" class="formulario" id="guardar"/></td>
        </tr>
</table>
</form>
</fieldset>
<script type = "text/javascript">
$('#guardar').button();    
$('#usuarioformulario').submit(function(event) {
    
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
</script>