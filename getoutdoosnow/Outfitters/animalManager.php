<?php
	session_start();	
    $title = "My Animals";
	include($_SERVER['DOCUMENT_ROOT']."/database.php");	
	include($_SERVER['DOCUMENT_ROOT']."/common.php");
	$pageID = "animalManager";
	$error = "";
	$genError = "";
	$success = false;
	$states = getAllStates();
	$types = getAllOutfitterTypes();
	$lodgings = getAllOutfitterLodging();
    $allHuntingAnimals = array();
	$allFishingAnimals = array();
    $selected = "";
	$selectedArray = explode(',',$selected);
	$selectedIDs = array();

    if(empty($_SESSION['LoggedIn']) || empty($_SESSION['Username']))
    {
        $error = "You must be logged in";
    }
    else {
        if(isset($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
            $outfitterInstance = Outfitter::withID($id);
            $outfitter = $outfitterInstance->getOutfitter();

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
                }
            }
            if($type == 1) {
                //Hunting
                // echo "stophere";
                $instance = new Animals;
                $animals = $instance->getAnimals("Hunting");
            }
            elseif($type == 2) {
                //Fishing
                $instance = new Animals;
                $animals = $instance->getAnimals("Fishing");
            }
            else {
                //Both
                $instance = new Animals;
                $animals = $instance->getAnimals();
            }


            if(!empty($_POST['selected'])) {
                $selected = $_REQUEST['selected'];
                $selectedArray = explode(',', $selected);
                $selectedIDs = array_filter($selectedArray, function ($v) {
                    return $v > 0;
                });
                //$genError = "From Page: ".implode(',', $selectedIDs);
            }
            else {
                $selecte = array();
            }


            $animalsFromDB = array();
            $animalsToBeDeleted = array();
            $animalsToBeSaved = array();

            $outfitterInstance = Outfitter::withID($id);
            $outfitterAnimals = $outfitterInstance->getAnimalsByOutfitter();

            if(is_array($outfitterAnimals) && count($outfitterAnimals) > 0) {
                foreach ($outfitterAnimals as $outfitterAnimal) {
                    array_push($animalsFromDB, $outfitterAnimal["animals_id"]);

                    if(!in_array($outfitterAnimal["animals_id"], $selectedIDs)) {
                        array_push($animalsToBeDeleted, $outfitterAnimal["animals_id"]);
                    }
                }
                //$genError .= " <br><br>From DB: ".  implode(',', $animalsFromDB);
            }

            foreach ($selectedIDs as $outfitterAnimal) {
                if(!in_array($outfitterAnimal, $animalsFromDB)) {
                    array_push($animalsToBeSaved, $outfitterAnimal);
                }
            }
        }
        else {
            $error = "Please enter an ID";
        }
    }
	
	if($error =="" && !empty($_POST) && $_POST['pageID'] == $pageID) 
	{	$valid = true;
		// insert data
		if($valid)
		{
			
			if(is_array($animalsToBeSaved) && count($animalsToBeSaved)>0)
			{
				//$genError .= " <br><br>To Be Saved: ".  implode(',', $animalsToBeSaved);
				$saved = $outfitterInstance->addAnimalsByOutfitter($animalsToBeSaved);
				if(!$saved)
				{
					$genError .= "COULDN'T SAVE";
				}
			}
			
			if(is_array($animalsToBeDeleted) && count($animalsToBeDeleted)>0)
			{
				//$genError .= " <br><br>To Be Deleted: ".  implode(',', $animalsToBeDeleted);
				$deleted = $outfitterInstance->deleteAnimalsByOutfitter($animalsToBeDeleted);
				if(!$deleted)
				{
					$genError .= "COULDN'T DELETE";
				}
			}
		}
	}
	else
	{
		//TODO: why is this here? $selectedIDs = $animalsFromDB;
	}
	
		if($error == "")
		{
			$jsonBuiler = array();
			$level00 = array();
			$level11 = array();

			for ($i = 0; $i < count($animals); ++$i) 
			{
				if(strval($animals[$i]->activity) =="Fishing")
				{
					if(strval($animals[$i]->type==""))
					{
						$level00[strval($animals[$i]->activity)][strval($animals[$i]->FreshSalt)]["N/A"][strval($animals[$i]->animal)] = array(strval($animals[$i]->animal),strval($animals[$i]->id));	
					}
					else
					{
					$level00[strval($animals[$i]->activity)][strval($animals[$i]->FreshSalt)][strval($animals[$i]->type)][strval($animals[$i]->animal)] = array(strval($animals[$i]->animal),strval($animals[$i]->id));
					}
				}
				else
				{
					$level11[strval($animals[$i]->activity)][$animals[$i]->type][$animals[$i]->animal] = array(strval($animals[$i]->animal),strval($animals[$i]->id));
				}
			}

			$i = -1;
			$jsonBuilderFish = "";
			foreach($level00 as $key => $value)
			{
				$jsonBuilderFish .= '{"id":'.$i.', state: { opened    : true }  ,"text":"'.$key.'"';
				$i--;
				if(count($value)>0)
				{
					$jsonBuilderFish.= ',"children":';
				}
				$jsonBuilderFish .= '[';

				$last1 = array();
				$last1 = $value;
				end($last1);
				$last1key = key($last1);

				foreach($value as $key1 => $value1)
				{
					$jsonBuilderFish.='{"id":'.$i.',"text":"'.$key1.'"';
					$i--;

					if(count($value1)>0)
					{
						$jsonBuilderFish.= ',"children":[';
					}

					$last2 = array();
					$last2 = $value1;
					end($last2);
					$last2key = key($last2);


					foreach($value1 as $key2 => $value2)
					{
						$jsonBuilderFish.='{"id":'.$i.',"text":"'.$key2.'"';
						$i--;

						if(count($value2)>0)
						{
							$jsonBuilderFish.= ',"children":[';
						}

						$j = "1";
						foreach($value2 as $key3)
						{
							
							$jsonBuilderFish.='{"id":'.$key3[1].',"text":"'.$key3[0].'"';
							
							if(in_array($key3[1],$selectedIDs))
							{
								$jsonBuilderFish.=',"state" : {"opened" : true,"selected" : true}';
							}
							$jsonBuilderFish.='}';

							if($j<count($value2))
							{
								$jsonBuilderFish.=',';
							}
							$j++;
						}
						if(count($value2)>0)
						{
							$jsonBuilderFish.= ']';
						}

						$jsonBuilderFish.='}';
						if($last2key!=$key2)
						{
							$jsonBuilderFish.=',';
						}
					}

					if(count($value1)>0)
					{
						$jsonBuilderFish.= ']';
					}

					$jsonBuilderFish.='}';

					if($last1key!=$key1)
					{
						$jsonBuilderFish.=',';
					}
				}

				$jsonBuilderFish .=']';
				$jsonBuilderFish .='}';
			}


			$jsonBuilderHunt = "";
			foreach($level11 as $key => $value)
			{
				$jsonBuilderHunt .= '{"id":'.$i.',"text":"'.$key.'"';
				$i--;
				if(count($value)>0)
				{
					$jsonBuilderHunt.= ',"children":';
				}
				$jsonBuilderHunt .= '[';

				$last2 = array();
				$last2 = $value;
				end($last2);
				$last2key = key($last2);

				foreach($value as $key2 => $value2)
				{
					$jsonBuilderHunt.='{"id":'.$i.',"text":"'.$key2.'"';
					$i--;

					if(count($value2)>0)
					{
						$jsonBuilderHunt.= ',"children":[';
					}

					$j = "1";
					foreach($value2 as $key3)
					{
						$jsonBuilderHunt.='{"id":'.$key3[1].',"text":"'.$key3[0].'"';
						
						if(in_array($key3[1],$selectedIDs))
						{
							$jsonBuilderHunt.=',"state" : {"opened" : true,"selected" : true}';
						}
						$jsonBuilderHunt.='}';

						if($j<count($value2))
						{
							$jsonBuilderHunt.=',';
						}
							$j++;
					}

					if(count($value2)>0)
					{
						$jsonBuilderHunt.= ']';
					}

					$jsonBuilderHunt.='}';

					if($last2key!=$key2)
					{
						$jsonBuilderHunt.=',';
					}
				}

				$jsonBuilderHunt .=']';
				$jsonBuilderHunt .='}';

			}


			$jsonBuilder = "[";
			if($type == 1)
			{
				$jsonBuilder .= $jsonBuilderHunt;
			}
			else if($type == 2)
			{
				$jsonBuilder .= $jsonBuilderFish;
			}
			else
			{
				$jsonBuilder .= $jsonBuilderHunt.",".$jsonBuilderFish;
			}

			$jsonBuilder .= "]";
			//		echo "<br><br>".$jsonBuilderFish."<br><br>";
			//	echo "<br><br>".$jsonBuilderHunt."<br><br>";
			//	echo "<br><br>".$jsonBuilder."<br><br>";	
		}
		
			include($_SERVER['DOCUMENT_ROOT'].'/include/top_start.php');
	// Any extra scripts go here
