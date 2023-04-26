<?php

function register($info,$con,$DBNAME)
{
    $con->query("USE ".$DBNAME);
    if(isset($info["driver"]) && $info["carId"] == "")
    {
        echo "<script>alert('must fill car id as a driver to proceed');</script>";
        exit(); 
    }

    $fullname = $info["fullname"];
    $username = $info["username"];
    $password = $info["password"];
    $email = $info["email"];
    $phone =  $info["phone"];
    $carId = $info["carId"]; 
    if(isset($info["driver"]))
    {
        $data = $con->query("INSERT INTO `users`(`fullname`, `username`, `password`, `email`, `phonenumber`, `usertype`) 
        VALUES ('$fullname','$username','$password','$email','$phone',1);");
        if(!$data)var_dump($con);
    }
    else
    {
        $data = $con->query("INSERT INTO `users`(`fullname`, `username`, `password`, `email`, `phonenumber`, `usertype`) 
        VALUES ('$fullname','$username','$password','$email','$phone',0)");
        if(!$data)var_dump($con);
    }
}

?>