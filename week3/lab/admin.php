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
        
        if ( !$db->isLoggedIn() ){
            $util->redirect("index.php");
        }
        if( $db->isPostRequest() ){
            unset($_SESSION['loggedin']);
            unset($_SESSION['user_id']);
            session_destroy();
            $util->redirect("index.php");
        }
        
        ?>
        <div class="container">
            <br/>
            <h1>Logged in! Welcome!</h1>
            <form action="#" method="post">   
                <input type="submit" value="Log out" class="btn btn-primary" />
            </form>
        </div>
    </body>
</html>
