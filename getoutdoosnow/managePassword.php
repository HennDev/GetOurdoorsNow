<?php
	session_start();
	$title = "Manage my password";
	$error = "";
	$success = false;
	include("database.php");
	include("common.php");

	
	 // keep track validation errors
	 $passwordError = null;
	 $password2Error = null;
	 $originalPassError = null;
	 
	 if(!empty($_SESSION['Username']))
	 {
		 $email = $_SESSION['Username'];
	 }
	 
	 if (!empty($_SESSION['Username']) && !empty($_POST)) 
	 {
	 
	 	// keep track post values// validate input
		$valid = true;
		$originalPassword = $_POST['originalPassword'];
	 	$password = $_POST['password'];
	 	$password2 = $_POST['password2'];
	 	
	 	if (empty($originalPassword))
	 	{
	 		$originalPassError = 'Please enter your original Password';
	 		$valid = false;
		}
		else if($originalPassword == $password)
		{
			$originalPassError = 'Your original password matches your new password';
	 		$valid = false;
		}
		
		if (empty($password)) 
		{
			$passwordError = 'Please enter a new Password';
			$valid = false;
		}
		else if (!valid_pass($password) )
		{
			$passwordError = 'Please enter a valid password';
			$valid = false;
		} 
		
		if (empty($password2)) 
		{
			$password2Error = 'Please confirm your new Password';
			$valid = false;
		}
		 else if ($password != $password2) 
		 {
		 	$passwordError = 'Your passwords do not match';
		 	$password2Error = 'Your passwords do not match';
		 	$valid = false;
		}
		
	
		if ($valid)
		{
			//Check to see if original password is valid
			$instance = new User;
			$user = $instance->authenticate($email,$originalPassword);
			
			if($user!=1)
			{
				$valid = false;
				if($user == 0)
				{
					$originalPassError = "Original password is incorrect";
				}
			}
		}
		
		// insert data
		if ($valid)
		{
			//Everything is good to let's go update the password
			$users = $instance->editPassword($email, $password);
			if($users)
			{
				$success = true;
			}
			else
			{
				unknownErr();
				$valid = false;
			}
		}
    }
    
    
	include('include/top_start.php');
	include('include/top_end.php');
?>
<div class="container">
	<div class="col-md-6 col-md-offset-3 col-sm-6 col-xs-12">
		<div class="panel panel-default panel-success panel-success-custom .small-Panel">
			<div class="panel-heading clearfix text-center">
				<i class="icon-calendar"></i>
				<h3 class="panel-title"><?echo $title?></h3>
			</div>
			<div class="panel-body">
<?php 
	if($success)
	{
?>
	<div class="inlineblock alert alert-success" role="alert">Password edit successful</div>
<?php
} 
	if($error!="")
	{
?>
			<div class="inlineblock alert alert-danger" role="alert"><?=$error?></div>
<?php
	}
	else
	{


?>
 <form class="form-horizontal row-border" action="managePassword.php" method="post">
	 	
<?php
		echo FormElementCreate2('originalPassword','Original Password',$originalPassError,!empty($originalPassword)?$originalPassword:'','password','required');
		echo FormElementCreate2('password','Password',$passwordError,!empty($password)?$password:'','password','required');
		echo FormElementCreate2('password2','Confirm password',$password2Error,!empty($password2)?$password2:'','password','required');
		?>
		<div class="form-group">
			<div class="col-md-2 col-md-offset-5">
				<button type="submit" class="btn btn-success">Login</button>
			</div>
		</div>
		
<?php 
if ($passwordError == 'Please enter a valid password')
{
?>
			<div class="inlineblock alert alert-danger" role="alert">
				Password requirements:
				<ul>
					<li>Length of at least 8</li>
					<li>Contain at least one lowercase letter</li>
					<li>Contain at least one number</li>
					<li>Contain at least one special character</li>
				</ul>
			</div>
<?php 
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
<?php include('include/bottom.php');?>
