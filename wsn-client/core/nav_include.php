<?php

$index="myButtons";
$view_data="myButtons";
$contact="myButtons";

$menuLinkid=basename($_SERVER['PHP_SELF'], ".php");
if($menuLinkid=="index")
{
	$index='myActiveButton';
}
else if($menuLinkid=="view_data")
{
	$view_data='myActiveButton';
}
else if($menuLinkid=="contact")
{
	$contact='myActiveButton';
}

?>
    <ul>
        <li><a class="<?php echo $index; ?>" href="index.php">Home </a></li>
        <li><a class="<?php echo $view_data; ?>" href="view_data.php">View Data</a></li>
        <li><a class="<?php echo $contact; ?>" href="contact.php">Contact</a></li>
    </ul>
