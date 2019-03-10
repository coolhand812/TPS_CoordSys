<?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST")
                    {
                        if(isset($_POST["Student_ID"])){
                            $Student_ID = $_POST["Student_ID"];
                            $Student_ID = SanitizeUserInput($Student_ID);
                        }
                        if(isset($_POST["FName"])){
                            $firstName = $_POST["FName"];
                            $firstName = SanitizeUserInput($firstName);
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
                ?>