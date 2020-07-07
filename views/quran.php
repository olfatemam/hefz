
<div id="canvas_parent" class='w3-center '>

<div class="w3-centered w3-transparent" id="nav_row" style="height:35px;width:100%;">
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
        
