<?php
	session_start();
	$title = "Login";
	include('database.php');
	include('common.php');
	$error = "";
	$generalError = "";
	$newOutfitter = false;
	$passwordError = null;
	$emailError = null;
	
	//User tried to create an outfitter first
	if(!empty($_GET))
	{
		if (!empty($_GET['action']) && $_GET['action'] == 'NewOutfitter')
		{ 
			$newOutfitter = true;
		}
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		
		// keep track post values
		$password = $_POST['password'];
		$email = $_POST['email'];
    
	    if($_POST['newOutfitter'] == '1')
		{ 
			$newOutfitter = true;
		}   
		
		// validate input
		$valid = true;
		if (empty($password)) 
		{
			$passwordError = 'Please enter Password';
			$valid = false;
		}
		
		if (empty($email)) 
		{
			$emailError = 'Please enter Email Address';
			$valid = false;
		}
		
		// insert data
		if ($valid)
		{
			$instance = new User;
			$users = $instance->authenticate($email,$password);
			// Insert $hashAndSalt into database against user
			//$hashAndSalt = password_hash($password, PASSWORD_BCRYPT);
			//echo "~~~$hashAndSalt~~~";
			
			if($users == 1)
			{
				//Correct user/password
				$_SESSION['Username'] = $email;
				$_SESSION['EmailAddress'] = $email;
				$_SESSION['LoggedIn'] = 1;
				$_SESSION['FirstName'] = $instance->firstName;
				$_SESSION['LastName'] = $instance->lastName;
				$_SESSION['Roles'] = $instance->roles;
				
				if($newOutfitter)
				{
					header( 'Location: linkOutfitter.php' );
				}
				else
				{
					header( 'Location: index.php' ) ;
				}
			}
			else
			{
				$valid = false;
				if($users == -1)
				{
					$emailError = "Sorry, your account could not be found. Please try again</p>";
				}
				else if($users == 0)
				{
					$emailError = "Sorry, your account credentials are incorrect try again";
				}
			}
		}
	}
?>

<?php include('include/top_start.php');?>
<?php include('include/top_end.php');?>


<div class="container">
	<div class="col-md-6 col-md-offset-3 col-sm-6 col-xs-12">
		<div class="panel panel-default panel-success .small-Panel">
			<div class="panel-heading clearfix text-center">
				<i class="icon-calendar"></i>
				<h3 class="panel-title"><?echo $title?></h3>
			</div>
			<div class="panel-body">
				<form class="form-horizontal row-border" action="login.php" method="post">
					<?php 
						echo FormElementCreate2('email','E-mail',$emailError,!empty($email)?$email:'',"email","required");
						echo FormElementCreate2('password','Password',$passwordError,!empty($password)?$password:'',"password","required");
					?>
					<div class="form-group">
						<div class="col-md-2 col-md-offset-5">
							<button type="submit" class="btn btn-success">Login</button>
						</div>
					</div>
					<input name="newOutfitter" type="hidden" value="<?php echo $newOutfitter?'1':'0';?>">    
				</form>
			</div>
		</div>
	</div>
<?php include('include/bottom.php');?>