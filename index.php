<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" type="text/css" href="css/style_1.09.css" />

<link rel="stylesheet" type="text/css" href="css/audio1.1.css" />

<link rel="stylesheet" type="text/css" href="css/w3.css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script src="js/ihfaz7.js"></script>
<script src="js/verserect12.js"></script>
<script src="js/verse8.js"></script>
<script src="js/pages1.08.js"></script>
<script src="js/media8.js"></script>

<style>
body {
  font-family: "Lato", sans-serif;
}

.sidebar {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidebar a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.sidebar a:hover {
  color: #f1f1f1;
}

.sidebar .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

.openbtn {
  font-size: 20px;
  cursor: pointer;
  background-color: #111;
  color: white;
  padding: 10px 15px;
  border: none;
}

.openbtn:hover {
  background-color: #444;
}

#main {
  transition: margin-left .5s;
  padding: 16px;
}

/* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
@media screen and (max-height: 450px) {
  .sidebar {padding-top: 15px;}
  .sidebar a {font-size: 18px;}
}
</style>
<script>
function toggleNav()
{
  width = document.getElementById("controlBar").style.width;
  if(!width)width="0";
  if(parseInt(width)==0)
  {
      openNav();
  }
  else
  {
      closeNav();
  }
}
function openNav()
{
    document.getElementById("controlBar").style.width = "350px";
    document.getElementById("main").style.marginLeft = "350px";
}

function closeNav() {
  document.getElementById("controlBar").style.width = "0px";
  document.getElementById("main").style.marginLeft= "0px";
}
</script>


<title>Al Murattal</title>

</head >

<body class="">
<?php 
require_once 'Controllers/MainPageController.php';
?>

      
<div id="controlBar" class="sidebar">
<?php include('views/sidebar.php') ?>
</div>
<div id="main">
    

<div id="canvas_parent" class='w3-center '>

<div class="w3-centered w3-transparent" id="nav_row" style="height:35px;width:650px;">
    <button class="openbtn pull-left" onclick="toggleNav()">☰</button>
    <a id="next_link" onclick="next()" class="w3-margin-left w3-margin-right"><i class="fa fa-arrow-circle-left" style="font-size:24px"></i></a>
    <span id="page_num" class="w3-badge w3-margin-left w3-margin-right"></span>
    <a id="prev_link" onclick="prev()" class="w3-margin-left w3-margin-right"><i class="fa fa-arrow-circle-right" style="font-size:24px"></i></a>
</div>

<div  class="w3-centered" style="width:100%;padding:0;margin:0;">
<canvas class="" id="pages_canvas" width="650" height="842" style="float:top; padding:0;margin:0;object-fit:contain;"
        onclick="click_verse(event)" ondblclick="dblclick_verse(event)" 
        onmouseover="hover_verse(event)" onmouseout="clear_verse(event)">

</canvas>
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
    
function load_objects()
{
    g_QIhfazPage.initialize();
      
    g_Pages.get_pages_from_server(g_QIhfazPage.get_request_params());
    init_playAudio();
}

(function() {
    
    load_objects();
})();    
</script>    

</html>