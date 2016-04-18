
<?php
if ( is_single() ) {
    function remove_thumbclass( $classes ) {
        $classes = array_diff( $classes, array( 'has-post-thumbnail' ) );
        return $classes;
    }
    add_filter( 'post_class','remove_thumbclass' );
    if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb('<nav class="breadcrumbs entry-footer">','</nav>');
    }

    $postClass = array('article');

}
else{
    $postClass = array('post-preview');
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($postClass); ?> <?php if ( !is_single() ) : ?> js-boxLink <?php endif; ?><?php if ( is_single() ) : ?> role="article" itemscope itemtype="http://schema.org/ImageGallery" <?php endif; ?>>
    <?php
    // Post thumbnail.

    if ( !is_single() ) {

//        twentyfifteen_post_thumbnail();

    }
    ?>
    <header class="article__header">
        <?php
        if ( is_single() ) :
            the_title( '<h1 class="article__title">', '</h1>' );
        else :
            the_title( sprintf( '<h2 class="article__title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
        endif;
        ?>
    </header>
    <?php
    if ( is_single() ) : ?>
        <section class="article__content js-gallery">
            <?php
            /* translators: %s: Name of current post */
            the_content( sprintf(
                __( 'Continue reading %s', 'weddly' ),
                the_title( '<span class="screen-reader-text">', '</span>', false )
            ) );
            ?>
        </section><!-- .article__content -->
        <?php

    endif;
    ?>

    <footer class="article__footer">
        <p class="footer-comment-count">
            <?php comments_number(__('<span>No</span> Comments', 'weddly'), __('<span>One</span> Comment', 'weddly'), __('<span>%</span> Comments', 'weddly')); ?>
        </p>


        <?php printf('<p class="footer-category">' . __('filed under', 'bonestheme') . ': %1$s</p>', get_the_category_list(', ')); ?>

        <?php the_tags('<p class="footer-tags tags"><span class="tags-title">' . __('Tags:', 'bonestheme') . '</span> ', ', ', '</p>'); ?>


    </footer>

</article><!-- #post-## -->
