<?php
function curlGet($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    $results = curl_exec($ch);
    curl_close($ch);
    return $results;
}
for($i = 1; $i <= 97  ; $i++)
{
    echo("downloading page".$i);
    $down = curlGet("http://www.kaymu.com.np/mobile-phones/?page=$i");
    file_put_contents("/home/spontaneous/Desktop/kaymu/mobile/page$i",$down);
    
}
?>
