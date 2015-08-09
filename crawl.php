<?php
function curlGet($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    $results = curl_exec($ch);
    curl_close($ch);
    return $results;
}

function returnXPathObject($item){
    $xmlPageDom = new DomDocument();
    @$xmlPageDom->loadHTML($item);
    $xmlPageXPath = new DOMXPath($xmlPageDom);
    return $xmlPageXPath;
}

$packtPage = file_get_contents('/home/spontaneous/Desktop/kaymu/file1', FILE_USE_INCLUDE_PATH);

$packtBook = array();

$packtPageXPath = returnXPathObject($packtPage);

$shiping = $packtPageXPath->query('//*[@id="productsCatalog"]/div/div/a');
if ($shiping->length > 0) {
    for($i=0;$i<$shiping->length;$i++){
        echo($shiping->item($i)->getAttribute('href')."\n");
    }
}
?>
 