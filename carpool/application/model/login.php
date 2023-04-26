<?php
function auth($username,$password,$con,$DBNAME)
{
    $con->query("USE ".$DBNAME);
    $data = $con->query("SELECT * FROM USERS WHERE username='$username'");
    if(!$data)var_dump($con);
    else
    {
        $data = $data->fetch_assoc();
        if(isset($data["password"]) && $password == $data["password"])
        {
            echo "great success";
            return $data;
        }
        else
        {
            echo "invalid information";
            return false;
        }
    } 
}
?>