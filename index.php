<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"> 
        <link rel="icon" href="icon.png">
        <title>Quiz Management</title>
        <style>
            *{
                margin:0px;
                box-sizing: border-box;
            }
            .center { margin-left: auto; margin-right: auto;}
            .header{ width:100%; background-color: #0ead88; padding:10px 10px;
                     font-family: timesnewroman; color:white; position:fixed; 
                     z-index:1; top:0%;}
            body { font-family: Arial;  }
            .maincontent{ margin-top: 80px; width:50%; border-top: 7px solid #0ead88; 
                          color:#0ead88; box-shadow: 0px 0px 10px 5px grey; 
                          background-color: white; padding:20px;}
            .form_header{ text-align:center;font-size:50px; font-family:timesnewroman; 
                          word-wrap:break-word;}
            .login__field { position: relative; margin:15px;}
            .login__icon { position: absolute; padding:0px 5px; top: 25px; 
                          color: #0ead88; width:50px; height:50px; }  
            .login__input { padding: 10px; padding-left: 50px; width: 100%; 
                           font-size:22pt; height: 70px; }  
            .button{ padding:10px 20px; background-color:#0ead88; color:white; 
                     width:80%; font-size:35px; cursor: pointer; }
            .button:hover { background-color:#0a6e56; }
        </style>
        <script>
            window.history.forward();
        </script>
    </head>
    <body> 
        <div class="header">
            <center>
                <font size="6px">
                    <b>
                        <img align="left" src="icon.png" style="width:35px; height:35px;" alt="no image">Quiz Management System
                    </b>
                </font>
            </center>
        </div>
        <?php
            session_start(); 
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Pragma: no-cache");
            $error = "";
            if(isset($_POST['submit'])) 
            { 
                
                $uname = "";
                $utype = "";
                $uid = $_POST['username'];
                $password = $_POST['password'];
                $con = mysqli_connect("localhost","root","123456","quiz");
                $sql="select * from login where uid = '$uid' and password = '$password'";
                $result = mysqli_query($con,$sql);
                if($rows = mysqli_fetch_assoc($result))
                {
                    $uname = $rows["FNAME"]." ".$rows["LNAME"];
                    $utype = $rows["UTYPE"];
                    $_SESSION["uid"] = $uid;
                    $_SESSION["uname"] = $uname;
                    $_SESSION["utype"] = $utype;
                    header("Location: dashboard.php");
                }
                else
                {
                    $error = "Invalid Username or Password";
                }
                echo mysqli_error($con);
            }
            if(isset($_SESSION["msg1"]) && $error == "")
            {
                $error = $_SESSION["msg1"];
                unset($_SESSION["msg1"]);
            }
            
        ?>
        <div class="maincontent center">
            <h1 class="form_header">LOGIN</h1>
            <br>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1" onsubmit="return validate()">  
                <center>
                    <div class="login__field">
                        <i class = "login__icon fas fa-user"> </i> 
                        <input value="20BCE2633" class="login__input" type="text" name="username" placeholder="Username"  title="Registration ID" required/>
                    </div>
                        <br>
                    <div class="login__field">
                        <i class = "login__icon fas fa-lock"> </i> 
                        <input value="arvind123" class="login__input" type="password" name="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z]).{8,}"  title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required/>
                    </div>
                        <br>
                        <div>
                            <font color="red"><?php echo $error;?></font>
                        </div>    
                        <br>
                    <div style="float:left; margin:15px; word-wrap:break-word; font-size:18pt;">
                        <a href="index.html">Forgot Password?</a>
                    </div>
                    <div style="float:right; margin:15px; word-wrap:break-word; font-size:18pt;">
                        <a href="signup.html">Sign up?</a>
                    </div>
                        <br><br><br><br><br><br>
                    <input class="button" type="submit" name="submit" value="Login"/>
                </center>
            </form>         
        </div>
    </body>
</html>