?>
	<script src="/jstree.js"></script>
	<link rel="stylesheet" href="/css/themes/default/style.min.css" />
	<script>
	$( document ).ready(function() {
		
		  /*$("#btnDelete, #btnEdit, #btnView, #btnCreate").click(function(e) {
		    e.preventDefault();
		
		    var form = $("#myform");
		    form.prop("action", $(this).data("url"));
		    form.submit();
		  	});
*/

	// inline data demo
	<?php $thishere = '$("#data").jstree({"plugins":["wholerow","checkbox","search"], "core" : {
			"data" : '.$jsonBuilder.'
		}
	  });';
	if($thishere!="")
	{
		echo $thishere;
	
	}
	?>
	
	
$("#q").keyup(function(e) {
  e.preventDefault();
  $("#data").jstree(true).search($("#q").val());
});
	
	$("#Update").click(function(e) {
								
						//TODO: GET VALUE OF SELECTED
						$("#selected").val($("#data").jstree(true).get_checked().join(','));
	});
   });
   
   
</script>

     
   <link href="/css/simple-sidebar.css" rel="stylesheet"><script src="/js/holder.js"></script>

<?php
	include($_SERVER['DOCUMENT_ROOT'].'/include/top_end.php');
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
	//TODO: Fix
	if($error!=""){
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
			<form class="form-horizontal row-border" action="<?php echo $pageID?>.php?id=<?php echo $id?>" method="post" role="form">
				<!--hihurrythe fuckup					hehelovewifey -->
				<div class="col-lg-6 col-lg-offset-4  col-md-4 col-md-offset-3 col-sm-8 col-sm-offset-4 col-xs-12" style="text-align:left;">
				<input type="search" id="q" placeholder="Search Here" />
				<div id="data" class="demo"></div>
				<br>
				 </div>
				<div class="col-md-2 col-md-offset-5">
				<button type="submit" class="btn btn-success" id="Update">Update</button>
				</div>   
				
				<input type="hidden" name="pageID" value="<?php echo $pageID?>">
				<input type="hidden" name="id" value="<?php echo $id?>">
				<input type="hidden" name="selected" id="selected" value="<?php echo $selected?>">
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
   

	
	<?php include($_SERVER['DOCUMENT_ROOT'].'/include/bottom.php');?>
 
