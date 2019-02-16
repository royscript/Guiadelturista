<?php
session_start();
if(!isset($_SESSION["ID_PERSONA"])){
	header('Location: ../../login.php');
}
?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<title>Guía del Turista</title>
	<link rel="stylesheet" href="../../Plugins/themes/fumysam.min.css" />
	<link rel="stylesheet" href="../../Plugins/themes/jquery.mobile.icons.min.css" />
	<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css" />
	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	<script src="../../Plugins/mascaras/jquery.maskedinput.js"></script>
	<script src="../../Plugins/valida-rut/jquery.rut.js"></script>
	<script src="../../Plugins/jquery-confirm-master/js/jquery-confirm.js"></script>
	<link rel="stylesheet" href="../../Plugins/jquery-confirm-master/css/jquery-confirm.css" />
</head>
<body>
	<div data-role="page" id="pagina-mis-negocios">
  	  
  	  <div data-role="panel" id="panel-menu1" data-position="right" class="ui-panel ui-panel-position-right ui-panel-display-reveal ui-body-inherit ui-panel-animate ui-panel-open">
		<div class="ui-panel-inner">
			<ul data-role="listview" class="ui-listview">
				<li data-icon="delete" class="ui-first-child">
					<a href="#" data-rel="close" class="ui-btn ui-btn-icon-right ui-icon-delete">Cerrar</a>
				</li>
				<li>
					<a href="#" class="ui-btn ui-btn-active ui-btn-icon-right ui-icon-carat-r">Mis Negocios</a>
				</li>
				<li>
					<a href="registrar_categoria.php" rel="external" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Datos Personales</a>
				</li>
				<li class="ui-last-child">
					<a href="../administrador/logout.php" rel="external" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Logout</a>
				</li>
			</ul>
		</div>
	</div>
 	  
 	  
 	  
 	  
	  <div data-role="header" data-position="fixed" data-theme="a">
		<h1>Mis Negocios</h1>
		<a href="#panel-menu1"  data-icon="grid" class="ui-btn-right">Menú</a>
	  </div>
	  <div data-role="main" class="ui-content">
			<br>
			<form class="ui-filterable">
				<input type="search" id="filtro-mis-negocios" data-type="Buscar" placeholder="Buscar...">
		    </form>
			<table data-role="table" id="table-mis-negocios" data-mode="columntoggle" data-filter="true" data-input="#filtro-mis-negocios" class="ui-body-d ui-shadow table-stripe ui-responsive" data-column-btn-theme="b" data-column-btn-text="Columnas a mostrar..." data-column-popup-theme="a">
			 <thead>
			   <tr class="ui-bar-d">
				 <th>Nombre de Fantasía</th>
				 <th data-priority="1">Agregar Fotos</th>
				 <th data-priority="2">Establecer Ubicación</th>
				 <th data-priority="3">Modificar datos</th>
			   </tr>
			 </thead>
			 <tbody>
			   
			 </tbody>
		   </table>
			<br>
		    <br>
		    <br>
	  </div>
	</div>
	
	 
	  
	   
	    
	     
	      
	       
	        
	 <script>
	 	$(document).ready(function(){
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
			
			$(document).bind( 'mobileinit', function(){
			  $.mobile.loader.prototype.options.text = "Cargando";
			  $.mobile.loader.prototype.options.textVisible = true;
			  $.mobile.loader.prototype.options.theme = "a";
			  $.mobile.loader.prototype.options.html = "";
			});
			$(document).on( "pagecreate", "#paginaAgregarCliente", function() {
				
				$("#id").val("");
				$("#rut").val("");
				$("#nombre_completo").val("");
				$("#nombre_usuario").val("");
				$("#contrasena").val("");
				$("#email").val("");
				$("#celular").val("");
				
				$("#celular").mask("+56 9 9999 9999");
				$("#celular").blur(function(){
					if($("#celular").val().length==15){
						$("#label-celular").html('<strong>Celular* :</strong>');
					}else{
						$("#label-celular").html('<strong style="color:red;">Celular* : ¡Está mal escrito! Ej: +56 9 9292 6213</strong>');
					}
				});
				$("#email").keyup(function(){
					if($("#email").val().indexOf('@', 0) == -1 || $("#email").val().indexOf('.', 0) == -1) {
						$("#label-email").html('<strong style="color:red;">E-mail* : ¡Está mal escrito! Ej: ejemplo@gmail.com</strong>');
					}else{
						$("#label-email").html('<strong>E-mail* :</strong>');
					}
				});
				$("#rut")
				  .rut({formatOn: 'keyup', validateOn: 'keyup'})
				  .on('rutInvalido', function(){ 
					$("#label-rut").html("<strong style='color:red;'>Rut* : ¡Inválido!</strong>");
				  })
				  .on('rutValido', function(){ 
					$("#label-rut").html("<strong>Rut* :</strong>");
				  });
			});
		});
		$(document).on( "pagecreate", "#pagina-mis-negocios", function() {
			obtejoMisNegocios.mostrarMisNegocios();
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
			class Negocio extends Ajax{
				constructor(){
					super();
				}
				cargarPaginaFotos(id,nombre_fantasia){
					$("#id-empresa-foto").val(id);
					$("#nombre_empresa_foto").html(nombre_fantasia);
					var parametros = {
						'id' : id,
						'accion' : 'cargarFotosDelNegocio'
					};
					var respuestaAjax = super.enviar(parametros,"../../controlador/mis_negocios.php");
					window.setTimeout(function(){
						respuestaAjax.done(function( datos ) {
							datos = JSON.parse(datos);
							for(var x=0;x<datos.length;x++){
								var nombre_foto = datos[x].NOMBRE_FOTO;
								var ubicacion_foto = datos[x].UBICACION_FOTO;
								if(/imagen-1/.test(ubicacion_foto)){
									$("#nombre-imagen-1").val(nombre_foto);
									$("#ver-imagen-1").attr("src","../../fotos/fotos-destinos/"+ubicacion_foto);
								}
								
								if(/imagen-2/.test(ubicacion_foto)){
									$("#nombre-imagen-2").val(nombre_foto);
									$("#ver-imagen-2").attr("src","../../fotos/fotos-destinos/"+ubicacion_foto);
								}
								
								if(/imagen-3/.test(ubicacion_foto)){
									$("#nombre-imagen-3").val(nombre_foto);
									$("#ver-imagen-3").attr("src","../../fotos/fotos-destinos/"+ubicacion_foto);
								}
							}
						});
					},2000);
					
					location.href = '#pagina-agregar-fotos';
				}
				guardarFotos(){
					var formData = new FormData(document.getElementById("frm_guardar_fotos"));
					$.mobile.loader.prototype.options.text = "Subiendo Imagenes";
					$.mobile.loader.prototype.options.textVisible = true;
					$.mobile.loader.prototype.options.theme = "a";
					$.mobile.loader.prototype.options.html = "";
					// iniciar el ajax
					$.ajax({

						url: '../../controlador/mis_negocios.php',
						// el metodo para enviar los datos es POST
						type: "POST",
						// colocamos la variable formData para el envio de la imagen
						data: formData,
						contentType: false,
						processData: false,
						beforeSend: function(){
							$.mobile.loader.prototype.options.text = "Subiendo Imagenes";
							$.mobile.loader.prototype.options.textVisible = true;
							$.mobile.loader.prototype.options.theme = "a";
							$.mobile.loader.prototype.options.html = "";
						},
						success: function(data){
							obtejoMisNegocios.mostrarMisNegocios();
							location.href ="#pagina-mis-negocios";
						} 
					});	
				}
				rescatar_datos_tabla(id,comuna,txt_comuna,nombre_fantasia,descripcion,direccion,referencia,celular,whatsap,facebook,pagina_web,nombre_usuario_facebook){
					$("#id-negocio").val(id);
					
					if(txt_comuna!='null'){
						$("#comuna").html('<option value="'+comuna+'">'+txt_comuna+'</option>');
					}
					
					$("#nombre_de_fantasia").val(nombre_fantasia);
					if(descripcion!='null'){
						$("#descripcion").val(descripcion);
					}
					if(direccion!='null'){
						$("#direccion").val(direccion);
					}
					if(referencia!='null'){
						$("#referencia").val(referencia);
					}
					if(celular!='null'){
						$("#celular").val(celular);
					}
					if(whatsap!='null'){
						$("#whatsapp").val(whatsap);
					}
					if(facebook!='null'){
						$("#facebook").val(facebook);
					}
					if(pagina_web!='null'){
						$("#pagina_web").val(pagina_web);
					}
					if(nombre_usuario_facebook!='null'){
						$("#nombre_usuario_facebook_negocio").val(nombre_usuario_facebook);
					}
					var parametros = {
						'id' : id,
						'accion' : 'mostrarServiciosDelNegocio'
					};
					var respuestaAjax = super.enviar(parametros,"../../controlador/mis_negocios.php");
					window.setTimeout(function(){
						respuestaAjax.done(function( datos ) {
							datos = JSON.parse(datos);
							for(var x=0;x<datos.length;x++){
								$("#"+datos[x].ID_SERVICIO).prop('checked', true).checkboxradio('refresh');
							}
						});
					},2000);
					
					location.href ="#pagina_caracteristicas_del_negocio_seleccionado";
				}
				
				mostrarMisNegocios(){
					var parametros = {
						'accion' : 'mostrarMisNegocios'
					};
					var respuestaAjax = super.enviar(parametros,"../../controlador/mis_negocios.php");
					respuestaAjax.done(function( datos ) {
						if(datos.length==0){
							
						}else{
							datos = JSON.parse(datos);
							var html = "";
							var funcion_seleccionar_negocio = "";
							for(var x = 0 ; x < datos.length ; x++){
								funcion_seleccionar_negocio = "("+datos[x].ID_NEGOCIO+",";
								funcion_seleccionar_negocio += ""+datos[x].ID_COMUNA+",";
								funcion_seleccionar_negocio += "'"+datos[x].COMUNA_RESIDENTE+"',";
								funcion_seleccionar_negocio += "'"+datos[x].NOMBRE_DE_FANTASIA_NEGOCIO+"',";
								funcion_seleccionar_negocio += "'"+datos[x].DESCRIPCION_NEGOCIO+"',";
								funcion_seleccionar_negocio += "'"+datos[x].DIRECCION_NEGOCIO+"',";
								funcion_seleccionar_negocio += "'"+datos[x].REFERENCIA_DIRECCION_NEGOCIO+"',";
								funcion_seleccionar_negocio += "'"+datos[x].CELULAR_NEGOCIO+"',";
								funcion_seleccionar_negocio += "'"+datos[x].WHATSAPP_NEGOCIO+"',";
								funcion_seleccionar_negocio += "'"+datos[x].FACEBOOK_NEGOCIO+"',";
								funcion_seleccionar_negocio += "'"+datos[x].PAGINA_WEB_NEGOCIO+"',";
								funcion_seleccionar_negocio += "'"+datos[x].NOMBRE_USUARIO_FACEBOOK_NEGOCIO+"')";
								
								html += "<tr>";
								html += "<td>"+datos[x].NOMBRE_DE_FANTASIA_NEGOCIO+"</td>";
								html += '<td><a href="#" onclick="obtejoMisNegocios.cargarPaginaFotos('+datos[x].ID_NEGOCIO+','+"'"+datos[x].NOMBRE_DE_FANTASIA_NEGOCIO+"'"+');" class="ui-btn ui-icon-camera ui-btn-icon-notext ui-corner-all"></a></td>';
								html += '<td><a href="#" onclick="obtejoMisNegocios.establecerUbicacion('+datos[x].ID_NEGOCIO+','+"'"+datos[x].NOMBRE_DE_FANTASIA_NEGOCIO+"'"+');" class="ui-btn ui-icon-location ui-btn-icon-notext ui-corner-all"></a></td>';
								html += '<td><a href="#" onclick="obtejoMisNegocios.rescatar_datos_tabla'+funcion_seleccionar_negocio+';" class="ui-btn ui-icon-eye ui-btn-icon-notext ui-corner-all"></a></td>';
								html += "</tr>";
							}
							$("#table-mis-negocios tbody").html(html).closest("table#table-mis-negocios").table("refresh").trigger("create");
						}
						
					});
				}
				establecerUbicacion(id,local){
					$("#id-localizacion").val(id);
					$("#label-nombre-local").html("Local : "+local);
					location.href ="#pagina-ubicacion-local";
				}
				guardarGeolocalizacion(){
					var parametros = {
						'latitud' : parseFloat($("#latitud").val()),
						'longitud' : parseFloat($("#longitud").val()),
						'id-negocio' : parseInt($("#id-localizacion").val()),
						'accion' : 'guardarGeolocalizacion'
					};
					if(parseFloat($("#latitud").val())==""){
						alert("Debe ingresar la latitud mediante la función del gps.");
						return false;
					}
					if(parseFloat($("#longitud").val())==""){
						alert("Debe ingresar la longitud mediante la función del gps.");
						return false;
					}
					var respuestaAjax = super.enviar(parametros,"../../controlador/mis_negocios.php");
					respuestaAjax.done(function( datos ) {
						location.href ="#pagina-mis-negocios";
					});
				}
				modificar(){
					<?php
						include_once("../../modelo/Conexion.class.php");
						$conectar = new Conexion();
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
					 var servicios_seleccionados = new Array();
					 for(var x=0; x<servicios_checkboxes.length;x++){
						 if($("#"+servicios_checkboxes[x].id).is(":checked")){
							 servicios_seleccionados.push({ id:servicios_checkboxes[x].id });
						 }
					 }
					var parametros = {
						'id-negocio' : $("#id-negocio").val(),
						'comuna' : $("#comuna").val(),
						'nombre_de_fantasia' : $("#nombre_de_fantasia").val(),
						'descripcion' : $("#descripcion").val(),
						'direccion' : $("#direccion").val(),
						'referencia' : $("#referencia").val(),
						'celular' : $("#celular").val(),
						'whatsapp' : $("#whatsapp").val(),
						'facebook' : $("#facebook").val(),
						'pagina_web' : $("#pagina_web").val(),
						'nombre_usuario_facebook_negocio' : $("#nombre_usuario_facebook_negocio").val(),
						'servicios_seleccionados' : servicios_seleccionados,
						'accion' : 'editar'
					};
					if(servicios_seleccionados.length==0){
						alert("Debe seleccionar al menos un servicio o no saldrá su negocio en el mapa!!");
						return false;
					}
					if($("#comuna").val()==0){
						alert("Seleccione la comuna");
						return false;
					}
					if($("#nombre_de_fantasia").val().length<2){
						alert("Ingrese el Nombre de Fantasía");
						return false;
					}
					if($("#descripcion").val().length<2){
						alert("Ingrese la descripción de su negocio.");
						return false;
					}
					if($("#celular").val().length<2){
						alert("Ingrese el celular de su negocio para que lo llamen los clientes.");
						return false;
					}
					if($("#whatsapp").val().length<2){
						alert("Ingrese el whatsapp de su negocio para que le escriban");
						return false;
					}
					var respuestaAjax = super.enviar(parametros,"../../controlador/mis_negocios.php");
					respuestaAjax.done(function( datos ) {
						obtejoMisNegocios.mostrarMisNegocios();
						location.href ="#pagina-mis-negocios";
					});
				}
			}
		 	var obtejoMisNegocios = new Negocio();
		 
		 
		 $(document).ready(function(){
			 $('#comuna').select2({
				placeholder: 'Selecciona la comuna en que vives',
				ajax: {
				  url: '../../controlador/mis_negocios.php?buscar_comuna',
				  dataType: 'json',
				  delay: 250,
				  processResults: function (data) {
					return {
					  results: data
					};
				  },
				  cache: true
				}
			  });
			 $(document).on("pagebeforehide","#pagina_caracteristicas_del_negocio_seleccionado",function(){
				
				 <?php
						include_once("../../modelo/Conexion.class.php");
						$conectar = new Conexion();
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
					 for(var x=0; x<servicios_checkboxes.length;x++){
						 $("#"+servicios_checkboxes[x].id).filter(':checkbox').prop('checked',false).checkboxradio("refresh");
					 }
			 });
			 $(document).on( "pagecreate", "#pagina_caracteristicas_del_negocio_seleccionado", function() {
				 <?php
					include_once("../../modelo/Conexion.class.php");
					$conectar = new Conexion();
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
				 
				 var checkbox = "";
				 for(var x=0; x<servicios_checkboxes.length;x++){
					 checkbox = '<label><input type="checkbox" name="'+servicios_checkboxes[x].id+'" id="'+servicios_checkboxes[x].id+'" /><img src="../../fotos/iconos/'+servicios_checkboxes[x].icono+'"/> '+servicios_checkboxes[x].nombre+'</label>';
					 $('#grupo-checkbox').append(checkbox);
					 $('[type=checkbox]').checkboxradio().trigger('create');
					 $('#grupo-checkbox').controlgroup().trigger('create');
				 }
			});
			 $(document).on( "pageshow", "#pagina_caracteristicas_del_negocio_seleccionado", function() {
				if($("#id-negocio").val()==""){
					location.href ="#pagina-mis-negocios";
				}
			});
		 });
	 </script>        
	 <div data-role="page" id="pagina_caracteristicas_del_negocio_seleccionado">
	  <div data-role="header" data-position="fixed">
		<h1>Mi negocio</h1>
	  </div>
	  <br>
      <br>
	  <div data-role="main" class="ui-content">
		
			<div data-theme="a" data-form="ui-body-a" class="ui-body ui-body-a ui-corner-all">
				<form method="post" action="#">
			    	<input type="hidden" name="id-negocio" id="id-negocio">
				    <label for="textinput-6" id="label-comuna">Comuna* :</label>
				    <select name="comuna" id="comuna" style="width:100%;" data-role="none">
					  <option>Seleccione la comuna</option>
					</select>
					<label for="textinput-6">Nombre de Fantasía* :</label>
					<input type="text" name="nombre_de_fantasia" id="nombre_de_fantasia" placeholder="" value="" data-mini="true">
					<label for="textinput-6">Descripción* :</label>
					<input type="text" name="descripcion" id="descripcion" placeholder="" value="" data-mini="true">
					<label for="textinput-6">Dirección* :</label>
					<input type="text" name="direccion" id="direccion" placeholder="" value="" data-mini="true">
					<label for="textinput-6" id="label-email">Referencia* :</label>
					<input type="text" name="referencia" id="referencia" placeholder="" value="" data-mini="true">
					<label for="label-celular" id="label-celular">Celular* :</label>
					<input type="text" name="celular" id="celular" placeholder="" value="" data-mini="true">
					<label for="label-celular" id="label-celular">Whatsapp* :</label>
					<input type="text" name="whatsapp" id="whatsapp" placeholder="" value="" data-mini="true">
					<label for="label-celular" id="label-celular">Facebook o Fanpage* :</label>
					<input type="text" name="facebook" id="facebook" placeholder="" value="" data-mini="true">
					<label for="label-celular" id="label-celular">Página Web* :</label>
					<input type="text" name="pagina_web" id="pagina_web" placeholder="" value="" data-mini="true">
					<label for="label-celular" id="label-celular">Nombre de usuario url facebook* :</label>
					<input type="text" name="nombre_usuario_facebook_negocio" id="nombre_usuario_facebook_negocio" placeholder="" value="" data-mini="true">
				</form>
				<br>
		    	<fieldset data-role="controlgroup" id="grupo-checkbox">
					<legend><strong>Seleccione los servicios de su negocio :</strong></legend>
				</fieldset>
		    </div>
	  </div>

	  <div data-role="footer" style="text-align:center;" data-position="fixed">
		<div data-role="controlgroup" data-type="horizontal">
		  <a href="#pagina-mis-negocios" class="ui-btn ui-corner-all ui-shadow ui-icon-delete ui-btn-icon-left">Cancelar</a>
		  <a href="#" onClick="obtejoMisNegocios.modificar();" class="ui-btn ui-corner-all ui-shadow ui-icon-check ui-btn-icon-left">Guardar</a>
		</div>
	  </div>
	</div> 
	
	
	
	
	
	
	
	
	
	
	
	<script>
		function capturar_ubicacion(){
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
						$("#latitud").val(position.coords.latitude);
						$("#longitud").val(position.coords.longitude);
			
						$("#mensaje-captura-geolocalizacion").html("<strong>Mensaje : Latitud y Longitud capturadas.</strong>");
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
		function onErrorGeolocating(error){
			switch(error.code){
				case error.PERMISSION_DENIED:
					$("#mensaje-captura-geolocalizacion").html("<strong style='color:red;'>Error : El usuario deniega el acceso al GPS desde su celular. Presione el botón cancelar y vuelva a recargar la página. Si su equipo no le muestra esta opción elimine el historial y las cookies de su navegador y vuelva a ingresar a la aplicación.</strong>");
				break;
				
				case error.POSITION_UNAVAILABLE:
					$("#mensaje-captura-geolocalizacion").html("<strong style='color:red;'>Error : Existe un problema obteniendo la ubicación gps desde su dispositivo.</strong>");
				break;
				
				case error.TIMEOUT:
					$("#mensaje-captura-geolocalizacion").html("<strong style='color:red;'>Error : La aplicación agotó el tiempo de espera para obtener la posición del dispositivo.</strong>");
				break;
				
				default:
					$("#mensaje-captura-geolocalizacion").html("<strong style='color:red;'>Error : Problema desconocido.</strong>");
				break;
			}
		}
		$(document).ready(function(){
			$(document).on( "pageshow", "#pagina-ubicacion-local", function() {
				capturar_ubicacion();
				if($("#id-localizacion").val()==""){
					location.href ="#pagina-mis-negocios";
				}
			});
		});
	</script>
	<div data-role="page" id="pagina-ubicacion-local">
	  <div data-role="header" data-position="fixed">
		<h1>Establecer Localizacion del Negocio</h1>
	  </div>
	  <br>
      <br>
	  <div data-role="main" class="ui-content">
		
			<div data-theme="a" data-form="ui-body-a" class="ui-body ui-body-a ui-corner-all">
				<form method="post" action="#">
			    	<input type="hidden" name="id-localizacion" id="id-localizacion"/>
				    <label for="textinput-6" id="label-nombre-local">Local :</label>
					<label for="textinput-6">Latitud* :</label>
					<input type="text" name="latitud" id="latitud" placeholder="" value="" data-mini="true">
					<label for="textinput-6">Longitud* :</label>
					<input type="text" name="longitud" id="longitud" placeholder="" value="" data-mini="true">
					<label for="textinput-6" id="mensaje-captura-geolocalizacion">Mensaje :</label>
					<a href="#" onClick="capturar_ubicacion();" class="ui-btn ui-corner-all ui-shadow ui-icon-location ui-btn-icon-left">Volver a intentar</a>
				</form>
			</div>
	  </div>

	  <div data-role="footer" style="text-align:center;" data-position="fixed">
		<div data-role="controlgroup" data-type="horizontal">
		  <a href="#pagina-mis-negocios" class="ui-btn ui-corner-all ui-shadow ui-icon-delete ui-btn-icon-left">Cancelar</a>
		  <a href="#" onClick="obtejoMisNegocios.guardarGeolocalizacion();" class="ui-btn ui-corner-all ui-shadow ui-icon-check ui-btn-icon-left">Guardar</a>
		</div>
	  </div>
	</div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	<style>
	.controlgroup-textinput{
		padding-top:.22em;
		padding-bottom:.22em;
	}
	</style>
	<script>
	$(document).ready(function(){
		$(document).on( "pageload", "#pagina-agregar-empresa", function() {
			
			
		});
		document.getElementById("imagen-1").onchange = function() {
		  var reader = new FileReader(); //instanciamos el objeto de la api FileReader

		  reader.onload = function(e) {
			//en el evento onload del FileReader, asignamos el path a el src del elemento imagen de html
			document.getElementById("ver-imagen-1").src = e.target.result;
		  };

		  // read the image file as a data URL.
		  reader.readAsDataURL(this.files[0]);
		};
		document.getElementById("imagen-2").onchange = function() {
		  var reader = new FileReader(); //instanciamos el objeto de la api FileReader

		  reader.onload = function(e) {
			//en el evento onload del FileReader, asignamos el path a el src del elemento imagen de html
			document.getElementById("ver-imagen-2").src = e.target.result;
		  };

		  // read the image file as a data URL.
		  reader.readAsDataURL(this.files[0]);
		};
		document.getElementById("imagen-3").onchange = function() {
		  var reader = new FileReader(); //instanciamos el objeto de la api FileReader

		  reader.onload = function(e) {
			//en el evento onload del FileReader, asignamos el path a el src del elemento imagen de html
			document.getElementById("ver-imagen-3").src = e.target.result;
		  };

		  // read the image file as a data URL.
		  reader.readAsDataURL(this.files[0]);
		};
	});
	</script>
	<style>
		.imagen-previsualizada{
			max-width: 90%;
		}
	</style>
	<div data-role="page" id="pagina-agregar-fotos">
	  <div data-role="header" data-position="fixed">
		<h1>Agregar Fotos</h1>
	  </div>
	  <br>
      <br>
	  <div data-role="main" class="ui-content">
		
			<div data-theme="a" data-form="ui-body-a" class="ui-body ui-body-a ui-corner-all">
				<form name="frm_guardar_fotos" id="frm_guardar_fotos" method="post" action="#" enctype="multipart/form-data" data-ajax="false">
			    	<input type="hidden" name="id-empresa-foto" id="id-empresa-foto">
			    	<input type="hidden" name="guardarFotos" id="guardarFotos">
			    	<h2 id="nombre_empresa_foto"></h2>
					<br>
					<label for="textinput-6" id="label-nombre-local">Nombre Imagen 1 :</label>
					<input type="text" name="nombre-imagen-1" id="nombre-imagen-1">
					<label for="textinput-6" id="label-nombre-local">Imagen 1 :</label>
					<input type="file" name="imagen-1" id="imagen-1">
					<label for="textinput-6" id="label-nombre-local">Previsualización Imagen 1 :</label>
					<img src="../../fotos/fotos-sistema/no-image-avalible.png" id="ver-imagen-1" class="imagen-previsualizada"/>
					<label for="textinput-6" id="label-nombre-local">Nombre Imagen 2 :</label>
					<input type="text" name="nombre-imagen-2" id="nombre-imagen-2">
					<label for="textinput-6" id="label-nombre-local">Imagen 2 :</label>
					<input type="file" name="imagen-2" id="imagen-2">
					<label for="textinput-6" id="label-nombre-local">Previsualización Imagen 2 :</label>
					<img src="../../fotos/fotos-sistema/no-image-avalible.png" id="ver-imagen-2" class="imagen-previsualizada"/>
					<label for="textinput-6" id="label-nombre-local">Nombre Imagen 3 :</label>
					<input type="text" name="nombre-imagen-3" id="nombre-imagen-3">
					<label for="textinput-6" id="label-nombre-local">Imagen 3 :</label>
					<input type="file" name="imagen-3" id="imagen-3">
					<label for="textinput-6" id="label-nombre-local">Previsualización Imagen 3 :</label>
					<img src="../../fotos/fotos-sistema/no-image-avalible.png" id="ver-imagen-3" class="imagen-previsualizada"/>
					<br>
					<br>
					<br>
				</form>
			</div>
	  </div>

	  <div data-role="footer" style="text-align:center;" data-position="fixed">
		<div data-role="controlgroup" data-type="horizontal">
		  <a href="#pagina-mis-negocios" class="ui-btn ui-corner-all ui-shadow ui-icon-delete ui-btn-icon-left">Cancelar</a>
		  <a href="#" onClick="obtejoMisNegocios.guardarFotos();" class="ui-btn ui-corner-all ui-shadow ui-icon-check ui-btn-icon-left">Guardar</a>
		</div>
	  </div>
	</div>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
</body>
</html>