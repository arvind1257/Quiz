<!DOCTYPE html>
<?php 
        session_start();
        $photo="profile.jpg";
        require('checksession.php');
        ?>
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
            .img_style{
                width:35px;
                height:35px;
                float:left;
                margin-right: 10px;
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
                padding: 20px 15px; 
                width: 25%; 
            }
            
            fieldset{
                border:3px solid white;
                border-style:groove;
                padding: 15px;
                height:520px;
            }
            .logoutbutton{
                width:50%;
                color:white;
                padding:10px;
                border-radius:20px;
                font-weight:bolder;
                background-color:#0ead88;   
            }
            .logoutbutton:hover{
                box-shadow: 0px 0px 5px 2px grey;
                background-color:#0ead99;   
            }
            
            .question{
                width:80%;
                padding:10px;
                font-size: 20pt;
                background-color:#0ead88;
                box-shadow: 0px 0px 5px 2px grey;
            }
            .question textarea{
                width:90%;
                font-weight: lighter;
                font-size:18pt;
                resize: none;
            }
            .answer{
                width:80%;
                padding:10px;
                font-size:18pt;
                margin-bottom:10px;
                border: 2px solid #0ead88;
                box-shadow: 0px 0px 5px 2px grey;
            }
            .answerinput{
                width:80%;
                margin:5px;
                font-weight: lighter;
                font-size:18pt;
            }
            .addbutton{
                float:left;
                margin-left:100px;
            }
            .addbutton input{
                border:none;
                padding:10px;
                color:white;
                font-weight:bolder;
                border-radius: 10px;
                background-color:#0ead88;
            }
            .savebutton{
                float:right;
                margin-right:100px;
            }
            .savebutton input{
                border:none;
                padding:10px;
                color:white;
                font-weight:bolder;
                border-radius: 10px;
                background-color:#0ead88;
            }
            .scroll{
                overflow-y:scroll;
                width:100%;
                height:520px;
            }
            .tableview{
                width:100%; 
                border-collapse:collapse;
                text-align: center;
                font-size:10pt;
            }
            .tableview th{
                font-size:15pt;
            }
            #currenttime{
                padding:5px;
                width:auto;
                font-size:20pt;
                font-family:Comic Sans MS;
                border:2px solid white;
                border-style:groove;
                background-color:lightgray;
                color:black;
                border-radius:20px;
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
        $qid = $_REQUEST["qid"];
        $qdate="";
        $stime="";
        $etime="";
        $shuffle="";
        $qname="";
        date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)
        $currentdate = date('Y-m-d');
        $currenttime = date('H:i');
        $result2 = mysqli_query($con,"select distinct(status) from qattempt where qid='$qid' and sid='$uid'");
        while($rows1 = mysqli_fetch_assoc($result2))
        {
            if($rows1["status"]=="Completed")
            {
                break;
            }
            else
            {
        $result = mysqli_query($con,"select * from qlist where qid='$qid'");
        while($rows = mysqli_fetch_assoc($result))
        {
            $status = $rows["STATUS"];
            if($rows["QDATE"]==$currentdate)
            {
                $status = $rows["STATUS"];
                if($rows["STIME"]<=$currenttime)
                {
                    $check=mysqli_query($con,"update qlist set status='ACTIVE' where qid='$qid'");
                    mysqli_query($con,"update qattempt set status='Started' where qid='$qid' and sid='$uid'");
                    $status = "ACTIVE";
                    if($rows["ETIME"]<=$currenttime)
                    {
                        $check1 = mysqli_query($con,"update qlist set status='COMPLETED' where qid='$qid'");
                        mysqli_query($con,"update qattempt set status='Not Started' where qid='$qid' and sid='$uid'");
                        $status = "COMPLETED";
                    }
                }
            }
            else if($rows["QDATE"]<$currentdate)
            {
                $check1 = mysqli_query($con,"update qlist set status='COMPLETED' where qid='$qid'");
            }
            $qdate = $rows["QDATE"];
            $qname = $rows["QNAME"];
            $stime = $rows["STIME"];
            $etime = $rows["ETIME"];
            $shuffle = $rows["SHUFFLE"];
        }
            }
        }
        ?>
        <div class="menu">
            <form name="form1" id="form1" method="post" action="joincreate.php">
                <input type="hidden" name="qid1" id="qid" value="<?php echo $qid;?>"/>
            </form>
            <fieldset style="background-color: #0ead88;">
                <table style="width:100%" cellspacing="10"> 
                <tr>
                    <td colspan="2" align="center">
                        <p id="currenttime"></p>
                    </td>
                </tr>
                <tr>
                    <td>Quiz Date</td>
                    <td> : <input form="form1" type="date" name="qdate" value="<?php echo $qdate; ?>" readonly></td>
                </tr>
                <tr>
                    <td>Start Time</td>
                    <td> : <input form="form1" type="time" name="stime" value="<?php echo $stime; ?>" readonly></td>
                </tr>
                <tr>
                    <td>End Time</td>
                    <td> : <input form="form1" type="time" name="etime" value="<?php echo $etime; ?>" readonly></td>
                </tr>
                <tr>
                    <td>Quiz Status</td>
                    <td id="status"> : <?php  echo $status;?></td>
                </tr>
                </table>
            </fieldset>
        </div>
        <div class="tabcontent" id="tabcontent">
            <fieldset class="scroll">
                <legend><font size="6pt"><b><?php echo $qname;?></b></font></legend>
                <p style="font-size:50px; text-align:center; vertical-align:middle;">Quiz not yet started</p>
            </fieldset>
        </div>
        <div class="tabcontent" id="tabcontent1">
            <fieldset class="scroll">
                <legend><font size="6pt"><b><?php echo $qname;?></b></font></legend>
                    <?php 
                    $i=0;
                    $result1 = mysqli_query($con,"select * from qquestions where qid='$qid'");
                    while($rows = mysqli_fetch_assoc($result1))
                    {
                    ?>
                    <div id="questions">
                        <div class="question center">
                            <p><?php echo "Question ".($i+1).".";?></p>
                            <span style="color:white;"><?php echo $rows["QUESTIONS"]; ?></span>
                            <input form="form1" type="hidden" name="question[<?php echo ($i+1);?>]" value="<?php echo $rows["QUESTIONS"]?>" />
                        </div>  
                        <div class="answer center">
                            <input form="form1" type="hidden" name="type[<?php echo ($i+1);?>]" value="<?php echo $rows["TYPE"];?>"/>
                            <ol type="A">
                            <?php 
                            for($j=1;$j<=4;$j++)
                            {
                            ?>
                                <li><input form="form1" type="<?php echo $rows["TYPE"];?>" name="option[<?php echo ($i+1);?>][]" value="<?php echo $rows["OPTION$j"]; ?>"/>
                                <?php echo $rows["OPTION$j"];?></li>
                            <?php
                            }
                            ?>
                            </ol>
                        </div>
                    </div>
                    <?php 
                    $i++;
                    }        
                    ?>
                    <input type="hidden" id="count" value="<?php echo $i?>"/>
                    <div class="savebutton">
                        <input onclick="submit1()" type="submit" value="Submit"/>
                    </div>
            </fieldset>
        </div>
        <script>
            var status = document.getElementById("status").innerHTML;
            let test_date = document.form1.qdate.value.split("-");
            let start = document.form1.stime.value.split(":");
            let end = document.form1.etime.value.split(":");
            function gettime(){
                let date = new Date();
                let d = date.getDate();
                let mo = date.getMonth()+1;
                let y = date.getFullYear();
                let h = date.getHours();
                let m = date.getMinutes();
                let s = date.getSeconds();
                let d1=" ",mo1=" ",y1=" ";
                if(d<10) d1 = "0"+d;
                else d1 = ""+d;
                if(mo<10) mo1 = "0"+mo;
                else mo1 = ""+mo;
                if(y<10) y1 = "0"+y;
                else y1 = ""+y;
                let h1=" ",s1=" ",m1=" ";
                if(h<10) h1 = "0"+h;
                else h1 = h;
                if(s<10) s1 = "0"+s;
                else s1 = s;
                if(m<10) m1 = "0"+m;
                else m1 = m;
                if((test_date[0]===y1) && (test_date[1]===mo1) && (test_date[2]===d1))
                {
                    if((start[0]==h1 && start[1]==m1 && s1=="00"))
                    {
                        location.href="squiz_room.php?qid="+document.getElementById('qid').value;
                    }
                    if((end[0]==h1 && end[1]==m1 && s1=="00"))
                    {
                        alert("Time Over. Quiz Submitted Successfully");
                        document.getElementById('form1').submit();
                    }
                }
                else if(((test_date[0]==y1) && (test_date[1]==mo1) && (test_date[2]<d1)) || ((test_date[0]==y1) && (test_date[1]<mo1)) || (test_date[0]<y1))
                {
                    if((end[0]==h1 && end[1]<m1 ) || (end[0]<h1))
                    {
                        alert("hi");
                        location.href="cquiz_room.php?qid="+document.getElementById('qid').value;
                    }
                }
                document.getElementById('currenttime').innerHTML=h1+":"+m1+":"+s1;
                setTimeout('gettime()',1000);                    
            }
            gettime();
            
            let date = new Date();
            let d = date.getDate();
            let mo = date.getMonth()+1;
            let y = date.getFullYear();
            let h = date.getHours();
            let m = date.getMinutes();
            let s = date.getSeconds();
            let d1=" ",mo1=" ",y1=" ";
            if(d<10) d1 = "0"+d;
            else d1 = ""+d;
            if(mo<10) mo1 = "0"+mo;
            else mo1 = ""+mo;
            if(y<10) y1 = "0"+y;
            else y1 = ""+y;
            let h1=" ",s1=" ",m1=" ";
            if(h<10) h1 = "0"+h;
            else h1 = ""+h;
            if(s<10) s1 = "0"+s;
            else s1 = ""+s;
            if(m<10) m1 = "0"+m;
            else m1 = ""+m;
            if((test_date[0]===y1) && (test_date[1]===mo1) && (test_date[2]===d1))
            {
               
                if((start[0]===h1 && start[1]<=m1)||(start[0]<h1))
                {
                    document.getElementById('tabcontent1').style.display="block";
                    document.getElementById('tabcontent').style.display="none";
                    document.getElementById('status').innerHTML=": Started";
                    if(end[0]<=h1)
                    {
                        if((end[0]===h1 && end[1]<=m1)||(end[0]<h1))
                        {
                            document.getElementById('status').innerHTML=": Completed";
                        }
                    }
                }
                else
                {
                    document.getElementById('tabcontent1').style.display="none";
                }
            }
            else if(((test_date[0]==y1) && (test_date[1]==mo1) && (test_date[2]<d1)) || ((test_date[0]==y1) && (test_date[1]<mo1)) || (test_date[0]<y1))
            {
                document.getElementById('tabcontent1').style.display="block";
                document.getElementById('tabcontent').style.display="none";
                document.getElementById('status').innerHTML=": Completed";    
                location.href="cquiz_room.php?qid="+document.getElementById('qid').value;
            }
            else
            {
                document.getElementById('tabcontent1').style.display="none";
            }
            function submit1()
            {
                var n = parseInt(document.getElementById('count').value);
                for(let i=1;i<=n;i++)
                {
                    let flag=0;
                    let array = document.getElementsByName('option['+i+'][]');
                    for(let j=0;j<4;j++)
                    {
                        if(array[j].checked)
                        {
                            flag=1;
                            break;
                        }
                    }
                    if(flag===0)
                    {
                        alert("Choose the correct option for the question "+i);
                        array.focus();
                        return false;
                    }
                }
                document.getElementById('form1').submit();
                
            }
        </script>
    </body> 
</html>
