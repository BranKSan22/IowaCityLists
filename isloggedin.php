<?php
    //PHP that logs user out dependent on session variable 
    $isloggedin = false;
    $username = "not logged in";
    
    session_start();
    if (isset($_SESSION['username'])) {
        $isloggedin = true;
        $username = $_SESSION['username'];
        $account_id = $_SESSION['account_id'];
    }

    //Send response back
    $response = array();
    $response['status'] = 'success';
    $response['loggedin'] = $isloggedin;
    $response['username'] = $username;
    $response['account_id'] = $account_id;
    header('Content-Type: application/json');
    echo(json_encode($response));    
?>