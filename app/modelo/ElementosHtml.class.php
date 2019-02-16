<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once("Contactar.class.php");
class ElementosHtml{
	private $urlWeb = "https://neosystemspa.cl/NeoGuias/vistas/";
	private $id_sdk_facebook = "220038328518780";
	public function sdkFacebook(){
		echo $this->id_sdk_facebook;
	}
	function menuNavegacionSuperiorLogeadoOfertante($submenuElejido,$nombre_usuario){
		$nombrePagina = "MercadoExtranjeros";
		$elementosMenu[0] = array("texto" => "Bienvenido(a) ".$nombre_usuario, "href" => "#");
		$menu = '
		<div class="header clearfix">
			<nav class="navbar navbar-main navbar-default" role="navigation">
          		<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
					  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					  </button>
					  <a class="navbar-brand" href="'.$this->urlWeb.'index.php">'.$nombrePagina.'</a>
					</div>
        
            	<!-- Collect the nav links, forms, and other content for toggling -->
            	<div class="collapse navbar-collapse navbar-ex1-collapse" id="navbar_colapsada">            
              	<ul class="nav navbar-nav navbar-right">';
		for($x=0;$x<count($elementosMenu);$x++){
			if($submenuElejido==$elementosMenu[$x]){
				$menu .= '<li class="nav-item active"> 
								<a href="'.$elementosMenu[$x]["href"].'" class="nav-item-toggle" data-toggle="" role="button" aria-haspopup="true" aria-expanded="false"> 
									'.$elementosMenu[$x]["texto"].'</a> 
							</li>';
			}else{
				$menu .= '<li class="nav-item"> 
								<a href="'.$elementosMenu[$x]["href"].'" class="nav-item-toggle" data-toggle="" role="button" aria-haspopup="true" aria-expanded="false"> 
									'.$elementosMenu[$x]["texto"].'</a> 
							</li>';
				
			}
		}
                
        $menu .= '</ul>
            </div><!-- /.navbar-collapse -->
          </div>
        </nav>
		</div>';       
		echo $menu;
	}
	function menuNavegacionSuperior($submenuElejido){
		if(isset($_SESSION["idUsuario"])){
			$this->menuNavegacionSuperiorLogeadoOfertante(0,$_SESSION["nombresUsuario"]);
			return false;
		}
		$nombrePagina = "MercadoExtranjeros";
		$elementosMenu[0] = array("texto" => "Ingresa ", "href" => $this->urlWeb."login.php");
		$elementosMenu[1] = array("texto" => " ó ", "href" => "#");
		$elementosMenu[2] = array("texto" => "Regístrate ", "href" => $this->urlWeb."registro/ofertante/Registro-parte-1.php");
		$elementosMenu[3] = array("texto" => '<em class="fa fa-facebook"></em>', "href" => "https://www.facebook.com/ColombianosEnChile.Cl/");
		$elementosMenu[4] = array("texto" => '<em class="fa fa-twitter"></em>', "href" => "#");
		$menu = '
		<div class="header clearfix">
			<nav class="navbar navbar-main navbar-default" role="navigation">
          		<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
					  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					  </button>
					  <a class="navbar-brand" href="'.$this->urlWeb.'index.php">'.$nombrePagina.'</a>
					</div>
        
            	<!-- Collect the nav links, forms, and other content for toggling -->
            	<div class="collapse navbar-collapse navbar-ex1-collapse" id="navbar_colapsada">            
              	<ul class="nav navbar-nav navbar-right">';
		for($x=0;$x<count($elementosMenu);$x++){
			if($submenuElejido==$elementosMenu[$x]){
				$menu .= '<li class="dropdown active"> 
								<a href="'.$elementosMenu[$x]["href"].'" class="dropdown-toggle" data-toggle="" role="button" aria-haspopup="true" aria-expanded="false"> 
									'.$elementosMenu[$x]["texto"].'</a> 
							</li>';
			}else{
				$menu .= '<li class="dropdown"> 
								<a href="'.$elementosMenu[$x]["href"].'" class="dropdown-toggle" data-toggle="" role="button" aria-haspopup="true" aria-expanded="false"> 
									'.$elementosMenu[$x]["texto"].'</a> 
							</li>';
				
			}
		}
                
        $menu .= '</ul>
            </div><!-- /.navbar-collapse -->
          </div>
        </nav>
		</div>';       
		echo $menu;
	}
	function carousellPrincipal(){
		$fotos[0] = array("foto" => "../img/slide1html.png", "textoSuperior" => "", "textoInferior" => "");
		$fotos[1] = array("foto" => "../img/slide2html.png", "textoSuperior" => "", "textoInferior" => "");
		$fotos[2] = array("foto" => "../img/slide3html.png", "textoSuperior" => "", "textoInferior" => "");
		$galeriaCarousel = '<div id="carousel1" class="carousel slide carousell_principal" data-ride="carousel">
								<ol class="carousel-indicators">
								  <li data-target="#carousel1" data-slide-to="0" class="active"></li>
								  <li data-target="#carousel1" data-slide-to="1"></li>
								  <li data-target="#carousel1" data-slide-to="2"></li>
								</ol>
								<div class="carousel-inner" role="listbox">';
		for($x=0;$x<count($fotos);$x++){
			$primerItem = "item";
			if($x==0){
				$primerItem = "item active";	
			}
			$galeriaCarousel .= '<div class="'.$primerItem.'"><img src="'.$fotos[$x]["foto"].'" alt="First slide image" class="center-block">
            <div class="carousel-caption">
              <h3>'.$fotos[$x]["textoSuperior"].'</h3>
              <p>'.$fotos[$x]["textoInferior"].'</p>
            </div>
          </div>';
		}
        $galeriaCarousel .= '  </div>
        						<a class="left carousel-control" href="#carousel1" role="button" data-slide="prev">
									<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
									<span class="sr-only">Previous</span>
								</a>
								<a class="right carousel-control" href="#carousel1" role="button" data-slide="next">
									<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
									<span class="sr-only">Next</span>
								</a>
						</div>';
		echo $galeriaCarousel;
	}
	function categorias(){
		include_once("Categorias.class.php");
		$categoria = new Categorias("","","");
		$listado_categorias = $categoria->categoriaPadre();
		for($x=0;$x<count($listado_categorias);$x++){
			$elementos[] = array("foto" => "data:imagen/jpeg;base64,".$listado_categorias[$x]["FOTO_CATEGORIA_PADRE"], "nombre" => $listado_categorias[$x]["NOMBRE_CATEGORIA1"], "textoOnFocus" => "Ver Productos", "href" => "../controlador/procesaIndex.php?categoria=".$listado_categorias[$x]["ID_CATEGORIA3"]);
		}
		$nombre = "Categorías";
		$tumbail = "location.href='single-product.html';";
		$html = '<div class="row featuredCollection margin-bottom">
            <div class="col-xs-12">
              <div class="page-header">
                <h4>'.$nombre.'</h4>
              </div>
            </div>';
		for($x=0;$x<count($elementos);$x++){
			$html .= '<div class="col-sm-4 col-xs-12">'
              .'<div class="thumbnail" onclick="'.$tumbail.'">'
                .'<div class="imageWrapper">'
                  .'<img src="'.$elementos[$x]["foto"].'" alt="feature-collection-image">'
                  .'<div class="masking"><a href="'.$elementos[$x]["href"].'" class="btn viewBtn">'.$elementos[$x]["textoOnFocus"].'</a></div>'
                .'</div>'
                .'<div class="caption">'
                  .'<h4>'.$elementos[$x]["nombre"].'</h4>'
                .'</div>'
              .'</div>'
            .'</div>';
		}
        $html .= '</div>';
		echo $html;
	}
	function sliderHorizontal($nombre,$elementos){
		$html = '<div class="row featuredProducts margin-bottom">
            <div class="col-xs-12">
              <div class="page-header">
                <h4>'.$nombre.'</h4>
              </div>
            </div>
            <div class="col-xs-12">
              <div class="owl-carousel featuredProductsSlider">';
		
		for($x=0;$x<count($elementos);$x++){
			$html.= '<div class="slide">
					  <div class="productImage clearfix">
						<img src="'.$elementos[$x]["foto"].'" alt="featured-product-img">
						<div class="productMasking">
						  <ul class="list-inline btn-group" role="group">
							<li><a class="btn btn-default" data-toggle="modal" style="width: 157px;" href="#" id="producto-'.$elementos[$x]["id"].'" onClick="mostrarProducto('.$elementos[$x]["id"].')" >VER PRODUCTO <i class="fa fa-eye"></i></a></li>
						  </ul>
						</div>
					  </div>
					  <div class="productCaption clearfix">
						<a href="#">
						<h5>'.$elementos[$x]["nombre"].'</h5>
						</a>
						<h3>'.$elementos[$x]["valor"].'</h3>
					  </div>
					</div>';
		}
		$html .= '</div>
            </div>  
          </div>';
		echo $html;
	}
	function barraInferior($menuElejido = 7777777){
		$bandera = false;
		if(isset($_SESSION["tipoDeSesión"])){
			if($_SESSION["tipoDeSesión"]==4){
				$bandera = true;
			}
		}
		
		if($bandera==true){
			if($_SESSION["tipoDeSesión"]==4){
				$html =	$this->menuPerfilAdministrador($menuElejido);
			}
		}else if(isset($_SESSION["idUsuario"])){
			$compras = new Contactar("","",$_SESSION["idUsuario"],"","","","");
			$ventas = new Contactar("","","","",$_SESSION["idUsuario"],"","");
			$elementos_menu[0] = array(
										"url" => "cerrar-sesion.php",
										"texto" => '<span class="glyphicon glyphicon-log-out" style="font-size: 30px;"></span>
										<br>Salir'
									);
			$elementos_menu[1] = array(
										"url" => "perfil-ofertante/datos-personales.php",
										"texto" => '<span class="glyphicon glyphicon-user" style="font-size: 30px;"></span>
										<br>Perfil'
									);
			$elementos_menu[2] = array(
										"url" => "ventas.php",
										"texto" => '<span class="glyphicon glyphicon-usd" style="font-size: 30px;"></span>
										<br>Ventas <span class="badge">'.$ventas->cantidadVentasPendientes().'</span>'
									);
			$elementos_menu[3] = array(
										"url" => "compras.php",
										"texto" => '<span class="glyphicon glyphicon-shopping-cart" style="font-size: 30px;"></span>
										<br>Compras <span class="badge">'.$compras->cantidadComprasPendientes().'</span>'
									);
			$elementos_menu[4] = array(
										"url" => "categoria-productos.php",
										"texto" => '<span class="glyphicon glyphicon-search" style="font-size: 30px;"></span>
										<br>Buscar'
									);
			$html = '<div id="barra_navegacion_inferior">
					<ul>';
					  					  
			for($x=0;$x<count($elementos_menu);$x++){
				if($menuElejido==$x){
					$html .= '<li style="text-align: center;">
							<a href="'.$this->urlWeb.$elementos_menu[$x]["url"].'" class="elementoSeleccionadoInferior">
							  '.$elementos_menu[$x]["texto"].'
							</a>
						  </li>';
				}else{
					$html .= '<li style="text-align: center;">
							<a href="'.$this->urlWeb.$elementos_menu[$x]["url"].'">
							  '.$elementos_menu[$x]["texto"].'
							</a>
						  </li>';
				}
			}
					  
					  
		    $html .= '</ul>
				  </div>';
		}else{
			$html = '<div id="barra_navegacion_inferior">
					<ul>
					  <li style="text-align: center;">
						<a href="'.$this->urlWeb.'registro/ofertante/Registro-parte-1.php">
						  <span class="glyphicon glyphicon-registration-mark" style="font-size: 30px;"></span>
							<br>Registrarme
						</a>
					  </li>
					  <li style="text-align: center;">
						<a href="'.$this->urlWeb.'login.php">
						  <span class="glyphicon glyphicon-log-in" style="font-size: 30px;"></span>
							<br>Iniciar Sesión
						</a>
					  </li>
					  <li style="text-align: center;">
						<a href="'.$this->urlWeb.'categoria-productos.php">
						  <span class="glyphicon glyphicon-search" style="font-size: 30px;"></span>
							<br>Buscar
						</a>
					  </li>
					</ul>
				  </div>';
		}
		echo $html;
	}
	
