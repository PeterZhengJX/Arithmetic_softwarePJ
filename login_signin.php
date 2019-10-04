<?php
header('Content-type:text/json;charset=utf-8'); 
//网页输入读取
$is_student=$_POST['is_student'];
$is_login=$_PPOST['is_login'];
$name=$_POST['name'];
$password=$_POST['password'];
$grade=$_POST['grade'];

//php返回标识
$find=0;//初始值为登录失败
$sign=0;//初始值为注册失败
$data;
$grade_array;

if($is_student){
    //连接students数据库
    $link=mysqli_connect(
        'localhost',
        'root',
        '2915473239zjx',
        'students'
    );
    //设置年级
    $grade_array=array(null,"first_grade","second_grade","third_grade","fourth_grade","fifth_grade","sixth_grade");
    //如果当前为登录，则进行匹配；若当前为注册，则进行插入
    if($is_login){
        //当数据库成功开启时，读取用户
        if($link){
            $result=mysqli_fetch_array(mysqli_query($link,"select * from '$grade_array[$grade]' where name='$name'"));
            if($result){
                //当密码匹配时设置find为1
                if($result["password"]==$password)
                    $find=1;
            }
        }
        //将find放入data中
        $data='{find:"'.$find.'"}';
    }else{
        //当数据库开启成功时，写入数据并将sign置1
        if($link){
            mysqli_query($link,"insert into '$grade_array[$grade]' values('$password','$name',null,null,null,null,null)");
            $sign=1;
        }
        //将sign放入data中
        $data='{sign:"'.$sign.'"}';
    }
}else{
    //连接teachers数据库
    $link=mysqli_connect(
        'localhost',
        'root',
        '2925473239zjx',
        'teachers'
    );
    //如果当前为登录，则进行匹配；若当前为注册，则进行插入
    if($is_login){
        //当数据库成功开启时，开始匹配
        if($link){
            $result=mysqli_fetch_array(mysqli_query($link,"select * from teachers_info where name='.$name'"));
            if($result){
                //当找到用户并且密码匹配时，返回发现
                if($result["password"]==$password)
                    $find=1;
            }
        }
        //把find装入data
        $data='{find:"'.$find.'"}';
    }else{
        //当数据库连接成功时，插入数据并返回sign=1
        if($link){
            mysqli_query($link,"insert into teachers_info values('$name','$password',null,null,null)");
            $sign=1;
        }
        //把sign装入data
        $data='{sign:"'.$sign.'"}';
    }
}

echo json_decode($data);

mysqli_close($link);

?>