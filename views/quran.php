<style>
.page-container {
  height: 100%;
  width: 900px;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: transparent;
}

.page_content {
  background-color: transparent;
  width: 750px;
}
    
</style>

<div class="page-container">
<div class="page_content" >
<div class="w3-center w3-transparent" id="nav_row" style="height:35px;width:630px;">
    <a id="next_link" onclick="next()" class="w3-margin-left w3-margin-right"><i class="fa fa-arrow-circle-left" style="font-size:24px"></i></a>
    <span id="page_num" class="w3-badge w3-margin-left w3-margin-right"></span>
    <a id="prev_link" onclick="prev()" class="w3-margin-left w3-margin-right"><i class="fa fa-arrow-circle-right" style="font-size:24px"></i></a>
</div>

<div class="" style=padding:0;margin:0">
<div id="margin_column" class="margin_column" style="width: 140px;padding:0;margin:0;"></div>
<div id="content_block" class="content-column" style="padding:0;margin:0;">
<div class="canvas_div" style="padding:0;margin:0;">
<canvas class="" id="pages_canvas" width="650" height="842" style="float:top; padding:0;margin:0;"
        onclick="click_verse(event)" ondblclick="dblclick_verse(event)" 
        onmouseover="hover_verse(event)" onmouseout="clear_verse(event)">

</canvas>
</div>
</div>        
</div>        
</div>        
</div>        
        
