/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */





function clear_canvas(canvas , context)
{
    
    context.clearRect(0, 0, canvas.width, canvas.height, true);
    context.beginPath();
    context.closePath();
}



function zeroFill( number, width )
{
    width -= number.toString().length;
    if ( width > 0 )
    {
        return new Array( width + (/\./.test( number ) ? 2 : 1) ).join( '0' ) + number;
    }
    return number + ""; // always return a string
}



function QChapterBox(chapterNo,l,t, r, b)
{
    this.chapterNo=Number(chapterNo);
    this.left=parseFloat(l);
    this.top=parseFloat(t);
    this.right=parseFloat(r);
    this.bottom=parseFloat(b);
}

function QPage(page_num, nVerses, left, top, right, bottom)
{
    this.page_num       = Number(page_num);
    this.nVerses        = Number(nVerses);
    this.left           = parseFloat(left)+30;
    this.top            = parseFloat(top)+35;
    this.right          = parseFloat(right)-30;
    this.bottom         = parseFloat(bottom)-30;
    this.verses         =   new Array();
    this.sborders       =   new Array();
    this.page_url       =   null;
    this.hover_vindex=-1;
    this.played_vindex=-1;
    this.clicked_vindex=-1;
    this.show_help=true;
}



QPage.prototype.calc_verses_areas=function(ctx)
{
    if(this.verses.length==0)return;
    
    for(var i=0;i<this.verses.length;i++)
    {
        this.verses[i].calc_rects(ctx);
    }    
}

QPage.prototype.adjust_verses_begin=function()
{
    if(this.verses.length==0)return;
    
    this.verses[0].set_first_verse_inital_position(this);

    for(var i=1;i<this.verses.length;i++)
    {
        this.verses[i].set_begin_position(this, this.verses[i-1].x, this.verses[i-1].y);
        
    }    
}

QPage.prototype.add_sborder=function(ChapterBox)
{
    this.sborders.push(ChapterBox);
}

QPage.prototype.add_verse=function(verse)
{

    this.verses.push(verse);
}

QPage.prototype.get_verse_by_location=function(x, y)
{

    for(var i=0;i<this.verses.length;i++)
    {
        if(this.verses[i].point_within_verse_area(x,y) == true )
        {
            //console.log('point(' + x + ','+ y + ')found in verse:'+ this.verses[i].verseNo);
            return i;
        }
    }
    return -1;
};

QPage.prototype.click_verse=function(x, y)
{
    
    this.clicked_vindex = this.get_verse_by_location(x,y);
    if(this.clicked_vindex>=0)
    {
        g_QIhfazPage.set_selected_soura(this.verses[this.clicked_vindex].chapterNo); 

        //console.log('selected verse number:'+ this.clicked_vindex);
        this.refresh_page();
    }
};


QPage.prototype.dblclick_verse=function(x, y)
{
    
    this.clicked_vindex = this.get_verse_by_location(x,y);
    if(this.clicked_vindex>=0)
    {
        g_QIhfazPage.set_selected_soura(this.verses[this.clicked_vindex].chapterNo); 
        g_QIhfazPage.set_selected_verse(this.verses[this.clicked_vindex].verseNo);
        g_QIhfazPage.set_to_verse(this.verses[this.clicked_vindex].verseNo);
        this.refresh_page();
        g_QMedia.play_selected_verse();
    }
};

QPage.prototype.hover_verse=function(x, y, flag)
{
    this.hover_vindex=-1;
    if(flag)
        this.hover_vindex = this.get_verse_by_location(x,y);
    
    //console.log('selected verse number:'+ this.hover_vindex);
    this.refresh_page();
};


QPage.prototype.is_aya_in_page=function(soura_num, aya)
{
    this.played_vindex=-1;

    for(var i=0;i<this.verses.length;i++)
    {
        if( this.verses[i].chapterNo == soura_num && this.verses[i].verseNo == aya )
        {
            this.played_vindex = i;//this.verses[i];
            return this.verses[i];
        }
    }
    return null;
}

QPage.prototype.get_page_num= function(){return this.page_num;}
QPage.prototype.set_page_num = function(page_num){this.page_num=page_num;}

QPage.prototype.print_debug_info=function()
{
    //console.debug("page="+this.get_page_num());
}

QPage.prototype.setCookie=function(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
} 

QPage.prototype.getCookie=function(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}


