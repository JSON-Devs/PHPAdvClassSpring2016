<?php

/**
 * A method to check if a Post request has been made.
 *    
 * @return boolean
 */
function isPostRequest() {
    return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' );
}

function addAddress($fullname, $email, $address, $city, $state, $zip, $birthday) {
    
    $db = dbconnect();
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

function getAllAddress() {
    
    $db = dbconnect();
    $stmt = $db->prepare("SELECT * FROM address");
    
    $results = array();
    if ($stmt->execute() && $stmt->rowCount() > 0) {
       $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    return $results;
}

