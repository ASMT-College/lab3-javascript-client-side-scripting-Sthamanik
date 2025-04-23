<?php
require_once '../connection/dbconn.php';

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $validCredentials = true;
    
    // validate email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['emailError'] = "Enter a valid email address.";
        $validCredentials = false;
    }
    
    // Validate password
    $passwordregex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
    if (empty($password) || !preg_match($passwordregex, $password)) {
        $response['passwordError'] = "Password must be at least 8 characters, contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
        $validCredentials = false;
    }

    $response["success"] = false;
    if ($validCredentials) {
        // fetch request to the server using email
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $fetchedPassword = $row['password'];
            
            // verify password using password_verify() function
            if (password_verify($password, $fetchedPassword)){
                $response['success'] = true;
                $_SESSION['user_id'] = $row['id'];
                $response['user'] = $row['username'];
                $response['message'] = 'Logged in Successfully';
            }else
                $response["passwordError"] = "Enter valid credentials";
        }else
            $response["errorMessage"] = "Email not found wanna signup?";
    }else{
        $response["emailError"] = "Enter valid credentials";
    }
}
else{
    $response["errorMessage"] = "Unsupported Method Request";
    $response["success"] = false;
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);