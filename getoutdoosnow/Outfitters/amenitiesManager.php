<?php
session_start();
$title = "My Amenities";
include($_SERVER['DOCUMENT_ROOT']."/database.php");
include($_SERVER['DOCUMENT_ROOT']."/common.php");
$pageID = "amenitiesManager";
$error = "";
$genError = "";
$success = false;
$selected = "";
$selectedArray = explode(',',$selected);
$selectedIDs = array();

if(isset($_REQUEST['id']))
{
    $id = $_REQUEST['id'];
    $outfitterInstance = Outfitter::withID($id);
    $outfitter = $outfitterInstance->getOutfitter();

    if($outfitter==-1)
    {
        $error .=  " Outfitter $id does not exist";
    }
    else
    {
        foreach ($outfitter as $row)
        {
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


    if(!empty($_POST['selected']))
    {
        $selected = $_REQUEST['selected'];$selectedArray = explode(',',$selected);
        $selectedIDs = array_filter($selectedArray, function ($v) {
            return $v > 0;
        });
    }
    else
    {
        $selecte = array();
    }
}
else
{
    $error = "Please enter an ID";
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
   // $selectedIDs = $animalsFromDB;
}

if($error == "")
{
    $jsonBuiler = array();
    $level00 = array();
    $level11 = array();
}

include($_SERVER['DOCUMENT_ROOT'].'/include/top_start.php');
// Any extra scripts go here
?>
<script src="/jstree.js"></script>
<link rel="stylesheet" href="/css/themes/default/style.min.css" />
<script>
    $( document ).ready(function() {



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


                    <div class="panel panel-default panel-success small-Panel">
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
 
