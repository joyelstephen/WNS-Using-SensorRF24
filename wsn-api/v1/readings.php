<?php

    include '../core/connect.php';
    
    /* process clinet request */
    /* our URI looks like http://turing.une.edu.au/~jsteph32/api-wsn/v1/wns.php?name1=value1&name2=value2 */
    
    //parse the url and get the components
    $HTTP_HOST = $_SERVER["HTTP_HOST"];               //http://turing.une.edu.au
    $SCRIPT_NAME = $_SERVER["SCRIPT_NAME"];           //~jsteph32/api-wsn/v1/wns.php
    $QUERY_STRING = $_SERVER["QUERY_STRING"];         //name1=value1&name2=value2
    $REQUEST_METHOD = $_SERVER["REQUEST_METHOD"];     //GET or POST 

    $my_query = "";
  
    // get the authantication parameters
    /*
        $email = "joyel_stephen@yahoo.com";
        $password = "secret";
        $key = "ae8vGWPdZmLg5gPprG9sNM6yCu9fZV4n";
    */
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
        //******************************************************************************************
        //parse the query string
        parse_str($QUERY_STRING, $my_query);
        
        //get_meshes_list();
        
        // if we have only email,password and key (3 query)
        if(count($my_query) == 3)
        {
            get_reading_type_list();
        }
        else if(count($my_query) == 4 && isset($my_query['type']))
        {
            //dispaly information about the mesh
            get_reading($my_query['type']);
        }
        else if(count($my_query) == 5 && isset($my_query['type']) && isset($my_query['location']))
        {
            //dispaly information about the mesh
            get_reading_by_location($my_query['type'],$my_query['location']);
        }
        else if(count($my_query) == 6 && isset($my_query['type']) && isset($my_query['from']) && isset($my_query['to']))
        {
            //dispaly information about the mesh
            get_reading_by_time($my_query['type'],$my_query['from'],$my_query['to']);
/*            
            $data = [];
            // Get the deta from the row 
            $temp["from"] = $my_query['from'];
            $temp["to"] = $my_query['to'];
            
            // populate the data
            array_push($data,$temp);
            
            if(empty($data))
            {
                deliver_response (404, "Not Found--", NULL);
            }
            else 
            {
                deliver_response (200, "Ok", $data);
            }
            */
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
    function get_reading_type_list()
    {
        //$result = mysql_query("SELECT DISTINCT reading_type FROM sensores ORDER BY reading_type ASC");        
        $result = pg_query("SELECT DISTINCT reading_type FROM sensores ORDER BY reading_type ASC");

        // check for error
        if($result === FALSE) 
        { 
            die(mysql_error()); 
        }
        
        $data = [];             

        //while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
        while ($row = pg_fetch_array($result)) 
        {
            $type["reading_type"] = $row["reading_type"];
            
            array_push($data,$type);
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
    function get_reading($type)
    {
        /*
        $result = mysql_query("SELECT readings.readings,readings.time,sensores.id,meshes.mesh_name 
                                FROM readings 
                                LEFT JOIN sensores ON sensores.id = readings.sensor_id 
                                LEFT JOIN nodes ON nodes.id = sensores.node_id 
                                LEFT JOIN meshes ON meshes.id = nodes.mesh_id 
                                WHERE sensores.reading_type = '$type'");
        */
        
        $result = pg_query("SELECT readings.readings,readings.time,sensores.id,meshes.mesh_name 
                                FROM readings 
                                LEFT JOIN sensores ON sensores.id = readings.sensor_id 
                                LEFT JOIN nodes ON nodes.id = sensores.node_id 
                                LEFT JOIN meshes ON meshes.id = nodes.mesh_id 
                                WHERE sensores.reading_type = '$type'");
        
        // check for error
        if($result === FALSE) 
        { 
            die("Error in get_mesh(): " . mysql_error()); 
        }

        $data = [];
        //while ($row = mysql_fetch_assoc($result)) 
        while ($row = pg_fetch_assoc($result)) 
        {
            // Get the deta from the row 
            $temp["sensor_id"] = $row["id"];
            $temp["mesh_name"] = $row["mesh_name"];
            $temp["time"] = $row["time"];
            $temp["reading"] = $row["readings"];
            
            // populate the data
            array_push($data,$temp);
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
     * Get reading by location
     * 
     * @param       String $type
     * @param       String $loaction
     * @return      json 
     */
    function get_reading_by_location($type, $location)
    {

        /*
        $result = mysql_query("SELECT readings.readings,readings.time,sensores.id,meshes.mesh_name 
                                FROM readings 
                                LEFT JOIN sensores ON sensores.id = readings.sensor_id 
                                LEFT JOIN nodes ON nodes.id = sensores.node_id 
                                LEFT JOIN meshes ON meshes.id = nodes.mesh_id 
                                WHERE sensores.reading_type = '$type'");
        */
        
        $result = pg_query("SELECT readings.readings,readings.time,sensores.id,meshes.mesh_name 
                                FROM readings 
                                LEFT JOIN sensores ON sensores.id = readings.sensor_id 
                                LEFT JOIN nodes ON nodes.id = sensores.node_id 
                                LEFT JOIN meshes ON meshes.id = nodes.mesh_id 
                                WHERE sensores.reading_type = '$type' AND meshes.mesh_name = '$location'");
        
        // check for error
        if($result === FALSE) 
        { 
            die("Error in get_reading(): " . mysql_error()); 
        }

        $data = [];
        //while ($row = mysql_fetch_assoc($result)) 
        while ($row = pg_fetch_assoc($result)) 
        {
            // Get the deta from the row 
            $temp["sensor_id"] = $row["id"];
            $temp["mesh_name"] = $row["mesh_name"];
            $temp["time"] = $row["time"];
            $temp["reading"] = $row["readings"];
            
            // populate the data
            array_push($data,$temp);
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
     * Get the reading by time
     * 
     * @param       String $type        
     * @param       Date $from          
     * @param       Date $to            
     * @return      json 
     */
    function get_reading_by_time($type, $from, $to)
    {
        /*
        $result = mysql_query("SELECT readings.readings,readings.time,sensores.id,meshes.mesh_name 
                                FROM readings 
                                LEFT JOIN sensores ON sensores.id = readings.sensor_id 
                                LEFT JOIN nodes ON nodes.id = sensores.node_id 
                                LEFT JOIN meshes ON meshes.id = nodes.mesh_id 
                                WHERE sensores.reading_type = '$type' AND readings.time >= '$from' AND readings.time <= '$to'
                                ORDER BY readings.time");
        */

    
    
        $result = pg_query("SELECT readings.readings,readings.time,sensores.id,meshes.mesh_name 
                                FROM readings 
                                LEFT JOIN sensores ON sensores.id = readings.sensor_id 
                                LEFT JOIN nodes ON nodes.id = sensores.node_id 
                                LEFT JOIN meshes ON meshes.id = nodes.mesh_id 
                                WHERE sensores.reading_type = '$type' AND readings.time >= '$from' AND readings.time <= '$to'
                                ORDER BY readings.time");
        
        // check for error
        if($result === FALSE) 
        { 
            die("Error in get_reading(): " . mysql_error()); 
        }

        $data = [];
        //while ($row = mysql_fetch_assoc($result)) 
        while ($row = pg_fetch_assoc($result)) 
        {
            // Get the deta from the row 
            $temp["sensor_id"] = $row["id"];
            $temp["mesh_name"] = $row["mesh_name"];
            $temp["time"] = $row["time"];
            $temp["reading"] = $row["readings"];
            
            // populate the data
            array_push($data,$temp);
        }
/*

        $data = [];
        // Get the deta from the row 
        $temp["from"] = $from;
        $temp["to"] = $to;
        
        // populate the data
        array_push($data,$temp);
*/        
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
        //header("HTTP/1.1 $status $status_message");
        header("Content-Type: application/json");
        
        $response['status'] = $status;
        $response['status_message'] = $status_message;
        $response['data'] = $data;        
        
        // encode the output format to json 
        $json_response = json_encode($response, JSON_UNESCAPED_UNICODE);
        //$json_response = json_encode($response);
        
        //debug the env variables
        //echo my_phpinfo();        
        
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
        // get data from db
        //$queryUser = mysql_query("SELECT * FROM api_users WHERE email = '$email' AND password = '$password' AND api_key = '$key'");
        //$queryUser = mysql_query("SELECT * FROM api_users WHERE email = 'joyel_stephen@yahoo.com' AND password = 'secret' AND api_key = 'ae8vGWPdZmLg5gPprG9sNM6yCu9fZV4n'");
        
        $queryUser = pg_query("SELECT * FROM api_users WHERE email = '$email' AND password = '$password' AND api_key = '$key'");
        //$queryUser = pg_query("SELECT * FROM api_users WHERE email = 'joyel_stephen@yahoo.com' AND password = 'secret' AND api_key = 'ae8vGWPdZmLg5gPprG9sNM6yCu9fZV4n'");
        
        if($queryUser)
        {
            //rows = mysql_num_rows($queryUser);
            $rows = pg_num_rows($queryUser);
        }
        else
        {
            //echo my_phpinfo();
            die("something failed");
        }
        
        //$rows = mysql_num_rows($queryUser);
        
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
