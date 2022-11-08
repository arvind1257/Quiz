<?php
    session_start();
    require('checksession.php');
    if(isset($_FILES['photo']))
    {
        $errors= array();
        $file_name = $_FILES['photo']['name'];
        $file_size =$_FILES['photo']['size'];
        $file_tmp =$_FILES['photo']['tmp_name'];
        $file_type=$_FILES['photo']['type'];
        $file_ext=strtolower(end(explode('.',$_FILES['photo']['name'])));

        $extensions= array("jpeg","jpg","png");

        if(in_array($file_ext,$extensions)=== false){
           $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }
        if(empty($errors)==true)
        {
           move_uploaded_file($file_tmp,$file_name);
           if(mysqli_query($con,"update login set photo='$file_name' where uid='$uid'"))
           {
               header("Location: setting.php");
           }
        }else{
           print_r($errors);
        }
    }