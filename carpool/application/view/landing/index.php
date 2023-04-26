<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
     integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
     crossorigin=""/>
     <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
     integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
     crossorigin=""></script>
     <link rel="stylesheet" href=<?php STYLE("landing")?> >
     <script src=<?php JS("landing")?> defer></script>
    <title>start your journey</title>
</head>
<body>
    <h1>Hello <?php echo($userTitle." ".$username) ?> 👋 </h1>
    <h2>Start A Ride!</h2>
    <div id="map"></div>
    <form action="#" method="GET">

        <!-- cur location -->
        <input type="text" name="lat" hidden>
        <input type="text" name="lng" hidden>
        <!-- dest location -->
        <input type="text" name="destlat" hidden>
        <input type="text" name="destlng" hidden>

        <div><input type="submit" value="search" name="search"></div>
        <div><?php echo($driverList) ?></div>
        <div><input type="submit" value="choose" name="choose"></div>
    </form>
    <?php
    if($passengers != null)
    {
        echo("<h2>Passengers Looking For A Ride With You!</h2>");
        foreach($passengers as $passenger)
        {
            $arr = explode(" ",$passenger);
            echo("<h4> username: ".$arr[0]."<br> income: ".$arr[1]."<br> phone: ".$arr[2]." "."</h4>");
            echo("<br>");
        }
    }
    if(isset($_COOKIE["ride"]))
    {
        echo "you are on a ride with ". $_COOKIE["ride"];
    }
    ?>

</body>
</html>