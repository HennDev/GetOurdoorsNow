<?php

ini_set('display_errors', 1);

session_start();
$title = "Search Results";
include($_SERVER['DOCUMENT_ROOT']."/database.php");
include($_SERVER['DOCUMENT_ROOT']."/common.php");



//Only get valid states for now
$states = getAllStates(true);
$activities= getAllActivities(true);

$instance = new Outfitter;
$outfitters = $instance->getAllOutfitters("lastUpdate DESC");


$stateError = null;
$regionError = null;
$startDateError = null;
$cityError = null;
$peopleError = null;
$activityError = null;
$allErrors = "";

if(!empty($_GET))
{
    $results = array(
        "state" => !empty($_GET['state'])?urldecode($_GET['state']):'',
        "region" => !empty($_GET['region'])?urldecode($_GET['region']):'',
        "startDate" => !empty($_GET['startDate'])?urldecode($_GET['startDate']):'',
        "endDate" => !empty($_GET['endDate'])?urldecode($_GET['endDate']):'',
        "people" => !empty($_GET['people'])?urldecode($_GET['people']):'',
        "activity" => !empty($_GET['activity'])?urldecode($_GET['activity']):'',
        "sortValue" => !empty($_GET['sortValue'])?urldecode($_GET['sortValue']):''
    );
    extract($results);
}
else if(!empty($_POST))
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
    $sortValue = !empty($_POST['sortValue'])?$_POST['sortValue']:'';



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
        /*  //TODO, GET BY ID
          $instance = Outfitter::withAll($id,$name, $email, $state, $city, $address, $type, $phone, $lodge, $region, null, $descr, $zip, $descrShort);
          $outfitters = $instance->editOutfitter();

          if($outfitters==false)
          {
              $genError = 'Error updating, try again';
              $valid = false;
          }
          else if($outfitters)
          {
              $success = true;
          }
          else
          {
              unknownErr();
              $valid = false;
          }*/
    }
}
else
{
    $results = array(
        "state" => '',
        "region" => '',
        "startDate" => '',
        "endDate" => '',
        "people" => '',
        "activity" => '',
        "sortValue" => ''


    );
    extract($results);


}

include($_SERVER['DOCUMENT_ROOT']."/include/top_start.php");

