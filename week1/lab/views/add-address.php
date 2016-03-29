<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">    </head>
    </head>
    <body>
        <?php
        require_once '../functions/dbconn.php';
        require_once '../functions/address.php';
        
        $fullname = filter_input(INPUT_POST, 'fullname');
        $email = filter_input(INPUT_POST, 'email');
        $address = filter_input(INPUT_POST, 'address');
        $city = filter_input(INPUT_POST, 'city');
        $state = filter_input(INPUT_POST, 'state');
        $zip = filter_input(INPUT_POST, 'zip');
        $birthday = filter_input(INPUT_POST, 'birthday');
        $errorMessage = [];
        
        $filledInRegex = '/^(?:[A-Za-z]+)(?:[A-Za-z0-9 _]*)$/';
        $zipRegex = '/^[0-9]{5}(?:-[0-9]{4})?$/';
        $emailRegex = '/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/';
        
        if ( isPostRequest() ) {
            if(empty($fullname)){
                $errorMessage[] = 'Please Fill in your Full Name';
            }elseif (!preg_match($filledInRegex, $fullname)) {
                $errorMessage[] = 'Please Fill in a valid Full Name';
            }
            if(empty($email)){
                $errorMessage[] = 'Please Fill in your Email';
            }elseif (!preg_match($emailRegex, $email)) {
                $errorMessage[] = 'Please Fill in a valid Email';
            }
            if(empty($address)){
                $errorMessage[] = 'Please Fill in your Address';
            }elseif (!preg_match($filledInRegex, $address)) {
                $errorMessage[] = 'Please Fill in a valid Address';
            }
            if(empty($city)){
                $errorMessage[] = 'Please Fill in your City';
            }elseif (!preg_match($filledInRegex, $city)) {
                $errorMessage[] = 'Please Fill in a valid City';
            }
            if(empty($state)){
                $errorMessage[] = 'Please Fill in your State';
            }elseif (!preg_match($filledInRegex, $state)) {
                $errorMessage[] = 'Please Fill in a valid State';
            }
            if(empty($zip)){
                $errorMessage[] = 'Please Fill in your Zip';
            }elseif (!preg_match($zipRegex, $zip)) {
                $errorMessage[] = 'Please Fill in a valid Zip';
            }
            if(empty($birthday)){
                $errorMessage[] = 'Please Fill in your Birthday';
            }
            if(count($errorMessage[]) == 0){
                if (addAddress($fullname, $email, $address, $city, $state, $zip, $birthday)){
                    $success = 'Address added successfully!';
                }
            }
        }
        include '../views/errorMessage.php';
        ?>
        
        <br/>
        <div class="container">
            <h1>Add Address</h1>
            <form action="#" method="post">   
               Full Name: <input name="fullname" value="<?php echo $fullname; ?>" /> <br />
               Email: <input name="email" value="<?php echo $email; ?>" /> <br />
               Address: <input name="address" value="<?php echo $address; ?>" /> <br />
               City: <input name="city" value="<?php echo $city; ?>" /> <br />
               State: <input name="state" value="<?php echo $state; ?>" /> <br />
               Zip: <input name="zip" value="<?php echo $zip; ?>" /> <br />
               Birthday: <input type="date" name="birthday" value="<?php echo $birthday; ?>" /> <br /><br />
               <input type="submit" value="Submit" class="btn btn-primary" />
            </form>
        </div>
    </body>
</html>
