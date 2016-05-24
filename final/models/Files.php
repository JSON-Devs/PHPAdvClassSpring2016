<?php

/**
 * Description of uploading
 *
 * @author JAYGAGS
 */
class Files{
    protected $keyName;
    
    function __construct($keyName) {
        $this->setKeyName($keyName);
    }
    
    public function setKeyName($keyName){
        $this->keyName = $keyName;
        
    }


    public function fileErrorsCheck(){
        // Undefined | Multiple Files | $_FILES Corruption Attack
        // If this request falls under any of them, treat it invalid.
        if (!isset($_FILES[$this->keyName]['error']) || is_array($_FILES[$this->keyName]['error'])) {
            throw new RuntimeException('Invalid parameters.');
        }
        // Check $_FILES['upfile']['error'] value.
        switch ($_FILES[$this->keyName]['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException('No file sent.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException('Exceeded filesize limit.');
            default:
                throw new RuntimeException('Unknown errors.');
        }
    }
    public function fileSizeCheck(){
        // You should also check filesize here. 
        if ($_FILES[$this->keyName]['size'] > 1000000) {
            throw new RuntimeException('Exceeded filesize limit.');
        }
    }
    public function getExt(){
        $name = $_FILES[$this->keyName]["name"];
        $ext = strtolower(end((explode(".", $name))));

        if (preg_match("/^(jpeg|jpg|png|gif)$/", $ext) == false) {
            throw new RuntimeException('Invalid file format.');
        }
        return $ext;
    }
    
    function getFileName(){
        $salt = uniqid(mt_rand(), true);
        $fileName = 'img_' . sha1($salt . sha1_file($_FILES[$this->keyName]['tmp_name']));
        
        return $fileName;
    }
    
    function dirCheck(){
        if (!is_dir('../uploads')) {
            mkdir('../uploads');
        }
    }
    
    function extCheck($ext){
        switch ($ext) {
            case "jpg" :
            case "jpeg" :
                $rImg = imagecreatefromjpeg($_FILES[$this->keyName]["tmp_name"]);
                break;
            case "gif" :
                $rImg = imagecreatefromgif($_FILES[$this->keyName]["tmp_name"]);
                break;
            case "png" :
                $rImg = imagecreatefrompng($_FILES[$this->keyName]["tmp_name"]);
                break;

            default :
                throw new RuntimeException("Error Bad Extention");
                break;
        }
        return $rImg;
    }


}


