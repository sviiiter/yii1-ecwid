<?php
/**
 * Codeigniter + Yii application bootstrap file.
 */
$scriptDir = dirname(__FILE__);
defined('YII_DEBUG') or define('YII_DEBUG', true);

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

// change the following paths if necessary vendor/codeception/yii-bridge/yiit.php vendor/codeception/yii-bridge/yiit.php
require_once($scriptDir . '/../vendor/yiisoft/yii/framework/yii.php');
require_once($scriptDir . '/../vendor/codeception/yii-bridge/yiit.php');

// merge main config
//$config = CMap::mergeArray([], require($scriptDir . './../config/main.php'));
$config = [];
// merge test-specific config
$config = CMap::mergeArray($config, require($scriptDir . './../config/test.php'));

return array(
  'class' => 'CWebApplication',
  'config' => $config,
);

