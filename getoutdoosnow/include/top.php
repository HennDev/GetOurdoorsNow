<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title><?=$title?></title>
	<link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
	<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/jquery.tokenize.js"></script>
	<link rel="stylesheet" type="text/css" href="js/jquery.tokenize.css" />
	<link href="multiple-select.css" rel="stylesheet"/>
	<script src="jquery.multiple.select.js"></script>
	<link href="Site.css" rel="stylesheet" />
	<script src="us-map-1.0.1//lib/raphael.js"></script>
	<script src="us-map-1.0.1/example/color.jquery.js"></script>
	<script src="us-map-1.0.1/jquery.usmap.js"></script>
	
	
	<script>
		
		
	$(function() {
		$( "#sDate1" ).datepicker();
		$( "#eDate1" ).datepicker();
		$( "#sDate2" ).datepicker();
		$( "#eDate2" ).datepicker();
		$( "#sDate3" ).datepicker();
		$( "#eDate3" ).datepicker();
		$( "#sDate4" ).datepicker();
		$( "#eDate4" ).datepicker();
		$('.expand-one').click(function(){
		$('.content-one').slideToggle('slow');
		});
		
		$(function() {
			$( "#tabs" ).tabs();
		});
		
		$(function() {
			$('#field').validator({
				format: 'zipUS',
				invalidEmpty: true,
				correct: function() {
				$('#validation_result').text('VALID');
			},
			error: function() {
				$('#validation_result').text('INVALID');
			}
		});
		
		$('#button_validate').click(function(e) {
			$('#field').validator('validate');
		});
		
		

	});
	
	$('#Animal').multipleSelect();
	
	$( "#index" ).submit(function( event ) {
	var array = $('#Animal').multipleSelect('getSelects', 'text');
    $('input[name="testing"]').val(array);
    
 
});


});
  
  $( document ).ready(function() {
    $('#tokenizeHunt').tokenize();
    $('#tokenizeFish').tokenize();
    $('#tokenizeHuntFish').tokenize();
    $('#tokenizeActivity').tokenize();
    $( "#accordionHunt" ).accordion({
      collapsible: true, active: false
    });
     $( "#accordionFish" ).accordion({
      collapsible: true, active: false
    });
    $( "#accordionHuntFish" ).accordion({
      collapsible: true, active: false
    });
    $( "#accordionActivity" ).accordion({
      collapsible: true, active: false
    });
    
     $('#IDselect').multipleSelect();
     
     
     $(document).mouseup(function (e)
     {
         var container = $("#map");
     
         if (!container.is(e.target) // if the target of the click isn't the container...
             && container.has(e.target).length === 0) // ... nor a descendant of the container
         {
             $("#dialog").dialog("close");
         }
     });
    
    
     $('#map').usmap({
	    'stateSpecificStyles': {
	      'CO' : {fill: '#5cb85c'},
	      'TX' : {fill: '#5cb85c'}
	    },
	    'stateSpecificHoverStyles': {
	      'CO' : {fill: '#629331'},
	      'TX' : {fill: '#629331'}
	    },
	    'stateHoverStyles': {
	      fill: '#575757'
	    },
	    'stateStyles': {
	      fill: '#575757', 
	      "stroke-width": 1,
	      'stroke' : '#5cb85c'
	    },'labelBackingHoverStyles': {
	      fill: '#575757'
	    },
	    'labelBackingStyles': {
	      fill: '#575757'
	    },
	    
	    'mouseoverState': {
	      'HI' : function(event, data) {
	        //return false;
	      }
	    },
	    
	    //process map clicking
	    'click' : function(event, data) {
	      $('#alert')
	        .text(data.name+' was clicked')
	        .stop();
	         var title = "";
	         var fishimgsource = "";
	         var huntimgsource = "";
	        
	        $('#imgFigHunt').attr('src','');
		    $('#imgFigFish').attr('src','');
		    	
	        if(data.name=="TX")
	        {
		        title = "Texas Regions";
		        fishimgsource = "img/txfish.gif";
		        huntimgsource = "img/txhunt.gif";
		   	}
			else if(data.name == "CO")
			{
				title = "Colorado Regions";
		        fishimgsource = "img/colfish.gif";
		        huntimgsource = "img/colhunt.gif";     
			}
			
			if(title!="")
			{	
		    	$('#imgFigHunt').attr('src',huntimgsource);
		    	$('#imgFigFish').attr('src',fishimgsource);
		    	
		    	
		    	$("#dialog").attr('title', title).dialog()
	            .parent() //remember .dialog() wraps the content in another <div>
	            .draggable({
		        containment: '#map',
		        opacity: 0.70
		    	})
		    	.position({ my: 'center', at: 'center', of: '#map' });
	    	
				title="";
			}
			else
			{
				$("#dialog")
			     .dialog("close");
			}
	
	    }
	    
	    
	  });
	  
	$('#StateHunt').change(function(){
		populateSelect("Region");
	});
	
	$('#RegionHunt').change(function(){
		populateSelect();
	});
	
	if($("#loginSuccess").val()=="true" || $("#logoutSuccess").val()=="true") 
	{
		var delay = 2000; //Your delay in milliseconds

		setTimeout(function(){ window.location = "index.php"; }, delay);
	}
	
});

