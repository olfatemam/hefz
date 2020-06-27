<?php


require_once 'Controllers/PageController.php';


ini_set("display_errors",true);
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);


return (new PageController())->Process_request();
    
?>
