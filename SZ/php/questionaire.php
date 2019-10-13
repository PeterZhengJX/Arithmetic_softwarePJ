<?php
header('Content-type:text/json;charset=utf-8');
//网页输入读取
// $id="11112";
// $login=1;
// $que_num=10;
// $right_num=1;
// $timer="00时00分03秒";
$id=$_POST['id'];
$login=$_POST['login'];
$que_num=$_POST['que_num'];
$right_num=$_POST['right_num'];
$timer=$_POST['timer'];
//连接数据库
$link=mysqli_connect(
    'localhost',
    'root',
    '2925473239zjx',
    'students'
);
if($login==1){
    //设置年级1~3
    $grade_array=array(null,"first_grade","second_grade","third_grade");
    //解析传入的学号
    $str_id="".$id;
    $grade=intval(substr($str_id,0,1));
    $class=intval(substr($str_id,1,2));
    //解析timer
    $hour=intval(substr($timer,0,2));
    $minute=intval(substr($timer,5,2));
    $second=intval(substr($timer,10,2));
    if($link){
     //将数据库中的记录和题目页面记录求和
     $result=mysqli_fetch_array(mysqli_query($link,"select * from ".$grade_array[$grade]." where id='$str_id'"));
     $second+=intval(substr($result["timer"],0,2));
     if($second>=60){
           $minute++;
          $second-=60;
        }
     $minute+=intval(substr($result["timer"],2,2));
     if($minute>=60){
          $hour++;
          $minute-=60;
        }
        $hour+=intval(substr($result["timer"],4));
        $timer="".str_pad("".$second,2,"0",STR_PAD_LEFT)."".str_pad("".$minute,2,"0",STR_PAD_LEFT)."".str_pad("".$hour,6,"0",STR_PAD_LEFT)."";
        $que_num+=$result["que_num"];
        $right_num+=$result["right_num"];
        mysqli_query($link,"update ".$grade_array[$grade]." set que_num='$que_num',right_num='$right_num',timer='$timer' where id='$str_id'");
    }
}
// $result=1;
// $data='{ok:"'.$result.'"}';
// echo json_encode($data);
//关闭数据库
mysqli_close($link);
?>