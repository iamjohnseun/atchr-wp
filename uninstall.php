<?php
/**
 * Uninstall Atchr Messaging
 *
 * @package Atchr_Messaging
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
  exit;
}

delete_option('atchr_embed_code');