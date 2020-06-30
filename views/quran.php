<div class="w3-card w3-center" id="nav_row" style="height:35px;">
    <a id="next_link" onclick="next()" class="w3-margin-left w3-margin-right"><i class="fa fa-arrow-circle-left" style="font-size:24px"></i></a>
    <span id="page_num" class="w3-badge w3-margin-left w3-margin-right"></span>
    <a id="prev_link" onclick="prev()" class="w3-margin-left w3-margin-right"><i class="fa fa-arrow-circle-right" style="font-size:24px"></i></a>
</div>

<div class="w3-card w3-white">
<div id="margin_column" class="margin_column w3-transparent" style="width: 140px;padding:0;margin:0;"></div>
<div id="content_block" class="content-column " style="padding:0;margin:0;">
<div class="canvas_div" style="padding:0;margin:0;">
<canvas class="w3-white" id="pages_canvas" width="650" height="842" style="padding:0;margin:0;"
        onclick="click_verse(event)" ondblclick="dblclick_verse(event)" 
        onmouseover="hover_verse(event)" onmouseout="clear_verse(event)">

</canvas>
</div>
</div>        
</div>        
        
