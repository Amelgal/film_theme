<?php get_header(); ?>

    <main id="primary_page" class="site-main ">
        <div class="container">
            <div class="row">
                <div class="posts">
                    <h2>Все фильмы</h2>
                  <?php
                  do_shortcode('[all_movies numberposts = 15 post_type = film]');
                  ?>
                </div>
            </div>
        </div>
    </main>
    <div class="delimer"></div>

<?php get_footer(); ?>