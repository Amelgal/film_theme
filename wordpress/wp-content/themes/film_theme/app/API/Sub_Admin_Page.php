<?php


namespace Cactus\API;


class Sub_Admin_Page {

  public function __construct() {

    add_action('admin_menu', [$this, 'init']);
    add_action('admin_post_new_film_hook', [$this,'new_film_action_hook_function']);

  }

  public function init() {
    add_submenu_page(
      'edit.php?post_type=film',
      'API request',
      'Add new film',
      'manage_categories',
      'api-request',
      [$this,'render']
    );
  }

  public function render() {

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

  public function new_film_action_hook_function() {

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

}