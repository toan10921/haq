<?php

/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package tech888-core
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

if (post_password_required()) {
    return;
}
if (!function_exists('tech888f_comments_list')) {
    function tech888f_comments_list($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;
        $args['avatar_size'] = 105;

        if ('pingback' == $comment->comment_type || 'trackback' == $comment->comment_type) :
?>
            <li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
                <div class="comment-body">
                    <?php esc_html_e('Liên kết đến:', 'nebon'); ?>
                    <?php comment_author_link(); ?>
                    <?php edit_comment_link(esc_html__('Sửa', 'nebon'), '<span class="edit-link">', '</span>'); ?>
                </div>
            <?php else : ?>
            <li <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?>>
                <div id="comment-<?php comment_ID(); ?>" class="comment-item d-flex justify-content-between">
                    <div class="comment-left d-flex">
                        <div class="comment-avatar">
                            <?php echo get_avatar($comment, $args['avatar_size']); ?>
                        </div>

                        <div class="comment-details">
                            <div class="comment-date">
                                <?php echo esc_html(get_comment_date('d/m/Y') . ' lúc ' . get_comment_time('H:i')); ?>

                            </div>
                            <div class="comment-author">
                                <?php echo get_comment_author_link(); ?>
                            </div>


                            <div class="comment-text">
                                <?php
                                if ($comment->comment_approved == '0') {
                                    echo '<em>' . esc_html__('Bình luận của bạn đang chờ duyệt và sẽ hiển thị sau khi được chấp thuận.', 'nebon') . '</em><br />';
                                }
                                comment_text();
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="comment-right">
                        <?php if (comments_open()) : ?>
                            <div class="comment-reply">
                                <?php echo get_comment_reply_link(array_merge($args, array(
                                    'reply_text' => esc_html__('TRẢ LỜI', 'nebon'),
                                    'depth'      => $depth,
                                    'max_depth'  => $args['max_depth']
                                ))); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </li>
<?php endif;
    }
}


?>
<?php // You can start editing here -- including this comment! 
$icon_class = get_theme_mod('logo_icon', 'las la-rainbow');
?>

<?php if (have_comments()) : ?>
    <div id="comments" class="comments-area comments blog-comment-detail">
        <div class="t888-heading style2">
            <div class="title-wrapper">
                <h3 class="title title-comment">
                    <?php echo esc_html__('BÌNH LUẬN', 'nebon'); ?> (<?php echo esc_html(get_comments_number()); ?>)
                </h3>

            </div>
        </div>
        <div class="comments">
            <ol class="comment-list list-none">
                <?php
                wp_list_comments(array(
                    'style'         => '',
                    'short_ping'     => true,
                    'avatar_size'     => 70,
                    'max_depth'     => '5',
                    'callback'         => 'tech888f_comments_list',
                ));
                ?>
            </ol>
        </div>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through 
        ?>
            <nav id="comment-nav-below" class="comment-navigation" role="navigation">
                <h1 class="screen-reader-text"><?php esc_html_e('Điều hướng bình luận', 'nebon'); ?></h1>
                <div class="nav-previous"><?php previous_comments_link(esc_html__('&larr; Bình luận cũ hơn', 'nebon')); ?></div>
                <div class="nav-next"><?php next_comments_link(esc_html__('Bình luận mới hơn &rarr;', 'nebon')); ?></div>
            </nav><!-- #comment-nav-below -->
        <?php endif; // check for comment navigation 
        ?>
    </div>
<?php endif; // have_comments() 
?>

<?php
// If comments are closed and there are comments, let's leave a little note, shall we?
if (! comments_open() && '0' != get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
?>
    <p class="no-comments"><?php esc_html_e('Bài viết đã đóng bình luận.', 'nebon'); ?></p>
<?php endif; ?>


<?php
if (comments_open()) :
?>
    <!-- #comments -->
    <div class="leave-comments contact-form reply-comment">
        <?php
        $icon_class = get_theme_mod('logo_icon', 'las la-rainbow');

        ?>

        <div class="comment-form-heading">
            <h2><?php esc_html_e('Để lại bình luận', 'nebon'); ?></h2>
        </div>

        <?php
        $comment_form = array(
            'title_reply' => esc_html__('Trả lời', 'nebon'),
            'fields' => array(
                'author' => '<div class="name-email-wrap">
        <p class="contact-name">
            <input class="border" id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" placeholder="' . esc_attr__('Họ và tên*', 'nebon') . '" required />
        </p>',

                'email' => '<p class="contact-email">
        <input class="border" id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" placeholder="' . esc_attr__('Email*', 'nebon') . '" required />
    </p></div>',
            ),

            'comment_field' =>  '<p class="contact-message">
                                <textarea id="comment" class="border" rows="5" name="comment" required aria-required="true" placeholder="' . esc_attr__('Nội dung bình luận*', 'nebon') . '"></textarea>
                            </p>',
            'must_log_in' => '<div class="must-log-in control-group"><p class="desc silver">' . sprintf(wp_kses_post(__('Bạn cần <a href="%s">đăng nhập</a> để gửi bình luận.', 'nebon')), wp_login_url(apply_filters('the_permalink', get_permalink()))) . '</p></div>',
            'logged_in_as' => '<div class="logged-in-as control-group"><p class="desc silver">' . sprintf(wp_kses_post(__('Bạn đang đăng nhập với tài khoản <a href="%1$s">%2$s</a>. <a href="%3$s" title="Đăng xuất khỏi tài khoản này">Đăng xuất?</a>', 'nebon')), admin_url('profile.php'), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink()))) . '</p></div>',
            'comment_notes_before' => '<p class="comment-notes">' . esc_html__('Địa chỉ email của bạn sẽ không được công khai. Các trường bắt buộc được đánh dấu *', 'nebon') . '</p>',
            'comment_notes_after' => '',
            'id_form'              => 'commentform',
            'id_submit'            => 'submit',
            'title_reply' => '',
            'title_reply_to'       => esc_html__('Trả lời %s', 'nebon'),
            'cancel_reply_link'    => esc_html__('Hủy trả lời', 'nebon'),
            'label_submit'         => esc_html__('Gửi bình luận', 'nebon'),
            'class_submit'         => 'submit-btn button',
            'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>',
        );
        ?>
        <?php
        comment_form($comment_form); ?>
    </div>
<?php
endif;

class tech888f_custom_comment extends Walker_Comment
{

    /** START_LVL 
     * Starts the list before the CHILD elements are added. */
    function start_lvl(&$output, $depth = 0, $args = array())
    {
        $GLOBALS['comment_depth'] = $depth + 1;

        $output .= '<div class="children">';
    }

    /** END_LVL 
     * Ends the children list of after the elements are added. */
    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $GLOBALS['comment_depth'] = $depth + 1;
        $output .= '</div>';
    }
    function end_el(&$output, $object, $depth = 0, $args = array())
    {
        $output .= '';
    }
}
?>
