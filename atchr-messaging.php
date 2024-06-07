<?php
/*
Plugin Name: Atchr Messaging
Author: Chromesque LLC
Author URI: https://chromesque.com
Description: Atchr by Chromesque is a secure AI Chatbot, Instant messaging & Analytics platform for organizations, businesses, teams and individuals. Atchr provides a secure communications platform that bridges the divide between you, your customers and your team.
Version: 1.0
*/

if (!defined('ABSPATH')) {
  exit;
}

define('ATCHR_MESSAGING_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ATCHR_MESSAGING_PLUGIN_URL', plugin_dir_url(__FILE__));

include_once(ATCHR_MESSAGING_PLUGIN_DIR . 'assets/php/atchr-messaging-functions.php');

add_action('admin_menu', 'atchr_messaging_menu');
add_action('admin_enqueue_scripts', 'atchr_messaging_admin_scripts');
add_action('wp_footer', 'atchr_messaging_embed_script');
