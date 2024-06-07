<?php
if (!defined('ABSPATH')) {
  exit;
}

function atchr_messaging_menu()
{
  add_menu_page(
    'Atchr Messaging Settings',
    'Atchr Messaging',
    'manage_options',
    'atchr-messaging',
    'atchr_messaging_settings_page',
    ATCHR_MESSAGING_PLUGIN_URL . 'assets/images/menu-icon.svg',
    100
  );
}

function atchr_messaging_settings_page()
{
  ?>
  <div class="wrap postbox">
    <table>
      <tr>
        <td style="width: 90px"><img src="<?php echo ATCHR_MESSAGING_PLUGIN_URL . 'assets/images/logo-dark.png'; ?>" alt="Atchr Logo" /></td>
        <td><h1 class="title">Widget Settings</h1></td>
      </tr>
    </table>
    <form method="post" action="options.php">
      <?php
      settings_fields('atchr_messaging_settings');
      do_settings_sections('atchr-messaging');
      submit_button();
      ?>
    </form>
    <p>To get your Atchr embed code, register at <a href="https://atchr.com" target="_blank">atchr.com</a>.</p>
  </div>
  <div style="margin-top: 20px;">
    Atchr Messaging - &hearts; by <a href="https://chromesque.com" target="_blank">Chromesque LLC</a>
  </div>
  <?php
}

function atchr_messaging_settings_init()
{
  register_setting('atchr_messaging_settings', 'atchr_embed_code');

  add_settings_section(
    'atchr_messaging_section',
    '',
    'atchr_messaging_section_callback',
    'atchr-messaging'
  );

  add_settings_field(
    'atchr_embed_code',
    'Atchr Embed Code',
    'atchr_embed_code_render',
    'atchr-messaging',
    'atchr_messaging_section'
  );
}

function atchr_messaging_section_callback()
{
  echo '';
}

function atchr_embed_code_render()
{
  $embed_code = get_option('atchr_embed_code');
  ?>
  <input type="text" name="atchr_embed_code" value="<?php echo isset($embed_code) ? esc_attr($embed_code) : ''; ?>"
    size="50">
  <?php
}

function atchr_messaging_embed_script()
{
  $embed_code = get_option('atchr_embed_code');
  if ($embed_code) {
    wp_enqueue_script('atchr-messaging', ATCHR_MESSAGING_PLUGIN_URL . 'assets/js/atchr-messaging.js', [], null, true);
    wp_localize_script('atchr-messaging', 'atchrMessaging', ['embedCode' => esc_js($embed_code)]);
  }
}

function atchr_messaging_admin_scripts($hook)
{
  if ($hook != 'toplevel_page_atchr-messaging') {
    return;
  }
  wp_enqueue_style('atchr-messaging-admin', ATCHR_MESSAGING_PLUGIN_URL . 'assets/css/admin.css');
}

add_action('admin_init', 'atchr_messaging_settings_init');
?>