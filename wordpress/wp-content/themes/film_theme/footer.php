<div class="clean"></div>
<footer id="colophon" class="site-footer">
    <div class="container">
        <div class="row">
            <div class="site-info col-12 col-sm-12	col-md-12 col-lg-6 col-xl-6 m-4">
                <a href="<?php echo esc_url(__('https://wordpress.org/', 'wp_course')); ?>">
                    <?php
                    /* translators: %s: CMS name, i.e. WordPress. */
                    printf(esc_html__('Proudly powered by %s', 'wp_course'), 'WordPress');
                    ?>
                </a>
                <span class="sep"> | </span>
                <?php
                /* translators: 1: Theme name, 2: Theme author. */
                printf(esc_html__('Theme: %1$s by %2$s.', 'wp_course'), 'Wp_course', 'Eugene Shalko');
                ?>
            </div><!-- .site-info -->
        </div>
    </div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
