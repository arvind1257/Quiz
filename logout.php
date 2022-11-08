<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="icon.png">
        <title>Quiz Management</title>
    </head>
    <body>
        <?php
            session_start();
            unset($_SESSION["uid"]);
            unset($_SESSION["uname"]);  
            unset($_SESSION["utype"]);
            $_SESSION["status1"] = "done";
            $_SESSION["msg1"] = "Successfully Logout";
            header("Location: index.php");
        ?>
    </body>
</html>


