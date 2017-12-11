<?php
include_once('config.php');
include_once('dbutils.php');

//Gets information from current list
session_start();
    if (isset($_SESSION['listid'])) {
        $listid = $_SESSION['listid'];
        $response = array();
        $response['status'] = 'success';
        $response['listid'] = $listid;
        header('Content-Type: application/json');
        echo(json_encode($response));    
    } else {
        $response = array();
        $response['status'] = 'error';
        header('Content-Type: application/json');
        echo(json_encode($response));
    }



?>