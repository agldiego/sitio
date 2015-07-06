<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="ie6 ielt8"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="ie7 ielt8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="ie8"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<title>Radar 1.0 - Ingreso</title>
<link rel="stylesheet" type="text/css" href="tpl/css/login.css" />
</head>
<body>
<div class="container">
	<section id="content">
		<form action="app/autenticacion/autenticacion.php" method="POST">
                        <h1>Ingreso</h1>
                        <img src="tpl/img/logoradar.png"/>
                        <?php if(isset($_REQUEST['login'])):?>
                        <?php if($_REQUEST['login'] == 'false'):?>
                        <div style="color: #FF0000;font-size: 0.9em;">Usuario Incorrecto</div>
                        <?php endif;?>
                        <?php endif;?>
			<div>
				<input type="text" placeholder="Usuario" name="usuario" required="" id="username" />
			</div>
			<div>
                            <input type="password" placeholder="Contrase&ntilde;a" name="clave" required="" id="password" />
			</div>
			<div>
				<input type="submit" value="Ingresar" />
				<!--<a href="#">Lost your password?</a>-->
				<!--<a href="#">Register</a>-->
			</div>
		</form><!-- form -->
	</section><!-- content -->
</div><!-- container -->
</body>
</html>