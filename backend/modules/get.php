<?php
header('Content-Type: application/json');

// Include database connection
include '../config/connection.php';

// Define a key for encryption
$key = '1234567890123456'; // 16 characters for AES-128-CBC
$iv = '1234567890123456'; // 16 characters for AES-128-CBC

// SQL query to get all students
$sql = "SELECT * FROM students";
$result = $conn->query($sql);

$students = []; // Initialize an array to hold student data

// Check if there are results
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $students[] = $row; // Add each student to the array
    }
}

// Encrypt the JSON data
$json_data = json_encode($students);
$encrypted_data = openssl_encrypt($json_data, 'AES-128-CBC', $key, 0, $iv);

// Output the encrypted data
echo $encrypted_data;

// Close connection
$conn->close();
?>
