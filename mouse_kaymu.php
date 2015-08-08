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

//$packtPage = curlGet('http://www.kaymu.com.np/dell-wireless-mouse-243549.html/?ref=[SHOP]-[NP-2015-30]-[CLA-TEA-2-PRO]#productDetails');
$packtPage = array();
$packtPage[0] = file_get_contents('/home/spontaneous/Desktop/kaymu.html', FILE_USE_INCLUDE_PATH);
$packtPage[1] = file_get_contents('/home/spontaneous/Desktop/kay2.html', FILE_USE_INCLUDE_PATH);
$packtPage[2] = file_get_contents('/home/spontaneous/Desktop/kay3.html', FILE_USE_INCLUDE_PATH);

cfor($x = 0; $x<3; $x++)
{
    $packtBook = array();

    $packtPageXPath = returnXPathObject($packtPage[$x]);

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
    $about = $packtPageXPath->query('//td[@class="attributeTitle"]');
    $about_value = $packtPageXPath->query('//td[@class="attributeValue"]');
    if ($about->length > 0 and $about_value->length >0) {
        for($i = 0; $i<$about->length; $i++)
        {
            $temp = trim($about->item($i)->nodeValue);
            $temp1 = trim($about_value->item($i)->nodeValue);
            $packtBook[$temp] = $temp1;
        }
    
    }

    $detail = $packtPageXPath->query('//div[@class="prd-description mbm"]');
    $details = array();
    // if ($detail->length > 0) {
    //     $packtBook['detail'] = trim($detail->item(0)->nodeValue);
    //     // $children = $detail->item(0)->childNodes;
    //     // $child1 = $children->item(1)->childNodes;
    //     // $child2 = $children->item(3)->childNodes;
    //     // for($i = 0; $i < $child1->length; $i++)
    //     //     $details[$i] = trim($child1->item($i)->nodeValue);
    //     // $packtBook['details'] = $details;
    //     // for($i = 0; $i < $child2->length; $i++)
    //     //     $features[$i] = trim($child2->item($i)->nodeValue);
    //     // $packtBook['features'] = $features;
    // }

    print_r($packtBook);
    //echo($packtBook["shiping"]);
}
?>
