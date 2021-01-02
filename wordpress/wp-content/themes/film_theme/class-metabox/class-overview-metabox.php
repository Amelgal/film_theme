<?php

namespace Metabox;

require_once(DIR_PATH . '/core/class-base-meta-box.php');
use Core\Base_Meta;

class Overview_Metabox extends Base_Meta
{
  private $key='overview';

  public function render($post)
  {
    // TODO: Implement render() method.
    $overview = get_post_meta($post->ID, 'overview', true);

    ?>
    <p>
      <label for="overview-select"><?php _e('Select overview of type') ?></label>
      <select name="overview" id="overview-select">
        <option value="high">       <?php _e('High') ?>     </option>
        <option value="average">    <?php _e('Average') ?>  </option>
        <option value="low">        <?php _e('Low') ?>      </option>
      </select>
    </p>
    <hr>
    <label for="overview"><?php _e('overview') ?></label>
    <input type="text" name="overview" id="overview" value="<?= ucfirst($overview); ?>" disabled>
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