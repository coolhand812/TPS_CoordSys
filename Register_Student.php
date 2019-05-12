<?php
    // define variables and set to empty values
    $Student_ID = $Student_IDErr = $patLName = $patLNameErr = $matLName = $matLNameErr = $firstName = $firstNameErr = "";
    $secondName = $secondNameErr = $gender = $dateofbirth = $dateofbirthErr = $phoneNumber = $phoneNumberErr = "";
    $facebook = $facebookErr = $email = $emailErr = $generation = $generationErr = $startdate = $startdateErr = "";
    $enddate = $enddateErr = $facultyName = $learningProg = $toeflScore = $toeflScoreErr = $notes = "";
    $cityUstudentID = $cityUstudentIDErr = $currentStatus = $amttopay = $amttopayErr = $numofpmts = $numofpmtsErr = $pmtmethod = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //student ID validate If the Student_ID already exists
		$conn = new mysqli("localhost", "root", "", "ruxojo_accountsreceivable") OR die(mysql_error());
		// Check connection
		if (!$conn)
		{
			die("Connection failed: " . mysqli_connect_error());
		}
		echo "<b>Connection to MySQL DB established!</b> <br>";
		$sql = "SELECT Student_ID FROM Student_Table WHERE Student_ID = $Student_ID";
		if($conn->query($sql) === false)
		{
			// row not found, do stuff...
			echo "<b>student ID is available</b><br>";
		} else {
			// do other stuff...
			$StudentIDerr = "Duplicate student ID found, please verify";
		}
		$conn->close();

        if (empty($_POST["Student_ID"])){
            $Student_IDErr = "Student ID is required";
            } else {
            // check if name only contains numbers
            if (!preg_match("/^[1-9][0-9]{0,15}$/",$Student_ID)){
                $Student_IDErr = "Only numbers are allowed"; 
            }elseif(isset($_POST["Student_ID"])){
                $Student_ID = $_POST["Student_ID"];
                $Student_ID = SanitizeUserInput($Student_ID);
            }
        }

        if (empty($_POST["PatLName"])){
            $patLNameErr = "Paternal last name is required";
            } else {
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z ]*$/",$patLName)){
                $patLNameErr = "Only letters and white space allowed"; 
            }elseif(isset($_POST["PatLName"])){
                $patLName = $_POST["PatLName"];
                $patLName = SanitizeUserInput($patLName);
            }
        }

        if (empty($_POST["MatLName"])){
            $matLNameErr = "Maternal last name is required";
            } else {
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z ]*$/",$matLName)){
                $matLNameErr = "Only letters and white space allowed"; 
            }elseif(isset($_POST["MatLName"])){
                $matLName = $_POST["MatLName"];
                $matLName = SanitizeUserInput($matLName);
            }
        }

        if (empty($_POST["FName"])){
            $firstNameErr = "First name is required";
            } else {
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z ]*$/",$firstName)){
                $firstNameErr = "Only letters and white space allowed"; 
            }elseif(isset($_POST["FName"])){
                $firstName = $_POST["FName"];
                $firstName = SanitizeUserInput($firstName);
            }
        }

        if (empty($_POST["SName"])){
            $secondNameErr = "Second name is required";
            } else {
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z ]*$/",$secondName)){
                $secondNameErr = "Only letters and white space allowed"; 
            }elseif(isset($_POST["SName"])){
                $secondName = $_POST["SName"];
                $secondName = SanitizeUserInput($secondName);
            }
        }

        // No need to sanitize since it's a drop-down menu
        if(isset($_POST["gender"])){
            $gender = $_POST["gender"];
        }
        
        if (empty($_POST["date_of_birth"])){
            $dateofbirthErr = "Date of birth is required";
            } else {
            // check if date only contains numbers and fwd slash
            if (!preg_match("/^[^0-9\/]*$/",$dateofbirth)){
                $dateofbirthErr = "Only numbers and fwd slash allowed"; 
            }elseif(isset($_POST["date_of_birth"])){
                $dateofbirth = $_POST["date_of_birth"];
            }
        }

        if (empty($_POST["phone_number"])){
            $phoneNumberErr = "Phone number is required";
            } else {
            // check if phone number contains numbers, dashes, and parentheses
            if (!preg_match("/\(\d{3}\)\d{3}-\d{4}/",$phoneNumber)){
                $phoneNumberErr = "Only phone numbers allowed"; 
            }elseif(isset($_POST["phone_number"])){
                $phoneNumber = $_POST["phone_number"];
            }
        }

        if (empty($_POST["facebook"])){
            $facebookErr = "Facebook name is required";
            } else {
            // check if name only contains alphanumeric & underscore
            if (!preg_match("/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/",$facebook)){
                $facebookErr = "Only alphanumeric and underscore allowed"; 
            }elseif(isset($_POST["facebook"])){
                $facebook = $_POST["facebook"];
            }
        }

        if (empty($_POST["e-mail"])){
            $emailErr = "e-mail is required";
            } else {
            // check if name only contains e-mail characters
            if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i",$email)){
                $emailErr = "Only e-mail allowed"; 
            }elseif(isset($_POST["e-mail"])){
                $email = $_POST["e-mail"];
            }
        }

        if (empty($_POST["generation"])){
            $generationErr = "Generation is required";
            } else {
            // check if name only contains numbers
            if (!preg_match("/^[1-9][0-9]{0,4}$/",$generation)){
                $generationErr = "Only numbers are allowed"; 
            }elseif(isset($_POST["generation"])){
                $generation = $_POST["generation"];
            }
        }
        
        if (empty($_POST["start_date"])){
            $startdateErr = "Start date is required";
            } else {
            // check if date only contains numbers and fwd slash
            if (!preg_match("/^[^0-9\/]*$/",$startdate)){
                $startdateErr = "Only numbers and fwd slash allowed"; 
            }elseif(isset($_POST["start_date"])){
                $startdate = $_POST["start_date"];
            }
        }

        if (empty($_POST["prosp_end_date"])){
            $enddateErr = "End date is required";
            } else {
            // check if date only contains numbers and fwd slash
            if (!preg_match("/^[^0-9\/]*$/",$enddate)){
                $enddateErr = "Only numbers and fwd slash allowed"; 
            }elseif(isset($_POST["prosp_end_date"])){
                $enddate = $_POST["prosp_end_date"];
            }
        }

        // No need to sanitize since it's a drop-down menu
        if(isset($_POST["faculty_name"])){
            $facultyName = $_POST["faculty_name"];
        }

        // No need to sanitize since it's a drop-down menu
        if(isset($_POST["learning_prog"])){
            $learningProg = $_POST["learning_prog"];
        }

        if (empty($_POST["TOEFL_score"])){
            $toeflScoreErr = "TOEFL score is required";
            } else {
            // check if name only contains numbers
            if (!preg_match("/^[1-9][0-9]{0,3}$/",$toeflScore)){
                $toeflScoreErr = "Only numbers are allowed"; 
            }elseif(isset($_POST["TOEFL_score"])){
                $toeflScore = $_POST["TOEFL_score"];
            }
        }

        if (empty($_POST["CityU_Student_ID"])){
            $cityUstudentIDErr = "CityU Student ID is required";
            } else {
            // check if name only contains numbers
            if (!preg_match("/^[1-9][0-9]{0,15}$/",$cityUstudentID)){
                $cityUstudentIDErr = "Only numbers are allowed"; 
            }elseif(isset($_POST["CityU_Student_ID"])){
                $cityUstudentID = $_POST["CityU_Student_ID"];
            }
        }

        // No need to sanitize since it's a drop-down menu
        if(isset($_POST["current_status"])){
            $currentStatus = $_POST["current_status"];
        }

        if (empty($_POST["amt_to_pay"])){
            $amttopayErr = "amount to pay is required";
            } else {
            // check if name only contains numbers, periods, and commas
            if (!preg_match("/^((?:\d\.\d{3}\.|\d{1,3}\.)?\d{1,3},\d{1,2})$/",$amttopay)){
                $amttopayErr = "Only currency is allowed"; 
            }elseif(isset($_POST["amt_to_pay"])){
                $amttopay = $_POST["amt_to_pay"];
            }
        }

        if (empty($_POST["num_of_pmts"])){
            $numofpmtsErr = "number of payments is required";
            } else {
            // check if name only contains numbers, periods, and commas
            if (!preg_match("/^((?:\d\.\d{3}\.|\d{1,3}\.)?\d{1,3},\d{1,2})$/",$numofpmts)){
                $numofpmtsErr = "Only currency is allowed"; 
            }elseif(isset($_POST["num_of_pmts"])){
                $numofpmts = $_POST["num_of_pmts"];
            }
        }

        // No need to sanitize since it's a drop-down menu
        if(isset($_POST["pmt_method"])){
            $pmtmethod = $_POST["pmt_method"];
        }

        if(isset($_POST["notes"])){
            $notes = $_POST["notes"];
            $notes = SanitizeUserInput($notes);
        }
    } /* end of server request method */
				
    /* Good for troubleshooting ****************
    * echo "First Name: $firstName<br>";
    * echo "Last Name: $lastName<br>";
    ********************************************/
                    
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

    echo "</br></br>";
    CreateMySQLUser($Student_ID, $patLName, $matLName, $firstName, $secondName, $gender, $dateofbirth, 
    $phoneNumber, $facebook, $email, $generation, $startdate, $enddate, $facultyName, $learningProg,
    $toeflScore, $cityUstudentID, $currentStatus, $amttopay, $numofpmts, $pmtmethod, $notes);
						
	function CreateMySQLUser($Student_ID, $patLName, $matLName, $firstName, $secondName, $gender, $dateofbirth, 
    $phoneNumber, $facebook, $email, $generation, $startdate, $enddate, $facultyName, $learningProg,
    $toeflScore, $cityUstudentID, $currentStatus, $amttopay, $numofpmts, $pmtmethod, $notes)
	{
		echo "<b>Creating Student Record: <i> $Student_ID $patLName $matLName $firstName </i></b><br>";
		
		//make connection	
		$conn = new mysqli("localhost", "root", "", "ruxojo_accountsreceivable") OR die(mysql_error());
		// Check connection
		if (!$conn)
		{
			die("Connection failed: " . mysqli_connect_error());
		}
        echo "<b>Connection to MySQL DB established!</b> <br>";
        
		$sql = "INSERT INTO student_table (Student_ID, last_name1, last_name2, first_name, middle_name, gender,
        date_of_birth, phone_number, facebook, e-mail, generation, start_date, prosp_end_date, faculty_name,
        learning_prog, TOEFL_score, CityU_Student_ID, current_status, notes)
		VALUES ('$Student_ID', '$patLName', '$matLName', '$firstName', '$secondName', '$gender', '$dateofbirth',
        '$phoneNumber', '$facebook', '$email', '$generation', '$startdate', '$enddate', '$facultyName',
        '$learningProg', '$toeflScore', '$cityUstudentID', '$currentStatus', '$notes')";

        $sql1 = "INSERT INTO payments_table (amt_to_pay, num_of_pmts, pmt_method)
        VALUES ('$amttopay', '$numofpmts', '$pmtmethod')";

		echo "SQL Statement: $sql <br><br>";
		if ($conn->query($sql) === TRUE && $conn->query($sql1) === TRUE)
		{
			echo "<b>New record created successfully</b><br>";
		}
		else
		{
			echo "Error: " . $sql . "<br>" . $conn->error;
		}				
		$conn->close();
	}
?>