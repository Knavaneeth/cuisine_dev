<?php
define('YII_ENABLE_ERROR_HANDLER', false);
define('YII_ENABLE_EXCEPTION_HANDLER', false);
/* error_reporting(E_ALL);
ini_set("display_errors",true);  */		
// include Yii bootstrap file
require_once(dirname(__FILE__).'/yiiframework/yii.php');
$config=dirname(__FILE__).'/protected/config/main.php';
define('YII_DEBUG', TRUE); 
Yii::createWebApplication($config)->run();
?>