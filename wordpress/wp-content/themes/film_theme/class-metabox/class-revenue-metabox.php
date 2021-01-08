<?php

namespace Metabox;

require_once(DIR_PATH . '/core/class-base-meta-box.php');
use Core\Base_Meta;

class Revenue_Metabox extends Base_Meta
{
  private $key='revenue';

  public function render($post)
  {
    // TODO: Implement render() method.
    $revenue = get_post_meta($post->ID, 'revenue', true);

    ?>
    <label for="revenue"><?php _e('revenue') ?></label>
    <input type="text" name="revenue" id="revenue" value="<?= ucfirst($revenue); ?>" disabled>
    <?php
  }

  public function save($postID)
  {
    // TODO: Implement save() method.
    if ( array_key_exists( $this->key, $_POST ) ) {
      update_post_meta(
        $postID,
        $this->key,
        $_POST[$this->key]
      );
    }
  }

}