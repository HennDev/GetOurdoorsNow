<?php
	ini_set('display_errors', 1);

	session_start();
	$title = "View Outfitter";
	include($_SERVER['DOCUMENT_ROOT']."/database.php");
	include($_SERVER['DOCUMENT_ROOT']."/common.php");
	$error = "";
    $checkAvail = true;


/*//define the receiver of the email
$to = 'shennessy11@gmail.com';
//define the subject of the email
$subject = 'Test email';
//define the message to be sent.
$message = "Hello World!\r\nThis is my mail.";
//define the headers we want passed.
$header = "From: steven@getoutdoorsnow.com"; // must be a genuine address
//send the email
$mail_sent = mail($to, $subject, $message, $header);
//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed"

echo $mail_sent ? "Mail sent" : "Mail failed";
*/


	if(isset($_REQUEST['id']))
	{
		$id = $_REQUEST['id'];

		$outfitter = Outfitter::getSingleOutfitter($id);

		if(!isset($outfitter->name))
		{
			$error .=  " Outfitter $id does not exist";
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

        if(!empty($_POST))
        {
            $results = array(
                "startDate" => !empty($_POST['startDate'])?$_POST['startDate']:'',
                "endDate" => !empty($_POST['endDate'])?$_POST['endDate']:'',
                "people" => !empty($_POST['people'])?$_POST['people']:'',
                );
            extract($results);

            if($startDate!="" && $endDate!="")
            {
                $checkAvail = true;
            }
        }

	}
	else
	{
		$error = "Please enter an ID";
	}

	include($_SERVER['DOCUMENT_ROOT']."/include/top_start.php");
	// Any extra scripts go here
?>


	<link rel="stylesheet" href="/examples/woothemes-FlexSlider-9a419a0/flexslider.css" type="text/css"
		  xmlns="http://www.w3.org/1999/html">
	<script src="/examples/woothemes-FlexSlider-9a419a0/jquery.flexslider.js"></script>
    <script type="text/javascript" src="/js/jquery-validation-1.15.0/dist/jquery.validate.js"></script>

<script>
	// Can also be used with $(document).ready()
	var htmlForModal = "";
	
	$(document).ready(function() {
        jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
            phone_number = phone_number.replace(/\s+/g, "");
            return this.optional(element) || phone_number.length > 9 &&
                phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
        }, "Please specify a valid phone number");


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
                if(element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });



        //jquery for mouse spinner
        var action;
        $(".number-spinner button").mousedown(function () {
            btn = $(this);
            input = btn.closest('.number-spinner').find('input');
            btn.closest('.number-spinner').find('button').prop("disabled", false);

            if (btn.attr('data-dir') == 'up') {
                action = setInterval(function(){
                    if ( input.attr('max') == undefined || parseInt(input.val()) < parseInt(input.attr('max')) ) {
                        input.val(parseInt(input.val())+1);
                    }else{
                        btn.prop("disabled", true);
                        clearInterval(action);
                    }
                }, 50);
            } else {
                action = setInterval(function(){
                    if ( input.attr('min') == undefined || parseInt(input.val()) > parseInt(input.attr('min')) ) {
                        input.val(parseInt(input.val())-1);
                    }else{
                        btn.prop("disabled", true);
                        clearInterval(action);
                    }
                }, 50);
            }
        }).mouseup(function(){
            clearInterval(action);
        });


		$('.flexslider').flexslider({
			animation: "slide"

		});

		$(function() {
			$( "#tabs" ).tabs();
		});

        //adjust slide image to half the heigh
		$('.slides li').each( function() {
			var height = $(this).height();
			var imageHeight = $(this).find('img').height();
			if(height < 350 ) {
				var offset = (height - imageHeight) / 2;

				$(this).find('img').css('margin-top', offset + 'px');
			}
		});


        $( "#modalDate" ).datepicker({
            minDate: 'today',
            maxDate: "+90D"
        });





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


        //changes active jquery tab based on click
        $('.jump-to-target').click(function (event) {
            $('#tabs').tabs("option", "active", $(this).data("tab-index"));
            console.log($(this).html());
            activaTab($(this).html());
        });


        $('#availActivitiesJump').click(function (event) {
            event.preventDefault();
            $('#availActivities').goTo();
        });

        (function($) {
            $.fn.goTo = function() {
                $('html, body').animate({
                    scrollTop: $(this).offset().top-20 + 'px'
                }, 'fast');
                return this; // for chaining...
            }
        })(jQuery);

		$(".viewActivity").click(function (event) 
		{
			event.preventDefault();
			var id = $(this).attr('id');
			var appendVal = "";
			
			//resetMpdal
			$("#cartMsg").show();
			$("#cartSuccess").hide();
			$("#cartSpinner").empty();
			
			//Populate Modal
            $.ajax({
                url: "/Ajax/allOutfitters.php",
                type: "get", //send it through get method
                data:{id:id},
                success: function (data) {
                    $("#activityID").val(id);
                    $.each(data, function(key, val)
                    {
                        var curElement = $('#'+key.toLowerCase());

                        if(key=="Spots")
                        {
                            curElement.empty();
                            var splitSpots = val.split("-");

                            for (i = splitSpots[0]; i <= splitSpots[1]; i++)
                            {
                                $('<option>').val(i).text(i).appendTo('#'+key.toLowerCase());
                            }
                        }
                        else
                        {
                            curElement.html(val);
                        }
                    });
                    $("#myModal").modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                },
                error: function(ts) { alert(ts.responseText) }
            });

			});


        $("#closeModal").click(function(event) {
            $('#contactOutfitterForm')[0].reset()
            $("#mailSuccess").hide();
            $("#submitDiv").show();
        });

        //Contact Outfitter Actions
        $("#sendEmail").click(function (event)
        {



            $("#contactOutfitterForm").validate({
                rules: {
                    firstName: "required",
                    lastName: "required",
                    username: {
                        required: true,
                        minlength: 2
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phone: {
                        required: true,
                        phoneUS: true
                    }
                },
                messages: {
                    firstName: "Please enter your first name",
                    lastName: "Please enter your last name",
                    email: "Please enter a valid email address",
                    phone: "Please enter a phone number"
                },
                submitHandler: function(form) {
                    event.preventDefault();
                    $("#submitDiv").hide();
                    $.ajax({
                        type: "POST",
                        url: "/Ajax/contactOutfitter.php",
                        data: $("#contactOutfitterForm").serialize(), // serializes the form's elements.
                        cache: false,
                        beforeSend: function(){ $("#mailLoading").show();},
                        success: function(data){
                            $("#mailLoading").hide();

                            //alert(data);

                            if(data=="1")
                            {
                                $("#mailSuccess").show();
                            }
                            else
                            {
                                $("#mailError").show();
                                $("#submitDiv").show();
                            }
                        },
                        error: function() {
                            $("#mailError").show();
                            $("#mailLoading").hide();
                            $("#submitDiv").show();
                        }
                    });
                }
            });
        });

        $("#contactOutfitterModalLink").click(function (event)
        {
            event.preventDefault();
            $("#contactOutfitterModal").modal({
                keyboard: false
            });

        });




	});

    //changes active jquery tab
    function activaTab(tab){
        $('.nav-tabs a[href="#' + tab + '"]').tab('show');
    };

