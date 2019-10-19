<?php
/*
tea_info_eachUnit.php说明：
实现分单元显示学生总成绩并显示排名功能。
实现：从数据库获取某一个单元的所有学生成绩并排名
输入：
grade（年级;网页端标识：grade)
unit（单元；网页端标识：unit）
输出：
以表格形式由高到低返回单元内学生成绩
*/
header('Content-type:text/json;charset=utf-8');
//网页输入读取
$grade=$_POST['grade'];
$unit=$_POST['unit'];
//连接数据库
$link=mysqli_connect(
    'localhost',
    'root',
    '2925473239zjx',
    'students'
);
//初始置零
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
    if($grade==0&&$unit==0){//当grade为0，unit为0时；显示总成绩
        $result=mysqli_query($link,"select * from stu_info order by right_lev desc limit 10");//返回总排名前十，按降序返回,关键词为正确率
        if($result){
            $raw=mysqli_fetch_all($result);
            $array_num=sizeof($raw);
            for($i=0;$i<$array_num;$i++){//遍历输出每个学生的各项成绩数据
                $name=$raw[$i][1];
                $que_num=$raw[$i][2];
                $percent=$raw[$i][6]."%";
                $second=0;//时间计算前必须将timer置零
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
    }else{//按单元返回排名前十的学生成绩
        //按单元读取成绩在前十的学生，关键词为正确率
        $result=mysqli_query($link,"select * from ques_each where grade='$grade' and unit='$unit' order by right_lev desc limit 10");
        if($result){
            $raw=mysqli_fetch_all($result);
            $array_num=sizeof($raw);
            for($i=0;$i<$array_num;$i++){//遍历输出每个学生的各项成绩数据
                $id=$raw[$i][5];
                $result=mysqli_fetch_array(mysqli_query($link,"select * from stu_info where id='$id'"));
                if($result)
                    $name=$result["name"];
                $que_num=$raw[$i][2];
                $percent=$raw[$i][6]."%";
                $second=0;//时间计算前必须将timer置零
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