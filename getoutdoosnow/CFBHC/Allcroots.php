<?php

$allKeys = array("POINTS","PLAYER","POS","YEAR","HGT","WGT","RATING","OFFERS");

$keysToPrint = array("POINTS","PLAYER","POS","YEAR","HGT","WGT","RATING","OFFERS");

$priceSlot = count($keysToPrint)-1;


include('../include/top_start.php');
?>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>

<style type="text/css">
  .container {
    width: 1920px;
}
</style>
<script type="text/javascript">
  $(document).ready(function() {

      $('#example').DataTable( {
        } );
  } );
</script>
<?
include('../include/top_end.php');
?>
<div class="container">
  <div class="col-md-12">
    <div class="panel panel-default panel-success panel-success-custom">
      <div class="panel-heading clearfix text-center">
        <i class="icon-calendar"></i>
        <h3 class="panel-title"></h3>
      </div>
      <div class="panel-body">
        <?php //echo "<br><br><br><br>??".print_r(array_keys($coins[0]),true)."<br><br><br><br>$ninetithPercentile"; ?>
        
        
        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
<?php 
     
        
      foreach($allKeys as $key)
      {
         echo "<th>$key</th>";
        
      }
      
      
         
?>
            </tr>
        </thead>
        <tfoot>
          
<?php 
      foreach($allKeys as $key)
      {
                echo "<th>$key</th>";
      }
?>
        </tfoot>
        <tbody>
<tr>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="csrfmiddlewaretoken" value="ahlD3AFt6YSAFvjLTPUqGNB93CowBSL2"><input id="id_position" name="position" type="hidden" value="QB"><input id="id_forename" maxlength="100" name="forename" type="hidden" value="Chris"><input id="id_surname" maxlength="100" name="surname" type="hidden" value="Conn"><input id="id_height" name="height" type="hidden" value="71"><input id="id_weight" name="weight" type="hidden" value="204">
                        
                        <p>SIGNED</p>
                        
                    </form>
                </td>
                <td>
                    Chris Conn
                    
                    <br>
                    <font color="gray" size="2">Bloomington North (Bloomington, IN)</font>
                </td>
                <td>
                    QB <br>
                    <font color="gray" size="2">Hybrid</font>
                </td>
                <td>Fr</td>
                <td>5-11</td>
                <td>204</td>
                <td>
                    
                        <img src="/static/images/icons/icon_star_full.png" height="15" width="15">
                    
                    
                    
                        <img src="/static/images/icons/icon_star_empty.png" height="15" width="15">
                    
                        <img src="/static/images/icons/icon_star_empty.png" height="15" width="15">
                    
                        <img src="/static/images/icons/icon_star_empty.png" height="15" width="15">
                    
                    
                    
                    <br><font color="gray" size="2">1.0 of 4.0</font>
                </td>
                <td>

                            <img class="img-rounded" style="border:5px solid red" src="/static/images/teams/icons/und.gif" width="50" height="50">




                       

                </td>
              </tr>
              
              <tr>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="csrfmiddlewaretoken" value="ahlD3AFt6YSAFvjLTPUqGNB93CowBSL2"><input id="id_position" name="position" type="hidden" value="QB"><input id="id_forename" maxlength="100" name="forename" type="hidden" value="Nicola"><input id="id_surname" maxlength="100" name="surname" type="hidden" value="Rossi"><input id="id_height" name="height" type="hidden" value="74"><input id="id_weight" name="weight" type="hidden" value="234">
                        
                        <p>SIGNED</p>
                        
                    </form>
                </td>
                <td>
                    Nicola Rossi
                    
                    <br>
                    <font color="gray" size="2">Driscoll Catholic (Addison, IL)</font>
                </td>
                <td>
                    QB <br>
                    <font color="gray" size="2">Hybrid</font>
                </td>
                <td>Fr</td>
                <td>6-2</td>
                <td>234</td>
                <td>
                    
                        <img src="/static/images/icons/icon_star_full.png" height="15" width="15">
                    
                    
                    
                        <img src="/static/images/icons/icon_star_empty.png" height="15" width="15">
                    
                        <img src="/static/images/icons/icon_star_empty.png" height="15" width="15">
                    
                        <img src="/static/images/icons/icon_star_empty.png" height="15" width="15">
                    
                    
                    
                    <br><font color="gray" size="2">1.0 of 4.0</font>
                </td>
                <td>

                            <img class="img-rounded" style="border:5px solid red" src="/static/images/teams/icons/nw.gif" width="50" height="50">




                       

                </td>
              </tr>
              
              <tr>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="csrfmiddlewaretoken" value="ahlD3AFt6YSAFvjLTPUqGNB93CowBSL2"><input id="id_position" name="position" type="hidden" value="QB"><input id="id_forename" maxlength="100" name="forename" type="hidden" value="Rollie"><input id="id_surname" maxlength="100" name="surname" type="hidden" value="Green"><input id="id_height" name="height" type="hidden" value="72"><input id="id_weight" name="weight" type="hidden" value="199">
                        
                        <button class="btn btn-primary" type="submit" name="add">Add</button>
                        
                    </form>
                </td>
                <td>
                    Rollie Green
                    
                    <br>
                    <font color="gray" size="2">Eden (Eden, TX)</font>
                </td>
                <td>
                    QB <br>
                    <font color="gray" size="2">Pocket</font>
                </td>
                <td>Fr</td>
                <td>6-0</td>
                <td>199</td>
                <td>
                    
                        <img src="/static/images/icons/icon_star_full.png" height="15" width="15">
                    
                    
                    
                        <img src="/static/images/icons/icon_star_empty.png" height="15" width="15">
                    
                        <img src="/static/images/icons/icon_star_empty.png" height="15" width="15">
                    
                    
                        <img src="/static/images/icons/icon_star_half_empty.png" height="15" width="15">
                    
                    
                    <br><font color="gray" size="2">1.0 of 3.5</font>
                </td>
                <td>

                            <img class="img-rounded" style="border:5px solid red" src="/static/images/teams/icons/smu.gif" width="50" height="50">


                            <img class="img-rounded" src="/static/images/teams/icons/ulm.gif" width="50" height="50">


                            <img class="img-rounded" src="/static/images/teams/icons/kan.gif" width="50" height="50">


                       
                            <img class="img-rounded" src="/static/images/icons/icon_plus.png" title="2 more offers" width="25" height="25">
                    

                </td>
              </tr>
        </tbody>
    </table>



      </div>
    </div>
  </div>
<?php include('../include/bottom.php');



function mypercentile($data,$percentile){ 
    if( 0 < $percentile && $percentile < 1 ) { 
        $p = $percentile; 
    }else if( 1 < $percentile && $percentile <= 100 ) { 
        $p = $percentile * .01; 
    }else { 
        return ""; 
    } 
    $count = count($data); 
    $allindex = ($count-1)*$p; 
    $intvalindex = intval($allindex); 
    $floatval = $allindex - $intvalindex; 
    sort($data); 
    if(!is_float($floatval)){ 
        $result = $data[$intvalindex]; 
    }else { 
        if($count > $intvalindex+1) 
            $result = $floatval*($data[$intvalindex+1] - $data[$intvalindex]) + $data[$intvalindex]; 
        else 
            $result = $data[$intvalindex]; 
    } 
    return $result; 
} 

?>