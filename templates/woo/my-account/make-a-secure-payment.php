<?php 
/**
 * Make a secure payment
 */

?>

<h2 class="my-account-page-title"><?php _e('Make a Secure Payment', 'clampdown-child') ?></h2>

<?php
clampdown_child_message_tag(
  __('ℹ️ Note', 'clampdown-child'),
  wpautop(__('Need to make a payment? Enter your details here to have your payment credited to your order', 'clampdown-child')),
);
?>

<div style="margin: 0 auto; max-width: 100%">
  <?php echo do_shortcode(get_field('make_a_secure_payment_gform', 'option')) ?>
</div>