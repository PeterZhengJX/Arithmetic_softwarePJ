<?php
header('Content-type:text/json;charset=utf-8');
//网页输入读取
$id=$_POST['id'];
$name=$_POST['name'];
$password=$_POST['password'];
//连接数据库
$link=mysqli_connect(
    'localhost',
    'root',
    '2925473239zjx',
    'teachers'
);
$sign=0;//回传参数sign表示是否注册成功，exist表示是否已存在
$exist=0;
if($link){
    $result=mysqli_query($link,"select count(id) from teacher_info where id='$str_id'");
    if($result){
        $data_num=mysqli_fetch_array($result);
        if($data_num[0]==0){//若不存在则插入，设置sign=1，表示登录成功
            $insert=mysqli_query($link,"insert into teacher_info values('$id','$name','$password') ");
            if($insert){
                $sign=1;
        }
        }else{
            $exist=1;
        }
    }
}
//构造返回json字符串
$data='{sign:"'.$sign.'",exist:"'.$exist.'"}';
//返回json字符串
echo json_encode($data);
//关闭数据库
mysqli_close($link);
?>