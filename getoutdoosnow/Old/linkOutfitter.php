<?php
	session_start();
	$title = "Create a new Outfitter";
	include("database.php");	
	include("common.php");
	$pageID = "linkOutfitter";
	$error = "";
	$success = false;
	$states = getAllStates();
	
	// keep track validation errors
	$nameError = null;
	$stateError = null;
	$cityError = null;
	$addressError = null;
	$typeError = null;
	$phoneError = null;

	if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
	{
		$email = $_SESSION['Username'];
		
		$instance = new Outfitter;
		$outfitters = $instance->getAllUsersOutfitters($email);
		
		$limitReached = false;
		if(count($outfitters) >=	2)
		{
			$limitReached = true;
		}
		
		if($limitReached)
		{
			header( 'Location: allUsersOutfitters.php' );
		}		
	
		if (!empty($_POST) && $_POST['pageID'] == $pageID) 
		{
			// keep track post values
			$name = $_POST['name'];
			$state = !empty($_POST['state'])?$_POST['state']:'';
			$city = $_POST['city'];
			$address = $_POST['address'];
			$type = !empty($_POST['type'])?$_POST['type']:'';
			$phone = $_POST['phone'];
						
			// validate input
			$valid = true;
			if (empty($name)) 
			{
				$nameError = 'Please enter Name';
				$valid = false;
			}
			
			if (empty($state)) {
				$stateError = 'Please enter State';
				$valid = false;
			}
			
			if (empty($city)) {
				$cityError = 'Please enter City';
				$valid = false;
			}
			
			if (empty($address)) {
				$addressError = 'Please enter Address';
				$valid = false;
			}
			
			if (empty($type)) {
				$typeError = 'Please enter Type';
				$valid = false;
			}
		
			if (empty($phone)) {
				$phoneError = 'Please enter Phone Number';
				$valid = false;
			}
			else
			{
				$phoneVal = preg_replace('/[^0-9]/', '', $phone);
				if(strlen($phoneVal) != 10) {
				    $phoneError = 'Please enter a 10 digit Phone Number';
				    $valid = false;
				}
			}
			
	        // insert data
	        if ($valid) {
	        
				$instance = Outfitter::withAllButID($name, $email, $state, $city, $address, $type, $phone);
				$outfitters = $instance->linkOutfitter();
				
				if($outfitters)
				{
					header( 'Location: allUsersOutfitters.php?action=create' ) ;
				}
				else
				{
					unknownErr();
					$valid = false;
				}
	        }
	    }
    }
    else
    {
    	header( 'Location: createUser.php?action=NewOutfitter' );
    }
	include('include/top_start.php');
?>
	
	
<?php
include('include/top_end.php');
?>

  <!-- Page Content -->
    <div class="container">
		<div class="row">
    <div class="col-lg-12">
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
	else
	{
		if ($success)
		{
?>
			<div class="inlineblock alert alert-success" role="alert">Outfitter created successfully</div>
<?php
		}
?>
	 <form class="form-horizontal" action="linkOutfitter.php" method="post">
	<input type="hidden" name="pageID" value="<?php echo $pageID?>">		
<?php
	
	 FormElementCreate('email','Email Address',null,!empty($email)?$email:'',null,'disabled');
	 FormElementCreate('name','Name',$nameError,!empty($name)?$name:'');
	 FormElementCreate('address','Address',$addressError,!empty($address)?$address:'');
	 FormElementCreate('city','City',$cityError,!empty($city)?$city:'');
	 FormElementCreate('phone','Phone',$phoneError,!empty($phone)?$phone:'');
?>

		<div class="control-group <?php echo !empty($stateError)?'error':'';?>">
                        <label class="control-label">State</label>
                        <div class="controls">
	                        <select id="state" name="state" >
									<option value="<?php echo !empty($state)?$state:'';?>" selected disabled>Please select</option>
<?php
		foreach ($states as $row) 
		{
			$selected = "";
			if($row['state_id'] ==$state)
			{
				$selected = "selected";
			}
			echo '<option '.$selected.' value='. $row['state_id'] . '>'.$row['abbreviation'].'</option>';
		}
?>
							</select>
				<?php if (!empty($stateError)): ?>
								<span class="help-inline"><?php echo $stateError;?></span>
				<?php endif;?>
							</div>
						</div>
		<div class="control-group <?php echo !empty($typeError)?'error':'';?>">
			<label class="control-label">Type</label>
			<div class="controls">
				<select id="type" name="type" >
					<option value="<?php echo !empty($type)?$type:'';?>" selected disabled>Please select</option>
					<option <?php echo !empty($type) && $type=="1"?'selected':'';?> value="1">Hunting</option>
					<option <?php echo !empty($type) && $type=="2"?'selected':'';?> value="2">Fishing</option>
					<option <?php echo !empty($type) && $type=="3"?'selected':'';?> value="3">Both</option>
				</select>
				<?php if (!empty($typeError)): ?>
					<span class="help-inline"><?php echo $typeError;?></span>
				<?php endif;?>
				</div>
			</div> 
		<div class="form-actions">
				<button type="submit" class="button">Create</button>
			</div>
		</form>
<?php 
	} 
?>
	</div>
	</article> <!-- /container -->
 
 </div> <!-- /.col-xs-12 -->
    	</div> <!-- /.row -->
    </div>
<?php
include('include/bottom.php');
?>
