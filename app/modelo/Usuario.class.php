<?php
include_once("Conexion.class.php");
include_once("../Plugins/subirArchivos/class.upload.php");
class Usuario{
	private $conexion = null;
	public function __construct() {
		$this->conexion = new Conexion();
	}
	function registrar($sql){
		return $this->conexion->insertar($sql);
	}
	function modificar($sql){
		return $this->conexion->modificar($sql);
	}
	function listar($sql){
		return $this->conexion->listar($sql);
	}
	function verificarNombreDeUsuario($valor,$id_usuario = null){
		$valor = strip_tags($valor);
		if($id_usuario==null){
			$datos = $this->conexion->listar("SELECT * FROM `USUARIO` WHERE `USUARIO_USUARIO` = '".$valor."'");
			if(count($datos)>0){
				return false;
			}else{
				return true;
			}
		}else{
			$datos = $this->conexion->listar("SELECT * FROM `USUARIO` 
											  WHERE `USUARIO_USUARIO` = '".$valor."'
											  AND `ID_USUARIO` != ".$id_usuario);
			if(count($datos)>0){
				return false;
			}else{
				return true;
			}
		}
	}
	function procesaLogin($usuario,$contrasena){
		$datos = $this->conexion->listar("SELECT * FROM `persona` 
											WHERE `USUARIO_PERSONA` = '".strip_tags($usuario)."' 
											AND `CONTRASENA_PERSONA` = '".strip_tags($contrasena)."'
										    AND `ESTADO_PERSONA` = 1");
		if(count($datos)>0){
			return array(
							"ID_PERSONA"=>$datos[0]["ID_PERSONA"],
							"ID_TIPO_USUARIO"=>$datos[0]["ID_TIPO_USUARIO"],
							"RUT_PERSONA"=>$datos[0]["RUT_PERSONA"],
							"NOMBRE_COMPLETO_PERSONA"=>$datos[0]["NOMBRE_COMPLETO_PERSONA"],
							"USUARIO_PERSONA"=>$datos[0]["USUARIO_PERSONA"],
							"CONTRASENA_PERSONA"=>$datos[0]["CONTRASENA_PERSONA"],
							"EMAIL_PERSONA"=>$datos[0]["EMAIL_PERSONA"],
							"FONO_PERSONA"=>$datos[0]["FONO_PERSONA"],
							"ESTADO_PERSONA"=>$datos[0]["ESTADO_PERSONA"]
							);
		}else{
			return null;
		}
	}
	function buscar_comuna($value){
		$value = strip_tags($value);
		$listado = $this->conexion->listar("SELECT CONCAT(
														'Región de ',R.NOMBRE_REGION,', Provincia de ',P.NOMBRE_PROVINCIA,', Comuna de ',C.NOMBRE_COMUNA
													 ) AS TEXTO,
													 C.ID_COMUNA AS ID
										FROM `region` R
										INNER JOIN `provincia` P
										ON(R.`ID_REGION`=P.`ID_REGION`)
										INNER JOIN `comuna` C
										ON(P.`ID_PROVINCIA`=C.`ID_PROVINCIA`)
										WHERE 
										( 
										  C.NOMBRE_COMUNA LIKE '%".$value."%' 
										  OR P.NOMBRE_PROVINCIA LIKE '%".$value."%' 
										  OR R.NOMBRE_REGION LIKE '%".$value."%'
										 )
										AND `NOMBRE_COMUNA` NOT LIKE 'Todo Chile' 
										LIMIT 10");
		$json = [];
		for($x=0;$x<count($listado);$x++){
			 $json[] = ['id'=>$listado[$x]["ID"], 'text'=>$listado[$x]["TEXTO"]];
		}
		return $json;
	}
	function subir_fotos_negocio($foto,$idPersona,$nombre_foto,$nuevo_nombre_archivo,$id_empresa){
	    ini_set ( "memory_limit", "40M");
		if($foto['tmp_name']==""){
			//No se ha enviado ninguna imagen
			$datos = $this->conexion->listar("SELECT * FROM `foto` WHERE `ID_NEGOCIO` = ".strip_tags($id_empresa)." AND `UBICACION_FOTO` LIKE '%".$nuevo_nombre_archivo."%'");
			if(count($datos)>0){
				for($x=0;$x<count($datos);$x++){
					$this->conexion->modificar("UPDATE `foto` SET
												`NOMBRE_FOTO` = '".strip_tags($nombre_foto)."'
												WHERE `ID_FOTO` =".strip_tags($datos[$x]["ID_FOTO"]));
				}
			}
		}else{
			$extension = explode(".", $foto['name'])[1];
			$nombre_nueva_imagen = $nuevo_nombre_archivo."-id-usuario-".$idPersona."-id-empresa".$id_empresa.".".$extension;

			$datos = $this->conexion->listar("SELECT * FROM `foto` WHERE `ID_NEGOCIO` = ".strip_tags($id_empresa)." AND `UBICACION_FOTO` LIKE '%".$nuevo_nombre_archivo."%'");
			if(count($datos)>0){
				for($x=0;$x<count($datos);$x++){
					$this->conexion->modificar("UPDATE `foto` SET
												`NOMBRE_FOTO` = '".strip_tags($nombre_foto)."',
												`UBICACION_FOTO` = '".strip_tags($nombre_nueva_imagen)."'
												WHERE `ID_FOTO` =".strip_tags($datos[$x]["ID_FOTO"]));
				}
			}else{
				$this->conexion->insertar("INSERT INTO `foto` (`ID_NEGOCIO`,`NOMBRE_FOTO`,`UBICACION_FOTO`) 
											VALUES
												('".strip_tags($id_empresa)."','".strip_tags($nombre_foto)."','".strip_tags($nombre_nueva_imagen)."')");
			}
            @unlink('../fotos/fotos-destinos/'.$nombre_nueva_imagen);
			$imagen = new upload($foto);
			if ($imagen->uploaded){
				$imagen->image_resize         		= true; // default is true
			    $imagen->image_x              		= 300; // para el ancho a cortar
				$imagen->image_ratio_y        		= true; // para que se ajuste dependiendo del ancho definido
				$imagen->file_new_name_body   		= $nuevo_nombre_archivo."-id-usuario-".$idPersona."-id-empresa".$id_empresa; // agregamos un nuevo nombre
				//$imagen->image_watermark      		= 'watermark.png'; // marcado de agua
				//$imagen->image_watermark_position 	= 'BR'; // donde se ub icara el marcado de agua. Bottom Right		
				$imagen->process('../fotos/fotos-destinos/');	

				echo 'La imagen a sido subida correctamente';
			}else{
				echo 'error : ' . $imagen->error;
			}
		}
	}
}
?>