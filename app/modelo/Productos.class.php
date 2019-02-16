<?php
include_once("Conexion.class.php");
class Productos{
	private $ID_PRODUCTO = null;
	private $ID_CATEGORIA2 = null;
	private $ID_USUARIO = null;
	private $ID_ESTADO_PRODUCTO = null;
	private $NOMBRE_PRODUCTO = null;
	private $DETALLE_PRODUCTO = null;
	private $VALOR_PRODUCTO = null;
	private $FOTO_PRODUCTO = null;
	private $conexion = null;
	public function __construct($ID_PRODUCTO,$ID_CATEGORIA2,$ID_USUARIO,$ID_ESTADO_PRODUCTO,$NOMBRE_PRODUCTO,$DETALLE_PRODUCTO,$VALOR_PRODUCTO) {
		$this->ID_PRODUCTO = strip_tags($ID_PRODUCTO);
		$this->ID_CATEGORIA2 = strip_tags($ID_CATEGORIA2);
		$this->ID_USUARIO = strip_tags($ID_USUARIO);
		$this->ID_ESTADO_PRODUCTO = strip_tags($ID_ESTADO_PRODUCTO);
		$this->NOMBRE_PRODUCTO = strip_tags($NOMBRE_PRODUCTO);
		$this->DETALLE_PRODUCTO = strip_tags($DETALLE_PRODUCTO);
		$this->VALOR_PRODUCTO = strip_tags($VALOR_PRODUCTO);
		$this->conexion = new Conexion();
	}
	public function obtenerFotoProducto(){
		$foto = $this->conexion->listar("SELECT `FOTO_PRODUCTO` FROM `PRODUCTO` WHERE `ID_PRODUCTO`=".$this->ID_PRODUCTO);
		return $foto[0]["FOTO_PRODUCTO"];
	}
	public function convertirFoto($foto){
		
		// Ignore notices
		if (is_uploaded_file($foto["tmp_name"])){
			# verificamos el formato de la imagen
			if ($foto["type"]=="image/jpeg" || $foto["type"]=="image/pjpeg" || $foto["type"]=="image/gif" || $foto["type"]=="image/bmp" || $foto["type"]=="image/png")
			{

				# Escapa caracteres especiales
				//$imagenEscapes=base64_encode(file_get_contents($foto["tmp_name"]));
				$imagen = getimagesize($foto["tmp_name"]);    //Sacamos la información
				$ancho = $imagen[0];              //Ancho
				$alto = $imagen[1];               //Alto
				
				$ancho_origen = $ancho;
				$ancho_foto = $ancho_origen;
				$alto_origen = $alto;
				$alto_foto = $alto_origen;
				$ancho_limite = 400;
				if($ancho_origen>$alto_origen){//Para foto horizontal
				  $ancho_origen = $ancho_limite;
				  $alto_origen = $ancho_limite * $alto_foto / $ancho_foto;
				}else{//Para foto vertical
				  $alto_origen = $ancho_limite;
				  $ancho_origen = $ancho_limite * $ancho_foto / $alto_foto;
				}
				
				$image = new \claviska\SimpleImage();

				  // Manipulate it
				  $image = $image
					->fromFile($foto["tmp_name"])              // load parrot.jpg
					->bestFit($ancho_origen, $alto_origen)                   // proportinoally resize to fit inside a 250x400 box
					//->toScreen();                         // output to the screen
					->toString("image/jpeg");
					$image = base64_encode($image);
				return $image;
			}else{
				return false;
			}
		}
	}
	public function registrarProducto($foto){
		$mensaje_error = '<div class="alert alert-danger" role="alert">'
						  .'<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>'
						  .'<span class="sr-only">Error:</span>'
						 .'<div class="error">Error: ';
		$cantidad_productos = $this->conexion->listar("SELECT COUNT(`ID_PRODUCTO`) AS CANTIDAD FROM `PRODUCTO` 
											WHERE `ID_USUARIO` = ".$_SESSION["idUsuario"]."
											AND `ID_ESTADO_PRODUCTO` != 4");//ID 4 = PRODUCTO DADO DE BAJA
		$cantidad_productos = $cantidad_productos[0]["CANTIDAD"];
		if($this->limiteProductos()<$cantidad_productos){
			return $mensaje_error.'Ha superado el límite de productos que puede registrar.</div>';
		}
		$datos = $this->conexion->listar("SELECT * FROM `PRODUCTO` 
											WHERE `ID_USUARIO` = ".$_SESSION["idUsuario"]."
											AND `NOMBRE_PRODUCTO` = '".$this->NOMBRE_PRODUCTO."'
											AND `DETALLE_PRODUCTO` = '".$this->DETALLE_PRODUCTO."'
											AND `VALOR_PRODUCTO` = '".$this->VALOR_PRODUCTO."'
											AND `ID_ESTADO_PRODUCTO` != 4");
		if(count($datos)==0){//Esta consulta es para que no se registre 2 veces el producto con los mismos datos
			  $this->FOTO_PRODUCTO = $this->convertirFoto($foto);
			  if($this->FOTO_PRODUCTO==false){
				  return $mensaje_error.'Error: El formato de archivo tiene que ser JPG, GIF, BMP o PNG.</div>';
			  }else{
				  $this->conexion->insertar("INSERT INTO `PRODUCTO` 			
			(`ID_CATEGORIA2`,`ID_USUARIO`,`ID_ESTADO_PRODUCTO`,`NOMBRE_PRODUCTO`,`DETALLE_PRODUCTO`,`VALOR_PRODUCTO`,`FOTO_PRODUCTO`)
	VALUES (".$this->ID_CATEGORIA2.",".$this->ID_USUARIO.",".$this->ID_ESTADO_PRODUCTO.",'".strip_tags($this->NOMBRE_PRODUCTO)."','".strip_tags($this->DETALLE_PRODUCTO)."','".strip_tags($this->VALOR_PRODUCTO)."','".$this->FOTO_PRODUCTO."')");
				return '<div class="alert alert-success" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>Datos registrados correctamente</div>';
			  }
			  //-----------------------------------------------------------------------------------
		}else{ 
			return $mensaje_error.'Ha registrado un producto con las mismas características.</div>';
		} 
			
			
	}
	
	public function listarProductosUsuario($id_usuario){
		return $this->conexion->listar("SELECT * 
		                                FROM `PRODUCTO` P
										INNER JOIN `CATEGORIA2` CH
										ON(P.`ID_CATEGORIA2`=CH.`ID_CATEGORIA2`)
										WHERE `ID_USUARIO` = ".$id_usuario."
										AND `ID_ESTADO_PRODUCTO` != 4
										ORDER BY P.`ID_PRODUCTO` DESC");
	}
	public function listarProductosUsuarioOfertante($id_usuario){
		return $this->conexion->listar("SELECT * 
		                                FROM `PRODUCTO` P
										INNER JOIN `CATEGORIA2` CH
										ON(P.`ID_CATEGORIA2`=CH.`ID_CATEGORIA2`)
										WHERE `ID_USUARIO` = ".$id_usuario."
										AND P.`ID_ESTADO_PRODUCTO` = 1");
	}
	public function listarUltimosProductosRegistrados(){
		return $this->conexion->listar("SELECT * 
		                                FROM `PRODUCTO` P
										INNER JOIN `CATEGORIA2` CH
										ON(P.`ID_CATEGORIA2`=CH.`ID_CATEGORIA2`)
										WHERE P.`ID_ESTADO_PRODUCTO` = 1
										ORDER BY P.`ID_PRODUCTO` DESC
										LIMIT 15");
	}
	function categoriaPadre(){
		return $this->conexion->listar("SELECT * FROM `CATEGORIA1`");
	}
	function categoriaHijo($id){
		if(is_numeric($id)){
			return $this->conexion->listar("SELECT * FROM `CATEGORIA2` WHERE `ID_CATEGORIA3` =".$id);
		}else{
			return null;
		}
		
	}
	function modificarProducto($foto){
		$mensaje_error = '<div class="alert alert-danger" role="alert">'
						  .'<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>'
						  .'<span class="sr-only">Error:</span>'
						 .'<div class="error">Error: ';
		if($foto==''){//si no hay foto modificar datos sin modificar la foto
			$this->conexion->insertar("UPDATE `PRODUCTO` SET 
										`ID_CATEGORIA2` = ".$this->ID_CATEGORIA2.",
										`ID_USUARIO` = ".$this->ID_USUARIO.",
										`NOMBRE_PRODUCTO` = '".strip_tags($this->NOMBRE_PRODUCTO)."',
										`DETALLE_PRODUCTO` = '".strip_tags($this->DETALLE_PRODUCTO)."',
										`VALOR_PRODUCTO` = '".strip_tags($this->VALOR_PRODUCTO)."'
								  WHERE `ID_PRODUCTO` = ".$this->ID_PRODUCTO." AND `ID_USUARIO` = ".$this->ID_USUARIO);
		}else{//En caso contrario si existe una foto
			$this->FOTO_PRODUCTO = $this->convertirFoto($foto);
			if($this->FOTO_PRODUCTO==false){//No es el formato adecuado
				return $mensaje_error.'Error: El formato de archivo tiene que ser JPG, GIF, BMP o PNG.</div>';
			}else{//Es el fornato adecuado, modificar
				$this->conexion->insertar("UPDATE `PRODUCTO` SET 
									`ID_CATEGORIA2` = ".$this->ID_CATEGORIA2.",
									`ID_USUARIO` = ".$this->ID_USUARIO.",
									`NOMBRE_PRODUCTO` = '".strip_tags($this->NOMBRE_PRODUCTO)."',
									`DETALLE_PRODUCTO` = '".strip_tags($this->DETALLE_PRODUCTO)."',
									`VALOR_PRODUCTO` = '".strip_tags($this->VALOR_PRODUCTO)."',
									`FOTO_PRODUCTO` = '".$this->FOTO_PRODUCTO."'
							  WHERE `ID_PRODUCTO` = ".$this->ID_PRODUCTO." AND `ID_USUARIO` = ".$this->ID_USUARIO);
				return '<div class="alert alert-success" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>Producto modificado correctamente.</div>';
			}
		}
	}
	function desvincularPrenda(){
		if($this->ID_ESTADO_PRODUCTO==1){
			$this->ID_ESTADO_PRODUCTO = 2;
		}
		return $this->conexion->insertar("UPDATE `PRODUCTO` SET 
									`ID_ESTADO_PRODUCTO` = ".$this->ID_ESTADO_PRODUCTO."
							  WHERE `ID_PRODUCTO` = ".$this->ID_PRODUCTO." AND `ID_USUARIO` = ".$this->ID_USUARIO);
		
	}
	function limiteProductos(){
		$sql = "SELECT TU.CANTIDAD_PRODUCTOS_TIPO_USUARIO AS CANTIDAD_PRODUCTOS_TIPO_USUARIO FROM `USUARIO` U
				INNER JOIN `TIPO_USUARIO` TU
				ON(U.`ID_TIPO_USUARIO`=TU.`ID_TIPO_USUARIO`)
				WHERE `ID_USUARIO` = ".$this->ID_USUARIO;
		$datos = $this->conexion->listar($sql);
		for($x=0;$x<count($datos);$x++){
			return $datos[$x]["CANTIDAD_PRODUCTOS_TIPO_USUARIO"];
		}
	}
	function categoriaPadreConCantidades(){
		return $this->conexion->listar("SELECT CATPADRE.`ID_CATEGORIA3` AS ID_CATEGORIA3,
										CONCAT(CATPADRE.NOMBRE_CATEGORIA1,' (',COUNT(DISTINCT(P.ID_PRODUCTO)),')') AS NOMBRE_CATEGORIA1
										FROM `PRODUCTO` P
										INNER JOIN `CATEGORIA2` CATHIJO
										ON(P.`ID_CATEGORIA2`=CATHIJO.`ID_CATEGORIA2`)
										INNER JOIN `CATEGORIA1` CATPADRE
										ON(CATHIJO.`ID_CATEGORIA3`=CATPADRE.`ID_CATEGORIA3`)
										INNER JOIN `USUARIO` U
										ON(P.`ID_USUARIO`=U.`ID_USUARIO`)
										INNER JOIN `NACIONALIDAD` NACIO
										ON(U.ID_NACIONALIDAD=NACIO.ID_NACIONALIDAD)
										GROUP BY CATPADRE.`ID_CATEGORIA3`");
	}
	function buscadorDeProductos($search,$categoria,$subcategoria,$nacionalidad,$precio,$pagina,$cantidadPorPagina){
		$filtroSql_1 = " 1 = 1";
		if($search!=""){
			$filtroSql_1 = "P.`NOMBRE_PRODUCTO` LIKE '%".strip_tags($search)."%'
							OR P.`DETALLE_PRODUCTO` LIKE '%".strip_tags($search)."%'";
		}
		$filtroSql_2 = " AND 1 = 1";
		if(is_numeric($categoria)){
			if($categoria!=0 && $categoria!=''){
				$filtroSql_2 = " AND CATPADRE.`ID_CATEGORIA3` = ".strip_tags($categoria);
			}
		}
		$filtroSql_3 = " AND 1 = 1";
		if(is_numeric($subcategoria)){
			if($subcategoria!=0 && $subcategoria!=''){
				$filtroSql_3 = " AND CATHIJO.`ID_CATEGORIA2` = ".strip_tags($subcategoria);
			}
		}
		$filtroSql_4 = " AND 1 = 1";
		if(is_numeric($nacionalidad)){
			if($nacionalidad!=0 && $nacionalidad!=''){
				$filtroSql_4 = " AND NACIO.ID_NACIONALIDAD = ".strip_tags($nacionalidad);
			}
		}
		$filtro_5 = "";
		$filtro_6 = "";
		if(isset($_SESSION["comunaUsuario"])){
			$filtro_5 = " RIGHT JOIN `DESPACHO` DESP
			              ON(DESP.`ID_USUARIO`=U.`ID_USUARIO`)";
			$filtro_6 = " AND DESP.`ID_COMUNA` = ".$_SESSION["comunaUsuario"];
		}
		$filtro_7 = " ORDER BY `ID_PRODUCTO` ASC ";
		if($precio!=""){
			if($precio==1){
				$filtro_7 = " ORDER BY P.`VALOR_PRODUCTO` ASC ";
			}else{
				$filtro_7 = " ORDER BY P.`VALOR_PRODUCTO` DESC ";
			}
		}
		$sql = "FROM `PRODUCTO` P
				INNER JOIN `CATEGORIA2` CATHIJO
				ON(P.`ID_CATEGORIA2`=CATHIJO.`ID_CATEGORIA2`)
				INNER JOIN `CATEGORIA1` CATPADRE
				ON(CATHIJO.`ID_CATEGORIA3`=CATPADRE.`ID_CATEGORIA3`)
				INNER JOIN `USUARIO` U
				ON(P.`ID_USUARIO`=U.`ID_USUARIO`)
				INNER JOIN `NACIONALIDAD` NACIO
				ON(U.ID_NACIONALIDAD=NACIO.ID_NACIONALIDAD)
				".$filtro_5."
				WHERE 
				(".$filtroSql_1.") 
				AND P.`ID_ESTADO_PRODUCTO` = 1
				".$filtroSql_2." ".$filtroSql_3." ".$filtroSql_4." ".$filtro_6;
		$cantidadFilas = "SELECT COUNT(*) as cantidad ".$sql;
		$cantidadFilas = $this->conexion->listar($cantidadFilas);
		$cantidadFilas = $cantidadFilas[0]['cantidad'];
		if($cantidadFilas==0){
			return null;
		}
		$porcentajePorPagina = ($cantidadPorPagina*100)/$cantidadFilas;
		if($pagina==0){
			$limite1 = 0;
			$limite2 = (int)($cantidadFilas*($porcentajePorPagina/100));
		}elseif($pagina>0){
			$limite1 = $pagina * $cantidadPorPagina;
			$limite2 = ((int)($cantidadFilas*($porcentajePorPagina/100)))*$pagina;
		}else{
			return "la página debe ser mayor o igual a 0";
		}
		$query = "SELECT * ".$sql." ".$filtro_7."  LIMIT ".$limite1." ,".$limite2;
		$query = $this->conexion->listar($query);
		if($cantidadFilas<=0){
		}else{
			$array = array();
			for($x=0;$x<count($query);$x++){
				$array[]=
					array(
						"ID_PRODUCTO"=>$query[$x]['ID_PRODUCTO'],
						"ID_CATEGORIA2"=>$query[$x]['ID_CATEGORIA2'],
						"NOMBRE_PRODUCTO"=>$query[$x]['NOMBRE_PRODUCTO'],
						"DETALLE_PRODUCTO"=>$query[$x]['DETALLE_PRODUCTO'],
						"VALOR_PRODUCTO"=>$query[$x]['VALOR_PRODUCTO'],
						"FOTO_PRODUCTO"=>$query[$x]['FOTO_PRODUCTO'],
						"NOMBRES_USUARIO"=>$query[$x]['NOMBRES_USUARIO'],
						"NOMBRE_CATEGORIA1"=>$query[$x]['NOMBRE_CATEGORIA1'],
						"NOMBRE_NACIONALIDAD"=>$query[$x]['NOMBRE_NACIONALIDAD'],
						"VALOR_PRODUCTO"=>$query[$x]['VALOR_PRODUCTO']
					);
			}
			return array($array,$cantidadFilas);
	  	}
	}
	function mostrarProducto(){
		if(is_numeric($this->ID_PRODUCTO)){
			return $this->conexion->listar("SELECT *
										FROM `PRODUCTO` P
										INNER JOIN `CATEGORIA2` CATHIJO
										ON(P.`ID_CATEGORIA2`=CATHIJO.`ID_CATEGORIA2`)
										INNER JOIN `CATEGORIA1` CATPADRE
										ON(CATHIJO.`ID_CATEGORIA3`=CATPADRE.`ID_CATEGORIA3`)
										INNER JOIN `USUARIO` U
										ON(P.`ID_USUARIO`=U.`ID_USUARIO`)
										INNER JOIN `NACIONALIDAD` NACIO
										ON(U.ID_NACIONALIDAD=NACIO.ID_NACIONALIDAD)
										INNER JOIN `COMUNA` COM
										ON(COM.`ID_COMUNA`=U.`ID_COMUNA`)
										WHERE P.`ID_PRODUCTO` =".$this->ID_PRODUCTO."
										AND P.`ID_ESTADO_PRODUCTO` = 1");
		}
		
	}
	function buscadorAprobadorDeProductos($search,$estado,$pagina,$cantidadPorPagina){
		$filtroSql_1 = " 1 = 1";
		if($estado!=""){
			$filtroSql_1 = "P.`ID_ESTADO_PRODUCTO` = ".strip_tags($estado)."";
		}
		$filtroSql_2 = " AND 1 = 1";
		if($search!=""){
			$filtroSql_2 = " AND P.`NOMBRE_PRODUCTO` LIKE '%".strip_tags($search)."%'";
		}
		$sql = "FROM `PRODUCTO` P
				INNER JOIN `CATEGORIA2` CATHIJO
				ON(P.`ID_CATEGORIA2`=CATHIJO.`ID_CATEGORIA2`)
				INNER JOIN `CATEGORIA1` CATPADRE
				ON(CATHIJO.`ID_CATEGORIA3`=CATPADRE.`ID_CATEGORIA3`)
				INNER JOIN `USUARIO` U
				ON(P.`ID_USUARIO`=U.`ID_USUARIO`)
				INNER JOIN `NACIONALIDAD` NACIO
				ON(U.ID_NACIONALIDAD=NACIO.ID_NACIONALIDAD)
				WHERE 
				".$filtroSql_1." ".$filtroSql_2."
				AND P.`ID_ESTADO_PRODUCTO` != 4";
		$cantidadFilas = "SELECT COUNT(*) as cantidad ".$sql;
		$cantidadFilas = $this->conexion->listar($cantidadFilas);
		$cantidadFilas = $cantidadFilas[0]['cantidad'];
		if($cantidadFilas==0){
			return null;
		}
		$porcentajePorPagina = ($cantidadPorPagina*100)/$cantidadFilas;
		if($pagina==0){
			$limite1 = 0;
			$limite2 = (int)($cantidadFilas*($porcentajePorPagina/100));
		}elseif($pagina>0){
			$limite1 = $pagina * $cantidadPorPagina;
			$limite2 = ((int)($cantidadFilas*($porcentajePorPagina/100)))*$pagina;
		}else{
			return "la página debe ser mayor o igual a 0";
		}
		$query = "SELECT * ".$sql." LIMIT ".$limite1." ,".$limite2;
		$query = $this->conexion->listar($query);
		if($cantidadFilas<=0){
		}else{
			$array = array();
			for($x=0;$x<count($query);$x++){
				$array[]=
					array(
						"ID_PRODUCTO"=>$query[$x]['ID_PRODUCTO'],
						"ID_ESTADO_PRODUCTO"=>$query[$x]['ID_ESTADO_PRODUCTO'],
						"ID_CATEGORIA_HIJO"=>$query[$x]['ID_CATEGORIA3'],
						"NOMBRE_PRODUCTO"=>$query[$x]['NOMBRE_PRODUCTO'],
						"DETALLE_PRODUCTO"=>$query[$x]['DETALLE_PRODUCTO'],
						"VALOR_PRODUCTO"=>$query[$x]['VALOR_PRODUCTO'],
						"FOTO_PRODUCTO"=>$query[$x]['FOTO_PRODUCTO'],
						"NOMBRES_USUARIO"=>$query[$x]['NOMBRES_USUARIO'],
						"APELLIDOS_USUARIO"=>$query[$x]['APELLIDOS_USUARIO'],
						"NOMBRE_NACIONALIDAD"=>$query[$x]['NOMBRE_NACIONALIDAD']
					);
			}
			return array($array,$cantidadFilas);
	  	}
	}
	function eliminarProducto(){
		return $this->conexion->insertar("UPDATE `PRODUCTO` SET 
									`ID_ESTADO_PRODUCTO` = 4
							  WHERE `ID_PRODUCTO` = ".$this->ID_PRODUCTO);
		
	}
	function cambiarEstadoProducto(){
		return $this->conexion->insertar("UPDATE `PRODUCTO` SET `ID_ESTADO_PRODUCTO` = ".$this->ID_ESTADO_PRODUCTO
										 ." WHERE `ID_PRODUCTO` = ".$this->ID_PRODUCTO);
		
	}
	public function autocompletar($palabra){
		$listado = $this->conexion->listar("SELECT `NOMBRE_PRODUCTO`, `ID_PRODUCTO` FROM `PRODUCTO` WHERE `NOMBRE_PRODUCTO` LIKE '%".$palabra."%' AND `ID_ESTADO_PRODUCTO` = 1 LIMIT 7"); 
		$elementos = array();
		for($x=0;$x<count($listado);$x++){
			$elementos[] = array("id"=>$listado[$x]["ID_PRODUCTO"],"name"=>$listado[$x]["NOMBRE_PRODUCTO"]);
		}
		return json_encode($elementos);
	}
}
?>
