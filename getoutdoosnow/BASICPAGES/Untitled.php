<?php
	session_start();
	$title = "Create an account";
	include("common.php");
	$error = "";
 
    if ( !empty($_POST)) {
        // keep track validation errors
        $firstNameError = null;
        $emailError = null;
         
        // keep track post values
        $firstName = $_POST['firstName'];
        $email = $_POST['email'];
         
        // validate input
        $valid = true;
        if (empty($firstName)) {
            $firstNameError = 'Please enter Name';
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
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO Outfitters (name,email) values(?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($firstName,$email));
            Database::disconnect();
			header("Location:http://www.example.com/");
        }
    }
    
    
	include('include/top_start.php');
?>

	
	
<?php
include('include/top_end.php');

?>
 <article id="innerPageWrapper" class="roundDiv">
	<div class="divHeader roundDiv">
		<?=$title?>
	</div>
	
	<div id="loginContent">
<?php  
	if($error!="")
	{
		echo $error;
	}
	else
	{
?>
	 <form class="form-horizontal" action="createOutfitter.php" method="post">
                      <div class="control-group <?php echo !empty($firstNameError)?'error':'';?>">
                        <label class="control-label">Name</label>
                        <div class="controls">
                            <input name="firstName" type="text"  placeholder="FirstName" value="<?php echo !empty($firstName)?$firstName:'';?>">
                            <?php if (!empty($firstNameError)): ?>
                                <span class="help-inline"><?php echo $firstNameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
                        <label class="control-label">Email Address</label>
                        <div class="controls">
                            <input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
                            <?php if (!empty($emailError)): ?>
                                <span class="help-inline"><?php echo $emailError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                          <div class="form-actions">
                          <button type="submit" class="button">Create</button>
                          <a class="btn" href="index.php">Back</a>
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
