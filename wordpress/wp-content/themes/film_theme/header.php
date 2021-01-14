<!Doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<header class="header">
    <div class="header_top">
        <div class="container">
            <div class="space-between">
                <div class="header_logo col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 d-flex justify-content-end">
                  <?php
                  echo get_custom_logo();
                  ?>
                </div>
              <?php
              wp_nav_menu(
                [
                  'theme_location'  => 'menu-header',
                  'menu_id'         => 'header-menu_id',
                  'container'       => 'div',
                  'container_class' => 'header-menu',
                ]);
              ?>
            </div>
        </div>
    </div>
    <div class="header_content">
        <div class="container">
            <div class="header_content-inner">
                <nav class="menu ">
                  <?php
                  wp_nav_menu(
                    [
                      'theme_location'  => 'menu-1',
                      'menu_id'         => 'primary-menu',
                      'container'       => 'div',
                      'container_class' => 'menu-primary',
                    ]
                  );
                  ?>
                </nav>
            </div>
        </div>
    </div>
</header>
