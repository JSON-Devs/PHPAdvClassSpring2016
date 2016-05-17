<?php

class CorpsResoruce extends DB implements IRestModel {
    
    function __construct() {
        
        $util = new Util();
        $this->setDbConfig($util->getDBConfig());              
    }

    public function getAll() {
        $stmt = $this->getDb()->prepare("SELECT * FROM corps");
        $results = array();      
        if ($stmt->execute() && $stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        else{
            throw new Exception('All Corps could not be obtained');
        }
        return $results;
    }
    
    public function get($id) {
       
        $stmt = $this->getDb()->prepare("SELECT * FROM corps WHERE id = :id");
        $binds = array(":id" => $id);

        $results = array(); 
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        else{
            throw new Exception('Corp could not be obtained');
        }
        
        return $results;
                
    }
    
    public function post($serverData) {
        /* note you should validate before adding to the data base */
        $stmt = $this->getDb()->prepare("INSERT INTO corps SET corp = :corp, incorp_dt = :incorp_dt, email = :email, owner = :owner, phone = :phone, location = :location");
        $binds = array(
            ":corp" => $serverData['corp'],
            ":incorp_dt" => $serverData['incorp_dt'],
            ":email" => $serverData['email'],
            ":owner" => $serverData['owner'],
            ":phone" => $serverData['phone'],
            ":location" => $serverData['location']
        );

        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            return true;
        }
        else{
            return false;
        }
        
    }
    public function put($id, $serverData){
        $stmt = $this->getDb()->prepare("UPDATE corps SET corp = :corp, incorp_dt = :incorp_dt, email = :email, owner = :owner, phone = :phone, location = :location WHERE id = :id" );
        //INSERT INTO corps`(`corp`, `incorp_dt`, `email`, `owner`, `phone`, `location`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6]) WHERE id = :id
        $binds = array(
            ":corp" => $serverData['corp'],
            ":incorp_dt" => $serverData['incorp_dt'],
            ":email" => $serverData['email'],
            ":owner" => $serverData['owner'],
            ":phone" => $serverData['phone'],
            ":location" => $serverData['location'],
            ":id" => $id
        );
        
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            return true;
        } 
        else{
            return false;
            
        }
        
    }
    public function delete($id){
        $stmt = $this->getDb()->prepare("DELETE FROM corps WHERE id = :id");
        $binds = array(":id" => $id);

        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            return true;
        }
        else{
            return false;
        }
    }
    
}