<?php
	
	
	session_start();
	$title = "Get Outdoors Now";
	include($_SERVER['DOCUMENT_ROOT'] ."/database.php");
	include($_SERVER['DOCUMENT_ROOT'] ."/common.php");
	$error = "";
	include($_SERVER['DOCUMENT_ROOT'] .'/include/top_start.php');
	$success = false;
?>
<style type="text/css">
	.container {
		width: 1920px;
}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		
	} );
	
	
var last5 = 0.9836;
var last4 = 0.8902;
$( ".content-list" ).children('li').each(function( index ) {
   if(index > 1)
   {   
    var score = $( this ).find('.score').html();
	
    if(score>=last5)
    {
    	stars = 5;
    }
    else if(score>=last4)
    {
    	stars = 4;
    }
	else
    {
		stars = 3;
    }
     
	if(stars==5 || stars ==4)
    {
		var locationElem =  $( this ).find('.meta').html();
		var leftParen = locationElem.split("(");
		var rightParen = leftParen[1].split(")");

  		console.log(" NAME:"+ $( this ).find('img').attr("title")+  " Location:"+ rightParen[0]+ " SCORE:"+ $( this ).find('.score').html()+ " stars:"+ stars);
		// + "\n\n\n" + index + ": " + $( this ).text());
    }
   }
});

</script>
<?php
include($_SERVER['DOCUMENT_ROOT'] .'/include/top_end.php');

$doc = new DOMDocument();
libxml_use_internal_errors(true);
$doc->loadHTMLFile("test.html");
//echo $doc->saveHTML();

$finder = new DomXPath($doc);
$classname="content-list";
$elements = $finder->query("//*[contains(@class, '$classname')]");

if (!is_null($elements)) {
  foreach ($elements as $element) {
   // echo "[". $element->nodeName. "]";

    $nodes = $element->childNodes;
    foreach ($nodes as $node) {
      echo "<br><br><br><br>".$node->nodeValue. "\n";
    }
  }
}

?>
<div class="container">
	<div class="col-md-12">
		<div class="panel panel-default panel-success panel-success-custom">
			<div class="panel-heading clearfix text-center">
				<h3 class="panel-title"></h3>
			</div>
			<div class="panel-body">
		</div>
	</div>
</div>
</div>
<?php
	include($_SERVER['DOCUMENT_ROOT'] .'/include/bottom.php');
?>