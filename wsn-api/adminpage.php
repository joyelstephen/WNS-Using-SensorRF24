<?php 
    session_start(); 
    
    if (!$_SESSION['username'])// If not loged in go back to the login page - admin.php
        header('Location: http://turing.une.edu.au/~jsteph32/wsn-api/index.php');
        //header('Location: http://turing.une.edu.au/~icheck/');
    
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
        <nav id="green">
            <?php
                require_once('core/nav_include.php');
                /*
                if (!$_SESSION['username']){ // If not loged in go back to the login page - admin.php
                    require_once('core/nav_include.php');
                }
                else {
                    require_once('core/nav_admin_include.php');
                }
                */
            ?>
        </nav>
        <article>
            <div id="admin-three-fourth">
                <h1>Admin page</h1>
                <h2>Welcome to Admin page of WSN API!</h2>               
            </div>
        </article>

        <footer>
            <?php require_once('core/footer_include.php'); ?>
        </footer>

    </div>
</body>
</html>