<?php
		include($_SERVER['DOCUMENT_ROOT']."/Classes/images.php");

    $guid = "Guid";

    if(!isset($_COOKIE[$guid]))
    {
        setcookie("Guid", getGUID(), time()+60*60*24*30, '/');  /* expire in 30 days */
    }
    else
    {
        //extend cookie
        //setcookie($guid, $_COOKIE[$guid], time()+60*60*24*30, '/');  /* expire in 30 days */
    }

function valid_pass($candidate) {
    if (!preg_match_all('$\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$', $candidate))
        return FALSE;
    return TRUE;
	}
	
	function FormElementCreate($passedLower,$passed, $passedError,$passedValue,$type="text",$otherAttributes = null)
	{
		$thisValue = !empty($passedValue)?$passedValue:'';
		$errorClass = !empty($passedError)?'error':'';
		
		$thisName = !empty($passedLower)?$passedLower:'';
		$output = '<div class="control-group '.$errorClass.'">';
			$output .= '<label class="control-label">'.$passed.'</label> ';
			$output .= '<div class="controls">';
				$output .= '<input '.$otherAttributes.' name="'.$passedLower.'" type="'.$type.'"  placeholder="'.$passed.'" value="'.$passedValue.'">';
				if (!empty($passedError))
				{
					$output .= '<span class="help-inline">'.$passedError.'</span>';
				}
			$output .= '</div>';
		$output .= '</div>';
		return $output;
	}
	
	function FormElementCreate2($passedLower,$passed, $passedError,$passedValue,$type="text",$otherAttributes = null,$labelWidth = 5,$inputWidth = 7)
	{
		$thisValue = !empty($passedValue)?$passedValue:'';
		$errorClass = !empty($passedError)?'has-error':'';
		$thisName = !empty($passedLower)?$passedLower:'';
		
		$output = '<div class="form-group row '. $errorClass.'">';
		$output .= '<label class="col-md-'.$labelWidth.' control-label">'.$passed.'</label>';
		$output .='<div class="col-md-'.$inputWidth.'">';
		$output .= '<input '.$otherAttributes.' name="'.$passedLower.'" type="'.$type.'"  placeholder="'.$passed.'" value="'.$passedValue.'" class="form-control" required>';
		$output .= '</div>';
		
		if (!empty($passedError))
		{
			$output .= '<div class="col-md-12 col-md-offset-2"><label class="control-label" for="inputError">'.$passedError.'</label> </div>';
		}
		
		$output .= '</div>';
		return $output;
	}
	
	
	function FormElementCreateTextArea($passedLower,$passed, $passedError,$passedValue,$type="text",$otherAttributes = null)
	{
		$thisValue = !empty($passedValue)?$passedValue:'';
		$errorClass = !empty($passedError)?'has-error':'';
		$thisName = !empty($passedLower)?$passedLower:'';
		
		$output = '<div class="form-group '. $errorClass.'">';
		$output .= '<label class="col-md-5 control-label">'.$passed.'</label>';
		$output .='<div class="col-md-7">';
		$output .= '<textarea '.$otherAttributes.' name="'.$passedLower.'"  placeholder="'.$passed.'" class="form-control">'.$passedValue.'</textarea>';
		$output .= '</div>';
		
		if (!empty($passedError))
		{
			$output .= '<div class="col-md-12 col-md-offset-2"><label class="control-label" for="inputError">'.$passedError.'</label> </div>';
		}
		
		$output .= '</div>';
		return $output;
	}
	
	
	function FormElementCreateDropdown($passedLower,$passed, $passedError,$passedValue,$type="text",$otherAttributes = null,$values,$key,$value)
	{
		$thisValue = !empty($passedValue)?$passedValue:'';
		$errorClass = !empty($passedError)?'has-error':'';
		$thisName = !empty($passedLower)?$passedLower:'';
		
		$output = '<div class="form-group '. $errorClass.'">';
		$output .= '<label class="col-md-5 control-label">'.$passed.'</label>';
		$output .='<div class="col-md-7">';
		$output .='<select class="form-control" id="'.$passedLower.'" name="'.$passedLower.'">';
		$output .= '<option value="'.$passedValue.'" selected disabled>Please select</option>';
		
		if(!is_null($values))
		{
			foreach ($values as $row) 
			{
				$selected = "";
				if($row[$key] ==$passedValue)
				{
					$selected = "selected";
				}
				$output.= '<option '.$selected.' value='. $row[$key] . '>'.$row[$value].'</option>';
			}
		}
		
		$output .= '</select>';
		$output .= '</div>';
		
		$output .= '<span id='.$thisName.'_loading style="top: 6px!important; display:none;" class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>';
		if (!empty($passedError))
		{
			$output .= '<div class="col-md-12 col-md-offset-2"> <label class="control-label" for="inputError">'.$passedError.'</label> </div>';
		} 
		
		$output .= '</div>';
		return $output;
	}

    function FormElementCreateDropdown2($passedLower,$passed, $passedError,$passedValue,$type="text",$otherAttributes = null,$values,$key,$value)
    {
        $thisValue = !empty($passedValue)?$passedValue:'';
        $errorClass = !empty($passedError)?'has-error':'';
        $thisName = !empty($passedLower)?$passedLower:'';


    $output = '<div class="form-group has-feedback '. $errorClass.'">';
    $output .= '<div class="input-group">';
    $output .= '<span class="input-group-addon" id="basic-addon1">'.$passed.'</span>';


        $output .='<select aria-describedby="basic-addon1" class="form-control '.$otherAttributes.'" id="'.$passedLower.'" name="'.$passedLower.'">';
        $output .= '<option value="'.$passedValue.'" selected disabled>Please select a '.$passed.'</option>';

        if(!is_null($values))
        {
            foreach ($values as $row)
            {
                $selected = "";
                if($row[$key] ==$passedValue)
                {
                    $selected = "selected";
                }
                $output.= '<option '.$selected.' value='. $row[$key] . '>'.$row[$value].'</option>';
            }
        }

        $output .= '</select>';
        $output .= '</div>';

        $output .= '<span id='.$thisName.'_loading style="top: 6px!important; display:none;" class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>';
        if (!empty($passedError))
        {
            $output .= '<div class="col-md-12 col-md-offset-2"> <label class="control-label" for="inputError">'.$passedError.'</label> </div>';
        }

        $output .= '</div>';
        return $output;
    }

    function print_fa_icon($icon,$size,$amount,$color=null)
    {
        $style = "";

        if($color != null) {
            $style = "color:$color;";
        }

        for($i = 0; $i<$amount; $i++)
        {
            echo '<i style="' . $style . '" class="fa ' . $icon . ' fa-' . $size . 'x "></i>';
        }
    }

function getGUID($include_braces = false) {
    if (function_exists('com_create_guid')) {
        if ($include_braces === true) {
            return com_create_guid();
        } else {
            return substr(com_create_guid(), 1, 36);
        }
    } else {
        mt_srand((double) microtime() * 10000);
        $charid = strtoupper(md5(uniqid(rand(), true)));

        $guid = substr($charid,  0, 8) . '-' .
            substr($charid,  8, 4) . '-' .
            substr($charid, 12, 4) . '-' .
            substr($charid, 16, 4) . '-' .
            substr($charid, 20, 12);

        if ($include_braces) {
            $guid = '{' . $guid . '}';
        }

        return $guid;
    }
}
?>