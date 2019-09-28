<?php
header('Content-type:text/json;charset=utf-8');  
// $id=11;
// $password=123;
$id=$_POST['userid'];
$password=$_POST['userpass'];
//学生数据的返回数据结构包括find，name，age，已做题数que_mun，正确题目数right_num，登录总时间timer;若无此用户，find=false
class Student_redata{
    public $find;
    public $name;
    public $age;
    public $que_num;
    public $right_num;
    public $timer;
}
$link=mysqli_connect(
    'localhost',
    'root',
    '2925473239zjx',
    'students'
);
//比较输入用户是否存在于数据库中，若不存在或者密码错误则为false
$find=false;
//将对象变为数组的data数组
$data=array();
//创建返回对象
$student_redata=new Student_redata();
$student_redata->find=false;
$student_redata->name=NULL;
$student_redata->age=NULL;
$student_redata->que_num=NULL;
$student_redata->right_num=NULL;
$student_redata->timer=NULL;


if($link){
    //利用json准备返回该生数据，包括find，name，age，已做题数que_mun，正确题目数right_num，登录总时间timer;若无此用户，find=false
    $result=mysqli_fetch_array(mysqli_query($link,"select * from first_grade where id='$id'"));
    if($result){
        if($result["password"]==$password){
            $find=true;
        }
    }
    //若find为真则设置返回数据中find为真，同时将查询数据返回    
    if($find){
        $student_redata->find=true;
        $student_redata->name=$result["name"];
        $student_redata->age=$result["age"];
        $student_redata->que_num=$result["que_num"];
        $student_redata->right_num=$result["right_num"];
        $student_redata->timer=$result["timer"];
    }
}
//合成json格式的数据
$data='{find:"'.$student_redata->find.'",name:"'.$student_redata->name.'",age:"'.$student_redata->age.'",que_num:"'.$student_redata->que_num.'",right_num:"'.$student_redata->right_num.'",timer:"'.$student_redata->timer.'"}';
//返回json格式的字符串
echo json_encode($data);

mysqli_close($link);

?>