</script>
	<style>

    body
    {
        padding-top: 70px !important;
        background-color: white !important;
    }

	.whitePageBackground{
		background: white;
		margin-bottom: 50px;
	}

	.flex-caption {
		width: 96%;
		padding: 2%;
		left: 0;
		bottom: 0;
		background: rgba(0,0,0,.5);
		color: #fff;
		text-shadow: 0 -1px 0 rgba(0,0,0,.3);
		font-size: 14px;
		line-height: 18px;

	}
	.flexslider .slides img {
		width: auto;
		max-height: 450px;
		margin: 0 auto;
		max-width: 700px;
	}
		.flexslider{
			height:516px;
		}

	.tab-content>.tab-pane{
		margin:30px;
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

    .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
        background-color: #dbdde2;
    }


    .modal-header-green,  .modal-header-green h4, .close {
        background-color: #5cb85c;
        color:white !important;
        text-align: center;
        font-size: 30px;
    }

    #contactOutfitterModal .modal-header {
        background-color: white !important;
        color:white !important;
        text-align: center;
        font-size: 30px;
    }
    .modal-footer {
        background-color: #f9f9f9;
    }
	</style>



<?php
    include($_SERVER['DOCUMENT_ROOT']."/include/top_end.php");

?>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <form class="form-horizontal row-border" id="modalActivityForm" action="/Outfitters/Booking/index.php" method="post">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header-green" style="padding:15px 50px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4>Activity Details</h4>
                </div>
                <div class="modal-body" style="">
                    <input type=hidden id="activityID" name="activityID">
                    <input type=hidden id="activityID" name="outfitterID" value="<?php echo $id?>">


                    <input type=hidden id="sDate" name="sDate" value="03/31/2016">
                    <input type=hidden id="eDate" name="eDate" value="04/01/2016">


                    <div class="form-group" style="border-bottom:1px solid #ddd;  padding-bottom:20px">
                            <label class="col-md-5 control-label">Description</label>
                            <div class="col-md-7">
                                <p id="description" name="description" class="form-control-static"></p>
                            </div>
                        </div>
                        <div class="form-group" style="border-bottom:1px solid #ddd;  padding-bottom:20px">
                            <label class="col-md-5 control-label">Animals</label>
                            <div class="col-md-7">
                                <p id="animals" name="animals" class="form-control-static"></p>
                            </div>
                        </div>
                        <div class="form-group " style="border-bottom:1px solid #ddd;  padding-bottom:20px">
                            <label class="col-md-5 control-label">Nights</label>
                            <div class="col-md-4">
                                <p id="overnight" name="overnight" class="form-control-static"></p>
                            </div>
                        </div>
                        <div class="form-group " style="border-bottom:1px solid #ddd;  padding-bottom:20px">
                            <label class="col-md-5 control-label">Guided</label>
                            <div class="col-md-4">
                                <p id="guided" name="guided" class="form-control-static"></p>
                            </div>
                        </div>
                        <div class="form-group " style="border-bottom:1px solid #ddd;  padding-bottom:20px">
                            <label class="col-md-5 control-label">Price per person</label>
                            <div class="col-md-4">
                                <p id="price" name="price" class="form-control-static"></p>
                            </div>
                        </div>
					<div class="form-group ">
						<label class="col-md-5 control-label">People</label>
							<div class="col-md-7">
								<select class="form-control" id="spots" name="spots">
								</select>
							</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="container-fluid">
						<div class="row" style="display: none;" id="cartSuccess">
							 <div class="col-md-3">
						<button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal">
							<span class="glyphicon glyphicon-remove"></span> 
							Close
						</button>
					</div>
					<div class="col-md-6 text-center" id="successMsg">
													<div class="alert alert-success" style="margin-bottom:0px"> Item added to cart.</div>

					</div>
					<div class="col-md-3">
						<button id="goToCart" type="submit" class="btn btn-success btn-default">
							<span class="fa fa-shopping-cart fa-lg"></span>
							Go to Cart
						</button>
					</div>
						
						
							 </div>
						<div class="row"  id="cartMsg">
							
						
					<div class="col-md-3">
						<button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal">
							<span class="glyphicon glyphicon-remove"></span> 
							Cancel
						</button>
					</div>
					<div class="col-md-6 text-center" id="cartSpinner">
					</div>
					<div class="col-md-3">
						<button id="addToCart" type="submit" class="btn btn-success btn-default">
							<span class="glyphicon glyphicon-ok"></span>
							Book Now
						</button>
					</div>
							</div>
					</div>
				</div>
			</div>
		</form>
	</div>
    </div>


    <!--Login Modal Start-->
    <div class="modal fade " id="contactOutfitterModal" role="dialog">
        <div id="login-overlay" class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" align="center">
                    <div class="row">
                        <div class="col-xs-12">
                    <img class="hidden-sm hidden-xs" id="img_logo" src="/img/logos/Full%20Color/JPG/getoutdoors_150px.jpg" height="350px" width="auto" ">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span style="color: #24680C;"  class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </button>
                            </div>
                        </div>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="panel panel-default panel-success panel-success-custom .small-Panel">
                                <div class="panel-heading clearfix text-center">
                                    <h3 class="panel-title">Contact <?php echo $outfitter->name?></h3>
                                </div>
                                <div class="panel-body">
                                    <form class="form-horizontal row-border" id="contactOutfitterForm" action="" method="post">
                                       <div class="form-group row ">
                                            <label class="col-md-3 control-label">First Name</label>
                                            <div class="col-md-7">
                                                <input required="" name="firstName" type="text" placeholder="First Name" value="" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <label class="col-md-3 control-label">Last Name</label>
                                            <div class="col-md-7">
                                                <input required="" name="lastName" id="lastName" type="text" placeholder="Last Name" value="" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <label class="col-md-3 control-label">E-mail</label>
                                            <div class="col-md-7">
                                                <input required="" name="email" type="email" placeholder="E-mail" value="" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group row ">
                                            <label class="col-md-3 control-label">Phone</label>
                                            <div class="col-md-7">
                                                <input name="phone" type="text" placeholder="Phone" value="" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="form-group row has-feedback">
                                            <label class="col-md-3 control-label">Start Date:</label>
                                            <div class="col-md-7">
                                                <input type="text" class="dates form-control" placeholder="" id="modalDate" name="modalDate" value=""/>
                                                <i class="glyphicon glyphicon-calendar form-control-feedback"></i>
                                            </div>
                                        </div>


                                        <div class="form-group row ">
                                            <label class="col-md-3 control-label">Comment</label>
                                            <div class="col-md-7">
                                                <textarea class="form-control" rows="6" id="comment" name="comment"></textarea>
                                            </div>
                                        </div>

                                        <div id="mailLoading" class="col-md-4 col-md-offset-4 text-center"  style="display: none;">
                                            <i id="loadingMsg" class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
                                            <br>
                                            <br>
                                        </div>

                                        <div id="mailSuccess" class="alert alert-info col-md-4 col-md-offset-4 text-center" style="display: none;">
                                            <i id="loadingMsg" class="fa fa-check "></i>
                                            Email was sent successfully
                                            <br><br>
                                            <button type="submit" id="closeModal" data-dismiss="modal" class="btn btn-large btn-primary">close popup</button>
                                        </div>

                                        <div id="mailError" class="alert alert-danger col-md-4 col-md-offset-4 text-center" style="display: none;">
                                            <i id="loadingMsg" class="fa fa-check "></i>
                                            An error has occurred, please try again
                                        </div>

                                        <div id="submitDiv" class="col-md-4 col-md-offset-4 text-center" >
                                                <button type="submit" id="sendEmail" class="btn btn-large btn-success btn-success-custom">send</button>
                                        </div>

                                        <input name="outfitterID" type="hidden" placeholder="First Name" value="<?php echo $outfitter->id?>" class="form-control">
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div></div>
    <!--Login Modal End-->

 <div class="container">
	<div class="whitePageBackground">
