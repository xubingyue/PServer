<?php
    require_once CORE_DIR . '/common/gzdecode.php';
    require_once CORE_DIR . '/common/line_fitting.php';
    
    $data = substr($_POST['data'], strpos($_POST['data'], "\n") + 1);
    $b64 = base64_decode($data);
    $xml_text = gzdecode($b64);
    $xml = simplexml_load_string($xml_text);
    $ret = array();
    $point = array();
    $id = 0;
    foreach($xml->Activities->Activity->Lap->Track as $track)
    {
        foreach($track->Trackpoint as $p)
        {            
            if(isset($p->Position->LatitudeDegrees) && isset($p->Position->LongitudeDegrees))
            {
                $point[0] = $id++;
                $point[1] = (float)$p->Position->LatitudeDegrees;
                $point[2] = (float)$p->Position->LongitudeDegrees;
                array_push($ret, $point);
            }
        }
    }

    
   
    $path = fix_line($ret, $_POST['minlat'], $_POST['maxlat'], $_POST['minlng'], $_POST['maxlng']);
    /*
    $fout = fopen("abc.txt", "w");
    fwrite($fout, json_encode($ret));
    fclose($fout);
    */
    
    //点需要处理一下， 不然太多了。
    echo json_encode($path); 
?>
