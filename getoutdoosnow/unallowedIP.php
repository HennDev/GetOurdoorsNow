<?php 
    $address = $_SERVER['REMOTE_ADDR'];
    include($_SERVER['DOCUMENT_ROOT']."/database.php");



if(!isIPValid($_SERVER['REMOTE_ADDR']))
    {   
	if (!empty($_POST)) 
        {
            // keep track post values
            $password = 'devIPaddHenn$Smith';
            //$Smith@@Hennessy!!';
            $valid = password_hash($password, PASSWORD_BCRYPT);

            /*
            echo '<br> <br> '.$valid.'<br> <br> ';
            echo '<br> <br> '.$password.'<br> <br> ';
            */

            $passwordEntered = $_POST['password'];
         // $hashAndSalt2 = password_hash($password, PASSWORD_BCRYPT);

           // echo '<br> <br> '.$valid.'<br> <br> ';
            //echo '<br> <br> '.$hashAndSalt2.'<br> <br> ';
            //echo "~~~$hashAndSalt~~~";

            if(password_verify($passwordEntered,$valid))
            {
                if(addIP($address))
                {
                    header('Location: index.php' ) ;
                }
                else
                {
                    echo "Error";
                }
            }
            else 
            {
                echo 'Your IP/Computer is not registered <br> <br> '. $_SERVER['REMOTE_ADDR'].'<br> <br> ';
                echo "Incorrect Password!";
            }
        }
        else
        {
            echo 'Your IP/Computer is not registered <br> <br> '. $_SERVER['REMOTE_ADDR'].'<br> <br> ';
        }
        
        ?>
<form action="unallowedIP.php" method="post">
    <input type="password" name="password">
    <button type="submit" class="button">Add yours</button>
</form><?php
    }
    else
    {
        echo "Ip already added";
    }
    
                     
        ?>

