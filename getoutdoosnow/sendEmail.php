<?php
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");

/*
From http://www.html-form-guide.com 
This is the simplest emailer one can have in PHP.
If this does not work, then the PHP email configuration is bad!
*/
$msg="";
if(isset($_POST['submit']))
{
    /* ****Important!****
    replace name@your-web-site.com below 
    with an email address that belongs to 
    the website where the script is uploaded.
    For example, if you are uploading this script to
    www.my-web-site.com, then an email like
    form@my-web-site.com is good.
    */


    $to_add = "shennessy11@gmail.com";

    $from_add = "steven@getoutdoorsnow.com"; //<-- put your yahoo/gmail email address here

    $subject = "Lets getoutside now";
    $message = "Getting outdoors would be nice \n Now:       ". date("Y-m-d H:i:s") ."\n";;

    $headers = "From: $from_add \r\n";
    $headers .= "Reply-To: $from_add \r\n";
    $headers .= "Return-Path: $from_add\r\n";
    $headers .= "X-Mailer: PHP \r\n";

    ini_set('SMTP', "relay-hosting.secureserver.net");
    ini_set('smtp_port', "25");

    if(mail($to_add,$subject,$message,$headers))
    {
        $msg = "Mail sent OK";

        echo $to_add."<br>".$subject."<br>".$message."<br>".$headers;
    }
    else
    {
        $msg = "Error sending email!";
    }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Test form to email</title>
</head>

<body>
<?php echo $msg ?>
<p>
<form action='<?php echo htmlentities($_SERVER['PHP_SELF']); ?>' method='post'>
    <input type='submit' name='submit' value='Submit'>
</form>
</p>


</body>
</html>