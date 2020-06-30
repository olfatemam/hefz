<div class="w3-bar w3-black" style="width: 100%">
    <button class="tablink w3-red w3-col m4" onclick="openTab(event,'Recitation')">Recitations</button>
    <button class="tablink w3-col m4" onclick="openTab(event,'GotoSoura')">Soura Index</button>
    <button class="tablink w3-col m4" onclick="openTab(event,'GotoJuzz')">Juzz Index</button>
</div>
 <div id="Recitation" class="w3-container w3-border mytab">
<div class="w3-card w3-border">
<label id="ehfaz_error" style="color:red;"></label>
<br>
<table class="control_table1 w3-table">
<tbody>
<tr><td></td><td colspan="2"><label id='ehfaz_error' style='color:red'></label></td></tr>
<tr><td style='width:80%'><input class="w3-input w3-border" style="width:100%" id="input_page_number"  type="number" min="1" max="604" placeholder="Page Number"></td>
<td style='width:20%'><button class="w3-button w3-blue" id="goto_page_btn" onclick="goto_page()">Go</button></td></tr>
</tbody>
</table>
    
<table class="control_table1 w3-table">
<tbody>
<tr><td><label for="reciter">Reciter:</label></td><td> <?php echo (new reciters())->create_list();?></td></tr>
<tr><td><label for="soura">Surah:</label></td><td> <?php echo (new Suras())->create_list();?></td></tr>
<tr><td><label for="translation">Translation:</label></td><td> <?php echo (new Tafseers())->create_list();?></td></tr>
<tr><td><label for="from">From:</label></td><td> <select class="w3-select w3-border" id="from_list" onchange="on_from_changed()"></select></td></tr>
<tr><td><label for="from">To:</label></td><td> <select class="w3-select w3-border" id="to_list" onchange="on_to_changed()"></select></td></tr>
<tr><td><label for="repeat_all">Repeat All:</label></td><td><input class="w3-input w3-border" id="repeat_all" value="1" type="number"></td></tr>
<tr><td><label for="repeat_each">Repeat Verse:</label></td><td>
        <div  class="w3-col m2"><input type="checkbox" id="r3" value="3" onclick="on_repeatition_click(this, r5, r7)"><label class="_label" for="r3">3</label></div>
        <div class="w3-col m2"><input type="checkbox" id="r5" value="5" onclick="on_repeatition_click(this, r3, r7)"><label class="_label" for="r5">5</label></div>
        <div class="w3-col m2"><input type="checkbox" id="r7" value="7" onclick="on_repeatition_click(this, r3, r5)"><label class="_label" for="r7">7</label></div>
    </td>
</tr>
<tr><td colspan="2" class='w3-center w3-padding w3-margin'><?php echo (new AudioControl())->generate();?></td></tr>
</tbody>
 </table>       
</div>
</div>
<div id="GotoSoura" class="w3-container w3-border mytab" style="display:none">
      <?php echo (new Suras())->generate_ul_list(); ?>
</div>
<div id="GotoJuzz" class="w3-container w3-border w3-card-4 w3-right w3-right-align w3-right mytab" style="direction: rtl;width:100%;display:none;margin-left: 0;margin-right: 0">
        <?php echo (new Juzs())->generate_table(); ?>
</div>
