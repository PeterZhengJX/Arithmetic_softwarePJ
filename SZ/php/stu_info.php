<?php
header('Content-type:text/json;charset=utf-8');
//网页输入读取
// $id="11112";
$id=$_POST['id'];
//连接数据库
$link=mysqli_connect(
    'localhost',
    'root',
    '2925473239zjx',
    'students'
);
//解析传入的学号
$str_id="".$id;
$grade=intval(substr($str_id,0,1));
$find=0;
$que_num=0;
$percent="";
$timer="";
$data=null;
if($link){
    $result=mysqli_fetch_array(mysqli_query($link,"select * from stu_info where id='$str_id'"));
    if($result){
        $find=1;
        $que_num=$result["que_num"];
        $percent="".$result["right_lev"]."%";
        $timer="".intval(substr($result["timer"],4))."时".intval(substr($result["timer"],2,2))."分".intval(substr($result["timer"],0,2))."秒";
    }
    $name=$result["name"];
    // $result=mysqli_fetch_array(mysqli_query($link,"SELECT temp.pm FROM (SELECT @rownum:=@rownum+1 pm,`stu_info`.* FROM (SELECT @rownum:=0) a, `stu_info` ORDER BY `que_num`,`id`) temp WHERE temp.id = '11112'"));
    // $rank=$result[0];
    $data='{find:"'.$find.'",name:"'.$name.'",grade:"'.$grade.'",que_num:"'.$que_num.'",percent:"'.$percent.'",timer:"'.$timer.'"}';
}
//返回json字符串
echo json_encode($data);
//关闭数据库
mysqli_close($link);
?>