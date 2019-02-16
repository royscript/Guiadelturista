//Autor : Roy Alex Standen Barraza
//Versión : 1.0
//Fecha : 11-12-2017 20:34
var datos_del_punto_clickeado = new Array();
var negocio_clickeado = null;
$(document).ready(function(){
	
});
class Ajax{
	constructor(){

	}
	enviar(parametros,url){
		var enviados = null;
		try{
			enviados = $.ajax({
							url: url,
							type:'POST',
							data:parametros,
							beforeSend: function(){/* mientras este sucediendo el evento sucederá lo siguiente*/
								$.mobile.loader.prototype.options.text = "Cargando";
								$.mobile.loader.prototype.options.textVisible = false;
								$.mobile.loader.prototype.options.theme = "a";
								$.mobile.loader.prototype.options.html = "";
							},
							error: function(XMLHttlRequest, textStatus, errorThrown){
								alert(errorThrown);
							} /* Si sucede un error se llamará a la función callback_error*/
						});
		}catch(ex){
			alert(ex);
		}
		return enviados;
	}
}
var objetoAjax = new Ajax();


var mapa = null;
var directionsService = null;
var directionsDisplay = null;
var sitiosRuta = new Array();
var instruccionesRuta = null;
var _0xa3ee=["\x50\x72\x75\x65\x62\x61\x20\x52\x6F\x79\x20\x53\x74\x61\x6E\x64\x65\x6E\x20\x42\x2E\x2D"];

