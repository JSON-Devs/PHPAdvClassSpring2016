<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
           include './autoload.php';
            
            $errors = new ErrorMessage();
            $errors->addMessage('Email', 'Email is valid');
            var_dump($errors->getAllMessages());
            
            $errors->removeMessage('Email');
            var_dump($errors->getAllMessages());
        ?>
    </body>
</html>
