<?php get_header(); ?>

<main class="main-wrapper" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
    <div class="container">
        <?php if (has_nav_menu('primary')) : ?>
            <span class="main-nav-btn fa fa-bars js-menu-toggle"></span>
        <?php endif; ?>
        <span class="special-nav-btn fa fa-filter js-special-toggle"></span>
        <?php
        if ( 'posts' == get_option( 'show_on_front' ) ) {
            $content = get_post_format();
        }
        else{
            $content = 'page';
        }
        ?>

        <?php if (have_posts()) : ?>
            <?php
            // Start the loop.
            while (have_posts()) : the_post();

                /*
                 * Include the Post-Format-specific template for the content.
                 * If you want to override this in a child theme, then include a file
                 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                 */

                get_template_part('content', $content);

                // End the loop.
            endwhile;

// Previous/next page navigation.
            the_posts_pagination(array(
                'prev_text' => __('Previous page', 'weddly'),
                'next_text' => __('Next page', 'weddly'),
                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'weddly') . ' </span>',
            ));

        // If no content, include the "No posts found" template.
        else :
            get_template_part('content', 'none');

        endif;
        ?>


    </div> <?php // .container ?>
</main>
<?php get_sidebar(); ?>

<?php get_footer(); ?>
