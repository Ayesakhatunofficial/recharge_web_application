<?php
$host = '68.183.247.125';
$dbname = 'admin_recharge';
$username = 'root';
$password = 'Desuntech@2022';


$conn = mysqli_connect($host, $username, $password, $dbname);


if (!$conn) {

    echo ("Connection failed: " . mysqli_connect_error());
}

echo json_encode(['msg' => "Connected successfully"]);
