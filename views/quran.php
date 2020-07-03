<style>

 .content-column {

    width:650px;
    min-width:650px;

    height:850px;
    min-height:850px;
    background-color: transparent;
    
    color:#333;
    margin:0;
    padding:0;
    display:inline-table;
}
.mobile-content-column {

    width:650px;
    min-width:650px;

    height:850px;
    min-height:850px;

    background-color: transparent;

    
    color:#333;
    margin:auto auto;
    padding:0;
    display:inline-table;
}
.container {
    margin-left:auto;
    margin-right:auto;
    margin:0 auto;
    padding:0;
    display:inline-table;
    background:#E3FCFF url('../images/borders/border_4.png')center no-repeat; background-size: 100% 100%;
}


canvas {
    position: relative;
    float:left;
    vertical-align: top;
    margin:0;
    padding:0;
}
   
@media only screen and (max-width: 600px) 
{

.content-column {

    width:100%;
    min-width:100%;

    height:850px;
    min-height:850px;
    background-color: transparent;
    
    color:#333;
    margin:0;
    padding:0;
    display:inline-table;
}
.mobile-content-column {

    width:100%;
    min-width:100%;

    height:850px;
    min-height:850px;

    background-color: transparent;

    
    color:#333;
    margin:auto auto;
    padding:0;
    display:inline-table;
}
.container {
    margin-left:auto;
    margin-right:auto;
    margin:0 auto;
    padding:0;
    display:inline-table;
    background:#E3FCFF url('../images/borders/border_4.png')center no-repeat; background-size: 100% 100%;
}


canvas {
    position: relative;
    float:left;
    vertical-align: top;
    padding:0;
    margin:0;
}
    
}

</style>
<div class='w3-row' id='main_q_container'>
<div class='w3-center'>

<div class="w3-center w3-transparent" id="nav_row" style="height:35px;width:100%;">
    <a id="next_link" onclick="next()" class="w3-margin-left w3-margin-right"><i class="fa fa-arrow-circle-left" style="font-size:24px"></i></a>
    <span id="page_num" class="w3-badge w3-margin-left w3-margin-right"></span>
    <a id="prev_link" onclick="prev()" class="w3-margin-left w3-margin-right"><i class="fa fa-arrow-circle-right" style="font-size:24px"></i></a>
</div>

<div id="content_block w3-center" class="content-column1">
<div class="canvas_div" style="padding:0;margin:0;">
<canvas class="" id="pages_canvas" width="650" height="842" style="float:top; padding:0;margin:0;"
        onclick="click_verse(event)" ondblclick="dblclick_verse(event)" 
        onmouseover="hover_verse(event)" onmouseout="clear_verse(event)">

</canvas>
</div>
</div>        
</div>        
</div>        
        
