
<?php

# == работа с базовыми текстовыми разделами ====
# == версия 1.05 / 10.11.2018 (13.11.2018) ====

# == company, contacts, uslugi ==


# == index.php ==

    function del_txt($myid, $mainpath){
       unlink("../../".$mainpath."rec.".$myid);
    }

    function move_txt($myid, $mainpath, $txtid, $mover){

        if ($mover=="movedown"){
            $k=1;
        }
        
        if ($mover=="moveup"){
            $k=-1;
        }
        
        $start_down     = $_GET["start_down"];
        $dir_rec_down   = dir("../../".$mainpath);
        $i_down = 0;
        
        while($entry_down = $dir_rec_down->read()){
            if (substr($entry_down,0,3)=="rec"){
                $names_down[$i_down]=substr($entry_down,4);
                $i_down++;
            }}
        $dir_rec_down->close();
        @rsort($names_down);
        $count_down     = $i_down;
        $count1_down    = $count_down;
        $allnews_down   = 0;
       
    for ($i_down = 0; $i_down < $count_down; $i_down++){
    	
        $entry_down = $names_down[$i_down];
    	$data_down = file("../../".$mainpath."rec.".$entry_down);
    
		$msgid_down[$allnews_down]         = trim($data_down[0]);
    	$mtype_down[$allnews_down]         = trim($data_down[1]);
    	$razdel_down[$allnews_down]        = trim($data_down[2]);
		$zagolovok_down[$allnews_down]     = trim($data_down[3]);
    	$fulltext_down[$allnews_down]      = $data_down[4];
		$curdata_down[$allnews_down]       = trim($data_down[5]);
		$mycheck_down[$allnews_down]       = trim($data_down[6]);
	
		if ($razdel_down[$allnews_down]==$txtid){
			$allnews_down++;
		}}
//==========================================
		$tmp_msgid        = trim($msgid_down[$myid]);//текущее
    	$tmp_mtype        = trim($mtype_down[$myid]);
    	$tmp_razdel       = trim($razdel_down[$myid]);
		$tmp_zagolovok    = trim($zagolovok_down[$myid]);
    	$tmp_fulltext     = trim($fulltext_down[$myid]);
		$tmp_curdata      = trim($curdata_down[$myid]);
		$tmp_mycheck      = trim($mycheck_down[$myid]);

		$tmp2_msgid       = trim($msgid_down[$myid+$k]);//то что ниже 
    	$tmp2_mtype       = trim($mtype_down[$myid+$k]);
    	$tmp2_razdel      = trim($razdel_down[$myid+$k]);
		$tmp2_zagolovok   = trim($zagolovok_down[$myid+$k]);
    	$tmp2_fulltext    = trim($fulltext_down[$myid+$k]);
		$tmp2_curdata     = trim($curdata_down[$myid+$k]);
		$tmp2_mycheck     = trim($mycheck_down[$myid+$k]);
//==========================================
	    $infofile = "../../".$mainpath."rec.".$tmp2_msgid;
			
        $f=fopen($infofile, "w");
            fputs($f, "$tmp2_msgid\n");
            fputs($f, "$tmp_mtype\n");
            fputs($f, "$tmp_razdel\n");
            fputs($f, "$tmp_zagolovok\n");		
            fputs($f, "$tmp_fulltext\n");
            fputs($f, "$tmp_curdata\n");		
            fputs($f, "$tmp_mycheck\n");
        fclose($f);

        $infofile = "../../".$mainpath."rec.".$tmp_msgid;//zapisivaem current file
        $f=fopen($infofile, "w");
            fputs($f, "$tmp_msgid\n");
            fputs($f, "$tmp2_mtype\n");
            fputs($f, "$tmp2_razdel\n");
            fputs($f, "$tmp2_zagolovok\n");		
            fputs($f, "$tmp2_fulltext\n");
            fputs($f, "$tmp2_curdata\n");		
            fputs($f, "$tmp2_mycheck\n");
        fclose($f);
        
    }

    function start_read_txt($txtid,$mainpath,$pixpath){
      
            $dir_rec = dir("../../".$mainpath);
            $i = 0;
            while($entry = $dir_rec->read()){
                if (substr($entry,0,3)=="rec"){
                    $names[$i]=substr($entry,4);
                    $i++;
                }}
            $dir_rec->close();
            @rsort($names);
            
            $count      = $i;
            $count1     = $count;
            $allnews    = 0;

            for ($i = 0; $i < $count; $i++){
                $entry                  = $names[$i];
                $data                   = file("../../".$mainpath."rec.".$entry);

                $msgid[$allnews]        = trim($data[0]);
                $mtype[$allnews]        = trim($data[1]);
                $razdel[$allnews]       = trim($data[2]);
                $zagolovok[$allnews]    = trim($data[3]);
                $fulltext[$allnews]     = $data[4];
                $curdata[$allnews]      = trim($data[5]);
                $mycheck[$allnews]      = trim($data[6]);
	
                $fulltext[$allnews]     = ereg_replace("<br>","<br>&nbsp;&nbsp;&nbsp;&nbsp;",$fulltext[$allnews]);
                $fulltext[$allnews]     = ereg_replace($pixpath,"../../".$pixpath, $fulltext[$allnews]);

                if ($razdel[$allnews]==$txtid){
                    $allnews++;
                }
            
            }
	
            $maxlen=$allnews;
        
            return array("msgid"=>$msgid,
                         "mtype"=>$mtype,
                         "razdel"=>$razdel,
                         "zagolovok"=>$zagolovok,
                         "fulltext"=>$fulltext,
                         "curdata"=>$curdata,
                         "mycheck"=>$mycheck,
                         "maxlen"=>$allnews);
        
    }

    function switch_view_txt($myid, $mainpath){

        $data          = file("../../".$mainpath."rec.".$myid);
        $msgid         = trim($data[0]);
        $mtype         = trim($data[1]);
        $razdel        = trim($data[2]);
        $zagolovok     = trim($data[3]);
        $fulltext      = trim($data[4]);
        $curdata       = trim($data[5]);
        $mycheck       = trim($data[6]);

        if (trim($mycheck)=='on'){
            $mycheck = "";
        }else{
            $mycheck = "on";
        }

        $infofile="../../".$mainpath."rec.".$myid;

        $f=fopen($infofile, "w");
            fputs($f, "$msgid\n");      // id(time)
            fputs($f, "$mtype\n");      // type of info
            fputs($f, "$razdel\n");     // razdel
            fputs($f, "$zagolovok\n");  // zagolovok
            fputs($f, "$fulltext\n");   // fulltext
            fputs($f, "$curdata\n");    // curdata
            fputs($f, "$mycheck\n");    // mycheck
        fclose($f);
    }

