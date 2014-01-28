<?php 
  //***************************************************
  //  Archivo de funciones para HispaniComm
  //***************************************************
  // # Para mostrar errores en pantalla:
  // ini_set('display_errors', 1);

  // # Para mostrar errores en el archivo de logs del servidor: 
  // ini_set('log_errors', 1);

  include_once('conexion.php');

  class sitioWeb{
    // var $bd;
    // $bd = new Conexion();
    var $link = '';
    var $todos_textos = array();
    var $speech = "en";

    function get_head(){
      $expire=time()+60*60*24*365;
      // $expire=time()-3600;
      if (!isset($_COOKIE["idioma"])){
        setcookie("idioma", "en", $expire, "/");
      }else{
        $this->speech = $_COOKIE["idioma"];     
      }
      $this->link = Conexion::conectar();
      $quey_textos = "SELECT titulo, ".$this->speech." FROM textos;";
      $textos = mysql_query($quey_textos, $this->link);
      while ($texto = mysql_fetch_array($textos)) {
        # code...
        $this->todos_textos[$texto['titulo']] = $texto[$this->speech];
      }
      // echo "<pre>";
      // var_dump($this->todos_textos);
      // echo "</pre>";
      // echo var_dump($this->todos_textos);
?>
    <!doctype html>
    <html dir="ltr" lang="<?=$this->speech?>">
      <head>
        <meta charset="utf-8">
        <title>HispaniComm</title>
        
        <!-- archivos css -->
        <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />

        <!-- <link rel="stylesheet" href="css/default/default.css" type="text/css" /> -->

        <link rel="shortcut icon" href="images/favicon.ico">
      </head>
      <body>
        
        <header>
          <div class="innerShadow">
            <div>
              <a class="logo" href="index.php" width="310" height="85">
                <img  src="img/logo.png" alt="HispaniComm" width="310" height="80">
              </a>
              <i class="icon-menu"></i>
              <nav height="80">
                <ul>
                  <li><a href="empresa.php"><?=$this->todos_textos['nav1']?></a></li>
                  <li id="portafolio" class="icon-arrow-right"><?=$this->todos_textos['nav2']?>
                    <ul>
                      <?php 
                      if(!$this->link){
                        $this->link = Conexion::conectar();
                      }
                      $query = "SELECT ID_cliente, nombre FROM clientes where menu = 1 ORDER BY importancia ASC;";
                      $portafolio = mysql_query($query,$this->link);
                      while($cliente = mysql_fetch_array($portafolio)){                      
                      ?>                      
                        <li>
                          <a href="cliente.php?p=1&c=<?= $cliente['ID_cliente'];?>" rel="portafolio">
                            <?= $cliente['nombre']; ?>
                          </a>
                        </li>
                      <?php                      
                      }
                      ?>
                    </ul>    
                  </li>
                  <li><a href="contacto.php" id="contacto" data-fancybox-type="iframe"><?=$this->todos_textos['nav3']?></a></li>
                  <li style="width:0px;height: 15px;border-left: 1px dotted;"></li>
                  <li id="idioma" class="icon-arrow-right icon-globe"><?=$this->speech?><i class="icon-globe"></i>
                    <ul>
                      <?php 
                      if(!$this->link){
                        $this->link = Conexion::conectar();
                      }
                      $query = "SELECT ID_idioma, idioma FROM idiomas where post != '".$this->speech."';";
                      $idiomas = mysql_query($query,$this->link);
                      while($idioma = mysql_fetch_array($idiomas)){                      
                      ?>
                        <li id="<?= $idioma['ID_idioma']; ?>"><?= $idioma['idioma']; ?></li>
                      <?php
                      }
                      ?>
                    </ul>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
          <div id="bg-slider" >
            <ul class="rslides">
              <li><img src="img/banner_<?= $this->speech; ?>.jpg" alt="Collinscom" title="La Creatividad Mueve Montañas" width="930px" height="416px"/></li>
              <li><img src="img/banner-01.jpg" alt="Latest Tendencies" title="" width="930px" height="416px"/></li>
              <li><img src="img/banner-02.jpg" alt="Kodak, Tequila Cazador, Frigidaire" title="" width="930px" height="416px"/></li>
              <li><img src="img/banner-04.jpg" alt="Cryo-cell Cryanza" title=""/></li>
              <li><img src="img/banner-05.jpg" alt="Latest Tendencies, Gran Vía, Don Paco" title="" width="930px" height="416px"/></li>
            </ul>
          </div>
          <nav id="nav2">
            <ul>
              <?php 
              if(!$this->link){
                $this->link = Conexion::conectar();
              }
              $f=0;
              $query = "SELECT * FROM servicios ORDER BY ID_servicio ASC;";
              $servicios = mysql_query($query,$this->link);
              while($servicio = mysql_fetch_array($servicios)){
                if($f==1){ 
                  ?>
                    <li class="slash"></li>                       
                  <?php 
                }else{
                  $f=1;
                }
                
                ?>
                <li 
                <?php

                if(isset($_REQUEST['s']) && $servicio['ID_servicio']==$_REQUEST['s'])
                {
                  ?>
                    style="color:#4e4b4c"
                  <?php
                }

                ?>
                >
                  <a href="servicio.php?s=<?= $servicio['ID_servicio']; ?>"><?=$servicio['n_servicio_'.$this->speech];?></a>
                </li>
                <?php 
              }
              ?>
            </ul>
          </nav>
        </header>

        <div id="wrap" class="theme-default">
          <section id="contenido">
          <?php
  }//fin get_head

  function index(){
    $link = Conexion::conectar();
    $query ="SELECT ID_cliente, nombre, imagen, n_giro_".$this->speech." as giro FROM clientes left outer join giros ON clientes.giro = giros.ID_giro where servicios like '%1%' AND mostrar = 1 ORDER BY importancia ASC limit 8;";
    $clientes = mysql_query($query,$link);
    while($cliente = mysql_fetch_array($clientes)){
      ?>
      <article class="icon-search" idClient="<?= $cliente['ID_cliente'];?>" >
        <a href="cliente.php?s=1&c=<?= $cliente['ID_cliente'];?>">
          <figure>
            <img src="img/servicios/web sites/<?= $cliente['imagen'];?>.jpg" alt="<?= $service['n_servicio_'.$this->speech].' '.$cliente['nombre'];?>" title="<?= $cliente['nombre'];?>" onerror="this.src='img/clientes/no_disponible/235_<?=$this->speech?>.jpg';" width="220px" height="170px" />
          </figure>
          <span class="empresa"><?= $cliente['nombre'];?></span>
          <span class="giro"><?=$cliente['giro'];?></spn>
        </a>
      </article>
      <?php
    } 
  }

  function empresa(){
    ?>
      <div id="empresa" id="contenido2_s0" style="display: block; float: left; position: relative; z-index: 2; -webkit-transition: opacity 500ms ease-in-out; transition: opacity 500ms ease-in-out;">
        <div class="imgs_empresa">
          <?php
              $carpeta = "img/empresa";
              $dirint2 = dir($carpeta);
              $imagen = $dirint2->read();
              while(($imagen = $dirint2->read())!== false){
                if(preg_match("/.jpg/",$imagen)){
                  ?>
                    <img src="<?=$carpeta."/".$imagen?>" alt="" onerror="this.src='img/clientes/no_disponible/235_<?=$this->speech?>.jpg';" width="420px" height="465px" />
                  <?php 
                }
              }
            ?>
        </div>
        <div>
          <h2>HispaniComm</h2>
          <div class="line"></div>
          <p>
            <?=$this->todos_textos['empresa1']?>
          </p>
        </div>
      </div>

    <?php 
  }
  
  function contactanos(){
    error_reporting(0);
    $identificador = $_GET['identi'];

    $theName    = $_POST['theName'];
    $theCity    = $_POST['theCity'];
    $thePhone   = $_POST['thePhone'];
    $theMail    = $_POST['theMail'];
    $theComment = $_POST['theComment'];

    $mails=array(
      "contact@collinscom.com",
      "r.saavedra@collinscom.com",
      "isc.jorgerojas@gmail.com"
      );
    $this->speech = $_REQUEST["idioma"];
    $this->link = Conexion::conectar();
    $quey_textos = "SELECT titulo, ".$this->speech." FROM textos where titulo like 'contact_%';";
    $textos = mysql_query($quey_textos, $this->link);
    while ($texto = mysql_fetch_array($textos)) {
      # code...
      $this->todos_textos[$texto['titulo']] = $texto[$this->speech];
    }

    ?> 
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js"></script>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
    <style>
      body{text-align: center;color: #4e4b4c;font-family:HelveticaNeueLTStd;}
      input, textarea, div{}
      h2{font-size: 20px;text-transform: uppercase;padding: 0px;font-weight: normal;}
      p{padding: 0px;font-size: 16px;}
      p b{font-size: 16px;}
      form>div{padding: 5px; float: left; width: 200px; font-size: 16px;}
      label.error{font-family:HelveticaNeueLTStd;display: inline-block;color: #bababa;}
      label.error:before{font-family:HelveticaNeueLTStd; content: "*";color: #f47932;}
    </style>
    <body>
      <div id="mainFrame">
        <div id="mlCell">
          <h2 id="titles" style="margin: 0px;"><?=$this->todos_textos['contact_title'];?></h2>
          <p id="txtBody"><?=$this->todos_textos['contact_body'];?></p>
          <div id="main" style="width: 450px;height: 300px;margin: 0px auto;">
            <form action="contacto.php" method="post" name="fContacto" id="fContacto">        
              <div>
                <?=$this->todos_textos['contact_name'];?><span style="color:#f47932;">*</span>:<br><input name="theName" type="name" id="theName" size="15" maxlength="50"><br><br> 
                <?=$this->todos_textos['contact_phone'];?>:<br><input name="thePhone" type="tel" id="thePhone" size="15" maxlength="12"><br> <br> 
              </div>
              <div>
                <?=$this->todos_textos['contact_city'];?><span style="color:#f47932;">*</span>:<br>
                <input name="theCity" type="city" size="15" id="theCity" maxlength="25"><br><br>
                <?=$this->todos_textos['contact_mail'];?><span style="color:#f47932;">*</span>:<br>
                <input name="theMail" type="email" id="theMail" size="15" maxlength="50"><br><br> 
              </div>
              <div style="width: 400px;">
                <?=$this->todos_textos['contact_message'];?><span style="color:#f47932;">*</span>:<br>
                <textarea name="theComment" id="theComment" cols="40" rows="5"></textarea><br><br>
                <input style="font-size: 15px;margin:0px 5px;" name="sendMail" type="submit" id="sendMail" value="Enviar">
                <input style="font-size: 15px;margin:0px 5px;" name="Reset" type="reset" value="Cancelar">
                <p style="margin-bottom: 0px;"><span style="color:#f47932;">*</span><?=$this->todos_textos['contact_required_legend'];?></p>
              </div>
            </form>
          </div>          
        </div>
      </div>      
      <script type="text/javascript">
      $(function() {
        $('#sendMail').click(function(){
          $('#fContacto').validate({
            rules:{
              theName:{required:true},
              theCity:{required:true},
              thePhone:{number: true,rangelength: [7, 10]},
              theMail:{required: true,email: true},
              theComment:{required: true}
            },
            messages:{
              theName:{required:<?='"'.$this->todos_textos['contact_required_name'].'"';?>},
              theCity:{required:<?='"'.$this->todos_textos['contact_required_city'].'"';?>},
              thePhone:{number: <?='"'.$this->todos_textos['contact_requiredphone1'].'"';?>,rangelength: <?='"'.$this->todos_textos['contact_required_phone2'].'"';?>},
              theMail:{required: <?='"'.$this->todos_textos['contact_required_mail1'].'"';?>,email: <?='"'.$this->todos_textos['contact_required_mail2'].'"';?>},
              theComment:{required: <?='"'.$this->todos_textos['contact_required_comment'].'"';?>}
            }
          });
        });
        <?php 
          if ( $_POST['sendMail'] == 'Enviar' ){
            if(!$this->link){
              $this->link = Conexion::conectar();        
            }
            $query = "INSERT INTO contactos VALUES ( null , '$theName', '$theCity', '$thePhone', '$theMail', '$theComment', null);";
            $qrs = mysql_query($query,$this->link);
            // Conexion::desconectar();
            // echo "<script>";
            for ($i=0; $i < count($mails); $i++) {
              // $destino = $mails[$i];
              mail ("$mails[$i]", "Contacto HispaniComm", "Nombre: $theName\n\nCiudad: $theCity\n\nTeléfono: $thePhone\n\neMail: $theMail\n\nComentarios: $theComment", "From: $theMail");
              echo "console.log('se envio a: $mails[$i]');";
            }
            ?>
            $('#mlCell div').html("<p><?=$this->todos_textos['contact_thanks'];?>");
            $("#mlCell div p").css({'font-size': '32px', "margin-top": "20%"});
            setTimeout(function(){parent.$.fancybox.close()},2000);

            <?php
            // echo "</script>";
          }else{
            echo "console.log('El correo se enviara a:');";
            for ($i=0; $i < count($mails); $i++) { 
              echo " console.log('  ".$mails[$i]."');";
            }
            echo "console.log('codigo version 1.4')";
            // echo "</script>";
          }
        ?>
      });
      </script>
    </body>
    <?php
  }

  function servicio(){
    $prefix = mysql_fetch_array(mysql_query("SELECT prefix FROM servicios where ID_servicio = ".$_REQUEST['s'], Conexion::conectar()));
    $link = Conexion::conectar();
    $service = mysql_fetch_array(mysql_query("SELECT n_servicio_es, n_servicio_en from servicios where ID_servicio = ".$_REQUEST['s'],$link));
    $query ="SELECT ID_cliente, nombre, imagen, n_giro_".$this->speech." as giro FROM clientes left outer join giros ON clientes.giro = giros.ID_giro where servicios like '%".$_REQUEST['s']."%' AND mostrar = 1 ORDER BY importancia ASC;";
    $clientes = mysql_query($query,$link);
    while($cliente = mysql_fetch_array($clientes)){
      ?>
      <article class="icon-search" idClient="<?= $cliente['ID_cliente'];?>" >
        <a href="cliente.php?s=<?= $_REQUEST['s'];?>&c=<?= $cliente['ID_cliente'];?>">
          <figure>
            <img src="img/servicios/<?= $service[1].'/'.$cliente['imagen'];?>.jpg" alt="<?= $service['n_servicio_'.$this->speech].' '.$cliente['nombre'];?>" title="<?= $cliente['nombre'];?>" onerror="this.src='img/clientes/no_disponible/235_<?=$this->speech?>.jpg';" width="220px" height="170px" />
          </figure>
          <span class="empresa"><?= $cliente['nombre'];?></span>
          <span class="giro"><?=$cliente['giro'];?></span>
        </a>
      </article>
      <?php
    }
    Conexion::desconectar();
  }

  function cliente(){
    ?>
    <div id="clientes_servicio">
      <?php
      $link = Conexion::conectar();

      $query ="SELECT ID_cliente, nombre, url, description_".$this->speech.", imagen, n_giro_".$this->speech." as giro FROM clientes left outer join giros ON clientes.giro = giros.ID_giro where ID_cliente = '".$_REQUEST['c']."' AND mostrar = 1 ORDER BY importancia ASC;";
      $p_cliente = mysql_query($query,$link);
      $p_cliente = mysql_fetch_array($p_cliente);
      ?>
      <div class="cliente">
        <div class="imgs_cliente">
          <?php
            $carpeta = "img/clientes/".$p_cliente['imagen'];
            $dirint2 = dir($carpeta);
            $imagen = $dirint2->read();
            $cont = 1;
            while(($imagen = $dirint2->read())!== false){
              if(preg_match("/.jpg/",$imagen)) {
                ?>
                  <img src="<?=$carpeta."/".$imagen?>" alt="screenshot <?=$p_cliente['nombre'];?>" onerror="this.src='img/clientes/no_disponible/235_<?=$this->speech?>.jpg';" width="423px" height="393px" />
                <?php
              $cont++;
              }
            }
          ?>            
        </div>
        <div>
          <h2><?=$p_cliente['nombre'];?></h2>
          <a href="http://<?=$p_cliente['url'];?>" target="cliente"><span><?=$p_cliente['url'];?></span></a>
          <div class="line"></div>
          <p><?=$p_cliente['description_'.$this->speech];?></p>
        </div>
      </div>
      <?php
      if(isset($_REQUEST['p'])){
        $query ="SELECT ID_cliente, nombre, url, description_".$this->speech.", imagen, n_giro_".$this->speech." as giro FROM clientes left outer join giros ON clientes.giro = giros.ID_giro where menu like '1' AND ID_cliente != '".$_REQUEST['c']."' AND mostrar = 1 ORDER BY importancia ASC;";        
      }else{
        $query ="SELECT ID_cliente, nombre, url, description_".$this->speech.", imagen, n_giro_".$this->speech." as giro FROM clientes left outer join giros ON clientes.giro = giros.ID_giro where servicios like '%".$_REQUEST['s']."%' AND ID_cliente != '".$_REQUEST['c']."' AND mostrar = 1 ORDER BY importancia ASC;";
      }
      $clientes= mysql_query($query,$link);      
      while($cliente = mysql_fetch_array($clientes)){      
      ?>
        <div class="cliente">
          <div class="imgs_cliente">
            <?php
              $carpeta = "img/clientes/".$cliente['imagen'];
              $dirint2 = dir($carpeta);
              $imagen = $dirint2->read();
              $cont = 2;
              while(($imagen = $dirint2->read())!== false){
                if(preg_match("/.jpg/",$imagen)){
                  ?>
                    <img src="<?=$carpeta."/".$imagen?>" alt="<?= $cliente['nombre']." screenshot ".$cont;?>" onerror="this.src='img/clientes/no_disponible/235_<?=$this->speech?>.jpg';" width="423px" height="393px" />
                  <?php 
                  $cont++;
                }
              }
            ?>
          </div>
          <div>
            <h2><?=$cliente['nombre'];?></h2>
            <a href="http://<?=$cliente['url'];?>" target="cliente"><span><?=$cliente['url'];?></span></a>
            <div class="line"></div>
            <p><?=$cliente['description_'.$this->speech];?></p>
          </div>
        </div>
      <?php 
      }
      ?>
    </div>
    <?php
  }

  function get_footer(){
    ?>        <div class="clear"></div>
            </div><!-- fin del #contenido -->
          </div><!-- fin del #wrap -->
        <footer>
          <!-- <div class="separador2px color_sponsors" ></div> -->
          <div id="shares">
            <div>
              <!-- compartir facebook twitter g +1 -->
            </div>
          </div>
          <div id="sponsors">
            <div class="titulo">
              <?php $p = explode(" ", $this->todos_textos['sponsors']); ?>
              <span><?=$p[0];?> <strong><?=$p[1];?>: </strong></span>
            </div>
            <div class="list_carousel">
              <ul id="logos">
                <?php
                  $carpeta = "img/clientes_logos";
                  $dirint2 = dir($carpeta);
                  $logo = $dirint2->read();
                  while(($logo = $dirint2->read())!== false){
                    if(preg_match("/.png/",$logo)){
                      ?>
                        <li><img src="<?=$carpeta."/".$logo?>" alt="<?=$logo;?>" onerror="this.src='img/clientes_logos/no_image_<?=$this->speech?>.png';" height="70px" /></li>
                      <?php 
                    }
                  }
                ?>
              </ul>
            </div>
          </div>
          <div class="separador7px"></div>
          <div id="contactos">
            <div>
              <article>
                <h2><?=$this->todos_textos['contactos1'];?> <strong>HispaniComm</strong></h2>                
                <p><?=$this->todos_textos['descripcion'];?></p>
              </article>
              <article>
                <h2><?=$this->todos_textos['contactos2'];?></h2>
                <span class="lugar">4775 W Panther Creek Dr. #440-136 The Woodlands, TX. 77381 USA</span>
                <span class="telefono">646 684 28 87</span>
                <span class="mail"><a href="mailto:r.saavedra@collinscom.com" target="_blank"><?=$this->todos_textos['contactos4'];?></a></span>
                <!-- r.saavedra@collinscom.com -->
              </article>
              <article>
                <h2><?=$this->todos_textos['contactos3'];?></h2> 
                <a href="http://www.fb.com/collinscom" target="fb" class="facebook" rel="me"></a> 
                <a href="http://www.twitter.com/collinscom" target="tw" class="twitter" rel="me"></a>
                <a href="https://plus.google.com/115670544541098932922" target="g+" class="gplus" rel="me"></a>
              </article>
              <article class="byCollins">                
                <figure>
                  <span><?=$this->todos_textos['contactos5'];?> </span>
                  <a href="http://www.collinscom.com" target="collins" rel="me" >
                    <img src="img/byCollins.png" alt="CollinsCom" title="collinscom" width="130px" height="30px" />
                  </a>
                  <a href="https://plus.google.com/116190357565235955774/about?hl=es-419" rel="author"></a>
                </figure>
              </article>
            </div>
          </div>
          <div class="separador2px"></div>
          <div id="legales">
            <div>
              <span>© <?=$this->todos_textos['legales1'];?> 2013 HispaniComm</span>
              <ul>
                <li> <?=$this->todos_textos['legales2'];?>  </li>|
                <li>  <?=$this->todos_textos['legales3'];?>  </li>|
                <li>  FAQs </li>
              </ul>
            </div>
          </div>
        </footer>     
        <!-- <div id="fancybox-loading">
          <div></div>
        </div> -->
        <!-- archivos javascript -->
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/jquery-1.9.1.min.js"><\/script>')</script>
        <script type="text/javascript" src="js/jquery.carouFredSel-6.2.1.js"></script>
        <script type="text/javascript" src="js/jquery.fancybox.pack.js"></script>
        <script type="text/javascript" src="js/responsiveslides.js"></script>
        <script type="text/javascript" src="js/libs.js"></script>
        <script>
          $(document).ready(function() { 
            
          });
        </script>
      </body>
    </html>
          <?php
    // if($this->link){
    //   Conexion::desconectar();
    // }
  }//fin get_footer



  public function Deploy($page){
    switch ($page) {

      case 'index':
        $this->get_head();
        $this->index();
        $this->get_footer();
        ?>
        <script>
          expander_barra();
        </script>
        <?php
        break;

      case 'coleccion':
        $this->coleccion();
        break;
      
      case 'contacto':
        $this->contactanos();
        break;

      case 'empresa':
        $this->get_head();
        $this->empresa();
        $this->get_footer();
        ?>        
        <script>
          $(".imgs_cliente").responsiveSlides();
        </script>
        <?php
        break;

      case 'servicio':
        $this->get_head();
        $this->servicio();
        $this->get_footer();
        break;


      case 'cliente':
        $this->get_head();
        $this->cliente();
        $this->get_footer();
        break;

      case '404':
        $this->get_head();
        $this->get_footer();
        break;
    
    }    
  }
} //fin de la clase SitioWeb

