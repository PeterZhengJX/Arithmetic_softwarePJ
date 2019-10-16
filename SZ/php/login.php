<?php
header('Content-type:text/json;charset=utf-8');
//网页输入读取
// $identity=1;
// $id="11112";
// $password="U23";
$identity=$_POST['identity'];
$id=$_POST['id'];
$password=$_POST['password'];
//连接数据库
if($identity==0){
    $link=mysqli_connect(
        'localhost',
        'root',
        '2925473239zjx',
        'teachers'
    );
}else{
    $link=mysqli_connect(
        'localhost',
        'root',
        '2925473239zjx',
        'students'
    );
}
$str_identity=array("teacher_info","stu_info");
$str_id="".$id;
$login=0;
$pwd_right=0;
if($link){
    $result=mysqli_fetch_array(mysqli_query($link,"select * from ".$str_identity[$identity]." where id='$str_id'"));
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