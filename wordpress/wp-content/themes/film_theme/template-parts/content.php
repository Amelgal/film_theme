<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
                film_theme_posted_on();
                film_theme_posted_by();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php film_theme_post_thumbnail(); ?>

	<div class="entry-content">
        <?php
        the_taxonomies();
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'film_theme' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'film_theme' ),
				'after'  => '</div>',
			)
		);

		?>
        <div class="custom-meta-box">
            <h4>Popularity of this type: <?= ucfirst(get_post_meta(get_the_ID(), 'popularity', true))?></h4>
            <h4>Difficult of this type: <?= ucfirst(get_post_meta(get_the_ID(), 'difficulty_type', true))?></h4>
        </div>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php film_theme_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
