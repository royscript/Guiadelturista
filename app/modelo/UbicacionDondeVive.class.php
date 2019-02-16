<?php
include_once("Conexion.class.php");
class ubicacionDondeVive{
	private $conexion = null;
	public function __construct() {
		$this->conexion = new Conexion();
	}
	function region(){
		return $this->conexion->listar("SELECT * FROM `REGION` ORDER BY `ID_REGION` ASC");
	}
	function comuna($id){
		if(is_numeric($id)){
			return $this->conexion->listar("SELECT * FROM `COMUNA` WHERE `ID_PROVINCIA`=".$id);
		}else{
			return null;
		}
		
	}
	function provincia($id){
		if(is_numeric($id)){
			return $this->conexion->listar("SELECT * FROM `PROVINCIA` WHERE `ID_REGION` =".$id);
		}else{
			return null;
		}
		
	}
	function seSeleccionoLaComunaParaDespacho($id_usuario,$id_comuna){
		if(is_numeric($id_comuna)){
			$datos = $this->conexion->listar("SELECT * FROM `DESPACHO` WHERE `ID_COMUNA` = ".$id_comuna." AND `ID_USUARIO` =".$id_usuario);
			if(count($datos)>0){
				return true;
			}else{
				return false;
			}
		}else{
			return null;
		}
	}
	function nacionalidad(){
		return $this->conexion->listar("SELECT * FROM `NACIONALIDAD`");
	}
	function nacionalidadesConProductos(){
		return $this->conexion->listar("SELECT NACIO.ID_NACIONALIDAD AS ID_NACIONALIDAD,
										CONCAT(NACIO.`NOMBRE_NACIONALIDAD`,' (',COUNT(DISTINCT(P.`ID_PRODUCTO`)),')') AS NOMBRE_NACIONALIDAD
										FROM `PRODUCTO` P
										INNER JOIN `CATEGORIA2` CATHIJO
										ON(P.`ID_CATEGORIA2`=CATHIJO.`ID_CATEGORIA2`)
										INNER JOIN `CATEGORIA1` CATPADRE
										ON(CATHIJO.`ID_CATEGORIA3`=CATPADRE.`ID_CATEGORIA3`)
										INNER JOIN `USUARIO` U
										ON(P.`ID_USUARIO`=U.`ID_USUARIO`)
										INNER JOIN `NACIONALIDAD` NACIO
										ON(U.ID_NACIONALIDAD=NACIO.ID_NACIONALIDAD)
										GROUP BY NACIO.ID_NACIONALIDAD");
	}
	function comunasDondeDespacha($id_ofertante){
		if(is_numeric($id_ofertante)){
			$datos = $this->conexion->listar("SELECT * 
											  FROM `DESPACHO` D
											  INNER JOIN `COMUNA` C
											  ON(D.`ID_COMUNA`=C.`ID_COMUNA`)
											  WHERE `ID_USUARIO` =".$id_ofertante);
			return $datos;
		}else{
			return array();
		}
	}
}
?>