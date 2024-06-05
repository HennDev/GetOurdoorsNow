<!--</head>
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

-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">GetOutdoorsNow</a>
            </div>
             <?php 
                  include("menu.php");
                 ?>
           <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>



    <div id="content">
    


    