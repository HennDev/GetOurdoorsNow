<?php
session_start();
header('Content-Type: application/json');
include("../database.php");
include("../common.php");

if(!empty($_GET))
{
    if(!empty($_GET['id']))
    {

        $allOutfitterActivities = getAllOutfitterActivities(true);
        $regions = json_encode($allOutfitterActivities[$_GET['id']]);
        echo $regions;
    }
}
?>