<?php
header('Content-type:text/json;charset=utf-8');
//网页输入读取
// $grade=1;
// $unit=3;
// $id="11111";
// $login=1;
// $que_num=10;
// $right_num=1;
// $timer="00时00分03秒";
$id=$_POST['id'];
$login=$_POST['login'];
$que_num=$_POST['que_num'];
$right_num=$_POST['right_num'];
$timer=$_POST['timer'];
$grade=$_post['abb'];
$unit=$_post['bb'];
//连接数据库
$link=mysqli_connect(
    'localhost',
    'root',
    '2925473239zjx',
    'students'
);
if($login==1){
       //解析timer
    $hour=intval(substr($timer,0,2));
    $minute=intval(substr($timer,5,2));
    $second=intval(substr($timer,10,2));
    $hour_total=0;
    $minute_total=0;
    $second_total=0;
    $que_num_total=0;
    $right_num_total=0;
    if($link){
        //将数据库中的学生个人记录和题目页面记录求和
        $result=mysqli_fetch_array(mysqli_query($link,"select * from stu_info where id='$id'"));
        $second_total=intval(substr($result["timer"],0,2))+$second;
        if($second_total>=60){
            $minute_total++;
            $second_total-=60;
        }
        $minute_total=intval(substr($result["timer"],2,2))+$minute;
        if($minute_total>=60){
            $hour_total++;
            $minute_total-=60;
        }
        $hour_total=intval(substr($result["timer"],4))+$hour;
        $timer_total="".str_pad("".$second_total,2,"0",STR_PAD_LEFT)."".str_pad("".$minute_total,2,"0",STR_PAD_LEFT)."".str_pad("".$hour_total,6,"0",STR_PAD_LEFT)."";
        $que_num_total=$result["que_num"]+$que_num;
        $right_num_total=$result["right_num"]+$right_num;
        if($que_num!=0)
            $percent=$right_num_total/$que_num_total*100;
        else
            $percent=0;
        mysqli_query($link,"update stu_info set que_num='$que_num_total',right_num='$right_num_total',timer='$timer_total',right_lev='$percent' where id='$id'");

        //将数据库中保存学生各单元情况的记录与题目页面求和
        $result=mysqli_fetch_array(mysqli_query($link,"select * from ques_each where id='$id' and grade='$grade' and unit='$unit'"));
        $second_total=intval(substr($result["timer"],0,2))+$second;
        if($second_total>=60){
            $minute_total++;
            $second_total-=60;
        }
        $minute_total=intval(substr($result["timer"],2,2))+$minute;
        if($minute_total>=60){
            $hour_total++;
            $minute_total-=60;
        }
        $hour_total=intval(substr($result["timer"],4))+$hour;
        $timer_total="".str_pad("".$second_total,2,"0",STR_PAD_LEFT)."".str_pad("".$minute_total,2,"0",STR_PAD_LEFT)."".str_pad("".$hour_total,6,"0",STR_PAD_LEFT)."";
        $que_num_total=$result["que_num"]+$que_num;
        $right_num_total=$result["right_num"]+$right_num;
        if($que_num!=0)
            $percent=$right_num_total/$que_num_total*100;
        else
            $percent=0;
        mysqli_query($link,"update ques_each set que_num='$que_num_total',right_num='$right_num_total',timer='$timer_total',right_lev='$percent' where id='$id' and grade='$grade' and unit='$unit'");
        
    }
}
//$result=1;
//$data='{login:"'.$login.'"}';
// echo json_encode($grade);
//关闭数据库
mysqli_close($link);
?>