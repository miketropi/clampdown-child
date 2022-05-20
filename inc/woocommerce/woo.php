<?php
/**
 * Custom Woo
 * 
 */

/**
 * Woo enqueue scripts
 */
function clampdown_child_woo_enqueue_scripts() {
  wp_enqueue_style('clamdown-child-woo-style', CLAMPDOWN_URI . '/dist/woofrontend.clampdown.bundle.css', false, CLAMPDOWN_VER);
  wp_enqueue_script('clamdown-child-woo-script', CLAMPDOWN_URI . '/dist/woofrontend.clampdown.bundle.js', ['jquery'], CLAMPDOWN_VER, true);

  wp_localize_script('clamdown-child-woo-script', 'CLAMPDOWN_PHP_WOO_DATA', [
    'ajax_url' => admin_url('admin-ajax.php'),
    'site_url' => get_site_url(),
    'user_logged_id' => get_current_user_id(),
    'lang' => []
  ]);
}

add_action('wp_enqueue_scripts', 'clampdown_child_woo_enqueue_scripts', 30);

add_action('init', function() {
  remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
});

/**
 * Backend enqueue scripts 
 */
function clampdown_child_woo_admin_enqueue_scripts() {
  wp_enqueue_style('clamdown-child-admin-woo-style', CLAMPDOWN_URI . '/dist/woobackend.clampdown.bundle.css', false, CLAMPDOWN_VER);
  wp_enqueue_script('clamdown-child-admin-woo-script', CLAMPDOWN_URI . '/dist/woobackend.clampdown.bundle.js', ['jquery'], CLAMPDOWN_VER, true);

  wp_localize_script('clamdown-child-admin-woo-script', 'CLAMPDOWN_PHP_WOO_DATA', [
    'ajax_url' => admin_url('admin-ajax.php'),
    'lang' => [],
  ]);
}

add_action('admin_enqueue_scripts', 'clampdown_child_woo_admin_enqueue_scripts', 30);

function clampdown_child_woo_get_product_pricing_settings($id = 0, $name = null) {
  $default = [
    "enable_pricing_mode" => "false", 
    "general_default_opts" => [
      "size" => '12',
      "sides" => 2,
      "speed" => "33 1/3",
      "jacket_type" => "Standard Jacket",
      "inner_sleeve" => "White Paper",
      "insert" => "No",
      "packaging" => "None",
      "download_cards" => "None",
      "marketing_stickers" => "None",
      "tests" => "Yes",
      "labels" => "Yes",
      "center_hole" => "Big",
    ],
    "variant_default_opts" => [
      "number" => 300,
      "style" => "Standard Black",
      "colour" => "Black",
      "colour_1_2" => "Cherry",
      "colour_in_colour" => "SoftPink",
      "weight" => "140g",
      "splater" => "no",

      "style2" => "Standard Black",
      "colour2" => "Black",
      "colour_2_2" => "Cherry",
      "colour_in_colour2" => "SoftPink",
      "weight2" => "140g",
      "splater2" => "no",

      "style3" => "Standard Black",
      "colour3" => "Black",
      "colour_3_2" => "Cherry",
      "colour_in_colour3" => "SoftPink",
      "weight3" => "140g",
      "splater3" => "no",
    ],
    "product_pricing_custom_tag_price_rules" => [], 
    "product_pricing_total_price_foreach_variant" => "",
    "product_pricing_custom_tag_price_total_rules" => [],
    "product_pricing_total_price" => "@{TOTAL_ALL_Variants_Price}"];

  $pricingSettings = get_post_meta((int) $id, 'product_pricing_custom_settings', true);
  $pricingSettings = $pricingSettings ? $pricingSettings : $default;

  return empty($name) 
    ? $pricingSettings 
    : (isset($pricingSettings[$name]) ? $pricingSettings[$name] : null);
}

