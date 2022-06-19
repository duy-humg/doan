<?php
$return = FSInput::get('cmt_return');
$module = FSInput::get('cmt_module');
$view = FSInput::get('cmt_view');
$max_level = 1;
?>
<?php

function display_comment_item($item, $childdren, $level, $max_level = 2, $return, $module, $view,$comments_image,$count_comments_children)
{
//    var_dump($count_comments_children) ;
    $sub = ($level >= $max_level) ? ($max_level % 2) : ($level % 2);
    if ($item->admin_reply != 1 and $item->parent_id == 0) {
        $html = '<div class="comment-item comment-item-' . $item->id . ' ' . ($count_comments_children != 0 ? "comment-child" : "parent") . ' comment_level_' . $level . ' comment_sub_' . $sub . ' ' . ($item->report != 0 ? "comment-child-yes" : "comment-child-no") . ' "   >';
        $admin = strpos($item->name, 'admin') !== false ? 'admin' : '';
        $email = strpos($item->name, 'admin') !== false ? '' : '(<span>' . $item->email . '</span>)';
        $html .='<div class="bao_content9_1">';
        $html .='<div class="content9_1">';
        if ($item->admin_reply == 1)
            $html .= '<img class="img_user" alt="noavarta"  src="' . URL_ROOT . 'images/img_geni.png">';
        else
            if($item->level == 0)
                $html .= '<img class="img_user img_ava" alt="noavarta"  src="' . URL_ROOT . 'images/avt_cmt.png">';
            
                $html .= '<p class=" ' . $admin . '"><span class=""></span>
            
            
        </div>';
        $html .= '<div class="row-item item-comment">';

        if ($item->rating > 0) {
            $html .='<p class="name"><span class="user_name">'. $item->name .'</span>';

            $html .= '<p class="star-detail fl" data-rating="' . $item->rating . '">';

            $html .='</p><span class="danhgia">'. $item->title .'</span>';

        }
        if($item->level==1){
            $html .='<p class="name_2"><span class="user_name">Phản hồi của người bán</span>';
        }

        $html .= '<p class="content">' . $item->comment . '</p>';
        $html .= '<p class="date">' . date('H:m:s d-m-Y ', strtotime($item->created_time)) . '</p>';

        

        $html .= '</div>';
        if ($level == 0)

        $html .= '</div>';
        $html .= '</div>';
        if ($level >= $max_level) {
            $html .= '</div>';
        }
        if (isset($childdren[$item->id]) && count($childdren[$item->id])) {
            foreach ($childdren[$item->id] as $c) {
                $html .= display_comment_item($c, $childdren, $level + 1, $max_level = 2, $return, $module, $view);
            }
        }
        if ($level < $max_level) {
            $html .= '</div>';
        }
    }
    return $html;
}

?>

<?php
$num_child = array();
$wrap_close = 0;
if ($comments) {
    ?>
    <div class='_contents comments_contents row-item'>
        <?php foreach ($list_parent as $item) {
             $comments_image = $this->model->get_records('record_id='.$item->id, 'fs_contact_uploadfile', 'file_up');
             $comments_children = $this->model->get_comments_child($item->id);
             $count_comments_children = count($comments_children);
            //  var_dump( $count_comments_children);
//             var_dump($comments_image);
             ?>

            <?php echo display_comment_item($item, $list_children, 0, 2, $return, $module, $view,$comments_image,$count_comments_children); ?>
        <?php } ?>
    </div>
    <?php if ($pagination) echo $pagination->showPagination(3); ?>
<?php } ?>


<script>
    display_hidden_comment_form();

    function display_hidden_comment_form() {
        $('.button_reply').click(function () {
            $(this).next().removeClass('hide');
            $(this).addClass('hide');
        });
        $('.button_reply_close').click(function () {
            $(this).parent().parent().parent().parent().addClass('hide');
            $(this).parent().parent().parent().parent().parent().children('a').removeClass('hide');
        });
    }

    $(document).ready(function () {
        if ($('.star-detail').attr('data-rating')) {

            $('.star-detail').raty({
                readOnly: true,

                score: function () {
                    return $(this).attr('data-rating');
                },
                starOff: 'images/icon_sao3.png',
                starOn: 'images/icon_sao1.png',
                targetFormat: '{score}',

            });
        }

    })

</script>
