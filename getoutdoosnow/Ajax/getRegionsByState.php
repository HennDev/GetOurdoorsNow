<?php
	session_start();
	header('Content-Type: application/json');
	include("../database.php");	
	include("../common.php");
	
	if(!empty($_GET))
	{
		if(!empty($_GET['state_id']))
		{
			$regions = json_encode(getRegionByState($_GET['state_id']));
			echo  $regions;
		}
	}
?>