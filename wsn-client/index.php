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
                <h1>Well come to Wireless Network Sensor Client Page!</h1>
                <p>
                    This is client page which implements the WSN-API. Go to View Data to view some of the data. 
                </p> 
                <br><br><br><br><br><br><br><br><br><br><br>
                
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

