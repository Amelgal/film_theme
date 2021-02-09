<?php


namespace Cactus\API;


class Admin_Menu {

  public function __construct() {
    add_action('admin_menu', [$this,'init']);
    add_action('admin_post_api_key_hook', [$this,'api_key_action_hook_function']);
  }
  public function init() {
    add_menu_page('API', 'API config', 8, __FILE__, [$this,'render']);
  }

  public function render() {

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

  public function api_key_action_hook_function() {

    update_option('api_options', $_POST['api_options_content']);
    update_option('answer', $_POST['activation']);

    header("Location: http://" . $_SERVER['HTTP_HOST'] . $_POST['path']);
  }
}