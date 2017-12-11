<?php
include_once('config.php');
include_once('dbutils.php');

    $data =json_decode(file_get_contents('php://input'), true);
    //$count = $data['voteCount'];
    $votes =$data['votes'];
    $list_id =$data['list_id'];
    //Connect to database
    $db = connectDB($DBHost, $DBUser,$DBPassword,$DBName);
    //Variable that keeps track of whether the form was complete
    $isComplete = true;
    //Error message
    $errorMessage = "";
    session_start();
    $account_id = $_SESSION['account_id'];
 
    $voted = false;
    //Checks if user already voted on the list
    if($isComplete){
    //Selects from table entry by user
         $query ="SELECT * FROM votes WHERE account_id=$session_id AND list_id=$id";
    //Run statement
        $result = queryDB($query, $db);
        //If duplicate dont allow them to revote 
        if(nTuples($result) > 0){

            $row = nextTuple($result);
            $votes = $row['votes'];
            if ($votes == 1) {
                $isComplete = false;
                $errorMessage .= "You already voted on this list";
             } else {
                $voted = true;
            }
        }
    }
    //If working, create an insert statement
    if ($isComplete){

        if (!$voted) {
            $query = "INSERT INTO votes(list_id,votes,account_id) VALUES ($list_id,+1,$account_id)";
        } else {
          //Update vote  
            $query="UPDATE votes SET votes = votes + 1 WHERE list_id=$list_id";
        }
          //Run insert statement
        $result = queryDB($query,$db);
         //Update list with new increment 
        $query = "UPDATE list SET votes+1 WHERE id=$id";
        //Run insert statement
        $result = queryDB($query,$db);
        //Send a response back 
        $response =array();
        $response['status'] = 'success';
        $response['id'] = $id;
        header('Content-Type: application/json');
        echo(json_encode($response));
    } else{
        //Error message if failed 
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