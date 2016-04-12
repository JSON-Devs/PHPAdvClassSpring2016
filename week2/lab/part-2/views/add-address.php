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
        require_once '../autoload.php';
        $db = new DBSpring();
        
        //Initilize all vairables
        $fullname = filter_input(INPUT_POST, 'fullname');
        $email = filter_input(INPUT_POST, 'email');
        $address = filter_input(INPUT_POST, 'address');
        $city = filter_input(INPUT_POST, 'city');
        $state = filter_input(INPUT_POST, 'state');
        $zip = filter_input(INPUT_POST, 'zip');
        $birthday = filter_input(INPUT_POST, 'birthday');
        $errorMessage = [];
        $successMessage = "";
        
        //Regex values
        //$filledInRegex = '/^(?:[A-Za-z0-9]+)(?:[A-Za-z0-9 _]*)$/';
        //$zipRegex = '/^[0-9]{5}(?:-[0-9]{4})?$/';
        //$emailRegex = '/^[-a-zA-Z0-9~!$%^&*_=+}{\'?]+(\.[-a-zA-Z0-9~!$%^&*_=+}{\'?]+)*@([a-zA-Z0-9_][-a-zA-Z0-9_]*(\.[-a-zA-Z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/';
        
        //Validation
        $validation = new Validation();
        if ( $db->isPostRequest() ) {
            if(empty($fullname)){
                $errorMessage[] = 'Please Fill in your Full Name';
            }elseif (!$validation->filledIn($fullname)) {
                $errorMessage[] = 'Please Fill in a valid Full Name';
            }
            if(empty($email)){
                $errorMessage[] = 'Please Fill in your Email';
            }elseif (!$validation->emailIsValid($email)) {
                $errorMessage[] = 'Please Fill in a valid Email';
            }
            if(empty($address)){
                $errorMessage[] = 'Please Fill in your Address';
            }elseif (!$validation->filledIn($address)) {
                $errorMessage[] = 'Please Fill in a valid Address';
            }
            if(empty($city)){
                $errorMessage[] = 'Please Fill in your City';
            }elseif (!$validation->filledIn($city)) {
                $errorMessage[] = 'Please Fill in a valid City';
            }
            if(empty($state)){
                $errorMessage[] = 'Please Fill in your State';
            }
            if(empty($zip)){
                $errorMessage[] = 'Please Fill in your Zip';
            }elseif (!$validation->zipIsValid($zip)) {
                $errorMessage[] = 'Please Fill in a valid Zip';
            }
            if(empty($birthday)){
                $errorMessage[] = 'Please Fill in your Birthday';
            }
            if(count($errorMessage) == 0){
                if ($db->addAddress($fullname, $email, $address, $city, $state, $zip, $birthday)){
                    $successMessage = 'Address added successfully!';
                }
                else{
                    $errorMessage[] = "Error adding to the database";
                }
            }
        }
        include '../views/errorMessage.php';
        ?>
        
        <br/>
        <a href="../index.php">Home</a>
        <br/>
        <div class="container">
            <h1>Add Address</h1>
            <form action="#" method="post">   
                Full Name: <input name="fullname" value="<?php echo $fullname; ?>" /> <br />
                Email: <input name="email" value="<?php echo $email; ?>" /> <br />
                Address: <input name="address" value="<?php echo $address; ?>" /> <br />
                City: <input name="city" value="<?php echo $city; ?>" /> <br />
                State: <select name="state" id="state">
                    <option value="AL">Alabama</option>
                    <option value="AK">Alaska</option>
                    <option value="AZ">Arizona</option>
                    <option value="AR">Arkansas</option>
                    <option value="CA">California</option>
                    <option value="CO">Colorado</option>
                    <option value="CT">Connecticut</option>
                    <option value="DE">Delaware</option>
                    <option value="DC">District Of Columbia</option>
                    <option value="FL">Florida</option>
                    <option value="GA">Georgia</option>
                    <option value="HI">Hawaii</option>
                    <option value="ID">Idaho</option>
                    <option value="IL">Illinois</option>
                    <option value="IN">Indiana</option>
                    <option value="IA">Iowa</option>
                    <option value="KS">Kansas</option>
                    <option value="KY">Kentucky</option>
                    <option value="LA">Louisiana</option>
                    <option value="ME">Maine</option>
                    <option value="MD">Maryland</option>
                    <option value="MA">Massachusetts</option>
                    <option value="MI">Michigan</option>
                    <option value="MN">Minnesota</option>
                    <option value="MS">Mississippi</option>
                    <option value="MO">Missouri</option>
                    <option value="MT">Montana</option>
                    <option value="NE">Nebraska</option>
                    <option value="NV">Nevada</option>
                    <option value="NH">New Hampshire</option>
                    <option value="NJ">New Jersey</option>
                    <option value="NM">New Mexico</option>
                    <option value="NY">New York</option>
                    <option value="NC">North Carolina</option>
                    <option value="ND">North Dakota</option>
                    <option value="OH">Ohio</option>
                    <option value="OK">Oklahoma</option>
                    <option value="OR">Oregon</option>
                    <option value="PA">Pennsylvania</option>
                    <option value="RI">Rhode Island</option>
                    <option value="SC">South Carolina</option>
                    <option value="SD">South Dakota</option>
                    <option value="TN">Tennessee</option>
                    <option value="TX">Texas</option>
                    <option value="UT">Utah</option>
                    <option value="VT">Vermont</option>
                    <option value="VA">Virginia</option>
                    <option value="WA">Washington</option>
                    <option value="WV">West Virginia</option>
                    <option value="WI">Wisconsin</option>
                    <option value="WY">Wyoming</option>
                </select>
                <script type="text/javascript">
                    document.getElementById('state').value = "<?php echo $state;?>";
                </script>
                <br />
                Zip: <input name="zip" value="<?php echo $zip; ?>" /> <br />
                Birthday: <input type="date" name="birthday" value="<?php echo $birthday; ?>" /> <br /><br />
                <input type="submit" value="Submit" class="btn btn-primary" />
            </form>
        </div>
    </body>
</html>
