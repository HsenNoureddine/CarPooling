<?php
    // makes sure user is logged in every hour
    if(!isset($_COOKIE["login"]) || !$_COOKIE["login"])
    {
        echo "please login";
        exit();
    }

    require("../../connection.php");
    require("../model/landing.php");

    $username  = $_COOKIE["username"];
    $driverList = '<select name="ride"></select>';

    $userTitle = "Passenger";
    if($_COOKIE["usertype"] == 1)
    {
       $userTitle = "Driver";
    }


    $passengers = listPassengers($_COOKIE["userid"],$con,$DBNAME);

    if(isset($_GET["search"]))
    {
        $userid = $_COOKIE["userid"];

        $curlat = $_GET["lat"];
        $curlng = $_GET["lng"];
        $cur = substr($curlat,0,8).",".substr($curlng,0,8);

        $destlat = $_GET["destlat"];
        $destlng = $_GET["destlng"];
        $dest = substr($destlat,0,8).",".substr($destlng,0,8);
        

        if(!isset($_COOKIE["destlat"]))
        {
            setcookie("destlat",$destlat, time() + 86400/24);
            setcookie("destlng",$destlng, time() + 86400/24);
        }
        else
        {
            $destlat = $_COOKIE["destlat"];
            $destlng = $_COOKIE["destlng"];
        }

        $drivers = search($cur,$dest,$userid,$con,$DBNAME);
        
        $driverList = '<select name="ride">';
        foreach($drivers as $key=>$driver)
        {
            $dist = haversineGreatCircleDistance($curlat,$curlng,$driver["ct"],$driver["cg"]);
            // if driver current location is more than 2km away we dont show
            if($dist > 5)continue;

            $dist = haversineGreatCircleDistance($destlat,$destlng,$driver["dt"],$driver["dg"]);
            // if driver destination is more than 2km away we dont show
            if($dist > 5)continue;


            $driverList .= "<option value=".$driver["userid"].">".$key."</option>";
    
            $markersList = $key.".-.".$driver["ct"].".-.".$driver["cg"];
            setcookie($driver["userid"]."driver",$markersList, time() + 86400/24);
        }
        $driverList .= "</select>";
    }

    if(isset($_GET["choose"]))
    {
        $curlat = $_GET["lat"];
        $curlng = $_GET["lng"];


        $destlat = $_GET["destlat"];
        $destlng = $_GET["destlng"];
        $dest = substr($destlat,0,8).",".substr($destlng,0,8);

        if(!isset($_COOKIE["destlat"]))
        {
            setcookie("destlat",$destlat, time() + 86400/24);
            setcookie("destlng",$destlng, time() + 86400/24);
        }
        else
        {
            $destlat = $_COOKIE["destlat"];
            $destlng = $_COOKIE["destlng"];
        }

        $dist = haversineGreatCircleDistance($curlat,$curlng,floatval($destlat),floatval($destlng));
        
        if(!isset($_COOKIE["ride"]))
        {
            choose($_GET["ride"],$_COOKIE["userid"],floatval($dist),$dest,$con,$DBNAME);
            setcookie("ride",$_GET["ride"], time() + 86400/24);
        }
    }



    require("../view/landing/index.php");




   
?>