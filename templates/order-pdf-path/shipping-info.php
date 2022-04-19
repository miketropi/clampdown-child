<?php 
/**
 * Variable from parent template 
 * Path: ~/themes/clampdown-child/woocommerce/pdf/quote-header.php
 * 
 */

$billing_info = [
  [
    'label' => __('Name:', 'clampdown-child'),
    'value' => $user_name,
  ],
  [
    'label' => __('Address:', 'clampdown-child'),
    'value' => $order->get_formatted_shipping_address(),
  ],
  [
    'label' => __('E-mail:', 'clampdown-child'),
    'value' => $user_email,
  ],
  [
    'label' => __('Phone:', 'clampdown-child'),
    'value' => $billing_phone,
  ],
];
?>
<div class="shipping-info-container" style="width: 45%;">
  <h4 class="info-title"><?php _e('Ship to', 'clampdown-child'); ?></h4>
  <div class="info-list">
    <?php foreach ($billing_info as $index => $item) {
      echo '<div class="info-item">
        <label>'. $item['label'] .'</label> '. $item['value'] .'
      </div>';
    } ?>
  </div>
</div>