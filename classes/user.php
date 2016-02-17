<?php
class User{
	private $user;
	private $db;
	function __construct(){
		$this->db=new DBManager();
	}
	function setUser($user){
		$this->user=$user;
	}
	function getUserInfo($info, $user=null){
		if($user==null)
			$user=$this->user;
		return $this->db->getSingleData('users', $info, "id='$user'");
	}
	function getUserRole($user=null){
		if($user==null)
			$user=$this->user;
		$this->getUserInfo('role', $user);
	}
	function isUser($user=null){
		if($user==null)
			$user=$this->user;
		return $this->db->isExist('users', 'id', "id='$user'");
	}
	function changePass($user, $pass){
		return $this->db->updateSingleColumn('users', 'pass', $pass, "id='$user'");
	}
	function makeUser($user){
		return $this->db->insertData('users', array('id','role'), array($user,'student'));
	}
	function updateUserInfo($user, $info){
		$columns = array();
		$data = array();
		foreach ($info as $key => $value){
			$columns[] = $key;
			$data[] = $value;
		}
		return $this->db->updateMultipleColumn('users', $columns, $data, "id = '$user'");
	}
	function getUsers($info, $role = 'all'){
		if($role == 'all')
			return $this->db->getDataGrid('users', $info);
		else
			return $this->db->getDataGrid('users', $info, "role = '$role'");
	}
}