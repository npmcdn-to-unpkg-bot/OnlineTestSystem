<?php
class Config{
	public $site_name="PSITCoe CS/IT Exam System";
	public $db_host="localhost";
	public $db_user="root";
	public $db_pass="52665266";
	public $db_name="OES";
	public $tbl_pre="";
	public $site_address;
	public $session_salt="kgsTygv8Gvgjjygllkabkjkuhsslghg_";
	
	/* URL Scheme */
	
	public $url_scheme="parameter";
	
	function __construct(){
		$this->site_address="http://{$_SERVER['HTTP_HOST']}/A0WebRoot/OnlineTestSystem/";
	}
}
ini_set('max_execution_time', 0);
date_default_timezone_set("Asia/Kolkata");
session_start();
if (!isset($_SESSION['msg'])||empty($_SESSION['msg']))
	$_SESSION['msg']="";
?>