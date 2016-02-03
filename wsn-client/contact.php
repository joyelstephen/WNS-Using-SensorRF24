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
            <h1>Contact</h1>
            <p>This is the contact page!</p>
            <table width="500" border="0" cellpadding="0" cellspacing="10">
                <form action="contact.php" method="POST">
                        <!--  <?php
                        if ($_POST['submit']) {
                            //get form data
                            $name = $_POST['name'];
                            $email = $_POST['email'];
                            $subject = $_POST['subject'];
                            $message = $_POST['message'];

                            //default value of error string
                            $errorstring = "";

                            //Checking for error
                            if (!$name) //checking if name exsist
                                $errorstring = $errorstring . "*Name<br>";
                            if (strlen($name) < 2 && strlen($name) > 0) //checking if name is less that 2 characters
                                $errorstring = $errorstring . "*Name (should be more than 2 char length)<br>";
                            if (strlen($name) > 25) //checking if name is greater that 2 characters
                                $errorstring = $errorstring . "*Name (should be less than 25 char length)<br>";

                            if (!$email) //checking if email exsist
                                $errorstring = $errorstring . "*E-mail<br>";

                            //Checking if the E-Mail is valid
                            $result = ereg("^[^@ ]+@[^@ ]+\.[^@ ]+$", $email, $trashed);
                            if ($email) {
                                if (!$result)
                                    $errorstring = $errorstring . "*E-mail (Enter a valid email address)<br>";
                            }

                            if (strlen($email) > 30) //checking if email is greater that 30 characters
                                $errorstring = $errorstring . "*E-mail (should be less than 30 char length)<br>";

                            if (!$subject) //checking if message is written
                                $errorstring = $errorstring . "*Subject<br>";
                            if (strlen($subject) < 2 && strlen($subject) > 0) //checking if message is less that 3 characters
                                $errorstring = $errorstring . "*Subject (should be more than 1 char length)<br>";
                            if (strlen($subject) > 30) //checking if name is greater that 30 characters
                                $errorstring = $errorstring . "*Subject (should be less than 30 char length)<br>";

                            if (!$message) //checking if message is written
                                $errorstring = $errorstring . "*Message<br>";
                            if (strlen($message) < 3 && strlen($message) > 0) //checking if message is less that 3 characters
                                $errorstring = $errorstring . "*Message (should be more than 3 char length)<br>";
                            if (strlen($message) > 500) //checking if name is greater that 500 characters
                                $errorstring = $errorstring . "*Message (should be less than 500 char length)<br>";

                            //Display error massage
                            if ($errorstring != "")
                                echo "Please Fill out the following fields:<br>$errorstring";

                            else {
                                //Start bulding the mail
                                $msg = "Name= " . $name . "\n";
                                $msg .= "E-Mail= " . $email . "\n";
                                $msg .= "Subject= " . $subject . "\n";
                                $msg .= "Message= " . $message . "\n";
                                //Set up the mail
                                $recipient = "jsteph32@myune.edu.au";
                                $subject = "Email through the website";
                                $mailheaders = "From: " . $name . "\n";
                                $mailheaders .= "E-Mail:" . $email;

                                //Send the mail
                                mail($recipient, $subject, $msg, $mailheaders);

                                //desplay succes message to the user

                                echo "<p> Thank you <b>" . $name . "</b> for contacting us.
                                                                        <br/> Your submision has been sent succesfuly.
                                                                        <br/>The admin will be in touch with you regarding you message shortly.<br/>
                                                                        <br/>
                                                                        <br/>WSN Client (Web Portal) </p>";
                                exit;
                            }
                        }
                        ?> -->
                        <tr>
                            <td align="left" valign="top">
                                Name*
                                <label for="name"></label>
                            </td>
                        </tr>

                        <tr>
                            <td width="300" align="left" valign="top">
                                <!--<input name="name" value='<?php echo $name; ?>' type="text" id="name" size="45" />-->
                                <input name="name" type="text" id="name" size="45" />
                            </td>
                        </tr>

                        <tr>
                            <td align="left" valign="top">
                                Email*
                                <label for="email"></label>
                            </td>
                        </tr>

                        <tr>
                            <td align="left" valign="top">
                                <!--<input name="email" value='<?php echo $email; ?>' type="text" id="email" size="45" />-->
                                <input name="email" type="text" id="email" size="45" />
                            </td>
                        </tr>

                        <tr>
                            <td align="left">
                                Subject*
                                <label for="subject"></label>
                            </td>
                        </tr>

                        <tr>
                            <td align="left">
                                <!--<input name="subject" value='<?php echo $subject; ?>' type="text" id="subject" size="45" />-->
                                <input name="subject" type="text" id="subject" size="45" />
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" align="left" valign="top">
                                Content of your message?*
                                <label for="massage"></label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left" valign="top">
                                <!--<textarea name="message" id="message" cols="40" rows="5"><?php echo $message; ?></textarea><br />-->
                                <textarea name="message" id="message" cols="40" rows="5"></textarea><br />
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" align="left" valign="top">
                                <!--<?php
                                if (!$_POST['submit']) {
                                    echo "* = Required field";
                                }
                                ?> -->
                                <br />
                                <label for="massage"></label>
                                <label for="mailing"></label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left">
                                <input type="submit" name="submit" id="submit" value="Submit" />
                            </td>
                        </tr>
                    </fieldset>
                </form>
            </table>
            </div>
        </article>

        <footer>
            <?php require_once('core/footer_include.php'); ?>
        </footer>

    </div>
</body>
</html>

