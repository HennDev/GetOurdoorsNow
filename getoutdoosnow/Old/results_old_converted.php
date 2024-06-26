<?php

ini_set('display_errors', 1);

session_start();
$title = "View Outfitter";
include($_SERVER['DOCUMENT_ROOT'] . "/database.php");
include($_SERVER['DOCUMENT_ROOT'] . "/common.php");



if ($_SERVER['REQUEST_METHOD'] === 'POST')
{	//something posted

    if (isset($_POST['btnHunt']))
    {
        $expeditionType = "Hunt";
    }
    else if (isset($_POST['btnFish']))
    {
        $expeditionType = "Fish";
    }
    else if (isset($_POST['btnHuntFish']))
    {
        $expeditionType = "HuntFish";
    }
    else if (isset($_POST['btnActivity']))
    {
        $expeditionType = "Activity";
    }

    if (isset($_POST["option".$expeditionType]))
    {
        foreach ($_POST["option".$expeditionType] as $selectedOption)
        {
            echo $selectedOption."\n";
        }
    }

    $location = $_POST["location".$expeditionType];
    $sdate = $_POST["sDate".$expeditionType];
    $edate = $_POST["eDate".$expeditionType];
    $state = $_POST["State".$expeditionType];
    $region = $_POST["Region".$expeditionType];
    $Outfitter = $_POST["Outfitter".$expeditionType];



    echo " expeditionType ".$expeditionType." location: ". $location ." sdate ". $sdate ." edate ". $edate ." State ". $state." Region ". $Outfitter;

}
$array = array();

$inArray["ZipCode"] = "78260";
$inArray["Animals"] = array("Elk","Deer","Geese");
$inArray["Type"] = "Hunt";
$array["John's Outfitters"] = $inArray;

$inArray["ZipCode"] = "77581";
$inArray["Animals"] = array("Quail","Pheasant","Duck");
$inArray["Type"] = "Hunt";
$array["Extreme Hunting"] = $inArray;

$inArray["ZipCode"] = "77008";
$inArray["Animals"] = array("Marlin","Bass","Snapper");
$inArray["Type"] = "Fish";
$array["Galveston Fishing"] = $inArray;

$inArray["ZipCode"] = "75214";
$inArray["Animals"] = array("Marlin","Anglerfish","Dolphin");
$inArray["Type"] = "Fish";
$array["Deep Sea Fishing"] = $inArray;

$inArray["ZipCode"] = "77008";
$inArray["Animals"] = array("Marlin","Bass","Snapper");
$inArray["Type"] = "Fish";
$array["Galveston Deep Sea"] = $inArray;

$inArray["ZipCode"] = "75214";
$inArray["Animals"] = array("Marlin","Anglerfish","Dolphin");
$inArray["Type"] = "Fish";
$array["Fishing Expeditions"] = $inArray;


$animals = array("Elk","Deer","Geese","Quail","Pheasant","Duck","Marlin","Bass","Snapper","Marlin","Anglerfish","Dolphin");

if(!empty($_POST["Animal"]))
{
    $string = str_replace('&nbsp;',"", $_POST["testing"]);
    $string = preg_replace("/\s|&nbsp;/",'',$string);
    $animal = explode(",",$string);
}
else
{
    $animal = array();
}
$singleOrMulti = $_POST["singleOrMulti"];

include($_SERVER['DOCUMENT_ROOT'] . "/include/top_start.php");

?>

