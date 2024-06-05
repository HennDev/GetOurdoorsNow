<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  	<link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
	<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/jquery.tokenize.js"></script>
	<link rel="stylesheet" type="text/css" href="js/jquery.tokenize.css" />
	<link href="multiple-select.css" rel="stylesheet"/>
	<script src="jquery.multiple.select.js"></script>
	<link href="Site.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="dropdown.css" />
	<script src="us-map-1.0.1//lib/raphael.js"></script>
	<script src="us-map-1.0.1/example/color.jquery.js"></script>
	<script src="us-map-1.0.1/jquery.usmap.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
	    
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- Bootstrap Core CSS -->
    <link href="css/customBootstrap.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
    body {
        padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
    
  </style>
</head>
<body>

<div class="container">
  <h2>Horizontal form: control states</h2>
  <form class="form-horizontal" role="form">
    <div class="form-group">
      <label class="col-sm-2 control-label">Focused</label>
      <div class="col-sm-10">
        <input class="form-control" id="focusedInput" type="text" value="Click to focus...">
      </div>
    </div>
    <div class="form-group">
      <label for="inputPassword" class="col-sm-2 control-label">Disabled</label>
      <div class="col-sm-10">
        <input class="form-control" id="disabledInput" type="text" placeholder="Disabled input here..." disabled>
      </div>
    </div>
    <fieldset disabled>
      <div class="form-group">
        <label for="disabledTextInput" class="col-sm-2 control-label">Disabled input and select list (Fieldset disabled)</label>
        <div class="col-sm-10">
          <input type="text" id="disabledTextInput" class="form-control" placeholder="Disabled input">
        </div>
      </div>
      <div class="form-group">
        <label for="disabledSelect" class="col-sm-2 control-label"></label>
        <div class="col-sm-10">
          <select id="disabledSelect" class="form-control">
            <option>Disabled select</option>
          </select>
        </div>
      </div>
    </fieldset>
    <div class="form-group has-success has-feedback">
      <label class="col-sm-2 control-label" for="inputSuccess">Input with success and glyphicon</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="inputSuccess">
        <span class="glyphicon glyphicon-ok form-control-feedback"></span>
      </div>
    </div>
    <div class="form-group has-warning has-feedback">
      <label class="col-sm-2 control-label" for="inputWarning">Input with warning and glyphicon</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="inputWarning">
        <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
      </div>
    </div>
    <div class="form-group has-error has-feedback">
      <label class="col-sm-2 control-label" for="inputError">Input with error and glyphicon</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="inputError">
        <span class="glyphicon glyphicon-remove form-control-feedback"></span>
      </div>
    </div>
  </form>
  
  
</div>

	<div class="col-md-12 col-sm-6 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <i class="icon-calendar"></i>
          <h3 class="panel-title">Inputs</h3>
        </div>
       
        <div class="panel-body">
          <form class="form-horizontal row-border" action="#">
            <div class="form-group">
              <label class="col-md-2 control-label">Default input field</label>
              <div class="col-md-10">
                <input type="text" name="regular" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">Password</label>
              <div class="col-md-10">
                <input class="form-control" type="password" name="pass">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">With placeholder</label>
              <div class="col-md-10">
                <input class="form-control" type="text" name="placeholder" placeholder="placeholder">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">Disabled field</label>
              <div class="col-md-10">
                <input type="text" name="disabled" disabled="disabled" value="disabled" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">Read only field</label>
              <div class="col-md-10">
                <input class="form-control" type="text" name="readonly" readonly="" value="read only">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">Help text</label>
              <div class="col-md-10">
                <input type="text" name="regular" class="form-control">
                <span class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">Predefined value</label>
              <div class="col-md-10">
                <input type="text" name="regular" value="http://" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">With icon</label>
              <div class="col-md-10">
                <input type="text" name="regular" class="form-control">
                <i class="icon-pencil input-icon"></i>
              </div>
            </div>
            <div class="form-group">
              <label for="labelfor" class="col-md-2 control-label">Clickable label</label>
              <div class="col-md-10">
                <input type="text" name="labelfor" id="labelfor" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">Column sizing</label>
              <div class="col-md-10">
                <div class="row">
                  <div class="col-xs-3">
                    <input type="text" class="form-control" placeholder=".col-xs-3">
                  </div>
                  <div class="col-xs-5">
                    <input type="text" class="form-control" placeholder=".col-xs-5">
                  </div>
                  <div class="col-xs-4">
                    <input type="text" class="form-control" placeholder=".col-xs-4">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group has-success">
              <label class="col-md-2 control-label">Input success</label>
              <div class="col-md-10">
                <input type="text" class="form-control" id="inputSuccess" placeholder="Input Success">
                <i class="icon-pencil input-icon success"></i>
              </div>
            </div>
            <div class="form-group has-warning">
              <label class="col-md-2 control-label">Input warning</label>
              <div class="col-md-10">
                <input type="text" class="form-control" id="inputWarning" placeholder="Input Warning">
                <i class="icon-pencil input-icon warning"></i>
              </div>
            </div>
            <div class="form-group has-error">
              <label class="col-md-2 control-label">Input error</label>
              <div class="col-md-10">
                <input type="text" class="form-control" id="inputError" placeholder="Input Error">
                <i class="icon-pencil input-icon error"></i>
              </div>
            </div>
          </form>
        </div>
      </div>
    
    
</body>
</html>
