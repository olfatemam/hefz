<div class="w3-bar w3-black w3-card w3-center" style="width: 100%;height:35px;">
    <button style="height: 35px;" class="tablink w3-red w3-col m4" onclick="openTab(event,'Recitation')">Recitation</button>
    <button style="height: 35px;" class="tablink w3-col m4" onclick="openTab(event,'GotoSoura')">Sura Index</button>
    <button style="height: 35px;" class="tablink w3-col m4" onclick="openTab(event,'GotoJuzz')">Juzz Index</button>
</div>
<div id="Recitation" class="w3-container w3-border mytab" >
<div class="w3-card w3-border w3-padding">
<div class='w3-panel w3-padding w3-margin'>
    <label id="ehfaz_error" style="color:red;"></label>
</div>
<br>

<table class="w3-table w3-table-all">
<tbody>
<tr>
<td><label for="input_page_number">Goto:</label></td>
<td>
<div class='w3-col l10 s810 m10'><input class="w3-input" id="input_page_number"  style="width:100%" type="number" min="1" max="604" >
</div>
<div class='w3-col l2 s2 m2'><button class="w3-button w3-blue" style="height:34px" id="goto_page_btn" onclick="goto_page()">Go</button></div>
</td></tr>

<tr><td><label for="reciter">Reciter:</label></td><td> <?php echo (new reciters())->create_list();?></td></tr>
<tr><td><label for="soura">Surah:</label></td><td> <?php echo (new Suras())->create_list();?></td></tr>
<tr><td><label for="from">From:</label></td><td> <select class="w3-select w3-border" id="from_list" onchange="on_from_changed()"></select></td></tr>
<tr><td><label for="from">To:</label></td><td> <select class="w3-select w3-border" id="to_list" onchange="on_to_changed()"></select></td></tr>
<tr><td><label for="repeat_all">Repeat All:</label></td><td><input class="w3-input w3-border" id="repeat_all" value="1" type="number"></td></tr>
<tr><td><label for="repeat_each">Repeat Verse:</label></td><td>
        <div  class="w3-col m2"><input type="checkbox" id="r3" value="3" onclick="on_repeatition_click(this, r5, r7)"><label class="_label" for="r3">3</label></div>
        <div class="w3-col m2"><input type="checkbox" id="r5" value="5" onclick="on_repeatition_click(this, r3, r7)"><label class="_label" for="r5">5</label></div>
        <div class="w3-col m2"><input type="checkbox" id="r7" value="7" onclick="on_repeatition_click(this, r3, r5)"><label class="_label" for="r7">7</label></div>
    </td>
</tr>
<tr><td colspan="2" class='w3-center w3-padding w3-margin'>
    </td></tr>
</tbody>
</table>
<div class='w3-panel w3-padding w3-margin w3-center w3-centered' style="margin-top: 20px;">

    <?php echo (new AudioControl())->generate();?>

</div>
</div>
</div>
<div id="GotoSoura" class="w3-container w3-border mytab" style="display:none">
      <?php echo (new Suras())->generate_ul_list(); ?>
</div>
<div id="GotoJuzz" class="w3-container w3-border w3-card-4 w3-right w3-right-align w3-right mytab" style="direction: rtl;width:100%;display:none;margin-left: 0;margin-right: 0">
        <?php echo (new Juzs())->generate_table(); ?>
</div>
