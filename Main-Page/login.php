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
    <form class="form text-center" action="form.php" method="post" onsubmit="return checker()">

        <label for="email">Email</label><br>
        <input type="email" id="email" placeholder="lorem@mahindrauniversity.edu.in" name="email"><br>
        <label for="pwd">Password</label><br>
        <input type="password" id="pwd" name="pswd">

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>
    </div>
</body>

</html>