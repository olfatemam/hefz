<!DOCTYPE html>
<?php

/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */

require_once 'Controllers/MainPageController.php';
ini_set("display_errors",true);
$main_page = new MainPageController();        
echo $main_page->generate(TOP_BANNER);
?>

<script>
    load_default();
</script>
