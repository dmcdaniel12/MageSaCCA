<?php
/**
 * @category Rods
 * @package Rods_Sale
 * @author Derek McDaniel derek@rods.com
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0 Public License
 */

include_once 'lib/Mysql.php';
include_once 'lib/Config.php';
include_once 'lib/Magento.php';
include_once 'lib/Rapidflow.php';

// TODO move this to config
error_reporting(0);
set_time_limit(0);

// TODO - Add more configuration parameters here
$config = new Config();

// InsertType 0 = SQL, 1 = CSV Export, 2 = Magento API
$type = $config->getInsertType(0);
$newType = new $type();

// TODO - Add in Magento code to do this via the API in small batch increments
$magento = new Magento();
$magento->clearCategory($newType, $config);
$magento->runClearanceProductUpdates($newType, $config);
$magento->runSaleProductUpdates($newType, $config);
$magento->complete();
