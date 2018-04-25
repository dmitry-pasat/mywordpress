<?php

include_once CMPD_PLUGIN_DIR . '/frontend/classes/Template.php';

class CMProductDirectoryProductPageView extends CMPDProductPageTemplate {

    private $post;
    private $path;

    public function __construct() {
        $this->post = get_post();
    }

    public function content() {
        $customCSS= CMPD_Settings::getOption(CMPD_Settings::OPTION_CUSTOM_CSS);

        /*
         * Output custom CSS
         */
        $output = '';
        if (!empty($customCSS)) {
            $output .= '<style type="text/css">' . $customCSS . '</style>';
        }
        do_action('cmpd_before_product_page_content');
        $output .= CMProductDirectoryProductPage::loadTemplateView('content', array(
                    'post' => get_post(),
                    'post_meta' => (object) get_post_meta($this->post->ID),
                        ), true);

        return apply_filters('cmpd_single_item_content', $output);
    }

    public static function cmpd_enqueue_template_scripts($path) {
        wp_enqueue_style('cmpd-styles', $path . 'assets/css/styles.css');
    }

}