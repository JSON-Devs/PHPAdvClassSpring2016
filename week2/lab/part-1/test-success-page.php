<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
           include './autoload.php';
            
            $errors = new SuccessMessge();
            $errors->addMessage('Email', 'Email is valid');
            var_dump($errors->getAllMessages());
            
            $errors->removeMessage('Email');
            var_dump($errors->getAllMessages());
        ?>
    </body>
</html>
