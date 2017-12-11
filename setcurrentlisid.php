<?php

 //Collect data from FORM
 //value sends to correct webpage
 //New session variable 
        $data = json_decode(file_get_contents('php://input'), true);
        $listid = $data['listid'];
        $value = $data['value']; 
        session_start();
        $_SESSION['listid']=$listid;
        
        //Send response back
        $response = array();
        $response['status'] = 'success';
        header('Content-Type: application/json');
        echo(json_encode($response));
?>