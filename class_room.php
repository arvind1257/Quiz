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
                float: left; 
                padding:25px 10px;
                width: 25%; 
                color:white;
            }
            .menu li{
                margin-top:10px;
                padding:5px;
                margin-left:-20px;
                border:none;
                cursor: pointer;
                width:100%;
                box-shadow: 0px 0px 5px 2px grey;
            }
            fieldset{
                
                border:3px solid white;
                border-style:groove;
                padding: 20px;
                height:500px;
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
                height:500px;
            }
            .quizbutton{
                width:100%;
                padding:20px;
                cursor: pointer;
                font-family: TimesNewRoman;
                font-size: 15pt;
                font-weight: bolder; 
                background-color: #636663;
                color:white;
            }
            @media screen and (max-width: 1200px) {
                .tabcontent, .menu {
                    width: 100%;
                    margin-top: 0;
                }
            }
            .style1,.style1 td{
                width:100%;
            }
            .style1 td{
            width:25%;
            }
            
        </style>
    </head>
    <body>
        <?php 
        session_start();
        $photo="profile.jpg";
        $classname="";
        require('checksession.php');
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
        if($utype==="STUDENT")
        {
        ?>
        <div class="menu">
            <fieldset style="background-color: #0ead88;">
                <h3>Completed Quiz</h3>
                <br>
                <div class="scroll" style="height:170px;">
                    <ul type='none'>
                        <?php 
                        $result1 = mysqli_query($con,"select * from qlist where cid='".$_REQUEST["no"]."' and status='COMPLETED'");
                        if($rows = mysqli_fetch_assoc($result1))
                        {
                        do
                        {
                        ?>
                        <li><?php echo $rows["QNAME"];?><br><?php echo $rows["QDATE"];?></li>
                        <?php
                        }while($rows = mysqli_fetch_assoc($result1));
                        }
                        else
                        {
                            echo '<font size=5 color=black>No Quiz is Completed till now!</font>';
                        }
                        ?>
                    </ul>
                </div>
                <h3>Upcoming Quiz</h3>
                <br>
                <div class="scroll" style="height:170px;">
                    <ul type='none'>
                        <?php 
                        $result2 = mysqli_query($con,"select * from qlist where cid='".$_REQUEST["no"]."' and status='UPCOMING'");
                        if($rows = mysqli_fetch_assoc($result2))
                        {
                        do
                        {
                            
                            $date=date_create($rows["QDATE"]);
                        ?>
                        <li><?php echo $rows["QNAME"];?><br><?php echo date_format($date,"M d,Y");?></li>
                        <?php
                        }while($rows = mysqli_fetch_assoc($result2));
                        }
                        else
                        {
                            echo '<font size=5 color=black>No Upcoming quiz till now</font>';
                        }
                        ?>
                    </ul>
                </div>
            </fieldset>
        </div>
        <?php 
        }
        else
        {
        ?>
        <div class="menu">
            <fieldset style="background-color: #0ead88;" class="scroll">
                <?php 
                $result1 = mysqli_query($con,"select * from class_room where tid='$uid'");
                while($rows = mysqli_fetch_assoc($result1))
                {
                    $classname = $rows["CNAME"]; 
                    $students = explode(",",$rows["sid"]);
                    $count=0;
                    if($rows["sid"]!=null)
                    {
                        $count = count($students);
                    }
                ?>
                <p style="width:40%; float:left;"><b>Class ID : </b></p>
                <p style="width:59%; float:right;"><?php echo $_REQUEST["no"]; ?></p>
                <br><br>
                <p style="width:75%; float:left;"><b>No of Students : </b></p>
                <p style="width:20%; float:right;"><?php echo $count; ?></p>
                <br><br>
                <h3>Student List : </h3>
                <br>
                    <table class="tableview" cellspacing="10" style="width:100%;">
                        <tr>
                            <th>Names</th>
                            <th>Edit</th>
                        </tr>
                        <?php 
                        sort($students); 
                        for($i=0;$i<$count;$i++)
                        {
                        $result2 = mysqli_query($con,"select * from login where uid like '$students[$i]'");
                        while($rows = mysqli_fetch_assoc($result2))
                        {
                        $delete = "deleteclass.php?uid=".$rows["UID"]."&cid=".$_REQUEST["no"];
                        ?>
                        <tr>
                            <td align="center"><?php echo $rows["FNAME"]." ".$rows["LNAME"];?><br><?php echo $rows["UID"]; ?></td>
                            <td align="center">
                                <button style="width:80%; background-color:#0ead88; border:none;" onclick='location.href="<?php echo $delete; ?>"'><center>
                                        <img src="trash1.png" style="width:80%;height:30px;"></center>
                                </button>
                            </td>
                        </tr>
                        <?php
                        }}
                        ?>
                    </table>
                    <br>
                    <button id="view2" class="logoutbutton" onclick="add()">ADD STUDENTS</button>
                    <div id="view1">
                        <form method="post" action="joincreate.php">
                            <font color="black" size="5">Paste the Students ID : </font>
                            <textarea style="resize:none; font-size:20px" width="80%" name="students" rows="5" cols="20"></textarea>
                            <input type="hidden" name="cid" value='<?php echo $_REQUEST["no"]; ?>'/>
                            <button onclick="" name="add" class="logoutbutton">add</button>
                        </form>
                    </div>
                <?php
                }
                ?>    
            </fieldset>
        </div>
        <?php
        }
        ?>
        <div class="tabcontent">
            <fieldset class="scroll">
                <legend><font size="6pt"><b><?php echo $classname; ?></b></font></legend>
                <table class="style1" cellpadding=20 style="border-collapse: collapse;" >
                <tr>
                <?php 
                if($utype=="STUDENT") 
                { 
                } 
                else 
                { 
                ?>
                <td>
                    <button class="quizbutton" onclick="createquiz('<?php echo $_REQUEST["no"];?>')">CREATE QUIZ</button>
                </td>
                <?php 
                } 
                $sql3 = "select * from qlist where cid = '".$_REQUEST["no"]."'";
                $result3 = mysqli_query($con,$sql3);
                $count=1;
                while($rows = mysqli_fetch_assoc($result3))
                {
                ?>
                <td>
                    <button class="quizbutton" onclick="opentarget('<?php echo $rows["QID"];?>')"><?php echo $rows["QNAME"];?></button>
                </td>
                <?php
                if($count%4===3)
                {
                    ?>
                    </tr><tr>
                    <?php
                }
                $count++;
                }
                if($count%4!==0)
                {
                    for($i=0;$i<4-($count%4);$i++)
                    {
                    ?>
                    <td></td>
                    <?php    
                    }
                }
                ?>
                </tr>
                </table>                
            </fieldset>
        </div>
        <script>
            document.getElementById("view1").style.display="none";
            function add()
            {
                document.getElementById("view2").style.display="none";
                document.getElementById("view1").style.display="block";
            }
            function opentarget(no,type) 
            {
                if(type=="STUDENT")
                {
                    location.href="squiz_room.php?qid="+no;
                }
                else
                {
                    location.href="quiz_room.php?qid="+no;
                }
            }
            function createquiz(no)
            {
                location.href="createquiz.php?cid="+no;
            }
        </script>
    </body> 
</html>
