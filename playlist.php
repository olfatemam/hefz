<?php

/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */

header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");


require_once 'Controllers/AudioController.php';

$hefzverses = new AudioController();
$hefzverses->send_file_array('');

 ?>