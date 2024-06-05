<?php
  session_start();
  include("database.php");  
  include("common.php");
  $error = "";
  $success = false;




include('include/top_start.php');
?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/dataTables.bootstrap.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.13/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
  $('#example').DataTable();
});
</script>
<?
include('include/top_end.php');

$conferenceArray = array(
  "ACC" => array("Clemson", "Louisville", "Florida State", "N.C. State", "Wake Forest", "Boston College", "Syracuse", "Virginia Tech", "Miami", "North Carolina", "Pittsburgh", "Georgia Tech", "Duke", "Virginia", ),"AAC" => array("South Florida", "Temple", "UCF", "Cincinnati", "Connecticut", "East Carolina", "Navy", "Tulsa", "Houston", "Memphis", "Southern Methodist", "Tulane", ), 
  "Big 12" => array("Oklahoma", "Oklahoma State", "West Virginia", "Kansas State", "TCU", "Baylor", "Texas", "Texas Tech", "Iowa State", "Kansas", ), 
  "Big Ten" => array("Ohio State", "Penn State", "Michigan", "Indiana", "Maryland", "Michigan State", "Rutgers", "Wisconsin", "Nebraska", "Iowa", "Minnesota", "Northwestern", "Illinois", "Purdue", ),
  "C-USA" => array("Western Kentucky", "Old Dominion", "Middle Tennessee", "Florida International", "Charlotte", "Florida Atlantic", "Marshall", "Louisiana Tech", "UTSA", "SMU", "North Texas", "UTEP", "Rice"),
  "Independents(FBS)" => array("Brigham Young", "Army", "Notre Dame", "Massachusetts", ),
  "MAC" => array("Western Michigan", "Toledo", "Northern Illinois", "Eastern Michigan", "Central Michigan", "Ball State", "Ohio", "Miami (OH)", "Akron", "Bowling Green", "Kent State", "Buffalo", ),
  "MWC" => array("San Diego State", "Hawaii", "Nevada", "San Jose State", "UNLV", "Fresno State", "Boise State", "New Mexico", "Wyoming", "Air Force", "Colorado State", "Utah State", ),
  "Pac-12" => array("Washington", "Washington State", "Stanford", "California", "Oregon State", "Oregon", "Colorado", "USC", "Utah", "Arizona State", "UCLA", "Arizona", ),
  "SEC" => array("Alabama", "LSU", "Auburn", "Texas A&M", "Arkansas", "Mississippi State", "Ole Miss", "Florida", "Tennessee", "Georgia", "Kentucky", "South Carolina", "Vanderbilt", "Missouri", ),
  "Sun Belt" => array("Appalachian State", "Arkansas State", "Troy", "Idaho", "Louisiana-Lafayette", "Georgia Southern", "Louisiana-Monroe", "South Alabama", "Georgia State", "New Mexico State", "Texas State"),
  "Southland" => array("Stephen F. Austin"));

