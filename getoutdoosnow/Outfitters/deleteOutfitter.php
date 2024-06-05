<?php

$error = "";
$success = false;
$title = "Delete Outfitter";
include($_SERVER['DOCUMENT_ROOT']."/database.php");	
include($_SERVER['DOCUMENT_ROOT']."/common.php");
$valid = false;


if (!empty($_GET))
{
	if ($_GET['id'] != '')
	{ 
		$valid = true;
		$id = $_GET['id'];
	}
	
	if ($_POST['pageID'] != '')
	{ 
		$valid = true;
		$pageID = $_POST['pageID'];
	}
}
else
{
	$error = "No ID passed";
}


if($valid)
{
	$instance = Outfitter::withID($id);
	$outfitter = $instance->deleteOutfitter();

	if($outfitter)
	{
		header( 'Location: '.$pageID.'.php?action=delete');
	}
	else
	{
		$error = "deletion unsuccessful";
	}
}

include($_SERVER['DOCUMENT_ROOT'].'/include/top_start.php');

include($_SERVER['DOCUMENT_ROOT'].'/include/top_end.php');
?>
 <article id="innerPageWrapper" class="roundDiv">
	<div class="divHeader roundDiv">
		<?=$title?>
	</div>
	
	<div id="loginContent">
<?php  
	if($error!="")
	{
		?>
		<div class="inlineblock alert alert-danger" role="alert"><?=$error?></div>
		<?php
	}
?>
	</div>
	</article> <!-- /container -->
<?php
include($_SERVER['DOCUMENT_ROOT'].'/include/bottom.php');
?>