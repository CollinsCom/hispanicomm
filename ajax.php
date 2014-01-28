<?php 

include_once('conexion.php');

switch ($_REQUEST['accion']) {   

  case 'cookie':
    # code...
      $link = Conexion::conectar();
      $query ="SELECT post FROM idiomas WHERE ID_idioma = ".$_POST['ling'].";";
      $idiomas = mysql_query($query,$link);
      while($idioma = mysql_fetch_array($idiomas)){
        setcookie("idioma", $idioma['post'], time()+60*60*24*365, "/");       
        echo "post: ".$idioma['post']; //borrar
      }
      echo "id: "+$_POST['ling']; //borrar
      echo "fin"; //borrar
    break;
  
  case 'prueba':
    # code...     
    ?>
    <div>
      <p>Hola!</p>    
    </div>
    <?php        
    break;
  
  default:
    # code...
    ?>
    <span>ERROR: la accion no coincide con ninguna opción. Accion: <?php echo $_REQUEST['accion'];?></span>
    <?php 
    break;
}

?>