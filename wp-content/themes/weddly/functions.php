<?php

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
    if (!is_admin()) {
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
