<?php

    session_start();
    require('checksession.php');
    if(isset($_REQUEST["no"]))
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $randomString = '';
        for ($j = 0; $j < 2; $j++) {
        for ($i = 0; $i < 3; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        $randomString .= '-';
        }
        mysqli_query($con,"insert into class_room(cid,cname,tid) values('$randomString','".$_REQUEST["no"]."','$uid')");
        header("Location: dashboard.php");
    }
    else if(isset($_REQUEST["no1"]))
    {
        $result = mysqli_query($con,"select * from class_room where cid='".$_REQUEST["no1"]."'");
        if($rows= mysqli_fetch_array($result))
        {
            if($rows["sid"]===null || strlen($rows["sid"])<=0)
            {
                mysqli_query($con,"update class_room set sid='$uid' where cid = '".$_REQUEST["no1"]."'");
                header("Location: dashboard.php");
            }
            else if(strpos($rows["sid"],$uid) !== false){
            }           
            else{
                $sid = $rows["sid"];
                $sid = $sid.",".$uid;
                mysqli_query($con,"update class_room set sid='$sid' where cid = '".$_REQUEST["no1"]."'");
                header("Location: dashboard.php");
            }
        }
    }
    else if(isset($_REQUEST["add"]))
    {
        $students = explode("\n",$_REQUEST["students"]);
        for($i=0;$i<count($students);$i++)
        {
            $students[$i] = trim($students[$i]);
            $result = mysqli_query($con,"select * from class_room where cid='".$_REQUEST["cid"]."' and sid like '%".$students[$i]."%'");
            if(mysqli_num_rows($result)==0 )
            {
                $result1 = mysqli_query($con,"select * from login where uid like '%$students[$i]%'");
                if(mysqli_num_rows($result1)>0)
                {
                    $result2 = mysqli_query($con,"select * from class_room where cid='".$_REQUEST["cid"]."'");
                    if($rows= mysqli_fetch_array($result2))
                    {
                        if($rows["sid"]===null || strlen($rows["sid"])<=0)
                        {
                            mysqli_query($con,"update class_room set sid='$students[$i]' where cid = '".$_REQUEST["cid"]."'");
                        }
                        else{
                            $sid = $rows["sid"];
                            $sid = $sid.",".$students[$i];
                            mysqli_query($con,"update class_room set sid='$sid' where cid = '".$_REQUEST["cid"]."'");
                            
                        }
                    }
                }
            }
        }
        header("Location: class_room.php?no=".$_REQUEST["cid"]);
    }
    else if(isset($_REQUEST["qid1"]))
    {
        $qid=$_REQUEST["qid1"];
        $questions = $_REQUEST["question"];
        $option = $_REQUEST["option"];
        $type = $_REQUEST["type"];
        echo $_REQUEST["qid1"]."<br>";
        echo $uid."<br>";
        echo "COMPLETED<br>";
        $result = mysqli_query($con,"select * from qattempt where qid='$qid' and sid='$uid'");
        while($rows= mysqli_fetch_assoc($result))
        {
            for($i=1;$i<=count($questions);$i++)
            {
                if($rows["QUESTIONS"]==$questions[$i])
                {
                    $correctanswer = $option[$i][0];
                    for($j=1;$j<count($option[$i]);$j++)
                    { 
                        $correctanswer.=",".$option[$i][$j];
                    }
                    echo $questions[$i]."=".$correctanswer."<br>";
                }
            }
        }
        $marks=0;
        $result1 = mysqli_query($con,"select * from qquestions where qid='$qid'");
        while($rows= mysqli_fetch_assoc($result1))
        {
            for($i=1;$i<=count($questions);$i++)
            {
                if($rows["QUESTIONS"]==$questions[$i])
                {
                    $correctanswer = $option[$i][0];
                    for($j=1;$j<count($option[$i]);$j++){ 
                        $correctanswer.=",".$option[$i][$j];
                    }
                    if($rows["ANSWER"]==$correctanswer)
                    {
                        $marks+=1;
                    }
                }    
            }
        }
        echo "Marks=$marks";
    }
    else if(isset($_REQUEST["qid"]))
    {
        $qid = $_REQUEST["qid"];
        $qdate = $_REQUEST["qdate"];
        $stime = $_REQUEST["stime"];
        $etime = $_REQUEST["etime"];
        $shuffle = $_REQUEST["shuffle"];
        $qname = $_REQUEST["qname"];
        $question = $_REQUEST["question"];
        $answer = $_REQUEST["answer"];
        $option = $_REQUEST["option"];
        mysqli_query($con,"update qlist set qdate='$qdate',stime='$stime',etime='$etime',shuffle='$shuffle' where qid='$qid'");
        for($i=1;$i<=count($question);$i++)
        {
            $correctanswer = $option[$i][0];
            for($j=1;$j<count($option[$i]);$j++){ 
                $correctanswer.=",".$option[$i][$j];
              }
            mysqli_query($con,"update qquestions set questions='$question[$i]',option1='".$answer[$i][0]."',option2='".$answer[$i][1]."',option3='".$answer[$i][2]."',option4='".$answer[$i][3]."',answer='$correctanswer' where qid='$qid' and qno='$i'");
        }
        header("Location: quiz_room.php?qid=".$qid);
    }
    else if(isset($_REQUEST["cid"]))
    {
        $qid = rand(111111,999999);
        $cid = $_REQUEST["cid"];
        $qdate = $_REQUEST["qdate"];
        $stime = $_REQUEST["stime"];
        $etime = $_REQUEST["etime"];
        $shuffle = $_REQUEST["shuffle"];
        $qname = $_REQUEST["qname"];
        $question = $_REQUEST["question"];
        $answer = $_REQUEST["answer"];
        $option = $_REQUEST["option"];
        $type = $_REQUEST["type"];
        $students = array();
        echo $cid;
        $result = mysqli_query($con,"select sid from class_room where cid='$cid'");
        while($rows= mysqli_fetch_assoc($result))
        {
            $students = explode(",", $rows["sid"]);
        }
        mysqli_query($con,"insert into qlist(qid,cid,qname,qdate,stime,etime,shuffle,status) values('$qid','$cid','$qname','$qdate','$stime','$etime','$shuffle','UPCOMING')");
        for($i=1;$i<=count($question);$i++)
        {
            $correctanswer = $option[$i][0];
            for($j=1;$j<count($option[$i]);$j++){ 
                $correctanswer.=",".$option[$i][$j];
            }
            mysqli_query($con,"insert into qquestions(qid,questions,option1,option2,option3,option4,answer,type,qno) values('$qid','$question[$i]','".$answer[$i][0]."','".$answer[$i][1]."','".$answer[$i][2]."','".$answer[$i][3]."','$correctanswer','$type[$i]','$i')");
            for($j=0;$j<count($students);$j++)
            {
                mysqli_query($con,"insert into qattempt(qid,questions,answer,sid,status) values('$qid','$question[$i]','$correctanswer','$students[$j]','Not Started')");
            }
        }
        header("Location: class_room.php?no=".$cid);
    }
