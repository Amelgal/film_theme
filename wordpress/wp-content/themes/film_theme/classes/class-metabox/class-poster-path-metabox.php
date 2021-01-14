<?php

namespace Metabox;

use Core\Base_Meta;

class Poster_Metabox extends Base_Meta {

  public function render($post) {
    // TODO: Implement render() method.
    $budget = get_post_meta($post->ID, $this->key, TRUE);

    ?>
      <label for="<?= _e($this->key) ?>"><?= _e($this->key) ?></label>
      <input type="text" name="<?= _e($this->key) ?>" id="<?= _e($this->key) ?>"
             value="<?= ucfirst($budget); ?>" disabled>
    <?php
  }

  public function save($postID) {
    // TODO: Implement save() method.
    if (array_key_exists($this->key, $_POST)) {
      update_post_meta(
        $postID,
        $this->key,
        $_POST[$this->key]
      );
    }
  }

}