<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // http://php.net/manual/en/class.directoryiterator.php
        //DIRECTORY_SEPARATOR 

        $folder = './uploads';
        if ( !is_dir($folder) ) {
            die('Folder <strong>' . $folder . '</strong> does not exist' );
        }
        $directory = new DirectoryIterator($folder);
           
        ?>

        <?php foreach ($directory as $fileInfo) : ?>        
            <?php if ( $fileInfo->isFile() ) : ?>
                <h2><?php echo $fileInfo->getFilename(); ?></h2>
                <p>uploaded on <?php echo date("l F j, Y, g:i a", $fileInfo->getMTime()); ?></p>
                <p>This file is <?php echo $fileInfo->getSize(); ?> byte's</p>
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
