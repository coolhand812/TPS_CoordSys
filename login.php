<?php
    session_start();    // Starting Session
    $error='';          // Variable To Store Error Message
    $userlvl='';        // Variable to store user level
    if (isset($_POST['submit'])) {      // Verifies submit was selected
        if (empty($_POST['username']) || empty($_POST['password'])) {   //checks fields are not empty
            $error = "Username or Password is invalid";
            echo $error;    // displays message if either field is empty     
        }
        else {

            // Establishing Connection with Server by passing server_name, user_id and password as a parameter
            $db = new mysqli("localhost", "root", "", "ruxojo_accountsreceivable") OR die(mysql_error());

            // Define $username and $password with escape variables for security
            $username=SanitizeUserInput($db, $_POST['username']);
            $password=SanitizeUserInput($db, $_POST['password']);

            /*****************************************************
            * This function will sanitize user input
            * Specifically fields like first and last name
            * Even though these fields are restriced in size
            * users can still enter dangerous text.
            *****************************************************/
            function SanitizeUserInput($input)
            {
                // Dangerous words not allowed
                $wordsNotAllowed = array("/delete/i", "/update/i","/union/i","/insert/i","/drop/i","/evil/i","/--/i");
                // Remove dangerous words from first name
                $input = preg_replace($wordsNotAllowed , "", $input);
		        // Unfortunately escapeshellarg adds quotes around the first and last names.
		        // $input = escapeshellarg($input);
                // strip tags
                $input = filter_var($input, FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_AMP);
                // strip slashes
                $input = stripslashes($input);
                return $input;
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