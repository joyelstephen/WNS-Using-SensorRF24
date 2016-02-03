<?php

    echo date("Y", strtotime("2011-01-07"));
    echo date("M", strtotime("2011-01-07"));
    echo date("D", strtotime("2011-01-07"));
    echo date("d", strtotime("2011-01-07"));
    
    echo "<br>";
    
    $timestamp = "2011-01-07";    
    echo date("D, d M Y h:i:s O", strtotime ($timestamp));  //output =  Fri, 07 Jan 2011 12:00:00 +1100
    
    echo "<br>";
    
    //$date = new DateTime('2000-01-01');
    
    //How to get time difference
    $to_time = strtotime("2008-12-30");
    $from_time = strtotime("2009-01-01");
    echo round(abs($to_time - $from_time) / (60)). " minute";
    echo "<br>";
    echo round(abs($to_time - $from_time) / (60*60)). " hours";
    echo "<br>";
    echo round(abs($to_time - $from_time) / (60*60*24)). " days";
    echo "<br>";
    
    if($to_time>$from_time)
    {
        echo "To_time is greater than From_time";
    }
    else
    {
        echo "To_time is less than From_time";
    }
    
    echo "<br>";
    echo "<br>";
    
    $QUERY_STRING = $_SERVER["QUERY_STRING"];
    
    if($REQUEST_METHOD == "GET")
    {
        $name = $_GET['name'];
        $age = $_GET['age'];
    }

    parse_str($QUERY_STRING,$myArray);
    
    echo $myArray['from'];
    echo "<br>";
    echo $myArray['to'];
    //print_r($myArray);

?>
