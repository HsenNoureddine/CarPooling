<?php

require("../../connection.php");

require("../view/login/index.php");
require("../model/login.php");

if(isset($_POST["submit"]) && isset($_POST["username"]))
{
   //checks if data is right
   $res = auth($_POST["username"],$_POST["password"],$con,$DBNAME);

   //in case info was valid
   if($res)
   {
      setcookie("login",true, time() + 86400/24);
      setcookie("userid",$res["userid"], time() + 86400/24);
      setcookie("usertype",$res["usertype"], time() + 86400/24);
      setcookie("username",$_POST["username"], time() + 86400/24);
      header("location: ./landing.php");
   }
}

?>