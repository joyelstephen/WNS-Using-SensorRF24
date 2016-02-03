<?php

    //function that generates the API Key
    function RandomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 32; $i++) {
            $randstring = $randstring . $characters[rand(0, strlen($characters))];
        }
        return $randstring;
    }

    if(isset($_POST["submit"]))
    {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $re_password = $_POST['re_password'];


        //echo "md5 password: " . md5($password);
        
        if ($username&&$email&&$password&&$re_password) {
            // TODO: here do some format checking for the email
        
            if($password != $re_password) {
                $error = "<b>Password does not match.</b>";
            }
            else
            {
                //include database connection
                include("core/connect.php");

                // generate API Key and check if it exist generate new one
                $flag = true;
                //while(!$flag)
                {
                    $api = RandomString();
                    
                    //check it in the database
                    //if found go to the loop and genrate new
                    
                    //esle set flag to flase
                    // $flag = false;
                }
                
                // now insert the data and the API-Key into the database
                
                
                
            }

        }
        else
            $error = "<b>Please fill all fields.</b>";
            
    }   
    
    
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
                <h1>Registration!</h1>                
                <?php
                    // error messager
                    if(isset($error))
                    {
                        echo "$error <br>";
                    }
                ?>
                
                <?php
                    if(isset($api))
                    {
                        echo "<form><fieldset><legend> API Key</legend>
                               <table>
                                <tr><td><h2>$api</h2>Please keep this API-Key in safe place. If you loos your API Key email us through the contact form. <br>
                                </td></tr></table></fieldset></form>";
                        
                    } 
                    else
                    {
                    ?>        
                        <p>Pleas register below to get API Key.</p>
                        <form action="register.php" autocomplete="on" method="POST">
                                <fieldset>
                                    <legend>Register:</legend>
                                    <table>
                                        <tr>
                                            <td>User name: </td>
                                            <td><input type="text" name="username"></td>
                                        </tr>
                                        <tr>
                                            <td>Email:</td>
                                            <td><input type="text" name="email"></td>
                                        </tr>
                                        <tr>
                                            <td>Password:</td>
                                            <td><input type="password" name="password"></td>
                                        </tr>
                                        <tr>
                                            <td>Re-enter Password:</td>
                                            <td><input type="password" name="re_password"></td>
                                        </tr>
                                    </table>
                                    <br>
                                    <input type="submit" value="Submit" name="submit">
                                </fieldset>
                            </form>
                        <br>
                    <?php
                    }
                    ?>
               
            </div>
            <div id="one-fourth">
                
            </div>
        </article>

        <footer>
            <?php require_once('core/footer_include.php'); ?>
        </footer>

    </div>
</body>
</html>

