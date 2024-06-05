<?php
session_start();
$title = "Edit Image";
include($_SERVER['DOCUMENT_ROOT']."/database.php");
include($_SERVER['DOCUMENT_ROOT']."/common.php");
$pageID = "editImage";
$error = "";
$genError = "";
$success = false;
$valid_mime_types = array(
    "image/gif",
    "image/png",
    "image/jpeg",
    "image/pjpeg",
);

// keep track validation errors
$descriptionError = null;
$fileError = null;



if(empty($_SESSION['LoggedIn']) || empty($_SESSION['Username']))
{
    $error = "You must be logged in";
}
if (!empty($_POST) && $_POST['pageID'] == $pageID)
{
    $valid = true;
    // Posted from same page, so keep track post values
    $description = !empty($_POST['description'])?$_POST['description']:'';

    if (empty($description))
    {
        $descriptionError = 'Please enter description';
        $valid = false;
    }



    if($valid) {
        //TODO: update description
        $imageId= $_POST['id'];
        $outfitterID = $_POST['outfitterID'];
        $id = $outfitterID;
        $myImage = Image::withID($imageId);
        $outfitter = $myImage->updateImage($description);
        $myImage->printImageInfo();
    }

    /*
    // insert data
    if ($valid)
    {
        //TODO, GET BY ID
        $instance = Outfitter::withAll($id,$name, $email, $state, $city, $address, $type, $phone, $lodge, $region, null, $descr);
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
        }
    }*/
}
else if(isset($_GET['imageId']))
{
    $imageId= $_GET['imageId'];

    $email = $_SESSION['Username'];
    $instance = new User;
    $user = $instance->getUser($email);
    $roles = $_SESSION['Roles'];

    //Check to see if this image belongs to user
    $isUsersImage = $imageInstance->isUserImage($email,$imageId);

    //if belongs to image and not a post
    if((count($isUsersImage)>0 && !isset($outfitterID)))
    {
        $outfitterID =  $isUsersImage["outfitterID"];
        $id = $outfitterID;
    }

    if(is_array($roles) && in_array("admin",$roles))
    {
        $imgInstance = Image::withID($imageId);
        $outfitterID = $imgInstance->outfitter_id;
    }

    if($user==-1)
    {
        $error .=  " User with $email does not exist";
    }
    else
    {
        foreach ($user as $row)
        {
            $userID = $row['user_id'];
        }
    }

    if(!isset($outfitterID)) {
        $error.=  " This is not your outfitter";
    }
}
else
{
      $error = "Please enter an ID";
}

if($error == "")
{
    $filecount = countImages($outfitterID);
    $instance = new Image;
    $images = $instance->getOutfitterImage($outfitterID,$imageId);

    $description = $images[0]["description"];

    // echo print_r($images,true);
}

function countImages($outfitter_ID)
{
    $directory = $_SERVER['DOCUMENT_ROOT'] . '/upload/images/' . $outfitter_ID . '/';
    $files = glob($directory . '/*');

    if ($files !== false) {
        return count($files);
    } else {
        return -1;
    }
}

include($_SERVER['DOCUMENT_ROOT']."/include/top_start.php");
?>
<link href="/css/simple-sidebar.css" rel="stylesheet"><script src="/js/holder.js"></script>

<script>
    $( document ).ready(function() {
        $("#btnDelete, #btnEdit, #btnView, #btnCreate").click(function(e) {
            e.preventDefault();

            var form = $("#myform");
            form.prop("action", $(this).data("url"));
            form.submit();
        });
    });
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
                <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
                   <?php if($error!="")
                   {
                   ?>
                    <div class="inlineblock alert alert-danger" role="alert"><?=$error?></div>
                    <?php
                    }
                    else
                    {?>
                    <div class="panel panel-default panel-success panel-success-custom .small-Panel">
                        <div class="panel-heading clearfix text-center">
                            <i class="icon-calendar"></i>
                            <h3 class="panel-title"><?echo $title?></h3>
                        </div>
                        <div class="panel-body">
                            <?php

                            if ($success)
                            {
                                ?>
                                <div class="inlineblock alert alert-success" role="alert">File uploaded successfully</div>
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
                            <form class="form-horizontal row-border" enctype='multipart/form-data' action="<?php echo $pageID ?>.php?id=<?php echo $imageId?>" method="post" role="form" id="myform">
                                <input type="hidden" name="pageID" value="<?php echo $pageID?>">
                                <input type="hidden" name="id" value="<?php echo $imageId?>">
                                <input type="hidden" name="outfitterID" value="<?php echo $outfitterID?>">

                                <div class="col-lg-6 col-lg-offset-3 col-md-7 col-md-offset-3 col-sm-12 col-xs-12">
                                   <?php
                                    echo FormElementCreate2('description','Description',$descriptionError,!empty($description)?$description:'',null,"required");
                                    ?>
                                </div>


                                <?php //echo $outfitterID .  '   count: '.$filecount?>
                                <div class="col-lg-6 col-lg-offset-3 col-md-7 col-md-offset-3 col-sm-12 col-xs-12">
                                    <button type="submit" class="btn btn-success">Edit</button>
                                </div>
                                <br>
                                <br>
                                <br>
                        </div>

                        <?php
                        $directory = $_SERVER['DOCUMENT_ROOT'].'/upload/images/'.$outfitterID.'/';
                        $files = glob($directory. '/*');

                        if ( $files !== false || count($images)==0)
                        {
                           foreach ($images as $row)
                                    {
                                        $extension = $row['type'];

                                        ?>


                            <img class="img-responsive" style="margin: 0 auto;" /*style= "max-height: 600px; max-width: 400px;" */ src="/upload/images/<?php echo $row['outfitter_id'] ?>/<?php echo $row['id'].".".$extension?>" /><br />
                                        <legend ><?php echo $row['description'] ?></legend>
<?php
                                    }

                            ?>                      <br><br><br><br>

                            <?php
                        }
                        else
                        {
                            echo "No Images";
                        }
                        ?>
                        </form>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php include($_SERVER['DOCUMENT_ROOT']."/include/bottom.php");?>

