<?php

/**
 * @category MageSaCCA
 * @package MageSaCCA_Sale
 * @author Derek McDaniel dmcdaniel12@gmail.com
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0 Public License
 */
include_once 'Functionality.php';

class Magento extends Functionality {

    private $sortType;

    public function clearCategory($type, $config) {
        // This will get the New Arrivals Category and delete it
        foreach ($config->getNewArrivalCats() as $cat) {
            $type->deleteQuery($cat);
        }

        foreach ($config->getSaleCats() as $cat) {
            $type->deleteQuery($cat);
        }
    }

    //@TODO add in reindex method here - Needs to have API code in order to work properly
    public function reindex($config) {
        require_once $config->getMagentoAppLocation();
        umask(0);
        Mage::app();
        $process = Mage::getModel('index/indexer')->getProcessByCode('catalog_category_product');
        $process->reindexAll();
    }

    public function runClearanceProductUpdates($type, $config) {
        $mysql = new Mysql();
        $clearanceProducts = $mysql->selectClearanceQuery($config->getClearanceAmount());

        if ($config->getExcludeSaleOfDayItems()) {
            $startDate = date('Y-m-d') . " 00:00:00";
            $endDate = date('Y-m-d', strtotime(' +1 day')) . " 00:00:00";
            $dailyDealItems = $mysql->selectDailyDeal($startDate, $endDate);
            $clearanceProducts = $this->removeDailyDealItems($clearanceProducts, $dailyDealItems);
        }

        foreach ($clearanceProducts as $cp) {
            $this->setClearanceCat($type, $cp, $config);
        }
    }

    public function runSaleProductUpdates($type, $config) {
        $mysql = new Mysql();
        $saleProducts = $mysql->selectSalesQuery();

        foreach ($saleProducts as $sp) {
            if (isset($sp)) {
                $this->setSaleCat($type, $sp, $config);
            }
        }
    }

    public function runNewArrivals($type, $config) {
        // code to get all new arrival items from last 30 days for 60 total days
        $startDate = date('Y-m-d', strtotime('-59 Days'));
        $mysql = new Mysql();
        $newArrivalProducts = $mysql->selectNewArrivalProducts($startDate);

        foreach ($newArrivalProducts as $nap) {
            $this->setNewArrivalCat($type, $nap, $config);
        }
    }

    public function setClearanceCat($type, $cp, $config) {
        $position = 1;
        $category_id = $config->getClearanceBaseCat();
        $product_id = $cp['entity_id'];
        $sku = $cp['sku'];

        $type->insertCat($category_id, $product_id, $position, $sku);
    }

    public function setSaleCat($type, $sp, $config) {
        $categoryId = $config->getSaleBaseCat();
        $position = 1;
        $product = $sp['entity_id'];
        $sku = $sp['sku'];
        
        if($sku == 'BRL355-7-1'){
            echo "BRL355-7-1";
        }

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

        // inserts it into base category 215
        $type->insertCat($categoryId, $product, $position, $sku);
    }

    public function setNewArrivalCat($type, $prod, $config) {
        $categoryId = $config->getNewArrivalsCat();
        $position = 1;
        $product = $prod['entity_id'];
        $sku = $prod['sku'];

        $categories = $type->selectQuery("SELECT category_id FROM catalog_category_product WHERE product_id = " . $product);

        if ($config->getBaseCatToNewArrivalsCat()) {
            foreach ($categories as $cat) {
                foreach ($config->getBaseCatToNewArrivalsCat() as $newArrivalsCat) {
                    if (in_array($cat['category_id'], $newArrivalsCat)) {
                        $type->insertCat($newArrivalsCat[1], $product, $position, $sku);
                    }
                }
            }
        }

        $type->insertCat($categoryId, $product, $position, $sku);
    }

    public function removeDailyDealItems($products, $dailyDealItems) {
        foreach ($products as $key => $value) {
            foreach ($dailyDealItems as $ddItem) {
                if ($ddItem['sku'] == $value['sku']) {
                    unset($products[$key]);
                }
            }
        }
        return $products;
    }

    public function setSortType($type, $category) {
        $type->setSortType($category);
    }

    public function complete($type) {
        $type->complete();
    }

    public function saveCategory($config) {

        require_once($config->getMagentoAppLocation());

        umask(0);
        Mage::app();

        $category = Mage::getModel('catalog/category')->load(215);
        $category->setStoreId(0);
        $category->save();
        echo "Succeeded <br /> ";
    }

}
