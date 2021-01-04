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

require_once(DIR_PATH . '/class-metabox/class-poster-path-metabox.php');
require_once(DIR_PATH . '/class-metabox/class-budget-metabox.php');
require_once(DIR_PATH . '/class-metabox/class-country-metabox.php');
require_once(DIR_PATH . '/class-metabox/class-original-title-metabox.php');
require_once(DIR_PATH . '/class-metabox/class-release-metabox.php');
require_once(DIR_PATH . '/class-metabox/class-revenue-metabox.php');
require_once(DIR_PATH . '/class-metabox/class-runtime-metabox.php');
require_once(DIR_PATH . '/class-metabox/class-overview-metabox.php');
require_once(DIR_PATH . '/class-metabox/class-genre-metabox.php');


if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}

if (!function_exists('wp_course_setup')) :

    function wp_course_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Wp_course, use a find and replace
         * to change 'wp_course' to the name of your theme in all the template files.
         */
        load_theme_textdomain('wp_course', get_template_directory() . '/languages');

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
                'menu-1' => esc_html__('Primary', 'wp_course'),
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
                'wp_course_custom_background_args',
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
add_action('after_setup_theme', 'wp_course_setup');

function wp_course_content_width()
{
    $GLOBALS['content_width'] = apply_filters('wp_course_content_width', 640);
}

add_action('after_setup_theme', 'wp_course_content_width', 0);