function initMap(position) {
	directionsService = new google.maps.DirectionsService;
	var latitud;
	var longitud;
	var myLatLng;
	if(position!=null){
		latitud = position.coords.latitude;
		longitud = position.coords.longitude;
	}else{
		latitud = -42.6239686;
		longitud = -73.9265732;
	}
  myLatLng = {lat: latitud, lng: longitud};
  //alert("Pasé por aquí");
  mapa = new google.maps.Map(document.getElementById('map'), {
	zoom: 8,
	center: myLatLng,
	disableDefaultUI: true
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
  if(position!=null){
	geolocalizar_usuario();
  }
	//alert(_0xa3ee[0]);
}

var sitios_localizados = new Array();
var marcadores = new Array();
function marcar_empresas(){
	var parametros = {
		'accion' : 'mostrarMapa'	
	};
	var respuesta_ajax = objetoAjax.enviar(parametros,'controlador/mapas.php');
	respuesta_ajax.done(function( datos ) {
		datos = JSON.parse(datos);
		sitios_localizados = datos;
		if(datos.length>0){
			marcadores.length = 0;
		}
		for(var x=0;x<datos.length;x++){
			var marcador = new google.maps.Marker({
				position: {lat: parseFloat(datos[x].LATITUD_NEGOCIO), lng: parseFloat(datos[x].LONGITUD_NEGOCIO)},
				map: mapa,
				icon: 'fotos/iconos/'+datos[x].ICONO_SERVICIO,
				title: datos[x].NOMBRE_SERVICIO
			});
			marcadores.push(marcador);
			var html = '<div class="ui-panel-inner" style="height: 100%; overflow: scroll;">'
				+'<h2 class="titulo-local">'+datos[x].NOMBRE_DE_FANTASIA_NEGOCIO+'</h2>'
				+'<br>'
				+'<div>'
					+datos[x].DESCRIPCION_NEGOCIO
				+'</div>'

			   +'<br>';

			html    +='<!-- Start WOWSlider.com BODY section -->'
						+'<div id="wowslider-container1">'
						+'<div class="ws_images"><ul>';
			var fotos = "";
			for(var i=0;i<datos[x].FOTOS.length;i++){

				html    += '<li><a href="#"><img src="fotos/fotos-destinos/'+datos[x].FOTOS[i].UBICACION_FOTO+'" alt="jquery slideshow" title="'+datos[x].FOTOS[i].NOMBRE_FOTO+'" id="wows1_0"/></a></li>';
			}
			html    +='</ul></div>'
							+'<div class="ws_bullets"><div>'
								+'<a href="#" title="Foto2"><span><img src="Plugins/data1/tooltips/foto2.png" alt="Foto2"/>1</span></a>'
								+'<a href="#" title="Sin título"><span><img src="Plugins/data1/tooltips/sin_ttulo.png" alt="Sin título"/>2</span></a>'
							+'</div></div><div class="ws_script" style="position:absolute;left:-99%"><a href="http://wowslider.net">image slider</a> by WOWSlider.com v8.8</div>'
						+'<div class="ws_shadow"></div>'
						+'</div>'
						+'<script type="text/javascript" src="Plugins/engine1/wowslider.js"><'+'/script>'

						+'<script type="text/javascript" src="Plugins/engine1/script.js"><'+'/script>'
			html    +='<br>'
					+'<div data-role="controlgroup" data-type="horizontal">'
					  +'<a href="tel:+'+datos[x].CELULAR_NEGOCIO+'" class="ui-btn ui-corner-all">'
						+'<i class="icofont icofont-ui-call"></i>'
					  +'</a>'
					  +'<a href="https://api.whatsapp.com/send?phone='+datos[x].CELULAR_NEGOCIO+'" class="w3_whatsapp_btn ui-btn ui-corner-all">'
						+'<i class="icofont icofont-brand-whatsapp"></i>'
					  +'</a>'
					  +'<a href="https://m.me/'+datos[x].NOMBRE_USUARIO_FACEBOOK_NEGOCIO+'" class="w3_face_messenger_btn ui-btn ui-corner-all">'
						+'<i class="icofont icofont-social-facebook-messenger"></i>'
					  +'</a>'
					  +'<a href="'+datos[x].FACEBOOK_NEGOCIO+'" class="w3_facebook_btn ui-btn ui-corner-all">'
						+'<i class="icofont icofont-social-facebook"></i>'
					  +'</a>'
					  +'<a href="'+datos[x].PAGINA_WEB_NEGOCIO+'" class="ui-btn ui-corner-all">'
						+'<i class="icofont icofont-web"></i>'
					  +'</a>'
					  +'<a href="mostrar_destino.php?idCliente='+datos[x].ID_NEGOCIO+'" rel="external" class="ui-btn ui-corner-all">'
						+'<i class="icofont icofont-info-circle"></i>'
					  +'</a>'
					  +'<a href="#" data-rel="close" class="ui-btn ui-corner-all">'
						+'<i class="icofont icofont-close-squared"></i>'
					  +'</a>';
			  
			  html    +='<a href="#" onClick="agregarARuta('+x+')" data-rel="close" class="ui-btn ui-corner-all">'
						+'+<i class="icofont icofont-social-google-map"></i>'
					  +'</a>';
					  +'<div id="facebook"></div>';
			  html    +='</div>'
					+'</div>';

			informacionPorPunto(marcador, html,datos[x].ID_NEGOCIO);



		   // marcador = null;
		//	var infowindow = new google.maps.InfoWindow();
			//var contenido = 'Disponemos de comodas avitaciones y un buffet que se puede ajustar a su preferencia.';
		}
	});
}

function informacionPorPunto(marker, html, idNegocio = null) {
	//var infowindow = new google.maps.InfoWindow({
	  //content: html
	//});

	marker.addListener('click', function() {
	  //infowindow.open(marker.get('map'), marker);
	  $("#mostrar-info-punto").on("panelopen", function( event, ui ) {
			var objetoAjax = new Ajax();
			var parametros = {
				'accion' : 'mostrarMapa'	
			};
			var respuesta_ajax = objetoAjax.enviar(parametros,'cantidad-likes.php?idCliente='+idNegocio);
			respuesta_ajax.done(function( datos ) {
				$("#facebook").html(datos);
			});
	  });
		
	  $("#mostrar-info-punto").html(html);
	  $("#mostrar-info-punto").trigger('updatelayout');
	  $("#mostrar-info-punto").trigger('create');
	  $("#mostrar-info-punto").panel("open");
	});
}
function limpiar(){
	navigator.geolocation.getCurrentPosition(initMap,
											 onErrorGeolocating,
											 {
													enableHighAccuracy: true,
													maximumAge: 30000,
													timeout: 27000
											 });
}
function onErrorGeolocating(error){
	switch(error.code){
		case error.PERMISSION_DENIED:
			alert('ERROR: User denied access to track physical position!');
		break;

		case error.POSITION_UNAVAILABLE:
			alert("ERROR: There is a problem getting the position of the device!");
		break;

		case error.TIMEOUT:
			alert("ERROR: The application timed out trying to get the position of the device!");
		break;

		default:
			alert("ERROR: Unknown problem!");
		break;
	}
}
function iniciar_mapa(){
	initMap(null);
}

function geolocalizar_usuario(){
	obtener_coordenadas_usuario();
	setInterval(function(){ obtener_coordenadas_usuario(); }, 10000);
}

function obtener_coordenadas_usuario(){
	if(navigator.geolocation){
		navigator.geolocation.getCurrentPosition(function(position) {
				/*var marcador = null;
				//var imagen = '../../core/images/factory_google_maps-con-fondo.png';

				var marcador = new google.maps.Marker({
					position: {lat:position.coords.latitude, lng:position.coords.longitude},
					map: mapa,
					title: 'tu'
				});
				marcador.setMap(mapa);*/

				  addMarker({lat:position.coords.latitude, lng:position.coords.longitude});
				$("#prueba").html("Latitud : "+position.coords.latitude+' Longitud : '+position.coords.longitude);
			}, onErrorGeolocating
			, {
				enableHighAccuracy: true,
				maximumAge: 30000,
				timeout: 27000
			}
		);
	}else{
			// El navegador no soporta la geolicalización

	}
}
var posicion_antigua_usuario = new Array();
var latitud_longitud_usuario = new Array();
var es_primera_vez = true;
function addMarker(location) {
	//console.log(posicion_antigua_usuario.length+'>'+0+' = '+posicion_antigua_usuario.length>0);
	//console.log(posicion_antigua_usuario);
  if(es_primera_vez==false){
	posicion_antigua_usuario.setMap(null);
	posicion_antigua_usuario.length = 0;
	$("#prueba").html("Eliminado "+posicion_antigua_usuario);
	//console.log("Eliminando");
  }else{
	es_primera_vez = false;
  } 
  //console.log(posicion_antigua_usuario);
  var foto = 'fotos/breastfeeding.png';
  var marker = new google.maps.Marker({
	position: location,
	map: mapa,
	icon: foto
  });
  posicion_antigua_usuario = marker; 
  latitud_longitud_usuario = location;
}
var marcador_posicion_antigua_usuario = null;
function localizar_usuario(latitud_longitud_usuario){
	if(marcador_posicion_antigua_usuario==null){

	}else{
		marcador_posicion_antigua_usuario.setMap(null);
	}
	var latitud = latitud_longitud_usuario.lat;
	var longitud = latitud_longitud_usuario.lng;
	var foto = 'fotos/breastfeeding.png';
	var marker = new google.maps.Marker({
		position: latitud_longitud_usuario,
		map: mapa,
		icon: foto
	});
	marcador_posicion_antigua_usuario = marker;
	mapa.setCenter({lat: latitud, lng: longitud});//mostrar posicion actual usuario
}
function ver_donde_estoy(){
	navigator.geolocation.getCurrentPosition(function(position){
		var latitud = position.coords.latitude;
		var longitud = position.coords.longitude;
		latitud_longitud_usuario = {lat: latitud, lng: longitud};
		localizar_usuario(latitud_longitud_usuario);
	},
	 onErrorGeolocating,
	 {
			enableHighAccuracy: true,
			maximumAge: 30000, 
			timeout: 27000
	 });
}
function mover_camara(){
	mapa.setCenter({lat : -29.956547333764615, lng: -71.33786827325821});
}


function agregarARuta(indice){
	if(sitiosRuta.length>22){
		$.alert("Solo puede agregar un máximo de 23 lugares a la ruta.");
		return false;
	}else{
		for(var x=0;x<sitiosRuta.length;x++){
			if(indice==sitiosRuta[x].id){
				$.alert("Esta dirección ya la seleccionó.<br> This address has already selected it.");
				return false;
			}
		}
		sitiosRuta.push({
			id : indice,
			location: {
						lat: parseFloat(sitios_localizados[indice].LATITUD_NEGOCIO), 
						lng: parseFloat(sitios_localizados[indice].LONGITUD_NEGOCIO)
			},
		    stopover: true//Esto indica que es una parada real y no una alternativa
		});
		$("#cantidadPuntosRuta").html(sitiosRuta.length);
		$("#mostrar-info-punto").panel("close");
	}
}

function generarRuta(){
	if(sitiosRuta.length==0){
		$.alert("Necesitas seleccionar los lugares antes de generar la ruta.<br>You need to select the places before generating the route.");
		return false;
	}
	if(sitiosRuta.length==1){
		$.alert("Debe seleccionar al menos 2 lugares para generar la ruta.<br>You must select at least 2 places to generate the route.");
		return false;
	}
	$.confirm({
		title: 'Generar ruta',
		content: '' +
				'<form action="" class="formName">' +
				'<div class="form-group">' +
				'<label><strong>Seleccione el tipo de ruta.<br>Select the type of route.</strong></label>' +
				'<input type="radio" id="rutaMasCorta" name="rutaMasCorta" value="true"> RUTA MAS CORTA -SHORTEST ROUTE<br>'+
		        '<input type="radio" id="rutaMasCorta" name="rutaMasCorta" value="false" checked=""> RESPETAR ORDEN DE LUGARES - RESPECT ORDER OF PLACES<br>' +
				'<label><strong>Seleccione el medio de Transporte.<br>Select the means of Transportation.</strong></label>' +
				'<input type="radio" id="medioDeTransporte" name="medioDeTransporte" value="DRIVING">MANEJANDO - DRIVING<br>'+
		        '<input type="radio" id="medioDeTransporte" name="medioDeTransporte" value="WALKING" checked="" checked=""> CAMINANDO - WALKING<br>' +
				'<input type="radio" id="medioDeTransporte" name="medioDeTransporte" value="BICYCLING"> BICICLETA - BICYCLING<br>' +
				'<input type="radio" id="medioDeTransporte" name="medioDeTransporte" value="TRANSIT"> TRANSPORTE PÚBLICO - TRANSIT<br>' +
				'</div>' +
				'</form>',
		buttons: {
		    continuar: {
				text: 'Continuar',
				btnClass: 'btn-blue',
				action: function(){
					calcularYMostrarRuta(
						                Boolean($('input:radio[name=rutaMasCorta]:checked').val()),
						                $('input:radio[name=medioDeTransporte]:checked').val()
					);
				}
			},
			cancelar: function () {
				
			}
		}
	});
}
var polilinea = null;
function calcularYMostrarRuta(calcular,medioDeTransporte) {
	var puntosIntermedios = new Array();
	for(var x=1;x<(sitiosRuta.length-1);x++){
		puntosIntermedios.push({
			location: sitiosRuta[x].location,
		    stopover: sitiosRuta[x].stopover
		});
	}
	$("#indicacionesRuta").html("");
	directionsService.route({
	  origin: sitiosRuta[0].location,
	  destination: sitiosRuta[sitiosRuta.length-1].location,
	  waypoints: puntosIntermedios,
	  optimizeWaypoints: calcular,
	  travelMode: medioDeTransporte
	}, function(response, status) {
	  if (status === 'OK') {
		directionsDisplay.setDirections(response);
		instruccionesRuta = response.routes[0];
		polilinea = response;
		console.log(polilinea);
		/*var route = response.routes[0];
		//var summaryPanel = document.getElementById('directions-panel');
		//summaryPanel.innerHTML = '';
		// For each route, display summary information.
		for (var i = 0; i < route.legs.length; i++) {
		  var routeSegment = i + 1;
		  $("#indicacionesRuta").append('<b>Route Segment: ' + routeSegment +
			  '</b><br>');
		  $("#indicacionesRuta").append(route.legs[i].start_address + ' to ');
		  $("#indicacionesRuta").append(route.legs[i].end_address + '<br>');
		  $("#indicacionesRuta").append(route.legs[i].distance.text + '<br><br>');
		}*/
	  } else {
		$.alert('Directions request failed due to ' + status);
	  }
	});
}
function limpiarRuta(){
	sitiosRuta.length = 0;
	$("#indicacionesRuta").html("");
	$("#cantidadPuntosRuta").html(sitiosRuta.length);
	eliminarRuta();
}
function mostrarIndicaciones(){
    $("#mostrar-info-indicaciones").trigger('updatelayout');
    $("#mostrar-info-indicaciones").trigger('create');
    $("#mostrar-info-indicaciones").panel("open");
}
function distanciaTotal(result) {
  var total = 0;
  var myroute = result.routes[0];
  for (var i = 0; i < myroute.legs.length; i++) {
    total += myroute.legs[i].distance.value;
  }
  total = total / 1000;
  document.getElementById('total').innerHTML = total + ' km';
}

function eliminarTodosLosMarcadoresDelMapa(){
	for (var i = 0; i < marcadores.length; i++) {
	  marcadores[i].setMap(null);
	}
}
function eliminarRuta(){
	directionsDisplay.setMap(null);
}

function filtrarMarcadores(){
	eliminarTodosLosMarcadoresDelMapa();
	var datos = sitios_localizados;
	if(datos.length>0){
		marcadores.length = 0;
	}
	for(var x=0;x<datos.length;x++){
		if(coincidenciaTipoDeNegocio(datos[x].NOMBRE_SERVICIO)==true && coincidenciaLocalidad(datos[x].ID_COMUNA)==true){
			var marcador = new google.maps.Marker({
				position: {lat: parseFloat(datos[x].LATITUD_NEGOCIO), lng: parseFloat(datos[x].LONGITUD_NEGOCIO)},
				map: mapa,
				icon: 'fotos/iconos/'+datos[x].ICONO_SERVICIO,
				title: datos[x].NOMBRE_SERVICIO
			});
			marcadores.push(marcador);
			var html = '<div class="ui-panel-inner" style="height: 100%; overflow: scroll;">'
				+'<h2 class="titulo-local">'+datos[x].NOMBRE_DE_FANTASIA_NEGOCIO+'</h2>'
				+'<br>'
				+'<div>'
					+datos[x].DESCRIPCION_NEGOCIO
				+'</div>'

			   +'<br>';

			html    +='<!-- Roy Standen B. Start WOWSlider.com BODY section -->'
						+'<div id="wowslider-container1">'
						+'<div class="ws_images"><ul>';
			var fotos = "";
			for(var i=0;i<datos[x].FOTOS.length;i++){
				html    += '<li><a href="#"><img src="fotos/fotos-destinos/'+datos[x].FOTOS[i].UBICACION_FOTO+'" alt="jquery slideshow" title="'+datos[x].FOTOS[i].NOMBRE_FOTO+'" id="wows1_0"/></a></li>';
			}
			html    +='</ul></div>'
							+'<div class="ws_bullets"><div>'
								+'<a href="#" title="Foto2"><span><img src="Plugins/data1/tooltips/foto2.png" alt="Foto2"/>1</span></a>'
								+'<a href="#" title="Sin título"><span><img src="Plugins/data1/tooltips/sin_ttulo.png" alt="Sin título"/>2</span></a>'
							+'</div></div><div class="ws_script" style="position:absolute;left:-99%"><a href="http://wowslider.net">image slider</a> by WOWSlider.com v8.8</div>'
						+'<div class="ws_shadow"></div>'
						+'</div>'
						+'<script type="text/javascript" src="Plugins/engine1/wowslider.js"><'+'/script>'

						+'<script type="text/javascript" src="Plugins/engine1/script.js"><'+'/script>'
			html    +='<br>'
					+'<div data-role="controlgroup" data-type="horizontal">'
					  +'<a href="tel:+'+datos[x].CELULAR_NEGOCIO+'" class="ui-btn ui-corner-all">'
						+'<i class="icofont icofont-ui-call"></i>'
					  +'</a>'
					  +'<a href="https://api.whatsapp.com/send?phone='+datos[x].CELULAR_NEGOCIO+'" class="w3_whatsapp_btn ui-btn ui-corner-all">'
						+'<i class="icofont icofont-brand-whatsapp"></i>'
					  +'</a>'
					  +'<a href="https://m.me/'+datos[x].NOMBRE_USUARIO_FACEBOOK_NEGOCIO+'" class="w3_face_messenger_btn ui-btn ui-corner-all">'
						+'<i class="icofont icofont-social-facebook-messenger"></i>'
					  +'</a>'
					  +'<a href="'+datos[x].FACEBOOK_NEGOCIO+'" class="w3_facebook_btn ui-btn ui-corner-all">'
						+'<i class="icofont icofont-social-facebook"></i>'
					  +'</a>'
					  +'<a href="'+datos[x].PAGINA_WEB_NEGOCIO+'" class="ui-btn ui-corner-all">'
						+'<i class="icofont icofont-web"></i>'
					  +'</a>'
					  +'<a href="#" data-rel="close" class="ui-btn ui-corner-all">'
						+'<i class="icofont icofont-info-circle"></i>'
					  +'</a>'
					  +'<a href="#" data-rel="close" class="ui-btn ui-corner-all">'
						+'<i class="icofont icofont-close-squared"></i>'
					  +'</a>';

			  html    +='<a href="#" onClick="agregarARuta('+x+')" data-rel="close" class="ui-btn ui-corner-all">'
						+'+<i class="icofont icofont-social-google-map"></i>'
					  +'</a>';

			  html    +='</div>'
					+'</div>';

			informacionPorPunto(marcador, html);	
		}
	}
}
function coincidenciaTipoDeNegocio(nombreServicio){
	var serviciosCheckeados = new Array();
	$("input:checkbox:checked").each(function() {
             serviciosCheckeados.push($(this).val());
		
    });
	for(var x=0;x<serviciosCheckeados.length;x++){
		if(nombreServicio==serviciosCheckeados[x]){
			return true;
		}
	}
}
function coincidenciaLocalidad(idLocalidad){
	console.log("Filtrando localidades para id "+idLocalidad);
	console.log(filtro_localidades);
	for(var x=0;x<filtro_localidades.length;x++){
		if(idLocalidad==filtro_localidades[x].id){
			if($('#'+filtro_localidades[x].id+'-localidad').prop('checked')) {
				console.log("El id "+filtro_localidades[x].id+" esta chequeado.");
				return true;
			}
		}
	}
	return false;
}
$(document).ready(function() {
	$( "#panel-filtro" ).panel({
	  beforeclose: function( event, ui ) {
		  filtrarMarcadores();
	  }
	});

});