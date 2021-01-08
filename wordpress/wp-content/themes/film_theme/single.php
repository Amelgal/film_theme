<?php get_header(); ?>

<main id="primary" class="site-main">
    <?php
    while (have_posts()) :
        the_post();

        ?>
        <div class="container-title">
            <?php $id_post = get_the_ID(); ?>
            <div class="cover-img ">
                <img src="<?php echo get_post_meta( $id_post, 'poster_path', 1 ); ?>" alt="">
            </div>
            <div class="">
                <h1><?php the_title(); ?></h1>
            </div>
        </div>
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
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8"><?php the_content() ?></div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <?php $id_post = get_the_ID(); ?>
                        <div>Оригинальное название: <?php echo get_post_meta( $id_post, 'orig_title', 1 ); ?></div>
                        <div>Жанр: <?php echo get_post_meta( $id_post, 'genre', 1 ); ?></div>
                        <div>Дата выпуска: <?php echo get_post_meta( $id_post, 'release', 1 ); ?></div>
                        <div>Бюджет: <?php echo get_post_meta( $id_post, 'budget', 1 ); ?></div>
                        <div>Доход:<?php echo get_post_meta( $id_post, 'revenue', 1 ); ?></div>
                        <div>Длительность: <?php  echo get_post_meta( $id_post, 'runtime', 1 ); ?></div>
                        <div>Страна: <?php echo get_post_meta( $id_post, 'country', 1 ); ?></div>
                        <div>Original ID<?php echo get_post_meta( $id_post, 'original_id', 1 ); ?></div>
                    </div>
                </div>
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
