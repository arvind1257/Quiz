<?php
if(!isset($_SESSION["uid"]) || !isset($_SESSION["uname"]) || !isset($_SESSION["utype"]))
{
    
    header("Location: index.php");
    exit();
}
else
{
    $con = mysqli_connect("localhost","root","123456","quiz");
    $uid = $_SESSION["uid"];
    $uname = $_SESSION["uname"];
    $utype = $_SESSION["utype"];
}