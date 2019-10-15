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
    'teachers'
);
//解析传入的学号
$login=0;//回传参数login表示是否存在此工号，pwd_right表示密码是否正确
$pwd_right=0;
if($link){
    $result=mysqli_fetch_array(mysqli_query($link,"select * from teacher_info where id='$str_id'"));
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