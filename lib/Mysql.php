<?php
/**
 * @category MageSaCCA
 * @package MageSaCCA_Sale
 * @author Derek McDaniel dmcdaniel12@gmail.com
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0 Public License
 */

include_once 'Functionality.php';

// TODO add in code to no longer limit by in stock
class Mysql extends Functionality{

    private $server = '';
    private $username = '';
    private $password = '';
    private $database = '';
    private $conn;

    function getServer() {
        return $this->server;
    }

    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function getDatabase() {
        return $this->database;
    }

    function getConn() {
        return $this->conn;
    }

    function setServer($server) {
        $this->server = $server;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setDatabase($database) {
        $this->database = $database;
    }

    function setConn($conn) {
        $this->conn = $conn;
    }
    
    public function __construct(){
        $this->connect();
    }
    
    public function connect() {
        $conn = new mysqli($this->getServer(), $this->getUsername(), $this->getPassword(), $this->getDatabase());

        if ($conn->connect_error) {
            die("Connection Failed");
        }

        $this->setConn($conn);
    }

    public function close($conn) {
        $this->getConn()->close();
    }
    
    public function selectClearanceQuery($clearanceAmount){
        return $this->selectQuery("SELECT * FROM catalog_product_flat_1 WHERE special_price < (price * $clearanceAmount)");
    }
    
    public function selectSalesQuery(){
        return $this->selectQuery("SELECT * FROM catalog_product_flat_1 WHERE special_price < price");
    }
    
    public function selectDailyDeal($startDate, $endDate){
        return $this->selectQuery("SELECT sku FROM rods_dailydeal WHERE startDate = '$startDate' AND endDate = '$endDate'");
    }
    
    public function selectNewArrivalProducts($startDate){
        return $this->selectQuery("SELECT cpf1.entity_id,cpf1.sku, cpedt.value FROM catalog_product_flat_1 as cpf1 LEFT JOIN catalog_product_entity_datetime as cpedt ON cpf1.entity_id = cpedt.entity_id WHERE cpedt.attribute_id = 84 AND cpedt.value > '$startDate'");
    }

    public function selectQuery($query) {
        $result = $this->getConn()->query($query);
        while ($row = $result->fetch_object()) {
            $results[] = json_decode(json_encode($row),true);
        }

        return $results;
    }

    public function insertCat($categoryId, $productId, $position, $sku) {

        // Prepary our query for binding
        $stmt = $this->getConn()->prepare("INSERT INTO catalog_category_product VALUES (?,?,?)");
        // Dynamically bind values
        $stmt->bind_param('isi', $categoryId, $productId, $position);
        //call_user_func_array(array($stmt, 'bind_param'), $this->ref_values($values));
        // Execute the query
        $stmt->execute();

        // Check for successful insertion
        if ($stmt->affected_rows) {
            return true;
        }

        return false;
    }

    public function deleteQuery($whereData) {
        $this->getConn()->query("DELETE FROM catalog_category_product WHERE category_id = $whereData");
    }
        
    public function complete(){
        $this->getConn()->close();
    }

}
