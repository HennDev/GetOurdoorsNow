<?php
	session_start();	
    $title = "Edit an Outfitter";
	include($_SERVER['DOCUMENT_ROOT']."/database.php");	
	include($_SERVER['DOCUMENT_ROOT']."/common.php");
	$pageID = "editOutfitter";
	$error = "";
	$genError = "";
	$success = false;
    //Only get valid states for now
    $states = getAllStates(true);

    $types = getAllOutfitterTypes();
	$lodgings = getAllOutfitterLodging();
	
	// keep track validation errors
	$nameError = null;
	$emailError = null;
	$stateError = null;
	$cityError = null;
	$addressError = null;
	$typeError = null;
	$phoneError = null;
	$lodgeError = null;
	$regionError = null;
	$descrError = null;
    $descrShortError = null;
	$zipError = null;

if(empty($_SESSION['LoggedIn']) || empty($_SESSION['Username']))
{
    $error = "You must be logged in";
}
else {
    if(!empty($_POST) && $_POST['pageID'] == $pageID) {
        // keep track post values
        $name = $_POST['name'];
        $email = $_POST['email'];
        $state = !empty($_POST['state']) ? $_POST['state'] : '';
        $city = $_POST['city'];
        $address = $_POST['address'];
        $id = $_POST['id'];
        $type = !empty($_POST['type']) ? $_POST['type'] : '';
        $phone = $_POST['phone'];
        $lodge = !empty($_POST['lodge']) ? $_POST['lodge'] : '';
        $region = !empty($_POST['region']) ? $_POST['region'] : '';
        $descr = $_POST['descr'];
        $descrShort = $_POST['descrShort'];
        $zip = $_POST['zip'];

        // validate input
        $valid = true;
        if(empty($name)) {
            $nameError = 'Please enter Name';
            $valid = false;
        }

        if(empty($email)) {
            $emailError = 'Please enter Email Address';
            $valid = false;
        }
        else {
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailError = 'Please enter a valid Email Address';
                $valid = false;
            }
        }

        if(empty($state)) {
            $stateError = 'Please enter State';
            $valid = false;
        }

        if(empty($city)) {
            $cityError = 'Please enter City';
            $valid = false;
        }

        if(empty($address)) {
            $addressError = 'Please enter Address';
            $valid = false;
        }

        if(empty($type)) {
            $typeError = 'Please enter Type';
            $valid = false;
        }

        if(empty($lodge)) {
            $lodgeError = 'Please enter a Lodging option';
            $valid = false;
        }

        if(empty($region)) {
            $regionError = 'Please enter a Region';
            $valid = false;
        }

        if(empty($phone)) {
            $phoneError = 'Please enter Phone Number';
            $valid = false;
        }
        else {
            $phoneVal = preg_replace('/[^0-9]/', '', $phone);
            if(strlen($phoneVal) != 10) {
                $phoneError = 'Please enter a 10 digit Phone Number';
                $valid = false;
            }
        }

        if(empty($descr)) {
            $descrError = 'Please enter a Description';
            $valid = false;
        }

        if(empty($descrShort)) {
            $descrShortError = 'Please enter a short Description';
            $valid = false;
        }

        if(empty($zip)) {
            $zipError = 'Please enter zip Number';
            $valid = false;
        }
        else {
            //$zipVal = preg_replace('/[^0-9]/', '', $zip);
            if(preg_match('/^\d{5}(?:[-\s]\d{4})?$/', $zip, $matches)) {
                $zip = $matches[0];
            }
            else {
                $zipError = 'Please enter a valid Zip Code';
                $valid = false;
            }
        }

        // insert data
        if($valid) {
            //TODO, GET BY ID
            $instance = Outfitter::withAll($id, $name, $email, $state, $city, $address, $type, $phone, $lodge, $region, null, $descr, $zip, $descrShort);
            $outfitters = $instance->editOutfitter();

            if($outfitters == false) {
                $genError = 'Error updating, try again';
                $valid = false;
            }
            else {
                if($outfitters) {
                    $success = true;
                }
                else {
                    unknownErr();
                    $valid = false;
                }
            }
        }
    }
    else {
        if(isset($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
            $instance = Outfitter::withID($id);
            $outfitter = $instance->getOutfitter();

            if($outfitter == -1) {
                $error .= " Outfitter $id does not exist";
            }
            else {
                foreach ($outfitter as $row) {
                    $name = $row->name;
                    $email = $row->email;
                    $state = $row->state_ID;
                    $city = $row->city;
                    $phone = $row->phone;
                    $address = $row->address;
                    $type = $row->type;
                    $lodge = $row->lodging;
                    $region = $row->region_id;
                    $descr = $row->description;
                    $descrShort = $row->descrShort;
                    $zip = $row->zip;
                }
            }
        }
        else {
            $error = "Please enter an ID";
        }
    }
}


