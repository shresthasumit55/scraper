<?php
function curlGet($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    $results = curl_exec($ch);
    curl_close($ch);
    return $results;
}
//$packtPage = curlGet('http://www.kaymu.com.np/dell-wireless-mouse-243549.html/?ref=[SHOP]-[NP-2015-30]-[CLA-TEA-2-PRO]#productDetails');
$packtPage = file_get_contents('/home/spontaneous/Desktop/kaymu.html', FILE_USE_INCLUDE_PATH);
$packtBook = array();

function returnXPathObject($item){
    $xmlPageDom = new DomDocument();
    @$xmlPageDom->loadHTML($item);
    $xmlPageXPath = new DOMXPath($xmlPageDom);
    return $xmlPageXPath;
}
$packtPageXPath = returnXPathObject($packtPage);

$title = $packtPageXPath->query('//span[@class="prd-title"]');
if($title->length > 0){
    $packtBook['title'] = trim($title->item(0)->nodeValue);
}
//$price = $packtPageXPath->query('//span[@id="price_box"]');
$price = $packtPageXPath->query('//*[@id="price_box"]');
if ($price->length > 0) {
    //$packtBook['price'] = trim($overview->item(0)->nodeValue);
    $packtBook['price'] = trim($price->item(0)->nodeValue);
}
$details = $packtPageXPath->query('//div[@class="prd-description mbm"]');
if ($details->length > 0) {
    
    $packtBook['details'] = trim($details->item(0)->nodeValue);
}
$shiping = $packtPageXPath->query('//div[@class="boxAttribute rtl-right"]');
if ($shiping->length > 0) {
    for($i = 0; $i < $shiping->length-1; $i++)
    {
        $children = $shiping->item($i)->childNodes;
        $ship = trim($children->item(1)->nodeValue);
        $method = trim($children->item(3)->nodeValue);
        $packtBook[$ship] = $method;
    }
}
print_r($packtBook);
//echo($packtBook["shiping"]);
?>
