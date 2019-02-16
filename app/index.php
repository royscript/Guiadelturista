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
	<link rel="stylesheet" type="text/css" href="Plugins/icofont/css/icofont.css"/>
	<script src="Plugins/jquery-confirm-master/js/jquery-confirm.js"></script>
	<link rel="stylesheet" href="Plugins/jquery-confirm-master/css/jquery-confirm.css" />
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
		.w3_facebook_btn {
			border: 1px solid rgba(0, 0, 0, 0.1) !important;
			display: inline-block !important;
			position: relative !important;
			font-family: Arial,sans-serif !important;
			letter-spacing: .4px !important;
			cursor: pointer !important;
			font-weight: 400 !important;
			text-transform: none !important;
			color: #fff !important;
			border-radius: 2px !important;
			background-color: #4B4F9A !important;
			background-repeat: no-repeat !important;
			line-height: 1.2 !important;
			text-decoration: none !important;
			text-align: left !important;
			text-shadow: none !important;
		}
		.w3_face_messenger_btn {
			border: 1px solid rgba(0, 0, 0, 0.1) !important;
			display: inline-block !important;
			position: relative !important;
			font-family: Arial,sans-serif !important;
			letter-spacing: .4px !important;
			cursor: pointer !important;
			font-weight: 400 !important;
			text-transform: none !important;
			color: #fff !important;
			border-radius: 2px !important;
			background-color: #0084FF !important;
			background-repeat: no-repeat !important;
			line-height: 1.2 !important;
			text-decoration: none !important;
			text-align: left !important;
			text-shadow: none !important;
		}
		 .w3_whatsapp_btn {
			border: 1px solid rgba(0, 0, 0, 0.1) !important;
			display: inline-block !important;
			position: relative !important;
			font-family: Arial,sans-serif !important;
			letter-spacing: .4px !important;
			cursor: pointer !important;
			font-weight: 400 !important;
			text-transform: none !important;
			color: #fff !important;
			border-radius: 2px !important;
			background-color: #5cbe4a !important;
			background-repeat: no-repeat !important;
			line-height: 1.2 !important;
			text-decoration: none !important;
			text-align: left !important;
			text-shadow: none !important;
		}

		.w3_whatsapp_btn_small {
			font-size: 12px;
			background-size: 16px;
			background-position: 5px 2px;
			padding: 3px 6px 3px 25px;
		}

		.w3_whatsapp_btn_medium {
			font-size: 16px;
			background-size: 20px;
			background-position: 4px 2px;
			padding: 4px 6px 4px 30px;
		}

		.w3_whatsapp_btn_large {
			font-size: 16px;
			background-size: 20px;
			background-position: 5px 5px;
			padding: 8px 6px 8px 30px;
			color: #fff;
		}
		a.whatsapp { color: #fff;}
		.ui-checkbox, .ui-radio {
			margin: .0em 0 !important;
		}
		#mostrar-info-punto{
			height:440px;
   			overflow-y:scroll;
		}
		#panel-filtro{
			height:440px;
   			overflow-y:scroll;
		}
	</style>
