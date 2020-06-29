<!DOCTYPE html>
<?php

/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */

require_once 'Controllers/MainPageController.php';
ini_set("display_errors",true);
$main_page = new MainPageController();
echo (new Header())->generate_page_header();

?>
<!DOCTYPE html>
<html>
<title>
    <?php $main_page->title;?>
</title>
    
<meta name="viewport" content="width=device-width, initial-scale=1">
<body>

<!-- Sidebar -->

<div class="w3-sidebar w3-light-grey w3-bar-block" style="width:25%">
  
  <div class="w3-bar w3-black" style="width: 100%">
    <button class="tablink w3-red w3-col m4" onclick="openTab(event,'Recitation')">Recitations</button>
    <button class="tablink w3-col m4" onclick="openTab(event,'GotoSoura')">Soura Index</button>
    <button class="tablink w3-col m4" onclick="openTab(event,'GotoJuzz')">Juzz Index</button>
  </div>
  
  <div id="Recitation" class="w3-container w3-border mytab">
    <?php echo (new ControlBlock())->generate_body(); ?>
  </div>
  <div id="GotoSoura" class="w3-container w3-border mytab" style="display:none">
      <?php
        $x = new Suras();
        echo $x->create_ul();
        ?>
  </div>
  <div id="GotoJuzz" class="w3-container w3-border w3-card-4 w3-right w3-right-align w3-right mytab" style="direction: rtl;width:100%;display:none;margin-left: 0;margin-right: 0">
        <?php
            $x = new Juzs();
            echo $x->generate_table();
        ?>
  </div>
</div>
<!-- Page Content -->
<div style="margin-left:25%">

<div class="w3-container w3-teal">
    <h1>
    <?php echo $main_page->title;?>
    </h1>

</div>
    

<div class="w3-container">
<?php 
    echo (new QPage())->generate();
    ?>
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
</html>