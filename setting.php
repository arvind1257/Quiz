<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="icon.png">
        <title>Quiz Management</title>
        <style>
            *{
                margin:0px;
                box-sizing: border-box;
            }
            .center { 
                margin-left: auto; 
                margin-right: auto;
            }
            .header{ 
                width:100%; 
                font-size:30px;
                background-color: #0ead88;
                padding:10px 30px 10px 10px;
                font-family: timesnewroman; 
                color:white; 
            }
            body { 
                font-family: Arial; 
            }
            .tabcontent { 
                float: right; 
                padding: 10px 15px; 
                width: 74%; 
            }
            .menu { 
                padding:25px 10px;
                float: left;  
                width: 25%; 
                color:white;
                
            }
            fieldset{
                
                border:3px solid white;
                border-style:groove;
                padding: 20px;
                height:520px;
            }
            .logoutbutton{
                width:50%;
                color:white;
                padding:10px;
                cursor: pointer;
                border-radius:20px;
                font-weight:bolder;
                background-color:#0ead88;   
            }
            .logoutbutton:hover{
                box-shadow: 0px 0px 5px 2px grey;
                background-color:#0ead99;   
            }
            .img_style{
                width:35px;
                height:35px;
                float:left;
                margin-right: 10px;
            }
            .scroll{
                overflow-y:scroll;
                width:100%;
                height:520px;
            }
             .tablestyle{
                font-family: TimesNewRoman;
                text-align: center;
                border-collapse: collapse;
                font-size: 18pt; 
                width:100%;
                color:white;
            }
            .tablestyle td{
                border:2px solid black;
            }
            .tablestyle tr:nth-child(odd),.tablestyle tr:nth-child(odd) button{
                background-color:#0d8b66; 
                color:black;
            }
            .tablestyle tr:nth-child(even),.tablestyle tr:nth-child(even) button{
                background-color:#0ead88;
                color:black;
            }
            .tablestyle th{
                color:white;
                border:2px solid black;
            }
            @media screen and (max-width: 1200px) {
                .tabcontent, .menu {
                    width: 100%;
                    margin-top: 0;
                }
            }
        </style>
    </head>
    <body>
        <?php 
        session_start();
        $photo="profile.jpg";
        require('checksession.php');
        ini_set ('display_errors', 0);
        ?>
        <div class="header">
            <table style="width:100%;">
                <tr>
                    <td align="left">
                        <img src="icon.png" class="img_style" alt="no image">
                        <div style="margin-top:0px; float:left;">Quiz Management System</div>
                        <a href="dashboard.php">
                            <img class="img_style" style="margin-left: 10px" src="home.jpg" alt="no image">
                        </a>
                    </td>
                    <td align="right"><button class="logoutbutton" onclick="location.href='logout.php'">LOGOUT</button></td>
                </tr>
            </table>
        </div>
        <?php 
        $error="";
        if(isset($_POST['submit1'])) 
        { 
            ini_set('display_errors', 0);
            $fname = $_POST["fname"];
            $lname = $_POST["lname"];
            $uid = $_POST["uroll"];
            $uemail = $_POST["uemail"];
            try
            {
            if(mysqli_query($con,"update login set fname='$fname',lname='$lname',email='$uemail' where uid='$uid'"))
            {
                $_SESSION["uname"] = $fname." ".$lname;
                header("Location: dashboard.php");
            }
            }
            catch(Exception $e) {
                $error = "Error Message: ".$e->getMessage();
            }
        }
        ?>
        <div class="menu">
            <fieldset style="background-color: #0ead88;" class="scroll">
                <form id="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"></form>
                <table cellspacing="10" style="width:100%;">
                    <tr>
                        <td align="center">
                            <?php 
                            $fname = "";
                            $lname = "";
                            $email = "";
                            $sql1="select * from login where uid = '$uid'";
                            $result1 = mysqli_query($con,$sql1);
                            while($rows = mysqli_fetch_assoc($result1))
                            {
                                $fname = $rows["FNAME"];
                                $lname = $rows["LNAME"];
                                $email = $rows["EMAIL"];
                                if($rows["photo"]!=null)
                                {
                                    $photo = $rows["photo"];
                                }
                            }
                            ?>
                            <img src="<?php echo $photo; ?>" width="90%" height="170" alt="no image" style="border-radius:50px; border:2px solid white; border-style:groove; ">
                            <form id="form2" method="post" action="uploadfile.php" enctype="multipart/form-data"></form>
                            <div id="view1">
                                <button class="logoutbutton" onclick="edit()">Change</button>
                            </div>
                            <div id="view2">
                                <input type="file" name="photo" form="form2" style="width:80%;" required/>
                                <br><br>
                                <button style="float:right;" class="logoutbutton" form="form2">Update</button>
                                <button style="float:left;" class="logoutbutton" onclick="edit1()">Back</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>First Name</td>
                    </tr>
                    <tr>
                        <td><input form="form1" type="text" name="fname" value="<?php echo $fname; ?>" required/></td>
                    </tr>
                    <tr>
                        <td>Last Name</td>
                    </tr>
                    <tr>
                        <td><input form="form1" type="text" name="lname" value="<?php echo $lname; ?>" required/></td>
                    </tr>
                    <tr>
                        <td>Reg ID</td>
                    </tr>
                    <tr>
                        <td><input form="form1" type="text" name="uroll" value="<?php echo $uid; ?>" readonly/></td>
                    </tr>
                    <tr>
                        <td>Email Id</td>
                    </tr>
                    <tr>
                        <td><input form="form1" type="text" name="uemail" value="<?php echo $email; ?>" required/></td>
                    </tr>
                    <tr>
                        <td>
                        <?php 
                        if($error != "")
                        {
                            echo "<font color=red>$error</font>";
                        }
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td><input form="form1" class="logoutbutton" type="submit" value="Update" name="submit1"/></td>
                    </tr>
                </table>
            </fieldset>
        </div>
        <?php 
        if($utype=="STUDENT")
        {
        ?>
        <div class="tabcontent">
            <fieldset class="scroll">
                <legend><font size="6pt"><b>SETTINGS</b></font></legend>
                <p style="font-size:50px; text-align:center;">Can't Edit The Class</p>
            </fieldset>
        </div>
        <?php
        }
        else
        {
        ?>    
        <div class="tabcontent">
            <fieldset class="scroll">
                <legend><font size="6pt"><b>SETTINGS</b></font></legend>
                <table cellpadding="10" class="tablestyle center">
                    <tr>
                        <th>Class ID</th>
                        <th>Class Name</th>
                        <th>No of Students</th>
                        <th>No of Upcoming Quiz</th>
                        <th>No of Completed Quiz</th>
                        <th>Delete</th>
                    </tr>
                    <?php 
                    $sql2 = "select * from class_room where tid='$uid'";
                    $result2 = mysqli_query($con,$sql2);
                    while($rows= mysqli_fetch_assoc($result2))
                    {   
                        $students = explode(",",$rows["sid"]);
                        $count=0;
                        if($rows["sid"]!=null)
                        {
                            $count = count($students);
                        }
                        $delete = "deleteclass.php?id=".$rows["CID"];
                    ?>
                    <tr>
                        <td style="width:30%;" align="center"><?php echo $rows["CID"]; ?></td>
                        <td style="width:30%;" align="center"><?php echo $rows["CNAME"]; ?></td>
                        <td style="width:10%;" align="center"><?php echo $count; ?></td>
                        <Td style="width:10%;" align="center"></td>
                        <Td style="width:10%;" align="center"></td>
                        <td style="width:10%;" align="center">
                            
                            <button style="border:none;" onclick='location.href="<?php echo $delete; ?>"'>
                                <img src="trash1.png" style="width:120%;height:40px;">
                            </button>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </table>
            </fieldset>
        </div>
        <?php
        }
        ?>
        <script>
            document.getElementById('view2').style.display="none";
            function edit()
            {
                document.getElementById('view1').style.display="none";
                document.getElementById('view2').style.display="block";
            }
            function edit1()
            {
                document.getElementById('view2').style.display="none";
                document.getElementById('view1').style.display="block";
            }
        </script>    
    </body>
</html>