# == addnews.php ==

    function read_txt($msgid_current, $mainpath){

        $data = file("../../".$mainpath."rec.".$msgid_current);

        $blocks = array("msgid"=>trim($data[0]),
                        "mtype"=>trim($data[1]),
                        "razdel"=>$data[2],
                        "zagolovok"=>ereg_replace("<br>","\n",$data[3]),
                        "fulltext"=>ereg_replace("<br>","\n",$data[4]),
                        "curdata"=>trim($data[5]),
                        "mycheck"=>$data[6]);
        return $blocks;
    }

    function save_txt($mainpath,$blocks){

            if (trim($blocks[msgid])==""){
                $blocks[msgid] = time();    
            }

            $infofile           = "../../".$mainpath."rec.".$blocks[msgid];

            $blocks[zagolovok]  = stripslashes(ereg_replace("\n","<br>",$blocks[zagolovok]));
            $blocks[fulltext]   = stripslashes(ereg_replace("\n","<br>",$blocks[fulltext]));

            $f=fopen($infofile, "w");
                fputs($f, "$blocks[msgid]\n");        //id(time)
                fputs($f, "$blocks[mtype]\n");        //type of info
                fputs($f, "$blocks[razdel]\n");       //razdel
                fputs($f, "$blocks[zagolovok]\n");    //zagolovok
                fputs($f, "$blocks[fulltext]\n");     //fulltext
                fputs($f, "$blocks[curdata]\n");      //curdata
                fputs($f, "$blocks[mycheck]\n");      //mycheck
            fclose($f);

            allclose();  
    }

    function allclose(){
        echo"<html>";
        echo"<head><title>Добавление...</title>";
        echo"<script languare='javascript'>";
        echo"top.opener.location.href = 'index.php'";
        echo"</script>";
        echo"</head>";
        echo"<body></body></html>";
        echo"<script languare='javascript'>";
        echo"window.close()";
        echo"</script>";
        exit();
    }
?>