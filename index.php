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
    if( !is_admin() ){
        //rcl_enqueue_style('mpr-general',rcl_addon_url('incl/dist/magnific-popup.css', __FILE__)); // родные стили от скрипта теперь в общем файле
        rcl_enqueue_style('mpr-second', rcl_addon_url('mpr-style.css', __FILE__), true); // 3 аргумент - грузить в подвале
    }
}
add_action('rcl_enqueue_scripts', 'mpr_load_resource', 10);



// скрипт magnific в футере
function mpr_load_scr() {
    wp_enqueue_script('mpr-script', rcl_addon_url('incl/dist/jquery.magnific-popup.min.js', __FILE__), array('jquery'), '2.0.0', true);
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
add_filter('rcl_init_js_variables', 'mpr_localize', 10);



// подключим перевод
function mpr_textdomain(){
    load_textdomain( 'mpr-magnific', rcl_addon_path(__FILE__).'/languages/mpr-magnific-'.get_locale().'.mo' );
}
add_action('plugins_loaded', 'mpr_textdomain', 10);


function mpr_ettings_page(){
    $chr_page = get_current_screen();

    if($chr_page->base != 'wp-recall_page_rcl-options') return;
    if( isset($_COOKIE['otfmi_1']) && isset($_COOKIE['otfmi_2']) && isset($_COOKIE['otfmi_3']) )  return;

    require_once 'admin/for-settings.php';
}
add_action('admin_footer', 'mpr_ettings_page');


// скрипт инициализации
function mpr_init_script(){
    //console.log(Rcl.magni_r);
echo "
<script>jQuery(document).ready(function(){MpActivate()});function MpActivate(a){var b=' a[href$=\".bmp\"]';var c=' a[href$=\".gif\"]';var d=' a[href$=\".jpg\"]';var e=' a[href$=\".jpeg\"]';var f=' a[href$=\".png\"]';if(typeof a!=='undefined'){var g=a+b+','+a+c+','+a+d+','+a+e+','+a+f}else{var g=b+','+c+','+d+','+e+','+f}var h=jQuery(g).not('.nomagnific');h.addClass('mpr_image');jQuery('.mpr_image').magnificPopup({type:'image',closeBtnInside:false,tClose:Rcl.magni_r.close,gallery:{enabled:true,tPrev:Rcl.magni_r.prev,tNext:Rcl.magni_r.next,tCounter:'<span class=\"mfp-counter\">%curr% '+Rcl.magni_r.of+' %total%</span>'},image:{verticalFit:false,tError:'<a href=\"%url%\">'+Rcl.magni_r.img+'</a> '+Rcl.magni_r.not_load+'.'},callbacks:{change:function(){if(this.isOpen){this.wrap.addClass('mfp-open')}}}})}</script>";

echo "
<script>function mprPrimeReload(a){var b=a.result;var c=a.object;if(c.method!='get_preview'||b.error)return false;var d='.prime-post-content';MpActivate(d)}rcl_add_action('pfm_ajax_action_success','mprPrimeReload');function mprPrimeNewPost(){var a='.prime-post-content';setTimeout(function(){MpActivate(a)},400)}rcl_add_action('pfm_new_post','mprPrimeNewPost');</script>";

echo "
<script>function mprChatReload(){var a='.chat-messages';MpActivate(a)}rcl_add_action('rcl_get_chat_page','mprChatReload');rcl_add_action('rcl_chat_important_manager_shift','mprChatReload');rcl_add_action('rcl_init_chat','mprChatReload');rcl_add_action('rcl_chat_add_message','mprChatReload');function mprChatGetMessagesReload(a){var b=a.result.content;if(b.length<=0)return;var c='.chat-messages';MpActivate(c)}rcl_add_action('rcl_chat_get_messages','mprChatGetMessagesReload');</script>
";
}
add_action('wp_footer', 'mpr_init_script', 220);



// пакую этим js пакером http://dean.edwards.name/packer/

// скрипт для разработки. Выше - он же но сжатый
function mpr_init_script_develop(){

// инициализация magnific
    $out = "<script>

jQuery(document).ready(function() {
    MpActivate();
});

// инициализация отдельной функцией - можно вызывать после ajax
// dAttr - принимает атрибут .class или #id контейнера в котором нужно искать картинки.
// так будет не все dom дерево перестраивать, а только локальный участок
function MpActivate(dAttr) {
    var mBmp =  ' a[href$=\".bmp\"]';
    var mGif =  ' a[href$=\".gif\"]';
    var mJpg =  ' a[href$=\".jpg\"]';
    var mJpeg = ' a[href$=\".jpeg\"]';
    var mPng =  ' a[href$=\".png\"]';

    if (typeof dAttr !== 'undefined') {
        var type_image = dAttr + mBmp + ',' + dAttr + mGif + ',' + dAttr + mJpg + ',' + dAttr + mJpeg + ',' + dAttr + mPng;
    } else {
        var type_image = mBmp + ',' + mGif + ',' + mJpg + ',' + mJpeg + ',' + mPng;
    }

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
</script>";

// поддержка PrimeForum
    $out .= "<script>
// предпросмотр сообщения PrimeForum
function mprPrimeReload(success){
    var result = success.result;
    var object = success.object;

    if(object.method != 'get_preview' || result.error) return false;

    var dAttr = '.prime-post-content';
    MpActivate(dAttr);
}
rcl_add_action('pfm_ajax_action_success','mprPrimeReload');

// поддержка допа Prime Image Uploader и PrimeForum добавление нового сообщения
// PrimeForum получение чужого нового сообщения
function mprPrimeNewPost(){
    var dsAttr = '.prime-post-content';
    setTimeout(function(){
        MpActivate(dsAttr);
    },400);
}
rcl_add_action('pfm_new_post','mprPrimeNewPost');
</script>";


// поддержка RCL Chat
    $out .= "<script>
//   когда переключаю пагинацию
//   когда перехожу в важные сообщения и назад
//   когда инициализируется чат (загрузка чата или вкладки ЛС или: миничат - справа блок)
//   когда я отправляю сообщение
//   когда я принимаю сообщение

function mprChatReload(){
    var dAttr = '.chat-messages';
    MpActivate(dAttr);
}
rcl_add_action('rcl_get_chat_page','mprChatReload'); // ajax пагинация чата. динамич-хук rcl_do_action(prop.data.action, result); ядра
rcl_add_action('rcl_chat_important_manager_shift','mprChatReload'); // переключение к важным сообщениям и назад. динамич-хук
rcl_add_action('rcl_init_chat','mprChatReload'); // открыли окно чата: в миничате, в прайм форуме, в лк ЛС (даже по F5)
rcl_add_action('rcl_chat_add_message','mprChatReload'); // добавляем сообщение в чат - перезагружаем


// получим сообщение RCL Chat
function mprChatGetMessagesReload(data){
    var content = data.result.content;
    if (content.length <= 0) return; // запрос говорит - нет новых сообщений

    var dAttr = '.chat-messages';
    MpActivate(dAttr);
}
rcl_add_action('rcl_chat_get_messages','mprChatGetMessagesReload');
</script>";

    echo $out;
}

