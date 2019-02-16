<!doctype html>
<?php

$idCliente = intval($_GET['idCliente']);

?>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
<meta property="og:url"           content="http://neosystemspa.cl/turismochilote/app/mostrar_destino.php?idCliente=<?php echo $idCliente; ?>" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="Discover Chiloé" />
<meta property="og:description"   content="Un lugar donde puedes encontrar los diferentes destinos turisticos de la región tales como cabañas, ferias artesanales, islas, etc." />
</head>

<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.11&appId=1995340370738746&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
</body>
<div class="fb-like" data-href="http://neosystemspa.cl/turismochilote/app/mostrar_destino.php?idCliente=<?php echo $idCliente; ?>" data-layout="box_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
</html>
