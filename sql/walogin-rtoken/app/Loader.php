<?php

namespace BeycanPress\Walogin\RToken;

class Loader
{
    public function __construct()
    {
        if (is_admin()) {
            new MetaBox();
            new Settings();
        } else {
            new Restrict();
        }
    }

    public static function adminNotice()
    {
        add_action('admin_notices', function() {
            $notice = esc_html__('In order to use the "Restrict Content By Token For Walogin" Plugin, please install and activate the "Walogin" Plugin.', 'walogin');
            $type = 'error';
            ob_start();
            require_once dirname(__DIR__) . '/views/notice.php';
            echo ob_get_clean();
        });
    }
}
