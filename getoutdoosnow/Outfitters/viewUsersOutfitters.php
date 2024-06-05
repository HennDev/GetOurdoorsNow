<?php
	session_start();
	$title = "login page";
	include($_SERVER['DOCUMENT_ROOT']."/database.php");	
	include($_SERVER['DOCUMENT_ROOT']."/common.php");
	$error = "";
	
	if(isset($_REQUEST['id']))
	{
		$id = $_REQUEST['id'];
		$instance = Outfitter::withID($id);
		$outfitter = $instance->getOutfitter();
		
		if($outfitter==-1)
		{
			$error .=  " Outfitter $id does not exsist";
		}
	}
	else
	{
		$error = "Please enter an ID";
	}

	include($_SERVER['DOCUMENT_ROOT']."/include/top_start.php");
	// Any extra scripts go here
?>

	
	
<?php
include($_SERVER['DOCUMENT_ROOT']."/include/top_end.php");

?>
 <article id="innerPageWrapper" class="roundDiv">
	<div class="divHeader roundDiv">
		View Outfitter
	</div>
<?php  
	if($error!="")
	{
		echo $error;
	}
	else
	{
?>
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Name</th>
							<th>Email Address</th>
							<th>Address</th>
							<th>City</th>
							<th>State</th>
							<th>Type</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
<?php
		
		foreach ($outfitter as $row) 
		{
			echo '<tr>';
			echo '<td>'. $row->name . '</td>';
			echo '<td>'. $row->email . '</td>';
			echo '<td>'. $row->address . '</td>';
			echo '<td>'. $row->city . '</td>';
			echo '<td>'. $row->state . '</td>';
			echo '<td>';
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
			echo '</td>';
			echo '<td>';
			echo '<a class="btn" href="editOutfitter.php?id='.$row->id.'">Edit</a>';
			echo '<a class="btn" href="deleteOutfitter.php?id='.$row->id.'">Delete</a></td>';
			echo '</tr>';
			
			$mapAddress = $row->address . ' '. $row->city . ' '. $row->state  . ' US';
		}
?>
					</tbody>
				</table>
<?php 
	} 
?>
	</article> <!-- /container -->
	<article>
		<center>
  <iframe width="600" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=<?php echo $mapAddress?>&key=AIzaSyDZ6xoudqhcPl7MnRpaUvyZM-pN78gphjg"></iframe>
		</center>
	</article>
<?php
include($_SERVER['DOCUMENT_ROOT']."/include/bottom.php");
?>
