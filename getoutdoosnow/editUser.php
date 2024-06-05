<?php
	session_start();
	$title = "Edit my account";
	include("database.php");
	include("common.php");
	$error = "";
	$success = false;
	
	$valid = true;
	// keep track validation errors
        $firstNameError = null;
        $lastNameError = null;
        $emailError = null;
    
    if (!empty($_SESSION['Username']) && !empty($_POST)) 
    {
    
        // keep track post values
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
         
        // validate input
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
        
        // insert data
        if ($valid)
        {
			//ready to update
			//if username has changed
			if($email != $_SESSION['Username'])
			{
				//check if email already exsists
				$instance = new User;
				$user = $instance->getUser($email);

				//if it does, error out
				if($user!=-1)
				{
					$emailError .=  " User with this email already exists";
					$success = false;
				}
			}
			
			if(empty($emailError))
			{
				//no errors, update now
				$instance = new User;
				$users = $instance->editUser($_SESSION['Username'],$email, $firstName, $lastName);
				
				if($users==false)
				{
					$emailError = 'Email Address already taken';
					$valid = false;
				}
				else if($users)
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
    }
    else if(!empty($_SESSION['Username']))
    {
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
				$firstName = $row['first_name'];
				$email = $row['email'];
				$lastName = $row['last_name'];
			}
		}
	}
	else
	{
		$error = "Please enter an ID";
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
	<div class="inlineblock alert alert-success" role="alert">Account edit successful</div>
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
	 <form class="form-horizontal row-border" action="editUser.php" method="post">
					<?php 
						echo FormElementCreate2('email','E-mail',$emailError,!empty($email)?$email:'',"email","required");
						echo FormElementCreate2('firstName','First Name',$firstNameError,!empty($firstName)?$firstName:'',"text","required");
						echo FormElementCreate2('lastName','Last Name',$lastNameError,!empty($lastName)?$lastName:'',"text","required");
					?>
					<div class="form-group">
						<div class="col-md-2 col-md-offset-5">
							<button type="submit" class="btn btn-success">Login</button>
						</div>
					</div>   
				</form>
<?php 
	} 
?>

			</div>
		</div>
	</div>
</div>
<?php include('include/bottom.php');?>