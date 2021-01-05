<div class="clean"></div>
<hr>

<footer id="colophon" class="site-footer">
    <div class="site-info">
        <a href="<?php echo esc_url(__('https://wordpress.org/', 'film_theme')); ?>">
            <?php
            /* translators: %s: CMS name, i.e. WordPress. */
            printf(esc_html__('Proudly powered by %s', 'film_theme'), 'WordPress');
            ?>
        </a>
        <span class="sep"> | </span>
        <?php
        /* translators: 1: Theme name, 2: Theme author. */
        printf(esc_html__('Theme: %1$s by %2$s.', 'film_theme'), 'Film_theme', 'Eugene Shalko');
        ?>
    </div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
