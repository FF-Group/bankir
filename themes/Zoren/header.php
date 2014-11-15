<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package web2feel
 * @since web2feel 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php
        /*
         * Print the <title> tag based on what is being viewed.
         */
        global $page, $paged;

        wp_title('|', true, 'right');

        // Add the blog name.
        bloginfo('name');

        // Add the blog description for the home/front page.
        $site_description = get_bloginfo('description', 'display');
        if ($site_description && (is_home() || is_front_page()))
            echo " | $site_description";

        // Add a page number if necessary:
        if ($paged >= 2 || $page >= 2)
            echo ' | ' . sprintf(__('Page %s', 'web2feel'), max($paged, $page));

        ?></title>

    <link rel="profile" href="http://gmpg.org/xfn/11"/>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>

    <link href='http://fonts.googleapis.com/css?family=Bitter:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,800,700,600' rel='stylesheet' type='text/css'>

    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
    <![endif]-->

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site grid64">

    <header id="masthead" class="site-header row" role="banner">

        <div class="logo block-7">

            <?php if (get_theme_mod(FT_scope::tool()->optionsName . '_logo', '') != '') { ?>
                <h1 class="site-title logo"><a class="mylogo" rel="home" href="<?php bloginfo('siteurl'); ?>/"
                                               title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>"><img
                            relWidth="<?php echo intval(get_theme_mod(FT_scope::tool()->optionsName . '_maxWidth', 0)); ?>"
                            relHeight="<?php echo intval(get_theme_mod(FT_scope::tool()->optionsName . '_maxHeight', 0)); ?>"
                            id="ft_logo" src="<?php echo get_theme_mod(FT_scope::tool()->optionsName . '_logo', ''); ?>"
                            alt=""/></a></h1>
            <?php } else { ?>
                <h1 class="site-title logo"><a id="blogname" rel="home" href="<?php bloginfo('siteurl'); ?>/"
                                               title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>"><?php bloginfo('name'); ?></a>
                </h1>
            <?php } ?>

            <h2 class="site-description"><?php bloginfo('description'); ?></h2>
        </div>

        <div id="botmenu" class="block-8-9-10">
            <?php wp_nav_menu(array('container_id' => 'submenu', 'theme_location' => 'primary', 'menu_id' => 'web2feel', 'menu_class' => 'sfmenu', 'fallback_cb' => 'fallbackmenu')); ?>
        </div>
        <div class="right-logo">
            <h1 class="right-site-title logo"><a id="blogname" rel="home" href="<?php bloginfo('siteurl'); ?>/"
                                                 title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>"><?php echo __('Обмен Валют'); ?></a>
            </h1>
        </div>

    </header>
    <!-- #masthead .site-header -->
    <!--	<div class="thickline block-7-8-9-10"></div>-->
    <div id="main" class="site-main row">
