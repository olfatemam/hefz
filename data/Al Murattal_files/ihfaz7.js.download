/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */


function on_repeatition_click(checkbox, checkbox1, checkbox2)
{
    if(checkbox.checked)
    {
        checkbox1.checked=false;
        checkbox2.checked=false;
    };
};


function QIhfazPage(){
    this.g_reciter='000';
    this.g_tafseer='en.sahih.xml';
    this.g_soura=1;
    this.g_from_verse=1;
    this.g_to_verse=1;
    this.g_params='';
    this.g_nVerses=1;
    this.audio_volume=0;
};

function read_int(value)
{
    var ival=0;
    if (value!="")
        ival = parseInt(value, 10);
    return ival;
};

QIhfazPage.prototype.initialize=function()
{
    var soura = document.getElementById("soura");
    //self= this;
    soura.onchange = function()
    {
        g_QIhfazPage.reset_from_list();
        g_QIhfazPage.reset_to_list();

    };;
    g_QIhfazPage.reset_from_list();
    g_QIhfazPage.reset_to_list();

    var audio = document.getElementById("audio");
    this.audio_volume=audio.volume;

    //var myElem = document.getElementById('pages_canvas');
    
    document.getElementById("input_page_number").addEventListener("keyup", function(event) {
    event.preventDefault();
    if (event.keyCode == 13){
        document.getElementById("goto_page_btn").click();
    }
});
    document.getElementById("tafseer").addEventListener("change", function(event){g_Pages.update_trans_from_server();});

};

/////////////////////////
//setters
QIhfazPage.prototype.set_audio_volume=function(volume)
{
    this.audio_volume=volume;
};
        
QIhfazPage.prototype.set_tafseer=function (tafseer)
{
    this.g_tafseer=tafseer;
};

QIhfazPage.prototype.get_tafseer=function ()
{
    return this.g_tafseer;
};

QIhfazPage.prototype.set_reciter=function (reciter)
{
    this.g_reciter=reciter;
};

QIhfazPage.prototype.set_selected_soura=function(sura_number)
{
    if(this.g_soura!=sura_number)
    {
        var soura = document.getElementById("soura");
        soura.selectedIndex= sura_number -1;
        this.read_sura_info();
        this.reset_from_list();
        this.reset_to_list();
    }
    this.set_to_verse(this.g_nVerses);
};

QIhfazPage.prototype.set_selected_verse=function(verse)
{
    this.set_from_verse(verse);
};

QIhfazPage.prototype.set_from_verse=function(from_verse)
{
    this.g_from_verse=from_verse;
    var from_list = document.getElementById("from_list");
    from_list.selectedIndex=from_verse-1;
};

QIhfazPage.prototype.set_to_verse=function(to_verse)
{
    this.g_to_verse=to_verse;
    var to_list = document.getElementById("to_list");
    to_list.selectedIndex=this.g_to_verse-1;
};

QIhfazPage.prototype.set_request_params= function (params)
{
    this.g_params=params;
};;
QIhfazPage.prototype.set_numberof_verses= function (nVerses)
{
    this.g_nVerses=nVerses;
};;


QIhfazPage.prototype.get_reciter=function()
{
    return this.g_reciter;
};

QIhfazPage.prototype.get_soura=function()
{
    this.read_sura_info();
    return this.g_soura;
};

QIhfazPage.prototype.get_from_verse=function()
{
    return this.g_from_verse;
};

QIhfazPage.prototype.get_to_verse=function()
{
    return this.g_to_verse;
};

QIhfazPage.prototype.get_request_params=function()
{
    this.setup_params();
    return this.g_params;
};

QIhfazPage.prototype.get_numberof_verses= function()
{
    return this.g_nVerses;
};

QIhfazPage.prototype.get_audio_volume=function()
{
    return this.audio_volume;
};;
        

QIhfazPage.prototype.setup_params=function()
{
    this.g_params = "reciter="+this.g_reciter;
    this.g_params += "&tafseer="+this.g_tafseer;
    
    this.g_params += "&soura="+this.get_soura();
    this.g_params += "&from="+this.g_from_verse;
    this.g_params += "&to="+this.g_to_verse;
    this.g_params += "&repeat="+g_QMedia.get_play_each_count();
    //console.log(this.g_params);
};

QIhfazPage.prototype.setup_trans_params=function(pages_str)
{
    this.read_tafseer();
    this.g_params = "update_trans=1";
    this.g_params += "&tafseer="+this.g_tafseer;
    this.g_params += "&pages_list="+pages_str;
    //console.log(this.g_params);
    return this.g_params;
};

QIhfazPage.get_playing_verse_number = function () {
    verse_number= this.get_from_verse()+ g_QMedia.get_current_index();
    return verse_number;
};;

