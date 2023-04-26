<?php
require("env.php");

//check if initialized
$f = fopen("dbStatus","r");
$status = fgets($f);
fclose($f);

if($status == $NOTINIT)
{
    require("initialize.php");
}


//send to login page
header("Location: http://".$HOST."/carpool/application/controller/login.php");
?>