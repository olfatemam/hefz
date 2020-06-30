/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */


function QVerse(chapterNo,verseNo,cx, cy, r, is_first_in_page, left, top, right, trans)
{
    this.trans=trans;
    this.chapterNo=Number(chapterNo);
    this.verseNo=verseNo;
    this.r=Number(r);
    this.x=Number(cx)+this.r;
    this.y=Number(cy);
    this.left=left;
    this.page_top=top;
    this.right=right;
    
    this.px=0;
    this.py=0;
    
    this.highlight_color="#385571";//"#50555C";//#85BC3D";

    this.is_first_in_page=is_first_in_page;
    this.adjust_margin();
    
    this.rects=new Array();
    
}

 
function getStyleRuleValue(style, selector, sheet)
{
    var sheets = typeof sheet !== 'undefined' ? [sheet] : document.styleSheets;
    for (var i = 0, l = sheets.length; i < l; i++) {
        var sheet = sheets[i];
        if( !sheet.cssRules ) { continue; }
        for (var j = 0, k = sheet.cssRules.length; j < k; j++) {
            var rule = sheet.cssRules[j];
            if (rule.selectorText && rule.selectorText.split(',').indexOf(selector) !== -1) {
                return rule.style[style];
            }
        }
    }
    return null;
};

QVerse.prototype.point_within_verse_area=function (x,y)
{
    for(var i=0;i<this.rects.length;i++)
    {
        if( this.rects[i].point_is_inside(x,y) )
            return true;
    }
    return false;
};

QVerse.prototype.set_begin_position=function(page, cx,cy)
{
    this.px=cx;
    this.py=cy;

    if(this.verseNo==1 )
    {
        this.set_first_verse_inital_position(page);
    }
}

QVerse.prototype.highlight=function(ctx, page, style)
{
    this.select_verse(ctx, page, style);
};


QVerse.prototype.set_first_verse_inital_position=function(page)
{
    this.px = this.right+this.r+7;
    
    var top=this.page_top;
    
    for (var i = 0; i < page.sborders.length; i++) {
        if (this.chapterNo == page.sborders[i].chapterNo) {
            top = page.sborders[i].bottom+5;
            break;
        }
    }
    
    if(this.verseNo==1)
    {
        if(this.chapterNo == 1 )
            top += 40;
        else if(this.chapterNo==2)
            top += 80;
    
        if(top != this.page_top)//no border for sura name
            top += 40;

        top+=5;
    }
    this.py=top+20;
    this.log();
};


QVerse.prototype.calc_rects=function(ctx)
{    
    if(this.rects.length>0)return;
    
    this.adjust_py(ctx);

    var hight_diff = Math.abs(this.y - this.py);
    
    if ( hight_diff < 15 )//same line
    {
        r = new VerseRect(this.x, this.y - 20, this.px - this.x -2*this.r, 40);
        this.rects.push(r);
    }
    else if (this.y > this.py)
    {
        r = new VerseRect(this.left, this.py - 20, this.px - this.left - 2*this.r, 40, true);
        this.rects.push(r);
        
        var lines_in_between = this.y - this.py - 40;
        if( lines_in_between > 25 )
        {
            r = new VerseRect(this.left, this.py + 20, this.right - this.left, lines_in_between);
            this.rects.push(r);

            r = new VerseRect(this.x, lines_in_between+ this.py+20, this.right - this.x, 40);
            this.rects.push(r);
        }
        else
        {
            r = new VerseRect(this.x, this.py+20, this.right - this.x, this.y-this.py);
            this.rects.push(r);
        }
    } 
};

QVerse.prototype.adjust_margin=function()
{

    if( this.chapterNo==1 )
    {
        this.left          = 150;
        this.right          = 430;
        if(this.verseNo==1)
        {
            this.right=380;
        }
        else if(this.verseNo==2)
            this.right=400;
        else if(this.verseNo==5|| this.verseNo==6)
        {
            this.left=160;
        }
    }
    if(this.chapterNo==2)
    {
        if(this.verseNo==1)
        {
            this.left          = 190;
            this.right = 400;
        }
        else if(this.verseNo==2)
        {
            this.left          = 155;
            this.right=430;
        }
        else if(this.verseNo==3)
        {
            this.left          = 155;
            this.right=430;
        }
        else if(this.verseNo==4)
        {
            this.left          = 160;
            this.right=425;
        }
        else if(this.verseNo==5)
        {
            this.left          = 160;
            this.right=425;
        }
    }
};

QVerse.prototype.adjust_py=function(ctx)
{
    if(this.py<=this.page_top)
        this.py=this.page_top+23;

    if( this.chapterNo > 2 && (this.verseNo==1)) 
    {
        var basmallah_rect = new VerseRect(this.right -60, this.py, 20, 20);
        if (basmallah_rect.is_empty_rect(ctx)==true)
            this.py += 35;
    }
}

function english_alphanumeric(inputtxt)
{
    if(/[^0-9a-bA-B\s]/gi.test(inputtxt))
    {
        return true;
    }
    else
    {
        //alert("message");
        return false;
    }
}

QVerse.prototype.select_verse = function (ctx, page, style)
{    
    this.highlight_color = getStyleRuleValue('color', style);
    for(var i=0;i<this.rects.length;i++)
    {
        this.rects[i].draw(ctx, this.highlight_color);
    }
    return;
};

QVerse.prototype.draw_clicked_verse=function(page,ctx)
{
    this.highlight(ctx, page, '.clicked_verse');
    
    page.update_translation_box('{'+this.chapterNo+':'+this.verseNo+'}&emsp;' + this.trans, 'Translation');
    page.setCookie('visited_before', 'true', 30);
    //page.set_verse_tafseer('{'+this.chapterNo+':'+this.verseNo+'}' + this.trans, tran_title);
};


QVerse.prototype.log=function()
{
/*
    console.log(
            ' sura='+ this.chapterNo + 
            ', aya='+this.verseNo + 
            ', x='+ this.x + 
            ', y='+ this.y + 
            ', px='+ this.px + 
            ', py='+ this.py +
            ', left='+ this.left + 
            ', right='+ this.right );
    
*/
};