include($_SERVER['DOCUMENT_ROOT']."/include/top_start.php");
?>
   <link href="/css/simple-sidebar.css" rel="stylesheet"><script src="/js/holder.js"></script>
<script>
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
<?php
include($_SERVER['DOCUMENT_ROOT']."/include/top_end.php");
?>
<div class="container-fluid">
      <div class="row">
        
        <?php include($_SERVER['DOCUMENT_ROOT'].'/include/sidebar.php');?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main whiteBackground">
          <h3 class="page-header">Outfitter Dashboard</h3>

          <div class="row placeholders">
            <div class="col-lg-6 col-lg-offset-3 col-md-7 col-md-offset-3 col-sm-12 col-xs-12">
		<div class="panel panel-default panel-success panel-success-custom .small-Panel">
			<div class="panel-heading clearfix text-center">
				<i class="icon-calendar"></i>
				<h3 class="panel-title"><?echo $title?></h3>
			</div>
			<div class="panel-body">
<?php  
	if($error!="")
	{
	?>
			<div class="inlineblock alert alert-danger" role="alert"><?=$error?></div>
	<?php
	}
	else
	{
		if ($success)
		{
?>
			<div class="inlineblock alert alert-success" role="alert">Outfitter edited successfully</div>
<?php
		}
		else
		{
			if($genError!="")
			{
?>
				<div class="inlineblock alert alert-danger" role="alert"><?=$genError?></a></div>
<?php
			}
}
?>
	 	<form class="form-horizontal row-border" action="editOutfitter.php?id=<?php echo $id?>" method="post" role="form">
		 	<input type="hidden" name="pageID" value="<?php echo $pageID?>">
			<input type="hidden" name="id" value="<?php echo $id?>">
                        <input type="hidden" name="hiddenRegionID" id = "hiddenRegionID" value="<?php echo $region?>">
<?php
			
			echo FormElementCreate2('name','Name',$nameError,!empty($name)?$name:'',null,"required");
			echo FormElementCreate2('email','Email Address',$emailError,!empty($email)?$email:'');
			echo FormElementCreate2('address','Address',$addressError,!empty($address)?$address:'',null,"required");
			echo FormElementCreate2('city','City',$cityError,!empty($city)?$city:'',null,"required");
			echo FormElementCreateDropdown('state','State',$stateError,!empty($state)?$state:'',"text","required",$states,'state_id','abbreviation');
			echo FormElementCreate2('zip','Zip code',$zipError,!empty($zip)?$zip:'');
			echo FormElementCreateDropdown('region','Region',$regionError,!empty($region)?$region:'',"text","required",null,'type_id','kind');
			echo FormElementCreate2('phone','Phone',$phoneError,!empty($phone)?$phone:'',null,"required");
			echo FormElementCreateDropdown('type','Type',$typeError,!empty($type)?$type:'',"text","required",$types,'type_id','kind');
			echo FormElementCreateDropdown('lodge','Available Lodging',$lodgeError,!empty($lodge)?$lodge:'',"text","required",$lodgings,'type_id','kind');
            echo FormElementCreateTextArea('descrShort','Short Description',$descrShortError,!empty($descrShort)?$descrShort:'',null,'maxlength="250"');
            echo FormElementCreateTextArea('descr','Description',$descrError,!empty($descr)?$descr:'',null,'maxlength="500"');
				
			?>
			
					<div class="col-md-2 col-md-offset-5">
						<button type="submit" class="btn btn-success">Edit</button>
					</div>   
				</form>
<?php 
	} 
?>
				</div>
			</div>
		</div>
	
	
	</div>
			</div>
		  </div>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/bottom.php");?>
