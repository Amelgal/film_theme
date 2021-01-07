<?php

namespace Metabox;

require_once(DIR_PATH . '/core/class-base-meta-box.php');
use Core\Base_Meta;

class Poster_Metabox extends Base_Meta
{
    private $key='poster_path';

  public function render($post)
  {
    // TODO: Implement render() method.
    $poster_path = get_post_meta($post->ID, 'poster_path', true);

    ?>
    <label for="poster_path"><?php _e('poster_path') ?></label>
    <input type="text" name="poster_path" id="poster_path" value="<?= ucfirst($poster_path); ?>" disabled>
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