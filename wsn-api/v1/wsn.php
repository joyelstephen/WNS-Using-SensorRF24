<?php
/*
    This web service supports both GET and POST methods
*/
    include '../core/connect.php';
    
    /* process clinet request */
    /* our URI looks like http://turing.une.edu.au/~jsteph32/api-wsn/v1/wns.php?name1=value1&name2=value2 */
    
    //parse the url and get the components
    $HTTP_HOST = $_SERVER["HTTP_HOST"];               //http://turing.une.edu.au
    $SCRIPT_NAME = $_SERVER["SCRIPT_NAME"];           //~jsteph32/api-wsn/v1/wns.php
    $QUERY_STRING = $_SERVER["QUERY_STRING"];         //name1=value1&name2=value2
    $REQUEST_METHOD = $_SERVER["REQUEST_METHOD"];     //GET or POST 
    
    /*
     * HTTP code used:
     * 200      Ok                          The request has succeeded.
     * 400      Bad Request                 The request could not be understood by the server due to malformed syntax.
     * 403      Forbidden                   Either the username and password supplied do not match or the user specified does not have access to the object being accessed.
     * 404      Not Found                   The server has not found anything matching the Request-URI.
     * 405      Method Not Allowed          The URL used is not allowed on our API.
     * 500      Internal Server Error       The server encountered an unexpected condition which prevented it from fulfilling the request.
     * 501      Not Implemented             The server does not support the functionality required to fulfill the request.
     */
    
    $my_query = "";
  
    // get the authantication parameters
    if($REQUEST_METHOD == "GET")
    {
        $email = $_GET['email'];
        $password = $_GET['password'];
        $key = $_GET['key'];
//        $email = "joyel_stephen@yahoo.com";
//        $password = "secret";
//        $key = "ae8vGWPdZmLg5gPprG9sNM6yCu9fZV4n";
    }
    else if($REQUEST_METHOD == "POST")
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $key = $_POST['key'];
    }
    
    // check authentication
    if(!authenticate($email,$password,$key))    
    {
        deliver_response (401, "Unauthorized", NULL);
    }
    else
    {    
        //******************************************************************************************
        //Now start processing the reques
        //we have different types of query. check which one is comming and process it
        //all the query is stored in $QUERY_STRING

        //parse the query string
        parse_str($QUERY_STRING, $my_query);

        // $my_query has stored all the query as an array
        // $my_query['email'] will store the value of email
        // the keys we have in the array are: 
        //      email,password,key,...
        // and their values will be ...
        // the keys we have in the array are: 
        //      email,password,key,list,mesh_name,node_name,type,location,from,to
        // value for list : (meshes or nodes)
        // value for type : (temprature, humidity,...)
        
        if(isset($my_query['list']))
        {
            // display the lstes of meshes(if list=meshes) or list of nodes(if list=nodes)             
            if($my_query['list'] == "meshes")
            {                
                get_meshes_list();
            }
            else if($my_query['list'] == "nodes")
            {
                get_nodes_list();
            }
            else 
            {
                // other type of request are not allowed
                deliver_response (405, "Method Not Allowed", NULL);
            }            
        }
        else if(isset($my_query['mesh_name']))
        {
            //dispaly information about the mesh
            get_mesh($my_query['mesh_name']);
        }
        else if(isset($my_query['node_name']))
        {
            //dispaly information about the node            
            get_node($my_query['node_name']);
        }
        else if(isset($my_query['type']) && isset($my_query['location']))
        {
            //display reading of a given type for a given location            
            get_reading_by_location($my_query['type'], $my_query['location']);
        }
        else if(isset($my_query['type']) && isset($my_query['from']) && isset($my_query['to']))
        {
            //dispaly reading of a given type for a given period of time            
            get_reading_by_time($my_query['type'], $my_query['from'], $my_query['to']);
        }
        else if(isset($my_query['type']))
        {
            //display all readings of a given type
            get_reading($my_query['type']);
        }
    }
    
    /**
     * Get the list of meshes by name
     * 
     * @return      json 
     */
    function get_meshes_list()
    {
        $result = pg_query("SELECT mesh_name
                                FROM meshes ORDER BY mesh_name ASC");
                                
        $result = pg_query("SELECT mesh_name
                                FROM meshes ORDER BY mesh_name ASC");

        // check for error
        if($result === FALSE) 
        { 
            die(pg_error()); 
        }
        
        $data = [];             

        while ($row = pg_fetch_array($result)) {
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
     * Get the list of nodes by name
     * 
     * @return      json 
     */
    function get_nodes_list()
    {
        $result = pg_query("SELECT node_name
                                FROM nodes ORDER BY node_name ASC");

        // check for error
        if($result === FALSE) 
        { 
            die(pg_error()); 
        }
        
        $data = [];             

        while ($row = pg_fetch_array($result)) {
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
            die("Error in get_mesh(): " . pg_error()); // TODO: better error handling
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
     * Get node
     * 
     * @param       string $node_name  
     * @return      json 
     */
    function get_node($node_name)
    {    
        // TO DO! .....
        
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
        // TO DO! .....
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
        // TO DO! .....
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
     * Get the reading
     * 
     * @param       string $type     
     * @return      json 
     */
    function get_reading($type)
    {
        $result = pg_query("SELECT readings.readings,readings.time,sensores.id,meshes.mesh_name 
                                FROM readings 
                                LEFT JOIN sensores ON sensores.id = readings.sensore_id 
                                LEFT JOIN nodes ON nodes.id = sensores.node_id 
                                LEFT JOIN meshes ON meshes.id = nodes.mesh_id 
                                WHERE sensores.reading_type = '$type'");
        
        // check for error
        if($result === FALSE) 
        { 
            die("Error in get_reading(): " . pg_error()); // TODO: better error handling
        }

        $data = [];
        while ($row = pg_fetch_assoc($result)) 
        {
            // Get the deta from the row 
            $temp["sensore_id"] = $row["id"];
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
        $queryUser = pg_query("SELECT * FROM api_users WHERE email = '$email' AND password = '$password' AND api_key = '$key'");
        //$queryUser = pg_query("SELECT * FROM api_users WHERE email = 'joyel_stephen@yahoo.com' AND password = 'secret' AND api_key = 'ae8vGWPdZmLg5gPprG9sNM6yCu9fZV4n'");
        
        if($queryUser)
        {
            $rows = pg_num_rows($queryUser);
        }
        else
        {
            //echo my_phpinfo();
            die("something failed");
        }
        
        //$rows = pg_num_rows($queryUser);
        
        if ($rows == 0) 
        {
            return FALSE;
        }
        else 
        {
            return TRUE;            
        }
        return TRUE;
    }
    
    /**
    * This function outputs information about PHP's configuration: 
    * the PHP version, server information, the PHP environment, paths,...
    */
    function my_phpinfo()
    {
        $indicesServer = array('PHP_SELF', 
        'argv', 
        'argc', 
        'GATEWAY_INTERFACE', 
        'SERVER_ADDR', 
        'SERVER_NAME', 
        'SERVER_SOFTWARE', 
        'SERVER_PROTOCOL', 
        'REQUEST_METHOD', 
        'REQUEST_TIME', 
        'REQUEST_TIME_FLOAT', 
        'QUERY_STRING', 
        'DOCUMENT_ROOT', 
        'HTTP_ACCEPT', 
        'HTTP_ACCEPT_CHARSET', 
        'HTTP_ACCEPT_ENCODING', 
        'HTTP_ACCEPT_LANGUAGE', 
        'HTTP_CONNECTION', 
        'HTTP_HOST', 
        'HTTP_REFERER', 
        'HTTP_USER_AGENT', 
        'HTTPS', 
        'REMOTE_ADDR', 
        'REMOTE_HOST', 
        'REMOTE_PORT', 
        'REMOTE_USER', 
        'REDIRECT_REMOTE_USER', 
        'SCRIPT_FILENAME', 
        'SERVER_ADMIN', 
        'SERVER_PORT', 
        'SERVER_SIGNATURE', 
        'PATH_TRANSLATED', 
        'SCRIPT_NAME', 
        'REQUEST_URI', 
        'PHP_AUTH_DIGEST', 
        'PHP_AUTH_USER', 
        'PHP_AUTH_PW', 
        'AUTH_TYPE', 
        'PATH_INFO',  
        'ORIG_PATH_INFO') ; 

        echo '<h4>The Variables:</h4><table border="1" cellpadding="3">' ; 
        foreach ($indicesServer as $arg) { 
            if (isset($_SERVER[$arg])) {
                echo '<tr><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></tr>' ; 
            } 
            else { 
                echo '<tr><td>'.$arg.'</td><td>-</td></tr>' ; 
            } 
        } 
        echo '</table>' ; 
        
    }
?>
