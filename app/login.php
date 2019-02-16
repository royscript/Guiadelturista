<html>
<head>
	<meta charset="utf-8">
	<title>Discover Chiloé</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<link rel="stylesheet" href="Plugins/themes/fumysam.min.css" />
	<link rel="stylesheet" href="Plugins/themes/jquery.mobile.icons.min.css" />
	<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css" />
	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    
</head>
<body>
	<div data-role="page" id="pagina-login">
  	  
  	  <div data-role="panel" id="panel-menu1" data-position="right" class="ui-panel ui-panel-position-right ui-panel-display-reveal ui-body-inherit ui-panel-animate ui-panel-open">
		<div class="ui-panel-inner">
			<ul data-role="listview" class="ui-listview">
				<li data-icon="delete" class="ui-first-child">
					<a href="#" data-rel="close" class="ui-btn ui-btn-icon-right ui-icon-delete">Cerrar</a>
				</li>
				<li>
					<a href="index.php" rel="external" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Mapa</a>
				</li>
				<li>
					<a href="busquedas.php" rel="external" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Búsquedas</a>
				</li>
				<li>
					<a href="#paginaParametros" class="ui-btn ui-btn-icon-right ui-icon-carat-r">¿Quiénes somos?</a>
				</li>
				<li>
					<a href="#paginaMeses" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Contacto</a>
				</li>
				<li class="ui-last-child">
					<a href="#" class="ui-btn ui-btn-active ui-btn-icon-right ui-icon-carat-r">Login</a>
				</li>
			</ul>
		</div>
	</div>
 	  
 	  
 	  
 	  
	  <div data-role="header" data-position="fixed" data-theme="a">
		<h1>Discover Chiloé</h1>
		<a href="#panel-menu1"  data-icon="grid" class="ui-btn-right">Menú</a>
	  </div>
	  <div data-role="main" class="ui-content">
	    <form action="controlador/procesaLogin.php" method="post" data-ajax="false" name="Contact Form" id="contactform" enctype="multipart/form-data">
	    	<label for="textinput-6">Usuario / Username:</label>
			<input type="text" name="usuario" id="usuario" placeholder="usuario / username" value="" data-mini="true">
			<label for="textinput-6">Contraseña / Password:</label>
			<input type="password" name="contrasena" id="contrasena" placeholder="contraseña / password" value="" data-mini="true">
			<fieldset data-role="controlgroup" style="text-align:center;" data-type="horizontal">
				<button type="submit" class="ui-shadow ui-btn ui-corner-all ui-icon-check ui-btn-icon-right">Ingresar</button>
				<a href="#" class="ui-shadow ui-btn ui-corner-all ui-icon-mail ui-btn-icon-right">Recuperar Contraseña</a>
			</fieldset>
	    </form>
	  	
	  </div>
	</div> 
</body>
</html>