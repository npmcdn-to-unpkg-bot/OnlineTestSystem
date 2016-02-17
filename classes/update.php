<?php
class Update{
	public static function lastUpdate(){
		$config = new Config();
		$handle = fopen(root.DS."updates.txt", "r");
		if ($handle) {
			while (($line = fgets($handle)) !== false) {
				$str = str_replace("###&nbsp;&nbsp;", "", $line);
				break;
			}
		
			fclose($handle);
			return "<a href='".$config->site_address."changelog?date=$str' target='_blank'>".$str."</a>";
		} else {
			// error opening the file.
		}
	}
	public static function getUpdate($date){
		$parse = new Parsedown();
		return $parse->text(file_get_contents(root.DS."updates.txt"));
	}
}