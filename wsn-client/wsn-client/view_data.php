<?php
    require_once('wsn-api/wsn_api.php');
    $wsn_api = new wsn_api();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>WSN API</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
        <link href="master_style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
    <div id="main-body">
        <header>
            <?php require_once('core/header_include.php'); ?>
        </header>
        <nav>
            <?php require_once('core/nav_include.php');?>
        </nav>
        <article>
            <div id="three-fourth">
                <h1>View Data!</h1>
                <p>
                    To view data at list reading type must be selected. If you want to view for specific location select location 
                    and to view for a specific period of time select from and to.
                </p>
                <hr>
                <form action="view_data.php" autocomplete="on" method="POST">                    
                    <table>
                        <tr>
                            <td>Select Reading Type *</td>
                            <td>
                                <select name="type">
                                    <option value="null">Please Select...</option>
                                    <option value="temperature">Temperature</option>
                                    <option value="humidity">Humidity</option>
                                </select>
                            </td>
                            <td> </td><td> </td><td> </td><td> </td><td> </td>
                            <td>Select Location</td>
                            <td>
                                <select name="location">
                                    <option value="null">Please Select...</option>
                                    <option value="mesh-1">Mesh-1</option>
                                    <option value="mesh-2">Mesh-2</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table>
                        <tr>
                            <th>Select Period</th>
                            <td></td>
                        </tr>
                        <tr>
                            <td>From Date </td>
                            <td>
                                <input type="date" name="f_date">
                            </td>
                            <td>Hours </td>
                            <td>
                                <select name="f_hr">
                                    <option value="null"></option>
                                    <option value="00">00</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>                                    
                                </select>
                            </td>
                            <td>Minutes </td>
                            <td>
                                <select name="f_min">
                                    <option value="null"></option>
                                    <option value="00">00</option>
                                    <option value="20">20</option> 
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>To Date</td>
                            <td>
                                <input type="date" name="t_date">
                            </td>
                            <td>Hours </td>
                            <td>
                                <select name="t_hr">
                                    <option value="null"></option>
                                    <option value="00">00</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>                                    
                                </select>
                            </td>
                            <td>Minutes </td>
                            <td>
                                <select name="t_min">
                                    <option value="null"></option>
                                    <option value="00">00</option>
                                    <option value="20">20</option> 
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <input type="submit" value="Submit">                    
                </form>
                <?php
                    // get the type
                    if(isset($_POST["type"]))
                    {
                        $type = $_POST["type"];
                    }
                    // get the location
                    if(isset($_POST["location"]) && $_POST["location"]!= "null")
                    {
                        $location = $_POST["location"];
                    }
                    else
                    {
                        $location = null;
                    }
                    
                    // get From date
                    if(isset($_POST["f_date"]) && $_POST["f_date"]!= null && 
                        isset($_POST["f_hr"]) && $_POST["f_hr"]!= null && 
                        isset($_POST["f_min"]) && $_POST["f_min"]!= null )
                    {
                        $from = $_POST["f_date"] ." ". $_POST["f_hr"] .":".  $_POST["f_min"];
                    }
                    else
                    {
                        $from = null;
                    }
                    // get To date
                    if(isset($_POST["t_date"]) && isset($_POST["t_hr"]) && isset($_POST["t_min"]))
                    {
                        $to = $_POST["t_date"] ." ". $_POST["t_hr"] .":". $_POST["t_min"];
                    }
                    else
                    {
                        $to = null;
                    }                  
                    
                    
                ?>
                <hr>
                <h3>Output Data</h3>
                <?php 
                    if($type != null && $location != null) echo "'$type' reading for location '$location'";
                    else if($type != null) echo "'$type' reading for All locations";
                ?><br>
                <?php
                    //if(isset($from) && isset($to))
                    if($from !=null && $to != null)
                    {
                        $from = $from .":00";
                        $to = $to .":00";
                        echo "From: " .$from. " To: " . $to . "<br>";
                    }
                ?>
                <table border="1" width="100%">
                    <tr>
                      <th>sensor_id</th>
                      <th>mesh_name</th> 
                      <th>time</th>
                      <th>
                        reading <br>
                        <?php if($type != null) echo "($type)"?>
                      </th>
                    </tr>
                        <?php
                       // /*
                            //make the request
                            if(isset($type) && $location != null && $from != null && $to != null)
                            {
                                //$type = "temperature";
                                $response_readings = $wsn_api->get_reading_by_time($type,$from,$to);
                                // decode json
                                $result_temp_obj = json_decode($response_readings);
                                // get the meshes
                                $temp_obj = $result_temp_obj->{'data'}; 
                                // get the values $mesh_obj contains list of mesh as name=value pair
                                foreach($temp_obj as $temp)
                                {
                                    echo "<tr>".
                                            "<td>" . $temp->{'sensor_id'}."</td>".
                                            "<td>" . $temp->{'mesh_name'}."</td>".
                                            "<td>" . $temp->{'time'}."</td>".
                                            "<td>" . $temp->{'reading'}."</td>".
                                        "</tr>";
                                } 
                            }
                            else if(isset($type) && $location != null) // && $from == null && $to == null)
                            {
                                //$type = "temperature";
                                $response_readings = $wsn_api->get_reading_by_location($type,$location);
                                // decode json
                                $result_temp_obj = json_decode($response_readings);
                                // get the meshes
                                $temp_obj = $result_temp_obj->{'data'}; 
                                // get the values $mesh_obj contains list of mesh as name=value pair
                                foreach($temp_obj as $temp)
                                {
                                    echo "<tr>".
                                            "<td>" . $temp->{'sensor_id'}."</td>".
                                            "<td>" . $temp->{'mesh_name'}."</td>".
                                            "<td>" . $temp->{'time'}."</td>".
                                            "<td>" . $temp->{'reading'}."</td>".
                                        "</tr>";
                                } 
                            }
                            else if(isset($type) && $location == null)// && $from == null && $to == null)
                            {
                                //$type = "temperature";
                                $response_readings = $wsn_api->get_reading($type);
                                // decode json
                                $result_temp_obj = json_decode($response_readings);
                                // get the meshes
                                $temp_obj = $result_temp_obj->{'data'}; 
                                // get the values $mesh_obj contains list of mesh as name=value pair
                                foreach($temp_obj as $temp)
                                {
                                    echo "<tr>".
                                            "<td>" . $temp->{'sensor_id'}."</td>".
                                            "<td>" . $temp->{'mesh_name'}."</td>".
                                            "<td>" . $temp->{'time'}."</td>".
                                            "<td>" . $temp->{'reading'}."</td>".
                                        "</tr>";
                                } 
                            }

                        ?>

                </table>
            </div>
            <div id="one-fourth">
                <h2>List of Meshes</h2>
                <?php
                    //make the request
                    $response_meshlist = $wsn_api->get_meshes_list();
                    // decode json
                    $result_mesh_obj = json_decode($response_meshlist);
                    // get the meshes
                    $meshes_obj = $result_mesh_obj->{'data'}; 
                    // get the values $mesh_obj contains list of mesh as name=value pair
                    $count_msesh = 1;
                    foreach($meshes_obj as $mesh)
                    {
                        echo $count_msesh . ". " . $mesh->{'mesh_name'} . "<br>";
                        $count_msesh++;
                    }  
                ?>
                <h2>List of Nodes</h2>
                <?php
                    //make the request
                    $response_nodelist = $wsn_api->get_nodes_list();
                    // decode json
                    $result_node_obj = json_decode($response_nodelist);
                    // get the meshes
                    $node_obj = $result_node_obj->{'data'}; 
                    // get the values $mesh_obj contains list of mesh as name=value pair
                    $count_node = 1;
                    foreach($node_obj as $node)
                    {
                        echo $count_node . ". " . $node->{'node_name'} . "<br>";
                        $count_node++;
                    }  
                ?>
                <h2>List of Reading Type</h2>
                <?php
                    //make the request
                    $response_readinglist = $wsn_api->get_reading_type_list();
                    // decode json
                    $result_reading_obj = json_decode($response_readinglist);
                    // get the meshes
                    $readings_obj = $result_reading_obj->{'data'}; 
                    // get the values $mesh_obj contains list of mesh as name=value pair
                    $count_readings = 1;
                    foreach($readings_obj as $readings)
                    {
                        echo $count_readings . ". " . $readings->{'reading_type'} . "<br>";
                        $count_readings++;
                    } 
                ?>
                
            </div>
        </article>

        <footer>
            <?php require_once('core/footer_include.php'); ?>
        </footer>

    </div>
</body>
</html>

