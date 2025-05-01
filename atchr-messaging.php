<?php
/**
 * Plugin Name: Atchr Messaging
 * Plugin URI: https://atchr.com
 * Description: Atchr by Chromesque is a secure AI Chatbot, Instant messaging & Analytics platform for organizations, businesses, teams and individuals. Atchr provides a secure communications platform that bridges the divide between you, your customers and your team.
 * Version: 1.0.0
 * Author: Chromesque, LLC
 * Author URI: https://chromesque.com
 * Text Domain: atchr-messaging
 * Domain Path: /languages
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires at least: 5.0
 * Requires PHP: 7.2
 * Tested up to: 6.8
 *
 * Atchr Messaging is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Atchr Messaging is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Atchr Messaging. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 */

if (!defined('ABSPATH')) {
  exit;
}

define('ATCHR_MESSAGING_VERSION', '1.0.0');
define('ATCHR_MESSAGING_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ATCHR_MESSAGING_PLUGIN_URL', plugin_dir_url(__FILE__));

include_once(ATCHR_MESSAGING_PLUGIN_DIR . 'assets/php/atchr-messaging-functions.php');

add_action('admin_menu', 'atchr_messaging_menu');
add_action('admin_enqueue_scripts', 'atchr_messaging_admin_scripts');
add_action('wp_footer', 'atchr_messaging_embed_script');
