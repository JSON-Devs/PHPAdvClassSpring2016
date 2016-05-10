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
        // put your code here
        //DIRECTORY_SEPARATOR 

        $folder = './uploads';
        $directory = scandir('./uploads');
        
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
       
        //var_dump($directory);
        ?>

        <a href="upload-form.php">Upload a File</a>
        
        <?php foreach ($directory as $file) : ?>        
            <?php if ( is_file($folder . DIRECTORY_SEPARATOR . $file) ) : ?>
                <h2><?php echo $file; ?></h2>
                <form action="DirectoryIterator.php" method="get">
                    <input value="<?php echo $file; ?>" name="fileName" type="hidden" />
                    <input type="submit" value="See More Info" class="btn btn-primary"/>
                </form>
                <form method="post">
                    <input type="hidden" value="<?php echo $file ?>" name="deleteFile" />
                    <input type="submit" value="Delete File" class="btn btn-danger" />
                </form>
            <?php endif; ?>
        <?php endforeach; ?>

    </body>
</html>
