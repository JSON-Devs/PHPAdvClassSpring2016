<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Meme Generator - Sign Up</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">    </head>
    </head>
    <body>
        <?php
        require_once '../autoload.php';
        $db = new DBSpring();
        
        //Initilize all vairables
        $email = filter_input(INPUT_POST, 'email');
        $pass = filter_input(INPUT_POST, 'pass');
        $emailArray = [];
        $errorMessage = [];
        $successMessage = "";
        
        //Validation
        $validation = new Validation();
        if ( $db->isPostRequest() ) {
            if(empty($email)){
                $errorMessage[] = 'Please Fill in your Email';
            }elseif (!$validation->emailIsValid($email)) {
                $errorMessage[] = 'Please Fill in a valid Email';
            }
            if(empty($pass)){
                $errorMessage[] = 'Please Fill in a Password';
            }
            if (count($db->emailExists($email)) > 0){
                $errorMessage[] = 'Email already exists in the database';
            }
            if(count($errorMessage) == 0){
                $passHash = password_hash($pass, PASSWORD_DEFAULT);
                if ($db->addUser($email, $passHash)){
                    $successMessage = 'User added successfully!';
                    sleep(5);
                    header( ' Refresh: 5; url=../index.php' ) ; 
                }
                else{
                    $errorMessage[] = "Error adding User to the database";
                }
            }
        }
        include '../views/errorMessage.php';
        ?>
        
        
        <div class="container">
            <br/>
            <a href="../index.php">Home</a>
            <br/>
            <h1>Sign Up</h1>
            <form action="#" method="post">   
                Email: <input name="email" value="<?php echo $email; ?>" /> <br />
                Password: <input type="password" name="pass" value="<?php echo $pass; ?>" /> <br />
                <input type="submit" value="Submit" class="btn btn-primary" />
            </form>
        </div>
    </body>
</html>
