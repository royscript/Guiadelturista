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
	<div data-role="page" id="pagina-registrar-cliente" data-url="map-page">
  	  
  	  <div data-role="panel" id="panel-menu1" data-position="right" class="ui-panel ui-panel-position-right ui-panel-display-reveal ui-body-inherit ui-panel-animate ui-panel-open">
		<div class="ui-panel-inner">
			<ul data-role="listview" class="ui-listview">
				<li data-icon="delete" class="ui-first-child">
					<a href="#" data-rel="close" class="ui-btn ui-btn-icon-right ui-icon-delete">Cerrar</a>
				</li>
				<li>
					<a href="#" class="ui-btn ui-btn-active ui-btn-icon-right ui-icon-carat-r">Registrar Cliente</a>
				</li>
				<li>
					<a href="registrar_categoria.php" rel="external" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Registrar Categorías</a>
				</li>
				<li class="ui-last-child">
					<a href="logout.php" rel="external" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Logout</a>
				</li>
			</ul>
		</div>
	</div>
 	  
 	  
 	  
 	  
	  <div data-role="header" data-position="fixed" data-theme="a">
		<h1>Clientes</h1>
		<a href="#panel-menu1"  data-icon="grid" class="ui-btn-right">Menú</a>
	  </div>
	  <div data-role="main" class="ui-content">
			<br>
			<form class="ui-filterable">
				<input id="filtro-clientes" data-type="Buscar" placeholder="Buscar...">
		    </form>
			<table data-role="table" id="table-clientes" data-mode="columntoggle" data-filter="true" data-input="#filtro-clientes" class="ui-body-d ui-shadow table-stripe ui-responsive" data-column-btn-theme="b" data-column-btn-text="Columnas a mostrar..." data-column-popup-theme="a">
			 <thead>
			   <tr class="ui-bar-d">
				 <th>Nombre Completo</th>
				 <th data-priority="1">Rut</th>
				 <th data-priority="2">Celular</th>
				 <th data-priority="3">E-mail</th>
				 <th data-priority="4">Usuario</th>
				 <th data-priority="5">Contraseña</th>
				 <th data-priority="5">Agregar Empresa</th>
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
		  <a href="#paginaAgregarCliente" class="ui-btn ui-corner-all ui-shadow ui-icon-plus ui-btn-icon-left">Agregar Cliente</a>
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
		$(document).on( "pagecreate", "#pagina-registrar-cliente", function() {
			objetoPersona.mostrar();
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
			class Persona extends Ajax{
				constructor(){
					super();
					this.id = null;
					this.rut = null;
					this.nombre_completo = null;
					this.nombre_usuario = null;
					this.contrasena = null;
					this.email = null;
					this.celular = null;
				}
				ingresar(){
					var parametros = {
						'rut' : $("#rut").val(),
						'nombre_completo' : $("#nombre_completo").val(),
						'nombre_usuario' : $("#nombre_usuario").val(),
						'contrasena' : $("#contrasena").val(),
						'email' : $("#email").val(),
						'celular' : $("#celular").val(),
						'accion' : 'ingresar'
					};
					if($("#rut").val().length<2){
						alert("Ingrese el Rut");
						return false;
					}
					if($("#nombre_completo").val().length<2){
						alert("Ingrese el Nombre Completo");
						return false;
					}
					if($("#contrasena").val().length<2){
						alert("Ingrese la contraseña");
						return false;
					}
					if($("#nombre_usuario").val().length<2){
						alert("Ingrese el Nombre de Usuario");
						return false;
					}
					if($("#email").val().length<2){
						alert("Ingrese el E-mail");
						return false;
					}
					if($("#celular").val().length<2){
						alert("Ingrese el Celular");
						return false;
					}
					var respuestaAjax = super.enviar(parametros,"../../controlador/registrar-cliente.php");
					respuestaAjax.done(function( datos ) {
						objetoPersona.mostrar();
						location.href ="#pagina-registrar-cliente";
					});
				}
				rescatar_datos_tabla(id,rut,nombre_completo,nombre_usuario,contrasena,email,celular,estado){
					$("#id-editar").val(id);
					$("#rut-editar").val(rut);
					$("#nombre_completo-editar").val(nombre_completo);
					$("#nombre_usuario-editar").val(nombre_usuario);
					$("#contrasena-editar").val(contrasena);
					$("#email-editar").val(email);
					$("#celular-editar").val(celular);
					console.log(estado);
					if (estado==1) {
						 $('#estado').val('1');
					 }
					 else {
						 $('#estado').val('0');
					 }
					 try {
						 $('#estado').slider("refresh");
					 }
					 catch (err) {
						 console.log ("Error occurred refreshing slider (probabily first time!)");
						 window.setTimeout(function(){
							 $('#estado').slider("refresh").trigger("create");
						 },2000);
						 
					 }
					location.href ="#pagina-modificar-cliente";
				}
				prepararFormularioAgregarEmpresa(id,rut,nombre_completo){
					$("#id-agregar-empresa").val(id);
					$("#rut-agregar-empresa").html("Rut : "+rut);
					$("#nombre_completo-agregar-empresa").html("Nombre Cliente : "+nombre_completo);
					$("#table-negocios-del-cliente tbody").empty();
					window.setTimeout(function(){
						objetoPersona.mostrarNegocio();
					},1000);
					location.href ="#pagina-agregar-empresa";
				}
				agregarNegocio(){
					if($("#nombre-de-fantasia").val().length==0){
						alert("Debes escribir el nombre de fantasía del negocio para agregarlo");
						return false;
					}
					var parametros = {
						'id' : $("#id-agregar-empresa").val(),
						'nombre-de-fantasia' : $("#nombre-de-fantasia").val(),
						'accion' : 'agregarNegocio'
					};
					var respuestaAjax = super.enviar(parametros,"../../controlador/registrar-cliente.php");
					respuestaAjax.done(function( datos ) {
						objetoPersona.mostrarNegocio();
						$("#nombre-de-fantasia").val("");
					});
				}
				eliminarNegocio(id,nombreFantasia){
					var parametros = {
						'id' : id,
						'accion' : 'eliminarNegocio'
					};
					$.confirm({
						title: '¿Desea eliminar?',
						content: '¿esta seguro(a) que desea eliminar este negocio? <strong>'+nombreFantasia+'</strong>',
						buttons: {
							Eliminar: {
								btnClass: 'btn-red', // class for the button
								action: function(){
									var respuestaAjax = objetoPersona.enviar(parametros,"../../controlador/registrar-cliente.php");
									respuestaAjax.done(function( datos ) {
										objetoPersona.mostrarNegocio();
									});
								}
							},
							Cancelar: function () {
								
							}
						}
					});
				}
				mostrarNegocio(){
					var parametros = {
						'id' : $("#id-agregar-empresa").val(),
						'accion' : 'mostrarNegocio'
					};
					var respuestaAjax = super.enviar(parametros,"../../controlador/registrar-cliente.php");
					respuestaAjax.done(function( datos ) {
						if(datos.length==0){
							
						}else{
							datos = JSON.parse(datos);
							var html = "";
							var funcion_eliminar = "";
							for(var x = 0 ; x < datos.length ; x++){
								funcion_eliminar = "("+datos[x].ID_NEGOCIO+",";
								funcion_eliminar += "'"+datos[x].NOMBRE_DE_FANTASIA_NEGOCIO+"')";
								
								html += "<tr>";
								html += "<td>"+datos[x].NOMBRE_DE_FANTASIA_NEGOCIO+"</td>";
								html += '<td><a href="#" onclick="objetoPersona.eliminarNegocio'+funcion_eliminar+';" class="ui-btn ui-icon-delete ui-btn-icon-notext ui-corner-all"></a></td>';
								html += "</tr>";
							}
							$("#table-negocios-del-cliente tbody").html(html).closest( "table#table-negocios-del-cliente" ).table("refresh").trigger("create");
						}
						
					});
				}
				modificar(){
					var parametros = {
						'id' : $("#id-editar").val(),
						'rut' : $("#rut-editar").val(),
						'nombre_completo' : $("#nombre_completo-editar").val(),
						'nombre_usuario' : $("#nombre_usuario-editar").val(),
						'contrasena' : $("#contrasena-editar").val(),
						'email' : $("#email-editar").val(),
						'celular' : $("#celular-editar").val(),
						'estado' : $("#estado").val(),
						'accion' : 'editar'
					};
					if($("#rut-editar").val().length<2){
						alert("Ingrese el Rut");
						return false;
					}
					if($("#nombre_completo-editar").val().length<2){
						alert("Ingrese el Nombre Completo");
						return false;
					}
					if($("#contrasena-editar").val().length<2){
						alert("Ingrese la contraseña");
						return false;
					}
					if($("#nombre_usuario-editar").val().length<2){
						alert("Ingrese el Nombre de Usuario");
						return false;
					}
					if($("#email-editar").val().length<2){
						alert("Ingrese el E-mail");
						return false;
					}
					if($("#celular-editar").val().length<2){
						alert("Ingrese el Celular");
						return false;
					}
					var respuestaAjax = super.enviar(parametros,"../../controlador/registrar-cliente.php");
					respuestaAjax.done(function( datos ) {
						objetoPersona.mostrar();
						location.href ="#pagina-registrar-cliente";
					});
				}
				mostrar(){
					var parametros = {
						'accion' : 'buscar'
					};
					var respuestaAjax = super.enviar(parametros,"../../controlador/registrar-cliente.php");
					respuestaAjax.done(function( datos ) {
						datos = JSON.parse(datos);
						var html = "";
						var funcion_editar = "";
						var funcion_agregar_empresa = "";
						//rescatar_datos_tabla(id,rut,nombre_completo,nombre_usuario,contrasena,email,celular)
						for(var x = 0 ; x < datos.length ; x++){
							funcion_editar = "('"+datos[x].ID_PERSONA+"',";
							funcion_editar += "'"+datos[x].RUT_PERSONA+"',";
							funcion_editar += "'"+datos[x].NOMBRE_COMPLETO_PERSONA+"',";
							funcion_editar += "'"+datos[x].USUARIO_PERSONA+"',";
							funcion_editar += "'"+datos[x].CONTRASENA_PERSONA+"',";
							funcion_editar += "'"+datos[x].EMAIL_PERSONA+"',";
							funcion_editar += "'"+datos[x].FONO_PERSONA+"',";
							funcion_editar += "'"+datos[x].ESTADO_PERSONA+"')";
							
							
							funcion_agregar_empresa = "('"+datos[x].ID_PERSONA+"',";
							funcion_agregar_empresa += "'"+datos[x].RUT_PERSONA+"',";
							funcion_agregar_empresa += "'"+datos[x].NOMBRE_COMPLETO_PERSONA+"')";
							
							
							
							
							html += "<tr>";
							html += "<td>"+datos[x].NOMBRE_COMPLETO_PERSONA+"</td>";
							html += "<td>"+datos[x].RUT_PERSONA+"</td>";
							html += "<td>"+datos[x].FONO_PERSONA+"</td>";
							html += "<td>"+datos[x].EMAIL_PERSONA+"</td>";
							html += "<td>"+datos[x].USUARIO_PERSONA+"</td>";
							html += "<td>"+datos[x].CONTRASENA_PERSONA+"</td>";
							html += '<td><a href="#" onclick="objetoPersona.prepararFormularioAgregarEmpresa'+funcion_agregar_empresa+'" class="ui-btn ui-icon-home ui-btn-icon-notext ui-corner-all"></a></td>';
							html += '<td><a href="#" onclick="objetoPersona.rescatar_datos_tabla'+funcion_editar+'" class="ui-btn ui-icon-edit ui-btn-icon-notext ui-corner-all"></a></td>';
							html += "</tr>";
						}
						$("#table-clientes tbody").html(html).closest( "table#table-clientes" ).table("refresh").trigger("create");
					});
				}
			}
		 	var objetoPersona = new Persona();
	 </script>        
	 <div data-role="page" id="paginaAgregarCliente">
	  <div data-role="header" data-position="fixed">
		<h1>Agregar Cliente</h1>
	  </div>
	  <br>
      <br>
	  <div data-role="main" class="ui-content">
		
			<div data-theme="a" data-form="ui-body-a" class="ui-body ui-body-a ui-corner-all">
				<form method="post" action="#">
				    <label for="textinput-6" id="label-rut">Rut* :</label>
					<input type="text" name="rut" id="rut" placeholder="" value="" data-mini="true">
					<label for="textinput-6">Nombre Completo* :</label>
					<input type="text" name="nombre_completo" id="nombre_completo" placeholder="" value="" data-mini="true">
					<label for="textinput-6">Usuario* :</label>
					<input type="text" name="nombre_usuario" id="nombre_usuario" placeholder="" value="" data-mini="true">
					<label for="textinput-6">Contraseña* :</label>
					<input type="text" name="contrasena" id="contrasena" placeholder="" value="" data-mini="true">
					<label for="textinput-6" id="label-email">Email* :</label>
					<input type="text" name="email" id="email" placeholder="" value="" data-mini="true">
					<label for="label-celular" id="label-celular">Celular* :</label>
					<input type="text" name="celular" id="celular" placeholder="" value="" data-mini="true">
				</form>
			</div>
	  </div>

	  <div data-role="footer" style="text-align:center;" data-position="fixed">
		<div data-role="controlgroup" data-type="horizontal">
		  <a href="#pagina-registrar-cliente" class="ui-btn ui-corner-all ui-shadow ui-icon-delete ui-btn-icon-left">Cancelar</a>
		  <a href="#" onClick="objetoPersona.ingresar();" class="ui-btn ui-corner-all ui-shadow ui-icon-check ui-btn-icon-left">Guardar</a>
		</div>
	  </div>
	</div> 
	
	
	
	
	
	
	
	
	
	
	
	<script>
	$(document).ready(function(){
		$(document).on( "pagecreate", "#pagina-modificar-cliente", function() {
			$("#celular-editar").mask("+56 9 9999 9999");
			$("#celular-editar").blur(function(){
				if($("#celular-editar").val().length==15){
					$("#label-celular-editar").html('<strong>Celular* :</strong>');
				}else{
					$("#label-celular-editar").html('<strong style="color:red;">Celular* : ¡Está mal escrito! Ej: +56 9 9292 6213</strong>');
				}
			});
			$("#email-editar").keyup(function(){
				if($("#email-editar").val().indexOf('@', 0) == -1 || $("#email-editar").val().indexOf('.', 0) == -1) {
					$("#label-email-editar").html('<strong style="color:red;">E-mail* : ¡Está mal escrito! Ej: ejemplo@gmail.com</strong>');
				}else{
					$("#label-email-editar").html('<strong>E-mail* :</strong>');
				}
			});
			$("#rut-editar")
			  .rut({formatOn: 'keyup', validateOn: 'keyup'})
			  .on('rutInvalido', function(){ 
				$("#label-rut-editar").html("<strong style='color:red;'>Rut* : ¡Inválido!</strong>");
			  })
			  .on('rutValido', function(){ 
				$("#label-rut-editar").html("<strong>Rut* :</strong>");
			  });
		});
	});
	</script>
	<div data-role="page" id="pagina-modificar-cliente">
	  <div data-role="header" data-position="fixed">
		<h1>Modificar Cliente</h1>
	  </div>
	  <br>
      <br>
	  <div data-role="main" class="ui-content">
		
			<div data-theme="a" data-form="ui-body-a" class="ui-body ui-body-a ui-corner-all">
				<form method="post" action="#">
			    	<input type="hidden" name="id-editar" id="id-editar"/>
				    <label for="textinput-6" id="label-rut-editar">Rut* :</label>
					<input type="text" name="rut-editar" id="rut-editar" placeholder="" value="" data-mini="true">
					<label for="textinput-6">Nombre Completo* :</label>
					<input type="text" name="nombre_completo-editar" id="nombre_completo-editar" placeholder="" value="" data-mini="true">
					<label for="textinput-6">Usuario* :</label>
					<input type="text" name="nombre_usuario-editar" id="nombre_usuario-editar" placeholder="" value="" data-mini="true">
					<label for="textinput-6">Contraseña* :</label>
					<input type="text" name="contrasena-editar" id="contrasena-editar" placeholder="" value="" data-mini="true">
					<label for="textinput-6" id="label-email-editar">Email* :</label>
					<input type="text" name="email-editar" id="email-editar" placeholder="" value="" data-mini="true">
					<label for="label-celular" id="label-celular-editar">Celular* :</label>
					<input type="text" name="celular-editar" id="celular-editar" placeholder="" value="" data-mini="true">
					<label for="slider-flip-m">Estado :</label>
					<select name="estado" id="estado" data-role="slider">
						<option value="0">Inactivo</option>
						<option value="1">Activo  </option>
					</select>
				</form>
			</div>
	  </div>

	  <div data-role="footer" style="text-align:center;" data-position="fixed">
		<div data-role="controlgroup" data-type="horizontal">
		  <a href="#pagina-registrar-cliente" class="ui-btn ui-corner-all ui-shadow ui-icon-delete ui-btn-icon-left">Cancelar</a>
		  <a href="#" onClick="objetoPersona.modificar();" class="ui-btn ui-corner-all ui-shadow ui-icon-check ui-btn-icon-left">Modificar</a>
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
	});
	</script>
	<div data-role="page" id="pagina-agregar-empresa">
	  <div data-role="header" data-position="fixed">
		<h1>Agregar Empresa</h1>
	  </div>
	  <br>
      <br>
	  <div data-role="main" class="ui-content">
		
			<div data-theme="a" data-form="ui-body-a" class="ui-body ui-body-a ui-corner-all">
				<form method="post" action="#">
			    	<input type="hidden" name="id-agregar-empresa" id="id-agregar-empresa"/>
				    <label for="textinput-6" id="rut-agregar-empresa">Rut* :</label>
					<label for="textinput-6" id="nombre_completo-agregar-empresa">Nombre Completo* :</label>
					<label for="search-control-group">Negocio</label>
					<div data-role="controlgroup" data-type="horizontal">
						<input type="text" id="nombre-de-fantasia" name="nombre-de-fantasia" data-wrapper-class="controlgroup-textinput ui-btn" placeholder="Nombre de Fantasía">
						<button type="button" data-icon="plus" onClick="objetoPersona.agregarNegocio();">Agregar</button>
					</div>
					<table data-role="table" id="table-negocios-del-cliente" data-mode="columntoggle" class="ui-body-d ui-shadow table-stripe ui-responsive" data-column-btn-theme="b" data-column-btn-text="Columnas a mostrar..." data-column-popup-theme="a">
					 <thead>
					   <tr class="ui-bar-d">
						 <th>Nombre de Fantasía</th>
						 <th>Eliminar</th>
					   </tr>
					 </thead>
					 <tbody>

					 </tbody>
				   </table>
					<br>
					<br>
					<br>
				</form>
			</div>
	  </div>

	  <div data-role="footer" style="text-align:center;" data-position="fixed">
		<div data-role="controlgroup" data-type="horizontal">
		  <a href="#pagina-registrar-cliente" class="ui-btn ui-corner-all ui-shadow ui-icon-delete ui-btn-icon-left">Atrás</a>
		</div>
	  </div>
	</div>
</body>
</html>