<?php
header('Content-type:text/json;charset=utf-8');
//网页输入读取
// $identity=0;
// $id='123';
// $name='li';
// $password='123';
$identity=$_POST['identity'];
$id=$_POST['id'];
$name=$_POST['name'];
$password=$_POST['password'];
//连接数据库
$link_stu=mysqli_connect(
    'localhost',
    'root',
    '2925473239zjx',
    'students'
);
$link_tea=mysqli_connect(
    'localhost',
    'root',
    '2925473239zjx',
    'teachers'
);
//解析老师端还是学生端，老师端为0，学生端1
$str_identity=array("teacher_info","stu_info");
//解析传入的学号
$str_id="".$id;
$sign=0;
$exist=0;
if($identity==0){
    if($link_tea){
        $result=mysqli_query($link_tea,"select count(id) from ".$str_identity[$identity]." where id='$str_id'");
        if($result){
            $data_num=mysqli_fetch_array($result);
            if($data_num[0]==0){//若不存在则插入，设置sign=1，表示登录成功
                $insert=mysqli_query($link_tea,"insert into teacher_info values('$id','$name','$password') ");
                if($insert)
                    $sign=1;
            }else{
                $exist=1;
            }
        }
    }
}else{
    if($link_stu){
        $result=mysqli_query($link_stu,"select count(id) from ".$str_identity[$identity]." where id='$str_id'");
        if($result){
            $data_num=mysqli_fetch_array($result);
            if($data_num[0]==0){//若不存在则插入，设置sign=1，表示登录成功
                $insert=mysqli_query($link_stu,"insert into stu_info values('$password','$name',0,0,'0000000000','$id',0) ");
                for($i=1;$i<7;$i++){
                    for($j=1;$j<7;$j++){
                        $insert=mysqli_query($link_stu,"insert into ques_each values('$i','$j',0,0,'0000000000','$id',0) ");
                    }
                }
                if($insert)
                    $sign=1;
            }else{
                $exist=1;
            }
        }
    }
}
//构造返回json字符串
$data='{sign:"'.$sign.'",exist:"'.$exist.'"}';
//返回json字符串
echo json_encode($data);
//关闭数据库
mysqli_close($link_stu);
mysqli_close($link_tea);
?>