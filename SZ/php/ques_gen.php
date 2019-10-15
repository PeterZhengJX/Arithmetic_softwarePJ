<?php
header('Content-type:text/json;charset=utf-8');
//网页输入读取
$grade=$_POST['grade'];
$unit=$_POST['unit'];
$num=$_POST['num'];
// $grade=1;
// $unit=2;
// $num=10;
//连接数据库
$link=mysqli_connect(
    'localhost',
    'root',
    '2925473239zjx',
    'formulas'
);
//设置年级1~3
$grade_array=array(null,"first_grade_up","first_grade_down","second_grade_up","second_grade_down","third_grade_up","third_grade_down");
//在数据库中随机读取num道算式
$ques=array();
if($link){
    $result=mysqli_query($link,"select * from ".$grade_array[$grade]." where unit=".$unit." order by rand() limit ".$num."");
    // echo $result;
    if($result){
        $row=mysqli_fetch_all($result);
        //echo $row+"2";
        for($i=0;$i<$num;$i++){
            $ques[$i]=array("formu"=>$row[$i][1]."=","value"=>$row[$i][2]);
        }
    }
    else
     echo "eero";
}

//返回json字符串
echo json_encode($ques);
//关闭数据库
mysqli_close($link);
?>