QPage.prototype.update_translation_box=function(text, title)
{
    var tafseer_title = document.getElementById("tafseer_title");
    tafseer_title.innerHTML = title;
    
    var tafseer = document.getElementById("tafseer_text");
    if(this.clicked_vindex>-1)
    {
        tafseer.innerHTML = text; 
        tafseer.style = "tafseer_text";
    }
    else
    {
        /*if(tafseer.innerHTML[0]=='{')
        {
            tafseer.innerHTML = text; 
            tafseer.style = "tafseer_text";
        }*/
        //tafseer.style.border = "thick solid #D1D3D4;";
        //tafseer.style="help_text";
        if(this.getCookie('visited_before')=="")
            tafseer.innerHTML='<br><br><center>Click a Verse to see translation of Meaning <br><br><br><br>Double Click a Verse to Listen to Verse';
        return;
    }
};

QPage.prototype.clear_all=function()
{
    //this.clicked_vindex=-1;
    this.update_translation_box('','Translation');
} 

QPage.prototype.show_q_page0=function(img,force)
{
        //this sould be syncronized
        var canvas = document.getElementById('pages_canvas');
        
        var margin_column=document.getElementById('margin_column');
        
        var w = 135-this.left;
        
        margin_column.style.width = w + "px";
        
        var ctx = canvas.getContext("2d");
        clear_canvas(canvas, ctx);
        this.clear_all();
        ctx.drawImage(img, 0, 0);
        this.calc_verses_areas(ctx);
        this.highlight_verse(ctx);
};

QPage.prototype.show_q_page=function(img,force)
{
        //this sould be syncronized
        var canvas = document.getElementById('pages_canvas');
        
        //var margin_column=document.getElementById('margin_column');
        canvas.style.width;
        var w = 135-this.left;
        
        canvas.style.left = w + "px";
        
        var ctx = canvas.getContext("2d");
        clear_canvas(canvas, ctx);
        this.clear_all();
        ctx.drawImage(img, 0, 0);
        this.calc_verses_areas(ctx);
        this.highlight_verse(ctx);
};


var busy=false;
QPage.prototype.refresh_page=function()
{
    var self = this;
    
    var img = new Image();

    img.onload = function ()
    {
        if(busy==false)
        {
            busy=true;
            self.show_q_page(img);
            busy=false;
        }
    }
    img.src = this.page_url;//url
    document.getElementById('page_num').textContent=this.page_num;
    document.getElementById('input_page_number').value=this.page_num;
}

function transferFailed(evt) {
  console.log(evt.message);
  //alert(evt.message);
}

QPage.prototype.draw_page= function()
{
    if(this.page_url!=null)
    {
        this.refresh_page();
        return;
    }
    var sfilename = zeroFill(this.page_num, 3);
        this.img_ext=page_ext;
    this.pages_root=pages_root;

    //this.page_url = encodeURI('http://hidayah-institute.com/almurattal/eApp/data/pages/png/' + sfilename + '.png');//_595x841
    this.page_url = encodeURI(this.pages_root + sfilename + this.img_ext);//_595x841
    this.refresh_page();
};

QPage.prototype.reset_indexes=function()
{
    this.played_vindex=-1;
    this.clicked_vindex=-1;
    this.hover_vindex=-1;
}

QPage.prototype.highlight_verse=function(ctx)
{
    if ( this.played_vindex >= 0 )
    {
        this.verses[this.played_vindex].highlight(ctx, this, '.play_verse');
    }
    if ( this.clicked_vindex >= 0 )
    {
        this.verses[this.clicked_vindex].draw_clicked_verse(this, ctx);
    }
    if ( this.hover_vindex >= 0 && this.hover_vindex!=this.clicked_vindex )
    {        
        this.verses[this.hover_vindex].highlight(ctx, this, '.hover_verse');
    }
        
};

function QPages(page_ext, pages_root)
{
    this.img_ext=page_ext;
    this.pages_root=pages_root;
    this.g_pages_list=new Array();
    this.active_page=null;
    this.ishover=false;
}



QPages.prototype.dblclick_verse=function(x, y)
{
    if(this.active_page)
    {
        this.active_page.dblclick_verse(x, y);
    }
    else
    {
        //console.log('no active page');
    }
};

QPages.prototype.click_verse=function(x, y)
{
    if(this.active_page)
    {
        this.active_page.click_verse(x, y);
    }
    else
    {
        //console.log('no active page');
    }
};

QPages.prototype.hover_verse=function(x, y, flag)
{
    this.ishover=true;
    
    if(this.active_page)
    {
        this.active_page.hover_verse(x, y, flag);
    }
    else
    {
        //console.log('no active page');
    }
};

