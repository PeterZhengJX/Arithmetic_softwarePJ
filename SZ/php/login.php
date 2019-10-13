<?php
header('Content-type:text/json;charset=utf-8');
//网页输入读取
// $id="11112";
// $password="U23";
$id=$_POST['id'];
$password=$_POST['password'];
//连接数据库
$link=mysqli_connect(
    'localhost',
    'root',
    '2925473239zjx',
    'students'
);
//设置年级1~3
$grade_array=array(null,"first_grade","second_grade","third_grade");
//解析传入的学号
$str_id="".$id;
$grade=intval(substr($str_id,0,1));
$class=intval(substr($str_id,1,2));
$login=0;
$pwd_right=0;
if($link){
    $result=mysqli_fetch_array(mysqli_query($link,"select * from ".$grade_array[$grade]." where id='$str_id'"));
    if($result){
        $login=1;
        if($result["password"]==$password)
            $pwd_right=1;
    }
}
//构造返回json字符串
$data='{login:"'.$login.'",pwd_right:"'.$pwd_right.'"}';
//返回json字符串
echo json_encode($data);
//关闭数据库
mysqli_close($link);
?>