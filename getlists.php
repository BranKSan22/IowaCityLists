<?php
    include_once('config.php');
    include_once('dbutils.php');

    
    //Connect to the database
    $db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);
    
    //Query  that gets list of lists and time stamp that put the newly created list first
    $query = "SELECT * FROM list ORDER BY timeTable DESC";
    
    //Run the query
    $result = queryDB($query, $db);

    
    //Results given for array
    $lists = array();
    $i = 0;
    while ($list = nextTuple($result)) {
        $lists[$i] = $list;
        
        $listid = $list['id'];
        
        //Get items from  current list
        $query = "SELECT * FROM item WHERE list_id = $listid ORDER BY ordernumber";
        
        //Run the query
        $result_item = queryDB($query, $db);
        $items = array();
        $j = 0;
        while ($item = nextTuple($result_item)) {
            $items[$j] = $item;
            
            $itemid = $item['id'];
            
            //Get the attributes for item
            $query = "SELECT * FROM attribute WHERE item_id = $itemid ORDER BY ordernumber";
            
            //Run the query
            $result_attribute = queryDB($query, $db);
            $attributes = array();
            $k = 0;
            while ($attribute = nextTuple($result_attribute)) {
                $attributes[$k] = $attribute;
                $k++;
            }
            
            $items[$j]['attributes'] = $attributes;
            $j++;
        }
        
        $lists[$i]['items'] = $items;
        
        $i++;
    }
    
    //JSON and response send back
    $response = array();
    $response['status'] = 'success';
    $response['value'] = $lists;
    header('Content-Type: application/json');
    echo(json_encode($response));
?>