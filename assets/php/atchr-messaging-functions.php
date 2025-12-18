<?php
if (!defined('ABSPATH')) {
  exit;
}

function atchr_messaging_menu()
{
  $icon_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 95 95"><path d="M48.4 84.8c0 1.8 1.8 1.8 3.7 1.8 5.5-1.8 11.1-11.1 14.7-14.7 1.8-1.8 9.2-11.1 9.2-11.1.5-.8.9-1.5 1.2-2 1.5-3-1.5-1.7-3-1.7L48.4 71.9v12.9z" fill="#a7aaad"/><circle cx="46.6" cy="43.2" r="1.8" fill="#a7aaad" stroke="#a7aaad" stroke-width="8" stroke-miterlimit="10"/><circle cx="46.6" cy="43.2" r="28.4" fill="none" stroke="#a7aaad" stroke-width="12" stroke-miterlimit="10"/></svg>';
  $icon_base64 = 'data:image/svg+xml;base64,' . base64_encode($icon_svg);

  add_menu_page(
    'Atchr Messaging Settings',
    'Atchr Messaging',
    'manage_options',
    'atchr-messaging',
    'atchr_messaging_settings_page',
    $icon_base64,
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
    'atchr_entity_id',
    array(
      'sanitize_callback' => 'atchr_sanitize_entity_id',
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
    'atchr_entity_id',
    'Atchr Entity ID',
    'atchr_entity_id_render',
    'atchr-messaging',
    'atchr_messaging_section'
  );
}

function atchr_sanitize_entity_id($input)
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

function atchr_entity_id_render()
{
  $entity_id = get_option('atchr_entity_id');
  ?>
  <input type="text" name="atchr_entity_id" value="<?php echo isset($entity_id) ? esc_attr($entity_id) : ''; ?>"
    size="50" placeholder="Enter Embed Code">
  <?php
}

function atchr_messaging_embed_script()
{
  $entity_id = get_option('atchr_entity_id');
  if ($entity_id) {
    wp_enqueue_script('atchr-messaging', ATCHR_MESSAGING_PLUGIN_URL . 'assets/js/atchr-messaging.js', [], ATCHR_MESSAGING_VERSION, true);
    wp_localize_script('atchr-messaging', 'atchrMessaging', ['entityID' => esc_js($entity_id)]);
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