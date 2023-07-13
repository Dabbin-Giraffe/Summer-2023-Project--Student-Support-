<?php
session_start();
include_once "connect.php";

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = strtolower($data);
    return $data;
}

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = validate($_POST["email"]);
    $password = validate($_POST["password"]);

    $stmt = $conn->prepare("SELECT flag,firstName,lastName,userID,isStudent FROM user WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->bind_result($flag, $firstName, $lastName, $userID, $isStudent);
    if (!($stmt->fetch())) {
        header("Location:login.php?" );
        $_SESSION["error"] = 1;
        exit();
    } else {
        $_SESSION["id"] = $userID;
        $_SESSION["firstName"] = $firstName;
        $_SESSION["lastName"] = $lastName;
        $_SESSION["error"] = 0;
        $_SESSION["login"] = true;
        $expiryTime = time() + (60*60*24);
        setcookie("login","true",$expiryTime,'/');
        if ($isStudent) {
            $_SESSION["flag"] = $flag;
            $_SESSION["isStudent"] = true;
            header("Location:studentPage.php");
            exit();
        }else{
            $_SESSION["isStudent"] = false;
            header("Location:facultypage.php");
            exit();
        }
    }
}
echo "hello";
