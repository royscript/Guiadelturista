<?php
include_once("Conexion.class.php");
error_reporting(E_ALL & ~E_NOTICE);
class Categorias{
	private $ID_CATEGORIA_PK = null;
	private $ID_CATEGORIA_FK = null;
	private $NOMBRE_CATEGORIA = null;
	private $FOTO_CATEGORIA = null;
	private $conexion = null;
	public function __construct($ID_CATEGORIA_PK,$ID_CATEGORIA_FK,$NOMBRE_CATEGORIA) {
		$this->ID_CATEGORIA_PK = strip_tags($ID_CATEGORIA_PK);
		$this->ID_CATEGORIA_FK = strip_tags($ID_CATEGORIA_FK);
		$this->NOMBRE_CATEGORIA = strip_tags($NOMBRE_CATEGORIA);
		$this->conexion = new Conexion();
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
	
	function listarCategoriasPadre($search,$categoria,$pagina,$cantidadPorPagina){
		$filtroSql_1 = " 1 = 1";
		if($search!=""){
			$filtroSql_1 = "  CAT_PADRE.`NOMBRE_CATEGORIA1` LIKE '%".strip_tags($search)."%'";
		}
		$filtroSql_2 = " AND 1 = 1";
		if(is_numeric($categoria)){
			if($categoria!=0 && $categoria!=''){
				$filtroSql_2 = " AND CAT_PADRE.`ID_CATEGORIA3` = ".strip_tags($categoria);
			}
		}
		
		$sql = " 
				FROM `CATEGORIA1` CAT_PADRE
				WHERE 
				".$filtroSql_1.$filtroSql_2;
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
		$query = "SELECT CAT_PADRE.`NOMBRE_CATEGORIA1` AS NOMBRE_PADRE,
						 CAT_PADRE.`ID_CATEGORIA3` AS ID_PADRE,
						 CAT_PADRE.FOTO_CATEGORIA_PADRE AS FOTO_CATEGORIA_PADRE
					".$sql."  LIMIT ".$limite1." ,".$limite2;
		$query = $this->conexion->listar($query);
		if($cantidadFilas<=0){
		}else{
			$array = array();
			for($x=0;$x<count($query);$x++){
				$array[]=
					array(
						"ID_PADRE"=>$query[$x]['ID_PADRE'],
						"NOMBRE_PADRE"=>$query[$x]['NOMBRE_PADRE'],
						"FOTO_CATEGORIA_PADRE"=>$query[$x]['FOTO_CATEGORIA_PADRE']
					);
			}
			return array($array,$cantidadFilas);
	  	}
	}
	function listarCategorias($search,$categoria,$pagina,$cantidadPorPagina){
		$filtroSql_1 = " 1 = 1";
		if($search!=""){
			$filtroSql_1 = " (CAT_HIJO.`NOMBRE_CATEGORIA1` LIKE '%".strip_tags($search)."%'
							OR CAT_PADRE.`NOMBRE_CATEGORIA1` LIKE '%".strip_tags($search)."%')";
		}
		$filtroSql_2 = " AND 1 = 1";
		if(is_numeric($categoria)){
			if($categoria!=0 && $categoria!=''){
				$filtroSql_2 = " AND CAT_PADRE.`ID_CATEGORIA3` = ".strip_tags($categoria);
			}
		}
		
		$sql = " 
				FROM `CATEGORIA2` CAT_HIJO
				INNER JOIN `CATEGORIA1` CAT_PADRE
				ON(CAT_HIJO.`ID_CATEGORIA3`=CAT_PADRE.`ID_CATEGORIA3`)
				WHERE 
				".$filtroSql_1.$filtroSql_2;
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
		$query = "SELECT CAT_HIJO.`NOMBRE_CATEGORIA1` AS NOMBRE_HIJO,
		                 CAT_PADRE.`NOMBRE_CATEGORIA1` AS NOMBRE_PADRE,
						 CAT_PADRE.`ID_CATEGORIA3` AS ID_PADRE,
						 CAT_HIJO.`ID_CATEGORIA2` AS ID_HIJO
					".$sql."  LIMIT ".$limite1." ,".$limite2;
		$query = $this->conexion->listar($query);
		if($cantidadFilas<=0){
		}else{
			$array = array();
			for($x=0;$x<count($query);$x++){
				$array[]=
					array(
						"ID_HIJO"=>$query[$x]['ID_HIJO'],
						"ID_PADRE"=>$query[$x]['ID_PADRE'],
						"NOMBRE_PADRE"=>$query[$x]['NOMBRE_PADRE'],
						"NOMBRE_HIJO"=>$query[$x]['NOMBRE_HIJO']
					);
			}
			return array($array,$cantidadFilas);
	  	}
	}
	public function registrarPadre(){
		return $this->conexion->insertar("INSERT INTO `CATEGORIA1` (`NOMBRE_CATEGORIA1`) VALUES ('".$this->NOMBRE_CATEGORIA."')");
	}
	public function modificarPadre(){
		return $this->conexion->insertar("UPDATE `CATEGORIA1` SET 
												`NOMBRE_CATEGORIA1` = '".$this->NOMBRE_CATEGORIA."'
										  WHERE `ID_CATEGORIA3` = ".$this->ID_CATEGORIA_PK);
	}
	public function registrarHijo(){
		echo "INSERT INTO `CATEGORIA2` (`ID_CATEGORIA3`,`NOMBRE_CATEGORIA1`) VALUES (".$this->ID_CATEGORIA_FK.",'".$this->NOMBRE_CATEGORIA."')";
		return $this->conexion->insertar("INSERT INTO `CATEGORIA2` (`ID_CATEGORIA3`,`NOMBRE_CATEGORIA1`) VALUES (".$this->ID_CATEGORIA_FK.",'".$this->NOMBRE_CATEGORIA."')");
	}
	public function modificarHijo(){
		return $this->conexion->insertar("UPDATE `CATEGORIA2` SET 
												`NOMBRE_CATEGORIA1` = '".$this->NOMBRE_CATEGORIA."',
												`ID_CATEGORIA3` = ".$this->ID_CATEGORIA_FK."
										  WHERE `ID_CATEGORIA2` = ".$this->ID_CATEGORIA_PK);
	}
	public function adjuntarFotoCategoriaPadre($foto){
		
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
				$ancho_limite = 264;
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
				# Agregamos la imagen a la base de datos
				$sql = "UPDATE `CATEGORIA1` SET 
												`FOTO_CATEGORIA_PADRE` = '".$image."'
										  WHERE `ID_CATEGORIA3` = ".$this->ID_CATEGORIA_PK;
				//$sql="INSERT INTO `imagephp` (anchura,altura,tipo,imagen) VALUES (".$info[0].",".$info[1].",'".$foto["type"]."','".$imagenEscapes."')";
				//$mysqli->query($sql);
				$this->conexion->modificar($sql);
				# Cogemos el identificador con que se ha guardado
				//$id=$mysqli->insert_id;
				
				# Mostramos la imagen agregada
				//echo "<div class='mensaje'>Imagen agregada con el id ".$id."</div>";
			}else{
				//echo "<div class='error'>Error: El formato de archivo tiene que ser JPG, GIF, BMP o PNG.</div>";
			}
		}
	}
}
?>
