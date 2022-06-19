function delete_address($id)
{      
    console.log($id);
    if (confirm('Bạn có thật sự muốn xóa địa chỉ này?')) {
        $.ajax({
                type : 'get',
                url : '/index.php?module=users&view=address&task=delete_address',
                dataType : 'html',
                data: {id:$id},
                success : function(data){
                        window.location.reload();
                    return true;
                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {}
        });
        return false;
    } else {
        // Do nothing!
    }
    
}
function delete_default($id, $id_default)

{
    // alert($id_default);
    // return false;
    // console.log($id);
    // if (confirm('Bạn có thật sự muốn xóa địa chỉ này?')) {
        $.ajax({
                type : 'get',
                url : '/index.php?module=users&view=address&task=update_default&raw=1',
                dataType : 'html',
                data: 'id='+$id+'&id_default='+ $id_default,
                success : function(data){
                    // return false;
                        window.location.reload();
                    return true;
                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {}
        });
        return false;
    // } else {
    //     // Do nothing!
    // }

}