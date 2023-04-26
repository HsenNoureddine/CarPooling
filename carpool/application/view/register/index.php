<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?php STYLE("register") ?>>
    <title>register</title>
</head>
<body>
<div class="login">
        <form action="register.php" method="POST">
            <h1>Register as Passenger</h1>
            <div><label>fullname:</label> <input type="text" id="fullname" name="fullname" required></div>
            <div><label>username:</label> <input type="text" id="username" name="username" required></div>
            <div><label>password:</label> <input type="password" id="password" name="password" required></div>
            <div><label>email:</label> <input type="text" id="email" name="email" required></div>
            <div><label>phone:</label> <input type="text" id="phone" name="phone" required></div>
            <div id="checkIfDriver"><label>if driver:</label> <input type="checkbox" value="driver" name="driver"> </div>
            <div id="choice"><label>car id:</label> <input type="text" id="carId" name="carId"></div>
            <input type="submit" value="register" name="submit"/>
            <a href="login.php">Login</a>
        </form>
    </div>
</body>
</html>