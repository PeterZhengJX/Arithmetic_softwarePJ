var storage=window.localStorage;//获取当前locastorage中值
function openweb(){
    //window.open('stu_info.html');
    //alert(storage.identity);
    if (storage.identity==1)
       window.open('stu_info.html');
     else
       window.open('tea_info.html');
}

function opensuanshi(btn1,btn2){
    //将localstorage中保存年级和单元
    //alert(btn);
    var grade=btn1;
    storage["grade"]=grade;
    //alert(storage.grade);
    unit=btn2;
    storage['unit']=unit;
    //alert(storage.unit);
    window.open('suanshi.html');
}