/*
function clamdown_child_woo_is_product_pricing_mode_handle() {
  if(is_product() == true) {
    global $post; 
    $product = wc_get_product($post);
    $enable_pricing_mode = clampdown_child_woo_get_product_pricing_settings($product->get_id(), 'enable_pricing_mode');

    if($enable_pricing_mode == 'true' || $enable_pricing_mode == true) {
      remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
      remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);

      add_action('woocommerce_single_product_summary', 'clampdown_child_woo_product_pricing_custom_form', 32);
    }
  }
} 

add_action('wp_head', 'clamdown_child_woo_is_product_pricing_mode_handle');
*/

function clampdown_child_woo_product_pricing_custom_form($product_id = 0) {
  $wpnonce = wp_create_nonce( 'add-request-quote-' . $product_id );
  ?>
  <div 
    id="PRODUCT_PRICING_MODE_APP" 
    data-product-id="<?php echo $product_id ?>" 
    data-wp_nonce="<?php echo $wpnonce ?>" >
    <!-- Content render by React -->
  </div> <!-- #PRODUCT_PRICING_MODE_APP -->
  <?php 
}

add_action('clampdown-child/woo/custom-product-single-content', 'clampdown_child_woo_product_pricing_custom_form');

function clamdown_child_woo_product_single_content() {
  if(is_product() == true) {
    global $post;
    $product = wc_get_product($post);
    $enable_pricing_mode = clampdown_child_woo_get_product_pricing_settings($product->get_id(), 'enable_pricing_mode');
    
    if($enable_pricing_mode === 'true' || $enable_pricing_mode === true) {
      /**
       * Hook clampdown-child/woo/custom-product-single-content
       * 
       * @see clampdown_child_woo_product_pricing_custom_form - 20
       */
      do_action('clampdown-child/woo/custom-product-single-content', $product->get_id());
    } else {
      load_template(CLAMPDOWN_DIR . '/templates/woo/product-single-content.php', false);
    }
  }
}

