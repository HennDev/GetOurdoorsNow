<?php
	session_start();
	$title = "Create an Outfitter";
	include($_SERVER['DOCUMENT_ROOT']."/database.php");
	include($_SERVER['DOCUMENT_ROOT']."/common.php");
	$pageID = "createOutfitter.php";
	$error = "";
    $criticalError = "";
	$success = false;
	$states = getAllStates();
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
	$zipError = null;
    $descrShortError = null;

if (!empty($_POST) && $_POST['pageID'] == $pageID)
	{
		// keep track post values
		$name = $_POST['name'];
		$email = $_POST['email'];
		$state = !empty($_POST['state'])?$_POST['state']:'';
		$city = $_POST['city'];
		$address = $_POST['address'];
		$type = !empty($_POST['type'])?$_POST['type']:'';
		$phone = $_POST['phone'];
		$lodge = !empty($_POST['lodge'])?$_POST['lodge']:'';
		$region = !empty($_POST['region'])?$_POST['region']:'';
		$descr = $_POST['descr'];
		$zip = $_POST['zip'];
        $descrShort = $_POST['descrShort'];

		// validate input
		$valid = true;
		if (empty($name)) 
		{
			$nameError = 'Please enter Name';
			$valid = false;
		}
		
		if (empty($email)) 
		{
			$emailError = 'Please enter Email Address';
			$valid = false;
		} 
		else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$emailError = 'Please enter a valid Email Address';
			$valid = false;
		}
		
		if (empty($state)) {
			$stateError = 'Please enter State';
			$valid = false;
		}
		
		if (empty($city)) {
			$cityError = 'Please enter City';
			$valid = false;
		}
		
		if (empty($address)) {
			$addressError = 'Please enter Address';
			$valid = false;
		}
		
		if (empty($type)) {
			$typeError = 'Please enter Type';
			$valid = false;
		}
		
		if (empty($lodge)) {
			$lodgeError = 'Please enter a Lodging option';
			$valid = false;
		}
		
		if (empty($region)) {
			$regionError = 'Please enter a Region';
			$valid = false;
		}
		
		if (empty($phone)) {
			$phoneError = 'Please enter Phone Number';
			$valid = false;
		}
		else
		{
			$phoneVal = preg_replace('/[^0-9]/', '', $phone);
			if(strlen($phoneVal) != 10) {
				$phoneError = 'Please enter a 10 digit Phone Number';
				$valid = false;
			}
		}

		if (empty($zip)) {
			$zipError = 'Please enter zip Number';
			$valid = false;
		}
		else
		{
			//$zipVal = preg_replace('/[^0-9]/', '', $zip);
			if (preg_match('/^\d{5}(?:[-\s]\d{4})?$/', $zip, $matches)) {
				$zip = $matches[0];
			}
			else
			{
				$zipError = 'Please enter a valid Zip Code';
				$valid = false;
			}
		}

		if (empty($descr)) {
			$descrError = 'Please enter a Description';
			$valid = false;
		}

        if (empty($descrShort)) {
            $descrShortError = 'Please enter a Short Description';
            $valid = false;
        }
		
		
		// insert data
		if ($valid)
		{
			
			$instance = Outfitter::withAllButID($name, $email, $state, $city, $address, $type, $phone, $lodge, $region, null, $descr, $zip, $descrShort);
			$outfitters = $instance->createOutfitter();


            //TODO: Verify not an outfitter with this email doesn't already exist
            $outfitterCount = $outfitters->rowCount();


            if($outfitterCount==0)
			{
				$error = 'An unknown error has occurred';
				$valid = false;
			}
			else if($outfitters)
			{
				$success = true;
				
				$name = '';
				$email = '';
				$state = '';
				$city = '';
				$address = '';
				$type = '';
				$phone = '';
				$lodge = '';
				$region = '';
				$zip = '';
				$descr = '';
                $descrShort = '';
            }
			else
			{
                $emailError = 'Email Address already taken';

                //unknownErr();
				$valid = false;
			}
		}
	}
	
	
	include($_SERVER['DOCUMENT_ROOT'].'/include/top_start.php');
