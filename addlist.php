<?php

        //Collects data from the Form 
        $data = json_decode(file_get_contents('php://input'), true);
        $listid = $data['id'];
        
        //New session variable - that will add to the list       
        session_start();
        $_SESSION['listid'] = $listid;
        
        //Get the dbtuils and config.php
        include_once('config.php');
        include_once('dbutils.php');

        //Get the $db object
        $db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);
                
        $isComplete = true;                
                
        if(!isset($listid)) {
            $isComplete = false;
        }
        
        if ($isComplete) {
            $query = "SELECT template_id FROM list WHERE id = $listid";
    
            //Run the query
            $result = queryDB($query, $db);
        
            $row = nextTuple($result);
            
            $_SESSION['template_id'] = $row['template_id'];
            

    //Send response back
    $response = array();
    $response['status'] = 'success';
    header('Content-Type: application/json');
    echo(json_encode($response));
        
} else {
    ob_start();
    var_dump($data);
    $postdump = ob_get_clean();

    $response = array();
    $response['status'] = 'error';
    $response['message'] = $errorMessage . $postdump;
    header('Content-Type: application/json');
    echo(json_encode($response));
}

?>
        