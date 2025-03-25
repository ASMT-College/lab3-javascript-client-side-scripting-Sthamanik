<?php
require_once '../connection/dbconn.php';

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    $validcredentials = true;

    // Validate username
    $usernameregex = '/^[a-zA-Z ]{3,30}$/';
    if (empty($username) || !preg_match($usernameregex, $username)) {
        $response['usernameError'] = "Enter a valid username (3-30 characters, no special characters or numbers).";
        $validcredentials = false;
    }

    // Validate email format and check existence
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['emailError'] = "Enter a valid email address.";
        $validcredentials = false;
    } else {
        $existingEmail = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
        if (mysqli_num_rows($existingEmail) > 0) {
            $response['emailError'] = "Duplicate email address.";
            $validcredentials = false;
        }
    }

    // Validate password
    $passwordregex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
    if (empty($password) || !preg_match($passwordregex, $password)) {
        $response['passwordError'] = "Password must be at least 8 characters, contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
        $validcredentials = false;
    }

    // Validate confirmed password
    if (empty($cpassword)) {
        $response['cpasswordError'] = "Confirmed password can't be empty.";
        $validcredentials = false;
    } elseif ($cpassword != $password) {
        $response['cpasswordError'] = "Confirmed password does not match.";
        $validcredentials = false;
    }

    // If all validations pass, insert user into database
    if ($validcredentials) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
        
        if (mysqli_query($conn, $query)) {
            $response["success"] = true;
            $response["message"] = "User registered successfully!";
        } else {
            $response["success"] = false;
            $response["message"] = "Error: " . mysqli_error($conn);
        }
    } else {
        $response["success"] = false;
    }

}else{
    $response['success'] = false;
    $response['errorMessage'] ="Unsupported method request";
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);