$statesArray = array("Air Force" => "Colorado", "Akron" => "Ohio", "Alabama" => "Alabama", "Appalachian State" => "North Carolina", "Arizona" => "Arizona", "Arizona State" => "Arizona", "Arkansas" => "Arkansas", "Arkansas State" => "Arkansas", "Army West Point" => "New York", "Auburn" => "Alabama", "Ball State" => "Indiana", "Baylor" => "Texas", "Boise State" => "Idaho", "Boston College" => "Massachusetts", "Bowling Green" => "Ohio", "Buffalo" => "New York", "Brigham Young" => "Utah", "California" => "California", "Fresno State" => "California", "UCLA" => "California", "UCF" => "Florida", "Central Michigan" => "Michigan", "Charlotte" => "North Carolina", "Cincinnati" => "Ohio", "Clemson" => "South Carolina", "Colorado" => "Colorado", "Colorado State" => "Colorado", "Connecticut" => "Connecticut", "Duke" => "North Carolina", "Eastern Michigan" => "Michigan", "East Carolina" => "North Carolina", "FIU" => "Florida", "Florida" => "Florida", "Florida Atlantic" => "Florida", "Florida State" => "Florida", "Georgia" => "Georgia", "Georgia Southern" => "Georgia", "Georgia State" => "Georgia", "Georgia Tech" => "Georgia", "Hawai'i" => "Hawai'i", "Houston" => "Texas", "Idaho" => "Idaho", "Illinois" => "Illinois", "Indiana" => "Indiana", "Iowa" => "Iowa", "Iowa State" => "Iowa", "Kansas" => "Kansas", "Kansas State" => "Kansas", "Kent State" => "Ohio", "Kentucky" => "Kentucky", "LSU" => "Louisiana", "Louisiana Tech" => "Louisiana", "Louisiana-Lafayette" => "Louisiana", "Louisiana-Monroe" => "Louisiana", "Louisville" => "Kentucky", "Marshall" => "West Virginia", "Maryland" => "Maryland", "Massachusetts" => "Massachusetts", "Memphis" => "Tennessee", "Miami" => "Florida", "Miami (OH)" => "Ohio", "Michigan" => "Michigan", "Michigan State" => "Michigan", "Middle Tennessee" => "Tennessee", "Minnesota" => "Minnesota", "Ole Miss" => "Mississippi", "Mississippi State" => "Mississippi", "Missouri" => "Missouri", "Navy" => "Maryland", "Nebraska" => "Nebraska", "Nevada" => "Nevada", "UNLV" => "Nevada", "New Mexico" => "New Mexico", "New Mexico State" => "New Mexico", "North Carolina" => "North Carolina", "N.C. State" => "North Carolina", "North Texas" => "Texas", "Northern Illinois !NIU" => "Illinois", "Northwestern" => "Illinois", "Notre Dame" => "Indiana", "Ohio" => "Ohio", "Ohio State" => "Ohio", "Oklahoma" => "Oklahoma", "Oklahoma State" => "Oklahoma", "Old Dominion" => "Virginia", "Oregon" => "Oregon", "Oregon State" => "Oregon", "Penn State" => "Pennsylvania", "Pittsburgh" => "Pennsylvania", "Purdue" => "Indiana", "Rice" => "Texas", "Rutgers" => "New Jersey", "San Diego State" => "California", "San Jose State" => "California", "South Alabama" => "Alabama", "South Carolina" => "South Carolina", "South Florida" => "Florida", "USC" => "California", "SMU" => "Texas", "Southern Miss" => "Mississippi", "Stanford" => "California", "Syracuse" => "New York", "TCU" => "Texas", "Temple" => "Pennsylvania", "Tennessee" => "Tennessee", "Texas" => "Texas", "Texas A&M" => "Texas", "Texas State" => "Texas", "Texas Tech" => "Texas", "Texas-El Paso !UTEP" => "Texas", "Texas-San Antonio !UTSA" => "Texas", "Toledo" => "Ohio", "Troy" => "Alabama", "Tulane" => "Louisiana", "Tulsa" => "Oklahoma", "Utah" => "Utah", "Utah State" => "Utah", "Vanderbilt" => "Tennessee", "Virginia" => "Virginia", "Virginia Tech" => "Virginia", "Wake Forest" => "North Carolina", "Washington" => "Washington", "Washington State" => "Washington", "West Virginia" => "West Virginia", "Western Kentucky" => "Kentucky", "Western Michigan" => "Michigan", "Wisconsin" => "Wisconsin", "Wyoming" => "Wyoming", "Stephen F. Austin" => "Texas", "Hawaii" => "Hawaii" );

