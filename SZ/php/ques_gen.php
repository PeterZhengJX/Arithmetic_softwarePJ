<?php
/*
ques_gen.php说明：
实现题目生成功能。能根据输入题目数量生成题目
实现：从网页获取年级、单元、题目数量，在数据库中数据挑选题目，返回题目数组
输入：
grade（年级;网页端标识：grade）
unit(单元；网页端标识：unit)
num（题目数量；网页端标识：num）
输出：
ques（题目数组）
*/
header('Content-type:text/json;charset=utf-8');
//网页输入读取
$grade=$_POST['grade'];
$unit=$_POST['unit'];
$num=$_POST['num'];
//连接数据库
$link=mysqli_connect(
    'localhost',
    'root',
    '2925473239zjx',
    'formulas'
);
//设置年级字符串数组：1~3上下
$grade_array=array(null,"first_grade_up","first_grade_down","second_grade_up","second_grade_down","third_grade_up","third_grade_down");
$ques=array();//题目数组放置生成的题目

if($link){
    //在数据库中随机读取num道算式
    $result=mysqli_query($link,"select * from ".$grade_array[$grade]." where unit=".$unit." order by rand() limit ".$num."");
    if($result){
        $row=mysqli_fetch_all($result);//获取返回的所有数据
        for($i=0;$i<$num;$i++){
            $ques[$i]=array("formu"=>$row[$i][1]."=","value"=>$row[$i][2]);
        }
    }
}

//返回json字符串
echo json_encode($ques);
//关闭数据库
mysqli_close($link);
?>