                            <div class="col-sm-12">
                            <div class="panel panel-success panel-success-custom" id="panel-info">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="active"><a href="#Hunting" role="tab" data-toggle="tab">Hunting</a></li>
                                <li><a href="#Fishing" role="tab" data-toggle="tab">Fishing</a></li>
                                <li><a href="#Activities" role="tab" data-toggle="tab">Activities</a></li>
                            </ul>
                            <div class="panel-body">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane active" id="Hunting">
                                        <div id="criteria">
                                            <!-- ><input type="text" id="location" placeholder="Where do you want to go?" name="locationHunt" value="<?php echo $location; ?>">- -->
                                            <div class="datesLocation">
                                                <div class="locations">
                                                    State:
                                                    <select name="StateHunt" id="StateHunt">
                                                        <option value="" disabled selected>Select a State</option>
                                                        <option value="CO">Colorado</option>
                                                        <option value="TX">Texas</option>
                                                    </select>
                                                    <br>
                                                    <br>
                                                    Region:
                                                    <select name="RegionHunt" id="RegionHunt">
                                                        <option value="" disabled selected>Select a Region</option>
                                                    </select>
                                                    <br>
                                                    <br>
                                                    Outfitter:
                                                    <select name="OutfitterHunt" id="OutfitterHunt">
                                                        <option value="" disabled selected>Select an Outfitter</option>
                                                    </select>
                                                </div>
                                                <div class="dates">
                                                    Start Date:
                                                    <input type="text" class="dates form-control" placeholder="" id="sDate1" name="sDateHunt" value="<?php echo $sdate; ?>"/>
                                                    <i class="glyphicon glyphicon-calendar form-control-feedback"></i>


                                                    <br>
                                                    End Date: <input type="text" placeholder="" id="eDate1" name="eDateHunt" value="<?php echo $edate; ?>">
                                                </div>
                                            </div>
                                            <input class='btn btn-success btn-success-custom' type="submit" name="btnHunt" value="Get Outdoors Now">
<!--                                            <div id="accordionHunt">
                                                <h3>Advanced Options</h3>
                                                <div>
                                                    <p>What do you want do hunt?</p>
                                                    <select id="tokenizeHunt" multiple="multiple" name="optionHunt[]" class="tokenize-sample">
                                                        <option value="" selected disabled>Please select</option>
                                                        <?php
/*                                                        foreach ($huntanimals as $animal)
                                                        {
                                                            */?>													<option value="<?php /*echo $animal*/?>"><?php /*echo $animal*/?></option>
                                                            <?php
/*                                                        }
                                                        */?>
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
-->                                            <br>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="Fishing">
                                        <input type="radio" name="singleOrMultiFish" value="Single" <?php if($singleOrMulti == "Single") echo "checked";?>> Single day&nbsp;
                                        <input type="radio" name="singleOrMultiFish" value="Mutli" <?php if($singleOrMulti == "Mutli") echo "checked";?>> Multi-day
                                        <br>
                                        <div id="criteria">
                                            <input type="text" id="location" placeholder="Where do you want to go?" name="locationFish" value="<?php echo $location; ?>">
                                            <input type="text" class="dates" placeholder="Start Date" id="sDate2" name="sDateFish" value="<?php echo $sdate; ?>">
                                            <input type="text" placeholder="End Date" id="eDate2" name="eDateFish" value="<?php echo $edate; ?>">
                                            <input class='SearchButton' type="submit" name="btnFish" value="Get Outdoors Now">
                                            <br/>
                                            <br/>
                                            <br/>
                                            <div id="accordionFish">
                                                <h3>Advanced Options</h3>
                                                <div>
                                                    <p>What do you want do fish?</p>
                                                    <select id="tokenizeFish" multiple="multiple" name="optionFish[]" class="tokenize-sample">
                                                        <option value="" selected disabled>Please select</option>
                                                        <?php
                                                        foreach ($fishanimals as $animal)
                                                        {
                                                            ?>													<option value="<?php echo $animal?>"><?php echo $animal?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    Search Radius :&nbsp;&nbsp;
                                                    <select id="Radius" name="radiusFish">
                                                        <option value="5" <?php if($radius == "5") echo "selected";?>> 5</option>
                                                        <option value="20" <?php if($radius == "20") echo "selected";?>> 20</option>
                                                        <option value="150" <?php if($radius == "150") echo "selected";?>> 150</option>
                                                        <option value="300" <?php if($radius == "30") echo "selected";?>> 300</option>
                                                        <option value="1000" <?php if($radius == "1000") echo "selected";?>> 1000</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="Activities">
                                        <input type="radio" name="singleOrMultiActivity" value="Single" <?php if($singleOrMulti == "Single") echo "checked";?>> Single day&nbsp;
                                        <input type="radio" name="singleOrMultiActivity" value="Mutli" <?php if($singleOrMulti == "Mutli") echo "checked";?>> Multi-day
                                        <br>
                                        <div id="criteria">
                                            <input type="text" id="location" placeholder="Where do you want to go?" name="locationActivity" value="<?php echo $location; ?>">
                                            <input type="text" class="dates" placeholder="Start Date" id="sDate4" name="sDateActivity" value="<?php echo $sdate; ?>">
                                            <input type="text" placeholder="End Date" id="eDate4" name="eDateActivity" value="<?php echo $edate; ?>">
                                            <input class='SearchButton' type="submit" name="btnActivity" value="Get Outdoors Now">
                                            <br/>
                                            <br/>
                                            <br/>
                                            <div id="accordionActivity">
                                                <h3>Advanced Options</h3>
                                                <div>
                                                    Search Radius :&nbsp;&nbsp;
                                                    <select id="Radius" name="radiusActivity">
                                                        <option value="5" <?php if($radius == "5") echo "selected";?>> 5</option>
                                                        <option value="20" <?php if($radius == "20") echo "selected";?>> 20</option>
                                                        <option value="150" <?php if($radius == "150") echo "selected";?>> 150</option>
                                                        <option value="300" <?php if($radius == "30") echo "selected";?>> 300</option>
                                                        <option value="1000" <?php if($radius == "1000") echo "selected";?>> 1000</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                        </div>
                                    </div>



                                </div>
                            </div>
                            </div>
                            </div>
