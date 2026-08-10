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
                    <?php esc_html_e('Pingback:', 'nebon'); ?>
                    <?php comment_author_link(); ?>
                    <?php edit_comment_link(esc_html__('Edit', 'nebon'), '<span class="edit-link">', '</span>'); ?>
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
                                <?php echo get_comment_date('M. j, Y') . ' at ' . get_comment_time('g:i a'); ?>

                            </div>
                            <div class="comment-author">
                                <?php echo get_comment_author_link(); ?>
                            </div>


                            <div class="comment-text">
                                <?php
                                if ($comment->comment_approved == '0') {
                                    echo '<em>' . esc_html__('Your comment is awaiting moderation. This is a preview; your comment will be visible after it has been approved.', 'nebon') . '</em><br />';
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
                                    'reply_text' => esc_html__('REPLY', 'nebon'),
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
                    <?php echo esc_html__('COMMENTS', 'nebon'); ?> ( <?php echo get_comments_number(); ?> )
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
                <h1 class="screen-reader-text"><?php esc_html_e('Comment navigation', 'nebon'); ?></h1>
                <div class="nav-previous"><?php previous_comments_link(esc_html__('&larr; Older Comments', 'nebon')); ?></div>
                <div class="nav-next"><?php next_comments_link(esc_html__('Newer Comments &rarr;', 'nebon')); ?></div>
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
    <p class="no-comments"><?php esc_html_e('Comments are closed.', 'nebon'); ?></p>
<?php endif; ?>


<?php
if (comments_open()) :
?>
    <!-- #comments -->
    <div class="leave-comments contact-form reply-comment">
        <?php
        $icon_class = get_theme_mod('logo_icon', 'las la-rainbow');

        ?>

        <div class="t888-heading style2">
            <div class="title-wrapper">
                <h3 class="title title-comment">
                    <?php echo esc_html__('LEAVE A COMMENT', 'nebon'); ?>
                </h3>
            </div>
        </div>

        <?php
        $comment_form = array(
            'title_reply' => 'Reply',
            'fields' => array(
                'author' => '<div class="name-email-wrap">
        <p class="contact-name">
            <input class="border" id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" placeholder="' . esc_attr__('Your Name*', 'nebon') . '" />
        </p>',

                'email' => '<p class="contact-email">
        <input class="border" id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" placeholder="' . esc_attr__('Your Email*', 'nebon') . '" />
    </p>',

                'phone' => '<p class="contact-phone">
        <input class="border" id="phone" name="phone" type="text" value="" placeholder="' . esc_attr__('Mobile', 'nebon') . '" />
    </p></div>',
            ),

            'comment_field' =>  '<p class="contact-message">
                                <textarea id="comment" class="border" rows="5" name="comment" aria-required="true" placeholder="' . esc_attr__('Your comment*', 'nebon') . '"></textarea>
                            </p>',
            'must_log_in' => '<div class="must-log-in control-group"><p class="desc silver">' . sprintf(wp_kses_post(__('You must be <a href="%s">logged in</a> to post a comment.', 'nebon')), wp_login_url(apply_filters('the_permalink', get_permalink()))) . '</p></div >',
            'logged_in_as' => '<div class="logged-in-as control-group"><p class="desc silver">' . sprintf(wp_kses_post(__('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'nebon')), admin_url('profile.php'), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink()))) . '</p></div>',
            'comment_notes_before' => '<p class="comment-notes">' . esc_html__('Your email address will not be published. Required fields are marked *', 'nebon') . '</p>',
            'comment_notes_after' => '',
            'id_form'              => 'commentform',
            'id_submit'            => 'submit',
            'title_reply' => '',
            'title_reply_to'       => esc_html__('Leave a Reply %s', 'nebon'),
            'cancel_reply_link'    => esc_html__('Cancel reply', 'nebon'),
            'label_submit'         => esc_html__('POST COMMENT', 'nebon'),
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