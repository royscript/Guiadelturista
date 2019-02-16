<html>
<head>
<?php
	if(!isset($_GET['idCliente'])){
		header('Location: index.php');
            exit;
	}
	include_once("modelo/Conexion.class.php");
	$conectar = new Conexion();
	$idCliente = intval($_GET['idCliente']);
	if($idCliente==0){
		header('Location: index.php');
            exit;
	}
	$sqlLocalidad = "SELECT * FROM `foto` WHERE `ID_NEGOCIO` =".$idCliente;
	$fotos = $conectar->listar($sqlLocalidad);
	?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<title>Discover Chiloé</title>
	
	<meta property="og:url"           content="http://neosystemspa.cl/turismochilote/app/mostrar_destino.php?idCliente=<?php echo $idCliente; ?>" />
 	<meta property="og:type"          content="website" />
    <meta property="og:title"         content="Discover Chiloé" />
    <meta property="og:description"   content="Un lugar donde puedes encontrar los diferentes destinos turisticos de la región tales como cabañas, ferias artesanales, islas, etc." />
    <meta property="og:image"         content="http://neosystemspa.cl/turismochilote/app/fotos/fotos-destinos/<?php echo $foto[0]["UBICACION_FOTO"]; ?>" />
    
    
	<link rel="stylesheet" href="Plugins/themes/fumysam.min.css" />
	<link rel="stylesheet" href="Plugins/themes/jquery.mobile.icons.min.css" />
	<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css" />
	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	<!-- Start WOWSlider.com HEAD section -->
	<link rel="stylesheet" type="text/css" href="Plugins/engine2/style.css" />
	<script type="text/javascript" src="Plugins/engine2/jquery.js"></script>
	<!-- End WOWSlider.com HEAD section -->
    
	<style>
	#Introduction {
		color: #3eb249;
		background-color: transparent;
		border-bottom: 1px solid #ddd;
		font-size: 1.6em;
		padding-bottom: .2em;
		margin: 0 0 .7375em;
	}
	</style>
	<script>
	$(document).ready(function(){
		var isMobile = {
			Android: function() {
				return navigator.userAgent.match(/Android/i);
			},
			BlackBerry: function() {
				return navigator.userAgent.match(/BlackBerry/i);
			},
			iOS: function() {
				return navigator.userAgent.match(/iPhone|iPad|iPod/i);
			},
			Opera: function() {
				return navigator.userAgent.match(/Opera Mini/i);
			},
			Windows: function() {
				return navigator.userAgent.match(/IEMobile/i);
			},
			any: function() {
				return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
			}
		};
		if( !isMobile.any() ) {
			$("#map").css("width","100%");
		}
	});
	</script>
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.11&appId=1995340370738746&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

	<div data-role="page" id="Inicio">
  	  
  	  <div data-role="panel" id="panel-menu1" data-position="right" class="ui-panel ui-panel-position-right ui-panel-display-reveal ui-body-inherit ui-panel-animate ui-panel-open">
		<div class="ui-panel-inner">
			<ul data-role="listview" class="ui-listview">
				<li data-icon="delete" class="ui-first-child">
					<a href="#" data-rel="close" class="ui-btn ui-btn-icon-right ui-icon-delete">Cerrar</a>
				</li>
				<li>
					<a href="index.php" class="ui-btn ui-btn-active ui-btn-icon-right ui-icon-carat-r">Home / Inicio</a>
				</li>
				<li>
					<a href="#pagina-mapa" class="ui-btn  ui-btn-icon-right ui-icon-carat-r">Map / Mapa</a>
				</li>
				<li>
					<a href="#pagina-contacto" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Contact / Contacto</a>
				</li>
			</ul>
		</div>
	</div>
 	  
	  <div data-role="header" data-position="fixed" data-theme="a">
		<h1>Discover Chiloé</h1>
		<a href="#panel-menu1" rel="external"  data-icon="grid" class="ui-btn-right">Menú</a>
		<a href="busquedas.php" rel="external" data-icon="back" class="ui-btn-left">Atrás</a>		
	  </div>
	  <div data-role="main" class="ui-content">
	  	<!-- Start WOWSlider.com BODY section -->
		<div id="wowslider-container1">
		<div class="ws_images">
		    <ul>
			    <?php
					
					
					foreach($fotos as $foto){
						echo '<li>'
							.'<img src="fotos/fotos-destinos/'.$foto["UBICACION_FOTO"].'" alt="'.$foto["NOMBRE_FOTO"].'" title="'.$foto["NOMBRE_FOTO"].'" id="wows1_0"/>'
							.'</li>';
					}

					
				?>
				
			</ul>
		</div>
		<div class="ws_bullets">
			<div>
				<?php
					$indice = 1;
					foreach($fotos as $foto){
						echo '<a href="#" title="'.$foto["NOMBRE_FOTO"].'">'
								.'<span>'
								 .'<img src="fotos/fotos-destinos/'.$foto["UBICACION_FOTO"].'" alt="'.$foto["NOMBRE_FOTO"].'"/>'.$indice
							    .'</span>'
							.'</a>';
						$indice++;
					}

					
				?>
			</div>
		</div><div class="ws_script" style="position:absolute;left:-99%"></div>
		<div class="ws_shadow"></div>
		</div>	
		<script type="text/javascript" src="Plugins/engine2/wowslider.js"></script>
		<script type="text/javascript" src="Plugins/engine2/script.js"></script>
		<!-- End WOWSlider.com BODY section -->
		<br>
		<?php
		  $sqlLocalidad = "SELECT * FROM `negocio` WHERE `ID_NEGOCIO`=".$idCliente;
		  $informacionLocal = $conectar->listar($sqlLocalidad);
		  ?>
		<h2 id="Introduction" style="text-align: center;"><?php echo $informacionLocal[0]["NOMBRE_DE_FANTASIA_NEGOCIO"]; ?></h2>
		<p style="text-align: justify;"><?php echo $informacionLocal[0]["DESCRIPCION_NEGOCIO"]; ?></p>
		<h2 id="Introduction">Servicios / Services</h2>
		<?php
		  $sqlLocalidad = "SELECT S.`NOMBRE_SERVICIO`, S.`ICONO_SERVICIO`
							FROM `servicios_del_negocio` SN
							INNER JOIN `servicio` S
							ON(SN.`ID_SERVICIO`=S.`ID_SERVICIO`)
							WHERE SN.`ID_NEGOCIO` = ".$idCliente;
		  $servicios = $conectar->listar($sqlLocalidad);
		  ?>
		<p>
			<ol>
			<?php
			foreach($servicios as $servicio){
				echo '<li>'.$servicio["NOMBRE_SERVICIO"].'<img src="fotos/iconos/'.$servicio["ICONO_SERVICIO"].'" style="margin-bottom: -17px;margin-left: 5px;"></li>';
			}
			?>
			</ol>
		</p>
		<h2 id="Introduction">Comentarios / Comments 
		  <div class="fb-like" 
			data-href="https://neosystemspa.cl/turismochilote/app/mostrar_destino.php?idCliente=<?php echo $idCliente; ?>" 
			data-layout="standard" 
			data-action="like" 
			data-show-faces="true">
		  </div>
		  <div class="fb-follow" data-href="https://neosystemspa.cl/turismochilote/app/mostrar_destino.php?idCliente=<?php echo $idCliente; ?>" data-layout="standard" data-size="small" data-show-faces="true"></div>
		  </h2>
		<div class="fb-comments" data-href="https://neosystemspa.cl/turismochilote/app/mostrar_destino.php?idCliente=<?php echo $idCliente; ?>" data-numposts="5"></div>
	  </div>
	</div> 
	
	
	
	
	
	
	
	
	
	<div data-role="page" id="pagina-mapa">
  	  
  	  <div data-role="panel" id="panel-menu2" data-position="right" class="ui-panel ui-panel-position-right ui-panel-display-reveal ui-body-inherit ui-panel-animate ui-panel-open">
		<div class="ui-panel-inner">
			<ul data-role="listview" class="ui-listview">
				<li data-icon="delete" class="ui-first-child">
					<a href="#" data-rel="close" class="ui-btn ui-btn-icon-right ui-icon-delete">Cerrar</a>
				</li>
				<li>
					<a href="#Inicio" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Home / Inicio</a>
				</li>
				<li>
					<a href="#" class="ui-btn ui-btn-active ui-btn-icon-right ui-icon-carat-r">Map / Mapa</a>
				</li>
				<li>
					<a href="#pagina-contacto" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Contact / Contacto</a>
				</li>
			</ul>
		</div>
	</div>
 	  
	  <div data-role="header" data-position="fixed" data-theme="a">
		<h1>Discover Chiloé</h1>
		<a href="#panel-menu2" rel="external"  data-icon="grid" class="ui-btn-right">Menú</a>
		<a href="busquedas.php" rel="external" data-icon="back" class="ui-btn-left">Atrás</a>		
	  </div>
	  
	  	
	  
	  <div data-role="main" class="ui-content">
	  	<div id="map" style="width: 99%; height: 330px;"></div>
	  	<br>
	  	<ol>
	  		<li><strong>Dirección : </strong><?php echo $informacionLocal[0]["DIRECCION_NEGOCIO"]; ?>.</li>
	  		<li><strong>Referencia : </strong><?php echo $informacionLocal[0]["REFERENCIA_DIRECCION_NEGOCIO"]; ?>.</li>
	  	</ol>
	  </div>
	</div>
	
	
	
	
	<div data-role="page" id="pagina-contacto">
  	  
  	  <div data-role="panel" id="panel-menu3" data-position="right" class="ui-panel ui-panel-position-right ui-panel-display-reveal ui-body-inherit ui-panel-animate ui-panel-open">
		<div class="ui-panel-inner">
			<ul data-role="listview" class="ui-listview">
				<li data-icon="delete" class="ui-first-child">
					<a href="#" data-rel="close" class="ui-btn ui-btn-icon-right ui-icon-delete">Cerrar</a>
				</li>
				<li>
					<a href="#Inicio" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Home / Inicio</a>
				</li>
				<li>
					<a href="#pagina-mapa" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Map / Mapa</a>
				</li>
				<li>
					<a href="#" class="ui-btn ui-btn-active ui-btn-icon-right ui-icon-carat-r">Contact / Contacto</a>
				</li>
			</ul>
		</div>
	</div>
 	  
	  <div data-role="header" data-position="fixed" data-theme="a">
		<h1>Discover Chiloé</h1>
		<a href="#panel-menu3" rel="external"  data-icon="grid" class="ui-btn-right">Menú</a>
		<a href="busquedas.php" rel="external" data-icon="back" class="ui-btn-left">Atrás</a>		
	  </div>
	  
	  	
	  
	  <div data-role="main" class="ui-content">
	  	<ol>
	  		<li><strong>Dirección : </strong><?php echo $informacionLocal[0]["DIRECCION_NEGOCIO"]; ?>.</li>
	  		<li><strong>Referencia : </strong><?php echo $informacionLocal[0]["REFERENCIA_DIRECCION_NEGOCIO"]; ?>.</li>
	  		<li><strong>Celular : </strong><?php echo $informacionLocal[0]["CELULAR_NEGOCIO"]; ?>.</li>
	  		<li><strong>Whatsapp : </strong><?php echo $informacionLocal[0]["WHATSAPP_NEGOCIO"]; ?>.</li>
	  		<li><strong>Facebook : </strong><a href="<?php echo $informacionLocal[0]["FACEBOOK_NEGOCIO"]; ?>" rel="external">Link</a></li>
	  		<li><strong>Sitio Web : </strong><a href="<?php echo $informacionLocal[0]["PAGINA_WEB_NEGOCIO"]; ?>" rel="external">Link</a></li>
	  	</ol>
	  </div>
	</div>
	<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGx6vx7-gnREjJZ2--XIn_tFw9SUuG6BA&callback=initMap"></script>
    <script>
	var mapa = null;
	var directionsService = null;
	var directionsDisplay = null;
	var sitiosRuta = new Array();
	var instruccionesRuta = null;
	function initMap() {
		directionsService = new google.maps.DirectionsService;
		var latitud;
		var longitud;
		var myLatLng;
		
		latitud = parseFloat(<?php echo $informacionLocal[0]["LATITUD_NEGOCIO"]; ?>);
		longitud = parseFloat(<?php echo $informacionLocal[0]["LONGITUD_NEGOCIO"]; ?>);
		
	  myLatLng = {lat: latitud, lng: longitud};
	  //alert("Pasé por aquí");
	  mapa = new google.maps.Map(document.getElementById('map'), {
		zoom: 18,
		center: myLatLng
	  });
	  directionsDisplay = new google.maps.DirectionsRenderer({
		draggable: true,
		map: mapa,
		panel: document.getElementById('indicacionesRuta')
	  });
	  directionsDisplay.addListener('directions_changed', function() {
		distanciaTotal(directionsDisplay.getDirections());
	  });
	  //directionsDisplay.setMap(mapa);
	  marcar_empresas();
		//alert(_0xa3ee[0]);
	}
	var marcadores = new Array();
	function marcar_empresas(){	
		var marcador = new google.maps.Marker({
			position: {lat: parseFloat(<?php echo $informacionLocal[0]["LATITUD_NEGOCIO"]; ?>), lng: parseFloat(<?php echo $informacionLocal[0]["LONGITUD_NEGOCIO"]; ?>)},
			map: mapa,
			icon: 'fotos/iconos/<?php echo $servicios[0]["ICONO_SERVICIO"]; ?>',
			title: '<?php echo $servicios[0]["NOMBRE_SERVICIO"]; ?>'
		});
		marcadores.push(marcador);
	}
	$(document).ready(function(){
		$(document).on( "pageshow", "#pagina-mapa", function() {
			initMap();
		});
	});
	</script>
</body>
</html>