	function pieDePagina(){
		if(isset($_SESSION["idUsuario"])){
			$html = '<div class="footer clearfix" id="pie_de_pagina">
					<div class="container">
					  <div class="row">
						<!--<div class="col-sm-2 col-xs-12">
						  <div class="footerLink">
							<h5>Categorías</h5>
							<ul class="list-unstyled">
							  <li><a href="#">Comida rápida </a></li>
							  <li><a href="#">Sopas </a></li>
							  <li><a href="#">Almuerzos </a></li>
							  <li><a href="#">Menús Completos </a></li>
							</ul>
						  </div>
						</div>-->

						<div class="col-sm-2 col-xs-12">
						  <div class="footerLink">
							<h5>Síguenos en las principales redes sociales</h5>
							<ul class="list-inline">
							  <li><a href="#"><i class="fa fa-twitter"></i></a></li>
							  <li><a href="https://www.facebook.com/ColombianosEnChile.Cl/"><i class="fa fa-facebook"></i></a></li>
							</ul>
						  </div>
						</div>
						
						<div class="col-sm-4 col-xs-12 cuadros_con_botones_footer">
						  <div class="newsletter clearfix">
							<div class="input-group">
							</div>
						  </div>  
						</div>
						
					  </div>
					</div>
				  </div>';
		}else{
			$html = '<div class="footer clearfix" id="pie_de_pagina">
					<div class="container">
					  <div class="row">
						<!--<div class="col-sm-2 col-xs-12">
						  <div class="footerLink">
							<h5>Categorías</h5>
							<ul class="list-unstyled">
							  <li><a href="#">Comida rápida </a></li>
							  <li><a href="#">Sopas </a></li>
							  <li><a href="#">Almuerzos </a></li>
							  <li><a href="#">Menús Completos </a></li>
							</ul>
						  </div>
						</div>-->

						<div class="col-sm-2 col-xs-12">
						  <div class="footerLink">
							<h5>Síguenos en las principales redes sociales</h5>
							<ul class="list-inline">
							  <li><a href="#"><i class="fa fa-twitter"></i></a></li>
							  <li><a href="https://www.facebook.com/ColombianosEnChile.Cl/"><i class="fa fa-facebook"></i></a></li>
							</ul>
						  </div>
						</div>
						<div class="col-sm-4 col-xs-12 cuadros_con_botones_footer">
						  <div class="newsletter clearfix">
							<h4>¿Estás interesado en recivir novedades de productos extranjeros?</h4>
							<div class="input-group">
							  <a href="'.$this->urlWeb."registro/ofertante/Registro-parte-1.php".'" class="input-group-addon boton_registrarse" id="basic-addon2">Registrate ahora <i class="glyphicon glyphicon-chevron-right"></i></a>
							</div>
						  </div>  
						</div>
						<div class="col-sm-4 col-xs-12 cuadros_con_botones_footer">
						  <div class="newsletter clearfix">
							<div class="input-group">
							</div>
						  </div>  
						</div>
						<div class="col-sm-4 col-xs-12">
						  <div class="newsletter clearfix">
							<h4>¿Eres extranjero y deseas vender productos?</h4>
							<div class="input-group">
							 <br>
							  <a href="'.$this->urlWeb."registro/ofertante/Registro-parte-1.php".'" class="input-group-addon boton_registrarse" id="basic-addon2">Regístrate ahora <i class="glyphicon glyphicon-chevron-right"></i></a>
							</div>
						  </div>  
						</div>
					  </div>
					</div>
				  </div>';
		}
		
		echo $html;
	}
	function menuPerfilUsuario($elementoSeleccionado){
		$elementos[0] = array("nombre" => '<i class="fa fa-user" aria-hidden="true"></i>&nbsp;Datos personales', "href" => "datos-personales.php");
		$elementos[1] = array("nombre" => '<i class="fa fa-th" aria-hidden="true"></i>&nbsp;Ubicación', "href" => "datos-ubicacion.php");
		$elementos[2] = array("nombre" => '<i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;Sectores de despacho', "href" => "datos-sectores-despacho.php");
		$elementos[3] = array("nombre" => '<i class="fa fa-tag" aria-hidden="true"></i>&nbsp;Productos', "href" => "datos-productos.php");
		$html = '<div class="col-xs-12">
				  <div class="btn-group barraPerfilOfertante" role="group" aria-label="...">';

		for($x=0;$x<count($elementos);$x++){
			if($elementoSeleccionado==$x){
				$html .= '<a href="'.$elementos[$x]["href"].'" class="btn btn-default active">'.$elementos[$x]["nombre"].'</a>';
			}else{
				$html .= '<a href="'.$elementos[$x]["href"].'" class="btn btn-default">'.$elementos[$x]["nombre"].'</a>';
			}
		}
		 $html .='</div>
				</div>';
		echo $html;
	}
	function menuPerfilAdministrador($menuElejido){
		$elementos_menu[0] = array(
										"url" => "cerrar-sesion.php",
										"texto" => '<span class="glyphicon glyphicon-log-out" style="font-size: 30px;"></span>
										<br>Salir'
									);
		$elementos_menu[1] = array(
									"url" => "perfil-administrador/aprobar-productos.php",
									"texto" => '<span class="glyphicon glyphicon-tag" style="font-size: 30px;"></span>
										<br>Aprobar Productos'
								);
		$elementos_menu[2] = array(
									"url" => "perfil-administrador/gestion-usuarios.php",
									"texto" => '<span class="glyphicon glyphicon-user" style="font-size: 30px;"></span>
										<br>Gestión de Usuarios'
								);
		$elementos_menu[3] = array(
									"url" => "perfil-administrador/gestion-categorias.php",
									"texto" => '<span class="glyphicon glyphicon-list" style="font-size: 30px;"></span>
										<br>Gestión de Categoría Padre'
								);
		$elementos_menu[4] = array(
									"url" => "perfil-administrador/gestion-categoria-hijo.php",
									"texto" => '<span class="glyphicon glyphicon-list" style="font-size: 30px;"></span>
										<br>Gestión de Categoría Hijo'
								);
		$html = '<div id="barra_navegacion_inferior">
					<ul>';
		for($x=0;$x<count($elementos_menu);$x++){
			if($menuElejido==$x){
				$html .= '<li style="text-align: center;">
						<a href="'.$this->urlWeb.$elementos_menu[$x]["url"].'" class="elementoSeleccionadoInferior">
						  '.$elementos_menu[$x]["texto"].'
						</a>
					  </li>';
			}else{
				$html .= '<li style="text-align: center;">
						<a href="'.$this->urlWeb.$elementos_menu[$x]["url"].'">
						  '.$elementos_menu[$x]["texto"].'
						</a>
					  </li>';
			}
		}


		return $html .= '</ul>
			  </div>';
	}
}
?>