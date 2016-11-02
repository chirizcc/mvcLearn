function del(id) {
    $.get('./index.php?c=User&a=adel&id=' + id,'',function(data){
        data = eval(data);

        var str = '<table class="table table-hover"><tr><th>id</th><th>name</th><th>place</th><th>操作</th></tr>';
        for(i in data){
            str += '<tr>';
            str += '<td>'+data[i].id+'</td>';
            str += '<td>'+data[i].name+'</td>';
            str += '<td>'+data[i].place+'</td>';
            str += '<td class="col-md-4">';
            str += '<a class="btn btn-info" href="./index.php?c=User&a=edit&id='+ data[i].id +'">编辑</a>';
            str += ' <a class="btn btn-danger" onclick="del('+ data[i].id +')">删除</a>';
            str += '</td>';
            str += '<tr>';
        }
        str += '</table>';
        $('#con').html(str);
    });
}