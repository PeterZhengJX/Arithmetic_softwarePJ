# Arithmetic_softwarePJ
for software class homework
***

## 数据库部分

###1、数据库内容
####数据库students:
用于记录各年级学生的数据  
含有六个年级的表格：first_grade~sixth_grade  
表格中存取每个学生对应的信息

####数据库teachers:
用于记录各老师的情况。  
含有一个表格，teachers_info  
表格中存取每个老师的对应信息


###2、表格信息
####students:first_grade~sixth_grade
id：无符号整数  
password：12位以下字符串  
name：8位以下字符串  
age：tinyInt  
que\_num：int  
right\_num：int 
timer：int(秒)

####teachers:teachers_info
id：无符号整数  
password：12位以下字符串  
name：8位以下字符串  
age：tinyInt（可选项）  
grade：tinyInt


###3、PHP布局构思
####总体构思
外部操作应该对数据库具有增、删、改、查的基本功能  

php文本不宜过多（同理，HTML文本也不应该太多）

php文本共有login_signin.php、teachers.php、students.php  

####login_signin.php
**功能**：完成教师、学生登录和注册（增）的功能，为登录网页和注册网页提供支持  

**网页输入**：is\_student(boolean,标记当前登录人身份)、is\_login（int，标记当前功能是登录还是注册）、name、password、grade（1~6）  
 
**php输出**：json字符串。对于登录功能，返回一个是否成功登陆标识find（1表示成功，0表示失败）；对于注册功能，返回一个是否成功注册标记sign（1表示成功，0表示失败）

####teachers.php
**功能**：查询并返回教师信息、修改教师信息、注销教师信息；即为教师个人信息页面、教师个人信息修改页面提供支持  

**网页输入**：token（标记是哪种操作0查询并返回教师信息、1修改教师信息、2注销教师信息、3查询学生信息）、name、password、grade。(其中操作1需要网页传送原姓名past\_name用于查找；操作3需要附加输入student\_name)  

**php输出**：json字符串。操作0返回是否查询成功、教师所有信息（find，name，grade、教师年级学生数目students\_num）；操作1返回是否修改成功标记modify(1表示成功、0表示失败）及修改后的教师信息（name、age、grade）；操作2返回是否成功注销标记delete（1表示成功、0表示失败）；操作3返回查询的学生name、que\_num、right\_num、timer，实现教师页面查看学生成绩的功能

**注：教师个人页面也返回学生信息，用于教师查看学生成绩，每次可查看一个学生**

####students.php
**功能**：查询并返回学生信息、学生修改学生信息、做题页修改学生信息、注销学生信息;可为学生个人页面，学生个人修改页面，做题页面提供支持  

**网页输入**：token（0表示查询并返回学生信息、1表示学生修改学生信息、2表示做题页面修改学生信息，3表示注销学生信息 )、name、password、grade。（其中操作1需要输入修改前的年级past\_grade、姓名past\_name用于查找；操作2需要传输本次做题的题目数que_num、正确数right\_num、花费时间timer信息）   

**php输出**：json字符串。操作0返回查询成功标记find和学生信息（name，grade，que\_num、right\_num、timer）；操作1返回修改成功标记modify及修改后的学生信息（同前）；操作2返回修改成功标记modify；操作3返回注销成功标记delete

**注：学生可通过个人\修改?页面修改个人信息，同时做题页也可修改做题数、正确数等信息。**