<?php

/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */


class PagesPngGenerator {
    //put your code here
    public function __construct()
    {
        $config = include('config/app.php');
        $this->data_path = $config['app_folder'].'/data/';
    }
    
    public function export_svg_to_png()
    {
        $src_fldr=$this->data_path.'pages/svg/';
            
        $dest_fldr=$this->data_path.'pages/png/';
        
        $conver_prog = '"C:\Program Files\Inkscape\inkscape.exe" ';
        //inkscape -z -e test.png -w 1024 -h 1024 test.svg
        
        for($i=1; $i<=604;$i++)
        {
            $name = str_pad($i, 3, '0', STR_PAD_LEFT);
                    
            $cmd= $conver_prog.' -z -e ' 
                    . $dest_fldr.$name.'.png '
                    . '-w 595 -h 842 -d 96 -C '
                    . $src_fldr.$name.'.svg ';
            
            //$output = exec($cmd);
            //echo '<pre>'.$output.'</pre>';
            echo '<pre>'.$cmd.'</pre>';
        }
    }
}
