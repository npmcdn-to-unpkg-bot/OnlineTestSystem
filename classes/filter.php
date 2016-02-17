<?php
class Filter{
	static function filterData($data){
		return mysql_real_escape_string($data);
	}
	static function filterInput(){
		if (isset($_REQUEST)&&count($_REQUEST)>0)
			foreach ($_REQUEST as $key=>$val)
				if (!is_array($val))
					$_REQUEST[$key]=Filter::filterData($val);
		if (isset($_POST)&&count($_POST)>0)
			foreach ($_POST as $key=>$val)
				if (!is_array($val))
					$_POST[$key]=Filter::filterData($val);
		if (isset($_GET)&&count($_GET)>0)
			foreach ($_GET as $key=>$val)
				if (!is_array($val))
				$_GET[$key]=Filter::filterData($val);
	}
}
Filter::filterInput();