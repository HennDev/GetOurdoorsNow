<?php
  session_start();
  include("database.php");  
  include("common.php");
  $error = "";
  $success = false;
$coinsToWatch = array("RIC","IOST","PPP","ITC","DGB");
$slug = 'ethereum'; // find all at https://files.coinmarketcap.com/generated/search/quick_search.json
$tick = file_get_contents('https://api.coinmarketcap.com/v1/ticker/?limit=400');
$url = $tick;
//echo $url;
setlocale(LC_MONETARY, 'en_US.UTF-8');

$coins = json_decode($url,true);

$roundingArray = array("price_usd","available_supply","total_supply","market_cap_usd");
$totals = array("volMktCp Ratio"=>array());
foreach($coins as &$coin)
{
  $coin["volMktCp Ratio"] = round(($coin["24h_volume_usd"] / $coin["market_cap_usd"]),5);
  $coin["name"] = "<a href='https://coinmarketcap.com/currencies/".(str_replace(" ","-",$coin["name"]))."' target='_blank'>".$coin["name"]."</a>";
  round(($coin["24h_volume_usd"] / $coin["market_cap_usd"]),5);
  foreach ($roundingArray as $dollar)
  {
    $coin[$dollar] = money_format('%.3n', $coin[$dollar]);
  }
  $totals["volMktCp Ratios"][] = $coin["volMktCp Ratio"];
}

$ninetithPercentile = mypercentile($totals["volMktCp Ratios"],85.0);

unset($coin);

$allKeys = array_keys($coins[0]);

$keysToPrint = array("name"=>"Name","symbol"=>"Symbol","price_usd"=>"USD","market_cap_usd"=>"Mkt Cap","total_supply"=>"Total Supply","percent_change_1h"=>"1 Hr","percent_change_24h" =>"24 Hr","percent_change_7d"=>"7d","volMktCp Ratio"=>"Volume / Mkt Cp");

$priceSlot = count($keysToPrint)-1;

//echo "<br><br><br><br>??".print_r(array_keys($coins[0]),true)."<br><br><br><br>"; 

/*$json = file_get_contents($url);
$data = json_decode($tick, TRUE); //decodes in associative array

$ethusd = $data[0]['price_usd'];
echo $ethusd;*/


include('include/top_start.php');
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
        "columnDefs": [
    { className: "dt-right", "targets": [ 0 ] }
  ],
        "order": [[ <?=$priceSlot?>, "desc" ]],
        "pageLength": 25
    } );
  } );
</script>
<?
include('include/top_end.php');
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
      echo "<th style='display:none;'>Watching</th>";
        
      foreach($allKeys as $key)
      {
        if(array_key_exists($key,$keysToPrint))
        {
          echo "<th>".$keysToPrint[$key]."</th>";
        }
      }
      
      
         
?>
            </tr>
        </thead>
        <tfoot>
          
<?php 
      foreach($allKeys as $key)
      {
        if(array_key_exists($key,$keysToPrint))
        {
          echo "<th>".$keysToPrint[$key]."</th>";
        }
      }
?>
        </tfoot>
        <tbody>
            <?php
          
          foreach($coins as $coin)
          {
              echo "<tr>";
              
              if(in_array($coin["symbol"],$coinsToWatch))
              {
                $watched = "watching";
              }
              else
              {
                $watched = "";
              }
              
              
              echo "<td style='display:none;'>$watched</td>";
              
              foreach($allKeys as $key)
              {
                $styleStr = "";
                
                if(in_array($coin["symbol"],$coinsToWatch))
                {
                  $styleStr = "background-color: #f0ffef !important;";
                }
                
                if($coin["volMktCp Ratio"]>=$ninetithPercentile)
                {
                  $styleStr .= "color:green;font-weight: bold;";
                }
                else
                {
                  $styleStr = "";
                }
                
                $style ="";
                if(!empty($styleStr))
                {
                  $style = "style='$styleStr'";
                }
                
                if(array_key_exists($key,$keysToPrint))
                {
                  echo "<td $style>".$coin[$key]."</td>";
                }
              }
              echo "</tr>";
            }

?>
        </tbody>
    </table>


      </div>
    </div>
  </div>
<?php include('include/bottom.php');



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