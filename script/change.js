'use strict'
function hello(){
    $("#wait").show();
}
function helloSuccess(data){
    $("#wait").hide();
    $("#info").text(data);
}
    $(document).ready(function () {
        $('#done').bind("click", function () {
            $.ajax({
                url: "tmp.php",
                type: 'POST',
                data: ({id: $('#site')}),
                DataType: 'html',
                beforeSend: hello,
                success: helloSuccess
            });
        });
    });