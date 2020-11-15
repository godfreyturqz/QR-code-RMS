<?php
//include command must be inside the function

function getDateToday(){
    //today's date and time
    date_default_timezone_set("Asia/Manila");
    $dt = new DateTime();
    $date = $dt->format('Y-m-d');

    return $date;
}
function getTimeToday(){
    //today's date and time
    date_default_timezone_set("Asia/Manila");
    $dt = new DateTime();
    $time = $dt->format('H:i:s');

    return $time;
}

function countAttendanceToday(){
    $date = getDateToday();
    include 'conn.php';
    $sql= "SELECT DISTINCT idnum FROM login WHERE date='$date';";
    $object = mysqli_query($conn, $sql);
    $rowcount = mysqli_num_rows($object);

    return $rowcount;
}
function countAdminAttendanceToday(){
    $date = getDateToday();
    include 'conn.php';
    $sql= "SELECT DISTINCT idnum FROM login WHERE date='$date';";
    $object = mysqli_query($conn, $sql);
    $rowcount = mysqli_num_rows($object);

    return $rowcount;
}
function countRegToday(){
    //today's date and time
    date_default_timezone_set("Asia/Manila");
    $dt = new DateTime();
    $date = $dt->format('Y-m-d');
    $time = $dt->format('H:i:s');

    include 'conn.php';
    $sql= "SELECT DISTINCT idnum FROM list WHERE regdate='$date';";
    $object = mysqli_query($conn, $sql);
    $rowcount = mysqli_num_rows($object);

    return $rowcount;
}


function countRegTotal(){
    include 'conn.php';
    $sql= "SELECT DISTINCT id FROM list;";
    $object = mysqli_query($conn, $sql);
    $rowcount = mysqli_num_rows($object);

    return $rowcount;
}
function countAdminTotal(){
    include 'conn.php';
    $sql= "SELECT DISTINCT idnum FROM list WHERE position = 'Admin';";
    $object = mysqli_query($conn, $sql);
    $rowcount = mysqli_num_rows($object);

    return $rowcount;
}
function countPatientTotal(){
    include 'conn.php';
    $sql= "SELECT DISTINCT idnum FROM list WHERE position = 'Patient';";
    $object = mysqli_query($conn, $sql);
    $rowcount = mysqli_num_rows($object);

    return $rowcount;
}
function countOthersTotal(){
    include 'conn.php';
    $sql= "SELECT DISTINCT idnum FROM list WHERE position = 'Others';";
    $object = mysqli_query($conn, $sql);
    $rowcount = mysqli_num_rows($object);

    return $rowcount;
}
function getLastData($tableName, $colName){
    include 'conn.php';
    $sql= "SELECT * FROM $tableName ORDER BY id DESC;";
    $object = mysqli_query($conn, $sql);
    $array = mysqli_fetch_assoc($object);
    $value = $array[$colName];

    return $value;
}