?>
    <link rel="stylesheet" href="examples/jQuery-Multiple-Select-Plugin-For-Bootstrap-Bootstrap-Multiselect/dist/css/bootstrap-multiselect.css" type="text/css">
    <script type="text/javascript" src="examples/jQuery-Multiple-Select-Plugin-For-Bootstrap-Bootstrap-Multiselect/dist/js/bootstrap-multiselect.js"></script>


	<script>
        $(document).ready(function(){

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

            $( "#slider-range" ).slider({
                range: true,
                min: 0,
                max: 500,
                values: [ 75, 300 ],
                slide: function( event, ui ) {
                    $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
                }
            });
            $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
                " - $" + $( "#slider-range" ).slider( "values", 1 ) );
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




	$(function() {

		$('.expand-one').click(function(){
		$('.content-one').slideToggle('slow');
		});

		$(function() {
			$( "#tabs" ).tabs();
		});

		/*$(function() {
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



	}); */

	$('#Animal').multipleSelect();

	$( "#index" ).submit(function( event ) {
	var array = $('#Animal').multipleSelect('getSelects', 'text');
	//array = array.replace("&nbsp;","");
    $('input[name="testing"]').val(array);




});


});

  $( document ).ready(function() {

      $(".outfitterResult").on("click", function(e){
          e.preventDefault();
          var outfitterID = $(this).next().val();
          $('#resultsForm').attr('action', "Outfitters/viewOutfitter.php?id="+outfitterID).submit();
      });

      $(".sortLink").on("click", function(e){
          e.preventDefault();
          $('#sortValue').val($(this).attr('id'));
          $('#resultsForm').submit();
      });

      $('#demo').multiselect({
          numberDisplayed: 4
      });




      var $body   = $(document.body);
      var navHeight = $('.navbar').outerHeight(true) + $('#booking').outerHeight(true) + 10;

     /* $('#sidebar').affix({
          offset: {
              top: navHeight - 60
          }
      });
*/
      $body.scrollspy({
          target: '#leftCol',
          offset: navHeight
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

     $('#IDselect').multipleSelect();




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


	    'click' : function(event, data) {
	      $('#alert')
	        .text(data.name+' was clicked')
	        .stop()
	    }
	  });

});

</script>

<style>
    p.content-one
	{
		margin: 0 0 0 0 !important;
		text-indent: 10px;
	}

    .list-group-item-hover:hover
    {
        background-color: #dbdde2 !important;
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


    .v-align
    {
        float:none;
        display:inline-block;
        vertical-align:middle;
        margin-right:-4px;
    }

    #masthead {
        min-height:270px;
        background-color:#000044;
        color:#aaaacc;
    }

    #masthead h1 {
        font-size: 55px;
        line-height: 1;
    }

    #masthead .well {
        margin-top:13%;
        background-color:#111155;
        border-color:#000033;
    }

    .icon-bar {
        background-color:#fff;
    }

    @media screen and (min-width: 768px) {
        #masthead h1 {
            font-size: 100px;
        }
    }

    .navbar-bright {
        background-color:#111155;
        color:#fff;
    }

    .navbar-bright a, #masthead a, #masthead .lead {
        color:#aaaacc;
    }

    .navbar-bright li > a:hover {
        background-color:#000033;
    }

    .affix-top,.affix{
        position: static;
    }

    .list-group-item.active{
        background-color: #24680C;
        border-color: #24680C;
    }
    @media (min-width: 979px) {
        #sidebar.affix-top {
            position: static;
            margin-top:30px;
            background: white;

        }

        div#sidebar {
            /* padding-left: 10px; */
            padding: 10px;
            background: white;
        }

        #sidebar.affix {
            position: fixed;
            top:70px;
            width:280px;
            background: white;

        }
    }

    #sidebar li.active {
        border:0 #eee solid;
        border-right-width:4px;
    }

    #mainCol h2 {
        padding-top: 55px;
        margin-top: -55px;
    }
</style>


</head>



<?php
include($_SERVER['DOCUMENT_ROOT']."/include/top_end.php");

?>

