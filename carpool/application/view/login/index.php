<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href=<?php STYLE("login") ?>>
</head>

<body>   
    <div class="login">
        <form action="#" method="POST">
            <h1>Login</h1>
            <div><label>username:</label> <input type="text" id="username" name="username" required></div>
            <div><label>password:</label> <input type="password" id="password" name="password" required></div>
            <input type="submit" value="login" name="submit"/>
            <a href="register.php">Register</a>
        </form>
    </div>
</body>

</html>