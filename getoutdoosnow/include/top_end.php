<!--</head>

<body ng-app class='bodyclass'>
<?php echo $_SERVER['DOCUMENT_ROOT']."index.php" ?>
<div id="container">
		<header id="topHead">
			<div id="HeadContainer">
				<div id="Heading" class="clear">
					<div id="title">
						<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."index.php" ?>">GetOutdoorsNow</a>
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
<header>
    <nav class="navbar navbar-inverse"  style="position: absolute;
    top: 0px;
    left: 0px;
    right: 0px;
    z-index: 1001;
    width: 100%;" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               <!-- <a class="navbar-brand" href="/index.php">GetOutdoorsNow</a>-->

    <a class="navbar-brand" href="/index.php">                <img src="/img/logos/White/PNG/getoutdoors_72px%20copy%202%202.png" height="100px" width="auto" />
</a>
            </div>
            <?php
            include($_SERVER['DOCUMENT_ROOT'].'/include/menu.php');
            ?>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
</header>


<!--Login Modal Start-->
<div class="modal fade " id="loginModal" role="dialog">
    <div id="login-overlay" class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" align="center">
                <img class="img hidden-sm hidden-xs" id="img_logo" src="/img/logos/Full%20Color/JPG/getoutdoors_150px.jpg" height="350px" width="auto">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span style="color: red;" class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="well" id="box">
                            <form id="loginForm" method="POST" action="" novalidate="novalidate">
                                <div class="form-group">
                                    <label for="email" class="control-label">E-mail</label>
                                    <input type="text" class="form-control" id="email" name="email" value="" required="" title="Please enter your email" placeholder="example@gmail.com">
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="control-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" value="" required="" title="Please enter your password">
                                    <span class="help-block"></span>
                                </div>

                                <div id="loginErrorMsg" class="has-feedback has-error" style="display: none;">
                                    <label id="loginErrorMsgChild" class="control-label" for="inputError"></label>
                                </div>
                                <!--<div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" id="remember"> Remember login
                                    </label>
                                    <p class="help-block">(if this is a private computer)</p>
                                </div>-->
                                <button type="submit" id="loginButtonSubmit" class="btn btn-success btn-success-custom btn-block">Login</button>
                                <a href="/forgot/" class="btn btn-default btn-block">Help to login</a>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="well">

                            <p class="lead">Register now for <span class="text-success">FREE</span></p>
                            <ul class="list-unstyled" style="line-height: 2">
                                <li><span class="fa fa-check text-success"></span> Find the best activites</li>
                                <li><span class="fa fa-check text-success"></span> View upcoming adventures</li>
                                <li><span class="fa fa-check text-success"></span> Save your favorites</li>
                                <li><span class="fa fa-check text-success"></span> Fast checkout</li>
                                <!-- <li><a href="/read-more/"><u>Read more</u></a></li>-->
                            </ul>
                            <p>
                            </p>

                            <div class="row">

                            <div class="col-md-6">

                                <a href="/createUser.php" class="btn btn-info">Standard registration</a>
    </div>
                            <div class="col-md-6">
                                <a href="/createUser.php?action=NewOutfitter" class="btn btn-info">Outfitter registration</a>
</div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div></div>
<!--Login Modal End-->

<div id="wrapper">
	<div id="fb-root"></div>
    <!-- Navigation -->
