<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <?php wp_head(); ?>
    <title><?php echo wp_get_document_title(); ?></title>
</head>
<body>
<div class="prerol"></div>
<div class="info-box_mobi">
    <div class="info-box_wrapper-mobi">
        <div class="info-box_closeButton_mobi"></div>
        <div class="info-box_content_mobi"></div>
    </div>
</div>
<div class="main-wrapper main-wrapper_mobi">
    <div class="header header_mobi">
        <div class="header-top header-top_mobi">
            <img class="header-top_logo header-top_logo-mobi" src="<?php echo get_custom_logo(0); ?>" alt="<?php echo bloginfo('name'); echo ' | '; echo bloginfo('name'); ?>">
            <div class="header-top_activationButton-mobi"></div>
            <div class="header-top_menuButton-mobi"></div>
            <div class="header-top_infoBoxWrapper-pc disable">
                <?php
                if ( is_user_logged_in() ) echo '<a href="'.get_template_directory_uri().'/lk.php" class="header-top_authButton-pc" onclick="handler(messagebox, pc); return false; ">Личный кабинет</a>';
                else '<a href="'.get_template_directory_uri().'/auth.php" class="header-top_authButton-pc">Вход/Регистрация</a>';
                ?>
                <div class="info-box_pc">
                    <?php
                    if ( is_user_logged_in() ){
                        echo '<a href="'.get_template_directory_uri().'/myorders.php" id="ordersPC">Мои заказы</a>';
                        echo '<a href="'.get_template_directory_uri().'/chat/index.php" id="openChatPC">Сообщения</a>';
                    }
                ?>
                </div>
            </div>
        </div>
        <div class="header-bottom header-bottom_mobi">
            <div class="header-bottom_menu-pc disable">
                <?php
                $walker = new pcMenuWalker();
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
                    'items_wrap'      => '<ul class="site-menu_pc">%3$s</ul>',
                    'depth'           => 0,
                    'walker'          => $walker,
                ) ); ?>
            </div>
        </div>
    </div>