{
  /**
   * ywraq custom hook
   * 
   */

  function clampdown_child_woo_add_pricing_data_to_raq_item($raq, $product_raq) {
    if(isset($product_raq['pricing_data']) && isset($product_raq['pricing_total'])) {
      $raq['pricing_data'] = $product_raq['pricing_data'];
      $raq['pricing_total'] = $product_raq['pricing_total'];
    }
    return $raq; 
  }

  add_filter('ywraq_add_item', 'clampdown_child_woo_add_pricing_data_to_raq_item', 20, 2); 

  function clampdown_child_woo_render_request_quote_pricing_data_item($raq, $show_more = true) {
    if(!isset($raq['pricing_data']) && !isset($raq['pricing_total'])) return;

    set_query_var('pricing_data', $raq['pricing_data']);
    set_query_var('pricing_total_price', $raq['pricing_total']);
    set_query_var('show_more', $show_more);

    load_template(CLAMPDOWN_DIR . '/templates/woo/request-quote-pricing-data.php', false);
  }

  add_action('clampdown_child/request_quote/custom_name_item_after', 'clampdown_child_woo_render_request_quote_pricing_data_item', 20);

  function clampdown_child_woo_render_raq_variants_by_sides($variants = [], $sides = 0) {
    if(count($variants) == 0) return;
    // var_dump($variants);
    foreach($variants as $index => $item) {
      echo '<ul class="variant-item">';
      ?>
      <li class="product-pricing-data-list__item"><strong>#<?php echo $index + 1; ?></strong></li>
      <li class="product-pricing-data-list__item"><span><?php _e('Number:', 'clampdown-child') ?></span> <?php echo $item['number'] ?></li>
      <li class="product-pricing-data-list__item __divider"><b>A/B</b> <hr /></li>
      <?php clampdown_child_woo_render_sub_variants($item['style'], [
        'colour' => $item['colour'],
        'colour2' => $item['colour_1_2'],
        'weight' => $item['weight'],
        'useSplatter' => $item['splatter'],
        'splatterImage' => $item['splatter_image'],
        'colourInColour' => $item['colour_in_colour'],
      ]); ?>
      <?php
      if(in_array($sides, [4, 6, '4', '6'])) {
      ?>
      <li class="product-pricing-data-list__item __divider"><b>C/D</b> <hr /></li>
      <?php clampdown_child_woo_render_sub_variants($item['style2'], [
        'colour' => $item['colour2'],
        'colour2' => $item['colour_2_2'],
        'weight' => $item['weight2'],
        'useSplatter' => $item['splatter2'],
        'splatterImage' => $item['splatter_image2'],
        'colourInColour' => $item['colour_in_colour2'],
      ]); ?>
      <?php
      }

      if(in_array($sides, [6, '6'])) {
      ?>
      <li class="product-pricing-data-list__item __divider"><b>E/F</b> <hr /></li>
      <?php clampdown_child_woo_render_sub_variants($item['style3'], [
        'colour' => $item['colour3'],
        'colour2' => $item['colour_3_2'],
        'weight' => $item['weight3'],
        'useSplatter' => $item['splatter3'],
        'splatterImage' => $item['splatter_image3'],
        'colourInColour' => $item['colour_in_colour3'],
      ]); ?>
      <?php
      }
      echo '</ul>';
    }
  }

  /**
   * @param String $style
   * @param Array $args
   *  colour, colour2, weight, useSplatter, splatterImage
   */
  function clampdown_child_woo_render_sub_variants($style, $args = []) {
    $useSplatter = $args['useSplatter'];
    switch($style) {
      case 'Standard Black': 
        ?>
        <li class="product-pricing-data-list__item"><span><?php _e('Style:', 'clampdown-child') ?></span> <?php echo $style ?></li>
        <li class="product-pricing-data-list__item"><span><?php _e('Weight:', 'clampdown-child') ?></span> <?php echo $args['weight'] ?></li>
        <li class="product-pricing-data-list__item"><span><?php _e('Splatter:', 'clampdown-child') ?></span> <?php echo $useSplatter ?></li>
        <?php if($useSplatter == 'yes') { ?>
        <li class="product-pricing-data-list__item"><span><?php _e('Splatter Colour:', 'clampdown-child') ?></span> <?php echo $args['splatterImage'] ?></li>
        <?php } ?>
        <?php
        break;

      case 'Colour': 
        ?>
        <li class="product-pricing-data-list__item"><span><?php _e('Style:', 'clampdown-child') ?></span> <?php echo $style ?></li>
        <li class="product-pricing-data-list__item"><span><?php _e('Colour:', 'clampdown-child') ?></span> <?php echo $args['colour'] ?></li>
        <li class="product-pricing-data-list__item"><span><?php _e('Weight:', 'clampdown-child') ?></span> <?php echo $args['weight'] ?></li>
        <li class="product-pricing-data-list__item"><span><?php _e('Splatter:', 'clampdown-child') ?></span> <?php echo $useSplatter ?></li>
        <?php if($useSplatter == 'yes') { ?>
        <li class="product-pricing-data-list__item"><span><?php _e('Splatter Colour:', 'clampdown-child') ?></span> <?php echo $args['splatterImage'] ?></li>
        <?php } ?>
        <?php
        break;

      case 'Split': 
      case 'Smash': 
      case 'Clash': 
        ?>
        <li class="product-pricing-data-list__item"><span><?php _e('Style:', 'clampdown-child') ?></span> <?php echo $style ?></li>
        <li class="product-pricing-data-list__item"><span><?php _e('Colour:', 'clampdown-child') ?></span> <?php echo $args['colour'] ?></li>
        <li class="product-pricing-data-list__item"><span><?php _e('Colour 2:', 'clampdown-child') ?></span> <?php echo $args['colour2'] ?></li>
        <li class="product-pricing-data-list__item"><span><?php _e('Weight:', 'clampdown-child') ?></span> <?php echo $args['weight'] ?></li>
        <li class="product-pricing-data-list__item"><span><?php _e('Splatter:', 'clampdown-child') ?></span> <?php echo $useSplatter ?></li>
        <?php if($useSplatter == 'yes') { ?>
        <li class="product-pricing-data-list__item"><span><?php _e('Splatter Colour:', 'clampdown-child') ?></span> <?php echo $args['splatterImage'] ?></li>
        <?php } ?> 
        <?php
        break; 

      case 'Color In Color':
        // colourInColour
        ?>
        <li class="product-pricing-data-list__item"><span><?php _e('Style:', 'clampdown-child') ?></span> <?php echo $style ?></li>
        <li class="product-pricing-data-list__item"><span><?php _e('Colour:', 'clampdown-child') ?></span> <?php echo $args['colour'] ?></li>
        <li class="product-pricing-data-list__item"><span><?php _e('Colour In Colour:', 'clampdown-child') ?></span> <?php echo $args['colourInColour'] ?></li>
        <li class="product-pricing-data-list__item"><span><?php _e('Weight:', 'clampdown-child') ?></span> <?php echo $args['weight'] ?></li>
        <li class="product-pricing-data-list__item"><span><?php _e('Splatter:', 'clampdown-child') ?></span> <?php echo $useSplatter ?></li>
        <?php if($useSplatter == 'yes') { ?>
        <li class="product-pricing-data-list__item"><span><?php _e('Splatter Colour:', 'clampdown-child') ?></span> <?php echo $args['splatterImage'] ?></li>
        <?php } ?>
        <?php
        break;

      defaut: 
        ?>
        <li class="product-pricing-data-list__item"><span><?php _e('#Undefined', 'clampdown-child') ?></span> #Undefined</li>
        <?php
        break;
    }
  }

  function clampdown_child_woo_render_sub_variants_pdf($style, $args = []) {
    $useSplatter = $args['useSplatter'];
    switch($style) {
      case 'Standard Black': 
        ?>
        <tr>
          <td></td>
          <td>↳ <?php _e('Style:', 'clampdown-child') ?> <?php echo $style; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <tr>
          <td></td>
          <td>↳ <?php _e('Weight:', 'clampdown-child') ?> <?php echo $args['weight']; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <tr>
          <td></td>
          <td>↳ <?php _e('Splatter:', 'clampdown-child') ?> <?php echo $useSplatter; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <?php if($useSplatter == 'yes') { ?>
        <tr>
          <td></td>
          <td>↳ <?php _e('Splatter Colour:', 'clampdown-child') ?> <?php echo $args['splatterImage']; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <?php } ?>
        <?php
        break;

      case 'Colour': 
        ?>
        <tr>
          <td></td>
          <td>↳ <?php _e('Style:', 'clampdown-child') ?> <?php echo $style; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <tr>
          <td></td>
          <td>↳ <?php _e('Colour:', 'clampdown-child') ?> <?php echo $args['colour']; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <tr>
          <td></td>
          <td>↳ <?php _e('Weight:', 'clampdown-child') ?> <?php echo $args['weight']; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <tr>
          <td></td>
          <td>↳ <?php _e('Splatter:', 'clampdown-child') ?> <?php echo $useSplatter; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <?php if($useSplatter == 'yes') { ?>
        <tr>
          <td></td>
          <td>↳ <?php _e('Splatter Colour:', 'clampdown-child') ?> <?php echo $args['splatterImage']; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <?php } ?>
        <?php
        break;

      case 'Split': 
      case 'Smash': 
      case 'Clash': 
        ?>
        <tr>
          <td></td>
          <td>↳ <?php _e('Style:', 'clampdown-child') ?> <?php echo $style; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <tr>
          <td></td>
          <td>↳ <?php _e('Colour:', 'clampdown-child') ?> <?php echo $args['colour']; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <tr>
          <td></td>
          <td>↳ <?php _e('Colour 2:', 'clampdown-child') ?> <?php echo $args['colour2']; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <tr>
          <td></td>
          <td>↳ <?php _e('Weight:', 'clampdown-child') ?> <?php echo $args['weight']; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <tr>
          <td></td>
          <td>↳ <?php _e('Splatter:', 'clampdown-child') ?> <?php echo $useSplatter; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <?php if($useSplatter == 'yes') { ?>
        <tr>
          <td></td>
          <td>↳ <?php _e('Splatter Colour:', 'clampdown-child') ?> <?php echo $args['splatterImage']; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <?php } ?>
        <?php
        break; 

      case 'Color In Color':
        ?>
        <tr>
          <td></td>
          <td>↳ <?php _e('Style:', 'clampdown-child') ?> <?php echo $style; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <tr>
          <td></td>
          <td>↳ <?php _e('Colour:', 'clampdown-child') ?> <?php echo $args['colour']; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <tr>
          <td></td>
          <td>↳ <?php _e('Colour In Colour:', 'clampdown-child') ?> <?php echo $args['colourInColour']; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <tr>
          <td></td>
          <td>↳ <?php _e('Weight:', 'clampdown-child') ?> <?php echo $args['weight']; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <tr>
          <td></td>
          <td>↳ <?php _e('Splatter:', 'clampdown-child') ?> <?php echo $useSplatter; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <?php if($useSplatter == 'yes') { ?>
        <tr>
          <td></td>
          <td>↳ <?php _e('Splatter Colour:', 'clampdown-child') ?> <?php echo $args['splatterImage']; ?></td>
          <td></td><td></td><td></td>
        </tr>
        <?php } ?>
        <?php
        break;

      defaut: 
        ?>
        <tr>
          <td></td>
          <td>↳ <?php _e('#Undefined:', 'clampdown-child') ?> #Undefined</td>
          <td></td><td></td><td></td>
        </tr>
        <?php
        break;
    }
  }

  function clampdown_child_woo_add_custom_meta_pricing_after_created_order($order_id, $post_data, $raq) {
    if(isset($raq['raq_content']) && count($raq['raq_content']) > 0) {
      $raq_content = $raq['raq_content'];
      $pricing_products = [];

      foreach($raq_content as $key => $item) {
        if(isset($item['pricing_total']) && isset($item['pricing_data'])) {
          $item['__key'] = $key;
          array_push($pricing_products, $item);
        }
      }

      /**
       * Has pricing product
       */
      if(count($pricing_products) > 0)
        update_post_meta($order_id, '_pricing_order_data', $pricing_products);
    }

    return $order_id;
  }
  
  add_action('ywraq_after_create_order', 'clampdown_child_woo_add_custom_meta_pricing_after_created_order', 20, 3);

  function clampdown_child_woo_find_pricing_item($pid, $pricing_order_data) {
    $found_key = array_search($pid, array_column($pricing_order_data, 'product_id'));
    return isset($pricing_order_data[$found_key]) ? $pricing_order_data[$found_key] : false;
  }

  function clampdown_child_woo_pricing_data_after_order_itemmeta($item_id, $item, $product) {
    $product_id = $product->get_id();
    $order_id = get_the_ID();
    if(!$order_id) return;

    $pricing_order_data = get_post_meta($order_id, '_pricing_order_data', true);
    if(empty($pricing_order_data) || count($pricing_order_data) == 0) return; 
    
    $pricing_data = clampdown_child_woo_find_pricing_item($product_id, $pricing_order_data);
    if($pricing_data == false) return;

    clampdown_child_woo_render_request_quote_pricing_data_item($pricing_data, $show_more = false);
  }

  add_action('woocommerce_after_order_itemmeta', 'clampdown_child_woo_pricing_data_after_order_itemmeta', 20, 3);

  /**
   * Override price subtotal product pricing order
   * 
   */
  function clampdown_child_woo_custom_raq_cart_to_order_args($args, $cart_item_key, $values, $new_cart) {
    // wp_send_json([$args, $cart_item_key, $values, $new_cart]);
    /**
     * Checl pricing product data
     * 
     */
    if(isset($values['pricing_total'])) {
      $pricing_total = $values['pricing_total'];
      $qty = (int) $values['quantity'];
      $args['totals']['subtotal'] = floatval($pricing_total);
      $args['totals']['total'] = number_format(floatval($pricing_total) * $qty, 2);
    }
    
    return $args;
  }

  add_filter('ywraq_cart_to_order_args', 'clampdown_child_woo_custom_raq_cart_to_order_args', 20, 4);

  function clampdown_child_woo_more_info_product_pricing_order_item($item_id, $item, $order) {
    $order_id = $order->get_id();
    $pricing_order_data = get_post_meta($order_id, '_pricing_order_data', true);
    $product_id = $item['product_id'];
    if(empty($pricing_order_data) || count($pricing_order_data) == 0) return; 

    $pricing_data = clampdown_child_woo_find_pricing_item($product_id, $pricing_order_data);
    if($pricing_data == false) return;

    clampdown_child_woo_render_request_quote_pricing_data_item($pricing_data, $show_more = true);
  }

  add_action('woocommerce_order_item_meta_end', 'clampdown_child_woo_more_info_product_pricing_order_item', 20, 3);
}

