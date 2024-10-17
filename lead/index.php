<?php

require_once('config/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    print_r($_POST);
    die;

    $json_data = file_get_contents('php://input');
}