QIhfazPage.prototype.good_to_go=function()
{
    this.read_input();
    if (this.validate() == true)
    {
        this.setup_params();
        return true;
    };
};

QIhfazPage.prototype.validate=function()
{
    this.set_error_label(' ');

    if ( this.g_reciter == '' )
    {
        this.set_error_label('Please specify the reciter!');
        return false;
    };

    if ( this.g_tafseer == '' )
    {
        this.set_error_label('Please specify tafseer!');
        return false;
    };

    if( this.g_soura== '')
    {
        this.set_error_label('Please specify the Soura!');
        return false;
    };

    if (false == this.validate_verses_range())return false;
    return true;
};




QIhfazPage.prototype.validate_from=function()
{
    this.set_error_label(' ');
    this.read_from();
    this.read_to();
    this.validate_verses_range();
};

QIhfazPage.prototype.validate_to=function()
{
    this.set_error_label(' ');
    this.read_from();
    this.read_to();
    this.validate_verses_range();
};


QIhfazPage.prototype.reset_to_list=function()
{
    this.read_sura_info();
    var to_list = document.getElementById('to_list');
    this.reset_list(to_list, this.g_nVerses, this.g_nVerses);
};

QIhfazPage.prototype.reset_from_list=function()
{
    this.read_sura_info();

    var from_list = document.getElementById('from_list');
    this.reset_list(from_list, this.g_nVerses, 1);
};

QIhfazPage.prototype.reset_list=function(list, maxval, select_index)
{
    //for (var i=0; i<list.length; i++){
      //      list.remove(i);
    //};
    while(list.length>0)
    {
        list.remove(0);
    }
    
    for (var i = 1; i<=maxval; i++){
        var opt = document.createElement('option');
        opt.value = i;
        opt.innerHTML = i;
        list.appendChild(opt);
    };
    if(select_index==1)
    {
        list.value = 1;
    }
    else
        list.value =maxval;
};

QIhfazPage.prototype.validate_range=function(ival, iverses, customtext)
{
    if( ival < 1 || ival > iverses )
    {
        var sometext = " verse between 1 and " ;
        var smessage = "Please specify ";
        smessage += customtext;
        smessage += sometext;
        smessage += iverses;
        this.set_error_label(smessage);

        return false;
    };
    return true;
};

QIhfazPage.prototype.set_error_label=function(smessage)
{
    error_label = document.getElementById("ehfaz_error");
    error_label.innerHTML = smessage;
};



QIhfazPage.prototype.validate_verses_range=function()
{
    if (false == this.validate_range(this.g_from_verse, this.g_nVerses, ' start ')||
        false == this.validate_range(this.g_to_verse, this.g_nVerses, ' end '))
        return false;

    if( this.g_from_verse > this.g_to_verse )
    {
        this.set_error_label('Please make sure that the start verse is before the end verse!');
        return false;
    };
};

QIhfazPage.prototype.get_verses_of_sura=function(index)
{
    var soura = document.getElementById("soura");
    var nVerses = read_int(soura.options[index-1].getAttribute('Verses'));
    return nVerses;
};

QIhfazPage.prototype.read_reciter=function()
{
    this.g_reciter='';
    var reciter = document.getElementById("reciter");
    if(reciter.selectedIndex>=0)
        this.g_reciter=reciter.options[reciter.selectedIndex].getAttribute('audiopath');
};


QIhfazPage.prototype.read_tafseer=function()
{
    this.g_tafseer='';
    var tafseerlist = document.getElementById("tafseer");
    if(tafseerlist.selectedIndex>=0)
        this.g_tafseer=tafseerlist.options[tafseerlist.selectedIndex].getAttribute('filepath');
};

QIhfazPage.prototype.read_sura_info=function()
{
    var soura = document.getElementById("soura");
    if(soura.selectedIndex>=0) {
        this.g_soura = read_int(soura.options[soura.selectedIndex].value);
        this.g_nVerses = read_int(soura.options[soura.selectedIndex].getAttribute('Verses'));
    };
};

QIhfazPage.prototype.read_from=function()
{
    var from_list = document.getElementById("from_list");
    if(from_list.selectedIndex>=0)
    {
        this.g_from_verse=read_int(from_list.options[from_list.selectedIndex].value);
    };
};

QIhfazPage.prototype.read_to=function()
{
    var to_list = document.getElementById("to_list");
    if(to_list.selectedIndex>=0)
    {
        this.g_to_verse=read_int(to_list.options[to_list.selectedIndex].value);
    };
};

QIhfazPage.prototype.read_input=function()
{
    this.g_soura=0;
    this.read_reciter();
    this.read_sura_info();
    this.read_from();
    this.read_to();
    this.read_tafseer();

    g_QMedia.read_repeat_all_count();
    g_QMedia.read_play_each_count();
};