function clampdown_child_woo_raq_pdf_info_pricing($product_id = 0, $order_id = 0) {
  if($order_id == 0 || $product_id == 0) return;

  $pricing_order_data = get_post_meta($order_id, '_pricing_order_data', true);
  if(empty($pricing_order_data) || count($pricing_order_data) == 0) return; 
  
  $pricing_data = clampdown_child_woo_find_pricing_item($product_id, $pricing_order_data);
  if($pricing_data == false) return;

  set_query_var('pricing_data', $pricing_data['pricing_data']);
  load_template(CLAMPDOWN_DIR . '/templates/order-pdf-path/info-pricing.php', false);
}

add_action('request_quote_pdf_after_tr_item', 'clampdown_child_woo_raq_pdf_info_pricing', 20, 2);

function clampdown_child_woo_raq_pdf_footer($order_id) {
  ?>
  <div class="raq-pdf-tc">
    <h4><?php _e('Terms & Conditions', 'clampdown-child') ?></h4>
    <p><?php _e('- Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec fermentum porta eros eu imperdiet.', 'clampdown-child'); ?></p>
    <p><?php _e('- Pellentesque lobortis sagittis velit, non finibus dolor congue a.', 'clampdown-child') ?></p>
    <p><?php _e('- Donec interdum posuere auctor.', 'clampdown-child') ?></p>
  </div>
  <div class="raq-pdf-footer">
    <div class="f-logo">
      <img src="<?php echo CLAMPDOWN_DIR . '/images/footer-logo.png'; ?>" width="100px" />
    </div>
    <div class="f-text">
      <?php _e('Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...', 'clampdown-child') ?> 
    </div>
  </div>
  <?php 
}

