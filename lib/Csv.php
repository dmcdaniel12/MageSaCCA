<?php
/**
 * @category MageSaCCA
 * @package MageSaCCA_Sale
 * @author Derek McDaniel dmcdaniel12@gmail.com
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0 Public License
 */
class Csv {
    
    public function parseCsv($file){
        return array_map('str_getcsv', file($file));
    }
    
}
