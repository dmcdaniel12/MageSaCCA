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
    
    public function parseSalesCatConvCsv($file){
        $conversions = $this->parseCsv($file);
        $baseCatConv = array();
        foreach($conversions as $conv){
            $baseCatConv[] = array($conv[0], $conv[1]);
        }
        return $baseCatConv;
    }
    
    public function parseNewArrivalsCatConvCsv($file){
        $conversions = $this->parseCsv($file);
        $baseCatConv = array();
        foreach($conversions as $conv){
            $baseCatConv[] = array($conv[0] , $conv[2]);
        }
        return $baseCatConv;
    }
    
    public function getSaleCategoriesFromCsv($file, $config){
        $conversions = $this->parseCsv($file);
        $saleIds = array($config->getSaleBaseCat(), $config->getClearanceBaseCat());
        
        foreach($conversions as $con){
            if(!in_array($con[1], $saleIds)){
                $saleIds[] = (int) $con[1];
            }
        }

        return $saleIds;
    }
    
}
