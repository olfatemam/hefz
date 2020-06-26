<!DOCTYPE html>
<?php

/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */

require_once 'classes/mp_generator.php';
ini_set("display_errors",true);
$some_var = new mp_generator();        
echo $some_var->generate(TOP_BANNER);
?>

<script>
    load_default();
</script>
