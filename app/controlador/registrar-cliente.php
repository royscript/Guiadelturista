<?php
session_start();
if(!isset($_SESSION["ID_PERSONA"])){
	header('Location: login.php');
}

if(isset($_POST['accion'])){
	include_once("../modelo/Usuario.class.php");
	$objetoUsuario = new Usuario();
	if($_POST['accion']=='ingresar'){
		$rut = $_POST['rut'];
		$nombre_completo = $_POST['nombre_completo'];
		$nombre_usuario = $_POST['nombre_usuario'];
		$contrasena = $_POST['contrasena'];
		$email = $_POST['email'];
		$celular = $_POST['celular'];
		echo $objetoUsuario->registrar("INSERT INTO `persona` 
					(`ID_PERSONA`, `ID_TIPO_USUARIO`, `RUT_PERSONA`, `NOMBRE_COMPLETO_PERSONA`, `USUARIO_PERSONA`, `CONTRASENA_PERSONA`, `EMAIL_PERSONA`, `FONO_PERSONA`, `ESTADO_PERSONA`) 
					VALUES (NULL, '1', '".strip_tags($rut)."', '".strip_tags($nombre_completo)."', '".strip_tags($nombre_usuario)."', '".strip_tags($contrasena)."', '".strip_tags($email)."', '".strip_tags($celular)."', '1');");
	}
	if($_POST['accion']=='buscar'){
		echo json_encode($objetoUsuario->listar("SELECT * FROM `persona` WHERE `ID_TIPO_USUARIO` = 1"));
	}
	if($_POST['accion']=='editar'){
		$id = $_POST['id'];
		$rut = $_POST['rut'];
		$nombre_completo = $_POST['nombre_completo'];
		$nombre_usuario = $_POST['nombre_usuario'];
		$contrasena = $_POST['contrasena'];
		$email = $_POST['email'];
		$celular = $_POST['celular'];
		$estado = $_POST['estado'];
		echo $objetoUsuario->registrar("UPDATE `persona` SET
													`RUT_PERSONA` = '".strip_tags($rut)."',
													`NOMBRE_COMPLETO_PERSONA` = '".strip_tags($nombre_completo)."',
													`USUARIO_PERSONA` = '".strip_tags($nombre_usuario)."',
													`CONTRASENA_PERSONA` = '".strip_tags($contrasena)."',
													`EMAIL_PERSONA` = '".strip_tags($email)."',
													`FONO_PERSONA` = '".strip_tags($celular)."',
													`ESTADO_PERSONA` = ".strip_tags($estado)."
													WHERE `ID_PERSONA`= '".strip_tags($id)."'");
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
	if($_POST['accion']=='eliminarNegocio'){
		$id = $_POST['id'];
		echo $objetoUsuario->registrar("DELETE FROM `negocio` WHERE `ID_NEGOCIO` = ".strip_tags($id)."");
	}
}else{
	exit();
}

?>
