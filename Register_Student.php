<?php
    // define variables and set to empty values
    $Student_ID = $firstName = $secondName = $patLName = $matLName = $firstNameErr = "";
    $startdate = $enddate = $facultyName = $learningProg = $notes = $StudentIDerr = "";

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

        if(isset($_POST["SName"])){
            $secondName = $_POST["SName"];
            $secondName = SanitizeUserInput($secondName);
        }

        if(isset($_POST["PatLName"])){
            $patLName = $_POST["PatLName"];
            $patLName = SanitizeUserInput($patLName);
        }

        if(isset($_POST["MatLName"])){
            $matLName = $_POST["MatLName"];
            $matLName = SanitizeUserInput($matLName);
        }

        if(isset($_POST["start_date"])){
            $startdate = $_POST["start_date"];
            $startdate = SanitizeUserInput($startdate);
        }

        if(isset($_POST["prosp_end_date"])){
            $enddate = $_POST["prosp_end_date"];
            $enddate = SanitizeUserInput($enddate);
        }

        if(isset($_POST["faculty_name"])){
            $facultyName = $_POST["faculty_name"];
        }

        if(isset($_POST["learning_prog"])){
            $learningProg = $_POST["learning_prog"];
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
    CreateMySQLUser($Student_ID, $patLName, $matLName, $firstName, $secondName, $startdate,
     $enddate, $facultyName, $learningProg, $notes);
						
	function CreateMySQLUser($Student_ID, $patLName, $matLName, $firstName, $secondName, $startdate,
    $enddate, $facultyName, $learningProg, $notes)
	{
		echo "<b>Creating Student Record: <i> $Student_ID $patLName $matLName </i></b><br>";
		
		//make connection	
		$conn = new mysqli("localhost", "root", "", "ruxojo_accountsreceivable") OR die(mysql_error());
		// Check connection
		if (!$conn)
		{
			die("Connection failed: " . mysqli_connect_error());
		}
		echo "<b>Connection to MySQL DB established!</b> <br>";
		$sql = "INSERT INTO Student_Table (Student_ID, last_name1, last_name2, first_name, middle_name,
         start_date, prosp_end_date, faculty_name, learning_prog, notes)
		VALUES ('$Student_ID', '$patLName', '$matLName', '$firstName', '$secondName', '$startdate',
         '$enddate', '$facultyName', '$learningProg', '$notes')";
						
		echo "SQL Statement: $sql <br><br>";
		if ($conn->query($sql) === TRUE)
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