<?php
    //variables
    $patLName = $patLNameErr = $matLName = $matLNameErr = "";

    if (isset($_POST['submit'])) {      // Verifies submit was selected
        if (empty($_POST['last_name1'])) {   //checks field is not empty
            $patLNameErr = "Paternal Last Name cannot be empty";
            echo $patLName;    // displays message if field is empty     
        }
        else {
            // Define last names with escape variables for security
            if (!preg_match("/^[a-zA-Z ]*$/",$patLName)){
                $patLNameErr = "Only letters and white space allowed"; 
            }elseif(isset($_POST["PatLName"])){
                $patLName = $_POST["PatLName"];
            }

            if (empty($_POST["MatLName"])){
                $matLNameErr = "Maternal last name is required";
                } else {
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/",$matLName)){
                    $matLNameErr = "Only letters and white space allowed"; 
                }elseif(isset($_POST["MatLName"])){
                    $matLName = $_POST["MatLName"];
                }
            }
            
            // Establishing Connection with Server by passing server_name, user_id and password as a parameter
            $db = new mysqli("localhost", "root", "", "ruxojo_accountsreceivable") OR die(mysql_error());
            
            // SQL query to fetch information of registerd users and finds user match.
            // add MD5 to pswd
            $sql = "SELECT last_name1 FROM student_table WHERE last_name1 = $patLName";

            if($db->query($sql) === false)
			{ 
				// row not found, do stuff...
				echo "<b>Last name not found</b><br>";
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