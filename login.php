<?php
session_start();
include "db_connect.php";

function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['uname']) && isset($_POST['password'])) {
    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);

    if (empty($uname)) {
        header("Location: loginSystem.php?error=Username is required");
        exit();
    } else if (empty($pass)) {
        header("Location: loginSystem.php?error=Password is required");
        exit();
    }


    $sql = "SELECT * FROM usern WHERE user_name = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $uname, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user_name'] = $row['user_name'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['ID'] = $row['ID'];
        header("Location: Homepage.php");
        exit();
    }

  
    $sql = "SELECT * FROM agents WHERE agent_uname = ? AND agent_pass = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $uname, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user_name'] = $row['agent_uname'];
        $_SESSION['name'] = $row['agent_name'];
        $_SESSION['ID'] = $row['ID'];
        header("Location: Home.php");
        exit();
    }

    header("Location: loginSystem.php?error=Incorrect Username or Password");
    exit();
} else {
    header("Location: loginSystem.php");
    exit();
}
?>
