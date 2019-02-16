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
	<div data-role="page" id="pagina-registrar-servicio" data-url="map-page">
  	  
  	  <div data-role="panel" id="panel-menu1" data-position="right" class="ui-panel ui-panel-position-right ui-panel-display-reveal ui-body-inherit ui-panel-animate ui-panel-open">
		<div class="ui-panel-inner">
			<ul data-role="listview" class="ui-listview">
				<li data-icon="delete" class="ui-first-child">
					<a href="#" data-rel="close" class="ui-btn ui-btn-icon-right ui-icon-delete">Cerrar</a>
				</li>
				<li>
					<a href="registrar_cliente.php" rel="external" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Registrar Cliente</a>
				</li>
				<li>
					<a href="#" class="ui-btn ui-btn-active ui-btn-icon-right ui-icon-carat-r">Registrar Categorías</a>
				</li>
				<li class="ui-last-child">
					<a href="logout.php" rel="external" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Logout</a>
				</li>
			</ul>
		</div>
	</div>
 	  
 	  
 	  
 	  
	  <div data-role="header" data-position="fixed" data-theme="a">
		<h1>Categorías</h1>
		<a href="#panel-menu1"  data-icon="grid" class="ui-btn-right">Menú</a>
	  </div>
	  <div data-role="main" class="ui-content">
			<br>
			<form class="ui-filterable">
				<input id="filtro-clientes" data-type="Buscar" placeholder="Buscar...">
		    </form>
			<table data-role="table" id="table-servicios" data-mode="columntoggle" data-filter="true" data-input="#filtro-clientes" class="ui-body-d ui-shadow table-stripe ui-responsive" data-column-btn-theme="b" data-column-btn-text="Columnas a mostrar..." data-column-popup-theme="a">
			 <thead>
			   <tr class="ui-bar-d">
				 <th>Servicio</th>
				 <th data-priority="1">Ícono</th>
				 <th data-priority="7">Editar</th>
			   </tr>
			 </thead>
			 <tbody>
			   
			 </tbody>
		   </table>
			<br>
		    <br>
		    <br>
	  </div>
	  <div data-role="footer" style="text-align:center;" data-position="fixed">
		<div data-role="controlgroup" data-type="horizontal">
		  <a href="#paginaAgregarServicios" class="ui-btn ui-corner-all ui-shadow ui-icon-plus ui-btn-icon-left">Agregar Servicios</a>
		</div>
	  </div>
	</div>
	
	 
	  
	   
	    
	     
	      
	       
	        
	 <script>
	 	$(document).ready(function(){
			$(document).bind( 'mobileinit', function(){
			  $.mobile.loader.prototype.options.text = "Cargando";
			  $.mobile.loader.prototype.options.textVisible = true;
			  $.mobile.loader.prototype.options.theme = "a";
			  $.mobile.loader.prototype.options.html = "";
			});
			$(document).on( "pageshow", "#paginaAgregarServicios", function() {
				$("#nombre-servicio").val("");
				$("#icono-servicio").val("");
				
			});
		});
		$(document).on( "pagecreate", "#pagina-registrar-servicio", function() {
			objetoServicio.mostrar();
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
			class Servicio extends Ajax{
				constructor(){
					super();
				}
				ingresar(){
					if($("#nombre-servicio").val().length<2){
						alert("Ingrese el Nombre del Servicio");
						return false;
					}
					if($("#icono-servicio").val().length<2){
						alert("Ingrese el Ícono del Servicio");
						return false;
					}
					
					// declaro la variable formData e instancio el objeto nativo de javascript new FormData
					var formData = new FormData(document.getElementById("frm_ingresar_servicio"));

					// iniciar el ajax
					$.ajax({

						url: '../../controlador/registrar-categoria.php',
						// el metodo para enviar los datos es POST
						type: "POST",
						// colocamos la variable formData para el envio de la imagen
						data: formData,
						contentType: false,
						processData: false,
						beforeSend: function(){
							$.mobile.loader.prototype.options.text = "Subiendo Imagen";
							$.mobile.loader.prototype.options.textVisible = true;
							$.mobile.loader.prototype.options.theme = "a";
							$.mobile.loader.prototype.options.html = "";
						},
						success: function(data){
							objetoServicio.mostrar();
							location.href ="#pagina-registrar-servicio";
						} 
					});	
				}
				rescatar_datos_tabla(id,nombre,icono){
					$("#id-servicio").val(id);
					$("#nombre-servicio-editar").val(nombre);
					//$("#icono-servicio-editar").val(icono);
					location.href ="#paginaModificarServicio";
				}
				
				modificar(){
					if($("#nombre-servicio-editar").val().length<2){
						alert("Ingrese el Nombre del Servicio");
						return false;
					}
					
					// declaro la variable formData e instancio el objeto nativo de javascript new FormData
					var formData = new FormData(document.getElementById("frm_modificar_servicio"));

					// iniciar el ajax
					$.ajax({

						url: '../../controlador/registrar-categoria.php',
						// el metodo para enviar los datos es POST
						type: "POST",
						// colocamos la variable formData para el envio de la imagen
						data: formData,
						contentType: false,
						processData: false, 
						beforeSend: function(){
							$.mobile.loader.prototype.options.text = "Subiendo Imagen";
							$.mobile.loader.prototype.options.textVisible = true;
							$.mobile.loader.prototype.options.theme = "a";
							$.mobile.loader.prototype.options.html = "";
						},
						success: function(data){
							objetoServicio.mostrar();
							location.href ="#pagina-registrar-servicio";
						} 
					});
				}
				mostrar(){
					var parametros = {
						'accion' : 'buscar'
					};
					var respuestaAjax = super.enviar(parametros,"../../controlador/registrar-categoria.php");
					respuestaAjax.done(function( datos ) {
						datos = JSON.parse(datos);
						var html = "";
						var funcion_editar = "";
						var funcion_agregar_empresa = "";
						for(var x = 0 ; x < datos.length ; x++){
							funcion_editar = "('"+datos[x].ID_SERVICIO+"',";
							funcion_editar += "'"+datos[x].NOMBRE_SERVICIO+"',";
							funcion_editar += "'"+datos[x].ICONO_SERVICIO+"')";
							
							html += "<tr>";
							html += "<td>"+datos[x].NOMBRE_SERVICIO+"</td>";
							html += "<td>"+'<img src="../../fotos/iconos/'+datos[x].ICONO_SERVICIO+'">'+"</td>";
							html += '<td><a href="#" onclick="objetoServicio.rescatar_datos_tabla'+funcion_editar+'" class="ui-btn ui-icon-edit ui-btn-icon-notext ui-corner-all"></a></td>';
							html += "</tr>";
						}
						$("#table-servicios tbody").html(html).closest( "table#table-servicios" ).table("refresh").trigger("create");
					});
				}
			}
		 	var objetoServicio = new Servicio();
	 </script>        
	 <div data-role="page" id="paginaAgregarServicios">
	  <div data-role="header" data-position="fixed">
		<h1>Agregar Servicio</h1>
	  </div>
	  <br>
      <br>
	  <div data-role="main" class="ui-content">
		
			<div data-theme="a" data-form="ui-body-a" class="ui-body ui-body-a ui-corner-all">
				<form name="frm_ingresar_servicio" id="frm_ingresar_servicio" method="post" action="#" enctype="multipart/form-data" data-ajax="false">
			    	<input type="hidden" name="ingresar" id="ingresar" />
				    <label for="textinput-6" id="label-nombre-servicio">Nombre* :</label>
					<input type="text" name="nombre-servicio" id="nombre-servicio" placeholder="" value="" data-mini="true">
					<label for="textinput-6">Ícono* :</label>
					<input type="file" name="icono-servicio" id="icono-servicio">
					
				</form>
			</div>
	  </div>

	  <div data-role="footer" style="text-align:center;" data-position="fixed">
		<div data-role="controlgroup" data-type="horizontal">
		  <a href="#pagina-registrar-servicio" class="ui-btn ui-corner-all ui-shadow ui-icon-delete ui-btn-icon-left">Cancelar</a>
		  <a href="#" onClick="objetoServicio.ingresar();" class="ui-btn ui-corner-all ui-shadow ui-icon-check ui-btn-icon-left">Guardar</a>
		</div>
	  </div>
	</div> 
	
	
	
	
	
	
	
	
	
	
	
	
	<div data-role="page" id="paginaModificarServicio">
	  <div data-role="header" data-position="fixed">
		<h1>Modificar Servicio</h1>
	  </div>
	  <br>
      <br>
	  <div data-role="main" class="ui-content">
		
			<div data-theme="a" data-form="ui-body-a" class="ui-body ui-body-a ui-corner-all">
				<form name="frm_modificar_servicio" id="frm_modificar_servicio" method="post" action="#" enctype="multipart/form-data" data-ajax="false">
			    	<input type="hidden" name="modificar" id="modificar" />
			    	<input type="hidden" name="id-servicio" id="id-servicio" />
				    <label for="textinput-6" id="label-nombre-servicio-editar">Nombre* :</label>
					<input type="text" name="nombre-servicio-editar" id="nombre-servicio-editar" placeholder="" value="" data-mini="true">
					<label for="textinput-6">Ícono* :</label>
					<input type="file" name="icono-servicio-editar" id="icono-servicio-editar">
					
				</form>
			</div>
	  </div>

	  <div data-role="footer" style="text-align:center;" data-position="fixed">
		<div data-role="controlgroup" data-type="horizontal">
		  <a href="#pagina-registrar-servicio" class="ui-btn ui-corner-all ui-shadow ui-icon-delete ui-btn-icon-left">Cancelar</a>
		  <a href="#" onClick="objetoServicio.modificar();" class="ui-btn ui-corner-all ui-shadow ui-icon-check ui-btn-icon-left">Modificar</a>
		</div>
	  </div>
	</div>
	
</body>
</html>