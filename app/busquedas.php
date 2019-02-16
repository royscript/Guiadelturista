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
		.ui-checkbox, .ui-radio {
			margin: .0em 0 !important;
		}
		#pagina-mapa { width: 100%; height: 70%; padding: 0; }
		#map { width: 95%; height: 100%; margin-top: -32px; }
		.titulo-local {
			color: #3eb249;
			background-color: transparent;
			border-bottom: 1px solid #ddd;
			font-size: 1.6em;
			padding-bottom: .2em;
			margin: 0 0 .7375em;
		}
		
		
		.foto-producto{
			max-width: 120px;
		}
		.imagen-producto{
			max-height: 120px;
			cursor: pointer;
			margin-left: -10px;
		}
		.texto-producto{
			max-width: 60%;
			min-width: 60%;
			width: 60%;
		}
		.descripcion{
			overflow:hidden;
			white-space:nowrap;
			text-overflow: ellipsis;
		}
		
		.tabla-producto{
			width: 100%;
			max-height: 50px;
			height: 50px;
		}
		.tabla-producto li{
			list-style: none;
		}
		
		
		
		
		
		.foto-listado{
			height: 103px !important;
			min-height: 103px !important;
			max-width: 103px !important;
		}
		.titulo{
			margin-left: 10px !important;
		}
		.descripcion{
			margin-left: 10px !important;
		}
		.ubicacion{
			margin-left: 10px !important;
		}
		#listado li a{
			border-color: #B89500;
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
	<script>
		$(document).ready(function(){
			
			$(document).on( "pagecreate", "#pagina-mapa", function() {
				$( "label" ).flipswitch( "option", "corners", false );
		    });
				$(document).on({
					ajaxSend: function () { loading('show'); },
					ajaxStart: function () { loading('show'); },
					ajaxStop: function () { loading('hide'); },
					ajaxError: function () { loading('hide'); }
				});

				function loading(showOrHide) {
					setTimeout(function(){
						$.mobile.loading( showOrHide, {
							text: 'La página se encuentra cargando, espere porfavor.',
							textVisible: true,
							theme: 'z',
							html: ""
						});
					}, 1); 
				}
				 <?php
					include_once("modelo/Conexion.class.php");
					$conectar = new Conexion();
				    echo 'var servicios_checkboxes = [';
					$datos = $conectar->listar("SELECT (
													   SELECT COUNT(`servicios_del_negocio`.`ID_SERVICIOS_DEL_NEGOCIO`) 
													   FROM `servicios_del_negocio`
													   WHERE `servicios_del_negocio`.`ID_SERVICIO` = `servicio`.`ID_SERVICIO`
													   ) AS CANTIDAD,
													   `servicio`.*
												FROM `servicio`
												WHERE (
													   SELECT COUNT(`servicios_del_negocio`.`ID_SERVICIOS_DEL_NEGOCIO`) 
													   FROM `servicios_del_negocio`
													   WHERE `servicios_del_negocio`.`ID_SERVICIO` = `servicio`.`ID_SERVICIO`
													   ) > 0");
					for($x=0;$x<count($datos);$x++){
						echo '{ id : '.$datos[$x]["ID_SERVICIO"].', nombre : "'.$datos[$x]["NOMBRE_SERVICIO"].'", icono : "'.$datos[$x]["ICONO_SERVICIO"].'", cantidad : "'.$datos[$x]["CANTIDAD"].'" }';
						if($x<(count($datos)-1)){
							echo ',';
						}
					}
				    echo '];';
					?>
				 
				 var checkbox = "";
				 for(var x=0; x<servicios_checkboxes.length;x++){
					 checkbox = '<label><input type="checkbox" name="'+servicios_checkboxes[x].id+'" id="'+servicios_checkboxes[x].id+'" value="'+servicios_checkboxes[x].nombre+'" checked=""/><img src="fotos/iconos/'+servicios_checkboxes[x].icono+'" style="width: 20px;margin-bottom: -8;"/> '+servicios_checkboxes[x].nombre+' <span class="ui-li-count ui-body-b">'+servicios_checkboxes[x].cantidad+'</span></label>';
					 $('#grupo-checkbox-filtros').append(checkbox);
					  
					 $('[type=checkbox]').checkboxradio().trigger('create');
					
					 $('#grupo-checkbox-filtros').controlgroup().trigger('create');
					 
				 }
				$( ".ui-checkbox" ).removeClass( "ui-corner-all" );
			    $( "label" ).removeClass( "ui-corner-all" );
			//});
			
			<?php
				$sqlLocalidad = "SELECT C.`ID_COMUNA`, 
								        C.`NOMBRE_COMUNA`, 
									   (
									   	SELECT COUNT(`negocio`.`ID_NEGOCIO`) 
										FROM `negocio` 
										WHERE `negocio`.`ID_COMUNA` = C.`ID_COMUNA`
										) AS CANTIDAD
				FROM `provincia` P
				INNER JOIN `comuna` C
				ON(P.`ID_PROVINCIA`=C.`ID_PROVINCIA`)
				WHERE P.`ID_PROVINCIA` LIKE 42
				AND (
					 SELECT COUNT(`negocio`.`ID_NEGOCIO`) 
					 FROM `negocio` 
					 WHERE `negocio`.`ID_COMUNA` = C.`ID_COMUNA`
					 ) > 0";
				echo 'filtro_localidades = [';
				$datos = $conectar->listar($sqlLocalidad);
				for($x=0;$x<count($datos);$x++){
					echo '{ id : '.$datos[$x]["ID_COMUNA"].'
					        , nombre : "'.$datos[$x]["NOMBRE_COMUNA"].'"
							, cantidad : "'.$datos[$x]["CANTIDAD"].'"}';
					if($x<(count($datos)-1)){
						echo ',';
					}
				}
				echo '];';
			?>
			var checkbox = "";
			 for(var x=0; x<filtro_localidades.length;x++){
				 checkbox = '<label><input type="checkbox" name="'+filtro_localidades[x].id+'-localidad" id="'+filtro_localidades[x].id+'-localidad" value="'+filtro_localidades[x].id+'" checked=""/>'+filtro_localidades[x].nombre+' <span class="ui-li-count ui-body-b">'+filtro_localidades[x].cantidad+'</span></label>';
				 $('#grupo-checkbox-filtros-localidad').append(checkbox);

				 $('[type=checkbox]').checkboxradio().trigger('create');

				 $('#grupo-checkbox-filtros-localidad').controlgroup().trigger('create');

			 }
			$( ".ui-checkbox" ).removeClass( "ui-corner-all" );
			$( "label" ).removeClass( "ui-corner-all" );
		});
	</script>
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
					<a href="#" class="ui-btn ui-btn-active ui-btn-icon-right ui-icon-carat-r">Búsquedas</a>
				</li>
				<li>
					<a href="nosotros.php" rel="external" class="ui-btn ui-btn-icon-right ui-icon-carat-r">¿Quiénes somos?</a>
				</li>
				<li>
					<a href="contacto.php" rel="external" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Contacto</a>
				</li>
				<li class="ui-last-child">
					<a href="login.php" rel="external" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Login</a>
				</li>
			</ul>
		</div>
	</div>
 	  
 	  
 	  <div data-role="panel" id="panel-filtro" data-position="left" class="ui-panel ui-panel-position-left ui-panel-display-reveal ui-body-inherit ui-panel-animate ui-panel-open">
		<div class="ui-panel-inner">
			<ul data-role="listview" class="ui-listview" data-corners="false">
				<li data-icon="delete" class="ui-first-child" data-corners="false">
					<a href="#" data-rel="close" class="ui-btn ui-btn-icon-right ui-icon-delete"><strong>Filtro / Filter</strong></a>
				</li>
				
				<li class="ui-first-child">
					<div data-role="collapsibleset" data-theme="a" data-inset="false">
						<div data-role="collapsible">
						<h2><strong>Actividad / Activity</strong></h2>
							<ul data-role="listview">
								<fieldset data-role="controlgroup" id="grupo-checkbox-filtros" style="margin: 0px !important;">
								</fieldset>
							</ul>
						</div>
						<div data-role="collapsible" style="margin-top: -8px;">
						<h2><strong>Localidad / Location</strong></h2>
							<ul data-role="listview" data-theme="a" data-divider-theme="b">
								<fieldset data-role="controlgroup" id="grupo-checkbox-filtros-localidad" style="margin: 0px !important;">
								</fieldset>
							</ul>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
	  <div data-role="header" data-position="fixed" data-theme="a">
		<h1>Discover Chiloé</h1>
		<a href="#panel-menu1"  data-icon="grid" class="ui-btn-right">Menú</a>
		<a href="#panel-filtro" data-icon="bullets" class="ui-btn-left">Filtro</a>
		<table style="min-width: 95%; max-width: 95%;">
			<tr>
				<td style="width: 80%;">
				<input type="search" name="search-2" id="search-2" value="" data-mini="true" placeholder="Search / Buscar" />
				</td>
				<td style="width: 20%;">
					<button class="ui-shadow ui-btn ui-corner-all ui-icon-search ui-btn-icon-right" id="buscar-boton">Search</button>
				</td>
			</tr>
		</table>		
	  </div>
	  <div data-role="main" class="ui-content" id="map">
	  	<ul data-role="listview" data-inset="true" data-corners="false" class="" style="margin-left: -17px;" id="listado">
			<!--<li>
				<a href="#">
				<img src="fotos/fotos-destinos/Huilo-huilo.jpg" class="foto-listado">
				<h2 class="titulo">Huilo-Huilo</h2>
				<p class="descripcion">Enclavada en el corazón de la Selva Patagónica de Chile y rodeada por la majestuosa Cordillera de los Andes, nace la Reserva Biológica Huilo Huilo, un proyecto único en el mundo por su compromiso con la conservación del patrimonio natural y cultura local. Le invitamos a un viaje fascinante por las maravillas de nuestra mágica Reserva y a conocer nuestro compromiso en las áreas de Turismo Sustentable, Fundación y Territorio.</p>
				<p class="ubicacion"><strong>Chiloé, Región de Los Lagos</strong></p>
				</a>
			</li>
			<li><a href="#">
				<img src="fotos/fotos-destinos/turavion.jpg" class="foto-listado">
				<h2 class="titulo">Turavion</h2>
				<p class="descripcion">Ofrecemos tures en avion y alojamiento.</p>
				<p class="ubicacion"><strong>Chiloé, Región de Los Lagos</strong></p>
			</a>
			</li>
			<li><a href="#">
				<img src="fotos/fotos-destinos/ruta-termas-del-sur-de-chile.jpg" class="foto-listado">
				<h2 class="titulo">Manantial / Termas Sur de Chile</h2>
				<p class="descripcion">Ofrecemos alojamiento y baños en termas curativas para enfermedades osteo-musculares.</p>
				<p class="ubicacion"><strong>Chiloé, Región de Los Lagos</strong></p>
				</a>
			</li>
			<li>
				<a href="#">
				<img src="fotos/fotos-destinos/Huilo-huilo.jpg" class="foto-listado">
				<h2 class="titulo">Huilo-Huilo</h2>
				<p class="descripcion">Enclavada en el corazón de la Selva Patagónica de Chile y rodeada por la majestuosa Cordillera de los Andes, nace la Reserva Biológica Huilo Huilo, un proyecto único en el mundo por su compromiso con la conservación del patrimonio natural y cultura local. Le invitamos a un viaje fascinante por las maravillas de nuestra mágica Reserva y a conocer nuestro compromiso en las áreas de Turismo Sustentable, Fundación y Territorio.</p>
				<p class="ubicacion"><strong>Chiloé, Región de Los Lagos</strong></p>
				</a>
			</li>
			<li><a href="#">
				<img src="fotos/fotos-destinos/turavion.jpg" class="foto-listado">
				<h2 class="titulo">Turavion</h2>
				<p class="descripcion">Ofrecemos tures en avion y alojamiento.</p>
				<p class="ubicacion"><strong>Chiloé, Región de Los Lagos</strong></p>
			</a>
			</li>
			<li><a href="#">
				<img src="fotos/fotos-destinos/ruta-termas-del-sur-de-chile.jpg" class="foto-listado">
				<h2 class="titulo">Manantial / Termas Sur de Chile</h2>
				<p class="descripcion">Ofrecemos alojamiento y baños en termas curativas para enfermedades osteo-musculares.</p>
				<p class="ubicacion"><strong>Chiloé, Región de Los Lagos</strong></p>
				</a>
			</li>
			<li>
				<a href="#">
				<img src="fotos/fotos-destinos/Huilo-huilo.jpg" class="foto-listado">
				<h2 class="titulo">Huilo-Huilo</h2>
				<p class="descripcion">Enclavada en el corazón de la Selva Patagónica de Chile y rodeada por la majestuosa Cordillera de los Andes, nace la Reserva Biológica Huilo Huilo, un proyecto único en el mundo por su compromiso con la conservación del patrimonio natural y cultura local. Le invitamos a un viaje fascinante por las maravillas de nuestra mágica Reserva y a conocer nuestro compromiso en las áreas de Turismo Sustentable, Fundación y Territorio.</p>
				<p class="ubicacion"><strong>Chiloé, Región de Los Lagos</strong></p>
				</a>
			</li>
			<li><a href="#">
				<img src="fotos/fotos-destinos/turavion.jpg" class="foto-listado">
				<h2 class="titulo">Turavion</h2>
				<p class="descripcion">Ofrecemos tures en avion y alojamiento.</p>
				<p class="ubicacion"><strong>Chiloé, Región de Los Lagos</strong></p>
			</a>
			</li>
			<li><a href="#">
				<img src="fotos/fotos-destinos/ruta-termas-del-sur-de-chile.jpg" class="foto-listado">
				<h2 class="titulo">Manantial / Termas Sur de Chile</h2>
				<p class="descripcion">Ofrecemos alojamiento y baños en termas curativas para enfermedades osteo-musculares.</p>
				<p class="ubicacion"><strong>Chiloé, Región de Los Lagos</strong></p>
				</a>
			</li>-->
		</ul>
	  </div>
	</div> 
	<script>
	<?php
		$sqlLocalidad = "SELECT C.`ID_COMUNA`, C.`NOMBRE_COMUNA` 
						FROM `provincia` P
						INNER JOIN `comuna` C
						ON(P.`ID_PROVINCIA`=C.`ID_PROVINCIA`)
						WHERE P.`ID_PROVINCIA` LIKE 42";
		echo 'var filtro_localidades = [';
		$datos = $conectar->listar($sqlLocalidad);
		for($x=0;$x<count($datos);$x++){
			echo '{ id : '.$datos[$x]["ID_COMUNA"].', nombre : "'.$datos[$x]["NOMBRE_COMUNA"].'" }';
			if($x<(count($datos)-1)){
				echo ',';
			}
		}
		echo '];';
		
		echo 'var servicios_checkboxes = [';
		$datos = $conectar->listar("SELECT * FROM `servicio`");
		for($x=0;$x<count($datos);$x++){
			echo '{ id : '.$datos[$x]["ID_SERVICIO"].', nombre : "'.$datos[$x]["NOMBRE_SERVICIO"].'", icono : "'.$datos[$x]["ICONO_SERVICIO"].'" }';
			if($x<(count($datos)-1)){
				echo ',';
			}
		}
		echo '];';
	?>
	</script>
	<script src="js/busquedas.js"></script>
</body>
</html>