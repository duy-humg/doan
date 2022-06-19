<p class="text">Chọn danh mục</p>
<div class="list_dm">
    <?php foreach ($dm as $item){
        $model = $this->model;
        $dm2 = $model->dm2($item->id);
        ?>
        <div class="item-dm">
            <a href="javascript: void(0)" onclick="check_dm(<?php echo $item->id ?>)"><?php echo $item->name ?></a>
            <?php if($dm2){ ?>
                <ul>
                    <?php foreach ($dm2 as $item2){ ?>
                        <li>
                            <a href="javascript: void(0)" onclick="check_dm(<?php echo $item2->id ?>)"><?php echo $item2->name ?></a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
    <?php } ?>
</div>
<script type="text/javascript">

    function check_dm(id){
        // alert(1);
        $.ajax({
            url: "index.php?module=products&view=products&task=check_dm&raw=1",
            type: 'GET',
            data: {id:id},
            dataType: 'html',
            success: function ($html) {
                location.reload()
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
            }
        });
        // i++;
    }




</script>
<style>
    .text{
        font-size: 16px;
        color: #fff;
        padding: 10px 10px;
        font-weight: bold;
        background: #0b97c4;
    }
    .list_dm .item-dm{
        display: inline-block;
        width: 33%;
        margin-bottom: 10px;
        padding-right: 10px;

    }
    .list_dm .item-dm a{
        font-weight: bold;
        font-size: 16px;
        color: #333;
    }
    .list_dm .item-dm ul{
        margin-left: -15px;
    }
    .list_dm .item-dm ul li{
        margin-bottom: 3px;
    }
    .list_dm .item-dm ul li a{
        font-weight: normal;
        font-size: 14px;
        color: #333;
    }
</style>