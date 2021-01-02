<?php

namespace Metabox;

require_once(DIR_PATH . '/core/class-base-meta-box.php');
use Core\Base_Meta;

class Runtime_Metabox extends Base_Meta
{
  private $key='runtime';

  public function render($post)
  {
    // TODO: Implement render() method.
    $runtime = get_post_meta($post->ID, 'runtime', true);

    ?>
    <p>
      <label for="runtime-select"><?php _e('Select runtime of type') ?></label>
      <select name="runtime" id="runtime-select">
        <option value="high">       <?php _e('High') ?>     </option>
        <option value="average">    <?php _e('Average') ?>  </option>
        <option value="low">        <?php _e('Low') ?>      </option>
      </select>
    </p>
    <hr>
    <label for="runtime"><?php _e('revenue') ?></label>
    <input type="text" name="runtime" id="runtime" value="<?= ucfirst($runtime); ?>" disabled>
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