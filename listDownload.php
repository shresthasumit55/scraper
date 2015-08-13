// downloading product pages
<?php
function returnXPathObject($item){
    $xmlPageDom = new DomDocument();
    @$xmlPageDom->loadHTML($item);
    $xmlPageXPath = new DOMXPath($xmlPageDom);
    return $xmlPageXPath;
}
function curlGet($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    $results = curl_exec($ch);
    curl_close($ch);
    return $results;
}

$file = 'links.txt';
$handle = fopen($file,"r");
$i = 1;
// while(!feof($handle))
while($i != 3104)
{
    if($i<100){
        $link = fgets($handle);
        $i++;
        continue;
    }
    echo "downloading file".$i."\n";
    $link = fgets($handle);
    $link = str_replace("\n","",$link);
    $link = str_replace("\r","",$link);
    echo $link."\n";
    $down = curlGet($link);
    file_put_contents("/home/spontaneous/Desktop/kaymu/mob/page$i",$down);
    $i++;
}
?>
