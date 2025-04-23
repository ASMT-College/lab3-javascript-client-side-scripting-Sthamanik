<?php 
    $dotenv = parse_ini_file('../.env');

    $host = $dotenv['DB_HOST'];
    $user = $dotenv['DB_USER'];
    $pass = $dotenv['DB_PASS'];
    $dbname = $dotenv['DB_NAME'];

    $conn = mysqli_connect($host, $user, $pass, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // echo "Connected successfully!";
