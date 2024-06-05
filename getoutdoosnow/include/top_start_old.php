<?php
if (!isIPValid($_SERVER['REMOTE_ADDR']))
{
	header("location: unallowedIP.php");
	exit();
 }
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
	<link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
	<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/jquery.tokenize.js"></script>
	<link rel="stylesheet" type="text/css" href="js/jquery.tokenize.css" />
        <link href="/css/multiple-select.css" rel="stylesheet"/>
	<script src="/js/jquery.multiple.select.js"></script>
	<link href="/css/Site.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="/css/dropdown.css" />
	<script src="us-map-1.0.1//lib/raphael.js"></script>
	<script src="us-map-1.0.1/example/color.jquery.js"></script>
	<script src="us-map-1.0.1/jquery.usmap.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
	    
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- Bootstrap Core CSS -->
    <link href="css/customBootstrap.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
    body {
        padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
    
  
 </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    