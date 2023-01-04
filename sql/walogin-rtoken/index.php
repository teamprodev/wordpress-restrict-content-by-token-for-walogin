<?php 

namespace BeycanPress\Walogin;

/**
 * Plugin Name:  Restrict Content By Token For Walogin
 * Version:      1.0.1
 * Plugin URI:   https://walogin.beycanpress.com
 * Description:  By restricting your content, you can only show it to users with certain Tokens.
 * Author URI:   https://beycanpress.com
 * Author:       BeycanPress
 * Tags:         Restrict Content By Token For Walogin, wordpress show hide content by token, wordpress private content by token
 * Text Domain:  walogin
 * License:      GPLv3
 * License URI:  https://www.gnu.org/licenses/gpl-3.0.tr.html
 * Domain Path:  /languages
 * Requires at least: 5.0
 * Tested up to: 6.0
 * Requires PHP: 7.4
*/

require_once __DIR__ . '/vendor/autoload.php';

add_action('plugins_loaded', function() {
    if (class_exists(Loader::class)) {
        new \BeycanPress\Walogin\RToken\Loader(__FILE__);
    } else {
        \BeycanPress\Walogin\RToken\Loader::adminNotice();
    }
});