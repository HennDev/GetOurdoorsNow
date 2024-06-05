<?php
	session_start();
	$title = "View My Outfitters";
	include($_SERVER['DOCUMENT_ROOT']."/database.php");
	include($_SERVER['DOCUMENT_ROOT']."/common.php");
	$error = "";
	$actionMsg = "";
	$pageID = "allUsersOutfitters";
	$genError = "";
	
	if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
	{
		$email = $_SESSION['Username'];
		
		$instance = new Outfitter;
		$outfitters = $instance->getAllUsersOutfitters($email);
		
		if($outfitters == -1)
		{
			$genError = 'You currently have no outfitters assigned';
		}
		
		if(!empty($_GET))
		{
			if ($_GET['action'] == 'delete')
			{ 
				$actionMsg = "Outfitter deleted";
			}
			
			if ($_GET['action'] == 'create')
			{ 
				$actionMsg = "Outfitter created successfully";
			}
		}
	}
	else
	{
		$error = "You must be logged in";
	}
	
	if(isset($outfitters) && $outfitters != -1)
	{
		foreach ($outfitters as $row) 
		{
			$id = $row['id'];
		}
	}
        include($_SERVER['DOCUMENT_ROOT'].'/include/top_start.php');
	// Any extra scripts go here
?>
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

   <link href="/css/simple-sidebar.css" rel="stylesheet"><script src="/js/holder.js"></script>
<?php
		
	include($_SERVER['DOCUMENT_ROOT'].'/include/top_end.php');

?>
<div class="container-fluid">
      <div class="row">
        
        <?php include($_SERVER['DOCUMENT_ROOT'].'/include/sidebar.php');?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main whiteBackground">
          <h3 class="page-header">Outfitter Dashboard</h3>

          <div class="row placeholders">
            <div class="col-lg-10 col-lg-offset-1 col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
		<div class="panel panel-default panel-success panel-success-custom .small-Panel">
			<div class="panel-heading clearfix text-center">
				<i class="icon-calendar"></i>
				<h3 class="panel-title"><?echo $title?></h3>
			</div>
			<div class="panel-body">


	<form action="allUsersOutfitters.php" method="post" id="myform">
	<input type="hidden" name="pageID" value="<?php echo $pageID?>">
<?php  
	if($error!="")
	{
	?>
			<div class="inlineblock alert alert-danger centerDiv" role="alert"><center><?=$error?></center></div>
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
		
if($actionMsg != "")
	{
?>
	<div class="inlineblock alert alert-success" role="alert"><?=$actionMsg?></div>
<?php
	}		
?>

<?php
	$limitReached = false;
	if(is_array($outfitters) && count($outfitters) >=1)
	{
		$limitReached = true;
	}
?>
	<span>
	<p style="clear:both">
		<input class='<?=$limitReached?'warningButton':'btn btn-primary'; ?>' <?=$limitReached?'disabled':''?> type="submit" data-url="linkOutfitter.php" id="btnCreate" name="btnCreate" value="Create New">
	</p>
<?php 
	if($limitReached)
	{
?>
	<div class="inlineblock alert alert-warning" role="alert">You have reached the limit of outfitters, please delete one to add more</div>
<?php
	}

	if(is_array($outfitters))
	{	
		?>
	<div class ="table-responsive" style="clear:both">
		<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>Name</th>
						<th>Address</th>
						<th>City</th>
						<th>State</th>
						<th>Type</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
<?php
		
		
		foreach ($outfitters as $row) 
		{
	?>
			<tr>
			<td><?php echo $row['name'] ?></td>
			<td><?php echo $row['address'] ?></td>
			<td><?php echo $row['city'] ?></td>
			<td><?php echo $row['state'] ?></td>
			<td>
	<?php
			switch($row['type'])
			{
				case "1":
						echo 'Hunting';
						break;
				case "2":
						echo 'Fishing';
						break;
				case "3":
						echo 'Both';
						break;
			}
	?>
			</td>
			<td>
				<input class='btn btn-success' type="submit" data-url="viewOutfitter.php?id=<?php echo $row['id'] ?>" id="btnView" name="btnView" value="View">
				<input class='btn btn-success' type="submit" data-url="editOutfitter.php?id=<?php echo $row['id'] ?>" id="btnEdit" name="btnEdit" value="Edit">
				<input class='btn btn-success' type="submit" data-url="deleteOutfitter.php?id=<?php echo $row['id'] ?>" id="btnDelete" name="btnDelete" value="Delete">
				</td>
			</tr>
	<?php
		}
	?>
						</tbody>
					</table>
							</div>
					<?php echo "Outfitter count: ".count($outfitters);?>
					</span>
	<?php 
		}
	}
?>

 </form>



				</div>
			</div>
		</div>
	</div>
			</div>
		  </div>
	</div>
<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/include/bottom.php');?>