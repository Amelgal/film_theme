<?php get_header(); ?>

    <main id="primary" class="site-main film">
        <div class="container">
            <div class="row">
                <?php if (have_posts()) : ?>

                <!--- Для чего этот блок!!! ????--->
                    <header class="page-header">
                        <?php
                        //the_archive_title('<h1 class="page-title">', '</h1>');
                         the_archive_description('<div class="archive-description">', '</div>');
                        ?>
                    </header><!-- .page-header -->

                <!--- Для чего этот блок!!! ????--->

                    <?php
                    /* Start the Loop */
                    while (have_posts()) :
                        the_post();

                    ?>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                        <article>
                            <?php
                            //get_template_part('template-parts/content', get_post_type());
                            //the_meta();
                            the_excerpt() ?>
                            <h2><a href="<?php echo the_permalink();?>"><?php the_title(); ?></a></h2>
                        </article>
                    </div>


                    <?php
                        endwhile;

                        the_posts_navigation();

                        else :

                            get_template_part('template-parts/content', 'none');

                        endif;
                    ?>


            </div>
        </div>

    </main><!-- #main -->

<?php
get_footer();