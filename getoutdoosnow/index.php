<?php
	session_start();
	$title = "Get Outdoors Now";
	include("database.php");
	include("common.php");
	$error = "";
	$success = false;

    $huntanimals = array("Elk","Deer","Geese","Quail","Pheasant","Duck","Buffalo","Turkey","Mountain Lion","Sheep","Big Horn Sheep");
	$fishanimals = array("Salmon", "Tuna","Tilapia","Quail","Pollock","Cod","Catfish","Striped Bass","Bluefish","Scup","Weakfish");
	$animals = array_merge($huntanimals,$fishanimals);

    //Only get valid states for now
    $states = getAllStates(true);
    $activities= getAllActivities(true);


	if(!empty($_POST["Animal"]))
	{
		$string = str_replace('&nbsp;',"", $_POST["testing"]);
		$string = preg_replace("/\s|&nbsp;/",'',$string);
		$animal = explode(",",$string);
	}
	else
	{
		$animal = array();
	}

    $stateError = null;
    $regionError = null;
    $startDateError = null;
    $cityError = null;
    $peopleError = null;
    $activityError = null;

    $allErrors = "";

    if(!empty($_POST))
    {
        // validate input
        $valid = true;
        // keep track post values
        $state = !empty($_POST['state'])?$_POST['state']:'';
        $region = !empty($_POST['region'])?$_POST['region']:'';
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $people = $_POST['people'];
        $activity = !empty($_POST['activity'])?$_POST['activity']:'';

        if (empty($state))
        {
            $stateError = 'Please enter State';
            $valid = false;
            $allErrors .= " $stateError";
        }

        if (empty($region))
        {
            $regionError = 'Please enter Region';
            $valid = false;
            $allErrors .= " $regionError";
        }

        if (empty($startDate)) {
            $startDateError = 'Please enter Start Date';
            $valid = false;
            $allErrors .= " $startDateError";
        }

        if (empty($endDate)) {
            $endDateError = 'Please enter an End Date';
            $valid = false;
            $allErrors .= " $endDateError";
        }

        if (empty($people)) {
            $peopleError = 'Please enter people';
            $valid = false;
            $allErrors .= " $peopleError";
        }

        if (empty($activity)) {
            $activityError = 'Please enter activity';
            $valid = false;
            $allErrors .= " $activityError";
        }

        // insert data
        if ($valid)
        {
            $result = compact("state", "region", "startDate","endDate", "people", "activity");
            $queryString = "";

            foreach ($result as $key => $value)
            {
                if($value!="")
                {
                    if($queryString=="")
                    {
                        $queryString.="?";
                    }
                    else
                    {
                        $queryString.="&";
                    }
                    $queryString .= $key.'='.urlencode($value);
                }
            }

            header('Location: /results.php'.$queryString);
            //header('Location: /results.php?startDate='.urlencode($startDate).'&endDate='.urlencode($endDate));
        }
    }
    else
    {
        $state = "";
        $region = "";
        $startDate = "";
        $endDate = "";
        $people = "";
        $activity = "";

    }