QPages.prototype.get_pages_list=function(text)
{
    return this.g_pages_list;
}

QPages.prototype.read_xml_text=function(text)
{
    //try
    {
        if (window.DOMParser)
        {
            parser = new DOMParser();
            xmlDoc = parser.parseFromString(text, "text/xml");
        }
        else // Internet Explorer
        {
            xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
            xmlDoc.async = false;
            xmlDoc.loadXML(text);
        }

        var pages_tags = xmlDoc.getElementsByTagName('page');
        for (var i = 0; i < pages_tags.length; i++)
        {
            var pg_nm = pages_tags[i].getAttribute('index');
            var qpage_obj = this.get_page_by_number(pg_nm);

            if ( qpage_obj != null)
            {
                var verses_tags = pages_tags[i].getElementsByTagName('verse');
                var isfirst= true;
                for (var k = 0; k < verses_tags.length; k++)
                {
                    var trans = verses_tags[k].getAttribute('trans');
                    qpage_obj.verses[k].trans=trans;
                }
                continue;
            }
            qpage_obj = new QPage(
                                        pages_tags[i].getAttribute('index'),
                                        pages_tags[i].getAttribute('ttl'),
                                        pages_tags[i].getAttribute('left'),
                                        pages_tags[i].getAttribute('top'),
                                        pages_tags[i].getAttribute('right'),
                                        pages_tags[i].getAttribute('bottom')
                                    );

            var verses_tags = pages_tags[i].getElementsByTagName('verse');
            var isfirst= true;
            for (var k = 0; k < verses_tags.length; k++)
            {
                var chapterNo = verses_tags[k].getAttribute('sura');
                var verseNo = verses_tags[k].getAttribute('aya');
                var cx = verses_tags[k].getAttribute('cx');
                var cy = verses_tags[k].getAttribute('cy');
                var r = verses_tags[k].getAttribute('r');
                var trans = verses_tags[k].getAttribute('trans');
                
                var qverse = new QVerse(chapterNo, verseNo, cx, cy, r, isfirst, qpage_obj.left, qpage_obj.top, qpage_obj.right,trans);
                qpage_obj.add_verse(qverse);
                isfirst=false;
                //console.log(trans);
            }
            var sborders_tags = pages_tags[i].getElementsByTagName('sborder');
            for (var k = 0; k < sborders_tags.length; k++)
            {
                var chapterNo = sborders_tags[k].getAttribute('index');
                var l = sborders_tags[k].getAttribute('left');
                var t = sborders_tags[k].getAttribute('top');
                var r = sborders_tags[k].getAttribute('right');
                var b = sborders_tags[k].getAttribute('bottom');

                var ChapterBox = new QChapterBox(chapterNo, l, t, r, b);
                qpage_obj.add_sborder(ChapterBox);
            }
            qpage_obj.adjust_verses_begin();
            this.g_pages_list.push(qpage_obj);
        }
    }
    /*catch(err)
    {
        console.log(text);
        console.log(err.message);
    }*/
}

function read_int(value)
{
    var ival=0;
    if (value!="")
        ival = parseInt(value, 10);
    return ival;
}

QPages.prototype.set_active_page=function(sura, aya)
{    
    var _page = this.get_verse_page(sura, aya);
    if(_page!=null)
    {
        this.active_page=_page;
        this.active_page.clicked_vindex=-1;
        this.active_page.draw_page();
        return true;
    }
    //console.log('pages loaded but current page null, reset to first page');
    //if(this.g_pages_list.length>0)
    //    this.active_page=this.g_pages_list[0];
    return false;
};

QPages.prototype.parse_pages_list=function(text)
{
    this.read_xml_text(text);
    this.set_active_page(g_QIhfazPage.get_soura(), g_QIhfazPage.get_from_verse());
}

QPages.prototype.get_page_by_number=function(page_num)
{
    for(var i=0;i<this.g_pages_list.length;i++)
    {
        if( this.g_pages_list[i].get_page_num() == page_num)
        {
            return this.g_pages_list[i];
        }
    }
    
    return null;
}

        
QPages.prototype.update_trans_from_server=function()
{
    var pages_arr=new Array();
    
    var pages_str='';
    
    for(var i=0;i<this.g_pages_list.length;i++)
    {
        //pages_arr[i]=this.g_pages_list[i].get_page_num();
        if(i==0)
        {
            pages_str=this.g_pages_list[i].get_page_num();
        }
        else
        {
            pages_str += ',' + this.g_pages_list[i].get_page_num();
        }
    }
    //var pages_str =JSON.stringify(pages_arr);
    
    var params = g_QIhfazPage.setup_trans_params(pages_str);

    var xhr = new XMLHttpRequest();
    var req_string = encodeURI("get_pages.php?" + params);
    xhr.open('POST', req_string, true);
    xhr.setRequestHeader('Content-Type', 'application/jason');
    var myself=this;

    xhr.onload=function(evt)
    {
        g_Pages.on_translation_change(xhr.responseText);
    }
    xhr.send();
}

