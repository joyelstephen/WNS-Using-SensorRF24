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
            //dispaly list of meshes
            get_meshes_list();
        }
        else if(count($my_query) == 4 && isset($my_query['mesh_name']))
        {
            //dispaly information about the mesh
            get_mesh($my_query['mesh_name']);
        }
        else 
        {
            // other type of request are bad request
            deliver_response (400, "Bad Request", NULL);
        }         
    }
    
    /**
     * Get the list of meshes by name
     * 
     * @return      json 
     */
    function get_meshes_list()
    {
        $result = pg_query("SELECT mesh_name FROM meshes ORDER BY mesh_name ASC");

        // check for error
        if($result === FALSE) 
        { 
            die(mysql_error()); 
        }
        
        $data = [];             

        while ($row = pg_fetch_array($result)) 
        {
            $mesh["mesh_name"] = $row["mesh_name"];
            
            array_push($data,$mesh);
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
     * Get mesh
     * and with links to previous and next books
     * 
     * @param       string $mesh_name   
     * @return      json 
     */
    function get_mesh($mesh_name)
    {
        $result = pg_query("SELECT meshes.id,meshes.mesh_address,meshes.mesh_name,nodes.node_name
                                FROM meshes 
                                LEFT JOIN nodes ON meshes.id = nodes.mesh_id
                                WHERE meshes.mesh_name = '$mesh_name'");
        
        // check for error
        if($result === FALSE) 
        { 
            die("Error in get_mesh(): " . mysql_error()); 
        }

        $nodes = [];
        
        while ($row = pg_fetch_assoc($result)) 
        {
            // Get the deta from the row 
            $id = $row["id"];
            $mesh_address = $row["mesh_address"];
            $mesh_name = $row["mesh_name"];
            
            $node["node_name"] = $row["node_name"];

            array_push($nodes,$node);
        }
        
        // populate the data 
        $data["id"] = $id;
        $data["mesh_address"] = $mesh_address;
        $data["mesh_name"] = $mesh_name;
        
        $data["nodes"] = $nodes; 
        
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
