<?php
define('DIR_PATH', plugin_dir_path(__FILE__));
define('PREFIX', 'wp_');

use Metabox\Genre_Metabox;
use Metabox\Poster_Metabox;
use Metabox\Budget_Metabox;
use Metabox\Original_Title_Metabox;
use Metabox\Country_Metabox;
use Metabox\Release_Metabox;
use Metabox\Revenue_Metabox;
use Metabox\Runtime_Metabox;
use Metabox\Overview_Metabox;
use Cron\Upload_Bd;

require_once(DIR_PATH . '/classes/core/class-base-cron.php');
require_once(DIR_PATH . '/classes/core/class-base-meta-box.php');

require_once(DIR_PATH . '/classes/class-metabox/class-poster-path-metabox.php');
require_once(DIR_PATH . '/classes/class-metabox/class-budget-metabox.php');
require_once(DIR_PATH . '/classes/class-metabox/class-country-metabox.php');
require_once(DIR_PATH . '/classes/class-metabox/class-original-title-metabox.php');
require_once(DIR_PATH . '/classes/class-metabox/class-release-metabox.php');
require_once(DIR_PATH . '/classes/class-metabox/class-revenue-metabox.php');
require_once(DIR_PATH . '/classes/class-metabox/class-runtime-metabox.php');
require_once(DIR_PATH . '/classes/class-metabox/class-overview-metabox.php');
require_once(DIR_PATH . '/classes/class-metabox/class-genre-metabox.php');
require_once(DIR_PATH . '/classes/class-cron/class-upload-bd.php');


if (!defined('_S_VERSION')) {
  define('_S_VERSION', '1.0.0');
}