<?php
	if($error!="")
	{
		echo $error;
	}
	else
{
?>

        <div class="row row-custom">

            <div class="col-md-9">
                <div class="page-header" style="border-bottom: 0px; margin-top:0px">
                    <h1 style="float: left; width:100%; margin-top:5px">
                        <p style="margin-bottom: 1px;"> <?php
                            echo $outfitter->name . "&nbsp;&nbsp;";
                            print_fa_icon("fa-star", .5, rand(1, 5), "#24680C"); ?>
                        </p>
                        <small>
                            <?php
                            echo $outfitter->address . ", " . $outfitter->city . ", " . $outfitter->state . ", " . $outfitter->zip." ";

                            $phone = $outfitter->phone;
                            if(strpos($phone, "-") == false)
                            {
                                $phone = "(".substr($phone, 0, 3).") ".substr($phone, 3, 3)."-".substr($phone,6);
                            }
                            else
                            {
                                $phoneSplit = explode("-",$phone);
                                $phone = "(".$phoneSplit[0].") ".$phoneSplit[1]."-".$phoneSplit[2];
                            }
                            echo $phone;
                            ?>
                        </small>
                    </h1>
                </div>
                <br><br>
                <br><br>
            </div>
            <div class="col-md-3">

                    <!--<div class="page-header" style="border-bottom: 0px; margin-top:0px"><h2 style="float: left; width:100%;">
                        <span  style="margin:0 auto;
 " class="label label-default pull-right">
								<?php /*echo $outfitterTypeFormatted;	*/?>
							</span>
                    </h2>                </div>
-->

                    <h4>
                        <span  class="">
                            <a style="margin-left: 10px" class="btn btn-primary btn-lg outfitterResult" id="contactOutfitterModalLink">Contact Outfitter</a>
                       </span>

                    </h4>

                    </span>
            </div>
        </div>
        <div class="row row-custom">
            <div class="col-lg-12">
                <div class="jump-navigation">
                    <span>Jump to:</span>
                    <ul class="list-inline">
                        <li><a class="jump-to-target" data-jump-target="#panel-info2" href="#panel-info2">Overview</a></li>
                        |
                        <li><a class="jump-to-target" data-jump-target="#panel-info2" href="#panel-info2">Animals</a></li>
                        |
                        <li><a class="jump-to-target" data-jump-target="#panel-info2" href="#panel-info2">Amenities</a></li>
                    </ul>
                </div>
            </div>
        </div>

                <hr style="border-top: 2px solid green;
    margin-right: 10px;
    margin-left: 10px;">

				<!--<hr style="width: 100%; color: #5cb85c; height: 2px; background-color:#5cb85c;" />-->
				<!--Images-->
				<div class="row row-custom">
					<div class="col-lg-8 c-wrapper">

                        <div class="page-header page-header-custom">
                            <h3>
                                About this location
                            </h3>
                            <p>
<?php
                                echo $outfitter->descrShort;
?>                          </p>
                        </div>
<?php
						$outfitterID = $id;
						$directory = $_SERVER['DOCUMENT_ROOT'].'/upload/images/'.$outfitterID.'/';
						$files = glob($directory. '/*');

						$instance = new Image;
						$images = $instance->getAllOutfitterImages($outfitterID);



						if ( $files !== false && count($images)>0 )
						{
							$first = true;
							?>

						<div class="flexslider">
							<ul class="slides" style="    background-color: #DBDDE2;">

							<?php
							foreach ($images as $row)
							{
								$extension = $row['type'];
								?>

								<li>
									<img src="/upload/images/<?php echo $row['outfitter_id'] ?>/<?php echo $row['id'].".".$extension?>" />
									<p class="flex-caption"><?php echo $row['description'] ?></p>
								</li>

								<?php

							}
							?>

							</ul>
						</div>
<!---->
<!--							<div id="myCarousel" class="carousel slide" data-ride="carousel">-->
<!--								<!-- Indicators -->
<!--								<ol class="carousel-indicators">-->
<!--									<li data-target="#myCarousel" data-slide-to="0" class="active"></li>-->
<!--									<li data-target="#myCarousel" data-slide-to="1"></li>-->
<!--									<li data-target="#myCarousel" data-slide-to="2"></li>-->
<!--									<li data-target="#myCarousel" data-slide-to="3"></li>-->
<!--								</ol>-->
<!---->
<!--								<!-- Wrapper for slides -->
<!--								<div class="carousel-inner" role="listbox">-->
<!---->
<!---->
<!--									--><?php
//									foreach ($images as $row)
//									{
//										$extension = $row['type'];
//										?>
<!--										<div class="item --><?php //if ($first) echo 'active' ?><!--">'-->
<!---->
<!--											--><?php
//											//echo print_r(explode('/',$image),true);
//											?>
<!--											<img style= "height:auto; width: auto;max-height: 300px;"  src="/upload/images/--><?php //echo $row['outfitter_id'] ?><!--/--><?php //echo $row['id'].".".$extension?><!--" /><br />-->
<!--											--><?php
//
//											$first = false;
//											?>
<!--											<div class="carousel-caption">-->
<!--												<h3>--><?php //echo $row['description'] ?><!--</h3>-->
<!--											</div>-->
<!--										</div>-->
<!--										--><?php
//
//									}
//									?>
<!--								</div>-->
<!---->
<!--								<!-- Left and right controls -->
<!--								<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">-->
<!--									<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>-->
<!--									<span class="sr-only">Previous</span>-->
<!--								</a>-->
<!--								<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">-->
<!--									<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>-->
<!--									<span class="sr-only">Next</span>-->
<!--								</a>-->
<!--							</div>-->

<?php
						}
						else
						{
							echo "No Images";
						}
?>


					</div>
					<div class="col-lg-4">
						<div class="panel panel-default panel-success panel-success-custom .small-Panel">
							<div class="panel-heading clearfix text-center">
								<i class="icon-calendar"></i>
								<h3 class="panel-title">Check Availability</h3>
							</div>
							<div class="panel-body">

								<form action="" method="post" role="form">
									<div class="form-group has-feedback">
									<label class="control-label">Start Date:</label>
                                    <input hidden id="availabilityID" value="<?php echo $id?>">
									<input type="text" class="dates form-control" placeholder="" id="startDate" name="startDate" value="<?php if(isset($startDate)) {echo $startDate;} ?>"/>
									<i class="glyphicon glyphicon-calendar form-control-feedback"></i>
								</div>
								<br>
								<br>
									<div class="form-group has-feedback">
									<label class="control-label">End Date:</label>
									<input type="text" class="dates form-control" placeholder="" id="endDate" name="endDate" value="<?php if(isset($startDate)) {echo $endDate;} ?>"/>
									<i class="glyphicon glyphicon-calendar form-control-feedback"></i>
								</div>
                                <br>
                                <br>
                                <div class="form-group">
                                    <label class="control-label">Number of People:</label>
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
								<button type="submit" class="btn btn-success btn-success-custom center-block">Search</button>
								</form>
							</div>
						</div>

						<div>
							<br>
							<iframe frameborder="0" style="height:350px; width: 100%; ;border:0" src="https://www.google.com/maps/embed/v1/place?q=<?php echo $mapAddress?>&key=AIzaSyDZ6xoudqhcPl7MnRpaUvyZM-pN78gphjg"></iframe>
						<br>
					</div>
				</div>
				<!--<hr style="width: 100%; color: #5cb85c; height: 2px; background-color:#5cb85c;" />-->
                </div>

        </div>
        </div>

<?php
    if($checkAvail)
    {
    ?>
        <div id ="availActivities"></div>

        <div  class="container-fluid" style="background-color:rgb(219, 221, 226); margin: 30px 0 30px 0; ">
       <div class="container">
            <div class="row row-custom">
                <div class="panel panel-default panel-success panel-success-custom" style="margin-top:20px">
                    <div class="panel-heading clearfix text-center">
                        <i class="icon-calendar"></i>
                        <h3 class="panel-title">Available Activities</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive" style="clear:both">
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Animals</th>
                                    <th>Available Spots</th>
                                    <th>Night(s)</th>
                                    <th>Guided</th>
                                    <th>Meals Included</th>
                                    <th>Price per person</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
<?php
                                $activities = getAllOutfitterActivities(true);

                                foreach($activities as $key => $values)
                                {
?>
                                    <form action="/Outfitters/Booking/?outfitterId=<?php echo $id?>&activityId=<?php echo $key?>" method="post" role="form">
                                <tr>
<?php

                                    foreach($values as $key2 => $value)
                                    {
                                        if($key2!="Description" && $key2!="Amenities")
                                        {
                                            ?>

                                    <td>
<?php
                                      echo $value;
?>
                                      </td>
<?php                                   }
                                    }
?>
                                    <td class="text-center">
                                        <input class="btn btn-xl btn-primary viewActivity" type="submit" id="<?php echo $key?>" name="btnView" value="View">
                                    </td>
                                </tr>
                                        </form>


                                    <?php
                                }
?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>





            </div>
       </div>
    </div>
<?php
}
?>

    <div class="container">
        <div class="whitePageBackground">
                <div class="row row-custom">

                    <?php
                    if(!$checkAvail)
                    {
                        ?>
                        <hr style="border-top: 2px solid green; margin-right: 10px; margin-left: 10px;">
                        <?php
                    }
                    ?>



				    <div class="col-md-10 col-md-offset-1 col-sm-6 col-xs-12">
                        <div id="panel-info2"></div>
                        <div class="panel panel-success panel-success-custom" id="panel-info">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="active"><a href="#Overview" role="tab" data-toggle="tab">Overview</a></li>
                                <li><a href="#Animals" role="tab" data-toggle="tab">Animals</a></li>
                                <li><a href="#Amenities" role="tab" data-toggle="tab">Amenities</a></li>
                            </ul>
                            <div class="panel-body">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane active" id="Overview">
                                        <?php

                                        echo $outfitter->description;

                                        ?>
                                    </div>
                                    <div class="tab-pane" id="Animals">
                                        <div class="list-group">
                                            <?php
                                            if(is_array($outfitterAnimals) && count($outfitterAnimals)>0)
                                            {	foreach ($outfitterAnimals as $outfitterAnimal)
                                            {
                                                ?>
                                                <label class="list-group-item">
                                                    <?php
                                                    echo $outfitterAnimal["animal"];//.$outfitterAnimal["animals_id"] ." ". $outfitterAnimal["relationship_id"];
                                                    ?>
                                                </label>
                                                <?php
                                            }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="Amenities">
                                        <div class="list-group">

                                            <label class="list-group-item">Free Wi-Fi <span class="glyphicon glyphicon-ok"></span></label>
                                            <label class="list-group-item">ATM on-site <span class="glyphicon glyphicon-ok"></span></label>
                                            <label class="list-group-item">Business center <span class="glyphicon glyphicon-ok"></span></label>
                                            <label class="list-group-item">Gift shop <span class="glyphicon glyphicon-ok"></span></label>
                                            <label class="list-group-item">Laundry service <span class="glyphicon glyphicon-ok"></span></label>
                                            <label class="list-group-item">Meeting/Banquet facilities <span class="glyphicon glyphicon-ok"></span></label>
                                            <label class="list-group-item">24 hour front desk <span class="glyphicon glyphicon-ok"></span></label>
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



	</div>

</div>


<?php include($_SERVER['DOCUMENT_ROOT']."/include/bottom.php");?>