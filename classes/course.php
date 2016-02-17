<?php
class Course {
	private $db;
	private $table = "courses";
	function __construct(){
		$this->db = new DBManager();
	}
	function isCourse($id){
		return $this->db->isExist($this->table, 'id', "id='$id'");
	}
	function create($name){
		return $this->db->insertData($this->table, array('course_name'), array($name));
	}
	function update($id, $name){
		return $this->db->updateSingleColumn($this->table, 'course_name', $name, "id='$id'");
	}
	function delete($id){
		$qb = new QuestionBank();
		return $qb->deleteQBByCourseId($id) && $this->db->deleteRow($this->table, "id='$id'");
	}
	function getList($data = array()){
		return $this->db->getDataGrid($this->table, $data);
	}
	function getInfo($id, $info){
		if($this->isCourse($id))
			return $this->db->getSingleData($this->table, $info, "id='$id'");
		return false;
	}
}