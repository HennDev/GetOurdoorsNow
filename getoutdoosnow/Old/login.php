<?php
	session_start();
	$title = "Login";
	include('database.php');
	$error = "";
	$generalError = "";
	$newOutfitter = false;
	
	//User tried to create an outfitter first
	if(!empty($_GET))
	{
		if ($_GET['action'] == 'NewOutfitter')
		{ 
			$newOutfitter = true;
		}
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$passwordError = null;
		$emailError = null;
		
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
                    echo 'Location: '.$_SERVER["DOCUMENT_ROOT"].'linkOutfitter.php';
					header( 'Location: '.$_SERVER["DOCUMENT_ROOT"].'linkOutfitter.php' );
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
					$generalError = "Sorry, your account could not be found. Please try again</p>";
				}
				else if($users == 0)
				{
					$generalError = "Sorry, your account credentials are incorrect try again";
				}
			}
		}
	}
	
	include('include/top_start.php');
	include('include/top_end.php');

?>
 <article id="loginWrapper" class="roundDiv">
	<div class="divHeader roundDiv">
		<?=$title?>
	</div>
	<div id="loginContent">

<?php  
	if($error!="")
	{
?>
			<div class="inlineblock alert alert-danger" role="alert"><?=$error?></div> echo $error;
<?php
	}
	else	if ($generalError != "")
	{
?>
		<div class="inlineblock alert alert-danger" role="alert"><?=$generalError?></div>
<?php 
		}
?>
			<p>Thanks for visiting! Please either login below, or <a href="createUser.php">click here to register</a>.</p>
				
			<form class="form-horizontal" action="login.php" name="loginform" id="loginform" method="post">
			<div class="control-group <?php echo !empty($emailError)?'error':'';?>">
				<label class="control-label">Email</label>
				<div class="controls">
					<input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
					<?php if (!empty($emailError)): ?>
					<span class="help-inline"><?php echo $emailError;?></span>
					<?php endif;?>
				</div>
				</div>
			<div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
			<label class="control-label">Password</label>
			<div class="controls">
				<input name="password" type="password"  placeholder="Password" value="<?php echo !empty($password)?$password:'';?>">
				<?php if (!empty($passwordError)): ?>
				<span class="help-inline"><?php echo $passwordError;?></span>
				<?php endif; ?>
			</div>
			</div>
			
			<input name="newOutfitter" type="hidden" value="<?php echo $newOutfitter?'1':'0';?>">
			
			<div class="form-actions">
				<button type="submit" class="button">login</button>
			</div>
		</form>
	</div>
	</article> <!-- /container -->
<?php
include('include/bottom.php');
?>
