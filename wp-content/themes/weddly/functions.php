<?php


add_action( 'after_setup_theme', function(){
    /*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ) );

    /*
     * Enable support for Post Formats.
     *
     * See: https://codex.wordpress.org/Post_Formats
     */
    add_theme_support( 'post-formats', array(
        'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
    ) );

});

if (!is_admin()) {
    // добавляем стили
    wp_register_style('weddly', get_template_directory_uri() . '/Dist/styles/style.css');
    wp_enqueue_style('weddly');

    // добавляем скрипты в шляпу
    wp_register_script('fouc', get_template_directory_uri() . '/Dist/scripts/fouc.js');
    wp_enqueue_script('fouc');

    // добавляем скрипты в футер
    //TODO: заменить на min в релизе
    wp_register_script('main', get_template_directory_uri() . '/Dist/scripts/main.js', array(), false, true);
    wp_enqueue_script('main');
}


// разрешаем описание рубрикам в HTML
remove_filter('pre_term_description', 'wp_filter_kses');

// обрезаем описание в рубрике
add_action('admin_head-edit-tags.php', function () {
    add_filter('get_terms', function ($terms, $taxonomies) {
        if ('category' == $taxonomies[0]) {
            foreach ($terms as $key => $term) {
                $terms[$key]->description = wp_trim_words($term->description, 12, ' [...]');
            }
        }
        return $terms;
    }, 10, 2);
});

// удаляем лишние RSS
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);


// удаляем дефолтное говно

function remove_default_scripts(&$scripts)
{
    if (!is_admin() && !is_user_logged_in()) {
        $scripts->remove('jquery');
        $scripts->remove('jquery-core');
        $scripts->remove('jquery-migrate');
    }
}

add_filter('wp_default_scripts', 'remove_default_scripts');

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');


// wp_nav_menu() - регистрируем меню
register_nav_menus(array(
    'primary' => __('Primary Menu', 'weddly'),
));

// удаляем инлайновые width & height у картинок
//add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
//add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );
//add_filter( 'the_content', 'remove_width_attribute', 10 );

function remove_width_attribute( $html ) {
    $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
    return $html;
}



//img_caption_shortcode
//wp_caption
//caption



function figure_layout( $empty, $attr, $content ){
    if(is_single()){
        $attr = shortcode_atts( array(
            'id'      => '',
            'align'   => 'alignnone',
            'width'   => '',
            'caption' => ''
        ), $attr );

        if ( 1 > (int) $attr['width'] || empty( $attr['caption'] ) ) {
            return '';
        }

        if ( $attr['id'] ) {
            $attr['id'] = 'id="' . esc_attr( $attr['id'] ) . '" ';
        }
        preg_match('/height=.(\d*)/', $content, $h);
        preg_match('/width=.(\d*)/', $content, $w);
        preg_match( '/src="([^"]*)"/i', $content, $s ) ;
        preg_match( '/alt="([^"]*)"/i', $content, $a ) ;
//    $content = preg_replace( '/(width|height)=\"\d*\"\s/', "", $content );

        return '<figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject" ' . $attr['id'] .'class="gallery__item"><a href="'.$s[1].'" itemprop="contentUrl" data-size="'.$w[1].'x'.$h[1].'" data-width="'.$w[1].'" data-height="'.$h[1].'" class="gallery__item__link">'
        . '<img src="'.$s[1].'" alt="'.$a[1].'" class="gallery__item__img">'
        . '</a><figcaption class="gallery__image__caption">' . $attr['caption'] . '</figcaption>'
        . '</figure>';
    }

}


function changeImageOnFigure( $content )
{
    if(is_single()){
        $content = preg_replace(
            '/<p>\s*?<a.*?>\s*?<img.+?(src="([^"]*)".*?)(alt="([^"]*)".*?)(width="([^"]*)".*?)(height="([^"]*)".*?)>\s*?<\/a>\s*?<\/p>/s',
            '<figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject" class="gallery__item"><a href="$2" itemprop="contentUrl" data-size="$6x$8" data-width="$6" data-height="$8" class="gallery__item__link"><img src="$2" alt="$4" class="gallery__item__img"></a></figure>',
            $content
        );
        $content = preg_replace(
            '/<p>\s*?<img.+?(src="([^"]*)".*?)(alt="([^"]*)".*?)(width="([^"]*)".*?)(height="([^"]*)".*?)>\s*?<\/p>/s',
            '<figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject" class="gallery__item"><a href="$2" itemprop="contentUrl" data-size="$6x$8" data-width="$6" data-height="$8" class="gallery__item__link"><img src="$2" alt="$4" class="gallery__item__img"></a></figure>',
            $content
        );
        return $content;
    }

}



    add_filter( 'img_caption_shortcode', 'figure_layout', 10, 3 );
    add_filter( 'the_content', 'changeImageOnFigure', 99 );