var arrex = new Array();

<?php
$regions_TX = array('Big Bend Country-BBC','Gulf Coast-GC','Hill Country-HC','Panhandle Plains-PP','Pineywoods-PW','Prairies and Lakes-PL','South Texas Plains-STP');
$regions_CO = array('Northwest-NW','North Central-NC','Northeast-NE','Metro Area-MA','Pikes Peak-PP','West Central-WC','Southwest-SW','Southeast-SE');


$js_array = json_encode($regions_TX);
echo "arrex['TX'] = ". $js_array . ";\n";

$js_array = json_encode($regions_CO);
echo "arrex['CO'] = ". $js_array . ";\n";


?>

  
  
var arrex2 = new Array();
arrex2['BBC'] = Array('Big Bend Hunting-BBH','Davis Family-DF','Two Brothers Outfitter-TB');
arrex2['GC'] = Array('Gulf Coast Hunt-GCH','John Doe Hunting-JDH','Three Brothers Outfitter-TB');
arrex2['HC'] = Array('Big Bend Hunting-BBH','Davis Family-DF','Two Brothers Outfitter-TB');
arrex2['PP'] = Array('Gulf Coast Hunt-GCH','John Doe Hunting-JDH','Three Brothers Outfitter-TB');

arrex2['NW'] = Array('Big Bend Hunting-BBH','Davis Family-DF','Two Brothers Outfitter-TB');
arrex2['NC'] = Array('Gulf Coast Hunt-GCH','John Doe Hunting-JDH','Three Brothers Outfitter-TB');
arrex2['NE'] = Array('Big Bend Hunting-BBH','Davis Family-DF','Two Brothers Outfitter-TB');
arrex2['MA'] = Array('Gulf Coast Hunt-GCH','John Doe Hunting-JDH','Three Brothers Outfitter-TB');

function populateSelect(kind)
{
	if (kind == "Region")
	{
		var cat=$('#StateHunt').val();
		$('#RegionHunt').html('');
		$('#RegionHunt').append('<option value="" selected>Select a Region</option>');
		for(var key in arrex[cat]) 
		{
			var mySplitResult = arrex[cat][key].split("-");
			$('#RegionHunt').append('<option value='+mySplitResult[1]+'>'+mySplitResult[0]+'</option>');
		}
	}
	else
	{
		var cat=$('#RegionHunt').val();
		$('#OutfitterHunt').html('');
		
		if(typeof arrex2[cat] !== 'undefined')
		{
			$('#OutfitterHunt').append('<option value="" selected>Select an Outfitter</option>');
			for(var key in arrex2[cat]) 
			{
				var mySplitResult = arrex2[cat][key].split("-");
				$('#OutfitterHunt').append('<option value='+mySplitResult[1]+'>'+mySplitResult[0]+'</option>');
			}
		}
		else
		{
			$('#OutfitterHunt').append('<option value="" disabled selected>No Outfitters found</option>');
			
		}
	}
}




  </script>
    
<style>
	p.content-one
	{
		margin: 0 0 0 0 !important;
		text-indent: 10px;
	}
	
<?php if(!isset($_POST["Type"]) && !isset($_POST["Animal[]"]) && !isset($_POST["Radius"]) )
	{
?>

	div.content-one {
    display:none;
}



p.content-one ul {
    display:none;
}

<?php 
	}
?>
</style>
</head>
<body class='bodyclass'>
	<div id="container">
		
		<div id="topHead">
			<div id="HeadContainer">
				<div id="Heading" class="clear">
					<div id="title"><a href="index.php">GetOutdoorsNow</a></div>
					<div id="topMenu">
						<ul>
							<li>
							<?php
								if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
								{
									echo "Welcome ".$_SESSION['FirstName'].",";
?>
									 <a href="logout.php">logout</a> 
<?php
								}
								else
								{
?>
								<a href="login.php">login</a> 
<?php
								}
?>
							</li>
							<li>
								<a href="/Home/OurStory">sign up</a>
							</li>
							<li>
								<a href="/Home/Photos">support</a>
							</li>

						</ul>
					</div>
				</div>
			</div>
		</div>
		<div id="content">
			<div id="inside-content">
<?php
								if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && in_array('admin',$_SESSION['Roles']))
								{
?>
								<div id="navigation">
								Placeholder for admin only stuff
								</div>
<?php
								}
?>
		