<?php
session_start();
include('../database.php');
include('../common.php');
$error = "";
$generalError = "";
$newOutfitter = false;
$passwordError = null;
$emailError = null;

if (!empty($_POST))
{
    // keep track post values
    $password = $_POST['password'];
    $email = $_POST['username'];
    $valid = false;

    if($email!="" && $password!="")
    {
        $valid = true;
    }
    // insert data
    if($valid)
    {
        $instance = new User;
        $users = $instance->authenticate($email,$password);
        // Insert $hashAndSalt into database against user
        //$hashAndSalt = password_hash($password, PASSWORD_BCRYPT);
        //echo "~~~$hashAndSalt~~~";

        if($users == 1)
        {
            //Correct user/password
            $_SESSION['Username'] = $email;
            $_SESSION['user_id'] = $instance->id;
            $_SESSION['EmailAddress'] = $email;
            $_SESSION['LoggedIn'] = 1;
            $_SESSION['FirstName'] = $instance->firstName;
            $_SESSION['LastName'] = $instance->lastName;
            $_SESSION['Roles'] = $instance->roles;
            $_SESSION['isOutffiter'] = $instance->isOutffiter;
        }
        else
        {
            $valid = false;
            if($users == -1)
            {
                $emailError = "Sorry, your account could not be found. Please try again</p>";
            }
            else if($users == 0)
            {
                $emailError = "Sorry, your account credentials are incorrect try again";
            }
        }

        echo $users;
    }
}
?>