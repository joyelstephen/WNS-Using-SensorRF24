<?php

    include '../core/connect.php';
    
    /* process clinet request */
    /* our URI looks like http://example.com/wsn-api/v1/meshes.php?name1=value1&name2=value2 */
    
    //parse the url and get the components
    $HTTP_HOST = $_SERVER["HTTP_HOST"];               // http://example.com
    $SCRIPT_NAME = $_SERVER["SCRIPT_NAME"];           // /wsn-api/v1/meshes.php
    $QUERY_STRING = $_SERVER["QUERY_STRING"];         // name1=value1&name2=value2
    $REQUEST_METHOD = $_SERVER["REQUEST_METHOD"];     // GET or POST 

    $my_query = "";
  
    // get the authantication parameters
    if($REQUEST_METHOD == "GET")
    {
        $email = $_GET['email'];
        $password = $_GET['password'];
        $key = $_GET['key'];
    }
    
    // check authentication
    if(!authenticate($email,$password,$key))    
    {
        deliver_response (401, "Unauthorized", NULL);
    }
    else
    {    
        //parse the query string
        parse_str($QUERY_STRING, $my_query);
        
        // if we have only email,password and key (3 query)
        if(count($my_query) == 3)
        {
            //dispaly list of nodes
            get_nodes_list();
        }
        else if(count($my_query) == 4 && isset($my_query['node_name']))
        {
            //dispaly information about the node
            get_node($my_query['node_name']);
        }
        else 
        {
            // other type of request are bad request
            deliver_response (400, "Bad Request---", NULL);
        }         
    }
    
    /**
     * Get the list of nodes by name
     * 
     * @return      json 
     */
    function get_nodes_list()
    {
        $result = pg_query("SELECT node_name FROM nodes ORDER BY node_name ASC");

        // check for error
        if($result === FALSE) 
        { 
            die(mysql_error()); 
        }
        
        $data = [];             

        while ($row = pg_fetch_array($result)) 
        {
            $node["node_name"] = $row["node_name"];
             
            array_push($data,$node);
        } 
        
        if(empty($data))
        {
            deliver_response (404, "Not Found", NULL);
        }
        else 
        {
            deliver_response (200, "Ok", $data);
        }
    }

    /**
     * Get node
     * 
     * @param       string $node_name  
     * @return      json 
     */
    function get_node($node_name)
    {        
        $result = pg_query("SELECT nodes.id AS node_id,nodes.node_name,sensores.id AS sensor_id,sensores.ip_address,sensores.reading_type
                                FROM nodes 
                                LEFT JOIN sensores ON nodes.id = sensores.node_id
                                WHERE nodes.node_name = '$node_name'");
                               
        // check for error
        if($result === FALSE) 
        { 
            die("Error in get_mesh(): " . mysql_error()); 
        }

        $sensores = [];
        
        while ($row = pg_fetch_assoc($result)) 
        {
            // Get the deta from the row 
            $node_id = $row["node_id"];
            $node_name = $row["node_name"];
            
            $sensor["sensor_id"] = $row["sensor_id"];
            $sensor["ip_address"] = $row["ip_address"];
            $sensor["reading_type"] = $row["reading_type"];

            array_push($sensores,$sensor);
        }
        
        // populate the data 
        $data["node_id"] = $node_id;
        $data["node_name"] = $node_name;
        
        $data["sensores"] = $sensores; 
        
        if(empty($data))
        {
            deliver_response (404, "Not Found", NULL);
        }
        else 
        {
            deliver_response (200, "Ok", $data);
        }

    }

    /**
     * This returns the status code, status message and the data
     * 
     * @param       string $status          the http response code 
     * @param       string $status_message  the http response message
     * @param       string $data            the data
     * @return      json 
     */
    function deliver_response($status, $status_message, $data)
    {
        header("Content-Type: application/json");
        
        $response['status'] = $status;
        $response['status_message'] = $status_message;
        $response['data'] = $data;        
        
        // encode the output format to json 
        $json_response = json_encode($response, JSON_UNESCAPED_UNICODE);      
        
        //echo the response formatted in json 
        echo $json_response;
        
    }

    /**
     * The function checks if the email, password and key are in the database
     * 
     * @param       string $email       the email of the user 
     * @param       string $password    the password of the user
     * @param       string $key         the api key of the user
     * @return      BOOL 
     */
    function authenticate($email, $password, $key)
    {
        $queryUser = pg_query("SELECT * FROM api_users WHERE email = '$email' AND password = '$password' AND api_key = '$key'");
        
        if($queryUser)
        {
            $rows = pg_num_rows($queryUser);
        }
        else
        {
            $rows = 0;
        }
        
        if ($rows == 0) 
        {
            return FALSE;
        }
        else 
        {
            return TRUE;            
        }
    }

?>

