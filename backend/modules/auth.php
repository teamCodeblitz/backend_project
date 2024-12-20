<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include '../config/connection.php';

$data = json_decode(file_get_contents("php://input"));

if (isset($data->action) && $data->action === 'register') {
    // Registration logic
    $userName = $data->userName;
    $password = password_hash($data->password, PASSWORD_DEFAULT); // Hash the password

    // Get the current maximum studno and increment it
    $sql = "SELECT MAX(studno) AS max_studno FROM users";
    $result = $conn->query($sql);
    $maxStudno = $result->fetch_assoc()['max_studno'];
    $token = $maxStudno + 1; // Increment studno for the new user

    $sql = "INSERT INTO users (studno, userName, password, token) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $token, $userName, $password, $token);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Registration successful", "token" => $token]);
    } else {
        echo json_encode(["message" => "Registration failed"]);
    }

    $stmt->close();
} elseif (isset($data->action) && $data->action === 'login') {
    // Login logic  
    $userName = $data->userName;
    $password = $data->password;

    $sql = "SELECT * FROM users WHERE userName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            echo json_encode(["message" => "Login successful", "userId" => $user['studno'], "token" => $user['token']]);
        } else {
            echo json_encode(["message" => "Invalid password"]);
        }
    } else {
        echo json_encode(["message" => "User not found"]);
    }

    $stmt->close();
} else {
    echo json_encode(["message" => "Invalid action"]);
}

$conn->close();
?>
