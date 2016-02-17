<?php
class Module{
	private $moduleRegister = array('index' => array('index'),
			'home' => array('home'),
			'login' => array('login'),
			'dashboard' => array('dashboard','auth'),
			'admin-home' => array('admin-home','admin'),
			'manage-students' => array('manage-students','admin'),
			'manage-exams' => array('manage-exams','admin'),
			'manage-courses' => array('manage-courses','admin'),
			'manage-question' => array('manage-question', 'admin'),
			'add-question' => array('add-question', 'admin'));
	public static function getModule($module){
		$auth = new Auth();
		$mod = new Module();
		$url = new URL();
		if($url->getRequestedFunction() == 'angular') {
			if (!isset($mod->moduleRegister[$module]))
				return 'error';
			else if(!$auth->isAdmin()&&(isset($mod->moduleRegister[$module][1]) && $mod->moduleRegister[$module][1] == 'admin'))
				return 'login';
		}else {
			if (!isset($mod->moduleRegister[$module]))
				return 'error';
			else if(!isset($mod->moduleRegister[$module][1]))
				return 'index';
			else if(!$auth->isAdmin() && isset($mod->moduleRegister[$module][1]) && $mod->moduleRegister[$module][1] == 'admin')
				if($auth->isItAuthUser())
					return 'error';
				else
					return 'index';
			else if($auth->isItAuthUser()&&(isset($mod->moduleRegister[$module][1]) && ($mod->moduleRegister[$module][1] == 'auth' || $mod->moduleRegister[$module][1] == 'admin')))
				return 'dashboard';
			}
		return $mod->moduleRegister[$module][0];
	}
}