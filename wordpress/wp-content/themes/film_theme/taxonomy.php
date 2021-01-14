<?php get_header(); ?>

    <main id="primary" class="site-main film">
        <div class="container">
            <div class="row">
              <?php if (have_posts()) : ?>
                <?php
                while (have_posts()) :
                  the_post();
                  ?>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                        <article>
                          <?php
                          $id_post = get_the_ID();
                          ?>
                            <img src="<?php echo get_post_meta($id_post, 'poster_path', 1); ?>"
                                 alt="">
                          <?php the_excerpt(); ?>
                            <h2>
                                <a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                        </article>
                    </div>
                <?php
                endwhile; ?>
                  <div class="navigation">
                      <div class="next-posts"><?php next_posts_link(); ?></div>
                      <div class="prev-posts"><?php previous_posts_link(); ?></div>
                  </div>
              <?php
              else :
                get_template_part('template-parts/content', 'none');
              endif;
              ?>
            </div>
        </div>
    </main>

<?php
get_footer();