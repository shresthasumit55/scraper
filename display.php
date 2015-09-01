<?php

require_once 'login.php';
$id= $_GET['id'];
$result= "SELECT * FROM `Products_kaymu` WHERE `id`=$id";
$run=mysql_query($result);
$row=mysql_fetch_row($run);
$num_rows=mysql_num_rows($run);

echo "Title: ". $row[1]."<br>";          		
echo "Price: ". $row[2]."<br>";
echo "Payment: ". $row[3]."<br>";
echo "Shipping Option: ". $row[4]."<br>";
echo "Bluetooth: ". $row[6]."<br>";
echo "Brand: ". $row[7]."<br>";
echo "Product Condition: ". $row[8]."<br>";
echo "Model: ". $row[9]."<br>";
echo "Weight: ". $row[10]."<br>";

?>