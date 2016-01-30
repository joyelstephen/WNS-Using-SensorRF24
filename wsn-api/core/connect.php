<?php
    /*
        This is the login credential to the database. You need to edit it with correct value
    */
    $dbconn = pg_connect("host=myHost dbname=myDatabaseName user=myUserName password=myPassword") or 
            die("Could not connect to database.");
    
?>