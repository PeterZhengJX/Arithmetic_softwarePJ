<?php
/*
stu_ques_info.php说明：
实现学生分单元成绩显示功能。能显示学生的做题数、时间及正确率等数据
实现：从数据库获取相应id和年级的成绩，计算正确率，同时返回
输入：
id（账号;网页端标识：id)
grade（年级；网页端标识：grade）
输出：
一个HTML表格，含本年级各单元成绩
*/
header('Content-type:text/json;charset=utf-8');
//网页输入读取
$id=$_POST['id'];
$grade=$_POST['grade'];
//连接数据库
$link=mysqli_connect(
    'localhost',
    'root',
    '2925473239zjx',
    'students'
);
//数据初始化
$second=0;
$minute=0;
$hour=0;
$str_id="".$id;
$find=0;
$que_num=0;
$percent="";
$timer="";
//以字符形式保存成绩表
$html_str="
    <table id='show_table' >
        <tr id='firstrow'>
            <td class='td_show'>年级单元</td>
            <td class='td_show'>做题总数</td>
            <td class='td_show'>做题总时长</td>
            <td class='td_show'>正确率</td>
        </tr>";
//年级字符列
$grade_strs=array("","一年级上","一年级下","二年级上","二年级下","三年级上","三年级下");
//单元字符列
$unit_strs=array(null,"一单元","二单元","三单元","四单元","五单元","六单元");

if($link){
    for($a=1;$a<7;$a++){//循环查询当前年级每个单元的数据
        $second=0;//每次循环timer置零
        $minute=0;
        $hour=0;
        $que_num=mysqli_fetch_array(mysqli_query($link,"SELECT sum(que_num) FROM ques_each where id='$id' and grade='$grade' and unit='$a'"))[0];
        $right_num=mysqli_fetch_array(mysqli_query($link,"SELECT sum(right_num) FROM ques_each where id='$id' and grade='$grade' and unit='$a'"))[0];
        if($que_num!=0)//当做题数为0时，正确率置零
                $percent=sprintf("%.2f",$right_num/$que_num*100)."%";
        else
                $percent="0.00%";
        $result=mysqli_query($link,"SELECT timer FROM ques_each where id='$id' and grade='$grade' and unit='$a'");//获取表中所有当前年级单元时间的记录
        if($result){
            $row=mysqli_fetch_all($result);
            $row_num=sizeof($row);
            for($i=0;$i<$row_num;$i++){//循环累加单元内的做题时间
                $second+=intval(substr($row[$i][0],0,2));
                if($second>=60){
                    $minute++;
                    $second-=60;
                }
                $minute+=intval(substr($row[$i][0],2,2));
                if($minute>=60){
                    $hour++;
                    $minute-=60;
                }
                $hour+=intval(substr($row[$i][0],4));
            }
        }
        $timer="".$hour."时".$minute."分".$second."秒";
        //把当前记录的信息全部压入表格
        $html_str=$html_str."
        <tr>
        <td class='td_show'>".$grade_strs[$grade].$unit_strs[$a]."</td>
        <td class='td_show'>".$que_num."</td>
        <td class='td_show'>".$timer."</td>
        <td class='td_show'>".$percent."</td>
        </tr>";
    }
    //添加表格结尾
    $ret_html=$html_str."</table>";
}
//返回json字符串
echo json_encode($ret_html);
//关闭数据库
mysqli_close($link);
?>

            