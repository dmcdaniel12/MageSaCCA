<?php
/**
 * @category Rods
 * @package Rods_Sale
 * @author Derek McDaniel derek@rods.com
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0 Public License
 */
include_once 'Functionality.php';

class Magento extends Functionality{

    // TODO add in code to automatically clear the categories first
    public function clearCategory($type, $config) {
        $categories = $config->getSaleCats();
        foreach ($categories as $cat) {
            $type->deleteQuery($cat);
        }
    }

    //@TODO add in reindex method here - Needs to have API code in order to work properly
    // or possible location of shell script
    public function reindex() {
        
    }

    public function runClearanceProductUpdates($type, $config) {
        $mysql = new Mysql();
        $clearanceProducts = $mysql->selectClearanceQuery();
        
        foreach ($clearanceProducts as $cp) {
            $this->setClearanceCat($type, $cp, $config);
        }
    }

    public function runSaleProductUpdates($type, $config) {
        $mysql = new Mysql();
        $saleProducts = $mysql->selectSalesQuery("SELECT * FROM catalog_product_flat_1 WHERE special_price < price");
        foreach ($saleProducts as $sp) {
            if(isset($sp)){
                $this->setSaleCat($type, $sp, $config->getBaseCategoryIds(), $config->getSaleCatId());
            }
        }
    }

    public function setClearanceCat($type, $cp) {
        $position = 1;
        $category_id = 498;
        $product_id = $cp['entity_id'];
        $sku = $cp['sku'];
        
        $type->insertCat($category_id, $product_id, $position, $sku);
        
    }

    public function setSaleCat($type, $sp, $baseCategoryIds, $saleCatId) {
        $categoryId = 215;
        $position = 1;
        $product = $sp['entity_id'];
        $sku = $sp['sku'];
        
        $type->insertCat($categoryId, $product, $position, $sku);
        
        // get all products current category   
        $categories = $type->selectQuery("SELECT category_id FROM catalog_category_product WHERE product_id = " . $product);
        
        foreach ($categories as $cat) {
            $parentCatPath = array_shift($type->selectQuery("SELECT path FROM catalog_category_flat_store_1 WHERE entity_id = " . $cat['category_id']));
            $parentCatPathExploded = explode('/', array_shift($parentCatPath));

            if ($parentCatPathExploded[2] != 3 && $parentCatPathExploded[2] != 1 && $parentCatPathExploded[2] != 207 && $parentCatPathExploded[2] != 215) {
                if (array_search($parentCatPathExploded[2], $baseCategoryIds)) {
                    $key = array_search($parentCatPathExploded[2], $baseCategoryIds);
                    $type->insertCat($saleCatId[$key], $product, $position, $sku);
                }
            }
        }
    }
    
    public function complete($type){
        $type->complete();
    }

}
