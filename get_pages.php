<?php


require_once 'classes/chapter_info.php';
require_once 'classes/page_info.php';

ini_set("display_errors",true);
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

function Log_variable($name, $value)       
{
    //file_put_contents("log.html", "" . $name . '=' . $value .", ", FILE_APPEND);
}

function fn_get_pages($soura, $reciter, $tafseer, $from, $to, $repeat)
{         
    Log_variable('soura', $soura);
    Log_variable('reciter', $reciter);
    Log_variable('tafseer', $tafseer);
    Log_variable('from', $from);
    Log_variable('to', $to);
    Log_variable('repeat', $repeat);

    $pChapters = new CChapters();
    $pChapters->read_chapters_from_xml('data/chapters_details.xml');

    $pages_obj = new pages();
    $sura_pages_arry = $pChapters->get_verses_pages($soura, $from, $to);
    $pagesxml= new SimpleXMLElement( '<pages/>' );

    foreach($sura_pages_arry as $temp)
    {
        $page_info_obj = $pages_obj->get_final_page_by_number('data/pages/final_xml/', $temp->get_page_number());
        $page_info_obj->save2_page_to_final_xml($pagesxml, 'data/tafseer/'.$tafseer);
    }
    header('content-type: application/json; charset=utf-8');
    $buffer = $pagesxml->asXML();
    Log_variable('PAGES:', $buffer);
    return $buffer;
    
    }
 
if( isset($_GET['reciter']) )
{
    $soura = htmlentities($_GET['soura']);
    $reciter = htmlentities($_GET['reciter']);
    $tafseer = htmlentities($_GET['tafseer']);
    $from = htmlentities($_GET['from']);
    $to = htmlentities($_GET['to']);
    $repeat = htmlentities($_GET['repeat']);
    
    $buffer=fn_get_pages($soura, $reciter, $tafseer, $from, $to, $repeat);
    header('content-type: application/json; charset=utf-8');
    echo $buffer;
}
else if( isset($_GET['page_num']) )
{
    $page_num = htmlentities($_GET['page_num']);
    $tafseer = htmlentities($_GET['tafseer']);
    $pages_obj = new pages();
    $pagesxml= new SimpleXMLElement( '<pages/>' );

    $page_info_obj = $pages_obj->get_final_page_by_number('data/pages/final_xml/', $page_num);
    $page_info_obj->save2_page_to_final_xml($pagesxml, 'data/tafseer/'.$tafseer);
    
    header('content-type: application/json; charset=utf-8');
    $buffer = $pagesxml->asXML();
    Log_variable('PAGES:', $buffer);
    echo $buffer;
}
else if( isset($_GET['update_trans']) )
{
    $page_list = htmlentities($_GET['pages_list']);
    $tafseer = htmlentities($_GET['tafseer']);
    $pages_array = explode( ',', $page_list);
    
    $pages_obj = new pages();
    $pagesxml= new SimpleXMLElement( '<pages/>' );

    //for each page in pages list do:
    for($i=0;$i<count($pages_array);$i++)
    {
        $page_info_obj = $pages_obj->get_final_page_by_number('data/pages/final_xml/', $pages_array[$i]);
        $page_info_obj->save2_page_to_final_xml($pagesxml, 'data/tafseer/'.$tafseer);
    }
    header('content-type: application/json; charset=utf-8');
    $buffer = $pagesxml->asXML();
    Log_variable('PAGES:', $buffer);
    echo $buffer;
}
 else 
{
     $page_list = htmlentities('%5B1%5D');
    $tafseer = htmlentities('ar.jalalayn.xml');
    $pages_array = explode( ',', $page_list);
    
    $pages_obj = new pages();

    $pagesxml= new SimpleXMLElement( '<pages/>' );

    //for each page in pages list do:
    for($i=0;$i<count($pages_array);$i++)
    {
        $page_info_obj = $pages_obj->get_final_page_by_number('data/pages/final_xml/', $pages_array[$i]);
        $page_info_obj->save2_page_to_final_xml($pagesxml, 'data/tafseer/'.$tafseer);
    }
    header('content-type: application/json; charset=utf-8');
    $buffer = $pagesxml->asXML();
    Log_variable('PAGES:', $buffer);
    echo $buffer;
 }        
?>
