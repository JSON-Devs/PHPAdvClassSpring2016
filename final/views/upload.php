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
    $image_info = $files->getImageSize();
    $image_p = $files->newPicture($image_info, $rImg);
    $files->uploadTest($ext, $image_p, $location);
    
    $title = filter_input(INPUT_POST, 'title');
    $upFileName = $fileName . '.' . $ext;
    $userID = filter_input(INPUT_POST, 'id');
    if(!$db->addMeme($userID, $upFileName, $title)){
        throw new RuntimeException("Error writing to db");
    }

    imagedestroy($rImg);
    imagedestroy($image_p);

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

