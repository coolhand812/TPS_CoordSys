<?php
    // Establishing Connection with Server by passing server_name, user_id and password as a parameter
    $db = new mysqli("localhost", "root", "", "ruxojo_accountsreceivable");
    session_start();// Starting Session    

    // Storing Session
    $user_check=$_SESSION['login_user'];

    // SQL query to fetch information of registerd users and finds user match.
    $stmt = $db->prepare("SELECT user FROM admin_table WHERE user_level=?");
    $stmt->bind_param('s', $user_check); 
    $stmt->execute();
    $stmt->store_result();    
    $stmt->bind_result($user_check);
    $login_session = $user_check;

    if(!isset($login_session)){
        $stmt->close(); // Closing Connection
        header('Location: index.html'); // Redirecting To Home Page
    }
?>