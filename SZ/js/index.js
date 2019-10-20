/* index.js */
/* 主页面js文件 */
// 所涉及函数：openweb()、opensuanshi(btn1,btn2)
// 分别用于：打开个人页面、打开相应的做题页面


var storage=window.localStorage;//获取当前locastorage中值
//进入个人中心
//根据localstorage中的iden判断登入者身份
function openweb(){
    if (storage.identity==1)
       window.location.href='stu_info.html';
     else
       window.location.href='tea_info.html';
}

//打开算式页面
//根据按钮选择年级单元
function opensuanshi(btn1,btn2){
    //将localstorage中保存年级和单元
    var grade=btn1;
    storage["grade"]=grade;
    var unit=btn2;
    storage['unit']=unit;
    window.open('suanshi.html');//在新页面打开题目
}