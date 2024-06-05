<html>
  <head>
    <link href="/css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
	<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  </head>
  <body>
    <select multiple="multiple" id="my-select" name="my-select[]">
      <option value='elem_1'>elem 1</option>
      <option value='elem_2'>elem 2</option>
      <option value='elem_3'>elem 3</option>
      <option value='elem_4'>elem 4</option>
      ...
      <option value='elem_100'>elem 100</option>
    </select>
      <script src="/js/jquery.multi-select.js" type="text/javascript"></script>
      <script> $('#my-select').multiSelect();</script>
  </body>
</html>