include('include/top_start.php');
?>

    <script src="//maps.google.com/maps/api/js?sensor=true&key=AIzaSyDZ6xoudqhcPl7MnRpaUvyZM-pN78gphjg" type="text/javascript"></script>

	<script>
        $(document).ready(function() {

        /*    //------- Google Maps ---------//

            // Creating a LatLng object containing the coordinate for the center of the map
            var latlng = new google.maps.LatLng(53.385846,-1.471385);

            // Creating an object literal containing the properties we want to pass to the map
            var options = {
                zoom: 15, // This number can be set to define the initial zoom level of the map
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP // This value can be set to define the map type ROADMAP/SATELLITE/HYBRID/TERRAIN
            };
            // Calling the constructor, thereby initializing the map
            var map = new google.maps.Map(document.getElementById('map_div'), options);

            // Define Marker properties
            var image = new google.maps.MarkerImage('/img/logos/White/PNG/getoutdoors_72px%20copy%202%202.png',
                // This marker is 129 pixels wide by 42 pixels tall.
                new google.maps.Size(129, 42),
                // The origin for this image is 0,0.
                new google.maps.Point(0,0),
                // The anchor for this image is the base of the flagpole at 18,42.
                new google.maps.Point(18, 42)
            );

            // Add Marker
            var marker1 = new google.maps.Marker({
                position: new google.maps.LatLng(53.385846,-1.471385),
                map: map,
                icon: image // This path is the custom pin to be shown. Remove this line and the proceeding comma to use default pin
            });

            // Add listener for a click on the pin
            google.maps.event.addListener(marker1, 'click', function() {
                infowindow1.open(map, marker1);
            });

            // Add information window
            var infowindow1 = new google.maps.InfoWindow({
                content:  createInfo('Evoluted New Media', 'Ground Floor,<br />35 Lambert Street,<br />Sheffield,<br />South Yorkshire,<br />S3 7BH<br /><a href="http://www.evoluted.net" title="Click to view our website">Our Website</a>')
            });

            // Create information window
            function createInfo(title, content) {
                return '<div class="infowindow"><strong>'+ title +'</strong><br />'+content+'</div>';
            }*/

        });





        $( document ).ready(function() {

      $(document).mouseup(function (e)
      {
          var container = $("#map");

          if (!container.is(e.target) // if the target of the click isn't the container...
              && container.has(e.target).length === 0 && $("#dialog").hasClass("ui-dialog-content") && $("#dialog").dialog("isOpen") == true) // ... nor a descendant of the container
          {
              $("#dialog").dialog("close");
          }
      });

	    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-46156385-1', 'cssscript.com');
  ga('send', 'pageview');

      $('.expand-one').click(function(){
          $('.content-one').slideToggle('slow');
      });

   /*
      $(function() {
          $( "#tabs" ).tabs();
      });

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


      $('#Animal').multipleSelect();

      $( "#index" ).submit(function( event ) {
          var array = $('#Animal').multipleSelect('getSelects', 'text');
          $('input[name="testing"]').val(array);


      });


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

     $('#IDselect').multipleSelect();*/





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
				$("#dialog").dialog("close");
			}

	    }


	  });



	if($("#loginSuccess").val()=="true" || $("#logoutSuccess").val()=="true")
	{
		var delay = 2000; //Your delay in milliseconds

		setTimeout(function(){ window.location = "index.php"; }, delay);
	}


      $( "#startDate" ).datepicker({
          minDate: 'today',
          maxDate: "+90D",
          onClose: function (date) {
              var date2 = $('#startDate').datepicker('getDate');
              date2.setDate(date2.getDate());
              //sets minDate to startDate date
              $('#endDate').datepicker('option', 'minDate', date2);
              $('#endDate').datepicker("show");
          }

      });

      $( "#endDate" ).datepicker({
          minDate: 'today',
          maxDate: "+90D",
      });
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


$(document).ready(function(){

        $('#state').change(function(){
            var state_ID = $('#state').val();
            fillRegion(state_ID);
        });

        if($('#state').val() !== null)
        {
            var stateID = $('#state').val();
            var regionID = $('#hiddenRegionID').val();
            fillRegion(stateID,regionID);
           }
        });

        function fillRegion(stateID, regionID)
        {
            if(stateID !== null)
            {
                $('#region').empty();
                $('#region').append('<option value="loading">loading....</option>');
                $('#region_loading').show();
                var appendVal = "";
                var selected = "";

                $.getJSON("Ajax/getRegionsByState.php?state_id="+stateID, function(result){
                    $.each(result, function(i, field){
                        if(regionID === field['region_id'])
                        {
                            selected = "selected";
                        }
                        else
                        {
                            selected = "";
                        }
                        appendVal += '<option ' + ((regionID === field['region_id']) ? 'selected' : '') + ' value="'+field['region_id']+'">'+field['region']+'</option>';
                    });
                    $('#region_loading').hide();
                    $('#region').empty();
                    $('#region').append('<option selected disabled>Please select</option>');
                    $('#region').append(appendVal);
                });
            }
        }



  </script>

