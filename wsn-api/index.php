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
                <h1>Well come to Wireless Network Sensor API!</h1>
                <p>
                    The Wireless Sensor Networks (WSN) API is used to provide data collected by wireless sensor networks. 
                    This document describes the WSN API and its usage. Access to the API requires an account and an API key.
                </p> 
                
                <p>
                    In every request the users email address, password and the API key will be sent together with the request. 
                    All responses are provided in a standard JSON format.
                </p>
                <br>
                <h2>Downloads</h2>
                <p><a href="./downloads/WSN-API_Document.pdf">WSN API Documentation (V.1.0)</a></p>
                <p><a href="./downloads/wsn-api_class.zip">WSN API Class for Client (V.1.0)</a></p>
                <br><br><br><br><br><br><br><br><br><br>
                
            </div>
            <div id="one-fourth">
                <h1>Admin Login</h1>
                    <form action="login.php" autocomplete="on" method="POST">
                        <fieldset>
                            <legend>Login:</legend>
                            <table>
                                <tr>
                                    <th>User name: </th>
                                    <th><input type="text" name="username"></th>
                                </tr>
                                <tr>
                                    <td>Password:</td>
                                    <td><input type="password" name="password"></td>
                                </tr>
                            </table>
                            <!--Code for Captcha-->
                            
                            <!-- End of Code for Captcha-->
                            <input type="submit" value="Submit">
                        </fieldset>
                    </form>                
            </div>
        </article>

        <footer>
            <?php require_once('core/footer_include.php'); ?>
        </footer>

    </div>
</body>
</html>

