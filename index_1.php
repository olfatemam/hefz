<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/style_1.04.css" />

<link rel="stylesheet" type="text/css" href="css/w3.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" type="text/css" href="css/controlpanel1.2.css" />
<link rel="stylesheet" type="text/css" href="css/audio1.1.css" />

        
<script src="js/ihfaz7.js"></script>
<script src="js/verserect12.js"></script>
<script src="js/verse8.js"></script>
<script src="js/pages1.05.js"></script>
<script src="js/media8.js"></script>

<title>Al Murattal</title>

</head>

<body>
<?php 
require_once 'Controllers/MainPageController.php';
?>

<div class="w3-container">
<div class="w3-row">
<div id="left_section" class="w3-card w3-light-grey w3-col l3 m12 s12" style="height: 890px !important;margin:0;padding:0">
    <?php include('views/leftsection.php') ?>
</div>
<div id="q_section"  class="w3-card  w3-light-gray w3-col l5 m12 s12" style="height: 890px !important;margin:0;padding:0">
    <?php include('views/quran.php') ?>
</div>
<div id="right_section" class="w3-card w3-light-gray w3-col l4 m12 s12" style="height: 890px !important;margin:0;padding:0">
    <?php include('views/rightsection.php') ?>
</div>
</div>
</div>
</body>

<script>
<?php
$settings=include('config/app.php');
echo 'var pages_root="'.$settings['img_root'].'";';
echo 'var page_ext="'.$settings['img_ext'].'";';
?>
    
g_Pages = new QPages(page_ext, pages_root);
g_QMedia = new QMedia();
g_QIhfazPage = new QIhfazPage();
audio_initialized = false;
</script>

<script src="js/process9.js"></script>
            
<script>
    function openTab(evt, tabName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("mytab");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" w3-red", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " w3-red";
}

    
    
    
</script>


<script>
    
function getCssProperty(elmId, property){
   var elem = document.getElementById(elmId);
   return window.getComputedStyle(elem,null).getPropertyValue(property);
}
function getWidth() {
  return Math.max(
    document.body.scrollWidth,
    document.documentElement.scrollWidth,
    document.body.offsetWidth,
    document.documentElement.offsetWidth,
    document.documentElement.clientWidth
  );
}

function getHeight() {
  return Math.max(
    document.body.scrollHeight,
    document.documentElement.scrollHeight,
    document.body.offsetHeight,
    document.documentElement.offsetHeight,
    document.documentElement.clientHeight
  );
}
function expand_sections()
    {
    let ids = ['left_section','right_section','q_section'];
    ids.forEach(function(item, index) 
    {
        (document.getElementById(item)).style.width="100%";
    });
        
    }   
    
function load_objects()
{
    g_QIhfazPage.initialize();
      
    g_Pages.get_pages_from_server(g_QIhfazPage.get_request_params());
    init_playAudio();

    //w = getWidth();
    
    if(w<=650)
    {
        expand_sections();
    }
//    var os = getOS();
//    if(os == 'Android' )
//    {
//        w = getWidth();
//        expand_sections();
//    }
//    else if(os == 'iOS')
//    {
//        w = getWidth();
//        expand_sections();
//    }
}

(function() {
    
    load_objects();
    
})();    
</script>    

</html>