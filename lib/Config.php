<?php
/**
 * @category Rods
 * @package Rods_Sale
 * @author Derek McDaniel derek@rods.com
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0 Public License
 */
class Config {
    
    // TODO Add in cleareance/sale cateogry variables
    
    // TODO setup read from CSV
    private $csvFileConversion = "csv/category.csv";
    // Default is .5 but can be changed. 
    private $clearanceAmount = .5;
    // Remove this and have it set to $saleCatId instead
    private $saleCats = array(215,498,525,526,527,528,529,533,530,531,532);
    private $baseCategoryIds = array("womens" => 209, "mens" => 206, "kids" => 216, "boots" => 212, 
    "hats" => 213, "work" => 744, "accessories" => 208, "bedding" => 211, "home" => 214, "tack" => 210);
    private $saleCatId = array("womens" => 525, "mens" => 526,
        "kids" => 527, "boots" => 528, "accessories" => 529, "hats" => 533, "bedding" => 530,
        "home" => 531, "tack" => 532);
    private $baseCatToSalesCat;
    private $insertType = array("Mysql", "Rapidflow","Api"); 
    // 0 is array, 1 is csv
    private $parseType = 0;
    
    function getBaseCatToSalesCat() {
        return $this->baseCatToSalesCat;
    }

    function setBaseCatToSalesCat($baseCatToSalesCat) {
        $this->baseCatToSalesCat = $baseCatToSalesCat;
    }   
    
    public function getParseType() {
        return $this->parseType;
    }

    public function setParseType($parseType) {
        $this->parseType = $parseType;
    }
  
    public function getCsvFileConversion() {
        return $this->csvFileConversion;
    }

    public function setCsvFileConversion($csvFileConversion) {
        $this->csvFileConversion = $csvFileConversion;
    }
    
    public function getClearanceAmount() {
        return $this->clearanceAmount;
    }

    public function setClearanceAmount($clearanceAmount) {
        $this->clearanceAmount = $clearanceAmount;
    }

    public function getSaleCats() {
        return $this->saleCats;
    }

    public function setSaleCats($saleCats) {
        $this->saleCats = $saleCats;
    }
    
    public function getBaseCategoryIds() {
        return $this->baseCategoryIds;
    }

    public function getSaleCatId() {
        return $this->saleCatId;
    }

    public function setBaseCategoryIds($baseCategoryIds) {
        $this->baseCategoryIds = $baseCategoryIds;
    }

    public function setSaleCatId($saleCatId) {
        $this->saleCatId = $saleCatId;
    }

    public function getInsertType($area) {
        return $this->insertType[$area];
    }
    // Default is 0 = SQL, 1 = Export to CSV for rapidflow, 2 = Magento API
    public function setInsertType($insertType) {
        $this->insertType = $insertType;
    }
    
}
