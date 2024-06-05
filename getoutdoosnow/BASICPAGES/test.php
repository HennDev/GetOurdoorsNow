<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title>Home</title>
    <link href="Site.css" rel="stylesheet" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <link href="multiple-select.css" rel="stylesheet"/>
  <script src="jquery.multiple.select.js"></script>
  
<script type="text/javascript">
		
  $(function() {


});
  
  function recp(id) {
  $('#myStyle').load('data.php?id=' + id);
}

  </script>
  

         

</head>




<body class='bodyclass'>

 <a href="#" onClick="recp('1')" > One   </a>
<a href="#" onClick="recp('2')" > Two   </a>
<a href="#" onClick="recp('3')" > Three </a>

<div id='myStyle'>
</div>

</body>
</html>
