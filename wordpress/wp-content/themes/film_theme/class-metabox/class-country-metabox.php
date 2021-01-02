<?php

namespace Metabox;

require_once(DIR_PATH . '/core/class-base-meta-box.php');
use Core\Base_Meta;

class Country_Metabox extends Base_Meta
{
  private $key='country';

  public function render($post)
  {
    // TODO: Implement render() method.
    $country = get_post_meta($post->ID, 'country', true);

    ?>
    <p>
      <label for="country-select"><?php _e('Select country of type') ?></label>
      <select name="country" id="country-select">
        <option value="high">       <?php _e('High') ?>     </option>
        <option value="average">    <?php _e('Average') ?>  </option>
        <option value="low">        <?php _e('Low') ?>      </option>
      </select>
    </p>
    <hr>
    <label for="country"><?php _e('country') ?></label>
    <input type="text" name="country" id="country" value="<?= ucfirst($country); ?>" disabled>
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