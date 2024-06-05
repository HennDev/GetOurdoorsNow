<?php

$error = "";
$success = false;
$title = "Delete Image";
include($_SERVER['DOCUMENT_ROOT']."/database.php");	
include($_SERVER['DOCUMENT_ROOT']."/common.php");

$valid = false;



if (!empty($_GET))
{
	if ($_POST['id'] != '' && $_POST['pageID'] != '' && $_GET['imageId'] != '')
	{ 
		$valid = true;
		$id = $_POST['id'];
		$pageID = $_POST['pageID'];
		$imageID = $_GET['imageId'];
	}
	
	
}
else
{
	$error = "No ID passed";
}


if($valid)
{
	$instance = Image::withID($imageID);
	$outfitter = $instance->deleteImage();
	$instance->printImageInfo();
	
	if($outfitter)
	{
		header( 'Location: '.$pageID.'.php?id='.$id.'&action=delete');
	}
	else
	{
		$error = "deletion unsuccessful";
	}
}

include($_SERVER['DOCUMENT_ROOT'].'/include/top_start.php');

include($_SERVER['DOCUMENT_ROOT'].'/include/top_end.php');
?>
 <div class="container">
	<div class="col-md-12">
		<div class="panel panel-default panel-success .small-Panel">
			<div class="panel-heading clearfix text-center">
				<i class="icon-calendar"></i>
				<h3 class="panel-title"><?echo $title?></h3>
			</div>
			<div class="panel-body">
	
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
			</div>
		</div>
	</div>
	</div> <!-- /container -->
<?php
include($_SERVER['DOCUMENT_ROOT'].'/include/bottom.php');
?>