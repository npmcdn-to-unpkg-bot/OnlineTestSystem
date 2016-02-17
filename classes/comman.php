<?php
class Comman{
	public static function getUrlByDirectoryPath($path){
		$config=new Config();
		return urldecode(str_replace(root, $config->site_address, $path));
	}
	public static function getController($controller){
		$config=new Config();
		return $config->site_address."controllers/$controller.php";
	}
	public static function loadView($view, $user=null, $data=null){
		$per=new Permission();
		$result=null;
		if ($per->isPermitToView($view,$user)){
			if ($data!=null&&is_array($data))
				foreach ($data as $key=>$value)
					${$key}=$value;
		}else
			$view='login';
		ob_start();
		include root.DS.'views'.DS.$view.'.php';
		$result=ob_get_contents();
		ob_end_clean();
		return $result;
	}
	public static function loadModule($module, $data=null){
		if ($data!=null&&is_array($data))
			foreach ($data as $key=>$value)
			${$key}=$value;
		if(is_file(root.DS.'modules'.DS.$module.'.php'))
			include root.DS.'modules'.DS.$module.'.php';
		else
			include root.DS.'views'.DS.Module::getModule($module).'.php';
	}
	public static function isConfig($mod,$name){
		$db=new DBManager();
		$table='core_conf';
		return $db->isExist($table, 'id', "name='$name' AND module='$mod'");
	}
	public static function createConfig($mod,$name,$value=null){
		$db=new DBManager();
		$table='core_conf';
		if(Comman::isConfig($mod, $name))
			return false;
		$columns=array(0=>'module',
				1=>'name');
		$data=array(0=>$mod,
				1=>$name);
		if ($value==null)
			return $db->insertData($table, $columns, $data);
		return $db->insertData($table, $columns, $data) && Comman::setConfig($mod, $name, $value);
	}
	public static function getConfig($mod,$name){
		$db=new DBManager();
		$table='core_conf';
		if(Comman::isConfig($mod, $name))
			return $db->getSingleData($table, 'value', "module='$mod' AND name='$name'");
		return null;
	}
	public static function setConfig($mod,$name,$value){
		$db=new DBManager();
		$table='core_conf';
		if(!Comman::isConfig($mod, $name))
			return Comman::createConfig($mod, $name, $value);
		return $db->updateSingleColumn($table, 'value', $value, "module='$mod' AND name='$name'");
	}
	public static function convertArrayToSingle($arr,$key){
		$result=array();
		$i=0;
		foreach ($arr as $value)
			$result[$i++]=$value[$key];
		return $result;
	}
	public static function createArrayFromKeys($array,$keys){
		$result=array();
		if (count($keys)<1)
			return $result;
		else if (!is_array($keys))
			return array($array[$keys]);
		foreach ($keys as $key)
			if (isset($array[$key]))
				$result[]=$array[$key];
		return $result;
	}
	public static function getPercentage($base,$needle){
		return round(($needle/$base)*100,2);
	}
}