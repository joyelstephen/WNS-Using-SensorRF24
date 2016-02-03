<?php

/**
 * This is the account level class, used for API calls for a specific account
 *
 * @author Joyel and Seif
 */

class wsn_api 
{
    //declare constant variable inside a class
    const BASE_API_URL = "http://turing.une.edu.au/~jsteph32/wsn-api/";
    //const BASE_API_URL = "localhost/wsn-api/";
    const VERSION = "v1";
    const SCRIPT_NAME = "wsn.php";
    
    //private $connection_headers;
    private $connection_params;
    

    //constructor
    public function __construct() 
    {
        
        require_once("config.php");

        // connection parameters used in API URLs
        $this->connection_params = array(
            "email"=>USER_EMAIL, 
            "password"=>PASSWORD,
            "key"=>API_KEY
        );           
    }
    
    /**
     * Function to handle all of the requests with cURL
     *
     * @param       string $api_url
     * @param       array $p_curl_options
     * @return      json $api_responset
     */
    
    private function handle_request($api_url)
    {
        try 
        {
            //initialize curl sesssion with the api url
            $ch = curl_init($api_url);
            
            // create array of options
            $curl_options = array(
                //Set to true so curl_exec() will return the contents of the response
                CURLOPT_RETURNTRANSFER => TRUE,
                //Dont verifying certificate
                CURLOPT_SSL_VERIFYPEER => FALSE,
                // Follow redirects
                CURLOPT_FOLLOWLOCATION => TRUE,
            );              
            // Set multiple options for a cURL
            curl_setopt_array($ch, $curl_options);
            //execute the cURL session
            $api_response = curl_exec($ch);            
            //Gets information about the last transfer (execute of the cURL session)
            $api_response_info = curl_getinfo($ch);
            // throw an exception for http codes other than 200
            if ( $api_response_info["http_code"] != 200 ) {
                throw new Exception("API Error", $api_response_info["http_code"]);
            }               
            //Closes a cURL session and frees all resources. The cURL handle, ch, is also deleted.
            curl_close($ch); 
            // return the response
            return $api_response;
        }        
        catch (Exception $e) 
        {
            echo "<p>" . $e->getMessage() . " with error code: " . $e->getCode() . "</p>";             
            if ( curl_error($ch) != "" ) 
            {
                echo "Curl error: " . curl_error($ch);
            }            
        }        
    }
    
    /**
     * Construct the full API URL which includes the base uri, api-key and the query
     * 
     * @param       string $string      URL-encodded query string (will be NULL if nothing pass)
     * @return      json                full API URL 
     */    
    private function construct_url($string = NULL)
    {
        // Generate URL-encoded query string from connection params
        $connection_query_string = http_build_query($this->connection_params);
        
        // append the connection query string to the url
        $api_url = self::BASE_API_URL . self::VERSION ."/" . self::SCRIPT_NAME ."/?" . $connection_query_string;
        
        // add the the URL-encoded query string to the url if $string has value
        if($string != NULL)
        {
            $api_url = $api_url . "&" . $string;
        }
        
        // return the url
        return $api_url;        
    }


    /**
     * Get the list of meshes by name
     * 
     * @return      json 
     */
    public function get_meshes_list() 
    {
        // construct the url and add list=meshes query 
        $api_url = $this->construct_url("list=meshes");
        
        //get the response
        $response = $this->handle_request($api_url);        
        
        //return the response
        return $response;        
    }
    
    /**
     * Get the list of nodes by name
     * 
     * @return      json 
     */
    public function get_nodes_list() 
    {
        // construct the url and add list=nodes query
        $api_url = $this->construct_url("list=nodes");
        
        //get the response
        $response = $this->handle_request($api_url);        
        
        //return the response
        return $response;        
    }
    
    /**
     * Get mesh
     * 
     * @return      string $mesh_name        name of the mesh
     * @return      json 
     */
    public function get_mesh($mesh_name) 
    {
        // store the param to array
        $request_param = array("mesh_name"=>"$mesh_name");
        
        // Generate URL-encoded query string
        $query_string = http_build_query($request_param);

        // construct url and add the URL-encoded query string to API_URL
        $api_url = $this->construct_url($query_string);
        
        //get the response
        $response = $this->handle_request($api_url);        
        
        //return the response
        return $response;
    }
    
    /**
     * Get node
     * 
     * @param       string $node_name   name of the node
     * @return      json 
     */
    public function get_node($node_name) 
    {
        // store the param to array
        $request_param = array("node_name"=>"$node_name");
        
        // Generate URL-encoded query string
        $query_string = http_build_query($request_param);

        // construct url and add the URL-encoded query string to API_URL
        $api_url = $this->construct_url($query_string);
        
        //get the response
        $response = $this->handle_request($api_url);        
        
        //return the response
        return $response;
    }
    
    /**
     * Get reading by location
     * 
     * @param       String $type
     * @param       String $loaction
     * @return      json 
     */
    public function get_reading_by_location($type, $location) 
    {
        // store the param to array
        $request_param = array("type"=>"$type","location"=>$location);
        
        // Generate URL-encoded query string
        $query_string = http_build_query($request_param);

        // construct url and add the URL-encoded query string to API_URL
        $api_url = $this->construct_url($query_string);
        
        //get the response
        $response = $this->handle_request($api_url);        
        
        //return the response
        return $response;        
    }
    
    /**
     * Get the reading by time
     * 
     * @param       String $type        
     * @param       Date $from          
     * @param       Date $to            
     * @return      json
     */
    public function get_reading_by_time($type, $from, $to)
    {
        // store the param to array
        $request_param = array("type"=>"$type","from"=>$from,"to"=>$to);
        
        // Generate URL-encoded query string
        $query_string = http_build_query($request_param);

        // construct url and add the URL-encoded query string to API_URL
        $api_url = $this->construct_url($query_string);
        
        //get the response
        $response = $this->handle_request($api_url);        
        
        //return the response
        return $response;         
    }
    
    /**
     * Get the reading
     * 
     * @param       string $type     
     * @return      json  
     */
    public function get_reading($type) 
    {
        // store the param to array
        $request_param = array("type"=>"$type");
        
        // Generate URL-encoded query string
        $query_string = http_build_query($request_param);

        // construct url and add the URL-encoded query string to API_URL
        $api_url = $this->construct_url($query_string);
        
        //get the response
        $response = $this->handle_request($api_url);        
        
        //return the response
        return $response; 
    }

}

?>
