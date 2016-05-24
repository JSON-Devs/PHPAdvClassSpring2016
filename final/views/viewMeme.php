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
        $db = new DBMemes();
        
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

        <?php 
        $file = '..'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$memeInfo[0]['filename'];
        $info = new SplFileInfo($file);
        $sizeBytes = $info->getSize();
        $size = $sizeBytes/1024;
        ?>
        <h2><?php echo $memeInfo[0]['title']; ?></h2>
        <p>Views: <?php echo $viewCount; ?></p>
        <p>uploaded on <?php echo date("l F j, Y, g:i a", $info->getMTime()); ?></p>
        <p>This file is <?php echo $size; ?> KB</p>
        <br/>
        <img src="../uploads/<?php echo $memeInfo[0]['filename']; ?>" />
        <br/>
        <?php $link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
        <a href="mailto:someone@example.com?subject=Summer%20Party&body=Check%20out%20this%20awesome%20meme%20I%20found!%20<?php echo $link; ?>" target="_top">Email this to someone!</a>
        <br/>
        <a href="https://twitter.com/share" class="twitter-share-button" data-size="large" data-dnt="true">Tweet</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
    </body>
</html>
