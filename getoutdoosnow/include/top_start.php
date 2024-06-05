<?php

        

/*if (!isIPValid($_SERVER['REMOTE_ADDR']))
{
	header("location: unallowedIP.php");
	exit();
 }*/

	?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $title?></title>
    <link rel="icon"  type="image/png" href="/img/logos/Full%20Color/JPG/getoutdoors_150px.jpg" />
	<link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>

<!--	<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css" />
 	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

    <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.11.4/themes/south-street/jquery-ui.css" />
    <link rel="stylesheet" href="/css/themes/custom-theme/jquery-ui-1.9.2.custom.css">
     <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
-->
    <link rel="stylesheet" href="/css/themes/custom-theme/jquery-ui-1.10.0.custom.css">

    <link rel="stylesheet" href="/css/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="/css/themes/smoothness/theme.css"/>


    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
	<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script type = "text/javascript"
            src = "https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>

    <script type="text/javascript" src="/js/jquery.tokenize.js"></script>

    <script type="text/javascript" src="/js/jquery.validate.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/js/jquery.tokenize.css" />

    <link href="/css/multiple-select.css" rel="stylesheet"/>

    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>

    <script src="/js/jquery.multiple.select.js"></script>

    <script type="text/javascript" src="/js/jquery.tokenize.js"></script>
	<link rel="stylesheet" type="text/css" href="/js/jquery.tokenize.css" />
	<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
        <link href="/css/Site.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="/css/dropdown.css" />

        <!-- Bootstrap Core CSS -->
        <link href="/css/bootstrap.min.css" rel="stylesheet">

	<!-- Bootstrap Core CSS -->
        <link href="/css/customBootstrap.css" rel="stylesheet">

    <script type="text/javascript" src="/js/cookies.js"></script>


    <script src="/us-map-1.0.1//lib/raphael.js"></script>
    <script src="/us-map-1.0.1/example/color.jquery.js"></script>
    <script src="/us-map-1.0.1/jquery.usmap.js"></script>

        <!-- Custom CSS -->
        <style>
        body {
            padding-top: 70px;
            /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
        }


    </style>
<script type="text/javascript">
    $(document).ready(function() {


        $.validator.setDefaults({
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                if(element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });


        $('#loginButtonSubmit').click(function()
        {
            $("#loginForm").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: "required"
                },
                messages: {
                    password: "Please enter your email",
                    password: "Please enter your password"
                },
                submitHandler: function(form) {
                    event.preventDefault();

                    var email=$("#email").val();
                    var password=$("#password").val();
                    var dataString = 'username='+email+'&password='+password;
                    $.ajax({
                        type: "POST",
                        url: "/Ajax/ajaxLogin.php",
                        data: dataString,
                        cache: false,
                        beforeSend: function(){ $("#login").val('Connecting...');},
                        success: function(data){

                            if(data=="1")
                            {
                                location.reload();
                            }
                            else
                            {
                                if(data == -1)
                                {
                                    var emailError = "Sorry, your account could not be found. Please try again";
                                }
                                else if(data == 0)
                                {
                                    var emailError = "Sorry, your account credentials are incorrect try again";
                                }

                                //Shake animation effect.
                                var l = 5;
                                for( var i = 0; i < 10; i++ )
                                    $( "#box" ).animate( {
                                        'margin-left': "+=" + ( l = -l ) + 'px',
                                        'margin-right': "-=" + l + 'px'
                                    }, 50);

                                $("#loginErrorMsgChild").html(emailError);
                                $("#loginErrorMsg").show();

                            }
                        }
                    });
                }
            });
        });



        $("#loginModalLink").click(function (event)
        {
            event.preventDefault();


            $("#loginModal").modal({
                keyboard: false
            });

        });
    });


    </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


