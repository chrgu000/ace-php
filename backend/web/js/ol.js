function gritterSuccess($msg)
{
    $.gritter.add({
        title: '操作成功',
        text: $msg,
        time: 1600,
        class_name: 'gritter-success gritter-center'
    });
}
function gritterError($msg)
{
    $.gritter.add({
        title: '操作失败',
        text: $msg,
        time: 1600,
        class_name: 'gritter-error gritter-center'
    });
}