add_action('yith_ywraq_quote_template_footer', 'clampdown_child_woo_raq_pdf_footer', 20);

function clmapdown_child_woo_register_variant_record_images_settings() {
  add_submenu_page(
    'woocommerce', 
    __('Record Images 💿', 'clampdown-child'),
    __('Record Images 💿', 'clampdown-child'),
    'manage_options',
    'record-images-settings',
    'clampdown_child_woo_variant_record_images_settings_callback');
} 

// add_action('admin_menu', 'clmapdown_child_woo_register_variant_record_images_settings', 99);

function clampdown_child_woo_variant_record_images_settings_callback() {
  ?>
  <div id="VARIANT_RECORD_IMAGES_SETTINGS">
    <!-- React render -->
  </div> <!-- #VARIANT_RECORD_IMAGES_SETTINGS -->
  <?php
}

function clampdown_child_create_new_order_button() {
  ?>
  <div class="new-order-buttons">
    <a href="/pricing" target="_blank" class="button theme-button">
      <span class="__icon"><?php echo clampdown_svg('order'); ?></span>
      <?php _e('New Order', 'clampdown-child') ?>
    </a>
  </div>
  <?php 
}

add_action('woocommerce_before_account_orders', 'clampdown_child_create_new_order_button');

{
  function clampdown_child_my_account_remove_some_link($menu_links) {
    unset($menu_links['downloads']);
    unset($menu_links['make-a-secure-payment']);
    unset($menu_links['upgrade-to-priority']);
    unset($menu_links['update-payment-method']);
    return $menu_links;
  }

  add_filter ( 'woocommerce_account_menu_items', 'clampdown_child_my_account_remove_some_link', 40 );

  /**
   * Add My Account Custom Link 
   */

  function clampdown_child_my_account_add_custom_link($menu_links){
    $pos = 4;
    $newItem = [
      'upload-submit-files' => __('Upload / Submit Files', 'clampdown-child'),
      'make-a-secure-payment' => __('Make a Secure Payment', 'clampdown-child'),
      'upgrade-to-priority' => __('Upgrade To Priority?', 'clampdown-child'),
    ];
    $menu_links = array_slice($menu_links, 0, $pos) + $newItem + array_slice($menu_links, $pos);

    $pos = 7;
    $newItem = [
      'update-payment-method' => __('Update Payment Method', 'clampdown-child'),
      'tax-exemption' => __('Tax Exemption', 'clampdown-child'),
      'submit-general-inquiry' => __('Submit General Inquiry', 'clampdown-child'),
    ];
    $menu_links = array_slice($menu_links, 0, $pos) + $newItem + array_slice($menu_links, $pos);

    return $menu_links;

  }

  add_filter ( 'woocommerce_account_menu_items', 'clampdown_child_my_account_add_custom_link', 30 );

  function clampdown_child_woo_add_custom_endpoint() {
    // WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
    add_rewrite_endpoint('upload-submit-files', EP_PAGES);
    add_rewrite_endpoint('make-a-secure-payment', EP_PAGES);
    add_rewrite_endpoint('upgrade-to-priority', EP_PAGES);
    add_rewrite_endpoint('update-payment-method', EP_PAGES);
    add_rewrite_endpoint('tax-exemption', EP_PAGES);
    add_rewrite_endpoint('submit-general-inquiry', EP_PAGES);

  }

  add_action('init', 'clampdown_child_woo_add_custom_endpoint');

  function clampdown_child_woo_my_account_upload_submit_files_endpoint_content() {
    // of course you can print dynamic content here, one of the most useful functions here is get_current_user_id()
    // _e('Upload / Submit Files...!', 'clampdown-child');
    load_template(CLAMPDOWN_DIR . '/templates/woo/my-account/upload-submit-files.php', false);
  }

  add_action( 'woocommerce_account_upload-submit-files_endpoint', 'clampdown_child_woo_my_account_upload_submit_files_endpoint_content' );
  
  function clampdown_child_woo_my_account_make_a_secure_payment_endpoint_content() {
    // of course you can print dynamic content here, one of the most useful functions here is get_current_user_id()
    // _e('Make a Secure Payment...!', 'clampdown-child');
    load_template(CLAMPDOWN_DIR . '/templates/woo/my-account/make-a-secure-payment.php', false);
  }

  add_action( 'woocommerce_account_make-a-secure-payment_endpoint', 'clampdown_child_woo_my_account_make_a_secure_payment_endpoint_content' );

  function clampdown_child_woo_my_account_upgrade_to_priority_endpoint_content() {
    // of course you can print dynamic content here, one of the most useful functions here is get_current_user_id()
    _e('Upgrade To Priority?', 'clampdown-child');
  }

  add_action( 'woocommerce_account_upgrade-to-priority_endpoint', 'clampdown_child_woo_my_account_upgrade_to_priority_endpoint_content' );

  function clampdown_child_woo_my_account_update_payment_method_endpoint_content() {
    // of course you can print dynamic content here, one of the most useful functions here is get_current_user_id()
    _e('Update Payment Method...!', 'clampdown-child');
  }

  add_action( 'woocommerce_account_update-payment-method_endpoint', 'clampdown_child_woo_my_account_update_payment_method_endpoint_content' );

  function clampdown_child_woo_my_account_tax_exemption_endpoint_content() {
    // of course you can print dynamic content here, one of the most useful functions here is get_current_user_id()
    _e('Tax Exemption...!', 'clampdown-child');
  }

  add_action( 'woocommerce_account_tax-exemption_endpoint', 'clampdown_child_woo_my_account_tax_exemption_endpoint_content' );

  function clampdown_child_woo_my_account_submit_general_inquiry_endpoint_content() {
    // of course you can print dynamic content here, one of the most useful functions here is get_current_user_id()
    _e('Submit General Inquiry...!', 'clampdown-child');
  }

  add_action( 'woocommerce_account_submit-general-inquiry_endpoint', 'clampdown_child_woo_my_account_submit_general_inquiry_endpoint_content' );

  /**
   * End
   */
}

