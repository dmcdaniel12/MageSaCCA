<?php
/**
 * @category MageSaCCA
 * @package MageSaCCA_Sale
 * @author Derek McDaniel dmcdaniel12@gmail.com
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0 Public License
 */

include_once 'lib/Mysql.php';
include_once 'lib/Config.php';
include_once 'lib/Magento.php';
include_once 'lib/Rapidflow.php';
include_once 'lib/Csv.php';

// TODO move this to config
error_reporting(0);
set_time_limit(0);

// TODO: setup csv file that it uses to go to 1 to 1 with

// Can add any number of configuration params here to change the default configuration
$config = new Config();
// This sets the parse type to CSV instead of from a category config section
$config->setParseType(1);

if($config->getParseType() == 1){
    $csv = new Csv();
    $parser = $csv->parseCsv($config->getCsvFileConversion());
    $config->setBaseCatToSalesCat($parser);
}

// InsertType 0 = SQL, 1 = CSV Export, 2 = Magento API
$type = $config->getInsertType(0);
$newType = new $type();

// TODO - Add in Magento code to do this via the API in small batch increments
$magento = new Magento();
$magento->clearCategory($newType, $config);
$magento->runClearanceProductUpdates($newType, $config);
$magento->runSaleProductUpdates($newType, $config);
$magento->complete($newType);
