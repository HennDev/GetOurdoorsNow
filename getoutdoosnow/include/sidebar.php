<div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <!--<li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>-->
            <li <?php if($pageID=="allUsersOutfitters") echo 'class="active"';?>><a href="/Outfitters/allUsersOutfitters.php">Overview</a></li>
			<?php if(isset($id)){ ?>
			<li <?php if($pageID=="editOutfitter") echo 'class="active"';?>><a href="/Outfitters/editOutfitter.php?id=<?php echo $id?>">Edit Information</a></li>
            <li <?php if($pageID=="animalManager") echo 'class="active"';?>><a href="/Outfitters/animalManager.php?id=<?php echo $id?>">Edit Animals</a></li>
            <li <?php if($pageID=="editImages") echo 'class="active"';?>><a href="/Outfitters/Images/editImages.php?id=<?php echo $id?>">Edit Images</a></li>
            <li <?php if($pageID=="amenitiesManager") echo 'class="active"';?>><a href="/Outfitters/amenitiesManager.php?id=<?php echo $id?>">Edit Amenities</a></li>
            <?php } ?>
            <li <?php if($pageID=="linkOutfitter") echo 'class="active"';?>><a href="/Outfitters/linkOutfitter.php">Add an Outfitter</a></li>
          </ul>
          <!--<ul class="nav nav-sidebar">
            <li><a href="">Nav item</a></li>
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
            <li><a href="">More navigation</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
          </ul>-->
        </div>

