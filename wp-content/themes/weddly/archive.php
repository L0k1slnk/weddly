<?php get_header(); ?>

<main class="main-wrapper" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
    <div class="container">
        <?php if (has_nav_menu('primary')) : ?>
            <span class="main-nav-btn fa fa-bars js-menu-toggle"></span>
        <?php endif; ?>
        <span class="special-nav-btn fa fa-filter js-special-toggle"></span>

        <?php
        if ( function_exists('yoast_breadcrumb') ) {
            yoast_breadcrumb('<nav class="breadcrumbs">','</nav>');
        }
        ?>
        <?php if ( have_posts() ) : ?>

            <article class="post-preview post-preview--spoiler" role="article">
                <?php
                $current_term = get_queried_object()->term_id;
                the_archive_title( '<h1 class="article__title">', '</h1>' );
                echo get_term_thumbnail($current_term);
                echo '<section class="spoiler-body" itemscope itemtype="http://schema.org/ImageGallery">';
                echo get_the_archive_description();
                echo '</section>';
                ?>
            </article>

            <?php
            // Start the Loop.
            while ( have_posts() ) : the_post();

                /*
                 * Include the Post-Format-specific template for the content.
                 * If you want to override this in a child theme, then include a file
                 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                 */
                get_template_part( 'content', get_post_format() );

                // End the loop.
            endwhile;

            // Previous/next page navigation.
            the_posts_pagination( array(
                'prev_text'          => __( 'Previous page', 'twentyfifteen' ),
                'next_text'          => __( 'Next page', 'twentyfifteen' ),
                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>',
            ) );
            ?>
            <?php

        // If no content, include the "No posts found" template.
        else :
            get_template_part( 'content', 'none' );

        endif;
        ?>
            </div>
    </main>
<?php get_sidebar(); ?>

<?php get_footer(); ?>
