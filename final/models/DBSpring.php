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
    
    //Function to add a user into the database
    function addUser($email, $pass) {
        $now = date("Y-m-d H:i:s");
        $db = $this->getDb();
        $stmt = $db->prepare("INSERT INTO users SET user_id = NULL, email = :email, password = :password, created = :created ");
        $binds = array(
            ":email" => $email,
            ":password" => $pass,
            ":created" => $now,
        );
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }

    //Function to get all emails from the database
    function getAllEmails() {
        $db = $this->getDb();
        $stmt = $db->prepare("SELECT email FROM users");
        $results = array();
        if ($stmt->execute() && $stmt->rowCount() > 0) {
           $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $results;
    }
    
    //Function to check and see if the email is valid
    function getLoginInfo($email){
        $db = $this->getDb();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
        $binds = array(
            ":email" => $email,
        );
        $results = array();
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
           $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $results;
    }
    
    //Function to see if the session is set
    function isLoggedIn() {
        if ( !isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false ){
                return false;
            }
            return true;
    }
    
    //Function to see if the email exixts in the database
    function emailExists($email){
        $db = $this->getDb();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
        $binds = array(
            ":email" => $email,
        );
        $results = array();
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
           $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $results;
        
    }
    
//    function getAllTitles(){
//        $db = $this->getDb();
//        $stmt = $db->prepare("SELECT filename, title FROM photos");
//        $results = array();
//        if ($stmt->execute() && $stmt->rowCount() > 0) {
//           $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
//        }
//        return $results;
//    }
//    
//    function getMemeInfo($fileName){
//        $db = $this->getDb();
//        $stmt = $db->prepare("SELECT * FROM photos WHERE filename = :filename");
//        $binds = array(
//            ":filename" => $fileName,
//        );
//        $results = array();
//        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
//           $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
//        }
//        return $results;
//        
//    }
//    
//    function addView($viewCount, $fileName){
//        $db = $this->getDb();
//        $stmt = $db->prepare("UPDATE photos SET views = :views WHERE filename = :filename");
//        $binds = array(
//            ":views" => $viewCount,
//            ":filename" => $fileName
//        );
//        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
//           return true;
//        }
//        else{
//          return false;  
//        }
//    }
//    
//    function getUsersMemes($userID){
//         $db = $this->getDb();
//        $stmt = $db->prepare("SELECT * FROM photos WHERE user_id = :user_id");
//        $binds = array(
//            ":user_id" => $userID,
//        );
//        $results = array();
//        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
//           $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
//        }
//        return $results;
//        
//    }
//    
//    function getAllMemes(){
//         $db = $this->getDb();
//        $stmt = $db->prepare("SELECT filename, title FROM photos");
//        $results = array();
//        if ($stmt->execute() && $stmt->rowCount() > 0) {
//           $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
//        }
//        return $results;
//        
//    }
//    function getUsersMemeNames($userID){
//         $db = $this->getDb();
//        $stmt = $db->prepare("SELECT filename FROM photos WHERE user_id = :user_id");
//        $binds = array(
//            ":user_id" => $userID,
//        );
//        $results = array();
//        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
//           $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
//        }
//        return $results;
//        
//    }
//    
//    function deletePhoto($filename){
//         $db = $this->getDb();
//        $stmt = $db->prepare("DELETE FROM photos WHERE filename = :filename");
//        $binds = array(
//            ":filename" => $filename,
//        );
//        
//        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
//           return true;
//        }
//        else {
//            return false;
//        }
//        
//    }
//    
//    function addMeme($userID, $fileName, $title) {
//        $now = date("Y-m-d H:i:s");
//        $db = $this->getDb();
//        $stmt = $db->prepare("INSERT INTO photos(photo_id, user_id, filename, title, views, created) VALUES (NULL, :user_id, :filename, :title, '0', :created)");
//        $binds = array(
//            ":user_id" => $userID,
//            ":filename" => $fileName,
//            ":title" => $title,
//            ":created" => $now,
//        );
//        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
//            return true;
//        }
//        return false;
//    }
    
}