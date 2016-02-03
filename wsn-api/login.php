<?php

session_start();

$username = $_POST['username'];
$password = $_POST['password'];

//echo "md5 password: " . md5($password);

if ($username&&$password) {
    //include database connection
    include("core/connect.php");
    
    $query = mysql_query("SELECT * FROM users WHERE username='$username'");
    
    $numrows = mysql_num_rows($query);
    
    if ($numrows!=0) {
        //code to login
        while ($row = mysql_fetch_assoc($query)) {
            $dbUsername = $row['username'];
            $dbPassword = $row['password'];
        }
        
        //check to see if they match
        if ($username==$dbUsername&&md5($password)==$dbPassword) {
            
            $_SESSION['username']=$dbUsername;
            header('Location: http://turing.une.edu.au/~jsteph32/wsn-api/adminpage.php');
        }
        else
            echo "Incorrect password. <a href='http://turing.une.edu.au/~jsteph32/wsn-api/index.php'>Click Here</a> to login with correct password.";
            
    }
    else
        die("This user doesn't exist! <a href='http://turing.une.edu.au/~jsteph32/wsn-api/index.php'>Click Here</a> to login.");
}
else
    die("Please enter username and password by <a href='http://turing.une.edu.au/~jsteph32/wsn-api/index.php'>Click Here</a>.");
?>
