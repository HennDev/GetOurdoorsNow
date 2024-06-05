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
</script>
<?php
include($_SERVER['DOCUMENT_ROOT'] .'/include/top_end.php');
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