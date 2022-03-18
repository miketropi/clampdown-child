<?php
/**
 * Custom Woo
 * 
 */

/**
 * Woo enqueue scripts
 */
function clampdown_child_woo_enqueue_scripts() {
  wp_enqueue_script('clamdown-child-woo-script', CLAMPDOWN_URI . '/dist/woofrontend.clampdown.bundle.js', ['jquery'], CLAMPDOWN_VER, true);

  wp_localize_script('clamdown-child-woo-script', 'CLAMPDOWN_PHP_WOO_DATA', [
    'ajax_url' => admin_url('admin-ajax.php'),
    'lang' => []
  ]);
}

add_action('wp_enqueue_scripts', 'clampdown_child_woo_enqueue_scripts', 30);

/**
 * Backend enqueue scripts 
 */
function clampdown_child_woo_admin_enqueue_scripts() {
  wp_enqueue_style('clamdown-child-admin-woo-style', CLAMPDOWN_URI . '/dist/woobackend.clampdown.bundle.css', false, CLAMPDOWN_VER);
  wp_enqueue_script('clamdown-child-admin-woo-script', CLAMPDOWN_URI . '/dist/woobackend.clampdown.bundle.js', ['jquery'], CLAMPDOWN_VER, true);

  wp_localize_script('clamdown-child-woo-script', 'CLAMPDOWN_PHP_ADMIN_WOO_DATA', [
    'lang' => [],
  ]);
}

add_action('admin_enqueue_scripts', 'clampdown_child_woo_admin_enqueue_scripts', 30);