/**
 * Render choices options orders by user ID
 * 
 * @param Int $userID
 * @return Array 
 */
function clampdown_child_woo_render_option_orders_by_user($userID = 0) {
  $allStatus = wc_get_order_statuses();
  $orders = wc_get_orders([
    'limit' => -1,
    'customer_id' => $userID,
  ]);

  if(!$orders || count($orders) <= 0) return;
  $result = [];

  foreach($orders as $key => $o) {
    $o_status = $allStatus['wc-' . $o->get_status()];
    $o_date = date('F j, Y g:i a', strtotime($o->get_date_created()));
    $label = sprintf('#%s - %s(%s) / %s / %s', $o->get_id(), $o->get_total(), $o->get_currency(), $o_date, $o_status);
    $opt = [
      'text' => $label,
      'value' => $o->get_id()
    ];

    if($key == 0) {
      $opt['selected'] = 1;
    }

    array_push($result, $opt);
  }

  return $result;
}

function clampdown_child_render_opts_order_gform($form) {
  foreach ( $form['fields'] as &$field ) {
    if ( $field->type != 'select' || strpos( $field->cssClass, 're-render-options-orders-by-current-user' ) === false ) {
      continue;
    }

    $field->placeholder = __('Select your order', 'clampdown-child');
    $field->choices = clampdown_child_woo_render_option_orders_by_user(get_current_user_id());
  }

  return $form;
}

