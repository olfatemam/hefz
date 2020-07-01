<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,user-scalable=yes" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/style_1.03.css" />

<link rel="stylesheet" type="text/css" href="css/w3.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" type="text/css" href="css/controlpanel1.2.css" />
<link rel="stylesheet" type="text/css" href="css/audio1.1.css" />


<style>
.cell
{
    width:auto;
    background: #87CEEB;
    position: relative;
    height: 25px;
    vertical-align: middle;
    display:inline-block;
    margin:20px;
    margin-bottom: 20px;
    position: relative;
    top: 50%;
    transform: perspective(1px) translateY(-50%);
}

</style>    
        
<script src="js/ihfaz7.js"></script>
<script src="js/verserect12.js"></script>
<script src="js/verse8.js"></script>
<script src="js/pages1.03.js"></script>
<script src="js/media8.js"></script>


<title>Al Murattal</title>

</head>

<body>
<?php 

//$path = get_include_path();
//
//$settings=include ('config/app.php');
//
//$path.=';'.$settings['app_folder'];
//set_include_path($path);

require_once 'Controllers/MainPageController.php';
?>

<div class="w3-container">
<div class="w3-row">
    <div class="w3-col w3-card w3-border m12 l3 s12 w3-light-gray" style="height: 890px;">
        <?php include('views/leftsection.php') ?>
    </div>
    <div class="w3-col w3-card w3-border m12 l5 s12 w3-light-gray" style="height: 890px;">
        <?php include('views/quran.php') ?>
    </div>
    <div class="w3-col w3-card w3-border m12 l4 s12 w3-light-gray" style="height: 890px;">
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
    load_default();
    
    
    
</script>


<script>
    
function getCssProperty(elmId, property){
   var elem = document.getElementById(elmId);
   return window.getComputedStyle(elem,null).getPropertyValue(property);
}

(function() {
//    ////
//    var w = getCssProperty("nav_row", "width");
//    w=600;
//    var next = document.getElementById('next_link');
//    next.style.left = (w/2 - 60)+"px";
//    var prev = document.getElementById('prev_link');
//            
//    next.style.left=(w/2 - 30)+"px";
    //document.getElementById('page_num').textContent=current_page();
    

})();    
</script>    

</html>