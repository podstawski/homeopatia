<?php

    include __DIR__ .'/fun.php';

        

    $url='http://homeoint.org/books4/boerirep/index.htm';
    $html=url_get($url);

    $html=fromtxt2txt($html,'Presented by Médi-T','Copyright');
    
    $a=[];
    $urls=[];
    
    if (preg_match_all('~<a href="([^"]+)"~',$html,$a))
    {
        foreach($a[1] AS $href)
        {
            if (strstr($href,'..')) continue;
            $url2=dirname($url).'/'.$href;
            if ($pos=strpos($url2,'#')) $url2=substr($url2,0,$pos);
            if (isset($urls[$url2])) continue;
            $urls[$url2]=true;
            $html=url_get($url2);
        }
     
        
    }

        

    
   