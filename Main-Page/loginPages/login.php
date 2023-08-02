<?php
session_start();

if (isset($_SESSION["error"])) {
    if ($_SESSION["error"] == 1) {
        $errorMessage = true;
    } else {
        $errorMessage = false;
    }
} else {
    $errorMessage = false;
}

if (isset($_SESSION["login"]) && ($_SESSION["login"] == true) && isset($_COOKIE["login"]) && ($_COOKIE["login"] == true)) {
    if ($_SESSION["isStudent"]) {
        header("Location:../studentPages/webPages/studentPage.php");
        exit();
    }
    header("Location:../facultyPages/webPages/facultyUploadPage.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="loginPageStyleSheet.css?v=10">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="loginCheck.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="container col-lg-5">
        <div class="row justify-content-center welcome-text">
            <h1>Welcome!</h1>
        </div>
        <div class="row justify-content-center login-container">
            <div class="col-md-6 col-lg-5">
                <h2 class="text-center mb-4">Login page</h2>
                <?php if ($errorMessage) : ?>
                    <script>
                        alert("User details in database please try again with valid credentials");
                    </script>
                <?php endif; ?>
                <form action="loginCheck.php" method="post">

                    <div class="form-group">

                        <label for="email">Email</label><br>
                        <input type="email" class="form-control" id="email" placeholder="lorem@mahindrauniversity.edu.in" name="email"><br>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Password</label><br>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>


</html>