<style>

    @media (min-width: 992px) {
        body {
            padding-top: 31px !important;
        }
    }


	p.content-one
	{
		margin: 0 0 0 0 !important;
		text-indent: 10px;
	}


    .nav-tabs{
        background-color: #24680C;
    }
    .tab-content{
        background-color:white;
        color:black;
        padding:5px
    }
    .nav-tabs > li > a{
        border: medium none;
        color: white;
    }
    .nav-tabs > li > a:hover{
        background-color: #74a574 !important;
        border: medium none;
        border-radius: 0;
        color: white;

    }
    .nav-tabs > li.active > a,
    .nav-tabs > li.active > a:focus,
    .nav-tabs > li.active > a:hover{
        background-color: #C9CBD0 !important;
        color: #black !important;
        background-color: white !important;
        border-color: white !important;
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

<?php
include('include/top_end.php');
?><?php



/*if(isset($valid)) {
    if($valid) {
        ?>
        <div style="z-index: 999999; margin: 50px;"><?php echo "State $state <br> Region $region <br> startDate $startDate  <br> eDate $endDate   <br> people $people    <br> activity $activity " ; ?> </div>
        <?php
    }
    else {
        ?>
        <div style="z-index: 999999; margin: 50px;"><?php echo $allErrors; ?>
        </div>

        <?php
    }
}*/
?>
    <div class="whitePageBackground">
		<div id="dialog" title="Basic dialog" style="display:none;">

				<figure id="FigHunt">
					<figcaption>Hunting Regions</figcaption>
					<img id="imgFigHunt" width="325px" height="300px">
				</figure>

				<figure id="FigFish">
					<figcaption>Fishing Regions</figcaption>
					<img id="imgFigFish" width="325px" height="300px">
				</figure>

		</div>
                <div class="container-fluid" id="home-container-fluid">
                    <div class="container" style="">


                        <div class="row row-custom">

                            <div class="col-sm-12" style="padding-bottom: 30px;">
                                <div class="panel panel-default panel-success panel-success-custom">
                                    <div class="panel-heading clearfix">
                                        <i class="icon-calendar"></i>
                                        <h2 class="panel-title" style="font-size: 35px;">Find An Outfitter
                                        </h2>
                                    </div>
                                    <div class="panel-body">
                                        <form action="index.php" method="post" role="form"> <!--class="form-inline"-->
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <?php  echo FormElementCreateDropdown2('state','State',$stateError,!empty($state)?$state:'',"text","required input-lg",$states,'state_id','state');  ?>


                                                    <!--<div class="form-group has-feedback">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1">State</span>
                                                            <select class="form-control input-lg" name="state" id="state" aria-describedby="basic-addon1">
                                                                <option value="" disabled selected>Select a State</option>
                                                                <option value="CO">Colorado</option>
                                                                <option value="TX">Texas</option>
                                                            </select>
                                                        </div>
                                                    </div>-->
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group has-feedback">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon3">Start Date</span>
                                                            <input required type="text" class="dates form-control input-lg" placeholder="" id="startDate" name="startDate"  aria-describedby="basic-addon3" value="<?php echo $startDate; ?>"/>
                                                            <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group has-feedback">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon5">People</span>
                                                            <select required class="form-control input-lg" name="people" id="people" aria-describedby="basic-addon5">
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                                <option value="6">6</option>
                                                                <option value="7">7</option>
                                                                <option value="8">8</option>
                                                                <option value="9">9</option>
                                                                <option value="10">10</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <i id="region_loading" class="fa fa-refresh fa-spin" style="display: none;"></i>
                                                    <input type="hidden" name="hiddenRegionID" id = "hiddenRegionID" value="<?php echo $region?>">
                                                    <div class="form-group has-feedback <?php  if (!empty($regionError)) { echo 'has-error';} ?>">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon2">Region</span>
                                                            <select class="form-control input-lg" name="region" id="region" aria-describedby="basic-addon2">
                                                                <option value="" disabled selected>Select State first</option>
                                                            </select>
                                                        </div>
                                                        <?php
                                                        if (!empty($regionError))
                                                        {
                                                            echo '<div class="col-md-12 col-md-offset-2"> <label class="control-label" for="inputError">'.$regionError.'</label> </div>';
                                                        }
                                                        ?>
                                                    </div>


                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group has-feedback">
                                                        <div class="input-group">
                                                            <span required class="input-group-addon" id="basic-addon4">End Date</span>
                                                            <input type="text" class="dates form-control input-lg" placeholder="" id="endDate" name="endDate"  aria-describedby="basic-addon4" value="<?php echo $endDate; ?>"/>
                                                            <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <?php  echo FormElementCreateDropdown2('activity','Activity',$activityError,!empty($activity)?$activity:'',"text","required input-lg",$activities,'id','name');  ?>

                                                    <!-- <div class="form-group has-feedback">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon6">Activity</span>
                                                            <select required class="form-control input-lg" name="activity" id="activity" aria-describedby="basic-addon6">
                                                                <option value="" disabled selected>Select an activity</option>
                                                                <option value="hunt">Hunting</option>
                                                                <option value="fish">Fishing</option>
                                                                <option value="hunt_fish">Both</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                                                                       <div class="form-group">
                                                                                                            <label class="control-label">Adults:</label>

                                                                                                            <div class="input-group number-spinner">
                                                                                                                <span class="input-group-btn data-dwn">
                                                                                                                    <button onclick="return false;" class="btn btn-default btn-success btn-success-custom" data-dir="dwn"><span class="glyphicon glyphicon-minus"></span></button>
                                                                                                                </span>
                                                                                                                <input type="text" style="z-index: 1;" class="form-control text-center" value="1" min="1" max="10">
                                                                                                                <span class="input-group-btn data-up">
                                                                                                                    <button onclick="return false;" class="btn btn-default btn-success btn-success-custom" data-dir="up"><span class="glyphicon glyphicon-plus"></span></button>
                                                                                                                </span>
                                                                                                            </div>
                                                                                                        </div>
                                                    -->
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group has-success has-feedback text-center">
                                                        <label class="control-label"></label>
                                                        <button type="submit" class="btn btn-success btn-success-custom btn-lg">Search</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div class="container">
                        <div class="row row-custom">

                        <div class="col-md-6 col-md-offset-3">
                            <div class="panel panel-default panel-success panel-success-custom">
                                <div class="panel-heading clearfix text-center">
                                    <i class="icon-calendar"></i>
                                    <h3 class="panel-title">Welcome to GetOutdoorsNow
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                    <div class="col-sm-12">
                                        Book all of your outdoor adventures here. We provide a simple method to finding all of the outdoor activities you are looking for, including: hunting, fishing and more.
                                    </div>

                                        <div class="col-sm-6 col-sm-offset-3" style="line-height: 175%;  margin-bottom: 20px;
    margin-top: 20px;">
                                    <img class="img img-responsive" id="img_logo" style="

       display:block;
    margin:auto;

" src="img/logos/Full%20Color/JPG/getoutdoors_150px.jpg" width="auto">
</div>


                                        <div class="col-sm-12 text-center" style="        font-size: 18px;
 line-height: 175%;
">
                                            Book today and Get Outdoors Now!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
                <br class="container hidden-sm hidden-xs">
                <br class="container hidden-sm hidden-xs">
                <br class="container hidden-sm hidden-xs">
                <div class="container hidden-sm hidden-xs">
                    <div class="row row-custom">
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="panel panel-default panel-success panel-success-custom">
                                <div class="panel-heading clearfix text-center">
                                    <h3 class="panel-title">Click On The State You Want To Search</h3>
                                </div>
                                <div class="panel-body">
                                    <div id="map" style="width: 600px; height: 400px;"></div>

                                    <div id="map_div"></div>

                                    <div>
                                        <br>
                                        <iframe frameborder="0" style="height:350px; width: 100%; ;border:0" src="https://www.google.com/maps/embed/v1/place?q=26723VirgoLAne&key=AIzaSyDZ6xoudqhcPl7MnRpaUvyZM-pN78gphjg"></iframe>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <br>
                <div class="container">
                    <div class="row row-custom">
                        <div class="col-sm-12">
                            <div class="panel panel-default panel-success panel-success-custom">
                                <div class="panel-heading clearfix text-center">
                                    <h3 class="panel-title">
                                        Most Popular Outfitters
                                    </h3>
                                </div>
                                <div class="panel-body">
                                <div class="row row-custom">
                                    <div class="col-sm-4 col-xs-4">
                                        <a href="/Outfitters/viewOutfitter.php?id=142">
                                       <div class="popular-wrapper">
                                           <div class="row">
                                               <div class="col-sm-12">
                                                  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRjWv6rB5g78k-I7M27EaYEM4F726InBW7c-Q&s"/>
                                               </div>
                                           </div>
                                           <div class="row row-custom">
                                               <div class="col-sm-12 popularName">
                                                   White Oak Outfitters
                                               </div>
                                           </div>
                                           <div class="row row-custom popularLocation">
                                               <div class="col-sm-12">
                                                   Mount Pleasant, Texas
                                               </div>
                                           </div>
                                           <div class="row" style="margin-right: -9px;">
                                               <div class="col-sm-12 popularStats">
                                                   14 bookings in the last 72 hours
                                               </div>
                                           </div>
                                       </div>
                                        </a>
                                    </div>

                                    <div class="col-sm-4 col-xs-4">
                                        <div class="popular-wrapper">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <img src="data:image/jpeg;base64,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"/>
                                                </div>
                                            </div>
                                            <div class="row row-custom">
                                                <div class="col-sm-12 popularName">
                                                    Port A Bay Fishing
                                                </div>
                                            </div>
                                            <div class="row row-custom popularLocation">
                                                <div class="col-sm-12">
                                                    Port Aransas, Texas
                                                </div>
                                            </div>
                                            <div class="row" style="margin-right: -9px;">
                                                <div class="col-sm-12 popularStats">
                                                    13 bookings in the last 72 hours
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-sm-4 col-xs-4">
                                        <div class="popular-wrapper">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <img src="https://www.baffinbayrodandgun.com/wp-content/uploads/2022/05/dove-hunting-hero.jpg"/>
                                                </div>
                                            </div>
                                            <div class="row row-custom">
                                                <div class="col-sm-12 popularName">
                                                    South Texas Dove Hunting
                                                </div>
                                            </div>
                                            <div class="row row-custom popularLocation">
                                                <div class="col-sm-12">
                                                    Uvalde, Texas
                                                </div>
                                            </div>
                                            <div class="row" style="margin-right: -9px;">
                                                <div class="col-sm-12 popularStats">
                                                    4 bookings in the last 72 hours
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                    </div>

                            </div>
                        </div>
                    </div>
                <br>
                <br>
                <br>
                <div class="row row-custom">
                    <div class="col-sm-12">
                        <div class="panel panel-default panel-success panel-success-custom">
                            <div class="panel-heading clearfix text-center">
                                <h3 class="panel-title">
                                    Hot Deals
                                </h3>
                            </div>


                            <div class="panel-body">
                            <div class="row row-custom">
                                <div class="col-sm-4 col-xs-4">
                                    <div class="popular-wrapper">
                                        <div class="row">
                                            <div class="col-sm-12" >
                                                <img src="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcRWYDc2wzw7HSQeMnH9ccUok3nAQYppejGrzlNghKYPbJGZxq3z"/>
                                            </div>
                                        </div>
                                        <div class="row row-custom">
                                            <div class="col-sm-12 popularName">
                                                White Tail Outfitters
                                            </div>
                                        </div>
                                        <div class="row row-custom popularLocation">
                                            <div class="col-sm-12">
                                                Fredericksburg, Texas
                                            </div>
                                        </div>
                                        <div class="row" style="margin-right: -9px;">
                                            <div class="col-sm-12 popularStats">
                                                $200 off if you book from Feb 15th - March 31
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4 col-xs-4">
                                    <div class="popular-wrapper">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <img src="http://media.cleveland.com/egan_impact/photo/whitetail-deer-horiz-ohio-2011-apjpg-1cbf71e2c48af434.jpg"/>
                                            </div>
                                        </div>
                                        <div class="row row-custom">
                                            <div class="col-sm-12 popularName">
                                                Concho Wild Game
                                            </div>
                                        </div>
                                        <div class="row row-custom popularLocation">
                                            <div class="col-sm-12">
                                                Concho County, Texas
                                            </div>
                                        </div>
                                        <div class="row" style="margin-right: -9px;">
                                            <div class="col-sm-12 popularStats">
                                                20% off Today ONLY
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-4 col-xs-4">
                                    <div class="popular-wrapper">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQh2i0ko6zqck2y6xmLUJA0LYijkVXWvKxqwg&s"/>
                                            </div>
                                        </div>
                                        <div class="row row-custom">
                                            <div class="col-sm-12 popularName">
                                                Deep Sea Charters
                                            </div>
                                        </div>
                                        <div class="row row-custom popularLocation">
                                            <div class="col-sm-12">
                                                Galveston, Texas
                                            </div>
                                        </div>
                                        <div class="row" style="margin-right: -9px;">
                                            <div class="col-sm-12 popularStats">
                                                $500 off if you book 2 or more people
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                </div>
                        </div>
                    </div>
                </div>


    </div>
<?php
include('include/bottom.php');
?>

