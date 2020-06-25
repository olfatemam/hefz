<?php

/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */

class VersesAudio
{
    private $reciter="";
    private $soura=0;
    private $from=0;
    private $to=0;
    private $repeat=0;
    private $reciter_folder="";

    public function __construct($reciter, $nsoura, $nfrom_verse, $nto_verse, $nrepeat=1)
    {
        $this->soura     =   $nsoura;
        $this->from      =   $nfrom_verse;
        $this->to        =   $nto_verse;
        $this->repeat    =   $nrepeat;
        $this->reciter   =   $reciter;//str_pad(intval($reciter), 3, '0', STR_PAD_LEFT);
        
        //$path = $GLOBALS['IHFAZ_HOME'];
        $path =$_SERVER['SERVER_NAME'];
        
        if ($path == 'localhost')
            $path= 'http://'.$path.'/hefz/php';
        else 
            $path= $path. '/hifz/eApp';
        
        $this->reciter_folder='sounds/'.$this->reciter.'/';
/*        
        file_put_contents("mylog.log", '\r\n new        sura, from, to, repat, reciter='.
        $this->soura     .','.
        $this->from      .','.
        $this->to        .','.
        $this->repeat    .','.
        $this->reciter   .','
        .'\r\n', FILE_APPEND );
  */
     }

    public function __destruct(){}
    

    
    function send_file_array($root)
    {
        set_time_limit(0);
        $bitrate = 128;
        //header('Content-type: audio/mpeg');
        //header ("Content-Transfer-Encoding: binary");
        //header ("Pragma: no-cache");
        //header ("icy-br: " . $bitrate);
        
        echo $this->get_audiofiles($root);
     }

    function send_file()
    {
        set_time_limit(0);
        $bitrate = 128;
        header('Content-type: audio/mpeg');
        header ("Content-Transfer-Encoding: binary");
        header ("Pragma: no-cache");
        header ("icy-br: " . $bitrate);
        
        echo $this->get_audiofiles_content();
     }
     
    private function get_audiofiles($rooturl)
    {
            //file_put_contents("mylog.log", '');
        //$files_pathes = $this->add_prefix_paths();
        $files_pathes='';
        for ($index = $this->from; $index <= $this->to; $index++)
        {
            $temp = $rooturl.$this->get_verse_url($index);
            //file_put_contents("mylog.log", 'index, file'.$index.$temp.'\r\n', FILE_APPEND );
            if($index>$this->from)
            {
                $files_pathes = $files_pathes .',';
            }
            $files_pathes = $files_pathes.$temp;//.'::'.$index;
        }
        return $files_pathes;
    }
    
    
    private function get_audiofiles_content()
    {
        $filescontent = $this->add_prefix();

        for ($index = $this->from; $index <= $this->to; $index++)
        {
            $fcontent = file_get_contents($this->get_verse_path($index));
            
            if ($this->soura ==1 &&$index==1)
            {
                $filescontent=$filescontent.$fcontent;
            }
            else
            {
                for ($j=0;$j<$this->repeat;$j++)
                {
                    $filescontent=$filescontent.$fcontent;
                }
            }
        }
        return $filescontent;
    }

    private function soura_file_name()
    {
        return str_pad($this->soura, 3, '0', STR_PAD_LEFT);
    }

    private function get_verse_url($index)
    {
        $soura_str=$this->soura_file_name();

        $verse_str= str_pad($index, 3, '0', STR_PAD_LEFT);
        
        $versefile= $this->reciter_folder.$soura_str.$verse_str.".mp3";   
        
        //file_put_contents("mylog.log", $versefile."\r\n", FILE_APPEND );

        return $versefile;
    }

    private function get_verse_path($index)
    {
        $soura_str=$this->soura_file_name();

        $verse_str= str_pad($index, 3, '0', STR_PAD_LEFT);
        
        $versefile= $this->reciter_folder.$soura_str.$verse_str.".mp3";   
        
        //file_put_contents("mylog.log", $versefile."\r\n", FILE_APPEND );

        return $versefile;
    }
    
    private function add_prefix()
    {
        $filescontent=file_get_contents($this->reciter_folder."000000.mp3");//Este3aza
        $filescontent=$filescontent.file_get_contents($this->reciter_folder."001001.mp3");
        return $filescontent;
    }


 }; 


?>