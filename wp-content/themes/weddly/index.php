<?php get_header(); ?>

    <main class="main-wrapper" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'article' ); ?> role="article">
                <header class="article__header">
                    <h1 class="article__title">
                        <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                    </h1>
                </header>

                <section class="article__content">
                    <?php the_content(); ?>
                </section>

                <footer class="article__footer">
                    <p class="footer-comment-count">
                        <?php comments_number( __( '<span>No</span> Comments', 'bonestheme' ), __( '<span>One</span> Comment', 'bonestheme' ), __( '<span>%</span> Comments', 'bonestheme' ) );?>
                    </p>


                    <?php printf( '<p class="footer-category">' . __('filed under', 'bonestheme' ) . ': %1$s</p>' , get_the_category_list(', ') ); ?>

                    <?php the_tags( '<p class="footer-tags tags"><span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '</p>' ); ?>


                </footer>
            </article>

        <?php endwhile; ?>

        <?php else : ?>

            <article id="post-not-found" class="hentry cf">
                <header class="article-header">
                    <h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
                </header>
                <section class="entry-content">
                    <p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
                </section>
                <footer class="article-footer">
                    <p><?php _e( 'This is the error message in the index.php template.', 'bonestheme' ); ?></p>
                </footer>
            </article>

        <?php endif; ?>
    </main>
    <?php get_sidebar(); ?>

<?php get_footer(); ?>
