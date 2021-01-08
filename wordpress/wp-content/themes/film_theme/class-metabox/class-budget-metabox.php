<?php

namespace Metabox;

require_once(DIR_PATH . '/core/class-base-meta-box.php');
use Core\Base_Meta;

class Budget_Metabox extends Base_Meta
{
  private $key='budget';

  public function render($post)
  {
    // TODO: Implement render() method.
    $budget = get_post_meta($post->ID, 'budget', true);

    ?>
    <label for="budget"><?php _e('budget') ?></label>
    <input type="text" name="budget" id="budget" value="<?= ucfirst($budget); ?>" disabled>
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