<?php
include_once('config.php');
    include_once('dbutils.php');
    		
    //Connect to the database
     $db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);
     
     //Session id for list id and template id
	session_start();
	$session_list_id = $_SESSION['listid'];
	$session_template_id = $_SESSION['template_id'];


	///Collects data from JSON 
	$data = json_decode(file_get_contents('php://input'), true);

	//Template attributes for the current template with a query ( $session_template_id )
     $query = "SELECT * FROM template_attribute WHERE template_id=$session_template_id";
     
     //Run the query
    $result = queryDB($query, $db);
    
    //Order of input per item
    $query = "SELECT max(ordernumber) AS maxorder FROM item  WHERE list_id=$session_list_id";
    
	//Run the query
    $itemresult = queryDB ($query,$db);
    
    //Put max order back to zero
    if (nTuples($itemresult)>0){
        $row = nextTuple($itemresult);
        $maxorder = $row ["maxorder"];
        if($maxorder == NULL) {
            $maxorder = 0;
        } else {
            $maxorder++;
        }
    }
	
    //Create a new item under the current list
	//insert into item (listid) values $session_list_id
    $insert = "INSERT INTO item (list_id, ordernumber) VALUES ( $session_list_id,$maxorder)";
    
    //Run insert statment
    queryDB($insert,$db);
    
    
    //Get id for new item
    $itemid= mysqli_insert_id($db);
    
    //Default 
    $i=0;
    //For loop statemet reiterating through each temp attribute
    foreach ($result as $row ) {
        
        //Get items passed through $data
		 //Insert new attribute from current item - label - type ( template attribute ) ( $data[$i] )
        $ordernumber= $row['ordernumber'];
        $label=$row['label'];
        $type=$row['type'];
        $value=$data[$i];
        $insertattr= "INSERT INTO attribute (item_id,ordernumber, label, type, value) VALUES ($itemid, $ordernumber, '$label', '$type', '$value')";
              
         //Run insert statment and increment
        queryDB($insertattr,$db);
        $i++;

        
    }
?>