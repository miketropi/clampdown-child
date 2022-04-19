<?php
/**
 * Request Quote PDF Header
 *
 * @package YITH Woocommerce Request A Quote
 * @since   1.0.0
 * @version 3.0.0
 * @author  YITH
 *
 * @var $order    WC_Order
 * @var $raq_data array
 */

if ( function_exists( 'icl_get_languages' ) ) {
	global $sitepress;
	$lang = $order->get_meta( 'wpml_language' );
	if ( function_exists( 'wc_switch_to_site_locale' ) ) {
		wc_switch_to_site_locale();
	}
	YITH_Request_Quote_Premium()->change_pdf_language( $lang );
}

$order_id = $order->get_id();
$logo_url = get_option( 'ywraq_pdf_logo' );

$logo_attachment_id = apply_filters( 'yith_pdf_logo_id', get_option( 'ywraq_pdf_logo-yith-attachment-id' ) );


if ( ! $logo_attachment_id && $logo_url ) {
	$logo_attachment_id = attachment_url_to_postid( $logo_url );
}

$logo = $logo_attachment_id ? get_attached_file( $logo_attachment_id ) : $logo_url;
$image_type        = wp_check_filetype( $logo );
$mime_type         = array( 'image/jpeg', 'image/png' );
$logo              = apply_filters( 'ywraq_pdf_logo', ( isset( $image_type['type'] ) && in_array( $image_type['type'], $mime_type, true ) ) ? $logo : '' );
$user_name         = $order->get_meta( 'ywraq_customer_name' );
$user_email        = $order->get_meta( 'ywraq_customer_email' ); //phpcs:ignore
$formatted_address = $order->get_formatted_billing_address();
$billing_phone   = $order->get_meta( 'ywraq_billing_phone' );
$billing_name    = $order->get_meta( '_billing_first_name' );
$billing_surname = $order->get_meta( '_billing_last_name' );
$billing_phone   = $order->get_meta( 'ywraq_billing_phone' );
$billing_phone   = empty( $billing_phone ) ? $order->get_meta( '_billing_phone' ) : $billing_phone;
$billing_vat     = $order->get_meta( 'ywraq_billing_vat' );

$exdata = $order->get_meta( '_ywcm_request_expire' );
$expiration_data = '';

if ( function_exists( 'wc_format_datetime' ) ) {
	$order_date = wc_format_datetime( $order->get_date_created() );
	if ( ! empty( $exdata ) ) {
		try {
			$exdata = new WC_DateTime( $exdata );
		} catch ( Exception $e ) {
			$exdata = '';
		}
		$expiration_data = wc_format_datetime( $exdata );
	}
} else {
	$date_format     = isset( $raq_data['lang'] ) ? ywraq_get_date_format( $raq_data['lang'] ) : wc_date_format();
	$order_date      = date_i18n( $date_format, strtotime( $order->get_date_created() ) );
	$expiration_data = empty( $exdata ) ? '' : date_i18n( $date_format, strtotime( $exdata ) );
}

?>
<div class="logo">
  <?php require( CLAMPDOWN_DIR . '/templates/order-pdf-path/order-logo.php' ); ?>
</div>

<div class="heading-info">
  
  <div class="order-number-container">
    <div class="quote-title">
      <h2>
        <?php printf( 
          esc_html( __( 'Quote #%s', 'yith-woocommerce-request-a-quote' ) ), 
          esc_html( apply_filters( 'ywraq_quote_number', $order_id ) ) ); ?>
      </h2>
    </div>
  </div> <!-- .order-number-container -->
  
  <div class="order-info-container">
    <?php require( CLAMPDOWN_DIR . '/templates/order-pdf-path/order-customer-info.php' ); ?>
  </div> <!-- .order-info-container -->

</div> <!-- .heading-info -->

<div class="billing-shipping-container">
	<?php require( CLAMPDOWN_DIR . '/templates/order-pdf-path/billing-info.php'); ?>
	<?php require( CLAMPDOWN_DIR . '/templates/order-pdf-path/shipping-info.php'); ?>
</div>

<div class="clear"></div>