<?php
/**
 * Custom woocommerce payment integration by Creative Transmissions
 *
 * @since      1.0.0
 * @package    CT_WOOCOMMERCE
 * @subpackage CT_WOOCOMMERCE/includes
 * @author     Andrew van Duivenbode <andrew@creativetransmissions.com>
*/
class CT_WOOCOMMERCE {

	/**
	 * The domain specified for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $domain    The domain identifier for this plugin.
	 */
	private $domain;

	public function __construct($config = array()) {

		add_action( 'wc_add_to_cart_message_html', '__return_null' );
		add_action( 'woocommerce_add_to_cart_validation', array( $this, 'woocommerce_single_cart_item' ));
		add_action( 'woocommerce_add_to_cart_redirect', array( $this, 'skip_woocommerce_cart'));
		add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'update_jobid_on_checkout'));
		add_action( 'woocommerce_payment_complete_order_status', array( $this, 'mark_order_complete'));
		add_action( 'woocommerce_thankyou', array( $this, 'payment_success_redirect'));
		add_action( 'woocommerce_before_checkout_form', array( $this, 'woocommerce_checkout_autocomplete'));

	}

	public function add_transitquote_product(){
		
	}

	public function get_product_id(){
		//send woocommerce product id
		$args = array(
		 'post_type' => 'product',
		 'posts_per_page' => 1);
		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) : $loop->the_post(); global $product; 
			$product_id .= get_the_id();
		endwhile;
		wp_reset_query();
		return $product_id;
	}
	
	//empty cart before adding product
	public function woocommerce_single_cart_item( $cart_item_data ) {
		global $woocommerce;
		$woocommerce->cart->empty_cart();	 
		return true;
	}
	
	//skip cart page
	public function skip_woocommerce_cart() {
	 global $woocommerce;
	 $checkout_url = wc_get_checkout_url();
	 return $checkout_url;
	}
	
	//sets jobid to order meta
	public function update_jobid_on_checkout ( $order_id, $posted ) {
		if(isset($_SESSION['job_id'])) {
			$order = wc_get_order( $order_id );
			$order->update_meta_data( 'job_id', $_SESSION['job_id'] );
			$order->save();
		}
	}
	
	//skips order status processing
	public function mark_order_complete( $order_status, $order_id ) {
 
		 $order = new WC_Order( $order_id );
		 if ( 'processing' == $order_status && ( 'on-hold' == $order->status || 'pending' == $order->status || 'failed' == $order->status ) ) {
			return 'completed';
		 }
		 return $order_status;
	}

	//redirects to thankyou page on order complete
	public function payment_success_redirect( $order_id ){
		$options = get_option('tq_pro_paypal_options');
		$redirect_page_id = $options['redirect_page_after_payment'];
		
		$order = new WC_Order( $order_id );
		$redirect_page_url = get_permalink($redirect_page_id);
		if ( $order->status != 'failed' && $redirect_page_url!='') {
			wp_redirect($redirect_page_url);
			exit;
		}
	}

	public function woocommerce_checkout_autocomplete() {
		if(isset($_SESSION['billing_first_name'])) {
			$_POST['billing_first_name'] = $_SESSION['billing_first_name'];
			$_POST['billing_last_name'] = $_SESSION['billing_last_name'];
			$_POST['billing_phone'] = $_SESSION['billing_phone'];
			$_POST['billing_email'] = $_SESSION['billing_email'];
			$_POST['order_comments'] = $_SESSION['order_comments'];
		}
	}
}
