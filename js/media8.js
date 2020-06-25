/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */

function QMedia()
{
    this.g_media_array=-null;
    this._current_index=-1;
    this._play_each_count=1;
    this._play_all_count=1;
    this.play_basmala=true;
}

QMedia.prototype.play_selected_verse=function()
{
    this.play_basmala=false;
//    this.play_dummy_audio();
    this.read_repeat_all_count();
    this.get_audio_files_from_server(g_QIhfazPage.get_request_params());
}        

QMedia.prototype.play_dummy_audio=function()
{
    var audio_obj = document.getElementById("audio");
    g_QIhfazPage.set_audio_volume(audio_obj.volume);
    audio_obj.src= encodeURI('sounds/shortbeep.mp3');    
    audio_obj.volume=0;
    audio_obj.play();
}

QMedia.prototype.stopAudio=function()
{
    var audio_obj = document.getElementById("audio");
    audio_obj.pause();
    audio_obj.currentTime=0;
    this.reset_play_button();
};

        

QMedia.prototype.reset_play_button=function()
{
    this.set_play_mode();
};

QMedia.prototype.playAudio=function()
{
    var audio_obj = document.getElementById("audio");
    
    if (audio_obj.paused) 
    {
        var shouldpause=true;
        if( 0  == audio_obj.currentTime  )
        {
            shouldpause = processForm(null);
        }
        else if (audio_obj.currentTime>0)
        {
            audio_obj.play();
        }
        if( shouldpause == true )
            this.set_pause_mode();
    }
    else
    {
        audio_obj.pause();
        this.set_play_mode();
    }
};

QMedia.prototype.set_pause_mode=function()
{
    var stopbutton = document.getElementById("stopbutton");
    stopbutton.disabled=false;
    this.set_buttton_img("pButton", "images/pause1.png");
};




QMedia.prototype.set_play_mode=function()
{
    var stopbutton = document.getElementById("stopbutton");
    stopbutton.disabled=true;
    
    this.set_buttton_img("pButton", "images/play1.png");
};



QMedia.prototype.set_buttton_img=function(button, img)
{
    var pButton = document.getElementById(button);
    pButton.style.backgroundImage = 'url('+img+')';
    pButton.style.backgroundSize ="100%";
    pButton.style.backgroundRepeat="no-repeat";
};


QMedia.prototype.init_playAudio=function()
{
    this.set_play_mode();
};

QMedia.prototype.validate_total_repeat=function()
{
    if(this._play_all_count < 1 )
    {
        this.set_error_label('Please specify the number of repetition for each verse!');
        return false;
    }
};


QMedia.prototype.setVolume=function(volume)
{
    var audio_obj = document.getElementById("audio");
    audio_obj.volume = volume;
    
    g_QIhfazPage.set_audio_volume(volume);
//    var img_volume = document.getElementById("img_volume");
    
    var img_src=null;
    
    if(volume==0)
    {
        img_src = "images/volume0.png";

    }
    else if(volume==1)
    {
        img_src = "images/volume1.png";
    }
    else if(volume<0.3)
    {
        img_src = "images/volume01.png";        
    }
    else
    {
        img_src= "images/volume02.png";        
    }
    this.set_buttton_img("img_volume", img_src);
};

QMedia.prototype.read_repeat_all_count=function()
{
    var repeat_all = document.getElementById("repeat_all");
    this._play_all_count = read_int(repeat_all.value);
}

QMedia.prototype.decrement_play_all_count=function()
{
    this._play_all_count--;

}

QMedia.prototype.get_play_all_count=function()
{
    
    return this._play_all_count;
};

QMedia.prototype.get_play_each_count=function()
{
    
    return this._play_each_count;
};

QMedia.prototype.update_current_display=function (MediaObj) {

    this.init_looping();
    this.read_play_each_count();
    
    MediaObj.play_audio(this.get_play_each_count(), true);

    g_Pages.load_verse_page(MediaObj.get_sura(),MediaObj.get_vrse_number());

};

QMedia.prototype.load_next_audio=function()
{
    cindex= this.increment_current_index();

    if( cindex < this.g_media_array.length )
    {
        this.update_current_display(this.g_media_array[cindex]);
    }
    else
    {
        this.Start_playing(false);
    }
};


QMedia.prototype.get_current_index=function()
{
    return this._current_index;
};

QMedia.prototype.increment_current_index=function()
{
    this._current_index++;
    return this._current_index;
};

QMedia.prototype.reset_current_index=function(play_basmala)
{
    this._current_index=-1;
    if(play_basmala==false)
    {
        while(this.g_media_array[0].verse_no == 0 || this.g_media_array[0].verse_no==-1)
        {
             this.g_media_array.splice(0, 1);
        }
    }
};

//olfat
QMedia.prototype.Start_playing=function(play_basmala)
{
    //start over the play list if repetition is requested:
    if(this.get_play_all_count()>0)
    {
        this.reset_current_index(play_basmala);
        this.read_play_each_count();
        this.decrement_play_all_count();
        
        this.load_next_audio();
    }
    else
    {
        var audio_obj = document.getElementById("audio");
        audio_obj.currentTime=0;
        this.set_play_mode();
    }
};


