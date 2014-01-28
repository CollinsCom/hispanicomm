<?php 
# Para mostrar errores en pantalla:
ini_set('display_errors', 1);
# Para mostrar errores en el archivo de logs del servidor:
ini_set('log_errors', 1);

include_once('funciones.php');
$arch = explode(".", array_pop(explode("/", $_SERVER['PHP_SELF'])));
// echo $arch[0];

$hanson = new sitioWeb();
$hanson->Deploy($arch[0]);

?>