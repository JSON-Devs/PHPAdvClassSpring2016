<?php
header("Access-Control-Allow-Orgin: *");
header("Content-Type: application/json; charset=utf8");

require_once '../autoload.php';
$db = new DBMemes();
$files = new Files('upfile');

$status_codes = array(
    200 => 'OK',
    500 => 'Internal Server Error',
);

$status = 200;

/*
 * make sure php_fileinfo.dll extension is enable in php.ini
 */

try {

    $files->fileErrorsCheck();
    $files->fileSizeCheck();
    $ext = $files->getExt();
    $fileName = $files->getFileName();
    $files->dirCheck();

    $location = sprintf('../uploads/%s.%s', $fileName, $ext);

    $rImg = $files->extCheck($ext);



    $image_info = getimagesize($_FILES["upfile"]["tmp_name"]);

    if (false === $image_info) {
        throw new RuntimeException('Invalid file format.');
    }


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
    $title = filter_input(INPUT_POST, 'title');
    
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

    $upFileName = $fileName . '.' . $ext;
    $userID = filter_input(INPUT_POST, 'id');
    if(!$db->addMeme($userID, $upFileName, $title)){
        throw new RuntimeException("Error writing to db");
    }

    imagedestroy($rImg);
    imagedestroy($image_p);
    
   

    /*
      if ( !move_uploaded_file( $_FILES["upfile"]["tmp_name"], $location) ) {
        throw new RuntimeException('Failed to move uploaded file.');
      }

     */

    $message = 'File is uploaded successfully.';
} catch (RuntimeException $e) {

    $message = $e->getMessage();
    $status = 500;
    $location = '';
}


header("HTTP/1.1 " . $status . " " . $status_codes[$status]);

$response = array(
    "status" => $status,
    "status_message" => $status_codes[$status],
    "message" => $message,
    "location" => $location
);

echo json_encode($response);
die();

