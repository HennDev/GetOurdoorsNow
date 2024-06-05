<?php
	session_start();
	$title = "View All Outfitters";
	include($_SERVER['DOCUMENT_ROOT'].'/database.php');	
	include($_SERVER['DOCUMENT_ROOT'].'/common.php');
	$error = "";
	$actionMsg = "";
	$pageID = "allOutfitters";

	$instance = new Outfitter;
	$outfitters = $instance->getAllOutfitters();
	
if (!empty($_GET))
{
	if ($_GET['action'] == 'delete')
	{ 
		$actionMsg = "Outfitter deleted";
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
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/include/top_end.php');
?>
<div class="container">
	<div class="col-md-12">
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
			<div class="inlineblock alert alert-danger" role="alert"><?=$error?></div>
	<?php
	}
	else
	{
		
if($actionMsg != "")
	{
?>
	<div class="inlineblock alert alert-success" role="alert"><?=$actionMsg?></div>
<?php
	}		
?>
				<span>
				<p style="clear:both">
					<input class='btn btn-primary' type="submit" data-url="createOutfitter.php" id="btnCreate" name="btnCreate" value="Create New">
				</p>
			<div class ="table-responsive" style="clear:both">
			<table class="table table-hover table-bordered">
					<thead>
						<tr>
							<th>Name</th>
							<th>Address</th>
							<th>City</th>
							<th>State</th>
							<th>Phone</th>
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
			<td><?php echo $row->name ?></td>
			<td><?php echo $row->address ?></td>
			<td><?php echo $row->city ?></td>
			<td><?php echo $row->state ?></td>
			<td><?php echo $row->phone ?></td>
			<td>
<?php
			switch($row->type)
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
				<input class='btn btn-success' type="submit" data-url="viewOutfitter.php?id=<?php echo $row->id ?>" id="btnView" name="btnView" value="View">
				<input class='btn btn-success' type="submit" data-url="editOutfitter.php?id=<?php echo $row->id ?>" id="btnEdit" name="btnEdit" value="Edit">
				<input class='btn btn-success' type="submit" data-url="deleteOutfitter.php?id=<?php echo $row->id ?>" id="btnDelete" name="btnDelete" value="Delete">
				</td>
			</tr>
<?php
		}
?>
					</tbody>
				</table>
                        </div>
                                </span>
				
                <?php echo "Outfitter count: ".count($outfitters);?>
                </span>
<?php 
	} 
?> 
 </form>



				</div>
			</div>
		</div>
	</div>
<?php include($_SERVER['DOCUMENT_ROOT'].'/include/bottom.php');?>