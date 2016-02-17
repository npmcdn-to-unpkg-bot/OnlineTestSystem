<?php
class Permission{
	private $auth;
	private $db;
	private $user;
	private $admin=array(0=>'123');
	function __construct(){
		$this->auth=new Auth();
		$this->db=new DBManager();
		$this->user=new User();
	}
	function isPermitToView($view, $user=null){
		if(($view=='dashboard'||$view=='cat-master')&&$this->auth->isAdmin($user))
			return true;
		else if($view!='dashboard'&&$view!='cat-master')
			return true;
		return false;
	}
	function isPermitToDo($function, $user){
		
	}
}