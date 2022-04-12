<?php

session_start();
    //~ require_once 'db/connect.php';
// Variables
$error = '';
$hostname = "mysql1.cs.clemson.edu";
$username = "MeTube_4620_q9av";
$pswd     = "CP\$C4620!";
$db_name  = "MeTube_4620_2f01";

// Connecting, selecting database
$link = mysqli_connect($hostname,$username,$pswd,$db_name) or die ('Could not connect (ERROR):' .mysqli_error($link));
?>

<!DOCTYPE html>
<html>
<head>
<title>Account Registration Page Design</title>
    <link rel="stylesheet" type="text/css" href="register-style.css">
<body>
    <div class="loginbox">
    <img src="profile-icon.jpg" class="avatar">
        <h1>MeTube Account Creation</h1>

        <!-- begin form -->
        <!--~ <form action="register_account.php" method="post"> -->
        <form id="register" method="post">

            <p>Email Address</p>
            <input pattern="^([a-zA-Z0-9]+)@([a-zA-Z0-9]+)\.([a-zA-Z]{2,5})$" type="text" name="email" placeholder="Email Addresss">
            
            <p>Username</p>
            <input type="text" name="username" placeholder="Username">
            
            <p>Password</p>
            <input type="password" name="password" placeholder="Password">
            
            <input type="submit" name="registerbutton" value="Register">

            <br>
            
            <a href="http://webapp.computing.clemson.edu/~rjhay/MeTube/login2.php?#">Already have an account? Log in here</a>
        </form>

<?php

    $err_counter = 0;

        if (isset($_POST['registerbutton'])) {

            // gather variable info from html form
            $email = $_POST['email']; // gathered from name 'email'
            $username = $_POST['username']; // gathered from name 'username'
            $password = $_POST['password']; // gathered from name 'password'

            // check that email and username are not already in the database
            $check_email_query = "SELECT * from users WHERE email='{$email}'";
            $check_email_result = mysqli_query($link, $check_email_query) or die("Query error: ". mysqli_error($link)."\n");

            // loop through all results to see if it's empty
            $counter = 0;
            while ($line = mysqli_fetch_array($check_email_result, MYSQLI_ASSOC)){
                // loop through each column
                foreach($line as $col_value){	
                    if ($col_value != '' and $counter < 1) {
                        $error .= "<h3>email address $email is already in use!</h3><br>";
                        $err_counter++;
                        $counter++;
                    }
                }	
            }

            $check_username_query = "SELECT * from users WHERE username='{$username}'";
            $check_username_result = mysqli_query($link, $check_username_query) or die("Query error: ". mysqli_error($link)."\n");

            // loop through all results to see if it's empty
            $counter = 0;
            while ($line = mysqli_fetch_array($check_username_result, MYSQLI_ASSOC)){
                // loop through each column
                foreach($line as $col_value){	
                    if ($col_value != '' and $counter < 1) {
                        $error .= "<h3>username $username is already in use!</h3><br>";
                        $err_counter++;
                        $counter++;
                    }
                }	
            }

            // deny if any field is blank
            if ($email == '' or $username == '' or $password == '') {
                $error .= "<h3>no field can be left blank!</h3><br>";
                $err_counter++;
            }

            if ($err_counter > 0) {
                // print errors below the form
                echo $error;
            }

            // otherwise, accept the result and add the new user's data to the database
            else {

                // construct db query
                $insert_query = "INSERT into users VALUES ('{$email}', '{$username}', '{$password}')";

                $result = mysqli_query($link, $insert_query) or die("Query error: ". mysqli_error($link)."\n");

                // redirect them to the home page
                //~THIS ISN'T WORKING
                header('Location: http://webapp.computing.clemson.edu/~rjhay/MeTube/homepage.html');

            }

        }
        
mysqli_close($link);
?>

    </div>

</body>
</head>
</html>
