<?php
    //PHP that logs user out 
    //destorys session variable
    session_start();
    if (isset($_SESSION['username'])) {
        unset($_SESSION['username']);
    }
    session_destroy();
    
    //Send response back
    $response = array();
    $response['status'] = 'success';
    header('Content-Type: application/json');
    echo(json_encode($response));    
?>