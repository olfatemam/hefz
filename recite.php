<?php
/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */

function __autoload($class_name) {
  require_once 'classes/versesaudio.php';
}

if( isset($_GET['reciter']) )
{
    //be sure to validate and clean your variables
    $reciter = htmlentities($_GET['reciter']);
    $soura = htmlentities($_GET['soura']);
    $from = htmlentities($_GET['from']);
    $to = htmlentities($_GET['to']);
    $repeat = htmlentities($_GET['repeat']);

    $hefzverses = new VersesAudio($reciter, $soura, $from, $to, $repeat);
    $hefzverses->send_file();
}
else
{
    $hefzverses = new VersesAudio();
    $hefzverses->send_file();
}
 ?>