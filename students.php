<?php
header('Content-type:text/json;charset=utf-8'); 
//接收网页输入
$token=$_POST['token'];
$name=$_POST['name'];
$password=$_POST['password'];
$grade=$_POST['grade'];
//php输出数据
$data=null;
$find=0;
$modify=0;
$delete=0;
//设置年级
$grade_array=array(null,"first_grade","second_grade","third_grade"，"fourth_grade"，"fifth_grade"，"sixth_grade");
//连接数据库
$link=mysqli_connect(
    'localhost',
    'root',
    '2925473239zjx',
    'students'
);
//根据token进行各项操作
switch(token){
    case 0:{
        //查询并返回学生信息，可用于登录页面之后的个人信息页面
        if($link){
            $result=mysqli_fetch_array(mysqli_query($link,"select * from '$grade_array[$grade]' where name='$name'"));
            if($result["password"]==$password){
                $find=1;
            }
        }
        $data='{find:"'.$find'.",name:"'.$name.'",grade:"'.$grade.'",que_num:"'.$result["que_num"].'",right_num:"'.$result["right_num"].'",timer:"'.$result["timer"]'"}';
        break;
    }
    case 1:{
        //学生修改学生信息，可用于个人信息页面修改个人信息
        $past_name=$_POST['past_name'];
        $past_grade=$_POST['past_grade'];
        if($link){
            //如果年级有变更，先删去原年级中的记录再在新年级中创建记录,若无变更则直接更新数据
            if($grade!=$past_grade){
                $result=mysqli_fetch_array(mysqli_query($link,"select * from '$grade_array[$past_grade]' where name='$past_name'"));
                mysqli_query($link,"delete from '$grade_array[$past_grade]' where name='$name'");
                mysqli_query($link,"insert into '$grade_array[$grade]' values('$password','$name','$result["age"]','$result["que_num"]','$result["right_num"]','$result["timer"]',null)");
            }else{
                mysqli_query($link,"update '$grade_array[$grade]' set name='$name',password='$password',grade='$grade' where name='$past_name'");
            }
            $modify=1;
        }
        $result=mysqli_fetch_array(mysqli_query($link,"select * from '$grade_array[$grade]' where name='$name'"));
        $data='{modify:"'.$modify.'",name:"'.$name.'",grade:"'.$grade.'",que_num:"'.$result["que_num"].'",right_num:"'.$result["right_num"].'",timer:"'.$result["timer"]'"}';
        break;
    }
    case 2:{
        //做题页面修改学生信息
        $que_num=$_POST['que_num'];
        $right_num=$_POST['right_num'];
        $timer=$_POST['timer'];
        $result=mysqli_fetch_array(mysqli_query($link,"select * from '$grade_array[$grade]' where name='$name'"));
        $que_num+=$result["que_num"];
        $right_num+=$result["right_num"];
        $timer+=$result["timer"];
        if($link){
            mysqli_query($link,"update '$grade_array[$grade]' set que_num='$que_num',right_num='$right_num',timer='$timer' where name='$name'");
            $modify=1;
        }
        $data='{modify:"'.$modify.'"}';
        break;
    }
    case 3:{
        //注销学生信息
        if($link){
            mysqli_query($link,"delete from '$grade_array[$grade]' where name='$name'");
            $delete=1;
        }
        $data='{delete:"'.$delete.'"}';
        break;
    }
}
//data往网页传输
echo json_encode($data);
//关闭数据库
mysqli_close($link);
?>