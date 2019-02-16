<?php
session_start();
if(!isset($_SESSION["ID_PERSONA"])){
	header('Location: login.php');
}

if(isset($_POST['accion'])){
	include_once("../modelo/Usuario.class.php");
	$objetoUsuario = new Usuario();
	if($_POST['accion']=='buscar'){
		echo json_encode($objetoUsuario->listar("SELECT * FROM `servicio`"));
	}
	if($_POST['accion']=='editar'){
		$id = $_POST['id'];
		$nombre_servicio = $_POST['nombre-servicio'];
		$icono_servicio = $_POST['icono-servicio'];
		echo $objetoUsuario->registrar("UPDATE `persona` SET
													`NOMBRE_SERVICIO` = '".strip_tags($nombre_servicio)."',
													`ICONO_SERVICIO` = '".strip_tags($icono_servicio)."'
													WHERE `ID_SERVICIO`= '".strip_tags($id)."'");
	}
}else{
	if(isset($_POST['ingresar'])){
		include_once("../Plugins/subirArchivos/class.upload.php");
		include_once("../modelo/Usuario.class.php");
		$objetoUsuario = new Usuario();
		$id = $objetoUsuario->registrar("INSERT INTO `servicio` 
					(`ID_SERVICIO`, `NOMBRE_SERVICIO`) 
					VALUES (NULL, '".strip_tags($_POST['nombre-servicio'])."');");
		$extension = explode(".", $_FILES['icono-servicio']['name'])[1];
		$nombre_nueva_imagen = $id.".".$extension;
		$objetoUsuario->registrar("UPDATE `servicio` SET
													`ICONO_SERVICIO` = '".$nombre_nueva_imagen."'
													WHERE `ID_SERVICIO`= ".$id."");
		
		
		
		$imagen = new upload($_FILES['icono-servicio']);
		if ($imagen->uploaded){
			//$imagen->image_resize         		= true; // default is true
			//$imagen->image_x              		= 1000; // para el ancho a cortar
			//$imagen->image_ratio_y        		= true; // para que se ajuste dependiendo del ancho definido
			$imagen->file_new_name_body   		= $id; // agregamos un nuevo nombre
			//$imagen->image_watermark      		= 'watermark.png'; // marcado de agua
			//$imagen->image_watermark_position 	= 'BR'; // donde se ub icara el marcado de agua. Bottom Right		
			$imagen->process('../fotos/iconos/');	
			
			echo 'La imagen a sido subida correctamente';
		}else{
			echo 'error : ' . $imagen->error;
		}	
	}
	
	
	if(isset($_POST['modificar'])){
		include_once("../Plugins/subirArchivos/class.upload.php");
		include_once("../modelo/Usuario.class.php");
		$objetoUsuario = new Usuario();
		$id = $_POST['id-servicio'];
		$extension = explode(".", $_FILES['icono-servicio-editar']['name'])[1];
		$nombre_nueva_imagen = $id.".".$extension;
		$objetoUsuario->registrar("UPDATE `servicio` SET
		                                            `ID_SERVICIO` = ".strip_tags($_POST['id-servicio']).",
													`NOMBRE_SERVICIO` = '".strip_tags($_POST['nombre-servicio-editar'])."',
													`ICONO_SERVICIO` = '".$nombre_nueva_imagen."'
													WHERE `ID_SERVICIO`= ".strip_tags($_POST['id-servicio'])."");
		
		if($extension!=""){
			unlink('../fotos/iconos/'.$id);
		}
		
		$imagen = new upload($_FILES['icono-servicio-editar']);
		if ($imagen->uploaded){
			
			//$imagen->image_resize         		= true; // default is true
			//$imagen->image_x              		= 1000; // para el ancho a cortar
			//$imagen->image_ratio_y        		= true; // para que se ajuste dependiendo del ancho definido
			$imagen->file_new_name_body   		= $id; // agregamos un nuevo nombre
			//$imagen->image_watermark      		= 'watermark.png'; // marcado de agua
			//$imagen->image_watermark_position 	= 'BR'; // donde se ub icara el marcado de agua. Bottom Right		
			$imagen->process('../fotos/iconos/');	
			
			echo 'La imagen a sido subida correctamente';
		}else{
			echo 'error : ' . $imagen->error;
		}	
	}
	exit();
}

?>
