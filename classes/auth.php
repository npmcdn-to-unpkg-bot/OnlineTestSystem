<?php
class Auth{
	private $user;
	private $config;
	private $db;
	function __construct(){
		$this->config=new Config();
		$this->db=new DBManager();
		$this->user=new User();
	}
	function checkAdmin($user, $pass, $login=false){
		$result=$this->db->isExist('admin', 'id', "user='$user' AND pass='$pass'");
		if ($result==true && $login==true)
			$this->letHimGainAccess($user, 'admin');
		return $result;
	}
	public function letHimGainAccess($user, $role = null){
		$_SESSION[$this->config->session_salt."user"]=$user;
		if($role == null)
			$role = 'student';
		$_SESSION[$this->config->session_salt."role"] = $role;
	}
	public function isItAuthUser($user=null){
		if ($user==null)
			$user=$this->getCurrentUser();
		if (isset($_SESSION[$this->config->session_salt."user"])&&$_SESSION[$this->config->session_salt."user"]==$user&&$this->user->isUser($user))
			return true;
		return false;
	}
	public function getCurrentUser(){
		if (isset($_SESSION[$this->config->session_salt."user"])){
			return str_replace($this->config->session_salt, "", $_SESSION[$this->config->session_salt."user"]);
		}
		return false;
	}
	public function isAdmin($user=null){
		if ($user==null)
			$user=$this->getCurrentUser();
		if (!$user)
			return false;
		if($this->db->isExist('admin', 'id', "user='$user'"))
			return true;
		return false;
	}
}
?>