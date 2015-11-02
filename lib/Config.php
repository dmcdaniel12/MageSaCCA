<?php
/**
 * @category MageSaCCA
 * @package MageSaCCA_Sale
 * @author Derek McDaniel dmcdaniel12@gmail.com
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0 Public License
 */
class Config {
    
    // TODO Add in cleareance/sale cateogry variables
    private $saleBaseCat = 215;
    private $clearanceBaseCat = 498;
    private $csvFileConversion = "csv/category.csv";
    private $clearanceAmount = .5;
    private $saleCats = array();
    private $baseCategoryIds = array();
    private $saleCatId = array();
    private $baseCatToSalesCat;
    private $insertType = array("Mysql", "Rapidflow","Api"); 
    // 0 is array, 1 is csv
    private $parseType = 0;
    
    public function getBaseCatToSalesCat() {
        return $this->baseCatToSalesCat;
    }

    public function setBaseCatToSalesCat($baseCatToSalesCat) {
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
    
    public function getSaleBaseCat() {
        return $this->saleBaseCat;
    }

    public function getClearanceBaseCat() {
        return $this->clearanceBaseCat;
    }

    public function setSaleBaseCat($saleBaseCat) {
        $this->saleBaseCat = $saleBaseCat;
    }

    public function setClearanceBaseCat($clearanceBaseCat) {
        $this->clearanceBaseCat = $clearanceBaseCat;
    }
    
}
