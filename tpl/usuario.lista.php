<div id="tabs">
	<ul>
		<li><a href="#listado">LISTADO USUARIOS</a></li>
		<li><a href="app/usuario/usuario.php?a=ingresarForm">INGRESAR USUARIO</a></li>
	</ul>
<div id="listado">
<div align="center" id="mensaje">
<?php echo (!empty($msj))? $msj['mensaje'] : '';?>    
</div>
<div align="center"><strong>LISTADO DE USUARIOS</strong></div>
<br>
<div id="links">
<?php if(count($data['data'])):?>
<table width="60%" border="1" align="center">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Editar</th>
        <th>Borrar</th>
    </tr>
    <?php foreach($data['data'] as $valor): ?>
    <tr>
        <td><?php echo $valor['id'];?></td>
        <td><?php echo $valor['nombre'];?></td>
        <td align="center"><a href="app/usuario/usuario.php?a=actualizarForm&id=<?php echo $valor['id'];?>"><img src="tpl/img/editar2.png" width="16" height="16" /></a></td>
        <td align="center"><a href="app/usuario/usuario.php?a=eliminar&id=<?php echo $valor['id'];?>"><img src="tpl/img/remove.png" width="16" height="16" /></a></td>
    </tr>
    <?php endforeach;?>
</table>
</div>
<br/>
<div id="paginas" align="center">
<?php echo $data['links'];?>
</div>
<?php endif; ?>
<div id="resultado2" align="center"></div>
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
 
$('#links a').on('click', function() {
var href = $(this).attr("href");
$("#resultado").load(href);
return false;
});
$('#nuevo').on('click', function() {
var href = $(this).attr("href");
$("#resultado").load(href);
return false;
});

$('#paginas a').on('click', function() {
var href = $(this).attr("href");
$("#resultado").load(href);
return false;
});

</script>