<?php
error_reporting(E_ALL);
date_default_timezone_set('america/santiago');
class Conexion {

	private $host = "127.0.0.1";

    private $user = "neosyste_turista";

	private $password = "aucl3kcVETWm";

	private $bd = "neosyste_turista";

	private $connection = null;

	public function __construct() {
		$this->conectar();
	}

	/* Realiza la conexión a la base de datos. */



	private
	function conectar() {

		// -------CONEXION A UNA BASE DE DATOS

		$this->connection = new mysqli( $this->host, $this->user, $this->password, $this->bd );

		if ( $this->connection->connect_errno ) {

			die( "Error de Conexion: (" . $this->connection->mysqli_connect_errno()

				. ")" . $this->connection->mysqli_connect_error() );

			//header("Location: error-conexion.php');

			exit;

		} else {

			if ( !$this->connection->set_charset( "utf8" ) ) {

				printf( "Error transformando a UTF-8 : %s\n", $this->connection->error );

			} else {

				return $this->connection;

			}

		}

	}

	public
	function insertar( $query ) {

		if ( $query = mysqli_query( $this->connection, $query ) ) {
			return mysqli_insert_id( $this->connection );

		} else {
			echo mysqli_error($this->connection);
			return false;

		}

	}


	public function modificar($sql) {
		return $this->insertar($sql);
	}


	public function eliminar($sql) {
		return $this->insertar($sql);
	}

	public
	function listar( $sql ) {
		$enlace = $this->connection;
		$query = mysqli_query( $enlace, $sql );
		$array = array();
		echo mysqli_error($enlace);
		if ( mysqli_num_rows( $query ) > 0 ) {
			while ( $row = mysqli_fetch_assoc( $query ) ) {
				$array[] = $row;
			}
		}
		return $array;
	}
	
	
	public function listarConPaginador($sqlCantidad,$parametroCantidad,$sqlRegistros,$parametro,$pagina,$cantidadPorPagina = 10){
		$cantidadFilas = $this->listar($sqlCantidad);
		$cantidadFilas = $cantidadFilas[0]['CANTIDAD'];
		$limites = $this->limitesPaginacion($pagina,$cantidadPorPagina);
		$sqlRegistros = $sqlRegistros."  LIMIT ".$limites['Limite1']." ,".$limites['Limite2'];
		$enlace = $this->conectar();
		$sqlRegistros = mysql_query($sqlRegistros);
		$array = array();
		while($row = mysql_fetch_assoc($sqlRegistros)){
			$array[]= $row;
		}
		mysql_close($enlace);
		return json_encode(array("Datos"=>$array,"CantidadFilas"=>$cantidadFilas));
	}


	public function limitesPaginacion($pagina,$cantidadPorPagina) {
		$pagina = $pagina+1;//Se le suma 1 para que no se realize el calculo desde la pagina 0, sino desde la 1
		$limite1 = ($pagina-1)*$cantidadPorPagina;
		$limite2 = $cantidadPorPagina;
		return array("Limite1"=>$limite1,"Limite2"=>$limite2);
	}
	
	public function __destruct(){
                
	}  
}
?>