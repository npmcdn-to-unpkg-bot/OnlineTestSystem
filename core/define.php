<?php
/**
 * @author janruls1
 * @file config.php
 * @date 10/11/2014
 */
// Global Constants
define('DS', DIRECTORY_SEPARATOR);
define('root', realpath(__DIR__.DS.".."));
define('core', root.DS."core");
define('classes', root.DS."classes");
define('libs', root.DS."libs");
define('static_dir', root.DS."static");
$config = new Config();
define('assets', $config->site_address."assets/");
?>