function wp_course_widgets_init()
{
    register_sidebar(
        array(
            'name' => esc_html__('Sidebar', 'wp_course'),
            'id' => 'sidebar-1',
            'description' => esc_html__('Add widgets here.', 'wp_course'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        )
    );
}

add_action('widgets_init', 'wp_course_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function wp_course_scripts()
{
    wp_enqueue_style('wp_course-style', get_stylesheet_uri(), array(), _S_VERSION);
    wp_enqueue_style('normalize', get_template_directory_uri() . '/assets/css/normalize.css', array("wp_course-style"), _S_VERSION);
    wp_enqueue_style('wp_course-main-style', get_template_directory_uri() . '/assets/css/style.css', array("wp_course-style"), _S_VERSION);

    wp_style_add_data('wp_course-style', 'rtl', 'replace');

    wp_enqueue_script('wp_course-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'wp_course_scripts');

function film_setup_post_type()
{
    $labels = array(
        'name' => _x('Film', 'Post type general name', 'textdomain'),
        'singular_name' => _x('Film', 'Post type singular name', 'textdomain'),
        'menu_name' => _x('Film', 'Admin Menu text', 'textdomain'),
        'name_admin_bar' => _x('Film', 'Add New on Toolbar', 'textdomain'),
        'add_new' => __('Add New', 'textdomain'),
        'add_new_item' => __('Add New type', 'textdomain'),
        'new_item' => __('New type', 'textdomain'),
        'edit_item' => __('Edit type', 'textdomain'),
        'view_item' => __('View type', 'textdomain'),
        'all_items' => __('All types', 'textdomain'),
        'search_items' => __('Search type', 'textdomain'),
        'not_found' => __('No types found.', 'textdomain'),
        'archives' => _x('Types archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain'),
    );
    $args = array(
        'public' => true,
        'labels' => $labels,
        'has_archive' => true,
    );
    register_post_type('Film', $args);
}

add_action('init', 'film_setup_post_type');

/**
 * Register meta box(es).
 * Save meta box content.
 */
new Genre_Metabox('genre_meta_box_id',              __('Genre', 'textdomain'),         'film');
new Original_Title_Metabox('orig_title_meta_box_id',__('Original title', 'textdomain'),'film');
new Poster_Metabox('poster_path_meta_box_id',       __('Poster path', 'textdomain'),   'film');
new Release_Metabox('release_meta_box_id',          __('Release', 'textdomain'),       'film');
new Revenue_Metabox('revenue_meta_box_id',          __('Revenue', 'textdomain'),       'film');
new Budget_Metabox('budget_meta_box_id',            __('Budget', 'textdomain'),        'film','side');
new Country_Metabox('country_meta_box_id',          __('Country', 'textdomain'),       'film','side');
new Runtime_Metabox('runtime_meta_box_id',          __('Runtime', 'textdomain'),       'film','side');
new Overview_Metabox('overview_meta_box_id',        __('Overview', 'textdomain'),      'film','side');


/**
 * Register taxonomy(ies).
 */
function wp_course_register_taxonomies()
{

    register_taxonomy('film_genre',
        array('film'),
        array(
            'hierarchical' => true,
            /* true - по типу рубрик, false - по типу меток,
            по умолчанию - false */
            'labels' => array(
                /* ярлыки, нужные при создании UI, можете
                не писать ничего, тогда будут использованы
                ярлыки по умолчанию */
                'name' => 'Film genre',
                'singular_name' => 'Genre',
                'search_items' => 'Search genre',
                'all_items' => 'All genres',
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => 'Edit',
                'update_item' => 'Update genre',
                'add_new_item' => 'Add new genre',
                'new_item_name' => 'Add new genre name',
                //'separate_items_with_commas' => 'Разделяйте платформы запятыми',
                //'add_or_remove_items' => 'Добавить или удалить платформу',
                // 'choose_from_most_used' => 'Выбрать из наиболее часто используемых платформ',
                'menu_name' => 'Film genre'
            ),
            'public' => true,
            /* каждый может использовать таксономию, либо
            только администраторы, по умолчанию - true */
            'show_in_nav_menus' => true,
            /* добавить на страницу создания меню */
            'show_ui' => true,
            /* добавить интерфейс создания и редактирования */
            'show_tagcloud' => true,
            /* нужно ли разрешить облако тегов для этой таксономии */
            'update_count_callback' => '_update_post_term_count',
            /* callback-функция для обновления счетчика $object_type */
            'query_var' => true,
            /* разрешено ли использование query_var, также можно
            указать строку, которая будет использоваться в качестве
            него, по умолчанию - имя таксономии */
            'rewrite' => array(
                /* настройки URL пермалинков */
                //'slug' => 'platform', // ярлык
                'hierarchical' => false // разрешить вложенность

            ),
        )
    );
}

add_action('init', 'wp_course_register_taxonomies', 0);

function do_excerpt($string, $word_limit)
{
    $words = explode(' ', $string, ($word_limit + 1));
    if (count($words) > $word_limit)
        array_pop($words);
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

function slider_func(array $atts)
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
            <div class="services__item">
                <?php the_title('<h3 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h3>'); ?>
                <div class="services__text">
                    <?php do_excerpt(get_the_excerpt(), 20); ?>
                </div><!-- .services__text -->
                <div class="custom-meta-box">
                    <h5>Popularity of this type: <?= ucfirst(get_post_meta(get_the_ID(), 'popularity', true)) ?></h5>
                    <h5>Difficult of this
                        type: <?= ucfirst(get_post_meta(get_the_ID(), 'difficulty_type', true)) ?></h5>
                </div>
            </div><!-- .services__item -->
            <?php
            wp_reset_postdata();
        endforeach;
        ?>
    </div>
    </section><?php
}

add_shortcode('slider', 'slider_func');

//add_filter ('get_archives_link',
//    function ($link_html, $url, $text, $format) {
//        switch ($format){
//            case 'swim':
//                var_dump($link_html);
//                var_dump($text);
//                var_dump($format);
//                $link_html = "<li><a href='$url'>"
//                    . "<span class='plus'>+</span> Trip $text"
//                    . '</a></li>';
//                break;
//            default:
//                echo "ERROR";
//                break;
//        }
//        return $link_html;
//    }, 10, 6);

/*
// добавляет новую крон задачу

add_action( 'admin_head', 'film_cron' );
function film_cron() {
  if( ! wp_next_scheduled( 'hourly_event' ) ) {
    wp_schedule_event( time(), 'hourly', 'hourly_event');
  }
}

// добавляем функцию к указанному хуку
add_action( 'hourly_event', 'save_bd' );
function save_bd(){

  $url = "http://ec2-18-219-233-220.us-east-2.compute.amazonaws.com/wpr/wp-json/mw/v1/movies?page=1";
  // Создаём запрос
  $ch = curl_init();

  // Настройка запроса
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_URL, $url);

  // Отправляем запрос и получаем ответ
  $data = json_decode(curl_exec($ch));

  // Закрываем запрос
  curl_close($ch);
  //var_dump($data);
  $data = (array) $data;
  //var_dump($data['result'][0]);
  foreach ($data['result'][2] as $key=>$item){
  //var_dump($key);
  //var_dump($item);

  switch ($key){
      case 'title':
        $title = $item;
        break;
      case 'original_title':
        $original_title = $item;
        break;
      case 'poster_path':
        $poster_path = $item;
        break;
      case 'overview':
        $overview = $item;
        break;
      case 'genres':
        $genre= $item;
        break;
      case 'release_date':
        $release_date= $item;
        break;
      case 'budget':
        $budget = $item;
        break;
      case 'revenue':
        $revenue= $item;
        break;
      case 'runtime':
        $runtime = $item;
        break;
      case 'production_countries':
        $countries= $item;
        break;
      case 'original_id':
        $original_id = $item;
        break;
      default:
        echo 'Error'.$key;
        break;
    }
  }

  $post_arr = [
    'post_title'   => $title,
    'post_content' => '<img src="' . $poster_path . '" alt="' . $original_title . '">' . '<p>' . $overview . '</p>',
    'post_name'    => $original_title,
    'post_status'  => 'publish',
    'post_type'    => 'film',
    'meta_input'   => [
      'title'         => $title,
      'orig_title'    => $original_title,
      'poster_path'   => $poster_path,
      'overview'      => $overview,
      'genre'         => $genre,
      'release'       => $release_date,
      'budget'        => $budget,
      'revenue'       => $revenue,
      'runtime'       => $runtime,
      'country'       => $countries,
      'original_id'   => $original_id
    ],
  ];
  //var_dump($post_arr);
  wp_insert_post($post_arr, true);
  //wp_set_object_terms(98, "comedy", "film_genre", FALSE);
}
*/