<script>


    $(function() {
        $( "#sDate1" ).datepicker();
        $( "#eDate1" ).datepicker();
        $( "#sDate2" ).datepicker();
        $( "#eDate2" ).datepicker();
        $( "#sDate3" ).datepicker();
        $( "#eDate3" ).datepicker();
        $( "#sDate4" ).datepicker();
        $( "#eDate4" ).datepicker();
        $('.expand-one').click(function(){
            $('.content-one').slideToggle('slow');
        });

        $(function() {
            $( "#tabs" ).tabs();
        });

        $(function() {
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



        });

        $('#Animal').multipleSelect();

        $( "#index" ).submit(function( event ) {
            var array = $('#Animal').multipleSelect('getSelects', 'text');
            //array = array.replace("&nbsp;","");
            $('input[name="testing"]').val(array);


        });


    });

    $( document ).ready(function() {
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

        $('#StateHunt').change(function(){
            populateSelect("Region");
        });

        $('#RegionHunt').change(function(){
            populateSelect();
        });

    });

    var arrex = new Array();
    arrex['TX'] = Array('Big Bend Country-BBC','Gulf Coast-GC','Hill Country-HC','Panhandle Plains-PP','Pineywoods-PW','Prairies and Lakes-PL','South Texas Plains-STP');
    arrex['CO'] = Array('Northwest-NW','North Central-NC','Northeast-NE','Metro Area-MA','Pikes Peak-PP','West Central-WC','Southwest-SW','Southeast-SE');



    var arrex2 = new Array();
    arrex2['BBC'] = Array('Big Bend Hunting-BBH','Davis Family-DF','Two Brothers Outfitter-TB');
    arrex2['GC'] = Array('Gulf Coast Hunt-GCH','John Doe Hunting-JDH','Three Brothers Outfitter-TB');
    arrex2['HC'] = Array('Big Bend Hunting-BBH','Davis Family-DF','Two Brothers Outfitter-TB');
    arrex2['PP'] = Array('Gulf Coast Hunt-GCH','John Doe Hunting-JDH','Three Brothers Outfitter-TB');

    arrex2['NW'] = Array('Big Bend Hunting-BBH','Davis Family-DF','Two Brothers Outfitter-TB');
    arrex2['NC'] = Array('Gulf Coast Hunt-GCH','John Doe Hunting-JDH','Three Brothers Outfitter-TB');
    arrex2['NE'] = Array('Big Bend Hunting-BBH','Davis Family-DF','Two Brothers Outfitter-TB');
    arrex2['MA'] = Array('Gulf Coast Hunt-GCH','John Doe Hunting-JDH','Three Brothers Outfitter-TB');

    function populateSelect(kind)
    {
        if (kind == "Region")
        {
            var cat=$('#StateHunt').val();
            $('#RegionHunt').html('');
            $('#RegionHunt').append('<option value="" selected>Select a Region</option>');
            for(var key in arrex[cat])
            {
                var mySplitResult = arrex[cat][key].split("-");
                $('#RegionHunt').append('<option value='+mySplitResult[1]+'>'+mySplitResult[0]+'</option>');
            }
        }
        else
        {
            var cat=$('#RegionHunt').val();
            $('#OutfitterHunt').html('');

            if(typeof arrex2[cat] !== 'undefined')
            {
                $('#OutfitterHunt').append('<option value="" selected>Select an Outfitter</option>');
                for(var key in arrex2[cat])
                {
                    var mySplitResult = arrex2[cat][key].split("-");
                    $('#OutfitterHunt').append('<option value='+mySplitResult[1]+'>'+mySplitResult[0]+'</option>');
                }
            }
            else
            {
                $('#OutfitterHunt').append('<option value="" disabled selected>No Outfitters found</option>');

            }
        }
    }



</script>

