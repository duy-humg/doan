<?php
global $tmpl,$config;
$tmpl->addScript('vitri', 'blocks/vitri/assets/js');
$tmpl->addStylesheet('vitri', 'blocks/vitri/assets/css');
$lang = FSInput::get('lang');
$cid = FSInput::get('cid');
$Itemid = FSInput::get('Itemid');
$model = new VitriBModelsVitri();


//var_dump($get_id->parent_id);

?>

<div class="content_vitri">
    <p class="text-vitri">Quý khách vui lòng cho biết thêm Địa Chỉ Nhận Hàng để Homefarm.com chuẩn bị đủ hàng và giao nhanh chóng!</p>
    <div class="chon-vitri">
        <?php if($_SESSION['id_huyen']){ ?>
            <p class="text-chon">
                <a class="a-ql"  onclick="ql_xa()" href="javascript:void(0)"><i class="fal fa-chevron-left"></i></a>
                Chọn Xã/Phường Tại <?php echo $get_huyen->name ?>
            </p>
            <input type="hidden" id="id_city_menu" value="<?php echo $get_huyen->id ?>">
            <div class="nd_vitri">
                <div class="input-search-vitri">
                    <input type="text" id="huyen_search" value="" placeholder="Tìm nhanh xã/phường">
                </div>
                <div class="list_vitri">
                    <div class="box box-list-address">
                        <ul>
                            <?php foreach ($ward as $item){ ?>
                                <li>
                                    <a href="javascript:void(0)" onclick="xa(<?php echo $item->id ?>)"><?php echo $item->name ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php }elseif ($_SESSION['id_city']){ ?>
            <p class="text-chon">
                <a class="a-ql a-ql-huyen" onclick="ql_huyen()" href="javascript:void(0)"><i class="fal fa-chevron-left"></i></a>
                Chọn Quận huyện Tại <?php echo $get_city->name ?>
            </p>
            <input type="hidden" id="id_city_menu" value="<?php echo $get_city->id ?>">
            <div class="nd_vitri">
                <div class="input-search-vitri">
                    <input type="text" id="huyen_search" value="" placeholder="Tìm nhanh tỉnh thành, quận huyện...">
                </div>
                <div class="list_vitri">
                    <div class="box box-list-address">
                        <ul>
                            <?php foreach ($huyen as $item){ ?>
                                <li>
                                    <a href="javascript:void(0)" onclick="xa(<?php echo $item->id ?>)"><?php echo $item->name ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>

        <?php }else{ ?>

            <p class="text-chon">Chọn Tỉnh, Thành Phố</p>
            <div class="nd_vitri">
                <div class="input-search-vitri">
                    <input type="text" id="city_search" value="" placeholder="Tìm nhanh tỉnh thành, quận huyện...">
                </div>
                <div class="list_vitri">
                    <div class="box box-list-address">
                        <ul>
                            <?php foreach ($city as $item){ ?>
                                <li>
                                    <a href="javascript:void(0)" onclick="huyen(<?php echo $item->id ?>)"><?php echo $item->name ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
</div>