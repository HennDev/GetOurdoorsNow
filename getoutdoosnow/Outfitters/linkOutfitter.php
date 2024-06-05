<?php
	session_start();
	$title = "Create a new Outfitter";
	include($_SERVER['DOCUMENT_ROOT']."/database.php");	
	include($_SERVER['DOCUMENT_ROOT']."/common.php");
	$pageID = "linkOutfitter";
	$error = "";
	$success = false;
	$states = getAllStates();
	$types = getAllOutfitterTypes();
	$lodgings = getAllOutfitterLodging();
        $region = "";
	
	// keep track validation errors
	$nameError = null;
	$stateError = null;
    $emailError = null;
	$cityError = null;
	$addressError = null;
	$typeError = null;
	$phoneError = null;
	$lodgeError = null;
	$regionError = null;
	$descrError = null;
    $descrShortError = null;
    $zipError = null;
	
	if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
	{
		$email = $_SESSION['Username'];
		
		$instance = new Outfitter;
		$outfitters = $instance->getAllUsersOutfitters($email);
	}
	else
	{
		header( 'Location: /createUser.php?action=NewOutfitter' );
	}
	
	if($outfitters != -1)
	{
		foreach ($outfitters as $row) 
		{
			$id = $row['id'];
		}
	}
	
	
	if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
	{
		$email = $_SESSION['Username'];
        $emailUser = $_SESSION['Username'];
		$instance = new Outfitter;
		$outfitters = $instance->getAllUsersOutfitters($email);
		
		$limitReached = false;
		if(is_array($outfitters) && count($outfitters) >=1)
		{
			$limitReached = true;
		}
		
		if($limitReached)
		{
			header('Location: allUsersOutfitters.php' );
		}
		
		if (!empty($_POST) && $_POST['pageID'] == $pageID) 
		{
			// keep track post values
			$name = $_POST['name'];
			$state = !empty($_POST['state'])?$_POST['state']:'';
			$city = $_POST['city'];
			$address = $_POST['address'];
			$type = !empty($_POST['type'])?$_POST['type']:'';
			$phone = $_POST['phone'];
			$lodge = !empty($_POST['lodge'])?$_POST['lodge']:'';
			$region = !empty($_POST['region'])?$_POST['region']:'';
			$descr = $_POST['descr'];
            $descrShort = $_POST['descrShort'];
            $zip = $_POST['zip'];
            $email = $_POST['email'];



            // validate input
			$valid = true;
			if (empty($name)) 
			{
				$nameError = 'Please enter Name';
				$valid = false;
			}
			
			if (empty($state)) {
				$stateError = 'Please enter State';
				$valid = false;
			}

            if (empty($email)) {
                $emailError = 'Please enter Email Address';
                $valid = false;
            } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
                $emailError = 'Please enter a valid Email Address';
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
				if(strlen($phoneVal) != 10) 
				{
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
			
			// insert data
			if ($valid)
			{	
				$error = "here we go";
				$instance = Outfitter::withAllButID($name, $email, $state, $city, $address, $type, $phone, $lodge, $region, $emailUser, $descr, $zip, $descrShort);
				$outfitters = $instance->linkOutfitter();
				$error = "here we go";
				if($outfitters)
				{
					$userInstance = User::withEmail($email);
					
					$userInstance->setUserAsOutfitter();
					$_SESSION['isOutffiter'] = 1;
					header( 'Location: allUsersOutfitters.php?action=create' ) ;
				}
				else
				{
					unknownErr();
					$valid = false;
				}
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
			<div class="inlineblock alert alert-success" role="alert">Outfitter created successfully</div>
<?php
		}
?>
				<form class="form-horizontal row-border" action="linkOutfitter.php" method="post">
				<input type="hidden" name="pageID" value="<?php echo $pageID?>">
				<input type="hidden" name="hiddenRegionID" id = "hiddenRegionID" value="<?php echo $region?>">
<?php
	
	//FormElementCreate2('email','Email Address',$emailError,!empty($email)?$email:'',"hidden","readonly");
	echo FormElementCreate2('name','Name',$nameError,!empty($name)?$name:'',"text","required");
    echo FormElementCreate2('email','E-mail',$emailError,!empty($email)?$email:'',"email","required");

	echo FormElementCreate2('address','Address',$addressError,!empty($address)?$address:'',"text","required");
	echo FormElementCreate2('city','City',$cityError,!empty($city)?$city:'',"text","required");
	echo FormElementCreateDropdown('state','State',$stateError,!empty($state)?$state:'',"text","required",$states,'state_id','abbreviation');
    echo FormElementCreate2('zip','Zip code',$zipError,!empty($zip)?$zip:'');
    echo FormElementCreateDropdown('region','Region',$regionError,!empty($region)?$region:'',"text","required",null,'type_id','kind');
	echo FormElementCreate2('phone','Phone',$phoneError,!empty($phone)?$phone:'',"text","required");
	echo FormElementCreateDropdown('type','Type',$typeError,!empty($type)?$type:'',"text","required",$types,'type_id','kind');
	echo FormElementCreateDropdown('lodge','Available Lodging',$lodgeError,!empty($lodge)?$lodge:'',"text","required",$lodgings,'type_id','kind');
    echo FormElementCreateTextArea('descr','Description',$descrError,!empty($descr)?$descr:'',null,'maxlength="250"');
	echo FormElementCreateTextArea('descrShort','Short Description',$descrShortError,!empty($descrShort)?$descrShort:'',null,'maxlength="400"');
?>
				
<div class="col-md-2 col-md-offset-5">
						<button type="submit" class="btn btn-success">Create</button>
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
    </div>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/bottom.php");?>