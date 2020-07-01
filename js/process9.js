/* global g_Pages, g_QMedia, g_QIhfazPage */

/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */



//initial_vol=0;

function start() {
    var canvastmp = document.getElementById("pages_canvas");
    canvas = canvastmp.getContext("2d");
    window.addEventListener('mousemove', hover_verse, false);
}

/*function trevor(pos) {
    //canvas.clearRect(0, 0, 600, 400);
    //var x = pos.clientX;
    //var y = pos.clientY;
    //canvas.fillRect(x - 25, y - 25, 100, 100);
}
*/

function next()
{
    g_Pages.load_next();
}


function prev()
{
    g_Pages.load_previous();
}

function clearSelection() {
    if(document.selection && document.selection.empty) {
        document.selection.empty();
    } else if(window.getSelection) {
        var sel = window.getSelection();
        sel.removeAllRanges();
    }
}
function dblclick_verse(pos)
{
    //clearSelection();
    
    var canvas = document.getElementById('pages_canvas');
    var rect = canvas.getBoundingClientRect();
    var x = pos.clientX - rect.left;
    var y = pos.clientY - rect.top;
    g_Pages.dblclick_verse(x,y);
    return false;
}

function click_verse(pos)
{
    var canvas = document.getElementById('pages_canvas');
    var rect = canvas.getBoundingClientRect();
    var x = pos.clientX - rect.left;
    var y = pos.clientY - rect.top;
    //console.log('mouse click x='+ x + ',y=' + y );
    g_Pages.click_verse(x,y);
    return false;
}

function goto_sura(sura_num,aya_um)
{
    g_Pages.load_page_by_sura(sura_num,aya_um);
    /*var item1 = document.getElementById("dropdown-content");
    item1.classList.toggle("show");
    
    var item2 = document.getElementById("dropdown-content");
    item2.classList.toggle("show");
*/
    return false;
}
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
/*
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
} 
*/

function show_menu(id)
{
//    document.getElementById(id).style.display = "inline-table";
}

function hover_verse(pos)
{
    var canvas = document.getElementById('pages_canvas');
    var rect = canvas.getBoundingClientRect();
    var x = pos.clientX - rect.left;
    var y = pos.clientY - rect.top;
    //console.log('mouse move x='+ x + ',y=' + y );
    g_Pages.hover_verse(x,y, true);
}

function clear_verse(e)
{
//screenX
    var canvas = document.getElementById('pages_canvas');
    var rect = canvas.getBoundingClientRect();
    var x = e.clientX - rect.left;
    var y = e.clientY - rect.top;
    //console.log('mouse out x='+ x + ',y=' + y );
    g_Pages.hover_verse(x,y, false);
}
        
window.addEventListener('load', start, false);

function hide_volume_slider()
{
    //var x = document.getElementById('volume_slider');
    //if (x.style.display !== 'none') {
    //  x.style.display = 'none';
    //}
}
function on_vol_lose_focus()
{
    volume_clicked();
}

function volume_clicked() 
{
    //var x = document.getElementById('volume_slider');
    /*
     * if (x.style.display === 'none') {
        //x.style.display = 'block';
    } else {
        //x.style.display = 'none';
    }
     */
}

function goto_page()
{
  var input_page_number = document.getElementById('input_page_number');

    g_Pages.load_page(input_page_number.value);
}

function processForm()
{
    //hide_volume_slider();
    if(g_QIhfazPage.good_to_go()==true)
    {
        g_QMedia.play_dummy_audio();
    
        g_Pages.get_pages_from_server(g_QIhfazPage.get_request_params());
        g_QMedia.play_basmala=true;//just to be sure
        g_QMedia.get_audio_files_from_server(g_QIhfazPage.get_request_params());
        
        return true;
    }
    return false;
 }
 
function on_refresh_translation()
{
    g_Pages.update_trans_from_server();
}
 
function load_default() {
    g_QIhfazPage.initialize();
      
    g_Pages.get_pages_from_server(g_QIhfazPage.get_request_params());
    init_playAudio();
    var os = getOS();
    if(os == 'Android' )
    {
    
    }
    else if(os == 'iOS')
    {
        
    }
 /*   var scale = 'scale(7/10)';
    document.body.style.webkitTransform =       // Chrome, Opera, Safari
     document.body.style.msTransform =          // IE 9
     document.body.style.transform = scale;     // General    
*/
}

function getOS() {
  var userAgent = window.navigator.userAgent,
      platform = window.navigator.platform,
      macosPlatforms = ['Macintosh', 'MacIntel', 'MacPPC', 'Mac68K'],
      windowsPlatforms = ['Win32', 'Win64', 'Windows', 'WinCE'],
      iosPlatforms = ['iPhone', 'iPad', 'iPod'],
      os = null;

  if (macosPlatforms.indexOf(platform) !== -1) {
    os = 'Mac OS';
  } else if (iosPlatforms.indexOf(platform) !== -1) {
    os = 'iOS';
  } else if (windowsPlatforms.indexOf(platform) !== -1) {
    os = 'Windows';
  } else if (/Android/.test(userAgent)) {
    os = 'Android';
  } else if (!os && /Linux/.test(platform)) {
    os = 'Linux';
  }

  return os;
}

//alert(getOS());

function on_from_changed()
{
    g_QIhfazPage.validate_from();
}

function on_to_changed()
{
    g_QIhfazPage.validate_to();
}



function stopAudio()
{
    hide_volume_slider();
    g_QMedia.stopAudio();
}



function playAudio()
{
    hide_volume_slider();
    g_QMedia.playAudio();
}


function init_playAudio()
{
    g_QMedia.init_playAudio();
};

function setVolume(volume)
{
    g_QMedia.setVolume(volume);
}


/*
 *            <div id="player">
                    <audio id="audio" controls="controls"></audio>
                    
                    <a id="maskplay" onclick="processForm()" ><img id="maskplay" src="images/play0.png" width="35" height="35"/></a>
                    <div id="mask"></div>
                    </div>
                    <script type="text/javascript">
                    document.addEventListener("DOMContentLoaded", function(event)
                    {
                        document.getElementById('maskplay').style.display = 'block';
                        var match = navigator.userAgent.match(/Chrome\/(\d+)/);
                        if (match && parseInt(match[1]) >= 55) {
                            document.getElementById('mask').style.display = 'block';
                        }
                    });
                </script>

*/
