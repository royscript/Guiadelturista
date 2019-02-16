<?php
error_reporting(E_ALL);
if(isset($_POST['usuario']) && isset($_POST['contrasena'])){
	include_once("../modelo/Usuario.class.php");
	$objetoUsuario = new Usuario();
	$resultado = $objetoUsuario->procesaLogin($_POST['usuario'],$_POST['contrasena']);
	if($resultado==null){
		header("Location: ../login.php");
		exit();
	}else{
		if($resultado['ID_TIPO_USUARIO']==2){
			session_start();
			$_SESSION["ID_PERSONA"] = $resultado['ID_PERSONA'];
			header("Location: ../logeado/administrador/registrar_cliente.php");
			exit();
		}else{
			session_start();
			$_SESSION["ID_PERSONA"] = $resultado['ID_PERSONA'];
			header("Location: ../logeado/cliente/mis_negocios.php");
			exit();
		}

	}
}else{
	exit();
}

?>