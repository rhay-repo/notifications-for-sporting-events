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
    <link rel="stylesheet" type="text/css" href="login-style.css">
<body>
    <div class="loginbox">
    <img src="profile-icon.jpg" class="avatar">
        <h1>MeTube Login</h1>

        <!-- begin form -->
        <form id="login" method="post">

            <p>Username</p>
            <input type="text" name="username" placeholder="Enter Username">
            
            <p>Password</p>
            <input type="password" name="password" placeholder="Password">

            <input type="submit" name="loginbutton" value="Login">
            <a href="http://webapp.computing.clemson.edu/~rjhay/MeTube/too-bad.html?#">Forgot your password?</a><br>
            <a href="http://webapp.computing.clemson.edu/~rjhay/MeTube/register.html?#">Don't have an account? Register here</a>
        </form>


        <!-- begin new stuff -->
<?php

    $err_counter = 0;

        if (isset($_POST['loginbutton'])) {

            // print the count query
            $count_users_query = "SELECT COUNT(*) as cnt from users where username='{$username}'";
            $count_users_result = mysqli_query($link, $count_users_query) or die("Query error: ". mysqli_error($link)."\n");

            if($count_users_result->num_rows == 0) {
                $error .= "<h3>username $username does not exist!</h3><br>";
                $err_counter++;
            }

            echo "number of users with the username $username = " . $count_users_result->num_rows . "<br>";

            $matching_password_query = "SELECT * from users WHERE username='{$username}' and password='{$password}'";
            $matching_password_result = mysqli_query($link, $matching_password_query) or die("Query error: ". mysqli_error($link)."\n");

            if($matching_password_result->num_rows == 0) {
                $error .= "<h3>username $username does not exist!</h3><br>";
                $err_counter++;
            }

            echo "number of users with the credentials: $username/$password = " . $matching_password_result->num_rows . "<br>";


            // deny if any field is blank
            if ($username == '' or $password == '') {
                $error .= "<h3>no field can be left blank!</h3><br>";
                $err_counter++;
            }

            if (1 == 1) {
                echo $error;
                echo "<h3>\$err_counter = " . $err_counter . "</h3>";
            }

            // otherwise, accept the login and add take the user to the home page
            else {
                // redirect them to the home page
                //~THIS ISN'T WORKING
                header('Location: http://webapp.computing.clemson.edu/~rjhay/MeTube/homepage.html');

            }

        }

mysqli_close($link);
?>
        <!-- end new stuff -->

    </div>

</body>
</head>
</html>
