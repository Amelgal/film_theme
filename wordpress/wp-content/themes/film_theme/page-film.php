<?php
get_header(); ?>

    <main id="primary" class="site-main">
      <?php
      while (have_posts()) :
        the_post();
        ?>
          <div class="container-title"><h1><?php the_title(); ?></h1></div>
        <?php
        if (comments_open() || get_comments_number()) :
          comments_template();
        endif;
      endwhile;
      ?>
        <div class="container">
            <div class="row">
              <?php
              while (have_posts()) :
              the_post();
              ?>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 m-5">
                    <div><?php the_content() ?></div>
                    <div><?php the_meta(); ?></div>
                    <div><?php
                      $id_post = get_the_ID();
                      echo $id_post;
                      echo get_post_meta($id_post, 'budget', 1);
                      ?></div>
                </div>
            </div>
          <?php
          if (comments_open() || get_comments_number()) :
            comments_template();
          endif;
          endwhile;
          ?>
        </div>
    </main>

<?php
get_footer();