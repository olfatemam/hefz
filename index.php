<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,user-scalable=yes" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" type="text/css" href="css/w3.css" />
<link rel="stylesheet" type="text/css" href="css/left7.css" />
<link rel="stylesheet" type="text/css" href="css/audio7.css" />
<link rel="stylesheet" type="text/css" href="css/menu8.css" />
<link rel="stylesheet" type="text/css" href="css/style7.css" />
<link rel="stylesheet" type="text/css" href="css/nested_list.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
        
<script src="js/ihfaz7.js"></script>
<script src="js/verserect12.js"></script>
<script src="js/verse8.js"></script>
<script src="js/pages1.01.js"></script>
<script src="js/media8.js"></script>
<script src="js/process9.js"></script>

<title>Al Murattal</title>

</head>

<body>
<?php 
require_once 'Controllers/MainPageController.php';
?>

<div class="w3-row">
    <div class="w3-col w3-container w3-light-gray" style="width:30%;height:1000px">
        <?php include('views/leftsection.php') ?>
    </div>
    <div class="w3-col w3-container w3-light-grey" style="width:40%;height:1000px;min-width: 700px;">
        <?php include('views/quran.php') ?>
    </div>
    <div class="w3-col w3-container w3-light-gray" style="width:30%;height:1000px">
        <?php include('views/rightsection.php') ?>
    </div>
</div>


</body>

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