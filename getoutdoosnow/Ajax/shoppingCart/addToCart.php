<?php
// Start the session
session_start();
// Set session variables
$_SESSION["activityID"] = $_POST["activityID"];


$guid = "Guid";

if(!isset($_COOKIE[$guid."_NumberInCart"]))
{
    setcookie("Guid", getGUID(), time()+60*60*24*30, '/');  /* expire in 30 days */
}
else
{
    //extend cookie
    setcookie($guid, $_COOKIE[$guid], time()+60*60*24*30, '/');  /* expire in 30 days */
}




?>
