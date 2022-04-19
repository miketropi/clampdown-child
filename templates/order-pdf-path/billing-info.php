<?php 
/**
 * Variable from parent template 
 * Path: ~/themes/clampdown-child/woocommerce/pdf/quote-header.php
 * 
 */

$billing_info = [
  [
    'label' => __('Name:', 'clampdown-child'),
    'value' => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(),
  ],
  [
    'label' => __('Company:', 'clampdown-child'),
    'value' => $order->get_billing_company(),
  ],
  [
    'label' => __('E-mail:', 'clampdown-child'),
    'value' => $order->get_billing_email(),
  ],
  [
    'label' => __('Phone:', 'clampdown-child'),
    'value' => $order->get_billing_phone(),
  ],
];
?>
<div class="billing-info-container" style="width: 45%;">
  <h4 class="info-title"><?php _e('Bill to', 'clampdown-child'); ?></h4>
  <div class="info-list">
    <?php foreach ($billing_info as $index => $item) {
      echo '<div class="info-item">
        <label>'. $item['label'] .'</label> '. $item['value'] .'
      </div>';
    } ?>
  </div>
</div>