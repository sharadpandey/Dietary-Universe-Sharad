<?php
/**
 * Utility class
 *
 * @package NeverSettle\WooCommerce-Amazon-Fulfillment
 * @since 2.0.0
 */

if ( ! class_exists( 'NS_FBA_Utils' ) ) {

	class NS_FBA_Utils {

		private $ns_fba;

		function __construct( $ns_fba ) {
			// local reference to the main ns_fba object
			$this->ns_fba = $ns_fba;
		}
		
		function is_configured() {
			
			// if it's already configured (like on save) then skip the tests
			//if ( $this->ns_fba->is_configured ) return true;
			
			/***************************************************************************************
			 * Define the Amazon Constants
			 * REQUIRED by the Amazon PHP library
			 *
			 * Access Key ID and Secret Acess Key ID, obtained from: http://aws.amazon.com
			 * All MWS requests must contain a User-Agent header.
			 * The application name and version defined below are used in creating this value.
			 * All MWS requests must contain the seller's merchant ID and marketplace ID.
			 ****************************************************************************************/
			
			if (  isset ( $_POST['woocommerce_fba_ns_fba_aws_access_key_id'] ) 
				&& '' !== $_POST['woocommerce_fba_ns_fba_aws_access_key_id'] ) {
				$this->ns_fba->options['ns_fba_aws_access_key_id']        = $_POST['woocommerce_fba_ns_fba_aws_access_key_id'];
			}
			if (  isset ( $_POST['woocommerce_fba_ns_fba_aws_secret_access_key'] ) 
				&& '' !== $_POST['woocommerce_fba_ns_fba_aws_secret_access_key'] ) {
				$this->ns_fba->options['ns_fba_aws_secret_access_key']    = $_POST['woocommerce_fba_ns_fba_aws_secret_access_key'];
			}
			if (  isset ( $_POST['woocommerce_fba_ns_fba_merchant_id'] ) 
				&& '' !== $_POST['woocommerce_fba_ns_fba_merchant_id'] ) {
				$this->ns_fba->options['ns_fba_merchant_id']              = $_POST['woocommerce_fba_ns_fba_merchant_id'];
			}
			if (  isset ( $_POST['woocommerce_fba_ns_fba_marketplace_id'] ) 
				&& '' !== $_POST['woocommerce_fba_ns_fba_marketplace_id'] ) {
				$this->ns_fba->options['ns_fba_marketplace_id']           = $_POST['woocommerce_fba_ns_fba_marketplace_id'];
			}
			if (  isset ( $_POST['woocommerce_fba_ns_fba_app_name'] ) 
				&& '' !== $_POST['woocommerce_fba_ns_fba_app_name'] ) {
				$this->ns_fba->options['ns_fba_app_name']        		  = $_POST['woocommerce_fba_ns_fba_app_name'];
			}
			if (  isset ( $_POST['woocommerce_fba_ns_fba_app_version'] )  
				&& '' !== $_POST['woocommerce_fba_ns_fba_app_version'] ) {
				$this->ns_fba->options['ns_fba_app_version']              = $_POST['woocommerce_fba_ns_fba_app_version'];
			}
			
			// check if all properties are set and if so, then we can define the constants
			if ( isset ( $this->ns_fba->options['ns_fba_aws_access_key_id'] ) && 		'' !== $this->ns_fba->options['ns_fba_aws_access_key_id'] &&
			     isset ( $this->ns_fba->options['ns_fba_aws_secret_access_key'] ) &&	'' !== $this->ns_fba->options['ns_fba_aws_secret_access_key'] &&
			     isset ( $this->ns_fba->options['ns_fba_merchant_id'] ) && 				'' !== $this->ns_fba->options['ns_fba_merchant_id'] &&
			     isset ( $this->ns_fba->options['ns_fba_marketplace_id'] ) && 			'' !== $this->ns_fba->options['ns_fba_marketplace_id'] &&
			     isset ( $this->ns_fba->options['ns_fba_app_name'] ) && 				'' !== $this->ns_fba->options['ns_fba_app_name'] &&
			     isset ( $this->ns_fba->options['ns_fba_app_version'] ) && 				'' !== $this->ns_fba->options['ns_fba_app_version'] 
			) {
				if ( ! defined( 'NS_AWS_ACCESS_KEY_ID' ) ) 		define( 'NS_AWS_ACCESS_KEY_ID', 	$this->ns_fba->options['ns_fba_aws_access_key_id'] );
				if ( ! defined( 'NS_AWS_SECRET_ACCESS_KEY' ) ) 	define( 'NS_AWS_SECRET_ACCESS_KEY', $this->ns_fba->options['ns_fba_aws_secret_access_key'] );
				if ( ! defined( 'NS_APPLICATION_NAME' ) ) 		define( 'NS_APPLICATION_NAME', 		$this->ns_fba->options['ns_fba_app_name'] );
				if ( ! defined( 'NS_APPLICATION_VERSION' ) ) 	define( 'NS_APPLICATION_VERSION', 	$this->ns_fba->options['ns_fba_app_version'] );
				if ( ! defined( 'NS_MERCHANT_ID' ) ) 			define( 'NS_MERCHANT_ID', 			$this->ns_fba->options['ns_fba_merchant_id'] );
				if ( ! defined( 'NS_MARKETPLACE_ID' ) ) 		define( 'NS_MARKETPLACE_ID', 		$this->ns_fba->options['ns_fba_marketplace_id'] );
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Correctly return true / false regardless of the settings version either before or after WC_Integration
		 * (previous version of NS FBA used empty setting vs. value whereas WC_Integration uses 'no' vs. 'yes') 
		 */
		function isset_on ( $setting ) {
			if ( 'no' == $setting || empty ( $setting ) ) {
				//error_log( $setting . ' = false' );
				return false;
			} else {
				//error_log( $setting . ' = true' );
				return true;
			}
		}

		/**
		 * Normalize on / off for legacy NS FBA settings data. Eventually this can be removed. 
		 */
		function isset_how ( $setting ) {
			if ( empty ( $setting ) || 'no' == $setting ) {
				//error_log( $setting . ' = no' );
				return 'no';
			} else {
				//error_log( $setting . ' = yes' );
				return 'yes';
			}
		}

		/**
		 * Send an email message using phpmailer
		 */
		function mail_message( $message, $subject = '' ) {
			
			// if a custom address is set use that otherwise use the admin email
			$to = '';
			if ( isset( $this->ns_fba->options['ns_fba_notify_email'] ) && $this->ns_fba->options['ns_fba_notify_email'] !== '' ) {
				$to = $this->ns_fba->options['ns_fba_notify_email'];
			} else {
				$to = get_option( 'admin_email' );
			}
						
			// set the headers for HTML and FROM
			$headers[] = 'Content-Type: text/html; charset=UTF-8';
			$headers[] = 'From: NS FBA <' . get_option( 'admin_email' ). '>' . "\r\n";			
			wp_mail( $to, $subject, $message, $headers );
			
			/* 
			 * OLD METHOD
			if ( class_exists( 'PHPMailer' ) ) {
				$mail = new PHPMailer();								//create a new PHPMailer instance
				$mail->setFrom(get_option( 'admin_email' ), 'NS FBA');	//set who the message is to be sent from
				$mail->addAddress(get_option( 'admin_email' ), '');		//set who the message is to be sent to
				$mail->Subject = $subject;								//set the subject line
				$mail->msgHTML( $message );								//set the HTML message

				//send the message, check for errors
				if ( ! $mail->send() ) {
					error_log( '<h3>PHPMailer Error:</h3>' . $mail->ErrorInfo . '<br /><br />', 3, $this->ns_fba->err_log_path );
				}
			}
			*/
		}

		function is_order_amazon_fulfill ( $order, $is_manual_send ) {
			// check if there are any conditions or settings which block the order from being sent to Amazon
			// assume the order is supposed to be sent to Amazon
			$is_order_amazon_fulfill = true; 
			
			// if this is a manual send to FBA and the Manual Order Override setting is ON then don't check any other conditions
			if ( $is_manual_send && $this->isset_on( $this->ns_fba->options['ns_fba_manual_order_override'] ) ) {
				return true;
			}
			
			// check if international fulfillment is disabled and if this order is international 
			$country = new WC_Countries;
			$base_country = $country->get_base_country();
			$shipping_country = get_post_meta( $order->get_id(), '_shipping_country', true );
			
			//error_log( ' base_country = ' . $base_country );
			//error_log( ' ship_country = ' . $shipping_country );
			//error_log( ' disable intl setting = ' . $this->ns_fba->options['ns_fba_disable_international'] );
			
			if ( $this->isset_on( $this->ns_fba->options['ns_fba_disable_international'] ) && $base_country != $shipping_country ) {
				$is_order_amazon_fulfill = false;
				throw new Exception( __( 'This order was NOT sent to FBA because International fulfillment is disabled in the NS FBA settings and the shipping address country does not match the base location country in the WooCommerce settings.', $this->ns_fba->text_domain ) );
			}
			 
			// check if any shipping methods are disabled and if this order is using one of them 
			$order_shipping_method = $order->get_shipping_method();
			if ( $this->isset_on( $this->ns_fba->options['ns_fba_disable_shipping'] ) && in_array( $order_shipping_method, $this->ns_fba->options['ns_fba_disable_shipping'] ) ) {
				$is_order_amazon_fulfill = false;
				throw new Exception( __( 'This order was NOT sent to FBA because it is using a Shipping Method that is disabled for FBA in the NS FBA settings.', $this->ns_fba->text_domain ) );
			}
			
			// allow other plugins to filter this order with their own fulfillment rules
			$is_order_amazon_fulfill = apply_filters( 'ns_fba_is_order_fulfill', $is_order_amazon_fulfill, $order );
			
			// if a filter sets the order to not be fulfilled then throw that
			if ( ! $is_order_amazon_fulfill ) {
				throw new Exception( __( 'This order was NOT sent to FBA because a different plugin has modified the filter: ns_fba_is_order_fulfill.', $this->ns_fba->text_domain ) );
			}			
			
			return $is_order_amazon_fulfill;
		}
		
		function is_order_item_amazon_fulfill ( $order, $item, $item_product, $product_id, $is_manual_send ) {
			// check if there are any conditions which block the order from being sent to Amazon
			// assumer the order item is supposed to go to Amazon
			$is_order_item_amazon_fulfill = true; 
			$order_note = '';
			
			// if this is a manual send to FBA and the Manual Order Item Override setting is ON then don't check any other conditions
			if ( $is_manual_send && $this->isset_on( $this->ns_fba->options['ns_fba_manual_item_override'] ) ) {
				return true;
			}
			
			// if vacation mode is ON then don't check any other conditions
			if ( $this->isset_on( $this->ns_fba->options['ns_fba_vacation_mode'] ) ) {
				return true;
			}
			
			// check if this order item's product setting for Fulfill with Amazon FBA is turned ON
			if ( $item_product && 'yes' == get_post_meta( $product_id, 'ns_fba_is_fulfill', true ) ) {
				$is_order_item_amazon_fulfill = true;
			} else {
				$is_order_item_amazon_fulfill = false;
				$order_note .= __( 'The Order Item with SKU: ' . $item_product->get_sku() . ' is not set to Fulfill with Amazon FBA in its product settings under the Shipping tab. It will not be sent to FBA for this order. ', $this->ns_fba->text_domain );
			}
			
			// check if the Quantity Max Filter is set and violated
			if ( ! empty( $this->ns_fba->options['ns_fba_quantity_max_filter'] ) && $item['qty'] > $this->ns_fba->options['ns_fba_quantity_max_filter'] ) {
				$is_order_item_amazon_fulfill = false;
				$order_note .= __( 'The Order Item with SKU: ' . $item_product->get_sku() . ' has a Qty = ' . $item['qty'] . ' which is > the Quantity Max Filter setting in NS FBA. It will not be sent to FBA for this order.', $this->ns_fba->text_domain );
			}			
			
			// set up a test for the value before and after the filter
			$is_order_item_before_filter = $is_order_item_amazon_fulfill;
			
			// allow other plugins to filter this order_item with their own fulfillment rules
			$is_order_item_amazon_fulfill = apply_filters( 'ns_fba_is_order_item_fulfill', $is_order_item_amazon_fulfill, $item );
			
			if ( $is_order_item_before_filter && ! $is_order_item_amazon_fulfill ) {
				$order_note .= __( 'Fulfillment status for the Order Item with SKU: ' . $item_product->get_sku() . ' was modified by a different plugin using the filter: ns_fba_is_order_item_fulfill. It will not be sent to FBA for this order.', $this->ns_fba->text_domain );
			}
			
			if ( ! empty( $order_note ) ) {
				$order->add_order_note( $order_note );
			}
			
			return $is_order_item_amazon_fulfill;
		}
	}
}