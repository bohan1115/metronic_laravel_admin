
function AjaxCall(method, url, data, success, error, datatype){
    $.ajax({
        url:url,
        type:method,
        async:true,
        data:data,
        dataType:datatype,
        success:function(data, status, xhr){
            if(typeof success == 'function'){
                success(data, status, xhr);
            }
        },
        error : function(){
            if(typeof error == 'function'){
                error(xhr, errorType, error)
            }
        }
    });
}


function AjaxPost(url, data, success, datatype, error){
    if(typeof datatype == 'undefined' || datatype == ""){
        datatype = "json";
    }
    AjaxCall("POST", url, data, success, error, datatype)
}