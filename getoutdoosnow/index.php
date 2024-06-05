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

                $.getJSON("/Ajax/getRegionsByState.php?state_id="+stateID, function(result){
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

" src="/img/logos/Full%20Color/JPG/getoutdoors_150px.jpg" width="auto">
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
                                                  <!-- <img src="http://www.whiteoakoutfittersinc.com/Pics%20feb%202015/deer1.JPG"/> -->
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
                                                    <img src="http://www.bookmycharter.com/site/assets/files/1/fishing_scenic.jpg"/>
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
                                                    <img src="http://www.argentinadovehunting.com/images/LaCatalina.jpg"/>
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
                                                <img src="http://www.deepseafishingnj.net/wp-content/uploads/2008/08/fishing_pic21-300x206.jpg"/>
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

