<?php

namespace Metabox;

require_once(DIR_PATH . '/core/class-base-meta-box.php');
use Core\Base_Meta;

class Genre_Metabox extends Base_Meta
{
  private $key='genre';

  public function render($post)
  {
    // TODO: Implement render() method.
    $genre = get_post_meta($post->ID, 'genre', true);

    ?>
    <p>
      <label for="genre-select"><?php _e('Select genre') ?></label>
      <select name="genre" id="genre-select">
        <option value="high">       <?php _e('High') ?>     </option>
        <option value="average">    <?php _e('Average') ?>  </option>
        <option value="low">        <?php _e('Low') ?>      </option>
      </select>
    </p>
    <hr>
    <label for="genre"><?php _e('budget') ?></label>
    <input type="text" name="genre" id="genre" value="<?= ucfirst($genre); ?>" disabled>
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