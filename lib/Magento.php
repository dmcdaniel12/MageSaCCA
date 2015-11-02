<?php
/**
 * @category MageSaCCA
 * @package MageSaCCA_Sale
 * @author Derek McDaniel dmcdaniel12@gmail.com
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0 Public License
 */
include_once 'Functionality.php';

class Magento extends Functionality {

    public function clearCategory($type, $config) {
        $categories = $config->getSaleCats();
        foreach ($categories as $cat) {
            $type->deleteQuery($cat);
        }
    }

    //@TODO add in reindex method here - Needs to have API code in order to work properly
    public function reindex() {
        
    }

    public function runClearanceProductUpdates($type, $config) {
        $mysql = new Mysql();
        $clearanceProducts = $mysql->selectClearanceQuery($config->getClearanceAmount());

        foreach ($clearanceProducts as $cp) {
            $this->setClearanceCat($type, $cp, $config);
        }
    }

    public function runSaleProductUpdates($type, $config) {
        $mysql = new Mysql();
        $saleProducts = $mysql->selectSalesQuery("SELECT * FROM catalog_product_flat_1 WHERE special_price < price");
        foreach ($saleProducts as $sp) {
            if (isset($sp)) {
                $this->setSaleCat($type, $sp, $config);
            }
        }
    }

    public function setClearanceCat($type, $cp) {
        $position = 1;
        $category_id = $config->getClearanceBaseCat();
        $product_id = $cp['entity_id'];
        $sku = $cp['sku'];

        $type->insertCat($category_id, $product_id, $position, $sku);
    }

    public function setSaleCat($type, $sp, $config) {
        // TODO: This needs to be done via configuration setting
        $categoryId = $config->getSaleBaseCat();
        $position = 1;
        $product = $sp['entity_id'];
        $sku = $sp['sku'];
  
        $categories = $type->selectQuery("SELECT category_id FROM catalog_category_product WHERE product_id = " . $product);
        if ($config->getBaseCatToSalesCat()) {
            foreach ($categories as $cat) {
                foreach ($config->getBaseCatToSalesCat() as $salesCat) {
                    if (in_array($cat['category_id'], $salesCat)) {
                        $type->insertCat($salesCat[1], $product, $position, $sku);
                    }
                }
            }
        } else {
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
        
        $type->insertCat($categoryId, $product, $position, $sku);
    }

    public function complete($type) {
        $type->complete();
    }

}
