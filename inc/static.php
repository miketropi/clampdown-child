<?php
/**
 * Static 
 * 
 */

function clampdown_enqueue_scripts() {
  wp_enqueue_style('clampdown-childtheme-style', CLAMPDOWN_URI . '/dist/frontend.clampdown.bundle.css', false, CLAMPDOWN_VER);
  wp_enqueue_script('clampdown-childtheme-script', CLAMPDOWN_URI . '/dist/frontend.clampdown.bundle.js', ['jquery'], CLAMPDOWN_VER, true); 

  wp_localize_script('clampdown-childtheme-js', 'CLAMPDOWN_PHP_DATA', [
    'ajaxurl' => admin_url('admin-ajax.php'),
    'lang' => [],
  ]);
}

add_action('wp_enqueue_scripts', 'clampdown_enqueue_scripts');