if (!function_exists('film_theme_setup')) :

  function film_theme_setup() {
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

endif;
add_action('after_setup_theme', 'film_theme_setup');

function film_theme_content_width() {
  $GLOBALS['content_width'] = apply_filters('film_theme_content_width', 640);
}
add_action('after_setup_theme', 'film_theme_content_width', 0);

function film_theme_widgets_init() {
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
add_action('widgets_init', 'film_theme_widgets_init');

/**
 * Enqueue scripts and styles.
 */

function film_theme_scripts() {
  wp_enqueue_style('film_theme-style', get_stylesheet_uri(), [], _S_VERSION);
  wp_enqueue_style('normalize', get_template_directory_uri() . '/assets/css/normalize.css', ["film_theme-style"], _S_VERSION);
  wp_enqueue_style('film_theme-main-style', get_template_directory_uri() . '/assets/css/style.css', ["film_theme-style"], _S_VERSION);
  wp_enqueue_style('bootstrap-grid', get_template_directory_uri() . '/assets/bootstrap-4.3.1/css/bootstrap-grid.min.css');
  wp_style_add_data('film_theme-style', 'rtl', 'replace');
  wp_enqueue_style('font-connection', get_template_directory_uri() . '/assets/css/font-connection.css');
  wp_enqueue_script('film_theme-navigation', get_template_directory_uri() . '/js/navigation.js', [], _S_VERSION, TRUE);
  wp_enqueue_script('bootstrap-main', get_template_directory_uri() . '/assets/bootstrap-4.3.1/js/bootstrap.min.js', [], _S_VERSION, TRUE);
  wp_enqueue_script('bootstrap-bundle', get_template_directory_uri() . '/assets/bootstrap-4.3.1/js/bootstrap.bundle.min.js', [], _S_VERSION, TRUE);

  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}
add_action('wp_enqueue_scripts', 'film_theme_scripts');

function film_setup_post_type() {
  $labels = [
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
  ];
  $args = [
    'public'      => TRUE,
    'labels'      => $labels,
    'has_archive' => TRUE,
  ];
  register_post_type('Film', $args);
}
add_action('init', 'film_setup_post_type');

/**
 * Register meta box(es).
 * Save meta box content.
 */

new Genre_Metabox('genre', 'genre_meta_box_id', __('Genre', 'textdomain'), 'film');
new Original_Title_Metabox('orig_title', 'orig_title_meta_box_id', __('Original title', 'textdomain'), 'film');
new Poster_Metabox('poster_path', 'poster_path_meta_box_id', __('Poster path', 'textdomain'), 'film');
new Release_Metabox('release', 'release_meta_box_id', __('Release', 'textdomain'), 'film');
new Revenue_Metabox('revenue', 'revenue_meta_box_id', __('Revenue', 'textdomain'), 'film');
new Budget_Metabox('budget', 'budget_meta_box_id', __('Budget', 'textdomain'), 'film', 'side',);
new Country_Metabox('country', 'country_meta_box_id', __('Country', 'textdomain'), 'film', 'side');
new Runtime_Metabox('runtime', 'runtime_meta_box_id', __('Runtime', 'textdomain'), 'film', 'side');
new Overview_Metabox('overview', 'overview_meta_box_id', __('Overview', 'textdomain'), 'film', 'side');

/**
 * Register taxonomy(ies).
 */

function film_theme_register_taxonomies() {

  register_taxonomy('film_genre',
    ['film'],
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
add_action('init', 'film_theme_register_taxonomies', 0);

function do_excerpt($string, $word_limit) {
  $words = explode(' ', $string, ($word_limit + 1));
  if (count($words) > $word_limit) {
    array_pop($words);
  }
  echo implode(' ', $words) . ' ...';
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
  require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Add page in admin menu.
 */

add_action('admin_menu', 'mt_add_pages');
function mt_add_pages() {
  add_menu_page('API', 'API config', 8, __FILE__, 'mt_toplevel_page');
}

function mt_toplevel_page() {

  $api_key = 'api_options';
  $data_key_name = 'api_options_content';

  $api_val = get_option($api_key);

  if (get_option('answer') == 'Y') {
    ?>
      <div class="updated"><p>
              <strong><?php _e('Options saved.', 'mt_trans_domain'); ?></strong>
          </p></div>
    <?php
    update_option('answer', NULL);
  }
  ?>
    <div class="wrap">
        <h2><?= __('API Options', 'mt_trans_domain') ?></h2>
        <form name="form1" method="post"
              action="/wordpress/wp-admin/admin-post.php">

            <input type="hidden" name="action" value="api_key_hook">
            <input type="hidden" name="activation" value="Y">
            <input type="hidden" name="path"
                   value="<?= str_replace('%7E', '~', $_SERVER['REQUEST_URI']) ?>">

            <p><?php _e("API key:", 'mt_trans_domain'); ?>
                <input type="text" name="<?php echo $data_key_name; ?>"
                       value="<?php echo $api_val; ?>" size="60">
            </p>
            <hr/>
            <p class="submit">
                <input type="submit" name="Submit"
                       value="<?php _e('Update Options', 'mt_trans_domain') ?>"/>
            </p>
        </form>
    </div>
  <?php
}

add_action('admin_post_api_key_hook', 'api_key_action_hook_function');
function api_key_action_hook_function() {

  update_option('api_options', $_POST['api_options_content']);
  update_option('answer', $_POST['activation']);

  header("Location: http://" . $_SERVER['HTTP_HOST'] . $_POST['path']);
}

add_action('admin_menu', 'api_request_register_admin_page');
function api_request_register_admin_page() {
  add_submenu_page(
    'edit.php?post_type=film',
    'API request',
    'Add new film',
    'manage_categories',
    'api-request',
    'api_request_render_admin_page'
  );
}

function api_request_render_admin_page() {

  $param = (require(DIR_PATH . 'config/film_request_config.php'));

  if (get_option('answer') == 'Created') {
    ?>
      <div class="updated">
          <p>
              <strong><?php _e('Request sent.', 'mt_trans_domain'); ?></strong>
          </p>
      </div>
    <?php
    update_option('answer', NULL);
  }
  ?>
    <div class="wrap">
        <h2><?= __('Request to add a new movie to the list', 'mt_trans_domain') ?></h2>
        <form name="form1" method="post"
              action="/wordpress/wp-admin/admin-post.php">

            <input type="hidden" name="action" value="new_film_hook">
            <input type="hidden" name="path"
                   value="<?= str_replace('%7E', '~', $_SERVER['REQUEST_URI']) ?>">
          <?php
          foreach ($param as $key => $item):
            ?>
              <p><?php _e($key, 'mt_trans_domain'); ?>
                  <input type="text" name="<?= $item; ?>"
                         size="30">
              </p>
          <?php
          endforeach;
          ?>
            <p><?php _e("Overview:", 'mt_trans_domain'); ?>
            <p><textarea rows="10" cols="60"
                         name="<?php _e("overview", 'mt_trans_domain'); ?>"> </textarea>
            </p>
            <hr/>
            <p class="submit">
                <input type="submit" name="Submit"
                       value="<?php _e('Sent request', 'mt_trans_domain') ?>"/>
                <input type="reset"
                       value="<?php _e('Reset', 'mt_trans_domain') ?>">
            </p>
        </form>
    </div>
    <div class="clear"></div>
  <?php
}

add_action('admin_post_new_film_hook', 'new_film_action_hook_function');
function new_film_action_hook_function() {

  $api_val = get_option('api_options');
  $film_title_val = $_POST['title_request_content'];
  $original_film_title_val = $_POST['original_title'];
  $genres_val = $_POST['genres'];
  $poster_path_val = $_POST['poster_path'];
  $release_val = $_POST['year_content'];
  $revenue_val = $_POST['revenue'];
  $runtime_val = $_POST['runtime'];
  $production_countries_val = $_POST['production_countries'];
  $budget_val = $_POST['budget'];
  $overview_val = $_POST['overview'];

  $api_response = wp_remote_post('http://movie-world.top/wp-json/wp/v2/movie', [
    'headers' => [
      'Authorization' => 'Basic ' . $api_val,
    ],
    'body'    => [
      "title"                => $film_title_val,
      "original_title"       => $original_film_title_val,
      "genres"               => $genres_val,
      "poster_path"          => $poster_path_val,
      "release_date"         => $release_val,
      "revenue"              => $revenue_val,
      "runtime"              => $runtime_val,
      "production_countries" => $production_countries_val,
      "budget"               => $budget_val,
      "overview"             => $overview_val,
      "status"               => "pending",
    ],
  ]);
  update_option('answer', wp_remote_retrieve_response_message($api_response));

  header("Location: http://" . $_SERVER['HTTP_HOST'] . $_POST['path']);
}

new Upload_Bd('daily_event');

add_filter('excerpt_length', function () {
  return 15;
});

function all_movies_func(array $atts) {
  global $post;
  $atts['numberposts'] = (int) $atts['numberposts'];
  ?>
    <section class="services">
    <div class="services__items">
      <?php
      $myposts = get_posts($atts);
      foreach ($myposts as $post) :
        setup_postdata($post); ?>
          <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
              <article>
                <?php
                $id_post = get_the_ID();
                ?>
                  <img src="<?php echo get_post_meta($id_post, 'poster_path', 1); ?>"
                       alt="">
                <?php the_excerpt(); ?>
                  <h2>
                      <a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a>
                  </h2>
              </article>
          </div>
        <?php
        wp_reset_postdata();
      endforeach;
      ?>
    </div>
    </section><?php

}
add_shortcode('all_movies', 'all_movies_func');
