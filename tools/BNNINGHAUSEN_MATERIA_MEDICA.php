<?php

    include __DIR__ .'/fun.php';

        

    $url='http://homeoint.org/books2/boenchar/mmpsorhu.htm';
    $html=url_get($url);

    $html=fromtxt2txt($html,'Presented by Médi-T','Copyright');
    
    $a=[];
    $urls=[];
    
    die();
    
    if (preg_match_all('~<a href="([^"]+)"[^>]*>([^<]+)</a> ------&gt; ([^<]+)<~',$html,$a))
    {
        

        foreach($a[1] AS $i=>$href)
        {
            if (strstr($href,'..')) continue;
            $url2=dirname($url).'/'.$href;
            //if ($pos=strpos($url2,'#')) $url2=substr($url2,0,$pos);
            //if (isset($urls[$url2])) continue;
            //$urls[$url2]=true;
            
            echo $a[2][$i]." ... $url2\n";
            $html=url_get($url2);
        }
     
        
    }

        

    
   