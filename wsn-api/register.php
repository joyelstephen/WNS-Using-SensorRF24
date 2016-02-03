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
                                    <td><input type="password" name="password"></td>
                                </tr>
                                <tr>
                                    <td>Password:</td>
                                    <td><input type="password" name="password"></td>
                                </tr>
                                <tr>
                                    <td>Re-enter Password:</td>
                                    <td><input type="password" name="password"></td>
                                </tr>
                            </table>
                            <br>
                            <input type="submit" value="Submit">
                        </fieldset>
                    </form>
                <br>
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

