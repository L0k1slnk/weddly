<?php
	/*
		разрешаем описание рубрикам в HTML
	*/
	remove_filter('pre_term_description', 'wp_filter_kses');
	/*
	  обрезаем описание в рубрике, а то уж больно дофиша места жрет
	*/

	add_action('admin_head-edit-tags.php', 'admin_edit_tags');
	function admin_edit_tags(){
		add_filter('get_terms', 'admin_trim_cat_desc', 10, 2);
	}
	function admin_trim_cat_desc($terms, $taxonomies){
		 if( 'category' == $taxonomies[ 0 ] ) {
        foreach( $terms as $key => $term ) {
          $terms[ $key ]->description = wp_trim_words($term->description, 12, ' [...]');
        }
    }
    return $terms;
	}


	/*
		выполняем после всей инициализации функций родительского function.php
	*/
	function remove_childtheme_filters(){
		/*
			убираем описание рубрики из меню
		*/
		remove_filter( 'walker_nav_menu_start_el', 'twentyfifteen_nav_description', 10, 4 );
		/*
			удаляем лишние RSS
		*/
		remove_action( 'wp_head', 'feed_links_extra', 3 );
		remove_action( 'wp_head', 'feed_links', 2 );

		/*
			перемещаем скрипты в футер
		*/
		function add_async($url){
			if(strpos($url, '#defer') === false){
				return $url;
			}
			elseif (is_admin()) {
				return str_replace('#defer', '', $url);
			}
			else{
				return str_replace('#defer', '', $url)."' defer='defer";
			}

		}
		add_filter('clean_url', 'add_async', 11, 1);
		function custom_clean_head() {
			remove_action('wp_head', 'wp_print_scripts');
			remove_action('wp_head', 'wp_print_head_scripts', 9);
			remove_action('wp_head', 'wp_enqueue_scripts', 1);
		}
		add_action( 'wp_enqueue_scripts', 'custom_clean_head' );

		/*
			удаляем гуглошрифты
		*/


		function svadbal_dequeue_styles() {
		  wp_dequeue_style( 'twentyfifteen-fonts' );
		  wp_dequeue_style( 'genericons' );
		}
		add_action( 'wp_enqueue_scripts', 'svadbal_dequeue_styles', 20 );

		add_action('wp_footer', 'add_googleanalytics');

		function add_googleanalytics() {
			?>
				<script>
				  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

				  ga('create', 'UA-61311969-1', 'auto');
				  ga('send', 'pageview');

				</script>
			<?php
		}

	}
	add_action('after_setup_theme', 'remove_childtheme_filters');



	/*
		добавляем lazy load для картинок
	*/
	function filter_lazyload($content) {
	    return preg_replace_callback('/(<\s*img[^>]+)(src\s*=\s*"[^"]+")([^>]+>)/i', 'preg_lazyload', $content);
	}
	add_filter('the_content', 'filter_lazyload');
	add_filter('get_the_archive_description', 'filter_lazyload');
	add_filter('post_thumbnail_html', 'filter_lazyload');

	function preg_lazyload($img_match) {
	 
	    $img_replace = $img_match[1] . 'src="' . get_stylesheet_directory_uri() . '/imgs/pixel.gif" data-original' . substr($img_match[2], 3) . $img_match[3];
	 
	    $img_replace = preg_replace('/class\s*=\s*"/i', 'class="lazyload ', $img_replace);
	 
	    // $img_replace .= '<noscript>' . $img_match[0] . '</noscript>';

	    return $img_replace;
	}

	function svadbal_scripts(){
		wp_register_script('lazyload', get_stylesheet_directory_uri() . '/js/jquery.lazyload.min.js', array('jquery'), false, true);
		wp_enqueue_script( 'lazyload' );
		wp_enqueue_script('svadbal', get_stylesheet_directory_uri() . '/js/svadbal.js#defer', array('jquery','lazyload'), false, true);
	}
	add_action('wp_enqueue_scripts', 'svadbal_scripts');


// удаляем колонку с комментами (posts)

function my_manage_columns( $columns ) {
  unset($columns['comments']);
  return $columns;
}

function my_column_init() {
  add_filter( 'manage_posts_columns' , 'my_manage_columns' );
}
add_action( 'admin_init' , 'my_column_init' );







	/*
	  Убираем лишнее из футера поста (автора)
	*/

	if ( ! function_exists( 'twentyfifteen_entry_meta' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags.
	 *
	 * @since Twenty Fifteen 1.0
	 */
	function twentyfifteen_entry_meta() {
		if ( is_sticky() && is_home() && ! is_paged() ) {
			printf( '<span class="sticky-post">%s</span>', __( 'Featured', 'twentyfifteen' ) );
		}

		$format = get_post_format();
		if ( current_theme_supports( 'post-formats', $format ) ) {
			printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
				sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'twentyfifteen' ) ),
				esc_url( get_post_format_link( $format ) ),
				get_post_format_string( $format )
			);
		}

		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
			}

			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				get_the_date(),
				esc_attr( get_the_modified_date( 'c' ) ),
				get_the_modified_date()
			);

			printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
				_x( 'Posted on', 'Used before publish date.', 'twentyfifteen' ),
				esc_url( get_permalink() ),
				$time_string
			);
		}

		if ( 'post' == get_post_type() ) {

			$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'twentyfifteen' ) );
			if ( $categories_list && twentyfifteen_categorized_blog() ) {
				printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
					_x( 'Categories', 'Used before category names.', 'twentyfifteen' ),
					$categories_list
				);
			}

			$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'twentyfifteen' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
					_x( 'Tags', 'Used before tag names.', 'twentyfifteen' ),
					$tags_list
				);
			}
		}

		if ( is_attachment() && wp_attachment_is_image() ) {
			// Retrieve attachment metadata.
			$metadata = wp_get_attachment_metadata();

			printf( '<span class="full-size-link"><span class="screen-reader-text">%1$s </span><a href="%2$s">%3$s &times; %4$s</a></span>',
				_x( 'Full size', 'Used before full size attachment link.', 'twentyfifteen' ),
				esc_url( wp_get_attachment_url() ),
				$metadata['width'],
				$metadata['height']
			);
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( __( 'Leave a comment', 'twentyfifteen' ), __( '1 Comment', 'twentyfifteen' ), __( '% Comments', 'twentyfifteen' ) );
			echo '</span>';
		}
	}
	endif;
?>