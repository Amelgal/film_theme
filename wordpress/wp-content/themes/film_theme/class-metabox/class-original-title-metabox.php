<?php

namespace Metabox;

require_once(DIR_PATH . '/core/class-base-meta-box.php');
use Core\Base_Meta;

class Original_Title_Metabox extends Base_Meta
{
  private $key='orig_title';

  public function render($post)
  {
    // TODO: Implement render() method.
    $orig_title = get_post_meta($post->ID, 'orig_title', true);

    ?>
    <p>
      <label for="orig_title-select"><?php _e('Select orig_title of type') ?></label>
      <select name="orig_title" id="orig_title-select">
        <option value="high">       <?php _e('High') ?>     </option>
        <option value="average">    <?php _e('Average') ?>  </option>
        <option value="low">        <?php _e('Low') ?>      </option>
      </select>
    </p>
    <hr>
    <label for="orig_title"><?php _e('orig_title') ?></label>
    <input type="text" name="orig_title" id="orig_title" value="<?= ucfirst($orig_title); ?>" disabled>
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