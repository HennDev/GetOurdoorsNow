<?php
session_start();
include("../database.php");
include("../common.php");

function phone_number_format($phone) {
    if(strpos($phone, "-") == false)
    {
        $phone = "(".substr($phone, 0, 3).") ".substr($phone, 3, 3)."-".substr($phone,6);
    }
    else
    {
        $phoneSplit = explode("-",$phone);
        $phone = "(".$phoneSplit[0].") ".$phoneSplit[1]."-".$phoneSplit[2];
    }
    return $phone;
}

if (!empty($_GET))
{
    sleep(2);

    $outfitterID = $_GET["outfitterID"];

    if(isset($outfitterID))
    {
        $outfitter = Outfitter::getSingleOutfitter($outfitterID);
    }
    else
    {
        echo 0;
    }

    if(!isset($outfitter->email))
    {
        echo 0;
    }
    else
    {
        $firstName = $_GET["firstName"];
        $lastName = $_GET["lastName"];
        $email = $_GET["email"];
        $phone = $_GET["phone"];
        $comment = $_GET["comment"];

        $outfitterEmail = $outfitter->email;

        /* ****Important!****
       replace name@your-web-site.com below
       with an email address that belongs to
       the website where the script is uploaded.
       For example, if you are uploading this script to
       www.my-web-site.com, then an email like
       form@my-web-site.com is good. */

        $to_add = $outfitterEmail;

        $from_add = $email; //<-- put your yahoo/gmail email address here
        $from_add = "info@getoutdoorsnow.com"; //<-- put your yahoo/gmail email address here


        $subject = "GetOutdoorsNow: You have been contacted by a potential client";
        $message = '<html><body style="font-family: "Montserrat", sans-serif>';
        $message .= '<h1>Hello, World!</h1>';
        $message .= "Getting outdoors would be nice \n First Name: $firstName  \n Last Name: $lastName   \n to_add: $to_add \n form value entered: $email \n from_add: $from_add  \n Phone: $phone  \n Comment: $comment  \n OutfitterID: $outfitterID \n Now: ". date("Y-m-d H:i:s") ."\n";
        $message .= '</body></html>';

        $message = '<html><body>';
        $message .= '<div style="text-align: center;">';
        $message .= '<img src="http://dev.getoutdoorsnow.com/img/logos/Full%20Color/JPG/getoutdoors_150px.jpg" style="width: 150px;  height: auto;" alt="Website Change Request" />';
        $message .= '</div><br>';
        $message .= '<div style="text-align: center;">';
        $message .= 'The following potential customer has requested to contact you:';
        $message .= '</div><br>';
        $message .= '<table rules="all" style="border-color: #666; margin-left:auto;margin-right:auto" cellpadding="10">';
        $message .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>$firstName $lastName</td></tr>";
        $message .= "<tr><td><strong>Email:</strong> </td><td>$email</td></tr>";
        $message .= "<tr><td><strong>Phone Number:</strong> </td><td>".phone_number_format($phone)."</td></tr>";
        $message .= "<tr><td><strong>Urgency:</strong> </td><td>sss</td></tr>";
        $message .= "<tr><td><strong>Comment:</strong> </td><td>$comment</td></tr>";
        $message .= "<tr><td><strong>Time Sent:</strong> </td><td> Now: ". date("Y-m-d H:i:s") ."</td></tr>";
        $message .= "<tr><td><strong>To:</strong> </td><td>$outfitterEmail</td></tr>";
        $message .= '</table></body></html>';

        $headers = "From: $from_add \r\n";
        $headers .= "Reply-To: $from_add \r\n";
        $headers .= "Return-Path: $from_add\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion(). "\r\n";


        // To send HTML mail, the Content-type header must be set
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


        ini_set('SMTP', "relay-hosting.secureserver.net");
        ini_set('smtp_port', "25");


        if(mail($to_add,$subject,$message,$headers))
        {
            echo $message;
        }
        else
        {
            echo 0;
        }


    }
}
else if (!empty($_POST))
{
    sleep(2);

    $outfitterID = $_POST["outfitterID"];

    if(isset($outfitterID))
    {
        $outfitter = Outfitter::getSingleOutfitter($outfitterID);
    }
    else
    {
        echo 0;
    }

    if(!isset($outfitter->email))
    {
        echo 0;
    }
    else
    {
        $firstName = "N/A";
        $lastName = "N/A";
        $email = "N/A";
        $phone = "N/A";
        $comment = "N/A";
        $modalDate = "N/A";

        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $comment = $_POST["comment"];
        $modalDate = $_POST["modalDate"];

        if(empty($firstName) || empty($lastName)) {
            $firstName = "N/A";
            $lastName = "";
        }
        if(empty($email)) {
            $email = "N/A";
        }
        if(empty($phone)) {
            $phone = "N/A";
        }
        if(empty($comment)) {
            $comment = "N/A";
        }
        if(empty($modalDate)) {
            $modalDate = "N/A";
        }


        $outfitterEmail = $outfitter->email;

        /* ****Important!****
       replace name@your-web-site.com below
       with an email address that belongs to
       the website where the script is uploaded.
       For example, if you are uploading this script to
       www.my-web-site.com, then an email like
       form@my-web-site.com is good. */

        $to_add = $outfitterEmail;

        $from_add = $email; //<-- put your yahoo/gmail email address here
        $from_add = "info@getoutdoorsnow.com"; //<-- put your yahoo/gmail email address here


        $subject = "You have been contacted by a potential client";
        $message = "Getting outdoors would be nice \n First Name: $firstName  \n Last Name: $lastName   \n to_add: $to_add \n form value entered: $email \n from_add: $from_add  \n Phone: $phone  \n Comment: $comment  \n OutfitterID: $outfitterID \n modalDate: $modalDate \n Now: ". date("Y-m-d H:i:s") ."\n";


        $message = '<html><body>';
        $message .= '<div style="text-align: center;">';
        $message .= '<img src="http://dev.getoutdoorsnow.com/img/logos/Full%20Color/JPG/getoutdoors_150px.jpg" style="width: 75px;  height: auto;" alt="Website Change Request" />';
        $message .= '</div><br>';
        $message .= '<div style="text-align: center;">';
        $message .= 'The following potential customer has requested to contact you:';
        $message .= '</div><br>';
        $message .= '<table rules="all" style="border-color: #666; margin-left:auto;margin-right:auto" cellpadding="10">';
        $message .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>$firstName $lastName</td></tr>";
        $message .= "<tr><td><strong>Email:</strong> </td><td>$email</td></tr>";
        $message .= "<tr><td><strong>Phone Number:</strong> </td><td>".phone_number_format($phone)."</td></tr>";
        $message .= "<tr><td><strong>Date:</strong> </td><td>$modalDate</td></tr>";
        $message .= "<tr><td><strong>Comment:</strong> </td><td>$comment</td></tr>";
        //$message .= "<tr><td><strong>Time Sent:</strong> </td><td> Now: ". date("Y-m-d H:i:s") ."</td></tr>";
        //$message .= "<tr><td><strong>To:</strong> </td><td>$outfitterEmail</td></tr>";
        $message .= '</table></body></html>';

        $headers = "From: $from_add \r\n";
        $headers .= "Reply-To: $from_add \r\n";
        $headers .= "Return-Path: $from_add\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion(). "\r\n";


        // To send HTML mail, the Content-type header must be set
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        ini_set('SMTP', "relay-hosting.secureserver.net");
        ini_set('smtp_port', "25");


        if(mail($to_add,$subject,$message,$headers))
        {
            echo 1;
        }
        else
        {
            echo 0;
        }


    }
}
?>