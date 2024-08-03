<?php
session_start();
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $user_name = validate($_POST['user_name']);
    $password = validate($_POST['password']);
    $email = validate($_POST['email']);
    $name = validate($_POST['name']);
    $phone = validate($_POST['phone']);

    if (empty($user_name) || empty($password) || empty($email)) {
        header("Location: register_form.php?error=Nickname, Password, and Email are required");
        exit();
    }

    $sql = "SELECT * FROM users WHERE user_name=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $user_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        header("Location: register_form.php?error=Nickname already taken");
        exit();
    } else {
        // Password is not hashed
        $sql = "INSERT INTO users (user_name, password, name, email, phone) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $user_name, $password, $name, $email, $phone);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: register_form.php?success=Registration successful");
            exit();
        } else {
            header("Location: register_form.php?error=Something went wrong");
            exit();
        }
    }
} else {
    header("Location: register_form.php");
    exit();
}
?>
