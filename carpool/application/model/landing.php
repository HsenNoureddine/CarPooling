<?php
    function haversineGreatCircleDistance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);
    
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;
    
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }
    function search($cur,$dest,$userid,$con,$DBNAME)
    {
        $con->query("USE ".$DBNAME);

        //set my location and destination
        $result = $con->query("UPDATE USERS SET location='$cur' , destination='$dest' 
        WHERE userid='$userid'");

        //get drivers nearby going to a similar location
        $data = $con->query("SELECT * from USERS WHERE usertype='1'");

        $drivers = [];

        while($row = $data->fetch_assoc())
        {
            if($dest == ",")continue;
            //location not set
            if($row["userid"] == $userid || 
            $row["location"] == "0" || $row["destination"] == "0")continue;

            $cur = explode(",",$row["location"]);
            $ct = $cur[0];
            $cg = $cur[1];

            $dest = explode(",",$row["destination"]);
            $dt = $dest[0];
            $dg = $dest[1];

            // distance forumla using longitude and latitude
            // dist=acos(sin(lat1)*sin(lat2)+cos(lat1)*cos(lat2)*cos(lon2-lon1))*6371

            $lat1 = $ct;
            $lon1 = $cg;
            $lat2 = $dt;
            $lon2 = $dg;
            $dist = haversineGreatCircleDistance($lat1,$lon1,$lat2,$lon2);

            $drivers[$row["username"]] = ["ct"=>$ct,"cg"=>$cg,"dt"=>$dt,"dg"=>$dg,"dist"=>$dist,"userid"=>$row["userid"]];
        }

        return $drivers;
    }
    function choose($driverid,$passengerid,$distance,$destination,$con,$DBNAME)
    {
        $con->query("USE ".$DBNAME);
        $data = $con->query("SELECT * FROM RIDES where passengerid='$passengerid'");
        $data = $data->fetch_assoc();
        if($data == null)
        {
            $price = $distance / 20;
            $con->query("INSERT INTO RIDES (`driverid`,`passengerid`,`price`
            ,`location`) VALUES ('$driverid','$passengerid','$price','$destination')");
        }
        else
        {
            echo "already on a ride";
            $data = explode(",",$data["location"]);
            $destlat = $data[0];
            $destlng = $data[1];
            setcookie("destlat",$destlat, time() + 86400/24);
            setcookie("destlng",$destlng, time() + 86400/24);
        }
        
    }
    function listPassengers($userid,$con,$DBNAME)
    {
        $con->query("USE ".$DBNAME);

        $data = $con->query("SELECT usertype FROM USERS WHERE userid='$userid'");
        $data = $data->fetch_assoc();

        if($data["usertype"] == "0")return;
        

        $data = $con->query("SELECT * FROM RIDES WHERE driverid='$userid'");

        $passengers = [];
        while($row = $data->fetch_assoc())
        {
            $passengerid = $row["passengerid"];
            $passenger = $con->query("SELECT * FROM USERS WHERE userid='$passengerid'");
            $passenger = $passenger->fetch_assoc();
            $passengers[] = $passenger["username"]." ".$row["price"]."$ ".$passenger["phonenumber"];
        }
        return $passengers;

    }

?>