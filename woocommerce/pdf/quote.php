<?php
/**
 * Request Quote PDF Wrapper fils
 *
 * @package YITH Woocommerce Request A Quote
 * @since   1.0.0
 * @version 3.0.0
 * @author  YITH
 *
 * @var int $order_id Order id.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
	<style type="text/css">
		body {
    
		}

		.logo {
			width: 100%;
			float: left;
			max-width: 300px;
      margin-bottom: 40px;
		}

		.right {
			float: right;
			width: 40%;
			text-align: right;
		}

		.clear {
			clear: both;
		}

		.admin_info {
			font-size: 18px;
		}

		table {
			border: 0;
		}

		table.quote-table {
			border: 0;
			font-size: 14px;
		}

		.small-title {
			text-align: right;
			font-weight: 600;
			/* color: #4e4e4e; */
      color: white;
			padding-top: 5px;
			padding-right: 5px;
      font-size: 14px;
      color: #e371b3;
      font-weight: bold;
		}
		.small-info{
			/* background: #a8c6e4;
			background: linear-gradient(360deg, #a8c6e4 0%, #ffffff 1%, #ffffff 100%); */
			padding-left:10px;
			margin-bottom: 20px;
      color: white;
      font-size: 14px;
		}
		.small-info p {
      color: white;
			padding: 0 0 5px 5px;
			margin-bottom: 20px;
      font-size: 14px;
		}

		.quote-table td {
			border: 0;
			border-bottom: 1px solid #eee;
		}

		.quote-table .with-border td {
			border-bottom: 2px solid #eee;
		}

		.quote-table .with-border td {
			border-top: 2px solid #eee;
		}

		.quote-table .quote-total td {
			height: 100px;
			vertical-align: middle;
			font-size: 16px;
			border-bottom: 0;
		}

		.quote-table small {
			font-size: 11px;
		}

		.quote-table .last-col {
			padding-right: 45px;
		}

		.quote-table .last-col.tot {
			font-weight: 600;
		}

		.quote-table .tr-wb {
			border-left: 1px solid #ccc;
			border-right: 1px solid #ccc;
		}

		.pdf-button {
			color: #a8c6e4;
			text-decoration: none;
		}

		div.content {
			padding-bottom: 100px;
			border-bottom: 1px
		}

		.ywraq-buttons{
			margin-top: 30px;
		}

		.footer {
			position: fixed;
			bottom: 0;
			text-align: center;
			font-size: 70%
		}

		.footer {
			width: 100%;
			text-align: center;
			position: fixed;
			bottom: 0;
		}

		<?php
    $template = get_option( 'ywraq_pdf_template', 'table' );
		if ( 'div' === $template ) :
    ?>
		/* div template style */
		.table-wrapper ul {
			list-style: none;
			margin: 0;
			padding: 0;
		}

		.table-wrapper * {
			box-sizing: border-box;
			font-size: 13px;
		}

		.quote-table.raq-header {
			border-bottom: 1px solid #ebebeb;
			margin: 5px 0;
			font-weight: 600;
		}

		.quote-table.raq-header li, .quote-table.raq-items .raq_item li {
			float: left;
			padding: 5px 0;
		}

		.fields-1 li {
			width: 100%;
		}

		.fields-2 li {
			width: 50%;
		}

		.fields-3 li {
			width: 33%;
		}

		.fields-4 li {
			width: 25%;
		}

		.fields-5 li {
			width: 20%;
		}

		.quote-table.raq-items > li {
			border-bottom: 1px solid #ebebeb;
			padding: 5px 0;
		}

		.quote-table.raq-items > li.with-metas {
			border: none;
		}


		.raq-totals .totals_label {
			text-align: right;
			padding-right: 10px !important;
			display: block;
			float: left;
			width: 90%;
		}

		.raq-totals li.totals_value{
			display: block;
			float: left;
		}

		.raq-totals {
			border-bottom: 1px solid #ebebeb;
		}

		ul.quote-table.raq-totals > li {
			text-align: right;
			display: block;

		}

		ul.quote-table.raq-totals >li >ul {
			display:block;
			float: right;
			clear: both;
			margin:10px 0;
		}


		.raq_item.metas ul.wc-item-meta li {
			float:none;
			width: 100%;
		}
		.wc-item-meta p {
			display: inline-block;
			padding: 0 !important;
			margin: 0;
		}

		.raq_item.metas ul.wc-item-meta li p, 
    .raq_item.metas ul.wc-item-meta li strong {
			line-height: 100%;
			vertical-align: middle;
			font-size: 11px;
		}
		.quote-table.raq-items li > ul > li {
			overflow: hidden !important;
			word-break: break-all
		}

		.quote-table.raq-items .raq_item li.item-subtotal,
		.quote-table.raq-items .raq_item li.item-quantity,
		.quote-table.raq-items .raq_item li.item-price,
		.quote-table.raq-header li.product-subtotal,
		.quote-table.raq-header li.product-quantity,
		.quote-table.raq-header li.product-price {
			text-align: right;
		}
    <?php endif; ?>

    .heading-info {
      display: inline-block;
      width: 100%;
      margin-bottom: 30px;
      background-color: #e5f5fd;
    }

    .order-number-container,
    .order-info-container {
      
    }

    .order-number-container {
      float: left;
      width: 45%; 
    }

    .order-info-container {
      float: right;
      background-color: black;
      color: white;
      width: 50%; 
    }

    .admin_info-table tr td {
      vertical-align: top !important;
      padding: 0;
    }

    .quote-title {
      padding: 30px 0 0 30px;
    }

		.billing-shipping-container {
			/* font-weight: 600; */
			margin-bottom: 50px;
		}
		
		.shipping-info-container {
			float: right;
		}

		.billing-info-container {
			float: left;
		}

		.billing-shipping-container .info-title {
			border-bottom: 2px solid black;
			margin-bottom: 10px;
			padding-bottom: 10px;
		}

		.info-list .info-item {
			padding: 2px 0;
			font-size: 14px;
			font-weight: bold;
		}

		.info-list .info-item label {

		}

		.__order-info-table thead tr th,
		.__order-info-table tbody tr td {
			padding: 10px;
			margin: 0;
			border: none;
		}

		.__order-info-table tbody tr:nth-child(even) td {
			background-color: #e5f5fd;
		}

		.__order-info-table thead tr th {
			color: white;
		}

		.text-right {
			text-align: right;
		}

		.raq-pdf-footer {
			border-top: solid 2px black;
			padding: 10px 0;
		}

		.f-logo {
			float: left;
			width: 30%;
		}

		.f-text {
			float: right;
			text-align: right;
			width: 70%;
			font-size: 12px;
		}

		.raq-pdf-tc {
			width: 80%;
			margin-bottom: 20px;
		}

		.raq-pdf-tc h4 {
			border-bottom: solid 2px black;
		}

		.raq-pdf-tc p {
			font-size: 12px;
			margin-bottom: 2px;
			line-height: normal;
			padding: 0;
		}
	</style>
	<?php

	do_action( 'yith_ywraq_quote_template_head' );
	?>
</head>

<body>
  <?php
  do_action( 'yith_ywraq_quote_template_header', $order_id );
  ?>
  <div class="content">
    <?php
    do_action( 'yith_ywraq_quote_template_content', $order_id );
    ?>
  </div>
  <?php
  do_action( 'yith_ywraq_quote_template_after_content', $order_id );
  ?>

  <?php
  do_action( 'yith_ywraq_quote_template_footer', $order_id );
  ?>
</body>
</html>
