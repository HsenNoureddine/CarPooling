<?php

require("../../connection.php");

require("../view/register/index.php");
require("../model/register.php");

if(isset($_POST["submit"]))
{
    //adds user to db
    register($_POST,$con,$DBNAME);
}

?>