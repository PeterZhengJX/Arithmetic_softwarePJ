<?php
/*
tea_info_search.php说明：
实现根据学号查找学生并显示各年级成绩及排名功能。
实现：从数据库获取相应学生id的总成绩同时获得排名
输入：
id（学生学号;网页端标识：id)
输出：
HTML表格显示学生分年级成绩及排名
*/
header('Content-type:text/json;charset=utf-8');
//网页输入读取
$id=$_POST['id'];
//连接数据库
$link=mysqli_connect(
    'localhost',
    'root',
    '2925473239zjx',
    'students'
);
//数据初始化置零
$que_num=0;
$percent="";
$timer="";
$rank=0;
$hour=0;
$minute=0;
$second=0;
$html_str="
    <table id='show_table' >
        <tr id='firstrow'>
            <td class='td_show'>年级</td>
            <td class='td_show'>做题总数</td>
            <td class='td_show'>做题总时长</td>
            <td class='td_show'>正确率</td>
            <td class='td_show'>排名</td>
        </tr>";
//建立年级字符串表
$grade_strs=array("各年级总","一年级上","一年级下","二年级上","二年级下","三年级上","三年级下");

if($link){
    //获取学生各年级总成绩
    $result=mysqli_fetch_array(mysqli_query($link,"select * from stu_info where id='$id'"));//取得学生信息
    if($result){
        $que_num=$result["que_num"];
        $percent="".$result["right_lev"]."%";
        $timer="".intval(substr($result["timer"],4))."时".intval(substr($result["timer"],2,2))."分".intval(substr($result["timer"],0,2))."秒";
    }
    //获取学生排名，以正确率为关键词
    $result=mysqli_fetch_array(mysqli_query($link,"SELECT temp.pm FROM (SELECT @rownum:=@rownum+1 pm,`stu_info`.* FROM (SELECT @rownum:=0) a, `stu_info` ORDER BY `right_lev` DESC) temp WHERE temp.id = '$id'"));
    $rank=$result[0];
    $html_str=$html_str."
    <tr>
    <td class='td_show'>".$grade_strs[0]."</td>
    <td class='td_show'>".$que_num."</td>
    <td class='td_show'>".$timer."</td>
    <td class='td_show'>".$percent."</td>
    <td class='td_show'>".$rank."</td>
    </tr>";

    for($i=1;$i<7;$i++){//按单元生成学生单元成绩
        $que_num=mysqli_fetch_array(mysqli_query($link,"SELECT sum(que_num) FROM ques_each where id='$id' and grade='$i'"))[0];//直接求和计算学生本年级做题数
        $right_num=mysqli_fetch_array(mysqli_query($link,"SELECT sum(right_num) FROM ques_each where id='$id' and grade='$i'"))[0];//直接求和计算学生本年级做题正确数
        if($que_num!=0)//当做题总数为0时，直接置正确率为0
            $percent=sprintf("%.2f",$right_num/$que_num*100)."%";
        else
            $percent="0.00%";
        $result=mysqli_query($link,"SELECT timer FROM ques_each where id='$id' and grade='$i'");//获取当前年级学生各单元做题时间信息
        if($result){
            $row=mysqli_fetch_all($result);
            $row_num=sizeof($row);
            for($j=0;$j<$row_num;$j++){//循环累计做题时间
                $second+=intval(substr($row[$j][0],0,2));
                if($second>=60){
                    $minute++;
                    $second-=60;
                }
                $minute+=intval(substr($row[$j][0],2,2));
                if($minute>=60){
                    $hour++;
                    $minute-=60;
                }
                $hour+=intval(substr($row[$j][0],4));
            }
        }
        $timer="".$hour."时".$minute."分".$second."秒";
        //以正确率为关键词计算学生在本单元中排名
        $result=mysqli_fetch_array(mysqli_query($link,"SELECT temp.pm FROM (SELECT @rownum:=@rownum+1 pm,`ques_each`.* FROM (SELECT @rownum:=0) a, `ques_each` ORDER BY `right_lev` DESC) temp WHERE temp.id = '$id' and temp.grade='$i'"));
        $rank=$result[0];
        $html_str=$html_str."
        <tr>
        <td class='td_show'>".$grade_strs[$i]."</td>
        <td class='td_show'>".$que_num."</td>
        <td class='td_show'>".$timer."</td>
        <td class='td_show'>".$percent."</td>
        <td class='td_show'>".$rank."</td>
        </tr>";
    }
}

$ret_html=$html_str."</table>";
//返回json字符串
echo json_encode($ret_html);
//关闭数据库
mysqli_close($link);
?>