<?php

namespace Metabox;

require_once(DIR_PATH . '/core/class-base-meta-box.php');
use Core\Base_Meta;

class Release_Metabox extends Base_Meta
{
  private $key='release';

  public function render($post)
  {
    // TODO: Implement render() method.
    $release = get_post_meta($post->ID, 'release', true);

    ?>
    <label for="release"><?php _e('release') ?></label>
    <input type="text" name="release" id="release" value="<?= ucfirst($release); ?>" disabled>
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