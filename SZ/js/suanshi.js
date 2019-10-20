/* suanshi.js */
/* 做题页面js文件 */
// 所涉及函数：openweb()、showtitle()、product_suanshi()、toDub(n)、start()、product_dengshi()
// 分别用于：打开个人页面、显示标题、与后端交互、显示算式、将数值转化为字符串、开始计时、对输入进行判断并向数据库返回结果



var ss;//全局变量，用于存储算式答案
var mytime;//用以计时
var h,m,s,ms;//用以计时
var str;//用以记录时间字符串
var time;
var correct;//用以计数正确题目数
var number;//用以收集总题数
var storage=window.localStorage;//获取当前locastorage中值
var grade=storage.grade;//年级
var unit=storage.unit;//单元

// 打开页面，根据储存在本地的身份值判断要打开什么页面
function openweb(){
    if (storage.identity==1)
       window.location.href='stu_info.html';
     else
       window.location.href='tea_info.html';
}

//用来显示标题
function showtitle(){
	// 获取要显示标题的地方
	var title=window.document.getElementById("leixing1");
	// 对于获取的年级学期进行判断，进行不同的输出
	if(grade=='1'){
		title.innerHTML=
	"<h1 style='color:#000;' class='leixing' style='float:none' text-align='center;' width='120px;' height='35px;'>"
	+" 一年级上第 "+unit+" 单元"+"</h1>"
	}
	else if(grade=='2'){
		title.innerHTML=
	"<h1 style='color:#000;' class='leixing' style='float:none' text-align='center;' width='120px;' height='35px;'>"
	+" 一年级下第 "+unit+" 单元"+"</h1>"
	}
	else if(grade=='3'){
		title.innerHTML=
	"<h1 style='color:#000;' class='leixing' style='float:none' text-align='center;' width='120px;' height='35px;'>"
	+" 二年级上第 "+unit+" 单元"+"</h1>"
	}
	else if(grade=='4'){
		title.innerHTML=
	"<h1 style='color:#000;' class='leixing' style='float:none' text-align='center;' width='120px;' height='35px;'>"
	+" 二年级下第 "+unit+" 单元"+"</h1>"
	}
	else if(grade=='5'){
		title.innerHTML=
	"<h1 style='color:#000;' class='leixing' style='float:none' text-align='center;' width='120px;' height='35px;'>"
	+" 三年级上第 "+unit+" 单元"+"</h1>"
	}
	else {
		title.innerHTML=
	"<h1 style='color:#000;' class='leixing' style='float:none' text-align='center;' width='120px;' height='35px;'>"
	+" 三年级下第 "+unit+" 单元"+"</h1>"
	}
	
}



//与后端交互、显示算式的函数
function product_suanshi(){
	start();//开始计时
    var obj=window.document.getElementById("select_number");//获取选题数
	number=obj.options[obj.selectedIndex].value;//总题数
   
	// 与后端交互
	$.ajax({
		type: "post",
		url: "php/ques_gen.php",//指示使用的PHP文件
		data: {grade:parseInt(grade),unit:parseInt(unit),num:parseInt(number)},//提交到php的数据
		dataType: "json",
		success: function(arr){
			// 对要显示的字符串数组进行赋值
			ss=arr;
			// 得到要显示算式的位置
			var ul=document.getElementById("neirong_ul");
			$(ul).html("");//清空此位置（此举可支持多次生成）
			// for循环，根据所选择的算式个数生成算式
	        for(k=0;k<number;k++){
				var li=document.createElement("li");//创建一个“li”
				//将所需内容添加到“li”中
    			li.innerHTML =
        			'<p class="shizi" style="color:#000;">'+ss[k].formu+
					'<input type="text" class="shuru" size="3" />'+
        			'<span class="daan_show" ></span>'+
        			'<i class="s_jieguo" style="display:inline;"></i>'+
					'</p>'
    			ul.appendChild(li);//将“li”添加到“ul”中
			}//end of for
			
        },
        //未成功接收时的处理
        error:function(student_data){
            //提示连接出错
            alert("服务器连接出错！");
        }
	  });   
	
}

// 将数值转化为字符串
function toDub(n){  //补0操作
	if(n<10){
	  return "0"+n;
	}
	else {
	  return ""+n;
	}
  }

// 开始计时函数
function start(){
	h=m=s=ms= 0;  //时，分，秒初始化为0；
  
	function timer(){   //定义计时函数
	  ms=ms+50;         //毫秒
	  if(ms>=1000){
		ms=0;
		s=s+1;         //秒
	  }
	  if(s>=60){
		s=0;
		m=m+1;        //分钟
	  }
	  if(m>=60){
		m=0;
		h=h+1;        //小时
	  }
	  str =toDub(h)+"时"+toDub(m)+"分"+toDub(s)+"秒";
	  mytime = document.getElementById('clock');
	  mytime.innerHTML = str;
	}
	time=setInterval(timer,50);//开始计时
	
}

//生成算式，返回字符串形式的算式和结果（点击“交卷”的结果）
function product_dengshi(){
	clearInterval(time);//停止计时
	
	var inputs = document.getElementsByClassName("shuru");//输入框
	var spans = document.getElementsByClassName("daan_show");//显示答案的地方
	var iclass = document.getElementsByClassName("s_jieguo");//收集结果
	correct = 0;//计数正确题目的个数，清零
	var correctnumber = document.getElementById("grade");//显示得分的地方
	var obj=document.getElementById("select_number");//获取用户选择的题数

	// 根据题目数，对每一个输入进行收集，进行相应的判断和记录
	for (var i = 0; i < inputs.length; i++) {
      //判断这个元素是不是按钮
      if (inputs[i].type == "text") {
		  inputs[i].style="display:none;";
		  spans[i].value=inputs[i].value;//输入答案的赋值
		  spans[i].innerHTML=spans[i].value;//输入答案的显示
		  var res = String(ss[i].value);
		  var ret = String(inputs[i].value);
		  if(res==ret){//输入正确
			  correct +=1;//正确题数加一
			  iclass[i].innerHTML='<h7 style="color:green;">  正确</h7>'
			  answer[i]=1;
		  }
		  else{//输入错误
			iclass[i].innerHTML='<h7 style="color:red;">  答案：'+ss[i].value+'</h7>'
			answer[i]=0;
		  }
        
      }
	}
	correctnumber.innerHTML=correct+"/"+number;//显示得分

	storage=window.localStorage;//获取当前locastorage中值
	var userid = storage.getItem("id");//从localstorage中获取用户id

	var logjudge=1;//是否登录的检查
	//若用户未登录，置0
	if(userid=="admin")
	logjudge=0;
	// 获得选择的年级和单元，用于传递给数据库
	var abb=parseInt(storage.grade);
	var bb=parseInt(storage.unit);
	
	$.ajax({
		type: "post",
		url: "php/test.php",//指示使用的PHP文件
		data:{id:userid,login:logjudge,que_num:parseInt(number),right_num:correct,timer:str,abb:abb,bb:bb},//提交到test.php的数据
		dataType: "json",
		// 交互成功，无返回
		success:function(data){
		},
		// 交互失败，提示
		error:function(data){
			//提示连接出错
            alert("服务器连接出错！");
		}
	  });   

}