$yearsArray = array(
        "2017" => array("Florida State", "Ohio State", "Stanford", "Ohio State", "LSU", "Ohio State", "LSU", "Texas A&M", "Notre Dame", "Texas Tech", "Alabama", "USC", "LSU", "Oklahoma", "TCU", "Oklahoma", "Stanford", "Michigan", "Oklahoma State", "Texas", "Arizona State", "Arkansas", "Texas", "Oklahoma", "TCU", "Texas", "Texas A&M", "Oklahoma", "Oklahoma", "TCU", "Texas A&M", "LSU", "TCU", "Texas", "Oklahoma", "Northwestern", "Notre Dame", "Texas", "Texas A&M", "UCLA", "Oklahoma State", "LSU", "Texas A&M", "Alabama", "Texas", "Colorado", "Alabama", "Colorado", "Baylor", "Texas A&M", "Texas A&M", "Northwestern", "Ole Miss", "Texas A&M", "Utah", "Oklahoma", "Nebraska", "TCU", "Nebraska", "Baylor", "Baylor", "Baylor", "Texas A&M", "Tulsa", "Colorado", "Texas A&M", "Texas A&M", "Miami", "Texas", "Oklahoma State", "SMU", "Kansas", "TCU", "Texas Tech", "Texas", "Baylor", "Missouri", "Arizona State", "San Diego State", "Baylor", "Arkansas", "Texas State", "Texas", "Texas Tech", "Texas Tech", "Nebraska", "Vanderbilt", "TCU", "Colorado", "Northwestern", "Texas", "Iowa", "Vanderbilt", "Boise State", "Missouri", "Oklahoma", "Oklahoma State", "Texas A&M", "Oklahoma State", ),
        "2016" => array("Ole Miss", "Houston", "Florida", "Texas", "Stanford", "Texas", "Texas", "Ole Miss", "LSU", "Texas A&M", "Texas", "Texas", "Florida State", "Alabama", "Arkansas", "Houston", "Texas A&M", "Texas", "Texas", "TCU", "Texas A&M", "TCU", "TCU", "Alabama", "Alabama", "Alabama", "Texas", "LSU", "Texas", "Oregon", "LSU", "Oklahoma", "Texas", "Ole Miss", "TCU", "Texas A&M", "Ole Miss", "Texas", "TCU", "Auburn", "Texas A&M", "Oregon State", "Texas", "Oklahoma", "Texas", "Houston", "Texas", "Washington", "Texas A&M", "Texas Tech", "Baylor", "Stanford", "UCLA", "Arizona State", "TCU", "Texas", "Stanford", "Texas", "Minnesota", "Baylor", "Texas", "Stanford", "TCU", "Texas A&M", "TCU", "UCLA", "Baylor", "Houston", "Texas", "Texas A&M", "Baylor", "Texas A&M", "Texas Tech", "Texas A&M", "Baylor", "Oklahoma State", "TCU", "Texas A&M", "Clemson", "Texas", "Oklahoma", "Baylor", "SMU", "Ole Miss", "Texas A&M", "Texas A&M", "Baylor", "TCU", "Kansas", "Baylor", "Houston", "Arkansas", "Texas Tech", "Arkansas", "TCU", "Stephen F. Austin", ),
        "2015" => array("Texas", "Texas A&M", "Alabama", "UCLA", "Texas A&M", "LSU", "Baylor", "USC", "Ole Miss", "Alabama", "Texas", "Texas", "Texas", "Texas", "LSU", "Texas", "Oklahoma", "Texas A&M", "Texas A&M", "Oklahoma", "Texas A&M", "California", "Oklahoma", "Texas Tech", "Texas", "Texas A&M", "Baylor", "Texas A&M", "Texas A&M", "Nebraska", "Texas Tech", "Texas", "Texas A&M", "Baylor", "Texas A&M", "Texas Tech", "Oklahoma State", "Oklahoma State", "Tennessee", "Texas", "Texas A&M", "Texas A&M", "Texas Tech", "Oklahoma", "Texas", "Michigan State", "Texas", "Tulsa", "Arkansas", "Notre Dame", "Texas A&M", "Oklahoma", "Houston", "TCU", "Baylor", "Baylor", "Texas", "Texas", "Texas Tech", "TCU", "TCU", "Oklahoma", "Texas A&M", "Oklahoma State", "TCU", "USC", "Oklahoma State", "Fresno State", "Texas", "Texas Tech", "SMU", "TCU", "Arkansas", "Texas", "Texas A&M", "Oklahoma", "Arizona State", "TCU", "Michigan State", "Texas", "Arkansas", "Oklahoma", "TCU", "Oklahoma State", "Colorado", "Illinois", "Northwestern", "Michigan State", "Baylor", "TCU", "TCU", "TCU", "Ole Miss", "SMU", "Nebraska", "Tennessee", "Kansas State", ),
        "2014" => array("Texas A&M", "Alabama", "Stanford", "Baylor", "LSU", "LSU", "Baylor", "Texas A&M", "Texas", "Texas", "Boise State", "Oregon", "Texas A&M", "UCLA", "Ohio State", "Texas", "Texas A&M", "Texas A&M", "Texas", "Notre Dame", "TCU", "Texas", "Texas A&M", "Texas", "Texas A&M", "Stanford", "Baylor", "Texas A&M", "Oklahoma", "Texas", "Florida State", "Notre Dame", "Oklahoma State", "Baylor", "LSU", "Texas A&M", "Texas A&M", "TCU", "Oklahoma State", "Texas Tech", "Arkansas", "LSU", "Texas Tech", "Baylor", "Baylor", "TCU", "USC", "Texas Tech", "Oklahoma State", "TCU", "Texas Tech", "Oklahoma State", "LSU", "Oklahoma State", "Minnesota", "Oklahoma", "Texas A&M", "Northwestern", "Oregon State", "SMU", "TCU", "Arizona State", "Purdue", "Texas", "Texas", "Texas", "Texas A&M", "Texas", "Tennessee", "Baylor", "Texas A&M", "Texas Tech", "Baylor", "Oklahoma", "Baylor", "Kansas", "Notre Dame", "Vanderbilt", "Texas Tech", "UCLA", "Kansas", "Baylor", "Oklahoma", "Kentucky", "TCU", "UCLA", "Texas Tech", "Utah", "Kansas", "Baylor", "California", "Colorado State", "Louisiana Tech", "Texas Tech", ),
        "2013" => array("Oklahoma", "Texas A&M", "Baylor", "Alabama", "Texas", "Texas", "Miami", "Ohio State", "Ohio State", "Texas A&M", "Alabama", "Texas A&M", "Oklahoma", "Texas", "Texas", "Texas", "Ohio State", "Baylor", "Texas A&M", "Texas A&M", "Texas A&M", "Texas", "Texas A&M", "Oregon", "UCLA", "UCLA", "Mississippi State", "Texas", "TCU", "Notre Dame", "Texas A&M", "Texas", "Oklahoma State", "Texas A&M", "Nebraska", "Notre Dame", "Oklahoma", "Oklahoma State", "Oklahoma", "Texas", "Texas A&M", "Texas A&M", "UCLA", "Texas A&M", "Baylor", "Ole Miss", "Texas Tech", "Texas A&M", "Notre Dame", "TCU", "Oklahoma State", "Texas A&M", "Texas Tech", "TCU", "Texas A&M", "Texas", "Baylor", "Ole Miss", "Texas A&M", "Texas A&M", "Texas", "TCU", "TCU", "Texas Tech", "Baylor", "Texas A&M", "Ole Miss", "Baylor", "Oregon State", "Oklahoma State", "Texas Tech", "Oklahoma State", "Utah", "Oklahoma", "Oklahoma State", "Oklahoma", "Missouri", "Texas A&M", "Texas", "Baylor", "Oklahoma", "TCU", "Oklahoma", "Texas A&M", "SMU", "TCU", "Texas Tech", "West Virginia", "TCU", "Texas State", "Oklahoma", "Utah", "Oklahoma State", "Missouri", "Oklahoma State", "Utah", ),
        "2012" => array("Florida State", "Texas", "Texas", "Texas A&M", "Texas A&M", "Texas", "Texas", "Baylor", "Texas", "Oregon", "Tennessee", "Texas A&M", "Texas", "Texas Tech", "TCU", "Texas", "Texas A&M", "Texas", "Texas Tech", "Baylor", "Texas", "Oklahoma", "Texas", "Texas Tech", "Arkansas", "Texas", "LSU", "Texas", "Texas", "Texas", "Texas", "TCU", "Texas", "Texas A&M", "TCU", "Baylor", "LSU", "Texas A&M", "Texas", "Oklahoma State", "Nebraska", "Baylor", "Oklahoma", "Texas", "Arkansas", "Texas A&M", "Utah", "Florida State", "Texas A&M", "Oklahoma State", "Texas A&M", "Texas Tech", "West Virginia", "Utah", "Texas", "Baylor", "Arkansas", "Texas A&M", "Texas A&M", "Oklahoma State", "UCLA", "Texas A&M", "Baylor", "Texas Tech", "Texas A&M", "Texas", "TCU", "Houston", "Texas", "Texas Tech", "Baylor", "TCU", "Baylor", "TCU", "TCU", "Oklahoma State", "UCLA", "Notre Dame", "California", "Oklahoma State", "Oklahoma", "Oregon", "TCU", "Houston", "Missouri", "Arkansas", "Stanford", "Alabama", "TCU", "Arkansas", "Baylor", "Baylor", "Texas Tech", "Vanderbilt", "Texas Tech", "Boise State", ),
        "2011" => array("Oklahoma", "Texas", "Oklahoma", "Texas", "Nebraska", "Texas", "Texas", "Oklahoma State", "Nebraska", "Texas", "Nebraska", "TCU", "Texas", "Oklahoma", "Oklahoma State", "Oregon", "Texas Tech", "Oklahoma", "Texas", "Texas", "Texas", "LSU", "Texas Tech", "Texas", "Texas", "Texas", "Texas", "Arkansas", "TCU", "Texas Tech", "Baylor", "Texas A&M", "Stanford", "California", "LSU", "Texas A&M", "Michigan", "Oklahoma", "Oklahoma", "Texas Tech", "Oklahoma", "Texas Tech", "Texas", "Texas A&M", "Oklahoma", "TCU", "Oklahoma State", "Texas Tech", "Texas", "Arkansas", "Oklahoma State", "Texas", "Oklahoma State", "Oregon", "Oklahoma State", "TCU", "Texas A&M", "Oklahoma", "Texas", "Colorado State", "Baylor", "Texas A&M", "Texas", "Texas Tech", "Nebraska", "Oklahoma State", "Arizona", "Texas", "TCU", "Texas A&M", "Texas Tech", "Utah", "Oklahoma State", "TCU", "Oklahoma", "TCU", "Oklahoma State", "UCLA", "Oklahoma State", "Baylor", "TCU", "Oklahoma State", "Boise State", "Utah", "TCU", "Houston", "TCU", "Oklahoma State", "Texas", "TCU", "Missouri", "Michigan", "Texas Tech", "Texas Tech", "Oklahoma", "Oklahoma State", "Notre Dame", "Missouri", "TCU", ),
        "2010" => array("Texas", "Texas", "Texas", "Texas", "Oregon", "Texas A&M", "Baylor", "Texas A&M", "Texas", "Oklahoma", "Texas", "Texas", "Texas", "Texas", "Oklahoma State", "Alabama", "Texas A&M", "Texas", "Brigham Young", "Texas", "Texas", "Texas", "LSU", "Texas", "Texas", "Oklahoma", "Arkansas", "Oklahoma", "Oregon", "Texas A&M", "Texas A&M", "Oregon", "Texas", "Oklahoma", "Missouri", "Texas", "Tennessee", "Oklahoma State", "Oklahoma", "Texas Tech", "Oklahoma", "Baylor", "Texas Tech", "Texas", "Missouri", "Miami", "TCU", "West Virginia", "Oklahoma", "Texas", "Texas A&M", "Oklahoma", "Oklahoma State", "Oklahoma", "Oklahoma", "Texas A&M", "Oklahoma", "Oklahoma", "Stanford", "Utah", "Oklahoma", "Alabama", "Missouri", "Oklahoma", "TCU", "LSU", "Baylor", "Florida State", "Oklahoma State", "Texas A&M", "Missouri", "Texas A&M", "TCU", "Texas A&M", "Oklahoma State", "Texas A&M", "Nebraska", "Oklahoma State", "TCU", "Kansas", "Stanford", "Tulsa", "Kansas", "Colorado State", "Texas Tech", "Nebraska", "Oklahoma", "Houston", "Houston", "Tulsa", "Oklahoma State", "Missouri", "Texas A&M", "Utah", "Nebraska", "Arkansas", "Texas A&M", "Texas", "LSU", "Kansas", ),
        "2009" => array("LSU", "LSU", "Texas", "Texas", "Texas A&M", "Oklahoma", "Texas", "Texas", "Oklahoma", "Texas", "Oklahoma State", "Texas", "Oklahoma", "Texas", "Auburn", "California", "Texas", "Nebraska", "Texas", "Texas", "Texas", "Texas", "LSU", "Baylor", "LSU", "Arkansas", "TCU", "Tulsa", "Texas Tech", "Texas", "Texas Tech", "Texas A&M", "Texas", "Stanford", "Oklahoma", "Kentucky", "Texas A&M", "Texas Tech", "Texas A&M", "Texas Tech", "Oklahoma", "Nebraska", "Kansas", "Nebraska", "TCU", "TCU", "Baylor", "Arkansas", "Texas", "Auburn", "Texas Tech", "Baylor", "Minnesota", "Texas Tech", "Texas", "Minnesota", "Texas A&M", "Texas", "Oklahoma", "Kansas", "SMU", "TCU", "Texas A&M", "Arkansas", "Texas A&M", "TCU", "Stanford", "Texas A&M", "Texas Tech", "TCU", "Utah", "Auburn", "Texas Tech", "Texas Tech", "Texas A&M", "Houston", "Missouri", "Oklahoma", "Nebraska", "Texas A&M", "Vanderbilt", "Kansas", "Oklahoma", "Nebraska", "Texas A&M", "Baylor", "Miami", "Baylor", "Utah", "Minnesota", "Oklahoma", "Colorado", "Kansas", "Kentucky", "Kansas", "Iowa State", "Missouri", "TCU", "Florida State", ),
        "2008" => array("Oklahoma", "Oklahoma", "Texas", "Oklahoma", "Stanford", "Ohio State", "Michigan", "Texas", "LSU", "Texas", "Texas A&M", "Oklahoma", "UCLA", "Texas", "Texas A&M", "Texas", "Texas", "Texas A&M", "Texas", "Texas A&M", "Oklahoma", "Texas", "Texas", "Michigan", "Texas", "USC", "Florida", "Texas", "Michigan", "Texas", "Florida", "Oklahoma", "Baylor", "Oklahoma", "Alabama", "Oklahoma State", "Minnesota", "Texas A&M", "Oregon", "Oklahoma", "Baylor", "Texas A&M", "Oklahoma", "Texas", "Iowa State", "LSU", "Texas", "Notre Dame", "Nebraska", "Texas", "Nebraska", "Penn State", "Nebraska", "Miami", "Oklahoma State", "Texas A&M", "Oklahoma State", "Missouri", "North Texas", "Oregon State", "Missouri", "Texas Tech", "Louisiana Tech", "LSU", "Nebraska", "Kansas", "Texas A&M", "Oregon", "Minnesota", "Texas A&M", "Houston", "Texas A&M", "LSU", "Baylor", "Ole Miss", "Missouri", "Texas", "Louisville", "Boston College", "Oklahoma", "Tulsa", "Kansas State", "Houston", "Texas Tech", "Oklahoma State", "Texas A&M", "Ball State", "Rice", "Wisconsin", "Baylor", "Texas", "Kansas", "Texas Tech", "Stanford", "Baylor", "Oklahoma State", "Kansas", "Colorado", "Oklahoma State", ),
        "2007" => array("Michigan", "LSU", "Texas", "Texas", "Texas", "Oklahoma State", "Oklahoma State", "Texas", "Texas", "Texas", "Texas", "Maryland", "Texas", "Texas A&M", "Texas", "Texas A&M", "Texas", "LSU", "LSU", "Texas", "Texas", "Texas", "Oklahoma State", "Miami", "Texas", "Oklahoma", "Texas", "Oklahoma", "TCU", "Tennessee", "SMU", "Texas", "Oklahoma", "Texas A&M", "Texas", "Texas", "Arkansas", "Oklahoma", "Nebraska", "TCU", "Arkansas State", "LSU", "Texas", "Arizona", "Miami", "Texas A&M", "California", "Texas", "Missouri", "Michigan", "Oklahoma", "Nebraska", "Texas Tech", "Oklahoma State", "Arizona", "Nebraska", "Minnesota", "Oklahoma", "Alabama", "Missouri", "Texas Tech", "Oklahoma State", "Kansas", "Nebraska", "Baylor", "Texas A&M", "Arizona", "Texas Tech", "Missouri", "Arkansas", "LSU", "Oklahoma State", "Kansas State", "Baylor", "Michigan State", "Texas Tech", "TCU", "Texas Tech", "Alabama", "Texas A&M", "Nebraska", "Oklahoma State", "Texas A&M", "Iowa", "Kansas", "Houston", "Kansas", "Oklahoma State", "Texas Tech", "Brigham Young", "Tulsa", "Oklahoma State", "Wisconsin", "Texas", "Baylor", "Texas Tech", "Baylor", "Baylor", "Oklahoma State", "Houston", ),
        "2006" => array("Texas", "Georgia", "Texas", "Texas A&M", "Texas", "Texas", "Oklahoma", "USC", "USC", "Florida", "Texas", "Texas", "Texas", "Texas", "Oklahoma State", "Texas A&M", "Oklahoma", "Texas", "Florida", "Texas", "Texas", "Oklahoma", "Texas A&M", "Oklahoma State", "Miami", "Texas Tech", "Oklahoma State", "Oklahoma", "Texas", "Oklahoma", "Oklahoma", "Texas Tech", "Texas", "Arizona", "Miami", "Kansas", "Oklahoma", "Arizona", "Texas A&M", "Oklahoma State", "LSU", "TCU", "Texas", "Texas A&M", "Texas A&M", "Tennessee", "Texas", "Texas", "Alabama", "Florida State", "Texas A&M", "Texas", "Oklahoma", "Iowa", "Georgia Tech", "Texas A&M", "Texas A&M", "Texas Tech", "Texas Tech", "Texas Tech", "LSU", "Arizona", "TCU", "Florida State", "Texas Tech", "Texas Tech", "Oklahoma State", "Texas Tech", "Kansas", "Texas", "Arizona", "Oklahoma State", "Baylor", "Texas A&M", "Oklahoma State", "Oklahoma State", "Texas Tech", "Texas A&M", "Texas", "Texas Tech", "SMU", "Oklahoma", "Texas A&M", "Baylor", "Oklahoma State", "Oklahoma", "Texas A&M", "TCU", "Duke", "Texas Tech", "Arizona State", "Arkansas", "Arizona", "Missouri", "Oklahoma State", "Purdue", "Oklahoma State", "Oklahoma State", "Kansas", "Kansas", ),
        "2005" => array("Oklahoma", "Miami", "Texas A&M", "Texas", "Miami", "Texas", "Oklahoma", "Oklahoma", "Texas", "Texas A&M", "Texas A&M", "Duke", "LSU", "Texas", "Texas", "Florida State", "Kansas State", "Texas A&M", "Kansas", "Texas A&M", "Florida", "Texas", "Texas A&M", "Arkansas", "Texas A&M", "Texas A&M", "Texas Tech", "Texas A&M", "LSU", "Texas A&M", "Texas", "Kansas State", "Texas", "Texas Tech", "Iowa", "Texas Tech", "TCU", "TCU", "Arkansas", "Missouri", "Florida", "Tulsa", "Texas Tech", "LSU", "Texas A&M", "Texas A&M", "Nebraska", "LSU", "Texas", "Oklahoma State", "UCLA", "Arizona", "UCLA", "Oklahoma", "Kansas", "Nebraska", "Texas Tech", "Baylor", "TCU", "Texas", "Texas Tech", "Auburn", "Oklahoma", "Texas", "Notre Dame", "UCLA", "Baylor", "Colorado", "Texas A&M", "Texas Tech", "Oklahoma State", "Kansas", "Nebraska", "Northwestern", "Central Michigan", "Texas Tech", "Oklahoma State", "Oklahoma State", "Duke", "Wisconsin", "Florida State", "TCU", "Kansas State", "Purdue", "Baylor", "Tulane", "Louisiana-Lafayette", "Arizona", "Arizona", "Kansas State", "Baylor", "Arizona", "New Mexico", "Texas A&M", "Iowa State", "SMU", "TCU", "SMU", "Texas Tech", "Texas A&M", ),
        "2004" => array("Oklahoma", "Oklahoma", "Texas", "Miami", "Texas", "Oklahoma State", "Oklahoma", "Texas", "Texas A&M", "LSU", "Texas A&M", "Texas A&M", "Texas", "Miami", "Oklahoma", "Texas", "Texas", "Texas A&M", "Oklahoma State", "Texas A&M", "Texas Tech", "Texas", "Arizona", "Texas A&M", "Texas", "Texas", "Texas", "Oklahoma", "Texas", "Oklahoma State", "Texas Tech", "Texas", "Kansas State", "Kansas", "Miami", "Texas", "Oklahoma State", "Kansas", "Kansas State", "Texas A&M", "North Texas", "Oklahoma", "TCU", "Houston", "Texas", "Arizona", "Texas A&M", "LSU", "Arizona", "Texas A&M", "Oklahoma State", "Tulane", "Arkansas", "Texas A&M", "SMU", "TCU", "Florida", "Oklahoma", "Tulane", "Texas A&M", "Texas", "Texas A&M", "Arkansas", "Arizona State", "Texas", "Oklahoma State", "Texas Tech", "Purdue", "Texas A&M", "Oklahoma State", "Oklahoma", "Texas A&M", "LSU", "Colorado", "Texas A&M", "Northwestern", "Kansas", "North Carolina", "Colorado", "Arkansas", "Tulsa", "Texas Tech", "Arkansas", "TCU", "Nebraska", "Tulane", "Oklahoma", "New Mexico", "Texas", "Oklahoma State", "Oklahoma", "Arkansas", "Texas", "Texas Tech", "Iowa State", "Wisconsin", "Kansas State", "Oregon", "Oklahoma State", ),
        "2003" => array("Brigham Young", "Florida", "Texas A&M", "Oklahoma", "Texas", "Texas A&M", "Oklahoma State", "Texas", "Texas", "LSU", "Texas", "Virginia", "Texas", "Oklahoma", "Texas A&M", "Texas", "Oklahoma", "Texas", "Texas", "Texas", "LSU", "Tulsa", "Miami", "Miami", "Texas", "Oklahoma", "Texas A&M", "Iowa", "Oklahoma", "TCU", "Wisconsin", "Texas", "Texas A&M", "Oklahoma State", "Texas", "Texas Tech", "Louisiana Tech", "Purdue", "Colorado", "Colorado", "Oklahoma", "Purdue", "Texas A&M", "Texas A&M", "SMU", "SMU", "Missouri", "SMU", "SMU", "SMU", "Texas A&M", "SMU", "SMU", "Georgia Tech", "Texas A&M", "LSU", "Texas A&M", "Iowa", "Oklahoma", "Oklahoma State", "Texas A&M", "Oklahoma State", "Iowa State", "Brigham Young", "Arkansas", "Arizona", "Houston", "Texas A&M", "Nebraska", "UCLA", "Colorado", "Arkansas", "Arizona", "Texas A&M", "Oklahoma State", "LSU", "Texas A&M", "Wisconsin", "Baylor", "Texas A&M", "Colorado", "Texas A&M", "Notre Dame", "Arizona", "Colorado", "Texas", "Georgia Tech", "Oklahoma State", "Arizona State", "Arkansas", "Arizona", "Missouri", "Colorado", "Texas A&M", "Arizona", "Houston", "Houston", "Houston", "Texas A&M", "Houston", ),
        "2002" => array("Texas", "Texas", "Texas A&M", "Texas", "Mississippi State", "Miami", "USC", "Texas", "Texas", "Oklahoma", "Oklahoma", "Texas", "Texas", "Texas", "Texas", "Notre Dame", "Arkansas", "Texas", "Texas A&M", "Oklahoma", "Oklahoma", "Texas", "Texas", "Texas A&M", "Oklahoma State", "Colorado", "Tennessee", "Baylor", "Texas", "Oklahoma", "Texas A&M", "Texas", "Texas A&M", "Notre Dame", "Texas A&M", "Arkansas", "Arkansas", "Texas A&M", "Texas", "Arizona", "Arizona", "Baylor", "Georgia", "Texas Tech", "Texas A&M", "Texas A&M", "Texas", "Oklahoma", "Texas A&M", "Texas A&M", "Colorado", "Houston", "TCU", "Oklahoma State", "Oklahoma", "TCU", "Arkansas", "Texas A&M", "Tulsa", "Baylor", "Oklahoma State", "TCU", "Arizona", "Missouri", "Colorado", "Houston", "Louisville", "Texas Tech", "Oklahoma State", "Iowa State", "Colorado", "Texas Tech", "Colorado", "Oklahoma State", "Houston", "Texas A&M", "Houston", "Kansas State", "Georgia Tech", "Texas Tech", "Pittsburgh", "Oklahoma State", "Houston", "Kansas State", "Purdue", "Kansas", "Texas A&M", "Missouri", "Colorado", "Kansas State", "Texas", "Texas", "Arizona", "Texas", "LSU", "Oklahoma State", "Stanford", "Texas A&M", "Texas A&M", ));

