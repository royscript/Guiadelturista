<?php
include_once("Conexion.class.php"); 
class Contactar{
	private $ID_CONTACTAR = null;
	private $ID_PRODUCTO = null;
	private $ID_USUARIO = null;
	private $ID_ESTADO_CONTACTO = null;
	private $USU_ID_USUARIO = null;
	private $DETALLE_INTERES_CONTACTAR = null;
	private $DETALLE_RESPUESTA_CONTACTAR = null;
	private $conexion = null;
	public function __construct($ID_CONTACTAR, $ID_PRODUCTO, $ID_USUARIO, 
								$ID_ESTADO_CONTACTO, $USU_ID_USUARIO, $DETALLE_INTERES_CONTACTAR, 
								$DETALLE_RESPUESTA_CONTACTAR) {
		$this->ID_CONTACTAR = strip_tags($ID_CONTACTAR);
		$this->ID_PRODUCTO = strip_tags($ID_PRODUCTO);
		$this->ID_USUARIO = strip_tags($ID_USUARIO);
		$this->ID_ESTADO_CONTACTO = strip_tags($ID_ESTADO_CONTACTO);
		$this->USU_ID_USUARIO = strip_tags($USU_ID_USUARIO);
		$this->DETALLE_INTERES_CONTACTAR = strip_tags($DETALLE_INTERES_CONTACTAR);
		$this->DETALLE_RESPUESTA_CONTACTAR = strip_tags($DETALLE_RESPUESTA_CONTACTAR);
		$this->conexion = new Conexion();
	}
	public function enviarCorreo($mensaje,$idEmisor,$idDestinatario){
		$registrosUsuarioDestinatario = $this->conexion->listar("SELECT * FROM `USUARIO` WHERE `ID_USUARIO`=".$idDestinatario);
		$registrosUsuarioEmisor = $this->conexion->listar("SELECT * FROM `USUARIO` WHERE `ID_USUARIO`=".$idEmisor);
		$mensaje = $mensaje."
		        <br>
		        <br><strong>Datos del usuario :</strong>
				<br><strong>Nombre :</strong> ".$registrosUsuarioEmisor[0]["NOMBRES_USUARIO"]." ".$registrosUsuarioEmisor[0]["APELLIDOS_USUARIO"]."
				<br><strong>E-mail :</strong> ".$registrosUsuarioEmisor[0]["EMAIL_USUARIO"]."
				<br><strong>Dirección :</strong> ".$registrosUsuarioEmisor[0]["DIRECCION_USUARIO"]."
				<br><strong>Celular :</strong> ".$registrosUsuarioEmisor[0]["CELULAR_USUARIO"]."
				<br><strong>Whatsap :</strong> ".$registrosUsuarioEmisor[0]["WHATSAPP_USUARIO"];
		//Titulo
		$titulo = "Se quiere contactar contigo ".$registrosUsuarioEmisor[0]["NOMBRES_USUARIO"]." ".$registrosUsuarioEmisor[0]["APELLIDOS_USUARIO"];
		
		
		
		$destinatario = $registrosUsuarioDestinatario[0]["EMAIL_USUARIO"]; 
		$asunto = $titulo; 
		$cuerpo = ' 
		<html> 
		<head> 
		</head> 
		<body> 
		'.$mensaje.'
		</body> 
		</html> 
		'; 

		//para el envío en formato HTML 
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

		//dirección del remitente 
		$headers .= "From: GuíaColombia <GuiaColombia@neosystem.cl>\r\n"; 

		//dirección de respuesta, si queremos que sea distinta que la del remitente 
		$headers .= "Reply-To: ".$registrosUsuarioDestinatario[0]["EMAIL_USUARIO"]."\r\n"; 

		//ruta del mensaje desde origen a destino 
		$headers .= "Return-path: ".$registrosUsuarioDestinatario[0]["EMAIL_USUARIO"]."\r\n"; 

		//direcciones que recibián copia 
		$headers .= "Cc: ".$registrosUsuarioDestinatario[0]["EMAIL_USUARIO"]."\r\n"; 

		//direcciones que recibirán copia oculta 

		mail($destinatario,$asunto,$cuerpo,$headers);
	}
	public function solicitar(){
		$repetido = $this->conexion->listar("SELECT * 
												FROM `CONTACTAR` 
												WHERE `ID_PRODUCTO` = ".$this->ID_PRODUCTO."
												AND `ID_USUARIO` = ".$this->ID_USUARIO."
												AND `ID_ESTADO_CONTACTO` = 1
												AND `USU_ID_USUARIO` = ".$this->USU_ID_USUARIO."
												AND `FECHA_INTERES_CONTACTAR` = CURDATE()
												AND `DETALLE_INTERES_CONTACTAR` LIKE '".$this->DETALLE_INTERES_CONTACTAR."'");
		if(count($repetido)==0){
			$sql = "INSERT INTO `CONTACTAR`
										(`ID_PRODUCTO`,`ID_USUARIO`,`ID_ESTADO_CONTACTO`,
										 `USU_ID_USUARIO`,`FECHA_INTERES_CONTACTAR`,`HORA_INTERES_CONTACTAR`,
										 `DETALLE_INTERES_CONTACTAR`)
										 VALUES
										 (".$this->ID_PRODUCTO.",".$this->ID_USUARIO.",".$this->ID_ESTADO_CONTACTO.",
										  ".$this->USU_ID_USUARIO.",CURDATE(),DATE_FORMAT(NOW(),'%h:%m:%s'),
										  '".$this->DETALLE_INTERES_CONTACTAR."')";
			$this->conexion->insertar($sql);
			$datos_producto = $this->conexion->listar("SELECT * FROM `PRODUCTO` WHERE `ID_PRODUCTO`=".$this->ID_PRODUCTO);
			$mensaje = "<br><strong>Producto de interés : </strong>".$datos_producto[0]["NOMBRE_PRODUCTO"]."
						<br><strong>Comentarios : </strong>".$this->DETALLE_INTERES_CONTACTAR;
			$idOfertante = $this->USU_ID_USUARIO;
			$idCliente = $this->ID_USUARIO;
			$this->enviarCorreo($mensaje,$idCliente,$idOfertante);
		}
		
	}
	public function mostrarContactosDelUsuario($pagina,$cantidadPorPagina){
		$sql = "FROM `CONTACTAR` C
				INNER JOIN `PRODUCTO` P
				ON(P.`ID_PRODUCTO`=C.`ID_PRODUCTO`)
				INNER JOIN `USUARIO` U
				ON(U.`ID_USUARIO`=C.`ID_USUARIO`)
				WHERE C.`USU_ID_USUARIO` = ".$this->USU_ID_USUARIO."";
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
		$query = "SELECT *, DATE_FORMAT(FECHA_INTERES_CONTACTAR,'%d-%m-%Y') AS FECHA ".$sql." ORDER BY `ID_CONTACTAR` DESC  LIMIT ".$limite1." ,".$limite2;
		$query = $this->conexion->listar($query);
		if($cantidadFilas<=0){
		}else{
			$array = array();
			for($x=0;$x<count($query);$x++){
				$array[]=
					array(
						"NOMBRES_USUARIO"=>$query[$x]['NOMBRES_USUARIO'],
						"APELLIDOS_USUARIO"=>$query[$x]['APELLIDOS_USUARIO'],
						"EMAIL_USUARIO"=>$query[$x]['EMAIL_USUARIO'],
						"CELULAR_USUARIO"=>$query[$x]['CELULAR_USUARIO'],
						"WHATSAPP_USUARIO"=>$query[$x]['WHATSAPP_USUARIO'],
						"DIRECCION_USUARIO"=>$query[$x]['DIRECCION_USUARIO'],
						"USUARIO_USUARIO"=>$query[$x]['USUARIO_USUARIO'],
						"NOMBRE_PRODUCTO"=>$query[$x]['NOMBRE_PRODUCTO'],
						"FOTO_PRODUCTO"=>$query[$x]['FOTO_PRODUCTO'],
						"FECHA_INTERES_CONTACTAR"=>$query[$x]['FECHA'],
						"HORA_INTERES_CONTACTAR"=>$query[$x]['HORA_INTERES_CONTACTAR'],
						"DETALLE_INTERES_CONTACTAR"=>$query[$x]['DETALLE_INTERES_CONTACTAR'],
						"ID_ESTADO_CONTACTO"=>$query[$x]['ID_ESTADO_CONTACTO'],
						"ID_CONTACTAR"=>$query[$x]['ID_CONTACTAR'],
						"VALOR_PRODUCTO"=>$query[$x]['VALOR_PRODUCTO']
					);
			}
			return array($array,$cantidadFilas);
		}
	}
	public function responder(){
		$sql = "UPDATE `CONTACTAR` SET
						`FECHA_RESPUESTA_CONTACTAR` = CURDATE(),
						`ID_ESTADO_CONTACTO` = 2,
						`HORA_RESPUESTA_CONTACTAR` = DATE_FORMAT(NOW(),'%h:%m:%s'),
						`DETALLE_RESPUESTA_CONTACTAR` = '".$this->DETALLE_RESPUESTA_CONTACTAR."'
						WHERE `ID_CONTACTAR` = ".$this->ID_CONTACTAR;
		$this->conexion->modificar($sql);
		$datosUsuarioRespuesta = $this->conexion->listar("SELECT * 
															FROM `PRODUCTO` P
															INNER JOIN `CONTACTAR` C
															ON(P.`ID_PRODUCTO`=C.`ID_PRODUCTO`)
															INNER JOIN `USUARIO` U
															ON(U.`ID_USUARIO`=C.`ID_USUARIO`)
															WHERE `ID_CONTACTAR` =".$this->ID_CONTACTAR);
		$idOfertante = $datosUsuarioRespuesta[0]["USU_ID_USUARIO"];
		$idCliente = $datosUsuarioRespuesta[0]["ID_USUARIO"];
		$this->enviarCorreo("<br>Respuesta del Ofertante <br>".$this->DETALLE_RESPUESTA_CONTACTAR,$idOfertante,$idCliente);
	}
	public function mostrarComprasDelUsuario($pagina,$cantidadPorPagina){
		$sql = "FROM `CONTACTAR` C
				INNER JOIN `PRODUCTO` P
				ON(P.`ID_PRODUCTO`=C.`ID_PRODUCTO`)
				INNER JOIN `USUARIO` U
				ON(U.`ID_USUARIO`=C.`USU_ID_USUARIO`)
				WHERE C.`ID_USUARIO` = ".$this->ID_USUARIO."";
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
		$query = "SELECT *, DATE_FORMAT(FECHA_RESPUESTA_CONTACTAR,'%d-%m-%Y') AS FECHA ".$sql." ORDER BY `ID_CONTACTAR` DESC  LIMIT ".$limite1." ,".$limite2;
		$query = $this->conexion->listar($query);
		if($cantidadFilas<=0){
		}else{
			$array = array();
			for($x=0;$x<count($query);$x++){
				$array[]=
					array(
						"NOMBRES_USUARIO"=>$query[$x]['NOMBRES_USUARIO'],
						"APELLIDOS_USUARIO"=>$query[$x]['APELLIDOS_USUARIO'],
						"EMAIL_USUARIO"=>$query[$x]['EMAIL_USUARIO'],
						"CELULAR_USUARIO"=>$query[$x]['CELULAR_USUARIO'],
						"WHATSAPP_USUARIO"=>$query[$x]['WHATSAPP_USUARIO'],
						"DIRECCION_USUARIO"=>$query[$x]['DIRECCION_USUARIO'],
						"USUARIO_USUARIO"=>$query[$x]['USUARIO_USUARIO'],
						"NOMBRE_PRODUCTO"=>$query[$x]['NOMBRE_PRODUCTO'],
						"FOTO_PRODUCTO"=>$query[$x]['FOTO_PRODUCTO'],
						"FECHA_RESPUESTA_CONTACTAR"=>$query[$x]['FECHA'],
						"HORA_INTERES_CONTACTAR"=>$query[$x]['HORA_INTERES_CONTACTAR'],
						"DETALLE_RESPUESTA_CONTACTAR"=>$query[$x]['DETALLE_RESPUESTA_CONTACTAR'],
						"ID_ESTADO_CONTACTO"=>$query[$x]['ID_ESTADO_CONTACTO'],
						"ID_CONTACTAR"=>$query[$x]['ID_CONTACTAR'],
						"VALOR_PRODUCTO"=>$query[$x]['VALOR_PRODUCTO']
					);
			}
			return array($array,$cantidadFilas);
		}
	}
	public function cantidadComprasPendientes(){
		$sql = "FROM `CONTACTAR` C
				INNER JOIN `PRODUCTO` P
				ON(P.`ID_PRODUCTO`=C.`ID_PRODUCTO`)
				INNER JOIN `USUARIO` U
				ON(U.`ID_USUARIO`=C.`USU_ID_USUARIO`)
				WHERE C.`ID_ESTADO_CONTACTO` = 2 
				AND C.`ID_USUARIO` = ".$this->ID_USUARIO."";
		$cantidadFilas = "SELECT COUNT(*) as cantidad ".$sql;
		$cantidad = $this->conexion->listar($cantidadFilas);
		return $cantidad = $cantidad[0]["cantidad"];
	}
	public function cantidadVentasPendientes(){
		$sql = "FROM `CONTACTAR` C
				INNER JOIN `PRODUCTO` P
				ON(P.`ID_PRODUCTO`=C.`ID_PRODUCTO`)
				INNER JOIN `USUARIO` U
				ON(U.`ID_USUARIO`=C.`ID_USUARIO`)
				WHERE C.`ID_ESTADO_CONTACTO` = 1
				AND C.`USU_ID_USUARIO` = ".$this->USU_ID_USUARIO."";
		$cantidadFilas = "SELECT COUNT(*) as cantidad ".$sql;
		$cantidad = $this->conexion->listar($cantidadFilas);
		return $cantidad = $cantidad[0]["cantidad"];
	}
	public function mensajeLeido(){
		$sql = "UPDATE `CONTACTAR` SET
						`ID_ESTADO_CONTACTO` = 3
						WHERE `ID_CONTACTAR` = ".$this->ID_CONTACTAR."
						AND `ID_USUARIO` = ".$this->ID_USUARIO;
		$this->conexion->modificar($sql);
	}
}
?>