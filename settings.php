<!DOCTYPE html>
<!--
/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
﻿<?php

require_once 'classes/quran_info_generator.php';
require_once 'classes/png_generator.php';

?>
    </head>
    <body>
        <form action="settings.php" method="post">
            <input type="submit" name="Action"  value="GenerateIndexes" >
            <input type="submit" name="Action"  value="GeneratePngPages" >
            <input type="submit" name="Action"  value="clear_cache" >
                <?php
        
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $data_path= 'data/';
        switch ($_POST['Action'])
        {
            case 'GenerateIndexes':
                ini_set('max_execution_time', 600); 
                $obj = new quran_info_generator($data_path);
                $obj->setup_indexes();
                echo 'done!';
            break;

            case 'GeneratePngPages':
                ini_set('max_execution_time', 600); 
                $obj = new png_generator($data_path);
                $obj->export_svg_to_png();
                echo 'done!';
            break;
        
        case 'clear_cache':
            apcu_clear_cache();
            break;
        }
    }
    else 
    {
    }
?>
 
</form>
    </body>
</html>
