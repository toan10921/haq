<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="<?php echo esc_url("http://gmpg.org/xfn/11") ?>">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>
    <?php \T888Core\TemplateHelper::render_preloader(); ?>

</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
<?php t888f_get_template('layout/header-template', get_theme_mod('header_style', 'default') , array(), true); ?>

