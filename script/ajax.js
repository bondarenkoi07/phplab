'use strict'
function hello(){
    $("#wait").show();
}
function helloSuccess(data){
    $("#wait").hide();
    $("#info").text(data);
}
$(document).ready(function () {
    $('#load').bind("click",function (){
        $.ajax({
            url:"tmp.php",
            type:'POST',
            data:({name:"aDMIN"}),
            DataType:'html',
            beforeSend:hello,
            success:helloSuccess
        });
    });
});