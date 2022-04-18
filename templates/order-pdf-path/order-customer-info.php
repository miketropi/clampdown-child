<div class="admin_info">
	<table cellspacing="15" class="admin_info-table">
		<tr>
			<td valign="top"
				class="small-title"><?php echo esc_html( __( 'From', 'yith-woocommerce-request-a-quote' ) ); ?></td>
			<td valign="top" class="small-info">
				<p>
					<?php
					if ( 'yes' === get_option( 'ywraq_show_author_quote' ) ) :
						/**
						 * Current customer.
						 *
						 * @var $user WC_Customer
						 */
						$user = new WC_Customer( $order->get_meta( '_ywraq_author' ) );
						if ( $user ) :
							$name  = trim( $user->get_billing_first_name() . ' ' . $user->get_billing_last_name() );
							$email = trim( $user->get_billing_email() );
							$phone = trim( $user->get_billing_phone() );


							$from  = ! empty( $name ) ? $name . '<br>' : '';
							$from .= ! empty( $email ) ? $email . '<br>' : '';
							$from .= ! empty( $phone ) ? $phone . '<br>' : '';

							?>
							<?php echo ( trim( $from ) !== '' ) ? wp_kses_post( $from ) . '<br>' : ''; ?>
						<?php endif ?>
					<?php endif ?>

					<?php echo wp_kses_post( apply_filters( 'ywraq_pdf_info', nl2br( get_option( 'ywraq_pdf_info' ) ), $order ) ); ?>
				</p>
			</td>
		</tr>
		<tr>
			<td valign="top"
				class="small-title"><?php echo esc_html( __( 'Customer', 'yith-woocommerce-request-a-quote' ) ); ?></td>
			<td valign="top" class="small-info" style="word-wrap: break-word; word-break: break-all;">
				<p>
					<?php if ( empty( $billing_name ) && empty( $billing_surname ) ) : ?>
						<strong><?php echo esc_html( $user_name ); ?></strong>
						<?php
					endif;

					echo wp_kses_post( $formatted_address ) . '<br>';
					echo esc_html( "($user_email)" ) . '<br>';

					if ( '' !== $billing_phone ) {
						echo esc_html( $billing_phone ) . '<br>';
					}

					if ( '' !== $billing_vat ) {
						echo esc_html( $billing_vat ) . '<br>';
					}
					?>
				</p>
			</td>
		</tr>

		<?php if ( '' !== $order_date ) : ?>
			<tr>
				<td valign="top"
					class="small-title"><?php echo esc_html( __( 'Date created', 'yith-woocommerce-request-a-quote' ) ); ?></td>
				<td valign="top" class="small-info">
					<p><?php echo esc_html( $order_date ); ?></p>
				</td>
			</tr>
		<?php endif ?>

		<?php if ( '' !== $expiration_data ) : ?>
			<tr>
				<td valign="top"
					class="small-title"><?php echo esc_html( __( 'Expiration date', 'yith-woocommerce-request-a-quote' ) ); ?></td>
				<td valign="top" class="small-info">
					<p><strong><?php echo esc_html( $expiration_data ); ?></strong></p>
				</td>
			</tr>
		<?php endif ?>
	</table>
</div>