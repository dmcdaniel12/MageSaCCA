<?php

/**
 * TODO: Add in Column Headers
 * TODO: Add in column header setters/getters
 * TODO: Export to CSV File
 * TODO: Add in Global Variable DS (Directory_Structure)
 * TODO: Add in Variable for file location instead of hard coded
 * TODO: Add in code to automatically run RapidFlow code
 * TODO: Add in CSV Library to remove code from the RapidFlow Library code section
 */
/**
 * @category Rods
 * @package Rods_Sale
 * @author Derek McDaniel derek@rods.com
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0 Public License
 */
include_once 'Functionality.php';

class Rapidflow {

    private $columnHeaders = array("sku", "category.ids");

    // this will automatically set the headers
    public function __construct(){
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=data.csv');
        $output = fopen('php://output', 'w');
        
        $this->createColumnHeaders($output);   
    }
    
    // Format should be the following: 
    // sku,category.ids
    // currently getting productId and not SKU - Should be getting SKU
    public function insertCat($categoryId, $productId, $position, $sku) {
        $csvData = array($sku, $categoryId);
        $output = fopen('php://output', 'w');
        fputcsv($output, $csvData);
    }

    public function deleteQuery() {
        
    }

    function getColumnHeaders() {
        return $this->columnHeaders;
    }

    function setColumnHeaders($columnHeaders) {
        $this->columnHeaders = $columnHeaders;
    }

    public function createColumnHeaders($output) {
        fputcsv($output, $this->getColumnHeaders());
    }
    
    public function complete(){
        
    }

}
