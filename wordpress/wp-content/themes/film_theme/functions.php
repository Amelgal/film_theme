<?php
define('DIR_PATH', plugin_dir_path(__FILE__));
define('PREFIX', 'wp_');

use Cactus\Metabox\Genre_Metabox;
use Cactus\Metabox\Poster_Metabox;
use Cactus\Metabox\Budget_Metabox;
use Cactus\Metabox\Original_Title_Metabox;
use Cactus\Metabox\Country_Metabox;
use Cactus\Metabox\Release_Metabox;
use Cactus\Metabox\Revenue_Metabox;
use Cactus\Metabox\Runtime_Metabox;
use Cactus\Metabox\Overview_Metabox;

require_once 'vendor/autoload.php';

require_once(DIR_PATH . 'app/Core/Base_Meta.php');

require_once(DIR_PATH . 'app/Metabox/Poster_Metabox.php');
require_once(DIR_PATH . 'app/Metabox/Budget_Metabox.php');
require_once(DIR_PATH . 'app/Metabox/Country_Metabox.php');
require_once(DIR_PATH . 'app/Metabox/Original_Title_Metabox.php');
require_once(DIR_PATH . 'app/Metabox/Release_Metabox.php');
require_once(DIR_PATH . 'app/Metabox/Revenue_Metabox.php');
require_once(DIR_PATH . 'app/Metabox/Runtime_Metabox.php');
require_once(DIR_PATH . 'app/Metabox/Overview_Metabox.php');
require_once(DIR_PATH . 'app/Metabox/Genre_Metabox.php');

\Cactus\Bootstrap\Bootstrap::load([
  'Cactus\API\Admin_Menu',
  'Cactus\API\Sub_Admin_Page',
  'Cactus\Cron\Upload_Db',
  'Cactus\Theme\Theme',
  'Cactus\Film\Film',
]);

if (!defined('_S_VERSION')) {
  define('_S_VERSION', '1.0.0');
}

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
                      <a href="<?=get_permalink()?>"><?php the_title(); ?></a>
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
