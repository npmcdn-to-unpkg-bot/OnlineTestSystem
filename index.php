<?php
include 'core/includes.php';
$url=new URL();
$mod=$url->getRequestedModule();
Comman::loadModule($url->getRequestedModule(), $_REQUEST);
Message::getMessage();
?>