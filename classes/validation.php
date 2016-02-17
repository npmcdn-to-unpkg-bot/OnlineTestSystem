<?php 
class Validation{
	public static function isNull($var){
		if (!is_array($var)){
			if (isset($var)&&!empty($var))
				return false;
			return true;
		}else{
			if (isset($var[0])&&!empty($var))
				return false;
			return true;
		}
		return false;
	}
	public static function isEmail($var){
		if (Validation::isNull($var))
			return false;
		if (filter_var($var, FILTER_VALIDATE_EMAIL))
			return true;
		return false;
	}
	public static function isURL($var){
		if (Validation::isNull($var))
			return false;
		if (filter_var($var, FILTER_VALIDATE_URL))
			return true;
		return false;
	}
}
?>