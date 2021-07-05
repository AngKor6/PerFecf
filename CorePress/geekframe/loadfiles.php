<?php
function corepress_load_scripts()
{
    global $set;
    wp_enqueue_script('index_js', THEME_JS_PATH . '/index.js', array(), THEME_VERSION, true);
    $setdata = load_set_data_to_js();
    wp_localize_script('index_js', 'set', $setdata);
    if ($set['module']['highlight'] == 1) {
        if (is_single() || is_page()) {
            wp_enqueue_script('highlight_init', THEME_LIB_PATH . '/highlight/init.js', array(), THEME_VERSION, true);
        }
    }
    if (is_single()|| is_page()) {
        wp_enqueue_script('post_content', THEME_JS_PATH . '/post-content.js', array(), THEME_VERSION, true);
    }
    wp_enqueue_script('tools', THEME_JS_PATH . '/tools.js', array(), THEME_VERSION, false);

}
add_action('wp_enqueue_scripts', 'corepress_load_scripts');

function load_set_data_to_js()
{
    global $set;
    $setdata = array();
    /**
     * 通用模块
     */
    $setdata['is_single'] = is_single();
    $setdata['is_page'] = is_page();
    $setdata['is_home'] = is_home();
    $setdata['ajaxurl'] = AJAX_URL;


    /*
     * 防转载模块
     * */
    $set['module']['reprint']['open'] == 0;
    $setdata['reprint']['msg'] = '';
    $setdata['reprint']['copylenopen'] = 0;
    $setdata['reprint']['copylen'] = 0;
    $setdata['reprint']['addurl'] = 0;
    $setdata['reprint']['siteurl'] = curPageURL();

    if ($set['module']['reprint']['open'] == 1) {
        $setdata['reprint']['open'] = 1;
        $setdata['reprint']['msg'] = $set['module']['reprint']['msg'];
        if ($set['module']['reprint']['copylenopen'] == 1) {
            $setdata['reprint']['copylenopen'] = 1;
            $setdata['reprint']['copylen'] = $set['module']['reprint']['copylen'];
        }
        if ($set['module']['reprint']['addurl'] == 1) {
            $setdata['reprint']['addurl'] = 1;
        }
    }
    /**
     *延迟加载
     */
    $setdata['module']['imglightbox'] = $set['module']['imglightbox'];
    $setdata['module']['imglazyload'] = $set['module']['imglazyload'];

    /**
     * 文章参数
     */

    if (is_single() || is_page()) {
        global $corepress_post_meta;
        $setdata['corepress_post_meta'] = $corepress_post_meta;
        $setdata['theme']['sidebar_position'] = $set['theme']['sidebar_position'];

    }
    /**
     * 延迟加载
     */
    $setdata['module']['imglazyload'] = $set['module']['imglazyload'];

    /**
     * 顶部加载
     */
    $setdata['theme']['loadbar'] = $set['theme']['loadbar'];
    $setdata['index']['linksicon'] = $set['index']['linksicon'];
    $setdata['index']['chromeiconurl'] = file_get_img_url("chrome.png");
    return $setdata;

}