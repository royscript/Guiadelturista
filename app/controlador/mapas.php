<?php

if(isset($_POST['accion'])){
	include_once("../modelo/Usuario.class.php");
	$objetoUsuario = new Usuario();
	if($_POST['accion']=='mostrarMapa'){
		$datos_negocios = $objetoUsuario->listar('SELECT `negocio`.*, 
														CONCAT("Región de ",`region`.`NOMBRE_REGION`,", Provincia de ",`provincia`.`NOMBRE_PROVINCIA`,", Comuna de ",`comuna`.`NOMBRE_COMUNA`) AS COMUNA_RESIDENTE,
														`servicio`.`ICONO_SERVICIO` AS ICONO_SERVICIO,
														`servicio`.`NOMBRE_SERVICIO` AS NOMBRE_SERVICIO,
														`comuna`.`ID_COMUNA`
													FROM `negocio`
													LEFT JOIN `comuna`
													ON(`negocio`.`ID_COMUNA`=`comuna`.`ID_COMUNA`)
													LEFT JOIN `provincia`
													ON(`comuna`.`ID_PROVINCIA`=`provincia`.`ID_PROVINCIA`)
													LEFT JOIN `region`
													ON(`region`.`ID_REGION`=`provincia`.`ID_REGION`)
													INNER JOIN `servicios_del_negocio`
													ON(`servicios_del_negocio`.`ID_NEGOCIO`=`negocio`.`ID_NEGOCIO`)
													INNER JOIN `servicio`
													ON(`servicio`.`ID_SERVICIO`=`servicios_del_negocio`.`ID_SERVICIO`)
													');
		
		$negocios = array();
		
		for($x=0;$x<count($datos_negocios);$x++){
			$fotos_del_negocio = $objetoUsuario->listar('SELECT * 
															FROM `foto` 
															WHERE `ID_NEGOCIO` = '.$datos_negocios[$x]["ID_NEGOCIO"]);
			$fotos = array();
			for($i=0;$i<count($fotos_del_negocio);$i++){
				$fotos [] = array(
										"NOMBRE_FOTO" => $fotos_del_negocio[$i]["NOMBRE_FOTO"],
										"UBICACION_FOTO" => $fotos_del_negocio[$i]["UBICACION_FOTO"]
									);
			}
			$negocios[] = array(
										"ID_NEGOCIO" => $datos_negocios[$x]["ID_NEGOCIO"],
										"NOMBRE_DE_FANTASIA_NEGOCIO" => $datos_negocios[$x]["NOMBRE_DE_FANTASIA_NEGOCIO"],
										"DESCRIPCION_NEGOCIO" => $datos_negocios[$x]["DESCRIPCION_NEGOCIO"],
										"DIRECCION_NEGOCIO" => $datos_negocios[$x]["DIRECCION_NEGOCIO"],
										"REFERENCIA_DIRECCION_NEGOCIO" => $datos_negocios[$x]["REFERENCIA_DIRECCION_NEGOCIO"],
										"LATITUD_NEGOCIO" => $datos_negocios[$x]["LATITUD_NEGOCIO"],
										"LONGITUD_NEGOCIO" => $datos_negocios[$x]["LONGITUD_NEGOCIO"],
										"CELULAR_NEGOCIO" => $datos_negocios[$x]["CELULAR_NEGOCIO"],
										"WHATSAPP_NEGOCIO" => $datos_negocios[$x]["WHATSAPP_NEGOCIO"],
										"FACEBOOK_NEGOCIO" => $datos_negocios[$x]["FACEBOOK_NEGOCIO"],
										"PAGINA_WEB_NEGOCIO" => $datos_negocios[$x]["PAGINA_WEB_NEGOCIO"],
										"ID_COMUNA" => $datos_negocios[$x]["ID_COMUNA"],
										"NOMBRE_USUARIO_FACEBOOK_NEGOCIO" => $datos_negocios[$x]["NOMBRE_USUARIO_FACEBOOK_NEGOCIO"],
										"ICONO_SERVICIO" => $datos_negocios[$x]["ICONO_SERVICIO"],
										"NOMBRE_SERVICIO" => $datos_negocios[$x]["NOMBRE_SERVICIO"],
										"FOTOS" => $fotos
										
								);
		}
		
		echo json_encode($negocios);
		
	}else if($_POST['accion']=='mostrarBusqueda'){
		$ubicaciones = $_POST['ubicaciones'];
		$actividades = $_POST['actividades'];
		if(count($ubicaciones)==0 || count($actividades)==0){
			$negocios = array();
			echo json_encode($negocios);
			return false;
		}
		$clausulaWhere = " WHERE ( ";
		$primeraVez = true;
		foreach($ubicaciones as $ubicacion){
			if($primeraVez==true){
				$primeraVez = false;
			}else{
				$clausulaWhere .= " OR ";
			}
			$clausulaWhere .= " `comuna`.`ID_COMUNA` = ".$ubicacion["id"];
		}
		$clausulaWhere .= " ) ";
		
		
		$clausulaWhere .= " AND ( ";
		$primeraVez = true;
		foreach($actividades as $actividad){
			if($primeraVez==true){
				$primeraVez = false;
			}else{
				$clausulaWhere .= " OR ";
			}
			$clausulaWhere .= " `servicios_del_negocio`.`ID_SERVICIO` = ".$actividad["id"];
		}
		$clausulaWhere .= " ) ";
		if($_POST["search"]!=""){
			$clausulaWhere .= " AND (`negocio`.`NOMBRE_DE_FANTASIA_NEGOCIO` LIKE '%".$_POST["search"]."%'";
			$clausulaWhere .= " OR `negocio`.`DESCRIPCION_NEGOCIO` LIKE '%".$_POST["search"]."%' )";
		}
		
		$datos_negocios = $objetoUsuario->listar('SELECT DISTINCT(`negocio`.`ID_NEGOCIO`) AS ID_CLIENTE, 
		                                                `negocio`.*, 
														CONCAT("Región de ",`region`.`NOMBRE_REGION`,", Provincia de ",`provincia`.`NOMBRE_PROVINCIA`,", Comuna de ",`comuna`.`NOMBRE_COMUNA`) AS COMUNA_RESIDENTE,
														`servicio`.`ICONO_SERVICIO` AS ICONO_SERVICIO,
														`servicio`.`NOMBRE_SERVICIO` AS NOMBRE_SERVICIO,
														`comuna`.`ID_COMUNA`
													FROM `negocio`
													LEFT JOIN `comuna`
													ON(`negocio`.`ID_COMUNA`=`comuna`.`ID_COMUNA`)
													LEFT JOIN `provincia`
													ON(`comuna`.`ID_PROVINCIA`=`provincia`.`ID_PROVINCIA`)
													LEFT JOIN `region`
													ON(`region`.`ID_REGION`=`provincia`.`ID_REGION`)
													INNER JOIN `servicios_del_negocio`
													ON(`servicios_del_negocio`.`ID_NEGOCIO`=`negocio`.`ID_NEGOCIO`)
													INNER JOIN `servicio`
													ON(`servicio`.`ID_SERVICIO`=`servicios_del_negocio`.`ID_SERVICIO`)
													'.$clausulaWhere);
		
		$negocios = array();
		
		for($x=0;$x<count($datos_negocios);$x++){
			$fotos_del_negocio = $objetoUsuario->listar('SELECT * 
															FROM `foto` 
															WHERE `ID_NEGOCIO` = '.$datos_negocios[$x]["ID_NEGOCIO"]);
			$fotos = array();
			for($i=0;$i<count($fotos_del_negocio);$i++){
				$fotos [] = array(
										"NOMBRE_FOTO" => $fotos_del_negocio[$i]["NOMBRE_FOTO"],
										"UBICACION_FOTO" => $fotos_del_negocio[$i]["UBICACION_FOTO"]
									);
			}
			$negocios[] = array(
										"ID_CLIENTE" => $datos_negocios[$x]["ID_CLIENTE"],
										"NOMBRE_DE_FANTASIA_NEGOCIO" => $datos_negocios[$x]["NOMBRE_DE_FANTASIA_NEGOCIO"],
										"DESCRIPCION_NEGOCIO" => $datos_negocios[$x]["DESCRIPCION_NEGOCIO"],
										"COMUNA_RESIDENTE" => $datos_negocios[$x]["COMUNA_RESIDENTE"],
										"DIRECCION_NEGOCIO" => $datos_negocios[$x]["DIRECCION_NEGOCIO"],
										"REFERENCIA_DIRECCION_NEGOCIO" => $datos_negocios[$x]["REFERENCIA_DIRECCION_NEGOCIO"],
										"LATITUD_NEGOCIO" => $datos_negocios[$x]["LATITUD_NEGOCIO"],
										"LONGITUD_NEGOCIO" => $datos_negocios[$x]["LONGITUD_NEGOCIO"],
										"CELULAR_NEGOCIO" => $datos_negocios[$x]["CELULAR_NEGOCIO"],
										"WHATSAPP_NEGOCIO" => $datos_negocios[$x]["WHATSAPP_NEGOCIO"],
										"FACEBOOK_NEGOCIO" => $datos_negocios[$x]["FACEBOOK_NEGOCIO"],
										"PAGINA_WEB_NEGOCIO" => $datos_negocios[$x]["PAGINA_WEB_NEGOCIO"],
										"ID_COMUNA" => $datos_negocios[$x]["ID_COMUNA"],
										"NOMBRE_USUARIO_FACEBOOK_NEGOCIO" => $datos_negocios[$x]["NOMBRE_USUARIO_FACEBOOK_NEGOCIO"],
										"ICONO_SERVICIO" => $datos_negocios[$x]["ICONO_SERVICIO"],
										"NOMBRE_SERVICIO" => $datos_negocios[$x]["NOMBRE_SERVICIO"],
										"FOTOS" => $fotos
										
								);
		}
		
		echo json_encode($negocios);
		
	}
	
}

?>
