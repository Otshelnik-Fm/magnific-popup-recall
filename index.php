<?php

// https://github.com/dimsemenov/Magnific-Popup
// http://dimsemenov.com/plugins/magnific-popup/
// подключаю скрипты
function mpr_load_resource() {
    if(!is_admin()){
        rcl_enqueue_style('mpr-general',rcl_addon_url('incl/dist/magnific-popup.css', __FILE__));
        rcl_enqueue_style('mpr-second',rcl_addon_url('mpr-style.css', __FILE__));
    }
}
add_action('rcl_enqueue_scripts', 'mpr_load_resource',10);

// скрипт magnific в футере
function mpr_load_scr() {
    wp_enqueue_script('mpr-script', rcl_addon_url('incl/dist/jquery.magnific-popup.min.js', __FILE__),array('jquery'),'1.1.0',true);
}
add_action('wp_enqueue_scripts', 'mpr_load_scr', 10);


// скрипт инициализации
function mpr_init_script(){
$out = "<script>
(function($){var type_image = 'a[href$=\".bmp\"],a[href$=\".gif\"],a[href$=\".jpg\"],a[href$=\".jpeg\"],a[href$=\".png\"]';var select = $(type_image).not('.nomagnific');select.addClass('mpr_image');jQuery(document).ready(function() {jQuery('.mpr_image').magnificPopup({type: 'image',closeBtnInside:false,tClose: 'Закрыть (Esc)',gallery:{enabled:true,tPrev: 'Предыдущее',tNext: 'Следующее',tCounter: '<span class=\"mfp-counter\">%curr% из %total%</span>'},image: {verticalFit: false,tError: '<a href=\"%url%\">Изображение</a> не может быть загружено.'},callbacks: {change: function() {if (this.isOpen) {this.wrap.addClass('mfp-open');}}}});});})(jQuery);
</script>";
    echo $out;
}
add_action('wp_footer','mpr_init_script',120);


// скрипт для разработки. Выше - он же но сжатый
function mpr_init_script_develop(){
    $out = "<script>
(function($){
    var type_image = 'a[href$=\".bmp\"],a[href$=\".gif\"],a[href$=\".jpg\"],a[href$=\".jpeg\"],a[href$=\".png\"]';
    var select = $(type_image).not('.nomagnific'); // ассоциируем и добавляем исключающий класс
    select.addClass('mpr_image'); // присваиваем всем картинкам класс
    $(document).ready(function() {
        $('.mpr_image').magnificPopup({
            type: 'image',
            //disableOn:function(){return $(window).width()<500?!1:!0},
            closeBtnInside:false,
            tClose: 'Закрыть (Esc)',
            gallery:{
                enabled:true,
                tPrev: 'Предыдущее',
                tNext: 'Следующее',
                tCounter: '<span class=\"mfp-counter\">%curr% из %total%</span>'
            },
            image: {
                verticalFit: false,
                tError: '<a href=\"%url%\">Изображение</a> не может быть загружено.'
            },
            callbacks: {
                change: function() {
                    if (this.isOpen) {
                        this.wrap.addClass('mfp-open');
                    }
                }
            }
        });
    });
})(jQuery);
</script>";
    echo $out;
}