add_filter('gform_pre_render_1', 'clampdown_child_render_opts_order_gform');
add_filter('gform_pre_validation_1', 'clampdown_child_render_opts_order_gform');
add_filter('gform_pre_submission_filter_1', 'clampdown_child_render_opts_order_gform');
add_filter('gform_admin_pre_render_1', 'clampdown_child_render_opts_order_gform');

add_filter('gform_pre_render_2', 'clampdown_child_render_opts_order_gform');
add_filter('gform_pre_validation_2', 'clampdown_child_render_opts_order_gform');
add_filter('gform_pre_submission_filter_2', 'clampdown_child_render_opts_order_gform');
add_filter('gform_admin_pre_render_2', 'clampdown_child_render_opts_order_gform');

function clampdown_child_woo_raq_after_create_order($order_id, $POST, $raq) {
  $order = new WC_Order($order_id);
  $order->update_status('ywraq-accepted');
  update_post_meta($order_id, '_ywraq_deposit_enable', 1); // enable deposit
  update_post_meta($order_id, '_ywraq_deposit_rate', 50); // set deposit rate 50%
}

add_action('ywraq_after_create_order', 'clampdown_child_woo_raq_after_create_order', 20, 3);

function clampdown_child_woo_raq_custom_thanks_message($message, $new_order, $quote_number_link) {
  $order = new WC_Order($new_order);
  ob_start();
  ?>
  <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay">
    <?php esc_html_e('Pay Now', 'clampdown-child'); ?>
  </a>
  <?php 
  $buttonGoCheckout = ob_get_clean();
  $message .= $buttonGoCheckout;
  return $message;
}

add_filter('ywraq_simple_thank_you_message', 'clampdown_child_woo_raq_custom_thanks_message', 20, 3);
// add_action('init', function() {
//   if(!isset($_GET['dev'])) return;
//   update_post_meta(211, '_ywraq_deposit_enable', 1);
//   update_post_meta(211, '_ywraq_deposit_rate', 50);
// });

add_action('wp_head', function() {
  if( is_shop() ) :

    wp_redirect('/pricing');

  endif;
});

function clampdown_child_woo_add_custom_email_format_string($string, $email) {
  $placeholder = '{order_id}'; // The corresponding placeholder to be used
  $order = $email->object; // Get the instance of the WC_Order Object
  $value = $order ? $order->get_id() : ''; // Get the value

  // Return the clean replacement value string for "{order_id}" placeholder
  return str_replace($placeholder, $value, $string);
}

add_filter('woocommerce_email_format_string' , 'clampdown_child_woo_add_custom_email_format_string', 10, 2);