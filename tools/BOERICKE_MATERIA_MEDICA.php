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
            
            if(isset($argv[1]) && $argv[1]!=$remedium_abbr) continue;
            
            
            echo "$remedium_abbr ($remedium_name) ... $url2\n";
            
            $remedium=new remediumModel();
            
            if (!$remedium->find_one_by_name($remedium_name))
            {
                $remedium->name=$remedium_name;
                $remedium->abbreviation=$remedium_abbr;
                $remedium->save();
            }
            
            $html=url_get($url2);
            $html=iconv('iso8859-2','utf-8',$html);
            
            $html=str_replace(['ć','Ć',''],['e','AE','e'],$html);
            
            
            $b=[];
            if (preg_match_all('~<p align="justify">(.+?)</p>~si',$html,$b))
            {
                foreach ($b[1] AS $h)
                {
                    $h=unhtml($h);
                    $h=explode('.--',$h);
                    
                    if (count($h)==1) {
                        $desc=new descModel();
                        $d=$desc->find('en',$book->id,$remedium->id);
                    
                        if (!$d) $desc->add($h[0],'en',$book->id,$remedium->id);
                        else {
                            $dict=new dictModel($d);
                            $dict->body = $h[0];
                            $dict->save();
                            
                        }
                    }
                    
                    
                    if (count($h)==2) {
                    
                        $complaint=new complaintModel();
                        $complaint_name=strtolower($h[0]);
                        if (strlen($complaint_name)>25) mydie($complaint_name);
                        switch ($complaint_name)
                        {
                            case 'relationship':
                                break;
                            case 'dose':
                                break;
                            
                            case 'modalities':
                                foreach (explode('.',$h[1]) AS $modal)
                                {
                                    $modal=trim($modal);
                                    $mod='';
                                    if (strtolower(substr($modal,0,5))=='worse')
                                    {
                                        $modal=trim(substr($modal,5));
                                        $mod='W';
                                    }
                                    if (strtolower(substr($modal,0,6))=='better')
                                    {
                                        $modal=trim(substr($modal,6));
                                        $mod='B';
                                    }
                                   
                                    
                                    if ($mod && $modal) {
                                        while (in_array($modal[0],[',',';'])) $modal=trim(substr($modal,1));
                                        $modality=new modalityModel();
                                        $m=$modality->find('en',$modal,$book->id,$remedium->id);
                                        if (!$m) {
                                            $m=$modality->add($modal,$mod,'en',$book->id,$remedium->id);
                                            
                                        }
                                    }
                                }
                                break;
                            
                            default:
                                
                                $c=$complaint->find('en',$complaint_name);
                                if (!$c) {
                                    $complaint->add($complaint_name,'en');
                                    $c=$complaint->find('en',$complaint_name);
                                }
                                foreach (explode('.',$h[1]) AS $comp)
                                {
                                    $comp=trim($comp);
                                    if (!strlen($comp)) continue;
                                    $c1=$complaint->find('en',$comp,$c['table_id']);
                                    
                                    if (!$c1) {
                                        $c1=$complaint->add($comp,'en',$c['table_id']);
                                    }
                                    $rc=new rcModel();
                                    if (!$rc->find($c1['table_id'],$book->id,$remedium->id)) {
                                        $rc->complaint_id=$c1['table_id'];
                                        $rc->book_id=$book->id;
                                        $rc->remedium_id=$remedium->id;
                                        $rc->save();
                                    
                                    }
                                }
                                

                                
                                break;
                                
                        }
                    }
                    
                    //echo "$h \n\n";
                }
                
                
            }
            if ($i>=50) break;
        }
     
        
    }

        

    
   