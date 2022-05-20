<?php
/**
 * Customer new account email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-new-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 6.0.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p>Welcome to Clampdown Record Pressing</p>

<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $user_login ) ); ?></p>

<p>Thanks for creating an account on Clampdown Record Pressing. Your username is <?php echo $user_login; ?>.</p>

<?php if ( 'yes' === get_option( 'woocommerce_registration_generate_password' ) && $password_generated && $set_password_url ) : ?>
	<?php // If the password has not been set by the user during the sign up process, send them a link to set a new password ?>
	<p><a href="<?php echo esc_attr( $set_password_url ); ?>"><?php printf( esc_html__( 'Click here to set your new password.', 'woocommerce' ) ); ?></a></p>
<?php endif; ?>

<p>When you're logged in to your account you can:</p>

<p>- Create new quotes and save them to your account to view later.<br />
- Click the pay now button on any of your quotes to pay a 50% deposit to get the order started<br />
- Follow along the status of any order in your account dashboard as we work to get your order completed<br />
- Upload and submit your audio and art files for your order<br />
- Manage your shipping addresses<br />
- Change your password<br />
- And more...</p>

<p>Access your account here: <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">My Account</a></p>

<p>Click here to set your new password.</p>

<p>We look forward to working with you soon!</p>

<p>Sincerely,<br />
Billy Bones and the Clampdown Team</p>

<?php
/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

do_action( 'woocommerce_email_footer', $email );
