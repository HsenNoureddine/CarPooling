<?php

// purpose
// this is the database for a car pooling php project, here we initialize the database when entering the project for the first time

require("env.php");
require("connection.php");

//checking if its the first time opening the project
$f = fopen("dbStatus","r");
$status = fgets($f);
fclose($f);

if($status == $INIT)
{
    echo $INIT;
    exit();
}

//create database , name found in env.php
$con->query("CREATE DATABASE ".$DBNAME);

//select database
$con->query("USE ".$DBNAME);


//create tables

//users table
$con->query("CREATE TABLE USERS(
    userid int not null auto_increment,
    fullname varchar(20) not null,
    username varchar(20) not null,
    password varchar(20) not null,
    location varchar(20) not null DEFAULT 0,
    destination varchar(20) not null DEFAULT 0,
    active int(1) DEFAULT 0,
    email varchar(25),
    phonenumber varchar(20) not null,
    usertype int not null,
    PRIMARY KEY(userid)
);");

//drivers table
$con->query("CREATE TABLE DRIVERS(
    carid varchar(20) not null,
    userid int not null, 
    rating int DEFAULT 0,
    numberOfrides int DEFAULT 0,
    PRIMARY KEY(carid),
    FOREIGN KEY(userid) REFERENCES USERS(userid)
);");

//rides table
$con->query("CREATE TABLE RIDES(
    rideid int not null auto_increment,
    driverid int not null,
    passengerid int not null,
    price float(8,2),
    location varchar(50),
    PRIMARY KEY(rideid),
    FOREIGN KEY(driverid) REFERENCES USERS(userid),
    FOREIGN KEY(passengerid) REFERENCES USERS(userid)
);");

// procedure , this procedure will increment the number of rides done by driver each time a ride is done and it will update his rating accoring to the new value
$con->query("CREATE PROCEDURE increaseNumRides(@driverid AS INT)
    AS
    BEGIN
    SELECT @avg = avg(rating) from RIDES;
    UPDATE DRIVERS SET numberofrides += 1,rating = @avg WHERE driverid = @driverid;
    END
;");
$con->query("CREATE TRIGGER ON RIDES 
    AFTER INSERT
    AS
    BEGIN
    SELECT @driverid = driverid from INSERTED;
    EXEC increaseNumRides @driverid;
    END
");

// updating status of project so db wont be initialized twice
$f = fopen("dbStatus","w");
fwrite($f,"".$INIT);
$con->close();

?>