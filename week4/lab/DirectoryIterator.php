<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    
    </head>
    <body>
        <?php
        // http://php.net/manual/en/class.directoryiterator.php
        //DIRECTORY_SEPARATOR 

        $folder = './uploads';
        if ( !is_dir($folder) ) {
            die('Folder <strong>' . $folder . '</strong> does not exist' );
        }
        
        if (array_key_exists('deleteFile', $_POST)) {
            $fileName = $folder . "/" . filter_input(INPUT_POST, 'deleteFile');
            if (file_exists($fileName)){
                unlink($fileName);
                echo "<h2>File" . $fileName . " Deleted</h2>";
            }
            else{
                echo "<h2>File". $fileName . " Not Deleted</h2>";
            }
        }
        
        $directory = new DirectoryIterator($folder);

            $fileNameGet = filter_input(INPUT_GET, 'fileName');
        
        ?>
        
        <a href="scandir.php">Back to List</a>
        </br>
        <a href="upload-form.php">Upload a File</a>
        
        <?php foreach ($directory as $fileInfo) : ?>        
            <?php if ( $fileInfo->isFile() && $fileInfo->getFilename() == $fileNameGet ) : ?>
                <h2><?php echo $fileInfo->getFilename(); ?></h2>
                <p>is a <?php echo $fileInfo->getExtension(); ?> and was</p>
                <p>uploaded on <?php echo date("l F j, Y, g:i a", $fileInfo->getMTime()); ?></p>
                <p>This file is <?php echo $fileInfo->getSize(); ?> byte's</p>
                <form method="post">
                    <input type="hidden" value="<?php echo $fileInfo ?>" name="deleteFile" />
                    <input type="submit" value="Delete File" class="btn btn-danger"/>
                </form>
                </br>
                <?php if ( $fileInfo->getExtension() == "jpg" || $fileInfo->getExtension() == "png" || $fileInfo->getExtension() == "gif" ) : ?>
                    <img src="<?php echo $fileInfo->getPathname(); ?>" />
                <?php endif; ?>
                <?php if ( $fileInfo->getExtension() == "pdf" ) : ?>
                    <embed src="<?php echo $fileInfo->getPathname(); ?>" type="application/pdf" width="500" height="500"/>
                <?php endif; ?>
                <?php if ( $fileInfo->getExtension() == "txt" ) : ?>
                    <textarea rows="20" cols="50"><?php echo file_get_contents($fileInfo->getPathName());?></textarea>
                <?php endif; ?>
                <?php if ( $fileInfo->getExtension() == "html" || $fileInfo->getExtension() == "doc" || $fileInfo->getExtension() == "docx" || $fileInfo->getExtension() == "xls" || $fileInfo->getExtension() == "xlsx") : ?>
                    <a href="<?php echo $fileInfo->getPathname(); ?>" download>Download</a>
                <?php endif; ?>
                    
            <?php endif; ?>
        <?php endforeach; ?>
        

    </body>
</html>
