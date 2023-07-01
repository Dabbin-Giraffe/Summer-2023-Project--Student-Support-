<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="login.php" method="post">
        <input type="text" name="studId"><br>
        <input type="submit" value="Submit">
    </form>
</body>

</html>

<?php
if (isset($_POST["studId"])) {
    $_SESSION["id"] = $_POST["studId"];
    header("Location: index.php");
}
?>