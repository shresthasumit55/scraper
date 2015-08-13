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
// sql to create table
$sql = "CREATE TABLE Products (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(255) NOT NULL,
price VARCHAR(20) NOT NULL,
payment VARCHAR(50),
shippingOpt VARCHAR(50),
shippingTime VARCHAR(50),
bluetooth VARCHAR(20),
brand VARCHAR(20),
prdCondition VARCHAR(20),
model VARCHAR(50),
weight VARCHAR(20),
reg_date TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Table Products created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
$conn->close();
?> 