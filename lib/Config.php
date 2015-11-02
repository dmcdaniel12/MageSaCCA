<?php
/**
 * @category Rods
 * @package Rods_Sale
 * @author Derek McDaniel derek@rods.com
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0 Public License
 */
class Config {
    
    private $saleCats = array(215,498,525,526,527,528,529,533,530,531,532);
    
    private $baseCategoryIds = array("womens" => 209, "mens" => 206, "kids" => 216, "boots" => 212, 
    "hats" => 213, "work" => 744, "accessories" => 208, "bedding" => 211, "home" => 214, "tack" => 210);
    
    private $saleCatId = array("womens" => 525, "mens" => 526,
        "kids" => 527, "boots" => 528, "accessories" => 529, "hats" => 533, "bedding" => 530,
        "home" => 531, "tack" => 532);
    
    private $insertType = array("Mysql", "Rapidflow","Api");    
    
    function getSaleCats() {
        return $this->saleCats;
    }

    function setSaleCats($saleCats) {
        $this->saleCats = $saleCats;
    }
    
    function getBaseCategoryIds() {
        return $this->baseCategoryIds;
    }

    function getSaleCatId() {
        return $this->saleCatId;
    }

    function setBaseCategoryIds($baseCategoryIds) {
        $this->baseCategoryIds = $baseCategoryIds;
    }

    function setSaleCatId($saleCatId) {
        $this->saleCatId = $saleCatId;
    }

    function getInsertType($area) {
        return $this->insertType[$area];
    }
    // Default is 1 = SQL, 2 = Export to CSV for rapidflow, 3 = Magento API
    function setInsertType($insertType) {
        $this->insertType = $insertType;
    }
    
}
