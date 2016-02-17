<?php 
class Paging{
	public $totalItem;
	public $itemPerPage;
	function __construct($totalItem, $itemPerPage){
		$this->itemPerPage=$itemPerPage;
		$this->totalItem=$totalItem;
	}
	function getTotalPage(){
		$pages = ($this->totalItem) / ($this->itemPerPage);
		if ($this->totalItem%$this->itemPerPage>0)
			$pages++;
		return $pages;
	}
	function isItLastPage($page){
		if ($page>=$this->getTotalPage())
			return true;
		return false;
	}
	function isItFirstPage($page){
		if ($page==1)
			return true;
		return false;
	}
	function nextPage($currentPage){
		if ($currentPage<$this->getTotalPage())
			return ++$currentPage;
		return false;
	}
	function prevPage($currentPage){
		if ($currentPage>1)
			return --$currentPage;
		return false;
		
	}
	function getLimits($page){
		if (1<=$page&&$page<=$this->getTotalPage()){
			$lower_limit=($page-1)*$this->itemPerPage;
			$upper_limit=$this->itemPerPage;
			return "$lower_limit , $upper_limit";
		}
		return false;
	}
}