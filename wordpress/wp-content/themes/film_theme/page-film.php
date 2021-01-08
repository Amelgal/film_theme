<?php

/*
Template Name: Template Film
Template Post Type: film
*/

get_header(); ?>

    <main id="primary" class="site-main">
        <?php
            while (have_posts()) :
                the_post();

        ?>
                <div class="container-title"><h1><?php the_title(); ?></h1></div>
        <?php

            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;

        endwhile; // End of the loop.
        ?>
        <div class="container">
            <div class="row">
                <?php
                while (have_posts()) :
                    the_post();

                    //get_template_part('template-parts/content', 'page');
                ?>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 m-5">
                    <div><?php the_content() ?></div>
                    <div><?php the_meta(); ?></div>
                    <div><?php
                        $id_post = get_the_ID();
                        echo $id_post;
                       echo get_post_meta( $id_post, 'budget', 1 );
                        ?></div>
                </div>
            </div>

            <?php

                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;

            endwhile; // End of the loop.
            ?>
        </div>
    </main><!-- #main -->

<?php
get_footer();