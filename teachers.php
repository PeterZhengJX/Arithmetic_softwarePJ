<?php
header('Content-type:text/json;charset=utf-8'); 
//接收网页输入
$token=$_POST['token'];
$name=$_POST['name'];
$password=$_POST['password'];
$grade=$_POST['grade'];
//PHP返回数据
$data=null;
$delete=0;
$find=0;
$modify=0;
//连接数据库
$link=mysqli_connect(
    'localhost',
    'root',
    '2925473239zjx',
    'students'
);
//设置表
$grade_array=array(null,"first_grade","second_grade","third_grade"，"fourth_grade"，"fifth_grade"，"sixth_grade");
switch(token){
    case 0:{
        //查询教师信息并返回教师、和本年级学生的信息
        if($link){
            $result=mysqli_fetch_array(mysqli_query($link,"select * from teachers_info where name='$name'"));
            $find=1;
        }
        $stu_result=mysqli_fetch_array(mysqli_query($link,"select count(*) from '$grade_array[$grade]'"));
        $students_num=$stu_result[0];
        $data='{find:"'.$find.'",name:"'.$name.'",grade:"'.$grade.'",students_num:"'.$students_num.'"}';
        break;
    }
    case 1:{
        //修改教师信息
        $past_name=$_POST['past_name'];
        if($link){
            mysqli_query($link,"update teachers_info set name='$name',password='$password',grade='$grade' where name='$past_name'");
            $modify=1;
        }
        $result=mysqli_fetch_array(mysqli_query($link,"select * from teachers_info where name='$name'"));
        $data='{modify:"'.$modify.'",name:"'.$name.'",grade:"'.$grade.'",age:"'.$result["age"].'"}';
        break;
    }
    case 2:{
        //注销教师信息
        if($link){
            mysqli_query($link,"delete from teachers_info where name='$name'");
            $delete=1;
        }
        $data='{delete:"'.$delete.'"}';
        break;
    }
    case 3:{
        //教师查询学生信息
        $student_name=$_POST['student_name'];
        if($link){
            $result=mysqli_fetch_array(mysqli_query($link,"select * from '$grade_array[$grade]' where name='$student_name'"));
        }
        $data='{name:"'.$name.'",que_num:"'.$result["que_num"].'",right_num:"'.$result["right_num"].'",timer:"'.$result["timer"]'"}';
        break;
    }
}
//data往网页传输
echo json_encode($data);
//关闭数据库
mysqli_close($link);
?>