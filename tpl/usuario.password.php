<div id="tabs">
	<ul>
		<li><a href="#cambiarpassword">CAMBIAR CLAVE</a></li>
	</ul>
<div id="cambiarpassword">
<div id="info"></div>
<fieldset>
  <legend><strong>CAMBIAR CLAVE</strong></legend>
<form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"  id="usuarioformulariopass">
<input type="hidden" name="a" value="cambiarPassword">

<table width="100%" align="left">
        
        <tr>
                <td align="left">Nueva Clave:</td>
                <td align="left"><input type="password" name="clave" id="clave"/><span class="validar"></span></td>
        </tr>
        <tr>
                <td align="left">Confirmar Clave:</td>
                <td align="left"><input type="password" name="cclave" id="cclave"/><span class="validar"></span></td>
        </tr>
       <tr>
            <td colspan="2"><input type=submit value="Guardar" name="submitbutton" class="formulario" id="guardar"/></td>
        </tr>
</table>
</form>
</fieldset>
</div>
</div>    
<script type = "text/javascript">
$( "#tabs" ).tabs({
    ajaxOptions: {
        error: function( xhr, status, index, anchor ) {
                $( anchor.hash ).html(
                            "No se han podido cargar los datos" );
                    }
		}
               
});

$('#guardar').button();    
$('#usuarioformulariopass').submit(function(event) {
    
   	 event.preventDefault();
   	 var url = $(this).attr('action');
   	 var datos = $(this).serialize();
   	 $.get(url, datos, function(resultado) {
            if(resultado.status == '1'){
                 $('#info').html(resultado.mensaje);
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