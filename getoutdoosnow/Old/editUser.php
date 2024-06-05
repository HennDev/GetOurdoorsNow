<?php
	session_start();
	$title = "Edit my account";
	include("database.php");
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
 <article id="loginWrapper" class="roundDiv">
	<div class="divHeader roundDiv">
		<?=$title?>
	</div>
	
	<div id="loginContent">
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
	 <form class="form-horizontal" action="editUser.php" method="post">
                      <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
                        <label class="control-label">Email Address</label>
                        <div class="controls">
                            <input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
                            <?php if (!empty($emailError)): ?>
                                <span class="help-inline"><?php echo $emailError;?></span>
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
                          <button type="submit" class="button">Edit</button>
                        </div>
                    </form>                             
<?php 
	} 
?>

	</div>
	</article> <!-- /container -->
<?php
include('include/bottom.php');
?>
