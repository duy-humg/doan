<?php
global $tmpl;
$tmpl->addStylesheet('default', 'plugins/comments/css');
$tmpl->addScript('default', 'plugins/comments/js');

$url = $_SERVER['REQUEST_URI'];
$module = FSInput::get('module');
//var_dump($module);
$view = FSInput::get('view');
$rid = FSInput::get('id');
//var_dump($rid);
$return = base64_encode($url);
$uploadConfig = base64_encode('add|' . session_id());
//var_dump($_SESSION);
?>
<div class="content_7">

    <div class="row">
        <div class="content7_1 col-md-3">
            <p class="p34"><?php echo formatNumber($sum_rate); ?></p>
            <p class="p33">
                <img src="<?php echo URL_ROOT.'images/sao.svg' ?>" alt="">
            </p>

<!--            <div>-->
<!--                --><?php //if (!$data->rating_count) { ?>
<!--                    <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                    <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                    <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                    <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                    <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                --><?php //} else { ?>
<!--                    --><?php //if (formatNumber($sum_rate) == 1) { ?>
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                    --><?php //} else if (formatNumber($sum_rate) == 2) { ?>
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                    --><?php //} else if (formatNumber($sum_rate) == 3) { ?>
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                    --><?php //} else if (formatNumber($sum_rate) == 4) { ?>
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                    --><?php //} else { ?>
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                        <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                    --><?php //} ?>
<!---->
<!--                --><?php //} ?>
<!--            </div>-->
            <p class="p35">(<?php echo $total_cmt; ?> nhận xét)</p>
        </div>
        <div class="content7_2 col-md-6">
            <div class="rating">
                <div class="phantram_sao">
                    <p class="p7_sao">5</p>
                    <div class="p77">
                        <img src="<?php echo URL_ROOT.'images\saoden.png' ?>">
                    </div>
                    <div class="progess1">
                        <div class="progress">
                            <div class="progress-bar"
                                 style="width:<?php echo formatNumber(($rate5 * 100) / $total_cmt) . '%'; ?>">
                            </div>
                        </div>
                    </div>
                    <p class="p8_sao"><?php echo $rate5 ?> đánh giá</p>
                </div>
                <div class="phantram_sao">
                    <p class="p7_sao">4</p>
                    <div class="p77">
                        <img src="<?php echo URL_ROOT.'images\saoden.png' ?>">
                    </div>
                    <div class="progess1">
                        <div class="progress">
                            <div class="progress-bar"
                                 style="width:<?php echo formatNumber(($rate4 * 100) / $total_cmt) . '%'; ?>">
                            </div>
                        </div>
                    </div>
                    <p class="p8_sao"><?php echo $rate4 ?> đánh giá</p>

                </div>
                <div class="phantram_sao">
                    <p class="p7_sao">3</p>
                    <div class="p77">
                        <img src="<?php echo URL_ROOT.'images\saoden.png' ?>">
                    </div>
                    <div class="progess1">
                        <div class="progress">
                            <div class="progress-bar"
                                 style="width: <?php echo formatNumber(($rate3 * 100) / $total_cmt) . '%'; ?>">
                            </div>
                        </div>
                    </div>
                    <p class="p8_sao"><?php echo $rate3 ?> đánh giá</p>

                </div>
                <div class="phantram_sao">
                    <p class="p7_sao">2</p>
                    <div class="p77">
                        <img src="<?php echo URL_ROOT.'images\saoden.png' ?>">
                    </div>
                    <div class="progess1">
                        <div class="progress">
                            <div class="progress-bar"
                                 style="width: <?php echo formatNumber(($rate2 * 100) / $total_cmt) . '%'; ?>">
                            </div>
                        </div>
                    </div>
                    <p class="p8_sao"><?php echo $rate2 ?> đánh giá</p>

                </div>
                <div class="phantram_sao">
                    <p class="p7_sao">1</p>
                    <div class="p77">
                        <img src="<?php echo URL_ROOT.'images\saoden.png' ?>">
                    </div>
                    <div class="progess1">
                        <div class="progress">
                            <div class="progress-bar"
                                 style="width: <?php echo formatNumber(($rate1 * 100) / $total_cmt) . '%'; ?>">
                            </div>
                        </div>
                    </div>
                    <p class="p8_sao"><?php echo $rate1 ?> đánh giá</p>

                </div>
            </div>
        </div>
        <div class="content7_3 col-md-3">
            <p class="p37_">
                <a class="p37" href="#cmt" data-toggle="collapse" aria-expanded="false" aria-controls="cmt">
                    <span class="a6">Gửi đánh giá của bạn</span>
                    <span class="a6_">ĐÓNG</span>
                </a>
            </p>
        </div>
    </div>

    <div class='block_form_comments collapse' id="cmt">
        <div class='comment_form_title row-item'>Gửi nhận xét của bạn</div>
        <div class="row">
            <!--            <div class="from1 col-sm-8">-->
            <form action="" method="post" name="comment_add_form" id='comment_add_form' class='form_comment'
                  onsubmit="javascript: submit_comment();return true;">
                <div class="row-item">
                    <div class="col-sm-6 col_right">
                        <div class="button_area row-item">
                            <p class="title_note">
                                <?php echo FSText::_('1. Đánh giá của bạn về sản phẩm này: ') ?>
                            </p>
                            <span class="rating-value "></span>
                            <!--                                --><?php //if ($_SESSION['user_id']) { ?>

                            <!--                                --><?php //} else { ?>
                            <p style="margin-bottom: 10px;color: #f00000;font-size: 13px;">
                                <?php echo FSText::_('Vui lòng chọn đánh giá của bạn về sản phẩm này!') ?>
                            </p>
                            <!--                                --><?php //} ?>
                            <p class="title_note">
                                <?php echo FSText::_('2. Tiêu đề nhận xét: ') ?>
                            </p>
                            <input type="text" name="title"
                                   placeholder='<?php echo FSText::_("Nhập tiêu đề nhận xét( không bắt buộc)"); ?>'
                                   id="title" value="" class="form_control">
                        </div>

                    </div>

                    <div class="col-sm-6 col_left ">
                        <p class="title_note">
                            <?php echo FSText::_('3. Viết nhận xét bên dưới: ') ?>
                        </p>
                        <textarea id="cmt_content" class="form-control" name="content" rows="4"
                                  style="    border-radius: unset;"
                                  placeholder="<?php echo FSText::_('Viết đánh giá của bạn về sản phẩm...'); ?>"></textarea>
                    </div>


                </div>

                <input class="submitbt" type="submit" id="submitbt"
                       value="<?php echo FSText::_('Gửi nhận xét của bạn'); ?>"/>
                <input type="hidden" value="<?php echo $module; ?>" name='module' id="_cmt_module"/>
                <input type="hidden" value="<?php echo $view; ?>" name='view' id="_cmt_view"/>
                <input type="hidden" value="save_comment" name='task'/>
                <input type="hidden" value="<?php echo $rid; ?>" name='record_id' id="_cmt_record_id"/>
                <input type="hidden" value="<?php echo $return; ?>" name='return' id="_cmt_return"/>
                <input type="hidden" value="<?php echo @$_SESSION['user_id']; ?>" name='user_id' id="user_id"/>
                <input type="hidden" value=" <?php echo $uploadConfig; ?>" name="data"/>
            </form>
            <!--            </div>-->
            <!--            <div class="col-sm-4 col_left ">-->
            <!--                --><?php //include 'dropzone.php'; ?>
            <!--            </div>-->
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="content_8">
        <div class="pp">
            <p class="p38">Chọn nhận xét</p>
        </div>
        <div class="content8_1">
            <select class="form-control" id="forma" onchange="sort(<?php echo $data->id ?>)">
                <!--                <option value="">Theo thười gian</option>-->
                <option value="1">Mới nhất</option>
                <option value="2">Cũ nhất</option>
            </select>
            <!--            <a class="a7"  href=""><p>Hữu ích</p></a>-->
        </div>
        <div class="content8_1">
            <select class="form-control" id="forma1" onchange="sort(<?php echo $data->id ?>)">
                <option value="">Tất cả sao</option>
                <option value="1">Một sao</option>
                <option value="2">Hai sao</option>
                <option value="3">Ba sao</option>
                <option value="4">Bốn sao</option>
                <option value="5">Năm sao</option>
            </select>
        </div>
    </div>
    <div id="_info_comment" class="row-item comments_wapper">
    </div>
</div>


