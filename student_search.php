<?php
    //variables
    $Student_IDErr = "";

    if (isset($_POST['submit'])) {      // Verifies submit was selected
        if (empty($_POST['Student_ID'])) {   //checks field is not empty
            $error = "Student ID cannot be empty";
            echo $error;    // displays message if field is empty     
        }
        else {
            // Establishing Connection with Server by passing server_name, user_id and password as a parameter
            $db = new mysqli("localhost", "root", "", "ruxojo_accountsreceivable") OR die(mysql_error());

            // Define Student ID with escape variables for security
            if (!preg_match("/^[1-9][0-9]{0,15}$/",$Student_ID)){
                $Student_IDErr = "Only numbers are allowed"; 
            }elseif(isset($_POST["Student_ID"])){
                $Student_ID = $_POST["Student_ID"];
                $Student_ID = SanitizeUserInput($Student_ID);
            }

            //check connection
            if (mysqli_connect_error()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
            }
            
            // SQL query to fetch information of registerd users and finds user match.
            // add MD5 to pswd
            $sql = "SELECT user_level FROM admin_table WHERE user_name= '$username' AND
             p_word= '$password'";

            $result = mysqli_query($db,$sql);
            $row = mysqli_fetch_row($result);
            $userlvl = $row[0];
            $count = mysqli_num_rows($result);

            if ($count == 0) {
                $error = "Username or Password is invalid";
                echo $error;    
            } else {

                if($userlvl == 1){
                    $_SESSION['login_user']=$username; // Initializing Session
                    header("Location: SU_Menuscreen.html");
                }else{
                    $_SESSION['login_user']=$username; // Initializing Session
                    header("Location: U_Menuscreen.html");
                }
            }
            mysqli_close($db); // Closing Connection
        }
    }
    else {
        echo 'post submit error';
    }
?>