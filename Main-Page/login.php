<?php
session_start();

if (isset($_SESSION["error"])) {
    if ($_SESSION["error"] == 1) {
        $errorMessage = true;
    } else {
        $errorMessage = false;
    }
}else{
    $errorMessage = false;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="loginCheck.js"></script>
    <title>Document</title>
</head>

<body>
    <h2>Login page</h2>
    <?php if ($errorMessage) : ?>
        <script>
            alert("User details in database please try again with valid credentials");
            return false;
        </script>
    <?php endif; ?>
    <form action="loginCheck.php" method="post">

        <label for="email">Email</label><br>
        <input type="email" id="email" placeholder="lorem@mahindrauniversity.edu.in" name="email"><br>
        <label for="pwd">Password</label><br>
        <input type="password" id="password" name="password">
        <input type="submit" value="Submit">
    </form>
    </div>
    </div>
</body>

</html>