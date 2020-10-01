<?php 


if (!empty($_POST["list"])) {
    $list = $_POST["list"];
    $arr = explode("\n", $list);
    $hitung = count($arr);
    
    function ceker ($proxy){
        $url = 'https://ouo.io/rvgXSt';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
        //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); //wait konek
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
        $curl_scraped_page = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($curl_scraped_page, 0, $header_size);
        $body = substr($curl_scraped_page, $header_size);

        $split = $body;
        // $split = substr($body,0,255);

        curl_close($ch);

        return strval($split);
    }
    $proxy_result = array();

    // for ($i=0; $i < $hitung; $i++) { 
    foreach ($arr as $proxy) {
        
        // set_time_limit(10);
        ignore_user_abort(true);
        // $proxy = $arr[$i];

        $hasil = ceker($proxy);
        $posisi=strpos($hasil,"Earn money on short links");

        if ($posisi){
          array_push($proxy_result,$proxy);

        }
    }
    // }
    $conver_str =  implode(', ', $proxy_result);
    $output = str_replace(',', '\n', $conver_str);
    echo '<textarea name="" id="" cols="30" rows="10">'.$output.'</textarea>';
    

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
    <form action="" method="post">
        <textarea name="list" id="" cols="50" rows="10"></textarea>
        <br><button type="submit">PROSES</button>
    </form>
    <br>
    <p>Hasil</p>
    <textarea name="hasil" id="" cols="50" rows="10"></textarea>
</body>
</html>