# Arithmetic_softwarePJ
for software class homework

## 数据库部分
###1、数据库内容
数据库students

用于记录各年级学生的数据

老师的做不做？？？？？

含有六个年级的表格：first_grade~sixth_grade

###2、表格信息
id：无符号整数  
password：12位以下字符串  
name：8位以下字符串  
age：tinyInt  
que_num：int  
right_num：int  
timer：int(秒)

###3、外部操作构思

获取学生数据： get_studentsRecord(id)       //用于学生登录之后返回信息  
查表匹配： login_match(id,password)         //用于学生登录  
修改学生数据： modify_studentsRecord(id)    //用于获取当前总做题数，正确数，登录总时间并修改  
插入一条记录： insert_studentsRecord(id,password,name,age)    //生成新记录