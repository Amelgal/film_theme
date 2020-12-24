<?php

namespace Metabox;

require_once(DIR_PATH . '/core/class-base-meta-box.php');
use Core\Base_Meta;

class Popularity_Metabox extends Base_Meta
{
    private $key='popularity';

  public function render($post)
  {
    // TODO: Implement render() method.
    $popular = get_post_meta($post->ID, 'popularity', true);

    ?>
    <p>
      <label for="popularity-select"><?php _e('Select popularity of type') ?></label>
      <select name="popularity" id="popularity-select">
        <option value="high">       <?php _e('High') ?>     </option>
        <option value="average">    <?php _e('Average') ?>  </option>
        <option value="low">        <?php _e('Low') ?>      </option>
      </select>
    </p>
    <hr>
    <label for="popularity"><?php _e('Popularity') ?></label>
    <input type="text" name="popularity" id="popularity" value="<?= ucfirst($popular); ?>" disabled>
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