$yearsState = array();
?>




<div class="container">
  <div class="col-md-12">
    <div class="panel panel-default panel-success panel-success-custom">
      <div class="panel-heading clearfix text-center">
        <i class="icon-calendar"></i>
        <h3 class="panel-title"></h3>
      </div>
      <div class="panel-body">
        
        
        <div class ="table-responsive" style="clear:both">
      <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th>School</th>
              <th>Year</th>
              <th>Conference</th>
              <th>State</th>
            </tr>
          </thead>
          <tbody>
<?php
     foreach ($yearsArray as $year => $schools)
      {
        
        foreach($schools as $school)
        {
          $conference = "";
          foreach($conferenceArray as $conferenceName => $schoolsInConference)
          {
            if(in_array($school,$schoolsInConference))
            {
              $conference = $conferenceName;
              break;
            }
          }
          
          $state = "";
          
          if(array_key_exists($school,$statesArray))
          {
            $state = $statesArray[$school];
          }
          
          if(!array_key_exists($year,$yearsState))
          {
            $yearsState[$year] = array("Texas" => 0, "OOS" => 0);
          }
          
          if($state=="Texas")
          {
            $yearsState[$year]["Texas"]++;
          }
          else
          {
            $yearsState[$year]["OOS"]++; 
          }
          
         
      
       
?>
      <tr>
      <td><?php echo $year ?></td>
      <td><?php echo $school ?></td>
      <td><?php echo $conference ?></td>
      <td><?php echo $state ?></td>
      </tr>
<?php
        }
        }
?>
          </tbody>
        </table>
                        </div>
                        
                        <div class ="table-responsive" style="clear:both">
      <table id="example" class="table table-hover table-bordered">
          <thead>
            <tr>
              <th>Year</th>
              <th>TX</th>
              <th>OOS</th>
              <th>Sum</th>
              <th>% OOS</th>
            </tr>
          </thead>
          <tbody>
<?php
     foreach ($yearsState as $year => $info)
    {
        
        
       
?>
      <tr>
      <td><?php echo $year ?></td>
      <td><?php echo $info['Texas'] ?></td>
      <td><?php echo $info['OOS'] ?></td>
      <td><?php echo ($info['Texas']+$info['OOS']) ?></td>
      <td><?php echo number_format(100*($info['OOS']/($info['Texas']+$info['OOS'])),1)."%" ?></td>
      </tr>
<?php
        }
?>
          </tbody>
        </table>
                        </div>
        


      </div>
    </div>
  </div>
  <?php
  
  var_dump(print_r($yearsState,true));
?>
<?php include('include/bottom.php');?>