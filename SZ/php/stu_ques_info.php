<?php
header('Content-type:text/json;charset=utf-8');
//网页输入读取
// $id='11112';
// $grade=1;
$id=$_POST['id'];
$grade=$_POST['grade'];
//连接数据库
$link=mysqli_connect(
    'localhost',
    'root',
    '2925473239zjx',
    'students'
);
//解析传入的学号
$second=0;
$minute=0;
$hour=0;
$str_id="".$id;
$find=0;
$que_num=0;
$percent="";
$timer="";
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
$unit_strs=array(null,"一单元","二单元","三单元","四单元","五单元","六单元");
if($link){
    for($a=1;$a<7;$a++){
        $second=0;
        $minute=0;
        $hour=0;
        $que_num=mysqli_fetch_array(mysqli_query($link,"SELECT sum(que_num) FROM ques_each where id='$id' and grade='$grade' and unit='$a'"))[0];
        $right_num=mysqli_fetch_array(mysqli_query($link,"SELECT sum(right_num) FROM ques_each where id='$id' and grade='$grade' and unit='$a'"))[0];
        if($que_num!=0)
                $percent=sprintf("%.2f",$right_num/$que_num*100)."%";
        else
                $percent="0.00%";
        $result=mysqli_query($link,"SELECT timer FROM ques_each where id='$id' and grade='$grade' and unit='$a'");
        // echo json_encode($result);
        if($result){
            $row=mysqli_fetch_all($result);
            $row_num=sizeof($row);
            // echo json_encode($row);
            for($i=0;$i<$row_num;$i++){
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
        $html_str=$html_str."
        <tr>
        <td class='td_show'>".$grade_strs[$grade].$unit_strs[$a]."</td>
        <td class='td_show'>".$que_num."</td>
        <td class='td_show'>".$timer."</td>
        <td class='td_show'>".$percent."</td>
        </tr>";
    }
    $ret_html=$html_str."</table>";
}
//返回json字符串
echo json_encode($ret_html);
//关闭数据库
mysqli_close($link);
?>

            