?>
<script>
$(document).ready(function(){
	
	$('#state').change(function(){
		var state_ID = $('#state').val();
		fillRegion(state_ID);
	});
	
	if($('#state').val() != null)
	{
		var stateID = $('#state').val();
		var regionID = $('#hiddenRegionID').val();
		fillRegion(stateID,regionID);
	}
});

function fillRegion(stateID, regionID)
{
	if(stateID != null)
	{
		$('#region').empty();
		$('#region').append('<option value="loading">loading....</option>');
		$('#region_loading').show();
		var appendVal = "";
		var selected = "";
		
		$.getJSON("/Ajax/getRegionsByState.php?state_id="+stateID, function(result){
			$.each(result, function(i, field){
				if(regionID == field['region_id'])
				{
					selected = "selected";
				}
				else
				{
					selected = "";
				}
				appendVal += '<option ' + ((regionID == field['region_id']) ? 'selected' : '') + ' value="'+field['region_id']+'">'+field['region']+'</option>';
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
	include($_SERVER['DOCUMENT_ROOT'].'/include/top_end.php');
?>


<div class="container">
	<div class="col-md-6 col-md-offset-3 col-sm-6 col-xs-12">
		<div class="panel panel-default panel-success panel-success-custom .small-Panel">
			<div class="panel-heading clearfix text-center">
				<i class="icon-calendar"></i>
				<h3 class="panel-title"><?echo $title?></h3>
			</div>
			<div class="panel-body">

		<?php
	if($criticalError!="")
	{
	?>
			<div class="alert alert-danger col-md-2 col-md-offset-5" role="alert"><?=$error?></div>
	<?php
	}
	else
	{
		if ($success)
		{
?>
            <div class="row">
			<div class="col-md-6 col-md-offset-3 alert alert-success" role="alert">Outfitter created successfully</div>
            </div>
<?php
		}
        if($error!="")
        {
            ?>
            <div class="row">

            <div class="alert alert-danger col-md-6 col-md-offset-3" role="alert"><?=$error?></div>
</div>
            <?php
        }
?>
				<form class="form-horizontal row-border" action="createOutfitter.php" method="post">	
					<input type="hidden" name="pageID" value="<?php echo $pageID?>">
                    <input type="hidden" name="hiddenRegionID" id = "hiddenRegionID" value="<?php if(!empty($region)) {echo $region;}?>">
<?php
	echo FormElementCreate2('name','Name',$nameError,!empty($name)?$name:'');
	echo FormElementCreate2('email','Email Address',$emailError,!empty($email)?$email:'');
	echo FormElementCreate2('address','Address',$addressError,!empty($address)?$address:'');
	echo FormElementCreate2('city','City',$cityError,!empty($city)?$city:'');
	echo FormElementCreateDropdown('state','State',$stateError,!empty($state)?$state:'',"text","required",$states,'state_id','abbreviation');
	echo FormElementCreate2('zip','Zip code',$zipError,!empty($zip)?$zip:'');
	echo FormElementCreateDropdown('region','Region',$regionError,!empty($region)?$region:'',"text","required",null,'type_id','kind');


	echo FormElementCreate2('phone','Phone',$phoneError,!empty($phone)?$phone:'');
	echo FormElementCreateDropdown('type','Type',$typeError,!empty($type)?$type:'',"text","required",$types,'type_id','kind');
	echo FormElementCreateDropdown('lodge','Available Lodging',$lodgeError,!empty($lodge)?$lodge:'',"text","required",$lodgings,'type_id','kind');
	echo FormElementCreateTextArea('descr','Description',$descrError,!empty($descr)?$descr:'',null,'maxlength="400"');
    echo FormElementCreateTextArea('descrShort','Short Description',$descrShortError,!empty($descrShort)?$descrShort:'',null,'maxlength="250"');
?>
				<div class="col-md-2 col-md-offset-5">
					<button type="submit" class="btn btn-success">Create</button>
				</div>    
			</form>
<?php 
	} 
?>				</div>
			</div>
		</div>
	</div>
<?php 	include($_SERVER['DOCUMENT_ROOT'].'/include/bottom.php');?>