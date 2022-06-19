function loaddistrict($city_id)
{           
    $.ajax({
            type : 'get',
            url : '/index.php?module=users&view=address&raw=1&task=ajax_load_district',
            dataType : 'html',
            data: {city_id:$city_id},
            success : function(data){
                
                $("#district").html(data);
                $('#district').removeAttr('disabled');
                return true;
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {}
    });
    return false;
}

function loadwards($city_id)
{      
    console.log($city_id);
    $.ajax({
            type : 'get',
            url : '/index.php?module=users&view=address&raw=1&task=ajax_load_ward',
            dataType : 'html',
            data: {district_id:$city_id},
            success : function(data){
                
                $("#wards").html(data);
                $('#wards').removeAttr('disabled');
                return true;
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {}
    });
    return false;
}