<?php
ini_set('display_errors', 1);

session_start();
$title = "Confirmation";
include($_SERVER['DOCUMENT_ROOT'] . "/database.php");
include($_SERVER['DOCUMENT_ROOT'] . "/common.php");
$error = "";
$pageID = "activityIndex";


include($_SERVER['DOCUMENT_ROOT'] . "/include/top_start.php");
// Any extra scripts go here
?>

    <script>
    </script>
    <style>

        .list-group-item.active {
            background-color: #24680C;
            border-color: #24680C;
        }

        body
        {
            padding-top: 70px !important;
        // background-color: white !important;
        }

        .control-label:nth-of-type(1)
        {
            border-right: solid #24680C;
        }

        label.error {
            /* remove the next line when you have trouble in IE6 with labels in list */
            color: red;
            font-style: italic
        }


    </style>



<?php
include($_SERVER['DOCUMENT_ROOT'] . "/include/top_end.php");

$activityID = $_POST['activityID'];
$numberOfPeople = $_POST['spots'];

$firstNameError = null;
$lastNameError = null;
$emailError = null;
$zipError = null;
$phoneError = null;


if ( !empty($_POST)) {
    // keep track validation errors

    $email = $_POST['email'];
    $zip = $_POST['zip'];
    $card_holder_name = $_POST['card_holder_name'];
    $card_number = $_POST['card_number'];
    $expiry_month = $_POST['expiry_month'];
    $expiry_year = $_POST['expiry_year'];
    $cvv = $_POST['cvv'];
    $userPhone = $_POST['userPhone'];

    $activityID = $_POST['activityID'];
    $numberOfPeople = $_POST['spotsSelected'];
    $outfitterID = $_POST['outfitterID'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    $activity = getOutfitterActivity($activityID,$outfitterID);
    $basePrice = $activity["Price"] * $numberOfPeople;
    $taxes = .1522;
    $taxesPrice = $basePrice * .1522;
    $subtotal = $basePrice + $taxesPrice;

    $outfitter = Outfitter::getSingleOutfitter($outfitterID);


    $directory = $_SERVER['DOCUMENT_ROOT'] . '/upload/images/' . $outfitterID . '/';
    $files = glob($directory . '/*');

    $instance = new Image;
    $images = $instance->getAllOutfitterImages($outfitterID);


    if(!isset($outfitter->name))
    {
        $error .=  " Outfitter $outfitterID does not exist";
    }
    else
    {
        $outfitterTypeFormatted = "Other";
        switch($outfitter->type)
        {
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

        $mapAddress = $outfitter->address . ' '. $outfitter->city . ' '. $outfitter->state  . ' US';

        $outfitterAnimals = $outfitter->getAnimalsByOutfitterWithDetails();
    }

    if(!empty($_POST['pageID']) && $_POST['pageID'] == $pageID) {

        // validate input
        $valid = true;
        /*if(empty($password)) {
            $passwordError = 'Please enter Password';
            $valid = false;
        }

        if(empty($email)) {
            $emailError = 'Please enter Email Address';
            $valid = false;
        }*/



        // insert data
        if($valid) {
            if(true) {

            }
            else {
                $valid = false;
            }
        }
    }
    else
    {
        $email = "";
    }
}
else
{
    $error = "Not allowed without post";
}
?>
    <div class="whitePageBackground">
        <?php
        if($error!="")
        {
            echo $error;
        }
        else
        {
            ?>
                <div class="container-fluid">
                    <div class="container" style="">
                        <div class="row row-custom">
                            <div class="col-xs-12">
                                <div class="panel panel-default panel-success panel-success-custom" style="margin-top:20px">
                                    <div class="panel-body">
                                        <div class="row row-custom">
                                            <div class="col-xs-12">
                                                <div class="alert alert-success" role="alert"><h3><?php print_fa_icon("fa-check-circle",1.5,1,"#24680C"); ?> &nbsp;&nbsp;&nbsp; Thank you for your purchase, please check your email for a confirmation.  </h3></div>
                                            </div>
                                            <div class="col-xs-12">
                                               <!-- List group -->
                                              <ul class="list-group">
                                                        <a href="#" class="list-group-item active">Outfitter Info</a>
                                                        <li class="list-group-item">
                                                            <span class="pull-right"><?php echo $outfitter->name; ?></span>
                                                            Outfitter Name:
                                                        </li>
                                                        <li class="list-group-item">
                                                            <span class="pull-right"><?php echo $outfitter->address . ", " . $outfitter->city . " " . $outfitter->state . ", " . $outfitter->zip; ?></span>
                                                            Outfitter Address:
                                                        </li>
                                                        <li class="list-group-item">
                                                            <span class="pull-right"><?php $phone = $outfitter->phone;  echo "(".substr($phone, 0, 3).") ".substr($phone, 3, 3)."-".substr($phone,6); ?></span>
                                                            Outfitter Address:
                                                        </li>
                                                        <a href="#" class="list-group-item active">Activity Info</a>
                                                        <li class="list-group-item">
                                                            <span class="pull-right"><?php echo $activity["Name"]; ?></span>
                                                            Activity Name:
                                                        </li>
                                                        <li class="list-group-item">
                                                            <span class="pull-right">
<?php
                                                                $dateStart = new DateTime($startDate);
                                                                $dateEnd = new DateTime($endDate);

                                                                echo $dateStart->format('D, M j, Y')." - ".$dateEnd->format('D, M j, Y')
?>
                                                            </span>
                                                            Activity Duration:
                                                        </li>

                                                        <a href="#" class="list-group-item active">User Info</a>
                                                        <li class="list-group-item">
                                                            <span class="pull-right"><?php echo $card_holder_name; ?></span>
                                                            Name on card:
                                                        </li>
                                                        <li class="list-group-item">
                                                            <span class="pull-right"><?php echo $email; ?></span>
                                                             E-mail
                                                        </li>
                                                        <li class="list-group-item">
                                                            <span class="pull-right"><?php echo "(".substr($userPhone, 0, 3).") ".substr($userPhone, 3, 3)."-".substr($userPhone,6); ?></span>
                                                            Phone:
                                                        </li>
                                                        <li class="list-group-item">
                                                            <span class="pull-right"><?php echo $card_number; ?></span>
                                                            Card number:
                                                        </li>

                                                        <a href="#" class="list-group-item active">Pricing Info</a>
                                                        <li class="list-group-item">
                                                            <span class="pull-right"><?php echo $basePrice; ?></span>
                                                            Price per person:
                                                        </li>
                                                        <li class="list-group-item">
                                                            <span class="pull-right"><?php echo $numberOfPeople; ?></span>
                                                            Number of people:
                                                        </li>
                                                        <li class="list-group-item">
                                                            <span class="pull-right"><?php echo round($taxesPrice,2); ?></span>
                                                            Fee and Taxes:
                                                        </li>
                                                        <li class="list-group-item">
                                                            <span class="pull-right"><?php echo round($subtotal,2); ?></span>
                                                            Total Paid:
                                                        </li>





                                                    </ul>

                                            </div>
                                         </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>












        <?php } ?>
    </div>


<?php include($_SERVER['DOCUMENT_ROOT'] . "/include/bottom.php");?>