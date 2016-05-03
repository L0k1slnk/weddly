
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
    // Post thumbnail.
//    twentyfifteen_post_thumbnail();
    ?>

    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    </header><!-- .entry-header -->

    <?php if ( is_single() || is_front_page()) : ?>
    <section class="article__content js-gallery">
        <?php
        /* translators: %s: Name of current post */
        the_content();
        ?>
    </section><!-- .article__content -->
    <?php

    endif;
    ?>



</article><!-- #post-## -->
