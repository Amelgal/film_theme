<!Doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="header">
    <div class="header_top">
        <div class="container">
            <div class="row">
                <div class="header_logo col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 d-flex justify-content-end">
                    <!--<?php
                    // Need to understand why the  tag <images> is displayed
                        //echo get_custom_logo();
                    ?>-->
                    <a href="http://film-theme/wordpress/" class="custom-logo-link" rel="home" aria-current="page"><img width="128" height="75" src="http://film-theme/wordpress/wp-content/uploads/2021/01/logo.png" class="custom-logo" alt="Film Theme" /></a>

                </div>
                <?php
                    wp_nav_menu( [
                        'theme_location'  => 'Header-Menu',
                        'menu'            => '',
                        'container'       => 'div',
                        'container_class' => '',
                        'container_id'    => '',
                        'menu_class'      => 'menu menu-header col-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 d-flex justify-content-end',
                        'menu_id'         => '',
                        'echo'            => true,
                        'fallback_cb'     => 'wp_page_menu',
                        'before'          => '',
                        'after'           => '',
                        'link_before'     => '',
                        'link_after'      => '',
                        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'depth'           => 0,
                        'walker'          => '',
                    ] );
                ?>
            </div>
        </div>
    </div>
    <div class="header_content">
        <div class="container>
            <div class="header_content-inner">

                <nav class="menu">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'menu-1',
                            'menu_id' => 'primary-menu',
                            'container'       => 'div',
                            'container_class'     => 'menu-primary',
                        )
                    );
                    ?>
                </nav>
            </div>
        </div>
    </div>
</header>
