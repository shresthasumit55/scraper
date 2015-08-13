<?php
$servername = "localhost";
$username = "root";
$password = "semanta";
$dbname = "myDB";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

// prepare and bind
$stmt = $conn->prepare("INSERT INTO Products (title, price, payment, shippingOpt, shippingTime, bluetooth, brand, prdCondition, model, weight) VALUES (?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("ssssssssss", $titledb, $pricedb, $paymentdb, $shippingOptdb, $shippingTimedb,$bluetoothdb, $branddb, $prdConditiondb, $modeldb, $weightdb);

for($x = 1; $x<100; $x++)
{
    $productPage = file_get_contents("/home/spontaneous/Desktop/kaymu/mob/page$x");
    $products = array();

    $productPageXPath = returnXPathObject($productPage);

    $title = $productPageXPath->query('//span[@class="prd-title"]');
    if($title->length > 0){
        $products['title'] = trim($title->item(0)->nodeValue);
    }
    //$price = $packtPageXPath->query('//span[@id="price_box"]');
    $price = $productPageXPath->query('//*[@id="price_box"]');
    if ($price->length > 0) {
        //$packtBook['price'] = trim($overview->item(0)->nodeValue);
        $products['price'] = trim($price->item(0)->nodeValue);
    }

    $shiping = $productPageXPath->query('//div[@class="boxAttribute rtl-right"]');
    if ($shiping->length > 0) {
        for($i = 0; $i < $shiping->length-1; $i++)
        {
            $children = $shiping->item($i)->childNodes;
            $ship = trim($children->item(1)->nodeValue);
            $method = trim($children->item(3)->nodeValue);
            $products[$ship] = $method;
        }
    }
    $about = $productPageXPath->query('//td[@class="attributeTitle"]');
    $about_value = $productPageXPath->query('//td[@class="attributeValue"]');
    if ($about->length > 0 and $about_value->length >0) {
        for($i = 0; $i<$about->length; $i++)
        {
            $temp = trim($about->item($i)->nodeValue);
            $temp = preg_replace('/\s+/','',$temp);//removing excess whitespaces
            $temp1 = trim($about_value->item($i)->nodeValue);
            $products[$temp] = $temp1;
        }
    
    }

    $detail = $productPageXPath->query('//div[@class="prd-description mbm"]');
    $details = array();
    // if ($detail->length > 0) {
    //     $packtBook['detail'] = trim($detail->item(0)->nodeValue);
    //     // $children = $detail->item(0)->childNodes;
    //     // $child1 = $children->item(1)->childNodes;
    //     // $child2 = $children->item(3)->childNodes;
    //     // for($i = 0; $i < $child1->length; $i++)
    //     //     $details[$i] = trim($child1->item($i)->nodeValue);
    //     // $products['details'] = $details;
    //     // for($i = 0; $i < $child2->length; $i++)
    //     //     $features[$i] = trim($child2->item($i)->nodeValue);
    //     // $products['features'] = $features;
    // }

    print_r($products);
    $titledb = $products['title'];
    $pricedb = $products['price'];
    $paymentdb = $products['Payment options:'];
    $shippingOptdb = $products['Shipping options:'];
    $shippingTimedb = $products['Shipment time:'];
    $bluetoothdb = $products['Bluetooth:'];
    $branddb = $products['Brand:'];
    $prdConditiondb = $products['Condition:'];
    $modeldb = $products['Model:'];
    $weightdb = $products['Weight:'];
    $stmt->execute();
        
    
    
    //echo($packtBook["shiping"]);
}
$stmt->close();
$conn->close();
?>
