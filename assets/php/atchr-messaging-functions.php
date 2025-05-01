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
    esc_url(ATCHR_MESSAGING_PLUGIN_URL . 'assets/images/menu-icon.svg'),
    100
  );
}

function atchr_get_plugin_image($image_path, $alt, $args = [])
{
  $default_args = [
    'class' => '',
    'width' => '',
    'height' => '',
    'loading' => 'lazy',
  ];

  $args = wp_parse_args($args, $default_args);
  $img_url = esc_url(ATCHR_MESSAGING_PLUGIN_URL . 'assets/images/' . $image_path);

  $attr = [
    'src' => $img_url,
    'alt' => esc_attr($alt),
    'class' => esc_attr($args['class']),
    'loading' => esc_attr($args['loading'])
  ];

  if (!empty($args['width'])) {
    $attr['width'] = esc_attr($args['width']);
  }

  if (!empty($args['height'])) {
    $attr['height'] = esc_attr($args['height']);
  }

  $html = '<img';
  foreach ($attr as $name => $value) {
    $html .= ' ' . $name . '="' . $value . '"';
  }
  $html .= ' />';

  return $html;
}

function atchr_messaging_settings_page()
{
  ?>
  <div class="wrap postbox">
    <table>
      <tr>
        <td style="width: 90px">
  <?php echo wp_kses_post(atchr_get_plugin_image('logo-dark.png', 'Atchr Logo', [
            'width' => '90',
            'height' => '60',
            'class' => 'atchr-logo'
          ])); ?>
        </td>
        <td><h1 class="title">Widget Settings</h1></td>
      </tr>
    </table>
    <form method="post" action="options.php">
      <?php
      settings_fields('atchr_messaging_settings');
      wp_nonce_field('atchr_messaging_nonce', 'atchr_messaging_nonce_field');
      do_settings_sections('atchr-messaging');
      submit_button();
      ?>
    </form>
    <p>To get your Atchr embed code, register at <a href="https://atchr.com" style="text-decoration: none;" target="_blank">atchr.com</a>.</p>
  </div>
  <div style="margin-top: 20px;">
    Atchr Messaging - &hearts; by <a href="https://chromesque.com" style="text-decoration: none;" target="_blank">Chromesque, LLC</a>
  </div>
  <?php
}

function atchr_messaging_settings_init()
{
  register_setting(
    'atchr_messaging_settings',
    'atchr_embed_code',
    array(
      'sanitize_callback' => 'atchr_sanitize_embed_code',
      'default' => ''
    )
  );

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

function atchr_sanitize_embed_code($input)
{
  return wp_kses($input, array(
    'script' => array(
      'type' => array(),
      'src' => array(),
      'async' => array(),
      'defer' => array(),
      'id' => array(),
      'data-*' => true,
    )
  ));
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
    size="50" placeholder="Enter Embed Code">
  <?php
}

function atchr_messaging_embed_script()
{
  $embed_code = get_option('atchr_embed_code');
  if ($embed_code) {
    wp_enqueue_script('atchr-messaging', ATCHR_MESSAGING_PLUGIN_URL . 'assets/js/atchr-messaging.js', [], ATCHR_MESSAGING_VERSION, true);
    wp_localize_script('atchr-messaging', 'atchrMessaging', ['embedCode' => esc_js($embed_code)]);
  }
}

function atchr_messaging_admin_scripts($hook)
{
  if ($hook != 'toplevel_page_atchr-messaging') {
    return;
  }
  wp_enqueue_style('atchr-messaging-admin', ATCHR_MESSAGING_PLUGIN_URL . 'assets/css/admin.css', [], ATCHR_MESSAGING_VERSION);
}

add_action('admin_init', 'atchr_messaging_settings_init');
?>