<style>
    p.content-one
    {
        margin: 0 0 0 0 !important;
        text-indent: 10px;
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
</style>


</head>



<?php
include($_SERVER['DOCUMENT_ROOT'] . "/include/top_end.php");

?>

<div id="content">
    <div id="inside-content">
        <br/>
        <form id="index" action="../index.php" method="post">
            <h3>Book your trip:</h3>
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Hunting</a></li>
                    <li><a href="#tabs-2">Fishing</a></li>
                    <li><a href="#tabs-3">Hunting + Fishing</a></li>
                    <li><a href="#tabs-4">Activities</a></li>
                </ul>
                <div id="tabs-1">
                    <input type="radio" name="singleOrMultiHunt" value="Single" <?php if($singleOrMulti == "Single") echo "checked";?>> Single day&nbsp;
                    <input type="radio" name="singleOrMultiHunt" value="Mutli" <?php if($singleOrMulti == "Mutli") echo "checked";?>> Multi-day
                    <br>
                    <div id="criteria">
                        <!-- ><input type="text" id="location" placeholder="Where do you want to go?" name="locationHunt" value="<?php echo $location; ?>">- -->
                        <div class="datesLocation">
                            <div class="locations">
                                State:
                                <select id="StateHunt">
                                    <option value="" disabled selected>Select a State</option>
                                    <option value="CO">Colorado</option>
                                    <option value="TX">Texas</option>
                                </select>
                                <br>
                                <br>
                                Region:
                                <select id="RegionHunt">
                                    <option value="" disabled selected>Select a Region</option>
                                </select>
                                <br>
                                <br>
                                Outfitter:
                                <select id="OutfitterHunt">
                                    <option value="" disabled selected>Select an Outfitter</option>
                                </select>
                            </div>
                            <div class="dates">
                                Start Date: <input type="text" class="dates" placeholder="" id="sDate1" name="sDateHunt" value="<?php echo $sdate; ?>">
                                <br>
                                End Date: <input type="text" placeholder="" id="eDate1" name="eDateHunt" value="<?php echo $edate; ?>">
                            </div>
                        </div>

                        <div class="SearchButtonDiv">
                            <input class='SearchButton' type="submit" name="btnHunt" value="Get Outdoors Now">
                        </div>
                        <br/>
                        <br/>
                        <br/>
                        <div id="accordionHunt">
                            <h3>Advanced Options</h3>
                            <div>
                                <p>What do you want do hunt?</p>
                                <select id="tokenizeHunt" multiple="multiple" name="optionHunt[]" class="tokenize-sample">
                                    <option value="" selected disabled>Please select</option>
                                    <?php
                                    foreach ($huntanimals as $animal)
                                    {
                                        ?>													<option value="<?php echo $animal?>"><?php echo $animal?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <br>
                                <br>
                                Adults:
                                <select id="AdultsHunt">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="3">6</option>
                                    <option value="4">7</option>
                                    <option value="5">8</option>
                                </select>

                                <br>
                            </div>
                        </div>
                        <br>
                        <br>

                        <div id="alert"></div>
                        <div id="map" style="width: 600px; height: 400px;"></div>
                    </div>
                </div>

                <div id="tabs-2">
                    <input type="radio" name="singleOrMulti" value="Single" <?php if($singleOrMulti == "Single") echo "checked";?>> Single day&nbsp;
                    <input type="radio" name="singleOrMulti" value="Mutli" <?php if($singleOrMulti == "Mutli") echo "checked";?>> Multi-day
                    <br>
                    <br>
                    <div id="criteria">
                        <input type="text" id="location" placeholder="Where do you want to go?" name="location" value="<?php echo $location; ?>">
                        <input type="text" class="dates" placeholder="Start Date" id="sDate2" name="sDate" value="<?php echo $sdate; ?>">
                        <input type="text" placeholder="End Date" id="eDate2" name="eDate" value="<?php echo $edate; ?>">
                        <br/>
                        <br/>
                        <p>What do you want do fish?</p>
                        <br/>
                        <select id="tokenize2" multiple="multiple" placeholder="Where do you want to fish?" class="tokenize-sample">
                            <option value="" selected disabled>Please select</option>
                            <option value="1">Salmon</option>
                            <option value="2">Tuna</option>
                            <option value="3">Tilapia</option>
                            <option value="4">Quail</option>
                            <option value="5">Pollock</option>
                            <option value="6">Cod</option>
                            <option value="7">Catfish</option>
                            <option value="8">Striped Bass</option>
                            <option value="9">Bluefish</option>
                            <option value="10">Scup</option>
                            <option value="11">Weakfish</option>
                        </select>
                        <br/>
                        <br/>

                        Search Radius :&nbsp;&nbsp;
                        <select id="Radius" name="Radius">
                            <option value="5" <?php if($radius == "5") echo "selected";?>> 5</option>
                            <option value="20" <?php if($radius == "20") echo "selected";?>> 20</option>
                            <option value="150" <?php if($radius == "150") echo "selected";?>> 150</option>
                            <option value="300" <?php if($radius == "30") echo "selected";?>> 300</option>
                            <option value="1000" <?php if($radius == "1000") echo "selected";?>> 1000</option>
                        </select>
                        <br/>
                        <br/>
                        <input type="submit" value="Get Outdoors Now">
                        <br>
                        <br>
                    </div>
                </div>
                <div id="tabs-3">
                    <input type="radio" name="singleOrMulti" value="Single" <?php if($singleOrMulti == "Single") echo "checked";?>> Single day&nbsp;
                    <input type="radio" name="singleOrMulti" value="Mutli" <?php if($singleOrMulti == "Mutli") echo "checked";?>> Multi-day
                    <br>
                    <br>
                    <div id="criteria">
                        <input type="text" id="location" placeholder="Where do you want to go?" name="location" value="<?php echo $location; ?>">
                        <input type="text" class="dates" placeholder="Start Date" id="sDate3" name="sDate" value="<?php echo $sdate; ?>">
                        <input type="text" placeholder="End Date" id="eDate3" name="eDate" value="<?php echo $edate; ?>">
                        <br/>
                        <br/>
                        <p>What do you want do hunt/fish?</p>
                        <br/>
                        <select id="tokenize3" multiple="multiple" placeholder="Where do you want to fish?" class="tokenize-sample">
                            <option value="" selected disabled>Please select</option>
                            <option value="1">Elk</option>
                            <option value="2">Deer</option>
                            <option value="3">Geese</option>
                            <option value="4">Quail</option>
                            <option value="5">Pheasant</option>
                            <option value="6">Duck</option>
                            <option value="7">Buffalo</option>
                            <option value="8">Turkey</option>
                            <option value="9">Mountain Lion</option>
                            <option value="10">Sheep</option>
                            <option value="11">Big Horn Sheep</option>
                            <option value="12">Tuna</option>
                            <option value="13">Tilapia</option>
                            <option value="14">Quail</option>
                            <option value="15">Pollock</option>
                            <option value="16">Cod</option>
                            <option value="17">Catfish</option>
                            <option value="18">Striped Bass</option>
                            <option value="19">Bluefish</option>
                            <option value="20">Scup</option>
                            <option value="21">Weakfish</option>
                            <option value="22">Salmon</option>
                        </select>
                        <br/>
                        <br/>

                        Search Radius :&nbsp;&nbsp;
                        <select id="Radius" name="Radius">
                            <option value="5" <?php if($radius == "5") echo "selected";?>> 5</option>
                            <option value="20" <?php if($radius == "20") echo "selected";?>> 20</option>
                            <option value="150" <?php if($radius == "150") echo "selected";?>> 150</option>
                            <option value="300" <?php if($radius == "30") echo "selected";?>> 300</option>
                            <option value="1000" <?php if($radius == "1000") echo "selected";?>> 1000</option>
                        </select>
                        <br/>
                        <br/>
                        <input type="submit" value="Get Outdoors Now">
                        <br>
                        <br>
                    </div>
                </div>
                <div id="tabs-4">
                    <input type="radio" name="singleOrMulti" value="Single" <?php if($singleOrMulti == "Single") echo "checked";?>> Single day&nbsp;
                    <input type="radio" name="singleOrMulti" value="Mutli" <?php if($singleOrMulti == "Mutli") echo "checked";?>> Multi-day
                    <br>
                    <br>
                    <div id="criteria">
                        &nbsp; <input type="text" id="location" placeholder="Where do you want to go?" name="location" value="<?php echo $location; ?>">
                        &nbsp;  <input type="text" class="dates" placeholder="Start Date" id="sDate4" name="sDate" value="<?php echo $sdate; ?>">
                        &nbsp; <input type="text" placeholder="End Date" id="eDate4" name="eDate" value="<?php echo $edate; ?>">
                        <br/>
                        <br/>
                        <br/>
                        <input type="submit" value="Get Outdoors Now">
                        <br>
                        <br>
                        <div class="sitesection">
                            <p class="expand-one"><a id="advanceSearch" href="#">Advanced Search</a> <!--<img src="images/arrow.png" width="5" height="7" />--></p>
                            <div class="content-one">
                                <ul>
                                    <li>
                                        Animal :&nbsp;&nbsp;
                                        <select name="Animal[]" id="Animal">
                                            <?php

                                            foreach($animals as $loopedAnimal)
                                            {
                                                ?>															<option value="<?echo $loopedAnimal;?>" <?php if(in_array($loopedAnimal, $animal)) echo "selected";?>> <?php echo $loopedAnimal;?></option>
                                            <?php } ?>
                                        </select>

                                        <!--<input type="checkbox" name="Animal[]" value="Elk" <?php if(in_array("Elk", $animal)) echo "checked";?>> Elk&nbsp;
													<input type="checkbox" name="Animal[]" value="Dove" <?php if(in_array("Dove", $animal)) echo "checked";?>> Dove&nbsp;
													<input type="checkbox" name="Animal[]" value="Moose" <?php if(in_array("Moose", $animal)) echo "checked";?>> Moose-->
                                    </li>
                                    <li>
                                        Search Radius :&nbsp;&nbsp;
                                        <select id="Radius" name="Radius">
                                            <option value="5" <?php if($radius == "5") echo "selected";?>> 5</option>
                                            <option value="20" <?php if($radius == "20") echo "selected";?>> 20</option>
                                            <option value="150" <?php if($radius == "150") echo "selected";?>> 150</option>
                                            <option value="300" <?php if($radius == "30") echo "selected";?>> 300</option>
                                            <option value="1000" <?php if($radius == "1000") echo "selected";?>> 1000</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>





        <div id="results">

            <?php //if(isset($_POST["location"]) && $_POST["location"] != "")
            if($_SERVER['REQUEST_METHOD'] == "POST")
            {



                foreach($array as $x => $x_value)
                {
                    $locationCheck = false;
                    $expeditionCheck = false;
                    if( count($animal) > 0)
                    {
                        $arrayintersectcount = count(array_intersect($x_value["Animals"],$animal));
                    }
                    else
                    {
                        $arrayintersectcount = 1;
                    }

                    if( $location == "" || $location == $x_value["ZipCode"] )
                    {
                        $locationCheck = true;
                    }

                    if( $expeditionType == "" || $x_value["Type"] == $expeditionType || $expeditionType == "Either" )
                    {
                        $expeditionCheck = true;
                    }



                    if($expeditionCheck
                        && $arrayintersectcount > 0
                        && $locationCheck
                        && $expeditionCheck

                    )
                    {
                        ?>
                        <div class="results-item">
                            <p>
                                <?php
                                echo $x;
                                ?>
                            </p>
                            <?php
                            foreach($x_value as $xa => $xa_value)
                            {
                                $xa_valuea = "";
                                if(is_array($xa_value))
                                {
                                    $arrlength = count($xa_value);

                                    for($x = 0; $x < $arrlength; $x++)
                                    {
                                        $xa_valuea .= " ".$xa_value[$x];
                                    }
                                }
                                else
                                {
                                    $xa_valuea = $xa_value;
                                }
                                echo $xa . ": " . $xa_valuea;
                                echo "<br>";
                            }
                            echo "<br>";
                            ?>
                        </div>
                        <?php
                    }

                }
            }
            ?>
            <br/>
            <br/>
            <br/>
        </div>
    </div>
</div>
</div>

</form>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/include/bottom.php");?>
