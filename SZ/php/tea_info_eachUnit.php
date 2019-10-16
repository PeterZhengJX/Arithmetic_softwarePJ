<?php
header('Content-type:text/json;charset=utf-8');
//网页输入读取
$grade=$_POST['grade'];
$unit=$_POST['unit'];
// $grade=1;
// $unit=1;
//连接数据库
$link=mysqli_connect(
    'localhost',
    'root',
    '2925473239zjx',
    'students'
);
// $grade_strs=array(null,"一年级上","一年级下","二年级上","二年级下","三年级上","三年级下");
// $unit_strs=array(null,"一单元","二单元","三单元","四单元","五单元","六单元");
$name="";
$que_num=0;
$percent="";
$timer="";
$second=0;
$minute=0;
$hour=0;
$html_str="
    <table id='show_table' >
        <tr id='firstrow'>
            <td class='td_show'>姓名</td>
            <td class='td_show'>做题总数</td>
            <td class='td_show'>做题总时长</td>
            <td class='td_show'>正确率</td>
        </tr>";
if($link){
    if($grade==0&&$unit==0){//返回总排名前十
        $result=mysqli_query($link,"select * from stu_info order by right_lev desc limit 10");
        if($result){
            $raw=mysqli_fetch_all($result);
            $array_num=sizeof($raw);
            for($i=0;$i<$array_num;$i++){
                $name=$raw[$i][1];
                $que_num=$raw[$i][2];
                $percent=$raw[$i][6]."%";
                $second=0;
                $minute=0;
                $hour=0;
                $second+=intval(substr($raw[$i][4],0,2));
                if($second>=60){
                    $minute++;
                    $second-=60;
                }
                $minute+=intval(substr($raw[$i][4],2,2));
                if($minute>=60){
                    $hour++;
                    $minute-=60;
                }
                $hour+=intval(substr($raw[$i][4],4));
                $timer="".$hour."时".$minute."分".$second."秒";
                $html_str=$html_str."
                <tr>
                <td class='td_show'>".$name."</td>
                <td class='td_show'>".$que_num."</td>
                <td class='td_show'>".$timer."</td>
                <td class='td_show'>".$percent."</td>
                </tr>";
            }
        }
    }else{
        $result=mysqli_query($link,"select * from ques_each where grade='$grade' and unit='$unit' order by right_lev desc limit 10");
        if($result){
            $raw=mysqli_fetch_all($result);
            $array_num=sizeof($raw);
            for($i=0;$i<$array_num;$i++){
                $id=$raw[$i][5];
                $result=mysqli_fetch_array(mysqli_query($link,"select * from stu_info where id='$id'"));
                if($result)
                    $name=$result["name"];
                $que_num=$raw[$i][2];
                $percent=$raw[$i][6]."%";
                $second=0;
                $minute=0;
                $hour=0;
                $second+=intval(substr($raw[$i][4],0,2));
                if($second>=60){
                    $minute++;
                    $second-=60;
                }
                $minute+=intval(substr($raw[$i][4],2,2));
                if($minute>=60){
                    $hour++;
                    $minute-=60;
                }
                $hour+=intval(substr($raw[$i][4],4));
                $timer="".$hour."时".$minute."分".$second."秒";
                $html_str=$html_str."
                <tr>
                <td class='td_show'>".$name."</td>
                <td class='td_show'>".$que_num."</td>
                <td class='td_show'>".$timer."</td>
                <td class='td_show'>".$percent."</td>
                </tr>";
            }
        }
    }
}
$ret_html=$html_str."</table>";
//返回json字符串
echo json_encode($ret_html);
//关闭数据库
mysqli_close($link);
?>