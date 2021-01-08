<?php
define('DIR_PATH', plugin_dir_path(__FILE__));

use Metabox\Genre_Metabox;
use Metabox\Poster_Metabox;
use Metabox\Budget_Metabox;
use Metabox\Original_Title_Metabox;
use Metabox\Country_Metabox;
use Metabox\Release_Metabox;
use Metabox\Revenue_Metabox;
use Metabox\Runtime_Metabox;
use Metabox\Overview_Metabox;
use Core\Cron;

require_once(DIR_PATH . '/class-metabox/class-poster-path-metabox.php');
require_once(DIR_PATH . '/class-metabox/class-budget-metabox.php');
require_once(DIR_PATH . '/class-metabox/class-country-metabox.php');
require_once(DIR_PATH . '/class-metabox/class-original-title-metabox.php');
require_once(DIR_PATH . '/class-metabox/class-release-metabox.php');
require_once(DIR_PATH . '/class-metabox/class-revenue-metabox.php');
require_once(DIR_PATH . '/class-metabox/class-runtime-metabox.php');
require_once(DIR_PATH . '/class-metabox/class-overview-metabox.php');
require_once(DIR_PATH . '/class-metabox/class-genre-metabox.php');
require_once(DIR_PATH . '/core/class-cron.php');


if (!defined('_S_VERSION')) {
  // Replace the version number of the theme on each release.
  define('_S_VERSION', '1.0.0');
}