<div class="container">
    <form id="resultsForm" action="results.php" method="post" role="form"> <!--class="form-inline"-->

    <div id="booking" class="row row-custom">
            <div class="col-sm-12" style="">
                <div class="panel panel-default panel-success panel-success-custom">
                    <div class="panel-heading clearfix">
                        <i class="icon-calendar"></i>
                        <h2 class="panel-title">Find An Outfitter</h2>
                    </div>
                    <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <?php  echo FormElementCreateDropdown2('state','State',$stateError,!empty($state)?$state:'',"text","required",$states,'state_id','state');  ?>


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
                                    <div class="form-group has-feedback <?php  if (!empty($startDateError)) { echo 'has-error';} ?>">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon3">Start Date</span>
                                            <input required type="text" class="dates form-control " placeholder="" id="startDate" name="startDate"  aria-describedby="basic-addon3" value="<?php echo $startDate; ?>"/>
                                            <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                                        </div>
                                        <?php
                                        if (!empty($startDateError))
                                        {
                                            echo '<div class="col-md-12 col-md-offset-2"> <label class="control-label" for="inputError">'.$startDateError.'</label> </div>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group has-feedback">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon5">People</span>
                                            <select required class="form-control " name="people" id="people" aria-describedby="basic-addon5">
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
                                    <input type="hidden" name="hiddenRegionID" id = "hiddenRegionID" value="<?php echo $region?>">
                                    <div class="form-group has-feedback <?php  if (!empty($regionError)) { echo 'has-error';} ?>">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon2">Region</span>
                                            <select class="form-control " name="region" id="region" aria-describedby="basic-addon2">
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
                                    <div class="form-group has-feedback <?php  if (!empty($endDateError)) { echo 'has-error';} ?>">
                                        <div class="input-group">
                                            <span required class="input-group-addon" id="basic-addon4">End Date</span>
                                            <input type="text" class="dates form-control " placeholder="" id="endDate" name="endDate"  aria-describedby="basic-addon4" value="<?php echo $endDate; ?>"/>
                                            <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                                        </div>
                                        <?php
                                        if (!empty($endDateError))
                                        {
                                            echo '<div class="col-md-12 col-md-offset-2"> <label class="control-label" for="inputError">'.$endDateError.'</label> </div>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <?php  echo FormElementCreateDropdown2('activity','Activity',$activityError,!empty($activity)?$activity:'',"text","required",$activities,'id','name');  ?>

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
                    </div>
                </div>
            </div>
    </div>
    <div class="row">
       <div class="col-md-3" id="leftCol">

            <div id="sidebar">
                <div class="row">
                    <div class="col-md-12">
                        <div class="list-group filter-list" id="list1">
                            <a href="#" class="list-group-item active">Animals</a>
                            <a href="#" class="list-group-item">
                                <div class="form-group has-feedback">
                                    <div class="input-group text-center" style="margin: 0 auto;">
                                        <select id="demo" multiple="multiple">
                                            Antelope
                                            <option value="Javascript">Antelope</option>
                                            Bear
                                            <option value="Python">Bear</option>
                                            Bird
                                            <option value="LISP">Bird</option>
                                            Deer
                                            <option value="C++">Deer</option>
                                            Elk
                                            <option value="jQuery">Elk</option>
                                            Goat
                                            <option value="Ruby">Goat</option>
                                            Hog
                                            <option value="Ruby">Hog</option>
                                        </select>
                                    </div>
                                </div>
                            </a>
                        </div>



                        <div class="list-group filter-list" id="list1">
                            <a href="#" class="list-group-item active">Price range</a>
                            <a href="#" class="list-group-item">
                            <div class="form-group has-feedback">
                                <div class="input-group">
                                    <input type="text" class="form-control input-lg text-center" id="amount" readonly style="background-color: inherit !important; border:0; font-size: 16px; font-weight:bold;">
                                </div>
                            </div>
                            <div id="slider-range"></div></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="list-group filter-list" id="list1">
                            <a href="#" class="list-group-item active">Amenities</a>
                            <a href="#" class="list-group-item list-group-item-hover">Lodging <input type="checkbox" class="pull-right"></a>
                            <a href="#" class="list-group-item list-group-item-hover">Transportation Services <input type="checkbox" class="pull-right"></a>
                            <a href="#" class="list-group-item list-group-item-hover">Wifi <input type="checkbox" class="pull-right"></a>
                            <a href="#" class="list-group-item list-group-item-hover">Cell Phone Service <input type="checkbox" class="pull-right"></a>
                            <a href="#" class="list-group-item list-group-item-hover">Skinning/Butchering<input type="checkbox" class="pull-right"></a>
                            <a href="#" class="list-group-item list-group-item-hover">Meal(s) provided <input type="checkbox" class="pull-right"></a>
                            <a href="#" class="list-group-item list-group-item-hover">Camping or RV hook up <input type="checkbox" class="pull-right"></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="list-group filter-list" id="list1">
                            <a href="#" class="list-group-item active">Lodging Rating</a>
                            <a href="#" class="list-group-item list-group-item-hover"><?php print_fa_icon("fa-star",2,5); ?></i><input type="checkbox" class="pull-right"></a>
                            <a href="#" class="list-group-item list-group-item-hover"><?php print_fa_icon("fa-star",2,4); ?> <input type="checkbox" class="pull-right"></a>
                            <a href="#" class="list-group-item list-group-item-hover"><?php print_fa_icon("fa-star",2,3); ?><input type="checkbox" class="pull-right"></a>
                            <a href="#" class="list-group-item list-group-item-hover"><?php print_fa_icon("fa-star",2,2); ?><input type="checkbox" class="pull-right"></a>
                            <a href="#" class="list-group-item list-group-item-hover"><?php print_fa_icon("fa-star",2,1); ?><input type="checkbox" class="pull-right"></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group has-success has-feedback text-center">
                            <label class="control-label"></label>
                            <button type="submit" name="applyFilters" class="btn btn-success btn-success-custom btn-lg">Apply Filters</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

    <div class="col-md-9" id="mainCol">

        <div class="row">
            <div class="col-md-12 text-center">
                <input type="hidden" name="sortValue" id="sortValue" value="<?php echo $sortValue?>">
                <div class="btn-group" role="group" style="border-radius: 6px;    border: green solid 1px;" aria-label="...">
                    <button type="button" class="btn btn-default btn-lg" style="background: white; border-color: #ccc;">Sort By</button>
                    <div class="btn-group" role="group" >
                        <button type="button" class="btn btn-default btn-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Name
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" style="font-size: 15px;">
                            <li><a href="#" class="sortLink" id="nameAsc">Ascending &nbsp; <?php print_fa_icon("fa-sort-alpha-desc",2,1); ?></a></li>
                            <li><a href="#" class="sortLink" id="nameDesc">Descending &nbsp; <?php print_fa_icon("fa-sort-alpha-asc",2,1); ?></a></li>
                        </ul>
                    </div>
                    <div class="btn-group" role="group" >
                        <button type="button" class="btn btn-default btn-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Rating
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" style="font-size: 15px;">
                            <li><a href="#" class="sortLink" id="ratingAsc">Ascending &nbsp; <?php print_fa_icon("fa-sort-amount-desc",2,1); ?></a></li>
                            <li><a href="#" class="sortLink" id="ratingDesc">Descending &nbsp; <?php print_fa_icon("fa-sort-amount-asc",2,1); ?></a></li>
                        </ul>
                    </div>
                    <div class="btn-group" role="group" >
                        <button type="button" class="btn btn-default btn-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Price
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" style="font-size: 15px;">
                            <li><a href="#" class="sortLink" id="priceAsc">Ascending &nbsp; <?php print_fa_icon("fa-sort-amount-desc",2,1); ?></a></li>
                            <li><a href="#" class="sortLink" id="priceDesc">Descending &nbsp; <?php print_fa_icon("fa-sort-amount-asc",2,1); ?></a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

        <br>
            <!--<br>
            <h2 id="sec1">Results</h2>-->
            <?php

            foreach ($outfitters as $outfitter) {
                switch ($outfitter->type) {
                    case "1":
                        $outfitterTypeFormatted = "Hunting";
                        break;
                    case "2":
                        $outfitterTypeFormatted = "Fishing";
                        break;
                    case "3":
                        $outfitterTypeFormatted = "Hunting and Fishing";
                        break;
                }

                $outfitterID = $outfitter->id;
                $directory = $_SERVER['DOCUMENT_ROOT'] . '/upload/images/' . $outfitterID . '/';
                $files = glob($directory . '/*');

                $instance = new Image;
                $images = $instance->getAllOutfitterImages($outfitterID);


                if($outfitter->name != "" && $outfitter->zip != "" && count($images)>0)
                {
?>

                   <!-- <input type="hidden" name="state" id = "hiddenState" value="<?php echo $state?>">
                    <input type="hidden" name="region" id = "hiddenRegion" value="<?php echo $region?>">
                    <input type="hidden" name="startDate" id = "hiddenStartDate" value="<?php echo $startDate?>">
                    <input type="hidden" name="endDate" id = "hiddenEndDate" value="<?php echo $endDate?>">
                    <input type="hidden" name="people" id = "hiddenPeople" value="<?php echo $people?>">
                    <input type="hidden" name="activity" id = "hiddenActivity" value="<?php echo $activity?>">
                    <input type="hidden" name="outfitterID" class ="outfitterID" value="<?php echo $outfitterID?>">
                    -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <!-- <div class="panel-heading"><h4><?php echo $outfitter->name ?></h4></div>-->
                                <div class="panel-body" style="    padding-top: 1px;">
                                    <div class="row">
<?php
                                    if($files !== false && count($images) > 0)
                                    {
                                        $first = true;
                                        foreach ($images as $row) {
                                        if($first)
                                        {
                                            $first = false;
                                            $extension = $row['type'];
?>
                                            <div class="col-md-3 v-align">
                                                <img
                                                    src="/upload/images/<?php echo $row['outfitter_id'] ?>/<?php echo $row['id'] . "." . $extension ?>"
                                                    class="img-thumbnail img-responsive" style="margin: 10px;    max-height: 200px;"></div>
<?php
                                                }
                                         }

                                    }
                                    ?>
                                        <div class="col-md-9 v-align">
                                            <div class="row">

                                                <div class="col-md-9">
                                                    <div class="page-header" style="border-bottom: 0px; margin-top:0px">
                                                <h3 style="float: left; width:100%; margin-top:5px">
                                                   <p style="margin-bottom: 1px;"> <?php
                                                    echo $outfitter->name. "&nbsp;&nbsp;";     print_fa_icon("fa-star",.5,rand(1,5),"#24680C"); ?>
                                                    </p>
                                                    <small>
                                                        <?php
                                                        echo $outfitter->address . ", " . $outfitter->city . ", " . $outfitter->state . ", " . $outfitter->zip;
                                                        ?>
                                                    </small>
                                                </h3>
                                          </div>
<br><br>
<br><br>
                                                     <div style="clear: both;"><?php echo $outfitter->descrShort; ?> </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="page-header" style="border-bottom: 0px; margin-top:0px">
                                                        <h4 style="float: left; width:100%;">
                                                            <span style="" class=""><?php echo "From $".rand(99,500).'.99'; ?></h4>

                                                        </span>
                                                    </div>
                                                    <br><br><br><br>
                                                    <div class="form-group has-success has-feedback text-center">
                                                        <label class="control-label"></label>
                                                        <button type="submit" name="outfitterButton" class="btn btn-primary outfitterResult">Continue</button>
                                                        <input type="hidden" name="hiddenOutfitterID" id = "hiddenOutfitterID <?php echo $outfitterID?>" value="<?php echo $outfitterID?>">
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
                }

                    ?>
        </form>
<?php
        }
            ?>



<!--            <div class="table-responsive" style="clear:both">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Phone</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
/*
                    foreach ($outfitters as $row)
                    {
                        */?>
                        <tr>
                            <td><?php /*echo $row->name */?></td>
                            <td><?php /*echo $row->address */?></td>
                            <td><?php /*echo $row->city */?></td>
                            <td><?php /*echo $row->state */?></td>
                            <td><?php /*echo $row->phone */?></td>
                            <td>
                                <?php
/*                                switch($row->type)
                                {
                                    case "1":
                                        echo 'Hunting';
                                        break;
                                    case "2":
                                        echo 'Fishing';
                                        break;
                                    case "3":
                                        echo 'Both';
                                        break;
                                }
                                */?>
                            </td>
                            <td>
                                <input class='btn btn-success' type="submit" data-url="viewOutfitter.php?id=<?php /*echo $row->id */?>" id="btnView" name="btnView" value="View">
                                <input class='btn btn-success' type="submit" data-url="editOutfitter.php?id=<?php /*echo $row->id */?>" id="btnEdit" name="btnEdit" value="Edit">
                                <input class='btn btn-success' type="submit" data-url="deleteOutfitter.php?id=<?php /*echo $row->id */?>" id="btnDelete" name="btnDelete" value="Delete">
                            </td>
                        </tr>
                        <?php
/*                    }
                    */?>
                    </tbody>
                </table>
            </div>
-->

        </div>
    </div>
    <br>
    <br>
</div>

<?php include($_SERVER['DOCUMENT_ROOT']."/include/bottom.php");?>
