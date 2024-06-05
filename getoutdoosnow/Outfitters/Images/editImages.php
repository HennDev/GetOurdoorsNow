<?php
	session_start();	
    $title = "Manage Images";
	include($_SERVER['DOCUMENT_ROOT']."/database.php");	
	include($_SERVER['DOCUMENT_ROOT']."/common.php");
	$pageID = "editImages";
	$error = "";
	$genError = "";
	$success = false;
		$valid_mime_types = array(
    "image/gif",
    "image/png",
    "image/jpeg",
    "image/pjpeg",
);
	
	// keep track validation errors
	$descriptionError = null;
	$fileError = null;
	
	// keep track validation errors
	if(empty($_SESSION['LoggedIn']) || empty($_SESSION['Username']))
	{
		$error = "You must be logged in";
	}
	else
	{
		$id = $_REQUEST['id'];
		$outfitterID = $id;
		$email = $_SESSION['Username'];
		$instance = new User;
		$user = $instance->getUser($email);
		
		if($user==-1)
		{
			$error .=  " User with $email does not exist";
		}
		else
		{
			foreach ($user as $row) 
			{
				$userID = $row['user_id'];
			}
		}
		function countImages($outfitter_ID)
		{
			$directory = $_SERVER['DOCUMENT_ROOT'].'/upload/images/'.$outfitter_ID.'/';
			$files = glob($directory. '/*');
			
			if ( $files !== false )
			{
				return count( $files );
			}
			else
			{
				return -1;
			}
		}

		if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['pageID'] == $pageID)
		{
			$valid = true;
			$description = !empty($_POST['description'])?$_POST['description']:'';

			if (empty($description))
			{
				$descriptionError = 'Please enter description';
				$valid = false;
			}

			if ($valid)
			{
				if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/upload/images/' . $outfitterID)) {
					//create directory is not exists
					mkdir($_SERVER['DOCUMENT_ROOT'] . '/upload/images/' . $outfitterID, 0777, true);
				}

				if (empty($_FILES['file_upload']['name'])) {
					$fileError = "Please upload an image";
				} else if ($_FILES['file_upload']['error'] > 0) {
					$error = "An error ocurred when uploading.";
				} else if (!getimagesize($_FILES['file_upload']['tmp_name'])) {
					$error = "Please upload an image";
				} else if (!in_array($_FILES['file_upload']['type'], $valid_mime_types)) {
					$error = "Please upload an image";
				} else if ($_FILES['file_upload']['size'] > 5000000000)//500000
				{
					$error = "File uploaded exceeds maximum upload size";
				} else {
					$fileName = $_FILES['file_upload']['name'];
					$fileType = explode('/', $_FILES['file_upload']['type']);
					$fileType = $fileType[1];


					$myImage = Image::withAllButID($fileName, $description, $fileType, $outfitterID);
					$results = $myImage->insertImage();

					echo $myImage->id;
					if (!$results) {
						$error = "no write";
					}
					if (!move_uploaded_file($_FILES['file_upload']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/upload/images/' . $outfitterID . '/' . $myImage->id . '.' . $fileType)) {
						// Upload file
						$error = "Error uploading file - check destination is writeable.";
					} else {
						$success = true;
						$description = "";
					}
				}
			}
		}
		else if(isset($_REQUEST['id']))
		{
			$id = $_REQUEST['id'];
		}
		else
		{
			$error = "Please enter an ID";
		}
		
		if($error == "")
		{
			$filecount = countImages($outfitterID);
			$instance = new Image;
			$images = $instance->getAllOutfitterImages($outfitterID);
			//echo print_r($images,true);
		}
	}
include($_SERVER['DOCUMENT_ROOT']."/include/top_start.php");
?>
   <link href="/css/simple-sidebar.css" rel="stylesheet"><script src="/js/holder.js"></script>

	<script>
	$( document ).ready(function() {
		  $("#btnDelete, #btnEdit, #btnView, #btnCreate").click(function(e) {
		    e.preventDefault();
		
		    var form = $("#myform");
		    form.prop("action", $(this).data("url"));
		    form.submit();
		  	});
   });
</script>
<?php
include($_SERVER['DOCUMENT_ROOT']."/include/top_end.php");
?>
<div class="container-fluid">
      <div class="row">
        
        <?php include($_SERVER['DOCUMENT_ROOT'].'/include/sidebar.php');?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main whiteBackground">
          <h3 class="page-header">Outfitter Dashboard</h3>

          <div class="row placeholders">
            <div class="col-lg-6 col-lg-offset-3 col-md-7 col-md-offset-3 col-sm-12 col-xs-12">
		<div class="panel panel-default panel-success panel-success-custom .small-Panel">
			<div class="panel-heading clearfix text-center">
				<i class="icon-calendar"></i>
				<h3 class="panel-title"><?echo $title?></h3>
			</div>
			<div class="panel-body">
