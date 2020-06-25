<?php

/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */

header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");

$GLOBALS['IHFAZ_HOME'] = getcwd();

function __autoload($class_name) {
  require_once 'classes/versesaudio.php';
}
    $reciter = "000";
    $soura = 2;
    $from = 1;
    $to = 3;
    $repeat =1;

if( isset($_GET['reciter']) )
{
    //be sure to validate and clean your variables
    $reciter = htmlentities($_GET['reciter']);
    $soura = htmlentities($_GET['soura']);
    $from = htmlentities($_GET['from']);
    $to = htmlentities($_GET['to']);
    $repeat = htmlentities($_GET['repeat']);

    $hefzverses = new VersesAudio($reciter, $soura, $from, $to, $repeat);
    $hefzverses->send_file_array('');
}
else
{
    //print_r($_SERVER['QUERY_STRING']);
    
    $hefzverses = new VersesAudio($reciter, $soura, $from, $to, $repeat);
    $hefzverses->send_file_array('');
}
 ?>