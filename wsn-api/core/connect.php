<?php
    //@mysql_connect("localhost","root","root");
    //mysql_select_db("wsn_data");
    
    $dbconn = pg_connect("host=127.0.0.1 dbname=wsn_data user=jsteph32_apps password=220130353") or die("Could not connect to database. <a href='http://turing.une.edu.au/~jsteph32/wsn-api'>Go back</a><br>.");
  
    
    //check connection status
    //$status = pg_connection_status($dbconn);
    //if($status === PGSQL_CONNECTION_OK)
    //{
    //    echo 'Connection status OK<br>';
    //}
    //else
    //{
    //    echo 'Connection status Bad!<br>';
    //}
    
?>