<?php 
class Menu{
	private $adminMenu=array(0=>array('Dashboard','dashboard','fa fa-dashboard'),
			//1=>array('Sliders','sliders','fa fa-rocket'),
			//2=>array('News, Events, Media & Speech','newsadmin','fa fa-newspaper-o'),
			3=>array('Gallery','gallery-admin','fa fa-photo'),
			4=>array('Team','team-admin','fa fa-users'),
			5=>array('Plans &amp; Pricing','plans-admin','fa fa-cubes'),
			6=>array('FAQ','faq-admin','fa fa-question-circle'),
			7=>array('Clients','client-admin','fa fa-users'),
			8=>array('Settings','settings','fa fa-cogs'));
	private $userMenu=array();
	function getAdminMenu(){
		return $this->adminMenu;
	}
	function getUserMenu(){
		return $this->userMenu;
	}
}
?>