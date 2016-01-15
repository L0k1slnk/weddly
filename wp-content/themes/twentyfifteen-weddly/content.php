<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>
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

			$postClass = array();

		}
		else{
			$postClass = array('post-preview');
		}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($postClass); ?>>
	<?php
		// Post thumbnail.

		if ( !is_single() ) { 

			twentyfifteen_post_thumbnail();

		}
	?>

	<header class="entry-header <?php if ( !is_single() ) : ?> js-boxLink <?php endif; ?>">
		<?php
			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			endif;
		?>
	</header><!-- .entry-header -->
	<?php
			if ( is_single() ) : ?>
	<div class="entry-content">
	<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading %s', 'twentyfifteen' ),
				the_title( '<span class="screen-reader-text">', '</span>', false )
			) );	
?>
			<?php
			if ( is_single() ) : ?>
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.3";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>
				<script type="text/javascript" src="//vk.com/js/api/openapi.js?116"></script>
				<script type="text/javascript">
				  VK.init({apiId: 4893362, onlyWidgets: true});
				</script>
				<div class="fb-like" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
				<div id="vk_like" style="display: inline-block; vertical-align: bottom;"></div>
				<script type="text/javascript">
				VK.Widgets.Like("vk_like", {type: "mini"});
				</script>
				<!-- Вставьте этот тег в заголовке страницы или непосредственно перед закрывающим тегом основной части. -->
				<script src="https://apis.google.com/js/platform.js" async defer>
				  {lang: 'ru'}
				</script>

				<!-- Поместите этот тег туда, где должна отображаться кнопка "Поделиться". -->
				<div class="g-plus" data-action="share" data-annotation="bubble"></div>
				<style>
						.twitter-share-button{
							vertical-align: bottom;
							display: inline-block;
							margin: 0;
						}
				</style>
				<a href="https://twitter.com/share" class="twitter-share-button" data-via="_L0k1" style="">Tweet</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
				<?php
			
			endif;
		?>
			</div><!-- .entry-content -->
<?php
			
			endif;
		?>


	<?php
		// Author bio.
		if ( is_single() && get_the_author_meta( 'description' ) ) :
			get_template_part( 'author-bio' );
		endif;
	?>

	<footer class="entry-footer">
		<?php twentyfifteen_entry_meta(); ?>
		<?php edit_post_link( __( 'Edit', 'twentyfifteen' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
