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
                padding: 20px;
                height:500px;
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
            .question input{
                width:90%;
                font-weight: lighter;
                font-size:18pt;
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
                height:500px;
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
                    <td align="right"><button class="logoutbutton" onclick="location.href='logout.php'">LOGOUT</button></td>
                </tr>
            </table>
        </div>
        <?php
        $qdate="";
        $stime="";
        $etime="";
        $shuffle="";
        $qname="";
        $count=1;
        $currentdate = date('Y-m-d');
        if(isset($_REQUEST["qdate"]))
        {
            $qdate=$_REQUEST["qdate"];
        }
        if(isset($_REQUEST["stime"]))
        {
            $stime=$_REQUEST["stime"];
        }
        if(isset($_REQUEST["etime"]))
        {
            $etime=$_REQUEST["etime"];
        }
        if(isset($_REQUEST["shuffle"]))
        {
            $shuffle=$_REQUEST["shuffle"];
        }
        if(isset($_REQUEST["qname"]))
        {
            $qname=$_REQUEST["qname"];
        }
        $question = array(1=>"");
        $answer = array(1=>array(0=>"",1=>"",2=>"",3=>""));
        $option = array(1=>"");
        $type = array(1=>"radio");
        if(isset($_REQUEST["type1"]))
        {
            $question = $_REQUEST["question"];
            $answer = $_REQUEST["answer"];
            if(isset($_REQUEST["option"]))
            {
                $option = $_REQUEST["option"];
            }
            $count=(int)$_REQUEST["count"];
            $type = $_REQUEST["type"];
            if($type[$_REQUEST["type1"]]=="checkbox")
            {
                $type[$_REQUEST["type1"]]="radio";
            }
            else
            {
                $type[$_REQUEST["type1"]]="checkbox";
            }
        }
        if(isset($_REQUEST["delete"]))
        {
            $pos = $_REQUEST["delete"];
            $question = $_REQUEST["question"];
            $answer = $_REQUEST["answer"];
            if(isset($_REQUEST["option"]))
            {
                $option = $_REQUEST["option"];
            }
            $count=(int)$_REQUEST["count"];
            $type = $_REQUEST["type"];
            if($count!==1)
            {
                for($i=$pos;$i<$count;$i++)
                {
                    $question[$i] = $question[$i+1];
                    $answer[$i] = $answer[$i+1];
                    $type[$i] = $type[$i+1];
                }
                $count-=1;
            }   
        }
        if(isset($_REQUEST["add"]))
        {
            $question = $_REQUEST["question"];
            $answer = $_REQUEST["answer"];
            $type = $_REQUEST["type"];
            if(isset($_REQUEST["option"]))
            {
                $option = $_REQUEST["option"];
            }
            $count=(int)$_REQUEST["count"]+1;
            $question[$count] = "";
            $answer[$count] = array(0=>"",1=>"",2=>"",3=>"");
            $option[$count] = "";
            $type[$count] = "radio";
        }
        if(isset($_REQUEST["save"])||isset($_REQUEST["back"]))
        {
            $question = $_REQUEST["question"];
            $answer = $_REQUEST["answer"];
            $type = $_REQUEST["type"];
            if(isset($_REQUEST["option"]))
            {
                $option = $_REQUEST["option"];
            }
            $count=(int)$_REQUEST["count"];
        }
        ?>
        <div class="menu">
            <fieldset style="background-color: #0ead88;">
                <table style="width:100%" cellspacing="10"> 
                    <tr>
                        <td>Quiz Date</td>
                        <?php if(!isset($_REQUEST["save"])) { ?>
                        <td> : <input form="form1" min="<?php echo $currentdate;?>" type="date" name="qdate" value="<?php echo $qdate;?>"></td>
                        <?php }else {?>
                        <td> : <input form="form1" min="<?php echo $currentdate;?>" type="date" name="qdate" value="<?php echo $qdate;?>" readonly></td>
                        <?php } ?>
                        
                    </tr>
                    <tr>
                        <td>Start Time</td>
                        <?php if(!isset($_REQUEST["save"])) { ?>
                        <td> : <input form="form1" type="time" name="stime" value="<?php echo $stime;?>" onchange="date1()"></td>
                        <?php }else {?>
                        <td> : <input form="form1" type="time" name="stime" value="<?php echo $stime;?>" onchange="date1()" readonly></td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td>End Time</td>
                        <?php if(!isset($_REQUEST["save"])) { ?>
                        <td> : <input form="form1" type="time" name="etime" value="<?php echo $etime;?>" onchange="date1()"></td>
                        <?php }else {?>
                        <td> : <input form="form1" type="time" name="etime" value="<?php echo $etime;?>" onchange="date1()" readonly></td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td>Shuffle</td>
                        <?php if(!isset($_REQUEST["save"]))
                        { 
                            if($shuffle=="yes")
                            {
                            ?>
                            <td> : <input form="form1" type="radio" name="shuffle" value="yes" checked/>YES <input form="form1" type="radio" name="shuffle" value="no"/>NO</td>
                            <?php
                            }
                            else if($shuffle=="no")
                            {
                            ?>
                            <td> : <input form="form1" type="radio" name="shuffle" value="yes"/>YES <input form="form1" type="radio" name="shuffle" value="no" checked/>NO</td>
                            <?php
                            }
                            else
                            {
                            ?>
                            <td> : <input form="form1" type="radio" name="shuffle" value="yes"/>YES <input form="form1" type="radio" name="shuffle" value="no"/>NO</td>
                            <?php
                            }
                        }
                        else
                        {
                            ?>
                            <td> : <?php echo $shuffle;?> <input form="form1" type="hidden" name="shuffle" value="<?php echo $shuffle;?>"/></td>
                            <?php
                        }
                        ?>
                        
                    </tr>
                </table>
            </fieldset>
        </div>
        <div class="tabcontent">
            <fieldset class="scroll">
                <legend><font size="6pt"><b>CREATE QUIZ</b></font></legend>
                <form name="form1" id="form1" method="post" action="createquiz.php">
                    <input form="form1" type='hidden' name='cid' value='<?php echo $_REQUEST["cid"];?>'/>
                </form>
                    <div class="question center">
                        Quiz Name:
                    </div>
                    <div class="answer center">
                        <?php if(!isset($_REQUEST["save"])) { ?>
                        <input form="form1" class="answerinput" type="text" name="qname" value="<?php echo $qname?>"/>
                        <?php }else {?>
                        <input form="form1" class="answerinput" type="text" name="qname" value="<?php echo $qname?>" readonly/>
                        <?php } ?>
                        
                    </div>
                    <?php 
                    for($i=0;$i<$count;$i++)
                    {
                    ?>
                    
                    <div id="questions">
                        <div id="<?php echo "Question".($i+1);?>" class="question center">
                            <p style="width:80%;float:left;"><?php echo "Question ".($i+1).".";?></p>
                            <p style="width:20%; float:right;text-align: right;">
                                <?php
                                if(!isset($_REQUEST["save"]))
                                {
                                    ?>
                                    <button onclick="delete1('<?php echo $i+1; ?>')" style="background-color:#0ead88; border:none; cursor: pointer;">
                                        <img src="trash1.png" style="width:30px;height:30px;" alt="no image">
                                    </button>
                                    <?php
                                }
                                ?>
                            </p>       
                            <?php if(!isset($_REQUEST["save"])) { ?>
                            <input form="form1" type="text" name="question[<?php echo ($i+1);?>]" value="<?php echo $question[$i+1]; ?>" />
                            <?php }else {?>
                            <input form="form1" type="text" name="question[<?php echo ($i+1);?>]" value="<?php echo $question[$i+1]; ?>" readonly/>
                            <?php } ?>
                            
                        </div>  
                        <div id="<?php echo "answer".($i+1);?>" class="answer center">
                            <input form="form1" type="hidden" name="type[<?php echo ($i+1);?>]" value="<?php echo $type[$i+1];?>"/>
                            <?php
                            for($j=0;$j<4;$j++)
                            { 
                                ?>
                                <input form="form1" type="<?php echo $type[$i+1];?>" name="option[<?php echo ($i+1);?>][]" value="<?php echo $answer[$i+1][$j]; ?>"/>
                                <?php if(!isset($_REQUEST["save"])) { ?>
                                <input form="form1" class="answerinput" type="text" name="answer[<?php echo ($i+1);?>][]" value="<?php echo $answer[$i+1][$j];?>" /><br>
                                <?php }else {?>
                                <input form="form1" class="answerinput" type="text" name="answer[<?php echo ($i+1);?>][]" value="<?php echo $answer[$i+1][$j];?>" readonly/><br>
                                <?php } 
                            }
                            if(!isset($_REQUEST["save"]))
                            {
                                if($type[$i+1]=="radio")
                                {
                                    ?>
                                    <button style="width:20%;" class="logoutbutton" onclick="type1('<?php echo $i+1; ?>')">Multiple Choice</button>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <button style="width:20%;" class="logoutbutton" onclick="type1('<?php echo $i+1; ?>')">Single Choice</button>
                                    <?php    
                                }
                            }   
                            ?>
                        </div>
                    </div>    
                    <?php 
                    }
                    if(isset($_REQUEST["save"]))
                    {
                        ?>
                        <div class="addbutton">
                            <input type="submit" form="form1" value="Back" name="back"/>
                        </div>
                        <div class="savebutton">
                            <input type="button" onclick="submit1()" value="Save Correct Answer" name="save1"/>
                        </div>
                        <?php
                    }
                    else
                    {
                        ?>
                        <div class="addbutton">
                            <input form="form1" type="submit" value="Add Question" name="add"/>
                        </div>
                        <div class="savebutton">
                            <input type="button" onclick="submit2('save')" value="Save Questions and Answer" name="save"/>
                        </div>
                        <?php
                    }
                    ?>
                    <input form="form1" type="hidden" id="count" name="count" value="<?php echo $i;?>"/>  
            </fieldset>
        </div>
        <script>
            function date1()
            {
                var date = document.form1.qdate.value;
                var stime1 = document.form1.stime;
                var etime1 = document.form1.etime;
                if(stime1.value.length>0 && etime1.value.length>0 && date.length>0)
                {
                    var timeStart = new Date(date+"T"+stime1.value+":00Z");
                    var timeEnd = new Date(date+"T"+etime1.value+":00Z");
                    var difference = timeEnd - timeStart;
                    if(difference<=0)
                    {
                        alert("Start time time should be less than end time!");
                        stime1.value="";
                        etime1.value="";
                        stime1.focus();
                    }
                }
            }
            function delete1(no)
            {
                document.getElementById('form1').action="createquiz.php?delete="+no;
                document.getElementById('form1').submit();
            }
            function type1(no)
            {
                document.getElementById('form1').action="createquiz.php?type1="+parseInt(no);
                document.getElementById('form1').submit();
            }
            function submit2(name)
            {
                if(document.form1.qdate.value.length<=0)
                {
                    alert("Quiz Date can't be empty");
                    document.form1.qdate.focus();
                    return false;
                }
                else if(document.form1.stime.value.length<=0)
                {
                    alert("Quiz Start Time can't be empty");
                    document.form1.stime.focus();
                    return false;
                }
                else if(document.form1.etime.value.length<=0)
                {
                    alert("Quiz End Time can't be empty");
                    document.form1.etime.focus();
                    return false;
                }
                else if(document.form1.qname.value.length<=0)
                {
                    alert("Quiz Name can't be empty");
                    document.form1.qname.focus();
                    return false;
                }
                let flag=0;
                for(let i=0;i<2;i++)
                {
                    if(document.form1.shuffle[i].checked)
                    {
                        flag=1;
                        break;
                    }
                }
                if(flag===0)
                {
                    alert("Choose any option in shuffle");
                    document.form1.shuffle.focus();
                    return false;
                }
                var n = parseInt(document.getElementById('count').value);
                for (let i = 1; i <=n; i++) 
                {
                    let question = document.getElementsByName('question['+i+']');
                    if(question[0].value.length<=0)
                    {
                        alert("Question "+i+" can't be Empty");
                        question[0].focus();
                        return false;
                    }
                    for(let j=0;j<4;j++)
                    {
                        let answer = document.getElementsByName('answer['+i+'][]');
                        if(answer[j].value.length<=0)
                        {
                            alert("Option "+(j+1)+" can't be Empty in Question "+i);
                            answer[j].focus();
                            return false;
                        }
                    }
                }
                document.getElementById('form1').action="createquiz.php?"+name+"=done";
                document.getElementById('form1').submit();
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
                document.getElementById('form1').action="joincreate.php";
                document.getElementById('form1').submit();
                
            }
        </script>
    </body> 
</html>