QMedia.prototype.decrement_play_each_count=function()
{
    this._play_each_count--;
};

QMedia.prototype.read_play_each_count=function()
{
    this._play_each_count=1;
    if (document.getElementById('r3').checked) {
        this._play_each_count=3;
    }
    else if (document.getElementById('r5').checked) {
        this._play_each_count=5;
    }
    else if (document.getElementById('r7').checked) {
        this._play_each_count=7;
    }
    return this._play_each_count;
};



QMedia.prototype.init_looping=function()
{
    var audio = document.getElementById("audio");
    if (audio.removeEventListener)
    {
        audio.removeEventListener("ended", handle_play_end_event);
        audio.removeEventListener("timeupdate", handle_timeupdate_event);

    }
    else if (audio.detachEvent)
    {
        audio.detachEvent("ended", handle_play_end_event);
        audio.detachEvent("timeupdate", handle_timeupdate_event);
    }

    audio.addEventListener('ended', handle_play_end_event, false);
    audio.addEventListener('timeupdate', handle_timeupdate_event, false);

};

function handle_timeupdate_event()
{    
    var audio = document.getElementById("audio");
    var seekbar = document.getElementById("seekbar");
    seekbar.setAttribute("value", audio.currentTime / audio.duration);

};



function handle_play_end_event()
{
    var should_playnext = false;
    if (g_QMedia.get_play_each_count()>1)
    {
        if(this.src.indexOf('000000.mp3') >0 ||this.src.indexOf('001001.mp3')>0)
        {
            should_playnext = true;
        }
        else
        {
            g_QMedia.decrement_play_each_count();
            this.currentTime = 0;
            g_QMedia.set_play_timeupdate(0);
            this.play();
        }
    }
    else 
        should_playnext = true;
    
    
    if(should_playnext == true)
    {
        g_QMedia.set_play_timeupdate(0);
        g_QMedia.load_next_audio();
    }
};

function QAudio(soura, verse_no, audio_url, repeat_count)
{
    this.sura=soura;
    this.verse_no=verse_no;
    this.audio_url=audio_url;
    this.repeat_count=repeat_count;
};

QAudio.prototype.get_sura=function()
{
    return this.sura;
};

QAudio.prototype.get_vrse_number=function()
{
    return this.verse_no;
};

QAudio.prototype.set_repeat_count = function (repeat_count)
{
    this.repeat_count=repeat_count;
};


QAudio.prototype.play_audio= function(repeat_count, force)
{
    this.repeat_count=repeat_count;
    var audio = document.getElementById("audio");
    audio.volume = g_QIhfazPage.get_audio_volume();
    audio.src= encodeURI(this.audio_url);
    g_QMedia.set_play_timeupdate(0);
    g_QMedia.set_play_timeupdate(0);
    g_QMedia.set_pause_mode();
    audio.play();

};

QMedia.prototype.set_play_timeupdate=function(val)
{    
    var seekbar = document.getElementById("seekbar");
    seekbar.setAttribute("value", val);
    if( val == 0 )
        seekbar.value = seekbar.innerHTML = 0; 

};

function transferFailed(evt) {
  console.log(evt.message);
  //alert(evt.message);
}

QMedia.prototype.get_audio_files_from_server=function(params)
{
    var xhr = new XMLHttpRequest();
    xhr.open('POST', encodeURI("playlist.php?"+params), true);
    //xhr.addEventListener("error", transferFailed);
    xhr.setRequestHeader('Content-Type', 'application/json');

    qmedia_self=this;

    xhr.onload = function(evt)
    {
        qmedia_self.load_audio_files_from_text(xhr.responseText);
    };
    xhr.send();
};

QMedia.prototype.load_audio_files_from_text=function(text)
{
    this.g_media_array=Array();
    audio_array = text.split(',');

    if(this.play_basmala==true)
    {
        var audio_object = new QAudio(g_QIhfazPage.get_soura(), 0, encodeURI('sounds/'+g_QIhfazPage.get_reciter()+'/000000.mp3'));
        this.g_media_array.push(audio_object);

        var sura = g_QIhfazPage.get_soura();
        var from_verse = g_QIhfazPage.get_from_verse();
        if(!(sura==1 || ( sura == 9 && from_verse==1)))
        {
            var audio_object = new QAudio(g_QIhfazPage.get_soura(), -1, encodeURI('sounds/'+g_QIhfazPage.get_reciter()+'/001001.mp3'));
            this.g_media_array.push(audio_object);
        }
    }
    
    for(i=0;i<audio_array.length;i++)
    {
        audio_url = audio_array[i];
        var audio_object = new QAudio(g_QIhfazPage.get_soura(), g_QIhfazPage.get_from_verse()+i, audio_url);
        this.g_media_array.push(audio_object);
    }
    this.Start_playing(true);
    this.play_basmala=true;//reset to default
};

/*<audio controls preload="none">
 <source src="{$base_url}audio/pitbull.mp3" type="audio/mpeg">
 <source src="{$base_url}audio/music.ogg" type="audio/ogg">
 </audio>*/