<?php
	session_start();
	$title = "View All Outfitters";
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

	include('include/top_start.php');
	// Any extra scripts go here
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title>title</title>
	<link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
	<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/jquery.tokenize.js"></script>
	<link rel="stylesheet" type="text/css" href="js/jquery.tokenize.css" />
	<link href="multiple-select.css" rel="stylesheet"/>
	<script src="jquery.multiple.select.js"></script>
	<link href="Site.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="dropdown.css" />
	<script src="us-map-1.0.1//lib/raphael.js"></script>
	<script src="us-map-1.0.1/example/color.jquery.js"></script>
	<script src="us-map-1.0.1/jquery.usmap.js"></script>
		
	
	    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
<?php
	//	include('include/top_start.php');
?>

	
	




</head>
<body ng-app class='bodyclass'>
	<div id="container">
		<header id="topHead">
			<div id="HeadContainer">
				<div id="Heading" class="clear">
					<div id="title">
						<a href="index.php">GetOutdoorsNow</a>
					</div>
					<div id="topMenu">
						<div id="accountDropdown">
							<ul class="main-navigation">
<?php
	$outfitterLink = "";
	if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
	{
?>
								<li><a href="index.php">Welcome <?php echo $_SESSION['FirstName']?></a>
									<ul>
										<li>
											<a id="editUser" href="editUser.php">Edit my account</a>
										</li>
										<li>
											<a id="editUser" href="managePassword.php">Manage password</a>
										</li>
										<li>
											<a href="allUsersOutfitters.php">Your Outfitters</a> 
										</li>
										<li>
											<a href="logout.php">logout</a> 
										</li>
									</ul>
								</li>
<?php	
	}
	else
	{
?>
								<li>
									<a href="login.php">login</a> 
								</li>
								<li>
									<a href="createUser.php">sign up</a>
								</li>
<?php
	}
?>				
								<li>
									<a href="support.php">support</a> 
								</li>
								<li>
									<a href="linkOutfitter.php">Become an Outfitter</a> 
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</header>
	
		<div id="content">
			<?php
	if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && in_array('admin',$_SESSION['Roles']))
	{
?>	
			<nav id="navigation">
				<ul class="main-navigation">
					<li>
						<a href="#">Admin Tools</a>
					<ul>
						<li>
							<a href="#">Outfitter Management</a>
								<ul>
									<li>
										<a href="allOutfitters.php">View All Outfitters</a>
									</li>
									<li>
										<a href="createOutfitter.php">Create New Outfitter</a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
				</ul>
			</nav>
<?php
	}
?>
			<div id="inside-content">
				
				
				
				
<?php
//include('include/top_end.php');

?>


 <article id="loginWrapper" class="roundDiv">
	<div class="divHeader roundDiv">
		ttle
	</div>
	
	<div id="loginContent">
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
				<input name="password" type="text"  placeholder="Password" value="<?php echo !empty($password)?$password:'';?>">
				<?php if (!empty($passwordError)): ?>
				<span class="help-inline"><?php echo $passwordError;?></span>
				<?php endif; ?>
			</div>
			</div>
			<div class="form-actions">
				<button type="submit" class="button">login</button>
			</div>
<?php 
		if (false)
		{
?>
			<div class="control-group error">
			<div class="help-inline">
<?php
			echo $generalError;
?>
			 </div>
		 </div>
<?php 
		}
?>
		</form>
	</div>
	
	
	</article> <!-- /container -->


<?php
include('include/bottom.php');
?>
