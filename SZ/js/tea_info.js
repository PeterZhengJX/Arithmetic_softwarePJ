/* tea_info.js */
/* 教师个人中心页面js文件 */
// 所涉及函数：show_information()、show_allnum()、show_alltime()、show_percent()、tableload(sgrade,sunit)、stu_tableload()
// 分别用于：和数据库交互显示用户数据；显示做题总数、显示做题总时长、显示做题正确率、显示表格、查询学生信息




var storage=window.localStorage;//获取当前locastorage中值
//用于与数据库交互显示用户数据
function show_information(){
    var userid = storage.id;//获取教师id
      
        // 与数据库进行交互
        $.ajax({
            type: "post",
            url: "php/tea_info.php",
            data: {id:userid},
            dataType: "json",//回调函数接收数据的数据格式为json
            //成功接收时的处理
            success: function(tea_data){
                //将以json字符串格式返回的数据变成json的对象
                var json='';
                json = eval("("+tea_data+")"); 
                //将相关数据赋值
                alltime = json.timer;
                percent = json.percent;
                allnum = json.que_num;
                 //获取数据要显示的位置，进行显示
                var spanname = document.getElementById('p_name');
                spanname.innerHTML = json.name;
                //获取其他信息（题目数），进行显示
                var span_number = document.getElementById('span_number');
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
// 两个参数分别返回年级和单元
function tableload(sgrade,sunit){
    //获取年级和单元
    var grade = sgrade;
    var unit = sunit;
    $.ajax({
		type: "post",
		url: "php/tea_info_eachUnit.php",
		data: {grade:grade,unit:unit},//提交到php的数据
		dataType: "json",
		success: function(marks){//返回表单
             //获取要显示表格的位置，并且对表格进行显示
            var showtable=window.document.getElementById("show_table_div");
            //展示返回表单
            showtable.innerHTML=marks;
        },
        //未成功接收时的处理
        error:function(marks){
            //提示连接出错
            alert("服务器连接出错！");
        }
	  });  
}

//查询学生信息
function stu_tableload(){
    // 从输入框获取学生的id
    var stu_id=window.document.getElementById("findid");
    // 与数据库交互
    $.ajax({
		type: "post",
		url: "php/tea_info_search.php",
		data: {id:stu_id.value},//提交到php的数据
		dataType: "json",
		success: function(table){//返回表单
            //获取表单要显示的位置
            var showtable=window.document.getElementById("show_table_div");
            //展示返回表单
            showtable.innerHTML=table;
        },
        //未成功接收时的处理
        error:function(table){
            //提示连接出错
            alert("服务器连接出错！");
        }
	  });  
}