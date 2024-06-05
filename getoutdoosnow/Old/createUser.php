<?php
	session_start();
	$title = "Create an account";
	include("database.php");	
	include("common.php");
	$error = "";
	$success = false;
	$newOutfitter = false;
	
	//User tried to create an outfitter first
	if(!empty($_GET))
	{
		if ($_GET['action'] == 'NewOutfitter')
		{ 
			$newOutfitter = true;
		}
	}
		
// keep track validation errors
    $firstNameError = null;
    $lastNameError = null;
    $emailError = null;
    $passwordError = null;
    $password2Error = null;

if ( !empty($_POST)) {

    // keep track post values
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    
    if($_POST['newOutfitter'] == '1')
	{ 
		$newOutfitter = true;
	}
		
    $password2 = $_POST['password2'];
    
    
     
    // validate input
    $valid = true;
    if (empty($firstName)) {
        $firstNameError = 'Please enter First Name';
        $valid = false;
    }
    
    $valid = true;
    if (empty($lastName)) {
        $lastNameError = 'Please enter Last Name';
        $valid = false;
    }
     
    if (empty($email)) {
        $emailError = 'Please enter Email Address';
        $valid = false;
    } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
        $emailError = 'Please enter a valid Email Address';
        $valid = false;
    }
    
      if (empty($password)) {
        $passwordError = 'Please enter a Password';
        $valid = false;
    } else if ( !valid_pass($password) ) {
        $passwordError = 'Please enter a valid password';
        $valid = false;
    } 
    
    if (empty($password2)) {
        $password2Error = 'Please confirm your Password';
        $valid = false;
    } else if ($password != $password2) {
        $passwordError = 'Your passwords do not match';
        $password2Error = 'Your passwords do not match';
        $valid = false;
    }
    
    
     
    // insert data
    if ($valid)
    {
		$instance = new User;
		$users = $instance->createUser($email,$password,$firstName,$lastName);
		
		if($users==false)
		{
			$emailError = 'Email Address already taken';
			$valid = false;
		}
		else if($users)
		{
			$success = true;
			$user = $instance->authenticate($email,$password);
				
			if($user == 1)
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
		<div class="panel panel-default panel-success .small-Panel">
			<div class="panel-heading clearfix text-center">
				<i class="icon-calendar"></i>
				<h3 class="panel-title"><?echo $title?></h3>
			</div>
			<div class="panel-body">
				
				
<?php 
	if($success)
	{
?>
	<div class="inlineblock alert alert-success" role="alert">Account creation successful, <a href="login.php">click here to log in</a></div>
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
	
	if($newOutfitter)
	{
?>
	<div class="inlineblock alert alert-warning" role="alert">To become an Outfitter, please create an account below or <a href="login.php?action=NewOutfitter">login here</a></div>
<?php
}
?>
<form class="form-horizontal row-border" action="createUser.php" method="post">
					<?php 
						echo FormElementCreate2('email','E-mail',$emailError,!empty($email)?$email:'',"email","required");
						echo FormElementCreate2('password','Password',$passwordError,!empty($password)?$password:'',"password","required");
						echo FormElementCreate2('password2','Confirm Password',$password2Error,!empty($password2)?$password2:'',"password","required");
						echo FormElementCreate2('firstName','FirstName',$firstNameError,!empty($firstName)?$firstName:'',"text","required");
						echo FormElementCreate2('lastName','LastName',$lastNameError,!empty($lastName)?$lastName:'',"text","required");
					?>
					<div class="form-group">
						<div class="col-md-2 col-md-offset-5">
							<button type="submit" class="btn btn-success">sign up!</button>
						</div>
					</div>
					<input name="newOutfitter" type="hidden" value="<?php echo $newOutfitter?'1':'0';?>">    
				</form>
				
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



			</div>
		</div>
	</div>
<?php include('include/bottom.php');?>





		<form class="form-horizontal" action="createUser.php" method="post">
			<div>
			<div class="control-group <?php echo !empty($emailError)?'error':'';?>">
				<label class="control-label">Email Address</label>
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
					<input name="password" type="password" placeholder="Password" value="<?php echo !empty($password)?$password:'';?>">
					<?php if (!empty($passwordError)): ?>
					<span class="help-inline"><?php echo $passwordError;?></span>
					<?php endif;?>
				</div>
			</div>
			
			<div class="control-group <?php echo !empty($password2Error)?'error':'';?>">
				<label class="control-label">Confirm password</label>
				<div class="controls">
					<input name="password2" type="password" placeholder="Confirm password" value="<?php echo !empty($password2)?$password2:'';?>">
					<?php if (!empty($password2Error)): ?>
					<span class="help-inline"><?php echo $password2Error;?></span>
					<?php endif;?>
				</div>
			</div>   
			
			<div class="control-group <?php echo !empty($firstNameError)?'error':'';?>">
				<label class="control-label">First Name</label>
				<div class="controls">
					<input name="firstName" type="text"  placeholder="FirstName" value="<?php echo !empty($firstName)?$firstName:'';?>">
					<?php if (!empty($firstNameError)): ?>
					<span class="help-inline"><?php echo $firstNameError;?></span>
					<?php endif; ?>
				</div>
			</div>
			
			<div class="control-group <?php echo !empty($lastNameError)?'error':'';?>">
				<label class="control-label">Last Name</label>
				<div class="controls">
					<input name="lastName" type="text"  placeholder="LastName" value="<?php echo !empty($lastName)?$lastName:'';?>">
					<?php if (!empty($lastNameError)): ?>
					<span class="help-inline"><?php echo $lastNameError;?></span>
					<?php endif; ?>
				</div>
			</div>
			
			<div class="form-actions">
				<button type="submit" class="button">sign up!</button>
			</div>
			
			<input name="newOutfitter" type="hidden" value="<?php echo $newOutfitter?'1':'0';?>">
			
			
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
</article> <!-- /container -->
<?php
include('include/bottom.php');
?>
