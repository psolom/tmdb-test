<?php

// change the following paths if necessary
$yii = dirname(__FILE__) . '/protected/yii.php';
$autoload = dirname(__FILE__) . '/protected/vendor/autoload.php';
$config = dirname(__FILE__) . '/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

// include Yii
require_once($yii);

// include composer's autoloader
require_once($autoload);

require_once(dirname(__FILE__).'/protected/components/system/WebApplication.php');
Yii::createApplication('WebApplication', $config)->run();