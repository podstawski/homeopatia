<?php

    include __DIR__ .'/fun.php';

    $book_name='MATERIA MEDICA - By William BOERICKE';
    
    $book=new bookModel();
    $book->find_one_by_name($book_name);
    if (!$book->id)
    $book->name=$book_name;
    $book->author='William Boericke';
    $book->save();

    $url='http://homeoint.org/books/boericmm/remedies.htm';
    $html=url_get($url);

    $html=fromtxt2txt($html,'Presented by Médi-T','Copyright');
    
    $a=[];
    $urls=[];
    
    if (preg_match_all('~<a href="([^"]+)"[^>]*>([^<]+)</a> ------&gt; ([^<]+)<~',$html,$a))
    {
        

        foreach($a[1] AS $i=>$href)
        {
            if (strstr($href,'..')) continue;
            $url2=dirname($url).'/'.$href;
            //if ($pos=strpos($url2,'#')) $url2=substr($url2,0,$pos);
            //if (isset($urls[$url2])) continue;
            //$urls[$url2]=true;
            
            $remedium_name=strtolower(trim($a[3][$i]));
            $remedium_abbr=strtolower(trim($a[2][$i]));
            $remedium_name=preg_replace('/\s+/',' ',$remedium_name);
            
            echo "$remedium_abbr ($remedium_name) ... $url2\n";
            
            $remedium=new remediumModel();
            
            if (!$remedium->find_one_by_name($remedium_name))
            {
                $remedium->name=$remedium_name;
                $remedium->abbreviation=$remedium_abbr;
                $remedium->save();
            }
            
            $html=url_get($url2);
            $html=str_replace(['ć','Ć'],['e','AE'],$html);
            
            $b=[];
            if (preg_match_all('~<p align="justify">(.+?)</p>~si',$html,$b))
            {
                foreach ($b[1] AS $h)
                {
                    $h=unhtml($h);
                    $h=explode('.--',$h);
                    
                    if (count($h)==1) {
                        $desc=new descModel();
                        $d=$desc->find_on_desc($h[0],'en',$book->id,$remedium->id);
                    
                        if (!$d) $desc->add($h[0],'en',$book->id,$remedium->id);
                    }
                    
                    //echo "$h \n\n";
                }
                
                
            }
            break;
        }
     
        
    }

        

    
   