QPages.prototype.get_pages_from_server=function(params)
{
    var xhr = new XMLHttpRequest();
    var req_string = encodeURI("get_pages.php?" + params);
    xhr.open('POST', req_string, true);
    xhr.setRequestHeader('Content-Type', 'application/jason');
    var myself=this;
    xhr.onload=function(evt)
    {
        g_Pages.parse_pages_list(xhr.responseText);
    };

    xhr.send();
}




QPages.prototype.get_verse_page=function(soura_num, verse_num)
{
    for (i=0; i<this.g_pages_list.length; i++)
    {
        var verse = this.g_pages_list[i].is_aya_in_page(soura_num, verse_num);
        if( verse!= null)
        {
            return this.g_pages_list[i];
        }
    }
    return null;
}

QPages.prototype.load_verse_page=function(soura_num, verse_num)
{
    var _page = this.get_verse_page(soura_num, verse_num);

    if( _page != null )
    {
        this.active_page=_page;
        
        this.active_page.draw_page();
    }
}


QPages.prototype.show_page=function(text)
{
    this.read_xml_text(text);

    var _page = this.get_page_by_number(this.loading_page);

    if( _page != null )
    {
        this.active_page=_page;
        this.active_page.draw_page();
        g_QIhfazPage.set_selected_soura(this.active_page.verses[0].chapterNo); 
        g_QIhfazPage.set_selected_verse(this.active_page.verses[0].verseNo);
    }
}


QPages.prototype.get_page_from_server=function(page_num, tafseer)
{
    var xhr = new XMLHttpRequest();
    var req_string = encodeURI("get_pages.php?" + 'page_num='+page_num + '&tafseer=' +tafseer);
    xhr.open('POST', req_string, true);

    xhr.setRequestHeader('Content-Type', 'application/jason');
    
    this.loading_page= page_num;
    
    var self=this;
    
    xhr.onload=function(evt)
    {
        self.show_page(xhr.responseText);
        
    };

    xhr.send();
}

QPages.prototype.load_page=function(page_num)
{
    if(page_num>=1 && page_num<=604)
    {
        this.load_page(page_num);
    }
    
};
        
QPages.prototype.load_next=function()
{
    if(this.active_page)
    {
        this.load_page(this.active_page.page_num + 1);
    }
}

QPages.prototype.load_previous=function()
{
    if(this.active_page)
    {
        this.load_page(this.active_page.page_num - 1);
    }
}



QPages.prototype.load_page_by_sura=function(sura_num, aya_num)
{
    g_QIhfazPage.read_tafseer();
    g_QIhfazPage.set_selected_soura(sura_num); 
    g_QIhfazPage.set_selected_verse(aya_num);

    if(this.set_active_page(sura_num, aya_num) == false)
    {
        g_Pages.get_pages_from_server(g_QIhfazPage.get_request_params());
    }
}

QPages.prototype.load_page=function(page_num)
{
    if( page_num <= 0 || page_num> 604 )return;

    var _page = this.get_page_by_number(page_num);
    if(_page)
    {
        this.active_page = _page;
        this.active_page.draw_page();
        g_QIhfazPage.set_selected_soura(this.active_page.verses[0].chapterNo); 
        g_QIhfazPage.set_selected_verse(this.active_page.verses[0].verseNo);
    }
    else
    {
        g_QIhfazPage.read_tafseer();
        this.get_page_from_server(page_num, g_QIhfazPage.get_tafseer());
    }
}

QPages.prototype.on_translation_change=function(text)
{
    var clicked_vindex = -1;
    
    if(this.active_page)
    {
       clicked_vindex = this.active_page.clicked_vindex;
    }
    
    g_Pages.parse_pages_list(text);
    
    if(clicked_vindex >=0 && this.active_page)
    {
        this.active_page.clicked_vindex = clicked_vindex;
        this.active_page.draw_page();
    }
};
