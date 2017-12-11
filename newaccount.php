<?php
    include_once('config.php');
    include_once('dbutils.php');
    
    //Collects data from the Form (username, password, email, type of member )
    $data = json_decode(file_get_contents('php://input'), true);
    $username = $data['username'];
	$password = $data['password'];
	$password2 = $data['password2'];
	$email = $data['email'];
	$location = $data['location'];
    
   //Connect to the database
    $db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);    
    
    //Check for required fields
    $isComplete = true;
    $errorMessage = "";
    
    if (!isset($username)) {
        $errorMessage .= " Please enter a username.";
        $isComplete = false;
    } else {
        $username = makeStringSafe($db, $username);
    }
	
	if (!isset($email)) {
		$errorMessage .= " Please enter an email.";
    $isComplete = false;
	}

	if (!isset($location)) {
		$errorMessage .= " Please enter the type of member you are.";
    $isComplete = false;
	}

    if (!isset($password)) {
        $errorMessage .= " Please enter a password.";
        $isComplete = false;
    }	    
	
	if (!isset($password2)) {
        $errorMessage .= " Please enter a password again.";
        $isComplete = false;
    }
	
	if ($password != $password2) {
		$errorMessage .= " Your two passwords are not the same.";
		$isComplete = false;
	}
	    
	
    if ($isComplete) {
    
		//Username comparison
		$query = "SELECT * FROM account WHERE username='$username';";
		$result = queryDB($query, $db);
		if (nTuples($result) > 0) {
            //If same as another user, error 
            $errorMessage .= " Username $username already exists. Please select a different username. ";
        }
    }
    
    if ($isComplete) {
        //Hashed password
        $hashedpass = crypt($password, getSalt());
        
        //Sql code insert tuple record
        $insert = "INSERT INTO account(hashedpass,username,email,location ) VALUES ('$hashedpass','$username','$email','$location');";
    
        //Run the insert statement
        $result = queryDB($insert, $db);
        
        //Send response back
        $response = array();
        $response['status'] = 'success';
        header('Content-Type: application/json');
        echo(json_encode($response));
	} else {
        //Error if not correct 
        $response = array();
        $response['status'] = 'error';
        $response['message'] = $errorMessage;
        header('Content-Type: application/json');
        echo(json_encode($response));   
	}    

?>
