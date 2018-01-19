<?php
add_filter( 'document_title_separator', function(){ return ' | '; } );

//Включаем установку логотипа из опций темы
add_action( 'after_setup_theme', 'tootkot_setuplogo' );
function tootkot_setuplogo() {
    global $width_logo;
    global $height_logo;
    add_theme_support( 'custom-logo', array(
        'width' => 250,
        'height' => 100,
        'flex-width' => true,
        'flex-height' => true,
        'header-text' => array('site-title', 'site-description')
    ));
}

//Хукаем стандартную функцию вывода логотипа и выводим только url
add_filter( 'get_custom_logo', 'filter_function_name_3292', 10, 2 );
function filter_function_name_3292( $html, $blog_id ){

    preg_match('/src="(.+?)"/', $html, $m);
    return $m[1];
}

//Регаем стили
wp_register_style('main-style', get_template_directory_uri().'/style.css', 'beta1.0');
wp_enqueue_style('main-style', get_template_directory_uri().'/style.css', 'beta1.0');

//Цепляем JQuery
wp_enqueue_script('myjquery', get_template_directory_uri() . '/js/jquery.js');
wp_enqueue_script('device');

//Цепляем определять типа устройства
wp_enqueue_script('device', get_template_directory_uri() . '/js/device.js', array('myjquery'));
wp_enqueue_script('device');

//Цепляем инициализацию
wp_enqueue_script('init', get_template_directory_uri() . '/js/init.js', array('myjquery'));
wp_enqueue_script('init');

//Цепляем обработчик
wp_enqueue_script('handler', get_template_directory_uri() . '/js/handler.js', array('init'));
wp_enqueue_script('handler');
wp_localize_script('handler', 'myajax', array(
    'url' => admin_url('admin-ajax.php'),
));

//Цепляем закрывашку прерола
wp_enqueue_script('prerol', get_template_directory_uri() . '/js/prerol.js', array('init'));
wp_enqueue_script('prerol');

//Отключение всякого дерьма
remove_action( 'wp_head',             '_wp_render_title_tag',            1     );
remove_action( 'wp_head',             'wp_resource_hints',               2     );
remove_action( 'wp_head',             'feed_links',                      2     );
remove_action( 'wp_head',             'feed_links_extra',                3     );
remove_action( 'wp_head',             'rsd_link'                               );
remove_action( 'wp_head',             'wlwmanifest_link'                       );
remove_action( 'wp_head',             'noindex',                          1    );
remove_action( 'wp_head', 'rsd_link'            );
remove_action( 'wp_head', 'wlwmanifest_link'    );
add_filter('the_generator', '__return_empty_string');
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );

//Отключаем админ-панель сверху
add_filter('show_admin_bar', '__return_false');

//Включаем поддержку меню
add_theme_support( 'menus' );

//Walker десктопного меню
class pcMenuWalker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth, $args) {

        $class_names = join( ' ', $item->classes );
        $attributes = '';
        $item_output = $args->before;
        if (isset($item->classes[4])) {
            $class_names = ' class="site-menu_items-pc items-parent_pc"';
            $attributes.= !empty( $item->url ) ? ' href="' .esc_attr($item->url). '"' : '';
            $output .= '<li'.' onclick="mobileMenu(event);"'.' id="menu-item-' . $item->ID . '"' . $class_names . '>';
        } else {
            $class_names = ' class="site-menu_items-pc"';
            $attributes.= !empty( $item->url ) ? ' href="' .esc_attr($item->url). '"' : '';
            $output .= '<li id="menu-item-' . $item->ID . '"' . $class_names . '>';
        }
        // назначаем атрибуты a-элементу


        // проверяем, на какой странице мы находимся
        $current_url = (is_ssl()?'https://':'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $item_url = esc_attr( $item->url );
        // if ( $item_url != $current_url )
        $item_output.= '<a'. $attributes .'>'.$item->title.'</a>';
        //else $item_output.= $item->title;

        // заканчиваем вывод элемента
        $item_output.= $args->after;

        $output.= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

//Walker десктопного меню
class mobiMenuWalker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth, $args) {

        $class_names = join( ' ', $item->classes );
        $attributes = '';
        $item_output = $args->before;
        if (isset($item->classes[4])) {
            $class_names = ' class="site-menu_items-mobi items-parent_mobi"';
            $attributes.= !empty( $item->url ) ? ' onclick="handler.opennerMobileMenu(this); return false;" href="' .esc_attr($item->url). '"' : '';
            $output .= '<li'.''.' id="menu-item-' . $item->ID . '"' . $class_names . '>';
        } else {
            $class_names = ' class="site-menu_items-mobi"';
            $attributes.= !empty( $item->url ) ? ' href="' .esc_attr($item->url). '"' : '';
            $output .= '<li id="menu-item-' . $item->ID . '"' . $class_names . '>';
        }
        // назначаем атрибуты a-элементу


        // проверяем, на какой странице мы находимся
        $current_url = (is_ssl()?'https://':'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $item_url = esc_attr( $item->url );
        // if ( $item_url != $current_url )
        $item_output.= '<a'. $attributes .'>'.$item->title.'</a>';
        //else $item_output.= $item->title;

        // заканчиваем вывод элемента
        $item_output.= $args->after;

        $output.= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

add_action('wp_ajax_nopriv_getMenuMobi', 'getMenuMobi');
add_action('wp_ajax_getMenuMobi', 'getMenuMobi');
function getMenuMobi(){
    $walker = new mobiMenuWalker();
    wp_nav_menu( array(
        'theme_location'  => '',
        'menu'            => '',
        'container'       => '',
        'container_class' => '',
        'container_id'    => '',
        'menu_class'      => '',
        'menu_id'         => '',
        'echo'            => true,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul class="site-menu_mobi">%3$s</ul>',
        'depth'           => 0,
        'walker'          => $walker,
        ) );
    wp_die();
}

add_action('wp_ajax_nopriv_getAuthMobi', 'getAuthMobi');
add_action('wp_ajax_getAuthMobi', 'getAuthMobi');
function getAuthMobi(){
    if( is_user_logged_in() ){
        echo '<ul class="authorized_mobi">';
        echo '<li><a href="'.get_template_directory_uri().'/myorders.php">Мои заказы</a></li>';
        echo '<li><a href="'.get_template_directory_uri().'/chat/index.php">Мой чат</a></li>';
        echo '</ul>';
    } else {
        echo '<form class="auth-mobi clearfix" action="'.get_template_directory_uri().'/auth.php" method="POST">';
        echo '<input type="text" name="login" placeholder="Логин">';
        echo '<input type="password" name="pass" placeholder="Пароль">';
        echo '<div style="margin-top: 25px; width: 305px; position: absolute; left: 50%; margin-left: -152.5px;">';
        echo '<input type="submit" value="Войти">';
        echo '<a class="reg" href="'.get_template_directory_uri().'/reg.php">Регистрация</a>';
        echo '<a class="resetPass" href="'.get_template_directory_uri().'/resetpass.php">Восстановить доступ?</a>';
        echo '</div>';
        echo '</form>';
    }
    wp_die();
}