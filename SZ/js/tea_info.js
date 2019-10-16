function show_allnum(){
    var show = document.getElementById("show_span1");//用于获取显示位置
    show.innerHTML = allnum;
    
}
function show_alltime(){
    var show = document.getElementById("show_span2");//用于获取显示位置
    show.innerHTML = alltime;
    
}
function show_percent(){
    var show = document.getElementById("show_span3");//用于获取显示位置
    show.innerHTML = percent;
    
}
var storage=window.localStorage;//获取当前locastorage中值
function show_information(){//用于与数据库沟通显示用户数据
    var userid = storage.id;//获取教师id
      
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
                //alert(json.name+json.timer+json.percent+json.que_num);
                alltime = json.timer;
                percent = json.percent;
                allnum = json.que_num;
                var spanname = document.getElementById('p_name');
                //alert(spanname.value);
                spanname.innerHTML = json.name;//将班级等信息赋值
                var span_number = document.getElementById('span_number');
                // var span_class = document.getElementById("span_class");
                // span_class.innerHTML = json.grade;
                span_number.innerHTML = userid;
            },
            //未成功接收时的处理
            error:function(student_data){
                //提示连接出错
                alert("服务器连接出错！");
            }
          });
    
    }
    
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
            //将以json字符串格式返回的数据变成json的对象
            var showtable=window.document.getElementById("show_table");
            showtable.innerHTML=marks;//展示返回表单
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
    var stu_id=window.document.getElementById("findid");
    $.ajax({
		type: "post",
		url: "php/tea_info_search.php",
		data: {id:stu_id.value},//提交到php的数据
		dataType: "json",
		success: function(table){//返回表单
            //将以json字符串格式返回的数据变成json的对象
            var showtable=window.document.getElementById("show_table");
            showtable.innerHTML=table;//展示返回表单
        },
        //未成功接收时的处理
        error:function(table){
            //提示连接出错
            alert("服务器连接出错！");
        }
	  });  
}