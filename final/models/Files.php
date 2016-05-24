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

    function getImageSize(){
        $imageSize = getimagesize($_FILES[$this->keyName]["tmp_name"]);
        
        if (false === $image_info) {
            throw new RuntimeException('Invalid file format.');
        }
        return $imageSize;
    }
    
    function newPicture($image_info , $rImg){
        $image_width = $image_info[0];
        $image_height = $image_info[1];

        // Set a maximum height and width
        $max_width = 300;
        $max_height = 300;

        $ratio_orig = $image_width / $image_height;

        if ($max_width / $max_height > $ratio_orig) {
            $max_width = $max_height * $ratio_orig;
        } else {
            $max_height = $max_width / $ratio_orig;
        }

        $image_p = imagecreatetruecolor($max_width, $max_height);

        imagecopyresampled($image_p, $rImg, 0, 0, 0, 0, $max_width, $max_height, $image_width, $image_height);

        $memetop = filter_input(INPUT_POST, 'memetop');
        $memebottom = filter_input(INPUT_POST, 'memebottom');

        //Font Color (white in this case)
        $textcolor = imagecolorallocate($image_p, 255, 255, 255);
        $bgcolor = imagecolorallocate($image_p, 0, 0, 0);

        //y-coordinate of the upper left corner. 
        $yPos = intval($max_height - 20);

        if (null !== $memetop && strlen($memetop) > 0) {
            //x-coordinate of center. 
            $xPosTop = intval(($max_width - 8.5 * strlen($memetop)) / 2);
            // Set the background
            imagefilledrectangle($image_p, 0, 0, $max_width, 20, $bgcolor); // top
            //Writting the picture
            imagestring($image_p, 5, $xPosTop, 0, $memetop, $textcolor);
        }

        if (null !== $memebottom && strlen($memebottom) > 0) {
            //x-coordinate of center. 
            $xPosBottom = intval(($max_width - 8.5 * strlen($memebottom)) / 2);
            // Set the background 
            imagefilledrectangle($image_p, 0, $yPos, $max_width, $max_height, $bgcolor); //bottom
            //Writting the picture
            imagestring($image_p, 5, $xPosBottom, $yPos, $memebottom, $textcolor);
        }

        return $image_p;
    }
    
    function uploadTest($ext, $image_p, $location){
        switch ($ext) {
            case "jpg" :
            case "jpeg" :
                if (!imagejpeg($image_p, $location)) {
                    throw new RuntimeException('Failed to move uploaded file.');
                }
                break;
            case "gif" :
                if (!imagegif($image_p, $location)) {
                    throw new RuntimeException('Failed to move uploaded file.');
                }
                break;
            case "png" :
                if (!imagepng($image_p, $location)) {
                    throw new RuntimeException('Failed to move uploaded file.');
                }
                break;

            default :
                throw new RuntimeException("Error Bad Extention");
                break;
        }
    }

}


