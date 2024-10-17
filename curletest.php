<?php

$url = "https://jsonplaceholder.typicode.com/posts";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

if ($httpcode === 200) {
    echo "Success! Received data: " . $output;
} else {
    echo "Error! HTTP code: " . $httpcode;
}

?>