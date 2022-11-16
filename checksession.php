<?php
if(!isset($_SESSION["uid"]) || !isset($_SESSION["uname"]) || !isset($_SESSION["utype"]))
{
    
    header("Location: index.php");
    exit();
}
else
{
    $con = mysqli_connect("sql12.freesqldatabase.com","sql12575246","jpuCIqBGV5","sql12575246");
    $uid = $_SESSION["uid"];
    $uname = $_SESSION["uname"];
    $utype = $_SESSION["utype"];
}