<?php  
	if($error!="")
	{
	?>
			<div class="inlineblock alert alert-danger" role="alert"><?=$error?></div>
	<?php
	}
	else
	{
		if ($success)
		{
?>
			<div class="inlineblock alert alert-success" role="alert">File uploaded successfully</div>
<?php
		}
		else
		{
			if($genError!="")
			{
?>
				<div class="inlineblock alert alert-danger" role="alert"><?=$genError?></a></div>
<?php
			}
}
?>
	 	<form class="form-horizontal row-border" enctype='multipart/form-data' action="<?php echo $pageID ?>.php?id=<?php echo $id?>" method="post" role="form" id="myform">
		 	<input type="hidden" name="pageID" value="<?php echo $pageID?>">
			<input type="hidden" name="id" value="<?php echo $id?>">
                     
			
				
<?php /*				$output = '<div class="form-group '. $errorClass.'">';
		$output .= '<label class="col-md-4 control-label">'.$passed.'</label>';
		$output .='<div class="col-md-7">';
		$output .= '<input '.$otherAttributes.' name="'.$passedLower.'" type="'.$type.'"  placeholder="'.$passed.'" value="'.$passedValue.'" class="form-control" required>';
		$output .= '</div>';
		
		if (!empty($passedError))
		{
			$output .= '<div class="col-md-12 col-md-offset-2"><label class="control-label" for="inputError">'.$passedError.'</label> </div>';
		}
		
		$output .= '</div>';
		echo $output;
		
		
					echo FormElementCreate2('name','Name',$descriptionError,!empty($name)?$name:'',null,"required");*/

		
			
?>
			<div class="col-lg-6 col-lg-offset-3 col-md-7 col-md-offset-3 col-sm-12 col-xs-12">
				<div class="form-group <?php if($fileError != "") echo "has-error"?>">
					<label class="col-md-2 control-label">File</label>
						<div class="col-md-7">
							<input name="file_upload" class="file btn" type="file"  >
<?php							if($fileError != "")
	{?>
					<label class="control-label" for="inputError"><?php echo $fileError?>r</label>
<?php
	}
?>
						</div>
				</div>
<?php
					echo FormElementCreate2('description','Description',$descriptionError,!empty($description)?$description:'',null,"required");
?>
					</div>
				 
			
			<?php //echo $outfitterID .  '   count: '.$filecount?>
			<div class="col-lg-6 col-lg-offset-3 col-md-7 col-md-offset-3 col-sm-12 col-xs-12">
				 <button type="submit" class="btn btn-success">Upload</button>
			</div>
				<br>
				<br>
				<br>
			</div>
			
			<?php
			$directory = $_SERVER['DOCUMENT_ROOT'].'/upload/images/'.$outfitterID.'/';
			$files = glob($directory. '/*');
			
			if ( $files !== false )
			{
?>
			<br><br><br><br>
		<div class ="table-responsive" style="clear:both">
		<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>Image</th>
						<th>Description</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
<?php
				//echo print_r($files);
				//foreach($files as $image) 
				//{	
				foreach ($images as $row) 
				{
					$extension = $row['type'];
					//$explodeIt = explode('/',$image);
					//$imageName = $explodeIt[(count($explodeIt) - 1)];
					//echo print_r(explode('/',$image),true);
					?>
				<tr>
					<td>
						<img style= "max-height: 300px; max-width: 200px;"  src="/upload/images/<?php echo $row['outfitter_id'] ?>/<?php echo $row['id'].".".$extension?>" /><br />
					</td>
					<td><?php echo $row['description'] ?></td>
					<td>
						<input class='btn btn-success' type="submit" data-url="editImage.php?imageId=<?php echo $row['id'] ?>" id="btnEdit" name="btnEdit" value="Edit">
						<input class='btn btn-success' type="submit" data-url="deleteImage.php?imageId=<?php echo $row['id'] ?>" id="btnDelete" name="btnDelete" value="Delete">
					</td>
				</tr>
<?php			
				}
				?>
			</tbody>
					</table>
							</div>
			
			<?php	
			}
			else
			{
				echo "No Images";
			}
			?>
		</form>
<?php 
	} 
?>
				</div>
			</div>
		</div>
	
	
	</div>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/bottom.php");?>
