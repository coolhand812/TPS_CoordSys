<?php
    //variables
    $Student_IDErr = "";

    if (isset($_POST['submit'])) {      // Verifies submit was selected
        if (empty($_POST['Student_ID'])) {   //checks field is not empty
            $error = "Student ID cannot be empty";
            echo $error;    // displays message if field is empty     
        }
        else {
            // Define Student ID with escape variables for security
            if (!preg_match("/^[1-9][0-9]{0,15}$/",$Student_ID)){
                $Student_IDErr = "Only numbers are allowed"; 
            }elseif(isset($_POST["Student_ID"])){
                $Student_ID = $_POST["Student_ID"];
                $Student_ID = SanitizeUserInput($Student_ID);
            }
            
            // Establishing Connection with Server by passing server_name, user_id and password as a parameter
            $db = new mysqli("localhost", "root", "", "ruxojo_accountsreceivable") OR die(mysql_error());
            
            // SQL query to fetch information of registerd users and finds user match.
            // add MD5 to pswd
            $sql = "SELECT student_ID FROM student_table WHERE student_ID = $Student_ID";

            if($db->query($sql) === false)
			{ 
				// row not found, do stuff...
				echo "<b>Student ID not found</b><br>";
			} else {
				// row found, do other stuff...
                $result = mysqli_query($db,$sql); // gives the query result and assigns it to a variable
                //fetch associated array
                while ($row = $result->fetch_assoc()) {
                    echo "Student Id: " . $row["student_ID"]. " - Pat Last Name: " . $row["last_name1"] .
                     " - Mat Last Name: " . $row["last_name2"]. " - First Name: " . $row["first_name"]. 
                     " - Middle Name: " . $row["middle_name"]. " - Faculty Name: " . $row["faculty_name"]. 
                     "<br>";
                }
             
                /* free result set */
                $result->free();
			}
            mysqli_close($db); // Closing Connection
        } // end else
    } // end if verification
    else {
        echo 'post submit error';
    }

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
?>