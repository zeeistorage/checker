<?php 


if (!empty($_POST["list"])) {
    $list = trim($_POST["list"]);
    $arr = explode("\n", $list);
    $hitung = count($arr);

    $thread = trim($hitung);
    $timeout = 20;
    
    set_time_limit(0);
/***********************************************
* Multithreaded Proxy Checker
* Coded by Miyachung
* Janissaries.Org
* Miyachung@hotmail.com
------------------------------------------------
* Demonstration -> http://www.youtube.com/watch?v=4icPZHv3W9g
* Type list like IP:PORT in a file
***********************************************/

/*-----------------------------------------------------------------------*/
	// echo "\n[+]Enter your proxy list: ";
	$proxy_list = $list;
	$proxy_list = str_replace("\r\n","",$proxy_list);
	$proxy_list = trim($proxy_list);

	// echo "[+]Enter number of thread: ";
	$thread = $hitung;
	$thread = str_replace("\r\n","",$thread);
	$thread = trim($thread);
	// echo "[+]Enter timeout sec: ";
	$timeout = 20;
	$timeout = str_replace("\r\n","",$timeout);
	$timeout = trim($timeout);
	// echo "[+]Checking proxies\n";
	// echo "-------------------------------------------------------\n";
	// $open_file	=	file($proxy_list);
	// $open_file  =	preg_replace("#\r\n#si","",$list);
    // echo $arr;
	// die();
    /*-----------------------------------------------------------------------*/
    function checker($ips,$thread)
    {
        global $timeout;
        
        $multi 	= curl_multi_init();
        $ips 	= array_chunk($ips,$thread);
        $total 	= 0;
        $time1  = time();
        $proxy_result = array();
            foreach($ips as $ip)
            {
                for ($i=0; $i < $thread; $i++) { 
                    $proxy_aktif = $ip[$i];
                // }
                // die();
                // for($i=0;$i<=count($ip)-1;$i++)
                // {
                $curl[$i] = curl_init();
                curl_setopt($curl[$i],CURLOPT_RETURNTRANSFER,1);
                curl_setopt($curl[$i],CURLOPT_SSL_VERIFYHOST,0);
                curl_setopt($curl[$i],CURLOPT_SSL_VERIFYPEER,0);
                curl_setopt($curl[$i],CURLOPT_URL,"https://ouo.io/rvgXSt");
                curl_setopt($curl[$i],CURLOPT_PROXY,$proxy_aktif);
                curl_setopt($curl[$i],CURLOPT_TIMEOUT,$timeout);
                curl_multi_add_handle($multi,$curl[$i]);
                }
                
                do
                {
                curl_multi_exec($multi,$active);
                usleep(11);
                }while( $active > 0 );
                
                foreach($curl as $cid => $cend)
                {
                    $con[$cid] = curl_multi_getcontent($cend);
                    // echo var_dump($con[$cid]);
                    $hasil = $con[$cid];
                    $posisi=strpos($hasil,"Earn money on short links");
                    
                    curl_multi_remove_handle($multi,$cend);
                        if ($posisi){
                            array_push($proxy_result,$ip[$cid]);
                            $total++;                        
                        }
                    // die();
                    // if(preg_match('Earn money on short links',$con[$cid]))
                    // {
                    //     $total++;
                    //     echo "[~]Proxy works -> ".$ip[$cid]."\n";
                    //     save_file("works.txt",$ip[$cid]);
                    // }
                }
            }
        $time2 = time();
        $conver_str =  trim(implode(',', $proxy_result));
        $output = trim(str_replace(',','',trim($conver_str)))."\n";
        $filter = str_replace('\n','',$output);
        echo '<textarea name="" id="" cols="30" rows="10">'.$filter.'</textarea><br>';
        // echo $output;
        echo "\n[+]Total working proxies: $total,checking completed<br>";
        echo "[+]Elapsed time -> ".($time2-$time1)." seconds<br>";
        
    }
    

    checker($arr,$thread);
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="test.php" method="post">
        <textarea name="list" id="" cols="50" rows="10"></textarea>
        <br><button type="submit">PROSES</button>
    </form>
    <br>
    <p>Hasil</p>
    <textarea name="hasil" id="" cols="50" rows="10"></textarea>
</body>
</html>