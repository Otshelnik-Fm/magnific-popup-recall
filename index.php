<?php

/*

╔═╗╔╦╗╔═╗╔╦╗
║ ║ ║ ╠╣ ║║║ https://otshelnik-fm.ru
╚═╝ ╩ ╚  ╩ ╩

*/


// запрет прямого обращения к файлу
if ( !defined('ABSPATH') ) exit;



// https://github.com/dimsemenov/Magnific-Popup
// http://dimsemenov.com/plugins/magnific-popup/
// подключаю скрипты
function mpr_load_resource() {
    if(!is_admin()){
        //rcl_enqueue_style('mpr-general',rcl_addon_url('incl/dist/magnific-popup.css', __FILE__)); // родные стили от скрипта теперь в общем файле
        rcl_enqueue_style('mpr-second',rcl_addon_url('mpr-style.css', __FILE__), true); // 3 аргумент - грузить в подвале
    }
}
add_action('rcl_enqueue_scripts', 'mpr_load_resource',10);



// скрипт magnific в футере
function mpr_load_scr() {
    wp_enqueue_script('mpr-script', rcl_addon_url('incl/dist/jquery.magnific-popup.min.js', __FILE__),array('jquery'),'1.1.0',true);
}
add_action('wp_enqueue_scripts', 'mpr_load_scr', 10);



// js localize
function mpr_localize($data){
    $js_loc = array(
        'close'     => __('Close (Esc)','mpr-magnific'),
        'prev'      => __('Previous','mpr-magnific'),
        'next'      => __('Next','mpr-magnific'),
        'of'        => __('of','mpr-magnific'),
        'img'       => __('Image','mpr-magnific'),
        'not_load'  => __('could not be loaded','mpr-magnific')
    );
    $data['magni_r'] = $js_loc;

    return $data;
}
add_filter('rcl_init_js_variables','mpr_localize',10);



// подключим перевод
function mpr_textdomain(){
    load_textdomain( 'mpr-magnific', rcl_addon_path(__FILE__).'/languages/mpr-magnific-'.get_locale().'.mo' );
}
add_action('plugins_loaded', 'mpr_textdomain',10);



// скрипт инициализации
function mpr_init_script(){
    //console.log(Rcl.magni_r);
echo "<script>
jQuery(document).ready(function(){MpActivate()});function MpActivate(){var a='a[href$=\".bmp\"],a[href$=\".gif\"],a[href$=\".jpg\"],a[href$=\".jpeg\"],a[href$=\".png\"]';var b=jQuery(a).not('.nomagnific');b.addClass('mpr_image');jQuery('.mpr_image').magnificPopup({type:'image',closeBtnInside:false,tClose:Rcl.magni_r.close,gallery:{enabled:true,tPrev:Rcl.magni_r.prev,tNext:Rcl.magni_r.next,tCounter:'<span class=\"mfp-counter\">%curr% '+Rcl.magni_r.of+' %total%</span>'},image:{verticalFit:false,tError:'<a href=\"%url%\">'+Rcl.magni_r.img+'</a> '+Rcl.magni_r.not_load+'.'},callbacks:{change:function(){if(this.isOpen){this.wrap.addClass('mfp-open')}}}})}function mprPrimeReload(a){var b=a.result;var c=a.object;if(c.method!='post_create'||b.error)return false;MpActivate()}rcl_add_action('pfm_ajax_action_success','mprPrimeReload');
</script>";
}
add_action('wp_footer','mpr_init_script',120);



// пакую этим js пакером http://dean.edwards.name/packer/

// скрипт для разработки. Выше - он же но сжатый
function mpr_init_script_develop(){
    $out = "<script>

jQuery(document).ready(function() {
    MpActivate();
});


function MpActivate() { // инициализация отдельной функцией - можно вызывать после ajax
    var type_image = 'a[href$=\".bmp\"],a[href$=\".gif\"],a[href$=\".jpg\"],a[href$=\".jpeg\"],a[href$=\".png\"]';
    var select = jQuery(type_image).not('.nomagnific'); // ассоциируем и добавляем исключающий класс
    select.addClass('mpr_image'); // присваиваем всем картинкам класс

    jQuery('.mpr_image').magnificPopup({
        type: 'image',
        //disableOn:function(){return $(window).width()<500?!1:!0},
        closeBtnInside:false,
        tClose: Rcl.magni_r.close,
        gallery:{
            enabled:true,
            tPrev: Rcl.magni_r.prev,
            tNext: Rcl.magni_r.next,
            tCounter: '<span class=\"mfp-counter\">%curr% '+Rcl.magni_r.of+' %total%</span>'
        },
        image: {
            verticalFit: false,
            tError: '<a href=\"%url%\">'+Rcl.magni_r.img+'</a> '+Rcl.magni_r.not_load+'.'
        },
        callbacks: {
            change: function() {
                if (this.isOpen) {
                    this.wrap.addClass('mfp-open');
                }
            }
        }
    });
}


// поддержка допа Prime Image Uploader
function mprPrimeReload(success){
    var result = success.result;
    var object = success.object;

    if(object.method != 'post_create' || result.error) return false;

    MpActivate();
}
rcl_add_action('pfm_ajax_action_success','mprPrimeReload');

</script>";
    echo $out;
}

