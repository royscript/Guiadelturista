<?php
session_start();
if(!isset($_SESSION["ID_PERSONA"])){
	header('Location: login.php');
}

if(isset($_POST['accion'])){
	include_once("../modelo/Usuario.class.php");
	$objetoUsuario = new Usuario();
	if($_POST['accion']=='mostrarMisNegocios'){
		echo json_encode($objetoUsuario->listar('SELECT `negocio`.*, CONCAT("Región de ",`region`.`NOMBRE_REGION`,", Provincia de ",`provincia`.`NOMBRE_PROVINCIA`,", Comuna de ",`comuna`.`NOMBRE_COMUNA`) AS COMUNA_RESIDENTE
													FROM `negocio`
													LEFT JOIN `comuna`
													ON(`negocio`.`ID_COMUNA`=`comuna`.`ID_COMUNA`)
													LEFT JOIN `provincia`
													ON(`comuna`.`ID_PROVINCIA`=`provincia`.`ID_PROVINCIA`)
													LEFT JOIN `region`
													ON(`region`.`ID_REGION`=`provincia`.`ID_REGION`) 
													WHERE `ID_PERSONA` = '.$_SESSION["ID_PERSONA"]));
	}
	if($_POST['accion']=='editar'){
		$id = $_POST['id-negocio'];
		$comuna = $_POST['comuna'];
		$nombre_de_fantasia = $_POST['nombre_de_fantasia'];
		$descripcion = $_POST['descripcion'];
		$direccion = $_POST['direccion'];
		$referencia = $_POST['referencia'];
		$celular = $_POST['celular'];
		$whatsapp = $_POST['whatsapp'];
		$facebook = $_POST['facebook'];
		$pagina_web = $_POST['pagina_web'];
		$nombre_usuario_facebook_negocio = $_POST['nombre_usuario_facebook_negocio'];
		$servicios_seleccionados = $_POST['servicios_seleccionados'];
		echo $objetoUsuario->registrar("UPDATE `negocio` SET
											`ID_COMUNA` = '".strip_tags($comuna)."',
											`NOMBRE_DE_FANTASIA_NEGOCIO` = '".strip_tags($nombre_de_fantasia)."',
											`DESCRIPCION_NEGOCIO` = '".strip_tags($descripcion)."',
											`DIRECCION_NEGOCIO` = '".strip_tags($direccion)."',
											`REFERENCIA_DIRECCION_NEGOCIO` = '".strip_tags($referencia)."',
											`CELULAR_NEGOCIO` = '".strip_tags($celular)."',
											`WHATSAPP_NEGOCIO` = '".strip_tags($whatsapp)."',
											`FACEBOOK_NEGOCIO` = '".strip_tags($facebook)."',
											`PAGINA_WEB_NEGOCIO` = '".strip_tags($pagina_web)."',
											`NOMBRE_USUARIO_FACEBOOK_NEGOCIO` = '".strip_tags($nombre_usuario_facebook_negocio)."' 
									WHERE `ID_NEGOCIO` = '".strip_tags($id)."'");
		
		echo $objetoUsuario->registrar("DELETE FROM `servicios_del_negocio` WHERE `ID_NEGOCIO` = '".strip_tags($id)."'");
		for($x=0;$x<count($servicios_seleccionados);$x++){
			$objetoUsuario->registrar("INSERT INTO `servicios_del_negocio` (`ID_NEGOCIO`,`ID_SERVICIO`) VALUES (".strip_tags($id).",".strip_tags($servicios_seleccionados[$x]["id"]).")");
		}
	}
	if($_POST['accion']=='agregarNegocio'){
		$id_cliente = $_POST['id'];
		$nombre_de_fantasia = $_POST['nombre-de-fantasia'];
		
		echo $objetoUsuario->registrar("INSERT INTO `negocio` (`ID_PERSONA`, `NOMBRE_DE_FANTASIA_NEGOCIO`) VALUES ('".strip_tags($id_cliente)."','".strip_tags($nombre_de_fantasia)."');");
	}
	if($_POST['accion']=='mostrarNegocio'){
		$id_cliente = $_POST['id'];
		echo json_encode($objetoUsuario->listar("SELECT `ID_NEGOCIO`,`NOMBRE_DE_FANTASIA_NEGOCIO` FROM `negocio` WHERE `ID_PERSONA` = '".strip_tags($id_cliente)."'"));
	}
	if($_POST['accion']=='mostrarServiciosDelNegocio'){
		$id = $_POST['id'];
		echo json_encode($objetoUsuario->listar("SELECT * 
										FROM `servicio` S
										INNER JOIN `servicios_del_negocio` SN
										ON(S.`ID_SERVICIO`=SN.`ID_SERVICIO`)
										WHERE SN.`ID_NEGOCIO` = ".strip_tags($id).""));
	}
	if($_POST['accion']=='cargarFotosDelNegocio'){
		$id = $_POST['id'];
		echo json_encode($objetoUsuario->listar("SELECT * FROM `foto` WHERE `ID_NEGOCIO` = ".strip_tags($id).""));
	}
	if($_POST['accion']=='guardarGeolocalizacion'){
		$latitud = $_POST['latitud'];
		$longitud = $_POST['longitud'];
		$id_negocio = $_POST['id-negocio'];
		echo $objetoUsuario->registrar("UPDATE `negocio` SET
											`LATITUD_NEGOCIO` = '".strip_tags($latitud)."',
											`LONGITUD_NEGOCIO` = '".strip_tags($longitud)."' 
									WHERE `ID_NEGOCIO` = '".strip_tags($id_negocio)."'");
	}
}else{
	if(isset($_GET["buscar_comuna"])){
		include_once("../modelo/Usuario.class.php");
		$objetoUsuario = new Usuario();
		$listado = $objetoUsuario->buscar_comuna($_GET['q']);
		echo json_encode($listado);
	}
	if(isset($_POST['guardarFotos'])){
		include_once("../modelo/Usuario.class.php");
		$objetoUsuario = new Usuario();
		$id_empresa = $_POST['id-empresa-foto'];
		
		$objetoUsuario->subir_fotos_negocio($_FILES['imagen-1'],$_SESSION["ID_PERSONA"],$_POST["nombre-imagen-1"],"imagen-1",$id_empresa);
		
		$objetoUsuario->subir_fotos_negocio($_FILES['imagen-2'],$_SESSION["ID_PERSONA"],$_POST["nombre-imagen-2"],"imagen-2",$id_empresa);
		
		$objetoUsuario->subir_fotos_negocio($_FILES['imagen-3'],$_SESSION["ID_PERSONA"],$_POST["nombre-imagen-3"],"imagen-3",$id_empresa);
			
	}
	exit();
}

?>