</head>
<body>
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
	<div data-role="page" id="pagina-mapa" data-url="map-page" data-corners="false">
  	  <div data-role="panel" id="panel-menu1" data-position="right" class="ui-panel ui-panel-position-right ui-panel-display-reveal ui-body-inherit ui-panel-animate ui-panel-open">
		<div class="ui-panel-inner">
			<ul data-role="listview" class="ui-listview">
				<li data-icon="delete" class="ui-first-child">
					<a href="#" data-rel="close" class="ui-btn ui-btn-icon-right ui-icon-delete">Cerrar</a>
				</li>
				<li>
					<a href="#paginaParametros" class="ui-btn ui-btn-active ui-btn-icon-right ui-icon-carat-r">Mapa</a>
				</li>
				<li>
					<a href="busquedas.php" rel="external" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Búsquedas</a>
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
				
				
				
				
				<!--<li class="ui-first-child">
					<strong>Actividad / Activity</strong>
				</li>
				<fieldset data-role="controlgroup" id="grupo-checkbox-filtros" style="margin: 0px !important;">
				</fieldset>
				<li class="ui-first-child">
					<strong>Localidad / Location</strong>
				</li>
				<fieldset data-role="controlgroup" id="grupo-checkbox-filtros-localidad" style="margin: 0px !important;">
				</fieldset>-->
			</ul>
		</div>
	</div>
 	  
 	  
 	  <div data-role="panel" id="mostrar-info-punto" data-position="left" class="ui-panel ui-panel-position-left ui-panel-display-reveal ui-body-inherit ui-panel-animate ui-panel-open">
		<div class="ui-panel-inner">
			<h2 class="titulo-local">Pensión Europa</h2>
			<br>
			<div>
				Disponemos de comodas avitaciones y un buffet que se puede ajustar a su preferencia.
			</div>
			
           <br>
           <!-- Start WOWSlider.com BODY section -->
			<div id="wowslider-container1">
			<div class="ws_images"><ul>
					<li><a href="#"><img src="Plugins/data1/images/Pension-Soto.jpg" alt="jquery slideshow" title="Portada" id="wows1_0"/></a></li>
					<li><img src="Plugins/data1/images/Pension-Soto-2.jpg" alt="Sin título" title="Kajak" id="wows1_1"/></li>
				</ul></div>
				<div class="ws_bullets"><div>
					<a href="#" title="Foto2"><span><img src="Plugins/data1/tooltips/foto2.png" alt="Foto2"/>1</span></a>
					<a href="#" title="Sin título"><span><img src="Plugins/data1/tooltips/sin_ttulo.png" alt="Sin título"/>2</span></a>
				</div></div><div class="ws_script" style="position:absolute;left:-99%"><a href="http://wowslider.net">image slider</a> by WOWSlider.com v8.8</div>
			<div class="ws_shadow"></div>
			</div>	
			<script type="text/javascript" src="Plugins/engine1/wowslider.js"></script>
			<script type="text/javascript" src="Plugins/engine1/script.js"></script>
			<!-- End WOWSlider.com BODY section -->
            <br>
        <div data-role="controlgroup" data-type="horizontal">
          <a href="tel:+56968399881" class="ui-btn ui-corner-all">
		  	<i class="icofont icofont-ui-call"></i>
		  </a>
		  <a href="https://api.whatsapp.com/send?phone=56968399881" class="w3_whatsapp_btn ui-btn ui-corner-all">
		  	<i class="icofont icofont-brand-whatsapp"></i>
		  </a>
		  <a href="https://m.me/roy.a.barraza" class="w3_face_messenger_btn ui-btn ui-corner-all">
		  	<i class="icofont icofont-social-facebook-messenger"></i>
		  </a>
		  <a href="https://www.facebook.com/roy.a.barraza" class="w3_facebook_btn ui-btn ui-corner-all">
		  	<i class="icofont icofont-social-facebook"></i>
		  </a>
		  <a href="https://www.neosystemspa.cl" class="ui-btn ui-corner-all">
		  	<i class="icofont icofont-web"></i>
		  </a>
		  <a href="#" data-rel="close" class="ui-btn ui-corner-all">
		  	<i class="icofont icofont-info-circle"></i>
		  </a>
		  <a href="#" data-rel="close" class="ui-btn ui-corner-all">
		  	<i class="icofont icofont-close-squared"></i>
		  </a>
		  <a href="#" data-rel="close" class="ui-btn ui-corner-all">
		  	Add route
		  </a>
		</div>
		</div>
	</div>
 	  
 	  
 	  <div data-role="panel" id="mostrar-info-indicaciones" data-position="left" class="ui-panel ui-panel-position-right ui-panel-display-reveal ui-body-inherit ui-panel-animate ui-panel-open">
		<div class="ui-panel-inner" style="height: 100%; overflow: scroll;">
			<h2 class="titulo-local">Indicaciones</h2>
			<p>Total Distance: <span id="total"></span></p>
			<div id="indicacionesRuta" style="height: 90%; overflow: scroll;"></div>
		</div>
	</div>
  	  
	  <div data-role="header" data-position="fixed" data-theme="a">
		<h1>Discover Chiloé</h1>
		<a href="#panel-menu1"  data-icon="grid" class="ui-btn-right">Menú</a>
		<a href="#panel-filtro" data-icon="search" class="ui-btn-left">Filtro</a>
	  </div>
	  <div data-role="main" class="ui-content" id="map">
	  </div>
	  <div data-role="footer" style="text-align:center;" data-position="fixed">
		<!--<div data-role="controlgroup" data-type="horizontal">-->
	  	  <a href="#" onClick="ver_donde_estoy();" class="ui-btn ui-corner-all ui-shadow ui-icon-location ui-btn-icon-left">Donde estoy?</a>
		  <a href="#" onClick="generarRuta();" class="ui-btn ui-corner-all ui-shadow">
		  	<i class="icofont icofont-map-pins"></i> 
		  	Generar ruta&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  	<span class="ui-li-count" id="cantidadPuntosRuta">0</span>
		  </a>
		  <a href="#" onClick="limpiarRuta();" class="ui-btn ui-corner-all ui-shadow">
		  	<i class="icofont icofont-map-pins"></i> 
		  	Limpiar ruta
		  </a>
		  <a href="#" onClick="mostrarIndicaciones();" class="ui-btn ui-corner-all ui-shadow">
		  	<i class="icofont icofont-map"></i> 
		  	Ver indicaciones
		  </a>
		<!--</div>-->
	  </div>
	  
	</div> 
	
	<script>
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
				echo 'var filtro_localidades = [';
				$datos = $conectar->listar($sqlLocalidad);
				for($x=0;$x<count($datos);$x++){
					echo '{ id : '.$datos[$x]["ID_COMUNA"].', nombre : "'.$datos[$x]["NOMBRE_COMUNA"].'" }';
					if($x<(count($datos)-1)){
						echo ',';
					}
				}
				echo '];';
			?>
		console.log(filtro_localidades);
	</script>
	<script src="js/mapa.js"></script>
	
	<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGx6vx7-gnREjJZ2--XIn_tFw9SUuG6BA&callback=iniciar_mapa"></script>
</body>
</html>