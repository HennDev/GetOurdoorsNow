<?php                   
 if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
	{
?>
						
                    <li class="dropdown">
                    		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome <?php echo $_SESSION['FirstName']?></a>
                            <ul class="dropdown-menu">
                                <li>
											<a id="editUser" href="editUser.php">Edit my account</a>
										</li>
										<li>
											<a id="editUser" href="managePassword.php">Manage password</a>
										</li>
										<li>
											<a class=".hidden-desktop" href="allUsersOutfitters.php">Your Outfitters</a> 
										</li>
										<li>
											<a href="logout.php">logout</a> 
										</li>
                            </ul>
                      </li>
<?php	
	}
?>