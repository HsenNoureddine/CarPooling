<?php

$HOST="localhost";
$USERNAME="root";
$PASSWORD="";
$DBNAME="carpool";

$NOTINIT = "NotInitialized";
$INIT = "Initialized";

// make sure function isnt being redeclared
if(!function_exists("STYLE"))
{
    function STYLE($s)
    {
        echo "../view/".$s."/style.css";
    }
}
if(!function_exists("js"))
{
    function JS($s)
    {
        echo "../view/".$s."/app.js";
    }
}



?>