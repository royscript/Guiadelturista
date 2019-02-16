<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<title>Discover Chiloé</title>
	<link rel="stylesheet" href="Plugins/themes/fumysam.min.css" />
	<link rel="stylesheet" href="Plugins/themes/jquery.mobile.icons.min.css" />
	<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css" />
	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	<!-- Start WOWSlider.com HEAD section -->
	<link rel="stylesheet" type="text/css" href="Plugins/engine1/style.css" />
	
	<!-- End WOWSlider.com HEAD section -->
    
	<style>
		#pagina-mapa { width: 100%; height: 70%; padding: 0; }
		#map { width: 98%; height: 95%; }
		.titulo-local {
			color: #3eb249;
			background-color: transparent;
			border-bottom: 1px solid #ddd;
			font-size: 1.6em;
			padding-bottom: .2em;
			margin: 0 0 .7375em;
		}
	</style>
</head>
<body>
	<div data-role="page" id="pagina-mapa" data-url="map-page">
  	  
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
					<a href="#" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Búsquedas</a>
				</li>
				<li>
					<a href="nosotros.php" rel="external" class="ui-btn ui-btn-icon-right ui-icon-carat-r">¿Quiénes somos?</a>
				</li>
				<li>
					<a href="contacto.php" rel="external" class="ui-btn ui-btn-active ui-btn-icon-right ui-icon-carat-r">Contacto</a>
				</li>
				<li class="ui-last-child">
					<a href="login.php" rel="external" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Login</a>
				</li>
			</ul>
		</div>
	</div>
 	  
 	  
 	 
	  <div data-role="header" data-position="fixed" data-theme="a">
		<h1>Discover Chiloé</h1>
		<a href="#panel-menu1"  data-icon="grid" class="ui-btn-right">Menú</a>
	  </div>
		<div data-role="main" class="ui-content"></div>
	</div> 
</body>
</html>