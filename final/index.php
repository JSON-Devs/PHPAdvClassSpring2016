<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Meme Generator - Home</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <style>
            .meme {
                width: 300px; 
                text-align: center;
                vertical-align: middle;
                
            }



        </style>
    </head>
    <body>
        <?php
        session_start();
        require_once './autoload.php';
        $db = new DBMemes();
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
                $util->redirect("loggedIn.php");
            }
        }
        
        $titles = $db->getAllTitles();
        $randomMeme = $db->getAllMemes();
        $maxMeme = sizeof($randomMeme)-1;
        $randomNumberMeme = rand(0, $maxMeme);
        //var_dump($randomMeme[$randomNumberMeme]['filename']);
        ?>
        <div class="container">
            <?php if(!isset($_SESSION['user_id'])): ?>
            <br/>
            <a href="./views/signup.php">Sign Up</a>
            <br/>
            <h1>Login</h1>
            <form action="#" method="post">   
                Email: <input name="email" value="<?php echo $email; ?>" /> <br />
                Password: <input type="password" name="pass" value="<?php echo $pass; ?>" /> <br />
                <input type="submit" value="Login" class="btn btn-primary" />
            </form>
            <?php endif; ?>
            <?php if(isset($_SESSION['user_id'])): ?>
            <a href="./loggedIn.php">View My Memes</a>
            <?php endif; ?>
            <?php if($maxMeme != -1): ?>
            <h2>Featured Meme</h2>
            <a href="views/viewMeme.php?fileName=<?php echo $randomMeme[$randomNumberMeme]['filename']; ?>"><img src="uploads/<?php echo $randomMeme[$randomNumberMeme]['filename']; ?>" /></a>
            <br/><?php echo $randomMeme[$randomNumberMeme]['title'];?>
            <br/>
            <br/>
            <?php endif; ?>
            <h2>All Memes</h2>
            <?php
                $arraySize = sizeof($titles);
                if($arraySize == 0):?>
                    <br /><h1>No meme's to show</h1>
                <?php endif; ?>
                <?php for($i=0; $i <= $arraySize - 1; $i++):?> 
                    <div class="meme"> 
                        <a href="views/viewMeme.php?fileName=<?php echo $titles[$i]['filename'] ?>"><img src="./uploads/<?php echo $titles[$i]['filename'] ?>" /></a>
                        <?php echo $titles[$i]['title'];?>
                         
                    </div>

                <?php endfor; ?>
            


        </div>
        
    </body>
</html>