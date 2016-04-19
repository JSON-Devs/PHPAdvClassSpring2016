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
        
        //Initilize all vairables
        $email = filter_input(INPUT_POST, 'email');
        $pass = filter_input(INPUT_POST, 'pass');
        
        if ( $db->isPostRequest() ) {
            
            $userInfo = $db->getLoginInfo($email);
            $loginHash = $userInfo[0]['password'];
            $userID = $userInfo[0]['user_id'];
            
            if(password_verify($pass, $loginHash)){
                $_SESSION['user_id'] = $userID;
                $_SESSION['loggedin'] = true;
                $util->redirect("admin.php");
            }
        }
        ?>
        <div class="container">
            <br/>
            <a href="./views/signup.php">Sign Up</a>
            <br/>
            <h1>Login</h1>
            <form action="#" method="post">   
                Email: <input name="email" value="<?php echo $email; ?>" /> <br />
                Password: <input type="password" name="pass" value="<?php echo $pass; ?>" /> <br />
                <input type="submit" value="Login" class="btn btn-primary" />
            </form>
        </div>
    </body>
</html>
