function contraer_barra(){
  $('html, body').animate({scrollTop:0}, 'slow');
  $("#nav2>ul>li").removeAttr("style");
  $(".innerShadow").css({boxShadow: "0 0"});
  $("#bg-slider").animate({height:"26px"}).css({boxShadow: "-3px 2px 5px #4e4b4c"});
  $("#nav2").animate({top: "5px"}).css({"color": "#ffffff"}).addClass("nav3");
  $(".rslides, .nivo-controlNav").fadeOut();
}

function expander_barra(){  
  $(".rslides").responsiveSlides({
    auto: true,             // Boolean: Animate automatically, true or false
    speed: 3000,             // Integer: Speed of the transition, in milliseconds
    timeout: 5000,          // Integer: Time between slide transitions, in milliseconds
    pager: false,           // Boolean: Show pager, true or false
    nav: true,             // Boolean: Show navigation, true or false
    random: false,          // Boolean: Randomize the order of the slides, true or false
    pause: false,           // Boolean: Pause on hover, true or false
    pauseControls: false,    // Boolean: Pause when hovering controls, true or false
    prevText: "‹",   // String: Text for the "previous" button
    nextText: "›",       // String: Text for the "next" button
    maxwidth: "930",           // Integer: Max-width of the slideshow, in pixels
    navContainer: ".rslides",       // Selector: Where controls should be appended to, default is after the 'ul'
    manualControls: "",     // Selector: Declare custom pager navigation
    namespace: "banner",   // String: Change the default namespace used
    before: function(){
      // $(".cliente:not(.contenido1_on)").show();
    },   // Function: Before callback
    after: function(){
    }     // Function: After callback
  }, function(){
    $(".cliente:not(.contenido1_on)").hide();
  });
  $(".innerShadow").css({boxShadow: "-2px -1px 20px #4e4b4c"});
  // $("#bg-slider").animate({height:"416"});
  $("#bg-slider").css({boxShadow: "0 0"});
  $("#nav2").animate({top: "515px"}).css({"color": "#4e4b4c", "margin-top": "10px", "box-shadow": "0 0"}).addClass("nav3");
  $("#bg-slider").fadeIn();

}

$(document).ready(function() {
  // agrega el efecto fancybox a todas las imagenes
  $("a[href$='.jpg'],a[href$='.png'],a[href$='.gif']").attr('rel', 'gallery').fancybox();

  $("#idioma > ul > li").click(function() {
    /* Act on the event */
    $.ajax({
      url: 'ajax.php',
      type: 'POST',
      dataType: 'html', //default: Intelligent Guess (Other values: xml, json, script, or html)
      data: {accion: 'cookie', ling: $(this).attr("id")}
    })
    .done(function(code) {
      // console.log(code);
      console.log("success");
      window.location.reload();
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
  });  

  $("#contacto").fancybox({
    height: 510,
    maxHeight: 510,
    width: 450,
    maxWidth: 450,
    helpers : {
      overlay : {
          css : {
            'background' : 'rgba(78, 75, 76, 0.5)'
          }
      }
    }
  });

  $("[href$='.png']").fancybox();

  $("#cliente div figure a").fancybox({
    beforeClose : function(){
      // $.fancybox.open( [group])
      //parent.$.fancybox.close()
      console.log("src: "+$(this).attr("href"));
    }
  });  

  $("#clientes_servicio").responsiveSlides({
    auto: false,             // Boolean: Animate automatically, true or false
    speed: 500,            // Integer: Speed of the transition, in milliseconds
    timeout: 4000,          // Integer: Time between slide transitions, in milliseconds
    pager: false,           // Boolean: Show pager, true or false
    nav: true,             // Boolean: Show navigation, true or false
    random: false,          // Boolean: Randomize the order of the slides, true or false
    pause: false,           // Boolean: Pause on hover, true or false
    pauseControls: false,    // Boolean: Pause when hovering controls, true or false
    prevText: "‹",   // String: Text for the "previous" button
    nextText: "›",       // String: Text for the "next" button
    maxwidth: "930px",   // Integer: Max-width of the slideshow, in pixels
    namespace: "contenido",   // String: Change the default namespace used
    index: 1,
    after: function(){
      $("#contenido").animate({'opacity':'1'}, 'slow');
    }
  });

  $(".imgs_cliente").responsiveSlides({
    auto: true,
    speed: 2000,            // Integer: Speed of the transition, in milliseconds
    timeout: 3000,          // Integer: Time between slide transitions, in milliseconds
  });

  $(".imgs_empresa").responsiveSlides({
    auto: true,           // Integer: Speed of the transition, in milliseconds
    timeout: 3000,          // Integer: Time between slide transitions, in milliseconds
  });

 
  $(".next").click();
  $(".prev").click();

  $('#logos').carouFredSel({
    width: null,  // The width of the carousel. Can be null (width will be calculated), a number, "variable" (automatically resize the carousel when scrolling items with variable widths), "auto" (measure the widest item) or a percentage like "100%" (only applies on horizontal carousels)
    height: null, // The height of the carousel. Can be null (width will be calculated), a number, "variable" (automatically resize the carousel when scrolling items with variable heights), "auto" (measure the tallest item) or a percentage like "100%" (only applies on vertical carousels)
    scroll : 1
  });

  $("#contenido").delay('500').animate({'opacity':'1'}, 'slow');

  // mobile
  $(".ico-menu").on('click', function(){
    $('nav').slideToggle();

  });
});