if (!function_exists('film_theme_setup')) :

    function film_theme_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on film_theme, use a find and replace
         * to change 'film_theme' to the name of your theme in all the template files.
         */
        load_theme_textdomain('film_theme', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(
            array(
                'menu-1' => esc_html__('Primary', 'film_theme'),
                'menu-header' => esc_html__('Header-Menu', 'film_theme'),
            )
        );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',

            )
        );

        // Set up the WordPress core custom background feature.
        add_theme_support(
            'custom-background',
            apply_filters(
                'film_theme_custom_background_args',
                array(
                    'default-color' => 'ffffff',
                    'default-image' => '',
                )
            )
        );

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        add_theme_support(
            'custom-logo',
            array(
                'height' => 250,
                'width' => 250,
                'flex-width' => true,
                'flex-height' => true,
            )
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
function film_theme_scripts()
{
    wp_enqueue_style('film_theme-style', get_stylesheet_uri(), [], _S_VERSION);
    wp_enqueue_style('normalize', get_template_directory_uri() . '/assets/css/normalize.css', ["film_theme-style"], _S_VERSION);
    wp_enqueue_style('film_theme-main-style', get_template_directory_uri() . '/assets/css/style.css', ["film_theme-style"], _S_VERSION);
    // wp_enqueue_style('bootstrap-main', get_template_directory_uri() . '/assets/bootstrap-4.3.1/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap-grid', get_template_directory_uri() . '/assets/bootstrap-4.3.1/css/bootstrap-grid.min.css');
    // wp_enqueue_style('bootstrap-reboot', get_template_directory_uri() . '/assets/bootstrap-4.3.1/css/bootstrap-reboot.min.css');

  wp_style_add_data('film_theme-style', 'rtl', 'replace');

    // Add fonts
    wp_enqueue_style('font-connection', get_template_directory_uri() . '/assets/css/font-connection.css');

   wp_enqueue_script('film_theme-navigation', get_template_directory_uri() . '/js/navigation.js', [], _S_VERSION, TRUE);
    wp_enqueue_script('bootstrap-main', get_template_directory_uri() . '/assets/bootstrap-4.3.1/js/bootstrap.min.js', array(), _S_VERSION, true);
    wp_enqueue_script('bootstrap-bundle', get_template_directory_uri() . '/assets/bootstrap-4.3.1/js/bootstrap.bundle.min.js', array(), _S_VERSION, true);


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
new Genre_Metabox('genre_meta_box_id', __('Genre', 'textdomain'), 'film');
new Original_Title_Metabox('orig_title_meta_box_id', __('Original title', 'textdomain'), 'film');
new Poster_Metabox('poster_path_meta_box_id', __('Poster path', 'textdomain'), 'film');
new Release_Metabox('release_meta_box_id', __('Release', 'textdomain'), 'film');
new Revenue_Metabox('revenue_meta_box_id', __('Revenue', 'textdomain'), 'film');
new Budget_Metabox('budget_meta_box_id', __('Budget', 'textdomain'), 'film', 'side');
new Country_Metabox('country_meta_box_id', __('Country', 'textdomain'), 'film', 'side');
new Runtime_Metabox('runtime_meta_box_id', __('Runtime', 'textdomain'), 'film', 'side');
new Overview_Metabox('overview_meta_box_id', __('Overview', 'textdomain'), 'film', 'side');


/**
 * Register taxonomy(ies).
 */
function film_theme_register_taxonomies() {

  register_taxonomy('film_genre',
    ['film'],
    [
      'hierarchical'          => TRUE,
      /* true - по типу рубрик, false - по типу меток,
      по умолчанию - false */
      'labels'                => [
        /* ярлыки, нужные при создании UI, можете
        не писать ничего, тогда будут использованы
        ярлыки по умолчанию */
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
        //'separate_items_with_commas' => 'Разделяйте платформы запятыми',
        //'add_or_remove_items' => 'Добавить или удалить платформу',
        // 'choose_from_most_used' => 'Выбрать из наиболее часто используемых платформ',
        'menu_name'         => 'Film genre',
      ],
      'public'                => TRUE,
      /* каждый может использовать таксономию, либо
      только администраторы, по умолчанию - true */
      'show_in_nav_menus'     => TRUE,
      /* добавить на страницу создания меню */
      'show_ui'               => TRUE,
      /* добавить интерфейс создания и редактирования */
      'show_tagcloud'         => TRUE,
      /* нужно ли разрешить облако тегов для этой таксономии */
      'update_count_callback' => '_update_post_term_count',
      /* callback-функция для обновления счетчика $object_type */
      'query_var'             => TRUE,
      /* разрешено ли использование query_var, также можно
      указать строку, которая будет использоваться в качестве
      него, по умолчанию - имя таксономии */
      'rewrite'               => [
        /* настройки URL пермалинков */
        //'slug' => 'platform', // ярлык
        'hierarchical' => FALSE // разрешить вложенность

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

function slider_func(array $atts) {
  global $post;
  $atts['numberposts'] = (int) $atts['numberposts'];
  ?>
    <section class="services">
    <div class="services__items">
      <?php
      $myposts = get_posts($atts);
      foreach ($myposts as $post) :
        setup_postdata($post); ?>
          <div class="services__item">
            <?php the_title('<h3 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h3>'); ?>
              <div class="services__text">
                <?php do_excerpt(get_the_excerpt(), 20); ?>
              </div><!-- .services__text -->
              <div class="custom-meta-box">
                  <h5>Popularity of this
                      type: <?= ucfirst(get_post_meta(get_the_ID(), 'popularity', TRUE)) ?></h5>
                  <h5>Difficult of this
                      type: <?= ucfirst(get_post_meta(get_the_ID(), 'difficulty_type', TRUE)) ?></h5>
              </div>
          </div><!-- .services__item -->
        <?php
        $myposts = get_posts($atts);
        foreach ($myposts as $post) :
            setup_postdata($post); ?>
            <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                <article>
                    <?php
                    $id_post = get_the_ID();
                    ?>
                    <img src="<?php echo get_post_meta( $id_post, 'poster_path', 1 ); ?>" alt="">
                    <?php the_excerpt(); ?>
                    <h2><a href="<?php echo the_permalink();?>"><?php the_title(); ?></a></h2>
                </article>
            </div>
            <?php
            wp_reset_postdata();
        endforeach;
        ?>
    </div>
    </section><?php
}

add_shortcode('slider', 'slider_func');

// Limiting the output characters for the the_excerpt();
add_filter( 'excerpt_length', function(){
    return 15;
} );

// Short code for to output all movies
function all_movies_func(array $atts)
{
    global $post;
    $atts['numberposts'] = (int)$atts['numberposts'];
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
                    <img src="<?php echo get_post_meta( $id_post, 'poster_path', 1 ); ?>" alt="">
                    <?php the_excerpt(); ?>
                    <h2><a href="<?php echo the_permalink();?>"><?php the_title(); ?></a></h2>
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


add_action('admin_menu', 'mt_add_pages');
// action function for above hook
function mt_add_pages() {
  add_menu_page('API', 'API config', 8, __FILE__, 'mt_toplevel_page');
}

function mt_toplevel_page() {

  $api_key = 'api_options';
  $hidden_field_name = 'api_options_hidden';
  $data_key_name = 'api_options_content';

  $api_val = get_option($api_key);

  if ($_POST[$hidden_field_name] == 'Y') {
    $api_val = $_POST[$data_key_name];
    update_option($api_key, $api_val);
    ?>
      <div class="updated"><p>
              <strong><?php _e('Options saved.', 'mt_trans_domain'); ?></strong>
          </p></div>
    <?php
  }
  ?>
    <div class="wrap">
        <h2><?= __('API Options', 'mt_trans_domain') ?></h2>
        <form name="form1" method="post"
              action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">

            <input type="hidden" name="<?php echo $hidden_field_name; ?>"
                   value="Y">

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
  /*
   $film_title = 'title';
   $original_film_title = 'original_title';
   $genres = 'genres';
   $poster_path = 'poster_path';
   $release = 'release_date';
   $revenue = 'revenue';
   $runtime = 'runtime';
   $production_countries = 'production_countries';
   $budget = 'budget';
   $overview = 'overview';

   $film_title_val = get_option($film_title);
   $original_film_title_val = get_option($original_film_title);
   $genres_val = get_option($genres);
   $poster_path_val = get_option($poster_path);
   $release_val = get_option($release);
   $revenue_val = get_option($revenue);
   $runtime_val = get_option($runtime);
   $production_countries_val = get_option($production_countries);
   $budget_val = get_option($budget);
   $overview_val = get_option($overview);
 */

  $hidden_field_name = 'film_request_hidden';

  $data_film_title = 'title_request_content';
  $data_original_film_title = 'original_title';
  $data_genres = 'genres';
  $data_poster_path = 'poster_path';
  $data_release = 'year_content';
  $data_revenue = 'revenue';
  $data_runtime = 'runtime';
  $data_production_countries = 'production_countries';
  $data_budget = 'budget';
  $data_overview = 'overview';

  $api_val = get_option('api_options');

  if ($_POST[$hidden_field_name] == 'Y') {

    $film_title_val = $_POST[$data_film_title];
    $original_film_title_val = $_POST[$data_original_film_title];
    $genres_val = $_POST[$data_genres];
    $poster_path_val = $_POST[$data_poster_path];
    $release_val = $_POST[$data_release];
    $revenue_val = $_POST[$data_revenue];
    $runtime_val = $_POST[$data_runtime];
    $production_countries_val = $_POST[$data_production_countries];
    $budget_val = $_POST[$data_budget];
    $overview_val = $_POST[$data_overview];

    /*
    update_option($film_title, $film_title_val);
    update_option($original_film_title, $original_film_title_val);
    update_option($genres, $genres_val);
    update_option($poster_path, $poster_path_val);
    update_option($release, $release_val);
    update_option($revenue, $revenue_val);
    update_option($runtime, $runtime_val);
    update_option($production_countries, $production_countries_val);
    update_option($budget, $budget_val);
    update_option($overview, $overview_val);
    */

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

    if (wp_remote_retrieve_response_message($api_response) === 'Created') {
      ?>
        <div class="updated">
            <p>
                <strong><?php _e('Request sent.', 'mt_trans_domain'); ?></strong>
            </p>
        </div>
      <?php
    }
    else {
      ?>
        <div class="updated">
            <p>
                <strong><?php _e('Error.', 'mt_trans_domain'); ?></strong>
            </p>
        </div>
      <?php
    }
  }

  ?>
    <div class="wrap">
        <h2><?= __('Request to add a new movie to the list', 'mt_trans_domain') ?></h2>
        <form name="form1" method="post"
              action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">

            <input type="hidden" name="<?php echo "$hidden_field_name"; ?>"
                   value="Y">

            <p><?php _e("Film title:", 'mt_trans_domain'); ?>
                <input type="text" name="<?php echo $data_film_title; ?>"
                       value="<?php echo $film_title_val; ?>" size="30">
            </p>
            <p><?php _e("Original title:", 'mt_trans_domain'); ?>
                <input type="text"
                       name="<?php echo $data_original_film_title; ?>"
                       value="<?php echo $original_film_title_val; ?>"
                       size="30">
            </p>
            <p><?php _e("Genre:", 'mt_trans_domain'); ?>
                <input type="text" name="<?php echo $data_genres; ?>"
                       value="<?php echo $genres_val; ?>" size="30">
            </p>
            <p><?php _e("Poster:", 'mt_trans_domain'); ?>
                <input type="text" name="<?php echo $data_poster_path; ?>"
                       value="<?php echo $poster_path_val; ?>" size="30">
            </p>
            <p><?php _e("Release:", 'mt_trans_domain'); ?>
                <input type="text" name="<?php echo $data_release; ?>"
                       value="<?php echo $release_val; ?>" size="30">
            </p>
            <p><?php _e("Revenue:", 'mt_trans_domain'); ?>
                <input type="text" name="<?php echo $data_revenue; ?>"
                       value="<?php echo $revenue_val; ?>" size="30">
            </p>
            <p><?php _e("Runtime:", 'mt_trans_domain'); ?>
                <input type="text" name="<?php echo $data_runtime; ?>"
                       value="<?php echo $runtime_val; ?>" size="30">
            </p>
            <p><?php _e("Budget:", 'mt_trans_domain'); ?>
                <input type="text" name="<?php echo $data_budget; ?>"
                       value="<?php echo $budget_val; ?>" size="30">
            </p>
            <p><?php _e("Country:", 'mt_trans_domain'); ?>
                <input type="text"
                       name="<?php echo $data_production_countries; ?>"
                       value="<?php echo $production_countries_val; ?>"
                       size="30">
            </p>
            <p><?php _e("Overview:", 'mt_trans_domain'); ?>
            <p><textarea rows="10" cols="60"
                         name="<?= $data_overview; ?>"><?= $overview_val; ?></textarea>
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

new Cron();