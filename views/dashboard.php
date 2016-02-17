<?php
$auth = new Auth();
$config = new Config();
if($auth->isAdmin())
	echo Comman::loadView('admin-dashboard');
else if($auth->isItAuthUser())
	echo Comman::loadView('student-dashboard');
else
	header("location:".$config->site_address."login");