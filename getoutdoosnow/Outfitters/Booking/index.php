<?php
ini_set('display_errors', 1);

session_start();
$title = "Activity Details";
include($_SERVER['DOCUMENT_ROOT'] . "/database.php");
include($_SERVER['DOCUMENT_ROOT'] . "/common.php");
$error = "";
$pageID = "activityIndex";


include($_SERVER['DOCUMENT_ROOT'] . "/include/top_start.php");
// Any extra scripts go here
?>

    <script>
        $(document).ready(function() {
            // override jquery validate plugin defaults
            $.validator.setDefaults({
                highlight: function(element) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function(element) {
                    $(element).closest('.form-group').removeClass('has-error');
                },
                errorElement: 'span',
                errorClass: 'help-block',
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "agreement") {

                        // do whatever you need to place label where you want

                        // an example
                       // error.insertBefore( $("#someOtherPlace") );

                        // just another example
                        $("#agreementerror").html( error );

                    }
                    else if(element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            $("#spotsSelected").change(function()
            {
                var pricePerPerson = $("#pricePerPerson").val();
                var selected =  $("#spotsSelected").val();
                var taxes = $("#taxes").val();

                var priceValue = Number((selected * pricePerPerson).toFixed(2)); // 6.7
                var taxesValue = Number((priceValue * taxes).toFixed(2))
                var totalValue = Number((priceValue + taxesValue).toFixed(2))

                $("#lblPrice").text("Price ("+selected+" people):");
                $("#lblPriceValue").text("$"+priceValue);
                $("#lblTaxesValue").text("$"+taxesValue);
                $("#lblTotalValue").text("$"+totalValue);

                $("#priceValue").val(+priceValue);
                $("#taxesValue").val(taxesValue);
                $("#totalValue").val(totalValue);

            });

            $("#book").click(function (event)
            {

                $("#informationForm").validate({
                    rules: {
                        firstName: "required",
                        lastName: "required",
                        username: {
                            required: true,
                            minlength: 2
                        },
                        card_holder_name: {
                            required: true
                        },
                        card_number: {
                            required: true,
                            number: true
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        zip: {
                            required: true,
                            minlength: 5
                        },
                        cvv: {
                            required: true,
                            number: true
                        },
                        expiry_year: "required",
                        expiry_month: "required",
                        userPhone: "required",
                        agreement: {
                            required: true,
                            minlength: 1
                        }
                    },
                    messages: {
                        firstName: "Please enter your firstname",
                        lastName: "Please enter your lastname",
                        username: {
                            required: "Please enter a username"
                        },
                        card_number: {
                            required: "Please provide a credit card number"
                        },
                        confirm_password: {
                            required: "Please provide a password",
                            minlength: "Your password must be at least 5 characters long",
                            equalTo: "Please enter the same password as above"
                        },
                        email: "Please enter a valid email address",
                        cvv: {
                            required: "Please enter a cvv",
                            number: "Cvv must be a number"
                        },
                        userPhone: "Please enter a phone number",
                        zip: {
                            required: "Please enter a valid zip (ex. 78260)",
                            minlength: "Your zip must be at least 5 characters long"
                        },
                        expiry_month: "Please select a month",
                        expiry_year: "Please select a year",
                        agreement: "You must agree to the terms"
                    },
                    submitHandler: function(form) {
                        event.preventDefault();

                        $("#pleaseWaitDialog").modal({
                            backdrop: 'static',
                            keyboard: false
                        });

                        $(".progress-bar").animate({ width: "100%"},2500,function(){
                            setTimeout(function() {
                                form.submit();
                            }, 2000);
                        });
                    }
                });





            });
        });
    </script>

    <script type="text/javascript" src="/js/jquery-validation-1.15.0/dist/jquery.validate.js"></script>
    <style>

        body
        {
            padding-top: 70px !important;
           // background-color: white !important;
        }

        .control-label:nth-of-type(1)
        {
            border-right: solid #24680C;
        }

        .modal-header, h4, .close {
            background-color: #5cb85c;
            color:white !important;
            text-align: center;
            font-size: 30px;
        }

        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
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
$userPhoneError = null;


if ( !empty($_POST)) {
    // keep track validation errors


    $activityID = $_POST['activityID'];
    $numberOfPeople = $_POST['spots'];
    $outfitterID = $_POST['outfitterID'];
    $startDate = $_POST['sDate'];
    $endDate = $_POST['eDate'];

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
        if(empty($password)) {
            $passwordError = 'Please enter Password';
            $valid = false;
        }

        if(empty($email)) {
            $emailError = 'Please enter Email Address';
            $valid = false;
        }



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
            <!--<div class="container">

            <div class="row row-custom">

                <div class="col-md-9">
                    <div class="page-header" style="border-bottom: 0px; margin-top:0px">
                        <h1 style="float: left; width:100%; margin-top:5px">
                            <p style="margin-bottom: 1px;">Activity Details
                            </p>
                            <small>
                            </small>
                        </h1>
                    </div>
                </div>
            </div>
            </div> -->
                <!-- Modal -->
                <div class="modal fade" id="pleaseWaitDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1>Processing...</h1>
                            </div>
                            <div class="modal-body">
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-success" style="width:1%"></div>

                                    <span class="sr-only">40% Complete (success)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <form id="informationForm" class="form-horizontal row-border" action="confirmation.php" method="post">


                    <div class="container-fluid">
                        <div class="container" style="">
                            <div class="row row-custom">
                                <div class="col-md-4">
                                    <div class="panel panel-default panel-success panel-success-custom" style="margin-top:20px">
                                            <div class="panel-body">
                                                <div class="row row-custom">
                                                    <div class="page-header" style="border-bottom: 0px; margin-top:0px">
                                                        <h3 style="float: left; width:100%; margin-top:5px">
                                                            <p class="text-center" style="margin-bottom: 5px;"> <?php echo $outfitter->name ?>
                                                            </p>
                                                            <p class="text-center"> <?php print_fa_icon("fa-star",.5,rand(1,5),"#24680C"); ?>
                                                            </p>
                                                            <small>
                                                                <?php
                                                                echo $outfitter->address . ", " . $outfitter->city . " <br> " . $outfitter->state . ", " . $outfitter->zip;

                                                                $phone = $outfitter->phone;
                                                                echo " <br> (".substr($phone, 0, 3).") ".substr($phone, 3, 3)."-".substr($phone,6);

                                                                ?>
                                                            </small>
                                                        </h3>
                                                    </div>
                                                </div>
                                                <div class="row row-custom">
                                                    <div class="text-center col-md-12"><a href="/Outfitters/viewOutfitter.php?id=<?php echo $outfitterID?>">Outfitter Details</a> </div>

                                                    <div class="row row-custom">
                                                        <div class="col-md-12 v-align text-center">

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
                                                            <a href="/Outfitters/viewOutfitter.php?id=<?php echo $outfitterID?>">
                                                                <img
                                                                    src="/upload/images/<?php echo $row['outfitter_id'] ?>/<?php echo $row['id'] . "." . $extension ?>"
                                                                    class="img-thumbnail img-responsive" style="margin: 10px;    max-height: 200px;"></a></div>
                                                        <?php
                                                        }
                                                        }

                                                        }
                                                        ?>

                                                    </div>
                                                    <br><br><br>

                                                </div>
                                                <div class="row row-custom">
                                                    <div class="col-md-6">Activity Start:</div>
                                                    <div class="col-md-6"><?$date = new DateTime($startDate); echo $date->format('D, M j, Y');?> </div>
                                                    <div class="col-md-6">Activity End:</div>
                                                    <div class="col-md-6"><?$date = new DateTime($endDate); echo $date->format('D, M j, Y');?> </div>
                                                </div>
                                                <hr style="border-top: 2px solid green; margin-right: 10px;  margin-left: 10px;">
                                                <div class="row row-custom">
                                                    <div class="col-md-6" id="lblPrice">Price (<?php echo $numberOfPeople?> people):</div>
                                                    <div class="col-md-6 text-right" id="lblPriceValue">$<?php echo $basePrice;?></div>
                                                </div>
                                                <div class="row row-custom">
                                                    <div class="col-md-6">Taxes:</div>
                                                    <div class="col-md-6 text-right" id="lblTaxesValue">$<?php echo round($taxesPrice,2); ?></div>
                                                </div>
                                                <br>
                                                <div class="row row-custom" style="border-top:3px solid #ccc">
                                                <div class="col-md-6" style="font-size: 20px;"><b>Total Due:</b></div>
                                                <div class="col-md-6 text-right" style="font-size: 33px;" id="lblTotalValue">$<?php echo round($subtotal,2); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                        <div class="panel panel-default panel-success panel-success-custom" style=" margin-top:20px">

                                            <div class="panel-body">
                                                <div class="row row-custom">
                                                    <div class="col-md-12">

                                                <div class="page-header" style="border-bottom: 0px; margin-top:0px">
                                                    <h3 style="float: left; width:100%; margin-top:2px;  margin-bottom:2px">
                                                        <p>Activity Details</p>
                                                        <small>
                                                        </small>
                                                    </h3>
                                                </div>

                                                        </div>
                                                    </div>
                                                <hr style="border-top: 2px solid green; margin: 5px 10px 25px 10px;">
                                                <div class="row row-custom">
                                                    <div class="col-md-12">
                                                        <?php echo $activity["Description"] ?>
                                                    </div>
                                                </div>

                                            </div>





                                        </div>
                                        <div class="panel panel-default panel-success panel-success-custom" style=" margin-top:20px">

                                            <div class="panel-body">
                                                <div class="row row-custom">
                                                    <div class="col-md-12">

                                                        <div class="page-header" style="border-bottom: 0px; margin-top:0px">
                                                            <h3 style="float: left; width:100%; margin-top:2px;  margin-bottom:2px">
                                                                <p>Amentities Included</p>
                                                                <small>
                                                                </small>
                                                            </h3>
                                                        </div>

                                                    </div>
                                                </div>
                                                <hr style="border-top: 2px solid green; margin: 5px 10px 25px 10px;">
                                                <div class="row row-custom">
                                                    <div class="col-md-12">


                                                        <div class="tab-pane" id="Amenities">
                                                            <div class="list-group">
                            <?php
                                                                if($activity["OverNight"]>0)
                                                                {
                            ?>
                                                                    <label class="list-group-item col-xs-6">Overnight stay included <?php print_fa_icon("fa-check",2,1,"#24680C");?></label>

                            <?php

                                                                }

                                                                if($activity["Guided"]="Yes")
                                                                {
                                                                    ?>
                                                                    <label class="list-group-item col-xs-6">Guided <?php print_fa_icon("fa-check",2,1,"#24680C");?></label>

                                                                    <?php
                                                                }

                                                                if($activity["Guided"]="Meals")
                                                                {
                                                                    ?>
                                                                    <label class="list-group-item col-xs-6">Meals <?php print_fa_icon("fa-check",2,1,"#24680C");?></label>

                                                                    <?php
                                                                }

                                                                ?>
                                                                <label class="list-group-item col-xs-6">Dog Included <?php print_fa_icon("fa-check",2,1,"#24680C");?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>





                                        </div>
                                        <div class="panel panel-default panel-  success panel-success-custom" style=" margin-top:20px">


                                            <input type="hidden" name="pageID" value="<?php echo $pageID?>">

                                            <input type="hidden" name="priceValue" id="priceValue" value="<?php echo $basePrice?>">
                                            <input type="hidden" name="taxesValue" id="taxesValue" value="<?php echo $taxesPrice?>">
                                            <input type="hidden" name="totalValue" id="totalValue" value="<?php echo $subtotal?>">

                                            <input type="hidden" name="pricePerPerson" id="pricePerPerson" value="<?php echo $activity["Price"]?>">
                                            <input type="hidden" name="taxes" id="taxes" value="<?php echo $taxes?>">
                                            <input type="hidden" name="outfitterID" id="outfitterID" value="<?php echo $outfitterID?>">
                                            <input type="hidden" name="activityID" id="activityID" value="<?php echo $activityID?>">
                                            <input type="hidden" name="startDate" id="startDate" value="<?php echo $startDate?>">
                                            <input type="hidden" name="endDate" id="endDate" value="<?php echo $endDate?>">
                                            <input type="hidden" name="spots" id="spots" value="<?php echo $numberOfPeople?>">


                                            <div class="panel-body">
                                                <div class="row row-custom">
                                                    <div class="col-md-12">

                                                        <div class="page-header" style="border-bottom: 0px; margin-top:0px">
                                                            <h3 style="float: left; width:100%; margin-top:2px;  margin-bottom:2px">
                                                                <p>Payment</p>
                                                                <small>
                                                                </small>
                                                            </h3>
                                                        </div>

                                                    </div>
                                                </div>
                                                <hr style="border-top: 2px solid green; margin: 5px 10px 25px 10px;">
                                                <div class="row row-custom">
                                                    <div class="col-md-12">

                                                        <div class="v-align text-center" >
                                                                <img class="img-responsive img-thumbnail " src="http://i76.imgup.net/accepted_c22e0.png">
                                                        </div>
                            <br>
                                                        <div class="form-group row">
                                                            <label class="col-md-3 control-label">Activity Name</label>
                                                            <div class="col-md-9 form-control-static"><?php echo $activity["Name"] ?></div>
                                                        </div>
                                                    <?php
                                                    echo FormElementCreate2('email','E-mail',$emailError,!empty($email)?$email:'',"email","required",3,9);
                                                    //echo FormElementCreate2('userPhone','userPhone',$userPhoneError,!empty($userPhone)?$userPhone:'',null,"required",3,9);

                                                    ?>
                                                        <div class="form-group row "><label class="col-md-3 control-label">Phone</label><div class="col-md-9"><input required="" name="userPhone" type="text" placeholder="Phone" value="" class="form-control"></div></div>

                                                        <div class="form-group row">
                                                            <label class="col-md-3 control-label">People</label>
                                                            <div class="col-md-3">
                                                                <select id="spotsSelected" name="spotsSelected" class="form-control">
                                                                    <?php $spotsChoices = explode("-",$activity["Spots"]);

                                                                    for ($i = $spotsChoices[0]; $i <= $spotsChoices[1]; $i++)
                                                                    {
                                                                        if($numberOfPeople == $i)
                                                                        {
                                                                            echo "<option selected>$i</option>";

                                                                        }
                                                                        else
                                                                        {
                                                                            echo "<option>$i</option>";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <br>



                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label" for="card_holder_name">Name on Card</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" required name="card_holder_name" id="card_holder_name" placeholder="Card Holder's Name">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label" for="card_number">Card Number</label>
                                                            <div class="col-sm-9">
                                                                <div class = "input-group ">
                                                                    <input type="text" class="form-control" required name="card_number" id="card_number" placeholder="Debit/Credit Card Number" >
                                                                    <span class = "input-group-addon"><i class="fa fa-credit-card"></i></span>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label" for="expiry_month">Expiration Date</label>
                                                            <div class="col-sm-9">
                                                                <div class="row">
                                                                    <div class="col-xs-3">
                                                                        <select required class="form-control col-xs-3" name="expiry_month" id="expiry_month">
                                                                            <option value="">Month</option>
                                                                            <option value="01">Jan (01)</option>
                                                                            <option value="02">Feb (02)</option>
                                                                            <option value="03">Mar (03)</option>
                                                                            <option value="04">Apr (04)</option>
                                                                            <option value="05">May (05)</option>
                                                                            <option value="06">June (06)</option>
                                                                            <option value="07">July (07)</option>
                                                                            <option value="08">Aug (08)</option>
                                                                            <option value="09">Sep (09)</option>
                                                                            <option value="10">Oct (10)</option>
                                                                            <option value="11">Nov (11)</option>
                                                                            <option value="12">Dec (12)</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-xs-4">
                                                                        <select required class="form-control col-xs-3" name="expiry_year" id="expiry_year">
                                                                            <option value="">Year</option>
                                                                            <option value="13">2013</option>
                                                                            <option value="14">2014</option>
                                                                            <option value="15">2015</option>
                                                                            <option value="16">2016</option>
                                                                            <option value="17">2017</option>
                                                                            <option value="18">2018</option>
                                                                            <option value="19">2019</option>
                                                                            <option value="20">2020</option>
                                                                            <option value="21">2021</option>
                                                                            <option value="22">2022</option>
                                                                            <option value="23">2023</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label" for="cvv">Card CVV</label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" required name="cvv" id="cvv" placeholder="Security Code">
                                                            </div>

                                                        </div>
                                                        <?php 			echo FormElementCreate2('zip','Billing Zip',$zipError,!empty($zip)?$zip:'',"text",null,3,4); ?>
                                                        <br>
                                                        <div class="form-group row">
                                                            <div class="col-xs-9 col-xs-offset-3">
                                                                <label class="checkbox-inline" style="color: black;"><input type="checkbox" id="agreement" name="agreement" value=""> Agree with all <a href="http://www.vrbo.com/info/termsandconditions.html" target="_blank">Terms and Conditions</a> and <a href="http://www.vrbo.com/info/privacy.html" target="_blank">Privacy Policy</a></label>
                                                             <div class="col-xs-9 col-xs-offset-1" id="agreementerror"></div>
                                                            </div>
                                                        </div>
                                                        <br>

                                                        <div class="form-group row">
                                                            <div class="col-md-2 col-md-offset-5">
                                                                <button type="submit" id="book" class="btn btn-success btn-success-custom btn-lg">Book</button>
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

</form>












            <?php } ?>
        </div>


<?php include($_SERVER['DOCUMENT_ROOT'] . "/include/bottom.php");?>