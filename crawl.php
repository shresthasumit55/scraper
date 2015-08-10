<?php
function returnXPathObject($item){
    $xmlPageDom = new DomDocument();
    @$xmlPageDom->loadHTML($item);
    $xmlPageXPath = new DOMXPath($xmlPageDom);
    return $xmlPageXPath;
}
$file = 'links.txt';
for($i=1;$i<98;$i++){
    $filename = '/home/spontaneous/Desktop/kaymu/mobile/page'.$i;
    
    $handle = fopen($filename,'r');
     $webPage = fread($handle, filesize($filename));
     //$webPage = file_get_contents($filename, FILE_USE_INCLUDE_PATH);
    $packtPageXPath = returnXPathObject($webPage);
    fclose($handle);    
    $anchor = $packtPageXPath->query('//*[@id="productsCatalog"]/div/div/a');
    if($anchor->length > 0) {
        for($j=0;$j<$anchor->length;$j++){
            $link = "http://www.kaymu.com.np".$anchor->item($j)->getAttribute('href')."\n";
            $handle = fopen('links.txt', 'a');
            fwrite($handle, $link);
            fclose($handle);
        }
    }
}
?>