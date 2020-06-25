<!DOCTYPE html>

<head>
﻿<?php
function __autoload($class_name)
{
require_once 'classes/sura_info.php';
require_once 'classes/reciter_info.php';
}
?>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<title>احفط</title>


<script src="js/ihfaz.js"></script>
<script src="js/pages.js"></script>
<script src="js/media.js"></script>
<script src="js/process.js"></script>


<div style="margin:0px;float:left;width:auto;">
<label id="ehfaz_error" style="color:red;"></label>
<br/>
<br/>
<br/>
<br/>
<br/>

<table>
<tr >
    <td><label for="reciter">reciter:</label></td>
    <td>
        <?php
            $reciters_obj = new reciters();
            echo $reciters_obj->create_reciters_combo();
        ?>
    </td>
</tr>
<tr>
    <td><label for="soura">soura:</label></td>
    <td>
        <?php
            $souras_obj = new suras();
            echo $souras_obj->create_chapters_combo();
        ?>
    </td>
</tr>
<tr>
    <td><label for="from_list">from:</label></td>
    <td>
        <select id= "from_list" width ="300" dir="rtl" onchange="on_from_changed()"></select>
    </td>
</tr>
<tr>
    <td><label for="to_list">to:</label></td>
    <td>
        <select id="to_list" width="300" dir="rtl" onchange="on_to_changed()"></select>
    </td>
</tr>
<tr>
    <td><label for="repeat_all">repeat all:</label></td>
    <td><input type="number" id="repeat_all" dir="rtl" value="1" /></td>
</tr>
<tr>

<td><label for="repeat">repeat:</label></td>
    <td>
        <div>
            <input type="checkbox" id="r3" value="3" onclick="on_repeatition_click(this, r5, r7)"/>
            <label for="r3">3   </label>
            <input type="checkbox" id="r5" value="5" onclick="on_repeatition_click(this, r3, r7)"/>
            <label for="r5">5    </label>
            <input type="checkbox" id="r7" value="7" onclick="on_repeatition_click(this, r3, r5)"/>  
            <label for="r7">7    </label>
        </div>
    </td>
</tr>

<tr>
<td><label for="audio"></label></td>
<td>
    <audio id="audio" ></audio></td>
</tr>
</table>
<br>

<div class="table">
      <div class="cell">
          <button id="pButton" onclick="playAudio()" ></button>
      </div>
      <div class="cell">
        <button id="stopbutton" onclick="stopAudio()"></button>
      </div>    
      <div class="cell">
        <progress id="seekbar" value="0" max="1" ></progress>
      </div>    
      <div class="cell">
        <img id="img_volume" src="images/volume1.png" />
      </div>    
      <div class="cell">
        <input type="range" onchange="setVolume(this.value)" id="rngVolume" min="0" max="1" step="0.01" value="1">
      </div>    
 </div>
</div>

<div style="float:left;width:auto; margin:0px;">

    <div id accesskey="PagesDisplay" >
    <canvas id="pages_canvas" width="595.276" height="841.89" >
        <img id="qpage" src="data/pages/svg/001.svg" width="595.276" height="841.89">
    </canvas>
</div>
</div>

<script>load_default();

</script>

</body>

