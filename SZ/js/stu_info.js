/* stu_info.js */
/* 学生个人中心页面js文件 */
// 所涉及函数：show_information()、show_allnum()、show_alltime()、show_percent()、tableload(sgrade)
// 分别用于：和数据库交互显示用户数据；显示做题总数、显示做题总时长、显示做题正确率、显示表格


//用以从数据库中获得当前页面相关值
var alltime;//做题时长
var percent;//正确率
var allnum;//做题总数
var storage=window.localStorage;//获取当前locastorage中值
var userid = storage.id;//从本地获取用户id

//用于与数据库沟通显示用户数据
function show_information(){

    $.ajax({
        type: "post",
        url: "php/stu_info.php",//指示使用的PHP文件
        data: {id:userid},
        dataType: "json",//回调函数接收数据的数据格式为json
        //成功接收时的处理
        success: function(student_data){
            //将以json字符串格式返回的数据变成json的对象
            var json='';
            json = eval("("+student_data+")"); 
            //将相关数据赋值
            alltime = json.timer;
            percent = json.percent;
            allnum = json.que_num;
            //获取数据要显示的位置，进行显示
            var spanname = document.getElementById('p_name');
            spanname.innerHTML = json.name;
            //获取其他信息（班级、题目数），进行显示
            var span_number = document.getElementById('p_number');
            var span_class = document.getElementById("p_class");
            span_class.innerHTML = json.grade;
            span_number.innerHTML = userid;
        },
        //未成功接收时的处理
        error:function(student_data){
            //提示连接出错
            alert("服务器连接出错！");
        }
      });

}

//显示做题总数
function show_allnum(){
    var show = document.getElementById("show_span1");//用于获取显示位置
    show.innerHTML = allnum;
    
}
//显示做题总时间
function show_alltime(){
    var show = document.getElementById("show_span2");//用于获取显示位置
    show.innerHTML = alltime;
    
}
//显示正确率
function show_percent(){
    var show = document.getElementById("show_span3");//用于获取显示位置
    show.innerHTML = percent;
    
}


//传消息给后端使其显示表格
function tableload(sgrade){
    //获取年级
    var grade = sgrade;
    $.ajax({
		type: "post",
		url: "php/stu_ques_info.php",
		data: {id:userid,grade:grade},//提交到php的数据
		dataType: "json",
		success: function(marks){//返回表单
            //获取要显示表格的位置，并且对表格进行显示
            var showtable=window.document.getElementById("right_table");
            var act=marks;//获取返回表单
            showtable.innerHTML=act;//展示返回表单
        },
        //未成功接收时的处理
        error:function(marks){
            //提示连接出错
            alert("服务器连接出错！");
        }
	  });  
}