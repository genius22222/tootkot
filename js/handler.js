var handler = {
    screen: 'mobile'
    ,adaptive: function (winscreen) {
        console.log(winscreen);
        if (winscreen === undefined){
            winscreen = $(document).width();
        }
        if (winscreen < 1280){
            if (this.screen !== 'mobile'){
                //Тут адаптивность

                $('.header').removeClass('header_pc');
                $('.header').addClass('header_mobi');

                $('.header-top').removeClass('header-top_pc');
                $('.header-top').addClass('header-top_mobi');

                $('.header-top_logo').removeClass('header-top_logo-pc');
                $('.header-top_logo').addClass('header-top_logo-mobi');

                $('.header-top_infoBoxWrapper-pc').addClass('disable');

                $('.header-top_activationButton-mobi').removeClass('disable');

                $('.header-top_menuButton-mobi').removeClass('disable');

                $('.header-bottom').removeClass('header-bottom_pc');
                $('.header-bottom').addClass('header-bottom_mobi');

                $('.header-bottom_menu-pc').addClass('disable');

                this.screen = 'mobile';
            }
        } else {
            if (this.screen !== 'desktop'){
                //Тут адаптивность
                $('.info-box_mobi').hide();
                $('.info-box_content_mobi').empty();


                $('.header').removeClass('header_mobi');
                $('.header').addClass('header_pc');

                $('.header-top').removeClass('header-top_mobi');
                $('.header-top').addClass('header-top_pc');

                $('.header-top_logo').removeClass('header-top_logo-mobi');
                $('.header-top_logo').addClass('header-top_logo-pc');

                $('.header-top_infoBoxWrapper-pc').removeClass('disable');

                $('.header-top_activationButton-mobi').addClass('disable');

                $('.header-top_menuButton-mobi').addClass('disable');

                $('.header-bottom').removeClass('header-bottom_mobi');
                $('.header-bottom').addClass('header-bottom_pc');

                $('.header-bottom_menu-pc').removeClass('disable');

                this.screen = 'desktop';
            }
        }
    }

    ,getMenu: function (type) {
        if (type === undefined) console.log('Не указаны аргументы в Мобильном Инфобоксе!');
        else {
            if (type == 'menu'){
                var data = {
                    action: 'getMenuMobi',
                };
                a = {};
                $.ajax({
                    url: myajax.url,
                    type: 'POST',
                    async: false,
                    data: data,
                    dataType: 'html'
                }).done(function(html){
                    a = html;
                });
                return a;
            }
            if (type == 'auth'){
                var data = {
                    action: 'getAuthMobi',
                };
                a = {};
                $.ajax({
                    url: myajax.url,
                    type: 'POST',
                    async: false,
                    data: data,
                    dataType: 'html'
                }).done(function(html){
                    a = html;
                });
                return a;
            }
        }
    }
    ,eventON: function () {
        var safe = this;
        $(window).resize(function () {  //Обработчик изменения размера окна
            safe.adaptive();
        });
        $('.header-top_activationButton-mobi').bind('click', function () { //Вливаем html авторизации или меню пользователя
            $('.info-box_content_mobi').empty(); //Очищаем поле ввода html
            $('.info-box_content_mobi').append(authHtml); //Записываем html

            $('.info-box_mobi').show();
        });
        $('.header-top_menuButton-mobi').bind('click', function () { //Вливаем html меню сайта
            $('.info-box_content_mobi').empty(); //Очищаем поле ввода html
            $('.info-box_content_mobi').append(menuHtml); //Записываем html
            $('.info-box_mobi').show();
        });
        $('.info-box_closeButton_mobi').bind('click', function () {
            $('.info-box_mobi').hide();
            $('.info-box_content_mobi').empty();
        })
    }
}