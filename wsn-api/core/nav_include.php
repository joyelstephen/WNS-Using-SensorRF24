<?php

$index="myButtons";
$register="myButtons";
$contact="myButtons";

$menuLinkid=basename($_SERVER['PHP_SELF'], ".php");
if($menuLinkid=="index")
{
	$index='myActiveButton';
}
else if($menuLinkid=="register")
{
	$register='myActiveButton';
}
else if($menuLinkid=="contact")
{
	$contact='myActiveButton';
}

?>
    <ul>
        <li><a class="<?php echo $index; ?>" href="index.php">Home </a></li>
        <li><a class="<?php echo $register; ?>" href="register.php">Register</a></li>
        <li><a class="<?php echo $contact; ?>" href="contact.php">Contact</a></li>
    </ul>
