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
        require_once '../autoload.php';
        $db = new DBSpring();
        
        $folder = '../uploads';
        if ( !is_dir($folder) ) {
            die('Folder <strong>' . $folder . '</strong> does not exist' );
        }
        
        $directory = new DirectoryIterator($folder);

        $fileNameGet = filter_input(INPUT_GET, 'fileName');
      
        $memeInfo = $db->getMemeInfo($fileNameGet);
        $viewCount = $memeInfo[0]['views'] + 1;
        $db->addView($viewCount, $fileNameGet);
        ?>
        
        <a href="../index.php">Home</a>

        
        <?php foreach ($directory as $fileInfo) : ?>        
            <?php if ( $fileInfo->isFile() && $fileInfo->getFilename() == $fileNameGet ) : ?>
                <h2><?php echo $memeInfo[0]['title']; ?></h2>
                <p>Views: <?php echo $viewCount; ?></p>
                <p>uploaded on <?php echo date("l F j, Y, g:i a", $fileInfo->getMTime()); ?></p>
                <p>This file is <?php echo $fileInfo->getSize(); ?> byte's</p>
                </br>
                <?php if ( $fileInfo->getExtension() == "jpg" || $fileInfo->getExtension() == "png" || $fileInfo->getExtension() == "gif" ) : ?>
                    <img src="<?php echo $fileInfo->getPathname(); ?>" />
                <?php endif; ?>
                
                    
            <?php endif; ?>
        <?php endforeach; ?>
        

    </body>
</html>
