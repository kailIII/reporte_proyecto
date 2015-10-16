<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	 <meta name="viewport" content="width=device-width, initial-scale=1.0"><!-- Viewport para distintos dispositivos -->
	<meta name="language" content="es" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="./css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="./css/print.css" media="print" />

	<link rel="stylesheet" type="text/css" href="./css/main.css" />
	<link rel="stylesheet" type="text/css" href="./css/form.css" />

	<link rel="stylesheet" type="text/css" href="./css/custom-theme/jquery-ui-custom.css" />	

	<script type="text/javascript" src="./js/jquery.min.js"></script>
	<script type="text/javascript" src="./js/jquery-ui.min.js"></script>
	<script type="text/javascript">
		$().ready(function(){			
		    $( "button" ).button().click(function(event){validateForm();});

		    function validateForm(){
			    var x = document.forms["formulario"]["base_datos"].value;
			    if (x == null || x == ""){
			        alert("Debe seleccionar una Base de Datos.");
			        return false;
			    }
			}
		});
	</script>

	<title>SRPMS</title>
</head>
<body>
	<div class="container" id="page">
		<div id="header">
			<div id="banner"></div>
			<div id="logo">Sistema para el Registro de Materiales y Servicios</div>
		</div><!-- header -->

		<div id="mainmenu">
			<ul>
				<li class="active"><a herf="#">Base de Datos</a></li>
			</ul>
		</div>

		<div class="container">
			<div id="content">
				<h1>Bienvenido</h1>

				<?php
					//Lista de bd
					$bd=file_get_contents('./protected/respaldos/db.json');
					$json=json_decode($bd,true);
				?>


				<div class="form">
					<form method="post" action="_redirect.php" name="formulario" id="formulario" onsubmit="return validateForm()">
						<div class="row">
							<label>Base de datos</label>
							<select name="base_datos" id="base_datos">
								<option value="">Seleccione</option>
								<?php
									foreach ($json as $key => $value) 
									{
								?>
									<option value="<?php echo $key ?>"><?php echo $value; ?></option>
								<?php
									}
								?>
							</select>				
						</div>
						<div class="buttons">
							<button type="submit">Aceptar</button>
						</div>
					</form>
				</div>
			</div><!-- content -->
		</div><!-- container -->	

		<div id="footer">
			<?php date_default_timezone_set("America/Caracas");	?> <!-- Definir el timezone -->
			Copyleft &copy; <?php echo date('Y'); ?> por MINPPPST.<br/>
		</div><!-- footer -->
	</div>
</body>
</html>