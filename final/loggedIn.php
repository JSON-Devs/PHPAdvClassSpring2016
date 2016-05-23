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
        session_start();
        require_once './autoload.php';
        $db = new DBSpring();
        $util = new Util();
        $folder = './uploads';
        $directory = scandir('./uploads');
        
        if (array_key_exists('deleteFile', $_POST)) {
            $fileName = $folder . "/" . filter_input(INPUT_POST, 'deleteFile');
            if (file_exists($fileName && $db->deletePhoto($fileName))){
                unlink($fileName);
                echo "<h2>File" . $fileName . " Deleted</h2>";
            }
            else{
                echo "<h2>File". $fileName . " Not Deleted</h2>";
            }
        }
        
        if ( !$db->isLoggedIn() ){
            $util->redirect("index.php");
        }
        if( $db->isPostRequest() ){
            unset($_SESSION['loggedin']);
            unset($_SESSION['user_id']);
            session_destroy();
            $util->redirect("index.php");
        }
        
        $memes = $db->getUsersMemes($_SESSION['user_id']);
        $noOfMemes = sizeof($memes);
        ?>
        <div class="container">
            <br />
            <h1>Logged in! Welcome!</h1>
            <form action="#" method="post">   
                <input type="submit" value="Log out" class="btn btn-primary" />
            </form>
            <br />
            <a href="./views/uploadImage.php">Upload a Meme</a>
            <br />
            <?php for($i=0; $i<$noOfMemes; $i++):?>
            <h2><?php echo $memes[$i]['title']; ?></h2>
                <p>Views: <?php echo $memes[$i]['views']; ?></p>
                <p>uploaded on <?php echo $memes[$i]['created']; ?></p>
                </br>
                <form method="post">
                    <input type="hidden" value="<?php echo $memes[$i]['filename']; ?>" name="deleteFile" />
                    <input type="submit" value="Delete File" class="btn btn-danger"/>
                </form>
                <img src="./uploads/<?php echo $memes[$i]['filename']?>"/>
            <?php endfor; ?>
        </div>
    </body>
</html>