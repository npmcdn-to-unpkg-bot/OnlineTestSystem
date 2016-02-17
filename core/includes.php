<?php
include __DIR__.DIRECTORY_SEPARATOR.'config.php';
include __DIR__.DIRECTORY_SEPARATOR.'define.php';

foreach (glob(libs.DS."*.php") as $file)
	include $file;
foreach (glob(classes.DS."*.php") as $file)
	include $file;
?>