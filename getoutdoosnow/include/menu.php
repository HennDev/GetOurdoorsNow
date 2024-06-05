<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
<ul class="nav navbar-nav">
 <?php
 if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
	{
?>
	<li class="dropdown">
<?php
    if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && in_array('admin',$_SESSION['Roles']))
	{
?>
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin Tools</a>
			<ul class="dropdown-menu">
				<li>
										<a href="/Outfitters/allOutfitters.php">View All Outfitters</a>
									</li>
									<li>
										<a href="/Outfitters/createOutfitter.php">Create New Outfitter</a>
									</li>
			</ul>
<?php
	}
?>
	</li>

		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome <?php echo $_SESSION['FirstName']?> <i class="fa fa-user fa-fw"></i> </a>




            <ul class="dropdown-menu">
				<li>
					<a id="editUser" href="/editUser.php">Edit my account</a>
				</li>
				<li>
					<a id="editUser" href="/managePassword.php">Manage password</a>
				</li>
				
				<?php 
		if(!empty($_SESSION['isOutffiter']) && $_SESSION['isOutffiter'] == 1)
		{
			?>
		<li>
					<a href="/Outfitters/allUsersOutfitters.php">Outfitter Dashboard</a> 
				</li>
		<?php 
		}
		?>
		
		
		
				
				<li>
					<a href="/logout.php">Logout</a> 
				</li>
			</ul>
		</li>
<?php	
	}
	else
	{
?>
		<li>
			<!--<a href="/login.php">Login<i class="fa fa-lock fa-fw"></i> </a>-->
           <a href="#" id="loginModalLink" role="button" data-toggle="modal">Login<i class="fa fa-lock fa-fw"></i> </a>
        </li>



        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sign up <i class="fa fa-user-plus fa-fw"></i> </a>




            <ul class="dropdown-menu">
                <li>
                    <a id="editUser" href="/createUser.php">Standard Account</a>
                </li>

                <?php
                if(empty($_SESSION['isOutffiter']) || (!empty($_SESSION['isOutffiter']) && $_SESSION['isOutffiter'] != 1))
                {
                    ?>
                    <li>
                        <a href="/Outfitters/linkOutfitter.php">Become an Outfitter</a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </li>




<?php
	}

    if(!empty($_SESSION['Username']) && empty($_SESSION['isOutffiter']) || (!empty($_SESSION['isOutffiter']) && $_SESSION['isOutffiter'] != 1))
	{
?>
		<li>
			<a class="hidden-desktop" href="/Outfitters/linkOutfitter.php">Become an Outfitter</a> 
		</li>
<?php
    }

?>

        <li class="dropdown">
            <!-- <a href="/viewCart.php"><i class="fa fa-shopping-cart fa-lg"></i> <span id="cartInMenu" class="badge" style="background-color: #FFF; color: #24680C;   font-size: 16px; margin-left: 5px;"></span></a> -->
            <ul class="dropdown-menu">
                <li>
                    <a id="editUser" href="/viewCart.php">View Shopping Cart</a>
                </li>
            </ul>
        </li>
	</ul>
</div>