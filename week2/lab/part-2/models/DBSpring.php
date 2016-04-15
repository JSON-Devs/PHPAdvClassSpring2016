<?php
/**
 * Description of DBSpring
 *
 * @author JAYGAGS
 */
class DBSpring extends DB {
    //Constructor with database connection information
    function __construct() {
        $this->setDns('mysql:host=localhost;port=3306;dbname=PHPAdvClassSpring2016');
        $this->setPassword('');
        $this->setUser('root');
    }
    
    function isPostRequest() {
        return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' );
    }
    
    //Function to add an address into the database
    function addAddress($fullname, $email, $address, $city, $state, $zip, $birthday) {
        $db = $this->getDb();
        $stmt = $db->prepare("INSERT INTO address SET address_id = NULL, fullname = :fullname, email = :email, addressline1 = :address, city = :city, state = :state, zip = :zip, birthday = :birthday");
        $binds = array(
            ":fullname" => $fullname,
            ":email" => $email,
            ":address" => $address,
            ":city" => $city,
            ":state" => $state,
            ":zip" => $zip,
            ":birthday" => $birthday,
        );
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }

    //Function to get all addresses from the database
    function getAllAddress() {
        $db = $this->getDb();
        $stmt = $db->prepare("SELECT * FROM address");
        $results = array();
        if ($stmt->execute() && $stmt->rowCount() > 0) {
           $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $results;
    }
}