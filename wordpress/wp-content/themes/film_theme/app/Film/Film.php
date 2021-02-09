<?php

namespace Cactus\Film;

class Film {

  const NAME = 'film';

  /**
   * Film constructor.
   */
  public function __construct() {
    if (!function_exists('film_theme_setup')) {
      add_action('after_setup_theme', [$this, 'film_theme_setup']);
    };
    add_action('widgets_init', [$this, 'film_theme_widgets_init']);
    add_action('after_setup_theme', [$this, 'film_theme_content_width'], 0);
    add_action('wp_enqueue_scripts', [$this, 'film_theme_scripts']);

    add_action('init', [$this, 'register']);
    add_action('init', [$this, 'reg_taxonomy'], 0);
  }

  /**
   * Register
   */
  public function register() {
    register_post_type(self::NAME, [
      'labels'             => [
        'name'           => _x('Film', 'Post type general name', 'textdomain'),
        'singular_name'  => _x('Film', 'Post type singular name', 'textdomain'),
        'menu_name'      => _x('Film', 'Admin Menu text', 'textdomain'),
        'name_admin_bar' => _x('Film', 'Add New on Toolbar', 'textdomain'),
        'add_new'        => __('Add New', 'textdomain'),
        'add_new_item'   => __('Add New type', 'textdomain'),
        'new_item'       => __('New type', 'textdomain'),
        'edit_item'      => __('Edit type', 'textdomain'),
        'view_item'      => __('View type', 'textdomain'),
        'all_items'      => __('All types', 'textdomain'),
        'search_items'   => __('Search type', 'textdomain'),
        'not_found'      => __('No types found.', 'textdomain'),
        'archives'       => _x('Types archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain'),
      ],
      'public'             => TRUE,
      'has_archive'        => TRUE,
    ]);
  }

  /**
   * Register taxonomy(ies).
   */
  public function reg_taxonomy() {
    register_taxonomy('film_genre',
      [self::NAME],
      [
        'hierarchical'          => TRUE,
        'labels'                => [
          'name'              => 'Film genre',
          'singular_name'     => 'Genre',
          'search_items'      => 'Search genre',
          'all_items'         => 'All genres',
          'parent_item'       => NULL,
          'parent_item_colon' => NULL,
          'edit_item'         => 'Edit',
          'update_item'       => 'Update genre',
          'add_new_item'      => 'Add new genre',
          'new_item_name'     => 'Add new genre name',
          'menu_name'         => 'Film genre',
        ],
        'public'                => TRUE,
        'show_in_nav_menus'     => TRUE,
        'show_ui'               => TRUE,
        'show_tagcloud'         => TRUE,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => TRUE,
        'rewrite'               => [
          'hierarchical' => FALSE,
        ],
      ]
    );
  }

  public function film_theme_setup() {
    load_theme_textdomain('film_theme', get_template_directory() . '/languages');

    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    register_nav_menus(
      [
        'menu-1'      => esc_html__('Primary', 'film_theme'),
        'menu-header' => esc_html__('Header-Menu', 'film_theme'),
      ]
    );
    add_theme_support(
      'html5',
      [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',

      ]
    );
    add_theme_support(
      'custom-background',
      apply_filters(
        'film_theme_custom_background_args',
        [
          'default-color' => 'ffffff',
          'default-image' => '',
        ]
      )
    );
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support(
      'custom-logo',
      [
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => TRUE,
        'flex-height' => TRUE,
      ]
    );
  }

  public function film_theme_content_width() {
    $GLOBALS['content_width'] = apply_filters('film_theme_content_width', 640);
  }

  public function film_theme_widgets_init() {
    register_sidebar(
      [
        'name'          => esc_html__('Sidebar', 'film_theme'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'film_theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
      ]
    );
  }

  /**
   * Enqueue scripts and styles.
   */
  public function film_theme_scripts() {
    wp_enqueue_style('film_theme-style', get_stylesheet_uri(), [], _S_VERSION);
    wp_enqueue_style('normalize', get_template_directory_uri() . '/assets/css/normalize.css', ["film_theme-style"], _S_VERSION);
    wp_enqueue_style('film_theme-main-style', get_template_directory_uri() . '/assets/css/style.css', ["film_theme-style"], _S_VERSION);
    wp_enqueue_style('bootstrap-grid', get_template_directory_uri() . '/assets/bootstrap-4.3.1/css/bootstrap-grid.min.css');
    wp_style_add_data('film_theme-style', 'rtl', 'replace');
    wp_enqueue_style('font-connection', get_template_directory_uri() . '/assets/css/font-connection.css');
    wp_enqueue_script('film_theme-navigation', get_template_directory_uri() . '/assets/js/navigation.js', [], _S_VERSION, TRUE);
    wp_enqueue_script('bootstrap-main', get_template_directory_uri() . '/assets/bootstrap-4.3.1/js/bootstrap.min.js', [], _S_VERSION, TRUE);
    wp_enqueue_script('bootstrap-bundle', get_template_directory_uri() . '/assets/bootstrap-4.3.1/js/bootstrap.bundle.min.js', [], _S_VERSION, TRUE);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
      wp_enqueue_script('comment-reply');
    }
  }

}