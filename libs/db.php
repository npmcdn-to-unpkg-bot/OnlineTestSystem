<?php
class DBManager{
	private $con;
	private $pre;
	function __construct(){
		$config=new Config();
		$this->con=mysql_connect($config->db_host, $config->db_user, $config->db_pass);
		mysql_select_db($config->db_name,$this->con);
		$this->pre=$config->tbl_pre;
		$now = new DateTime();
		$mins = $now->getOffset() / 60;
		$sgn = ($mins < 0 ? -1 : 1);
		$mins = abs($mins);
		$hrs = floor($mins / 60);
		$mins -= $hrs * 60;
		$offset = sprintf('%+d:%02d', $hrs*$sgn, $mins);
		mysql_query("SET time_zone='$offset'",$this->con);
	}
	function customQuery($query){
		return mysql_query($query, $this->con);
	}
	function isExist($table, $column, $where=null){
		if($where!=null)
			$where=" WHERE ".$where;
		if(!mysql_query("SELECT $column FROM `$this->pre$table` $where",$this->con))
			return false;
		$row=mysql_fetch_array(mysql_query("SELECT $column FROM `$this->pre$table` $where",$this->con));
		if(isset($row[$column])||!empty($row[$column])||$row[$column]!="")
			return true;
		return false;
	}
	function getSingleData($table, $column, $where=null){
		if($where!=null)
			$where=" WHERE ".$where;
		$row=mysql_fetch_array(mysql_query("SELECT $column FROM `$this->pre$table` $where",$this->con));
		return stripslashes($row[$column]);
	}
	function getDataGrid($table, $columns, $where=null){
		$result=array();
		$i=0;
		if($where!=null)
			$where=" WHERE ".$where;
		$query=mysql_query("SELECT * FROM `$this->pre$table` $where",$this->con);
		//echo "SELECT * FROM `$this->pre$table` $where";
		while($row=mysql_fetch_array($query)){
			foreach ($columns as $column)
				$result[$i][$column]=stripslashes($row[$column]);
			$i++;
		}
		return $result;
	}
	function insertData($table, $columns, $data){
		$column=implode(',', $columns);
		for ($i=0;$i<count($data);$i++)
			$data[$i]=Filter::filterData($data[$i]);
		$data="'".implode("','", $data)."'";
		return mysql_query("INSERT INTO $this->pre$table($column)VALUES($data)",$this->con);
	}
	function updateSingleColumn($table, $column, $value, $where=null){
		if($where!=null)
			$where=" WHERE ".$where;
		return mysql_query("UPDATE $this->pre$table SET $column = '".Filter::filterData($value)."' $where",$this->con);
	}
	function updateMultipleColumn($table, $columns, $values, $where=null){
		if($where!=null)
			$where=" WHERE ".$where;
		$data="";
		$i=0;
		foreach ($columns as $column){
			$data.="$column='".Filter::filterData($values[$i])."',";
			$i++;
		}
		$data=substr($data, 0, strlen($data)-1);
		return mysql_query("UPDATE $this->pre$table SET $data $where",$this->con);
	}
	function deleteRow($table, $where=null){
		if($where!=null)
			$where=" WHERE ".$where;
		return mysql_query("DELETE FROM $this->pre$table $where",$this->con);
	}
}
?>