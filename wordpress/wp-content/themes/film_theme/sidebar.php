<?php

use View\WheatherShortcode;

?>
<div class="sidebar">
    <h2><?php _e('Categories'); ?></h2>
    <ul>
        <?php wp_list_categories('taxonomy=film_genre&title_li='); ?>
    </ul>
    <h2><?php _e('Archives'); ?></h2>
    <ul>
        <?php wp_get_archives('post_type=swim&type=yearly');

        ?>
    </ul>
</div>
