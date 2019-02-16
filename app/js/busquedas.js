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

class busqueda extends Ajax{
	constructor(){
		super();
	}
	buscar(){
		var ubicaciones = new Array();
		for(var x=0;x<filtro_localidades.length;x++){
			if($("#"+filtro_localidades[x].id+"-localidad").is(':checked')){
				ubicaciones.push({
					id : filtro_localidades[x].id
				});
			}
			
		}
		var actividades = new Array();
		for(var x=0;x<servicios_checkboxes.length;x++){
			if($("#"+servicios_checkboxes[x].id).is(':checked')){
				actividades.push({
					id : servicios_checkboxes[x].id
				});
			}
			
		}
		var parametros = {
			'ubicaciones' : ubicaciones,
			'actividades' : actividades,
			'search' : $("#search-2").val(),
			'accion' : 'mostrarBusqueda'	
		};
		var respuesta_ajax = super.enviar(parametros,'controlador/mapas.php');
		respuesta_ajax.done(function( datos ) {
			datos = JSON.parse(datos);
			var html = "";
			for(var x=0;x<datos.length;x++){
				html += '<li>'
						+ '<a href="mostrar_destino.php?idCliente='+datos[x].ID_CLIENTE+'" rel="external">'
						+ '<img src="fotos/fotos-destinos/'+datos[x].FOTOS[0].UBICACION_FOTO+'" class="foto-listado">'
						+ '<h2 class="titulo">'+datos[x].NOMBRE_DE_FANTASIA_NEGOCIO+'</h2>'
						+ '<p class="descripcion">'+datos[x].DESCRIPCION_NEGOCIO+'</p>'
						+ '<p class="ubicacion"><strong>'+datos[x].COMUNA_RESIDENTE+'</strong></p>'
					+ '</a>'
				+ '</li>';
			}
			$( "#listado" ).html(html);
			$( "#listado" ).listview( "refresh" );
		});
	}
}
var objeto = new busqueda();
$(document).ready(function(){
	objeto.buscar();
	$("#buscar-boton").click(function(){
		objeto.buscar();
	});
});