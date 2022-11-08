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
                width: 79%; 
            }
            .menu { 
                padding:25px 10px;
                float: left;  
                width: 20%; 
                color:white;
                
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
            .tab{
                width:100%;
                color:black;
                padding:5px;
                margin:10px; 
                font-size:10pt;
                box-shadow:0px 0px 2px 2px gray; 
            }
            .img_style{
                width:35px;
                height:35px;
                float:left;
                margin-right: 10px
            }
            .scroll{
                overflow-y:scroll;
                width:100%;
                height:500px;
            }
            .classbutton{
                width:25%;
                cursor: pointer;
                background-color: #636663; 
                border:1px solid black;
            }
            .classbutton button{
                border:none;
                width:100%;
                padding:20px;
                cursor: pointer;
                font-family: TimesNewRoman;
                font-size: 15pt;
                font-weight: bolder; 
                background-color: #636663;
                color:white;
            }
            .classbutton:hover {
                box-shadow: 0px 0px 5px 2px grey; 
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
                    <td align="right">
                        <button class="logoutbutton" onclick="location.href='logout.php'">LOGOUT</button>
                    </td>
                </tr>
            </table>
        </div>
        <div class="menu">
            <fieldset style="background-color: #0ead88;" class="scroll">
            <table cellspacing="10" style="width:100%">
                <tr>
                    <td colspan="2" align="center">
                        <?php 
                        $sql1="select photo from login where uid = '$uid'";
                        $result1 = mysqli_query($con,$sql1);
                        while($rows = mysqli_fetch_assoc($result1))
                        {
                            if($rows["photo"]!=null)
                            {
                                $photo = $rows["photo"];
                            }
                        }
                        ?>
                        <img src="<?php echo $photo; ?>" width="90%" height="130" alt="no image" style="border-radius:50px; border:2px solid white; border-style:groove; ">
                    </td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td><?php echo $uname; ?></td>
                </tr>
                <tr>
                    <td>Reg ID</td>
                    <td><?php echo $uid; ?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <details>
                            <summary>UPCOMING</summary>
                            <?php
                            $sql2="select qlist.qname,class_room.cname,qlist.qdate,qlist.status from class_room INNER JOIN qlist on class_room.cid=qlist.cid where class_room.sid like '%$uid%' or class_room.tid like '%$uid%' ";
                            $result2 = mysqli_query($con,$sql2);
                            while($rows = mysqli_fetch_assoc($result2))
                            {
                            ?>
                            <div class="tab">
                            <?php 
                            if($rows["status"]=="UPCOMING")
                            {
                            $date=date_create($rows["qdate"]);
                                echo $rows["cname"]." -- ".$rows["qname"]." -- ".date_format($date,"M d,Y");
                            }
                            ?>
                            </div>
                            <?php
                            }
                            ?>
                        </details>
                    </td>    
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <button class="logoutbutton" onclick="location.href='setting.php'">Settings</button>
                    </td>
                </tr>
            </table>
            </fieldset>
        </div>
        <div class="tabcontent">
            <fieldset class="scroll">
                <legend><font size="6pt"><b>DASHBOARD</b></font></legend>
                <table cellspacing="20">
                <?php 
                if($utype=="STUDENT") 
                { 
                ?>    
                    <tr>    
                        <td class="classbutton">
                            <button onclick="joinclass()">JOIN CLASS</button>
                        </td>
                <?php 
                } 
                else 
                { 
                ?>
                    <tr>
                        <td class="classbutton">
                            <button onclick="createclass()">CREATE CLASS</button>
                        </td>
                <?php 
                } 
                $count = 2;
                $sql3 = "select * from class_room where sid like '%$uid%' or tid like '%$uid%'";
                $result3 = mysqli_query($con,$sql3);
                while($rows = mysqli_fetch_assoc($result3))
                {
                if($count%4==1)
                {
                ?>
                    <tr>
                        <td class="classbutton">
                            <button onclick="opentarget('<?php echo $rows["CID"]; ?>')"><?php echo $rows["CNAME"]; ?></button>
                        </td>   
                <?php
                }
                else if($count%4==0)
                {
                ?>    
                        <td class="classbutton">
                            <button onclick="opentarget('<?php echo $rows["CID"]; ?>')"><?php echo $rows["CNAME"]; ?></button>
                        </td>
                    </tr>    
                <?php
                }
                else if($count%4<=3)
                {
                ?>
                        <td class="classbutton">
                             <button onclick="opentarget('<?php echo $rows["CID"]; ?>')"><?php echo $rows["CNAME"]; ?></button>
                        </td>
                    
                <?php
                }
                $count++;
                }   
                if(($count-1)%4!=0)
                { 
                ?>
                        <td width="<?php echo 100-25*(($count-1)%4); ?>%">
                        </td>
                    </tr>
                <?php    
                }
                ?>
                </table>                
            </fieldset>
        </div>
         <script>
            function joinclass()
            {
                var id = prompt("Enter the Class Room ID : ");
                if(id===null)
                {
                    
                }
                else if(id.length<=0)
                {
                    alert("Class ID can't be Empty");
                    joinclass();
                }
                else
                {
                    location.href="joincreate.php?no1="+id;
                }
            }
            function createclass()
            {
                var id = prompt("Enter the Class Room Name : ");
                if(id===null)
                {
                    
                }
                else if(id.length<=0)
                {
                    alert("Class Name can't be Empty");
                    joinclass();
                }
                else
                {
                    location.href="joincreate.php?no="+id;
                }
            }
            function opentarget(no) 
            {
                location.href="class_room.php?no="+no;
            }
        </script> 
        
    </body>
</html>
