<?php
/**
 * Implementation of WC Integration class for Settings
 *
 * @package NeverSettle\WooCommerce-Amazon-Fulfillment
 * @since 3.0.1
 */

class WC_Integration_FBA extends WC_Integration {
	
	private $nsfba;
	private $text_domain;
	private $button_defaults;
	
	/**
	 * Init and hook in the integration.
	 */
	public function __construct(  ) {
		global $woocommerce;
		
		// defaults for settings parameters
		$this->button_defaults = array(
			'class'             => 'button-secondary',
			'css'               => '',
			'custom_attributes' => array(),
			'desc_tip'          => false,
			'description'       => '',
			'title'             => '',
		);
		
		// local reference to the singleton nsfba object
		$this->nsfba = NS_FBA::get_instance();
		$this->text_domain = $this->nsfba->text_domain;
		
		// normal integration properties
		$this->id                 = 'fba';
		$this->method_title       = __( 'Fulfillment by Amazon', $this->text_domain );
		//$this->method_description = __( 'WooCommerce Integration with Fulfillment by Amazon', $this->text_domain );
		
		// Load the settings
		$this->init_form_fields();
		$this->init_settings();
		
		// Define user set variables
		
		// SECTION Amazon Account and MWS Settings 			--------------------------------------------------------------------
		$this->ns_fba_service_url				= $this->get_option( 'ns_fba_service_url' );
		$this->ns_fba_aws_access_key_id			= $this->get_option( 'ns_fba_aws_access_key_id' );
		$this->ns_fba_aws_secret_access_key		= $this->get_option( 'ns_fba_aws_secret_access_key' );
		$this->ns_fba_merchant_id				= $this->get_option( 'ns_fba_merchant_id' );
		$this->ns_fba_marketplace_id			= $this->get_option( 'ns_fba_marketplace_id' );
		$this->ns_fba_app_name					= $this->get_option( 'ns_fba_app_name' );
		$this->ns_fba_app_version				= $this->get_option( 'ns_fba_app_version' );
		
		// SECTION FBA Inventory (Stock Level) Settings 	--------------------------------------------------------------------
		$this->ns_fba_update_inventory			= $this->get_option( 'ns_fba_update_inventory' );
		$this->ns_fba_sync_inventory			= $this->get_option( 'ns_fba_sync_inventory' );
		$this->ns_fba_test_inventory_sku		= $this->get_option( 'ns_fba_test_inventory_sku' );
						
		// SECTION FBA Order Fulfillment Settings 			--------------------------------------------------------------------
		$this->ns_fba_order_prefix				= $this->get_option( 'ns_fba_order_prefix' );
		$this->ns_fba_shipping_speed			= $this->get_option( 'ns_fba_shipping_speed' );
		// for the custom controls we have to look for their new values in POST since they haven't been saved yet
		if ( ! empty( $_POST['woocommerce_fba_ns_fba_shipping_speed_standard'] ) ) {
			$this->ns_fba_shipping_speed_standard 	= $_POST['woocommerce_fba_ns_fba_shipping_speed_standard'];
			$this->nsfba->options['ns_fba_shipping_speed_standard'] = $_POST['woocommerce_fba_ns_fba_shipping_speed_standard'];		
			$this->ns_fba_shipping_speed_expedited 	= $_POST['woocommerce_fba_ns_fba_shipping_speed_expedited'];
			$this->nsfba->options['ns_fba_shipping_speed_expedited'] = $_POST['woocommerce_fba_ns_fba_shipping_speed_expedited'];			
			$this->ns_fba_shipping_speed_priority 	= $_POST['woocommerce_fba_ns_fba_shipping_speed_priority'];
			$this->nsfba->options['ns_fba_shipping_speed_priority'] = $_POST['woocommerce_fba_ns_fba_shipping_speed_priority'];			
		} else {
			$this->ns_fba_shipping_speed_standard	= $this->get_option( 'ns_fba_shipping_speed_standard' );
			$this->ns_fba_shipping_speed_expedited	= $this->get_option( 'ns_fba_shipping_speed_expedited' );
			$this->ns_fba_shipping_speed_priority	= $this->get_option( 'ns_fba_shipping_speed_priority' );
		}		
		$this->ns_fba_fulfillment_policy		= $this->get_option( 'ns_fba_fulfillment_policy' );
		
		// SECTION General Plugin Settings 					--------------------------------------------------------------------
		$this->ns_fba_notify_email				= $this->get_option( 'ns_fba_notify_email' );
		$this->ns_fba_email_on_error			= $this->get_option( 'ns_fba_email_on_error' );
		$this->ns_fba_encode_convert_bypass		= $this->get_option( 'ns_fba_encode_convert_bypass' );
		$this->ns_fba_encode_check_override		= $this->get_option( 'ns_fba_encode_check_override' );
		$this->ns_fba_automatic_completion		= $this->get_option( 'ns_fba_automatic_completion' );
		$this->ns_fba_sync_ship_status			= $this->get_option( 'ns_fba_sync_ship_status' );
		$this->ns_fba_disable_shipping_email	= $this->get_option( 'ns_fba_disable_shipping_email' );
		$this->ns_fba_display_order_tracking	= $this->get_option( 'ns_fba_display_order_tracking' );
		$this->ns_fba_debug_mode				= $this->get_option( 'ns_fba_debug_mode' );
		
		// SECTION Smart Fulfillment Settings 				--------------------------------------------------------------------
		$this->ns_fba_manual_order_override		= $this->get_option( 'ns_fba_manual_order_override' );
		$this->ns_fba_disable_international		= $this->get_option( 'ns_fba_disable_international' );
		
		// for the custom controls we have to look for their new values in POST since they haven't been saved yet
		if ( ! empty( $_POST['woocommerce_fba_ns_fba_disable_shipping'] ) ) {
			$this->ns_fba_disable_shipping 	= $_POST['woocommerce_fba_ns_fba_disable_shipping'];
			$this->nsfba->options['ns_fba_disable_shipping'] = $_POST['woocommerce_fba_ns_fba_disable_shipping'];
		} else {
			$this->ns_fba_disable_shipping		= $this->get_option( 'ns_fba_disable_shipping' );	
		}
		
		$this->ns_fba_manual_item_override		= $this->get_option( 'ns_fba_manual_item_override' );
		$this->ns_fba_vacation_mode				= $this->get_option( 'ns_fba_vacation_mode' );
		$this->ns_fba_perfection_mode			= $this->get_option( 'ns_fba_perfection_mode' );
		$this->ns_fba_quantity_max_filter		= $this->get_option( 'ns_fba_quantity_max_filter' );		
		
		// SECTION Configuration for Multiple Currencies 	--------------------------------------------------------------------
		$this->ns_fba_currency_code				= $this->get_option( 'ns_fba_currency_code' );
		$this->ns_fba_currency_conversion		= $this->get_option( 'ns_fba_currency_conversion' );
		
		// Actions
		add_action( 'woocommerce_update_options_integration_' . $this->id, array( $this, 'process_admin_options' ) );
		add_action( 'admin_notices', array( $this, 'ns_fba_not_configured_notice' ) );
		
		// run the inventory api test if if this is a test request and they are configured
		if ( isset( $_POST['ns_fba_test_inventory'] ) && $this->nsfba->is_configured ) {
			// test the single update
			add_action( 'admin_notices', array( $this, 'ns_fba_inventory_test_results' ) );
		}
		
		$this->process_form_actions();
	}

	/**
	 * Not Configured Notice
	 */
	function ns_fba_not_configured_notice() {
		// checks if saving the options has now left us in an unconfigured state
		// resets is_configured so that we get a true test
		$this->nsfba->is_configured = false;
		$this->nsfba->is_configured = $this->nsfba->utils->is_configured();
		if ( ! $this->nsfba->is_configured ) {
			$url = '/wp-admin/admin.php?page=wc-settings&tab=integration&section=fba';
			$link = sprintf( __( '<div class="error"><p>You need to <a href="%s">configure all settings for Amazon Fulfillment</a> before it will work.</p></div>', $this->text_domain ), $url );
			echo $link;
		}				
	}
	
	/**
	 * Inventory Test Results
	 */
	function ns_fba_inventory_test_results() {
		$service = $this->nsfba->inventory->create_service_inventory();
		$inventory = $this->nsfba->inventory->get_sku_inventory( $service, $this->nsfba->options['ns_fba_test_inventory_sku'] );
		if ( -1 != $inventory['number'] ) {
			$text = sprintf( __('<div class="updated"><p>Inventory Test Success! There are %s units of %s in FBA stock.</p></div>', $this->text_domain ), $inventory['number'], $this->nsfba->options['ns_fba_test_inventory_sku'] );
			echo $text;
		} else {
			$text = sprintf( __('<div class="error"><p>Inventory Test Fail! Error Message: %s </p></div>', $this->text_domain ), $inventory['message'] );
			echo $text;							
		}
	
		// manually test the sync update
		if ( ! empty ( $this->options['ns_fba_sync_inventory'] ) ) {
			// use for debugging scheduled sync on test, but normally commented out
			//$this->nsfba->inventory->sync_all_inventory();
		}
	}

	/**
	 * Check and Process the Form actions 
	 */
	private function process_form_actions() {
		// runs the api credentials test if if this is a test request and they are configured
		if ( isset( $_POST['ns_fba_test_api'] ) && $this->nsfba->is_configured ) {
			$status = $this->nsfba->outbound->test_api();
			if ( 'success' == $status ) {
				_e( '<div class="updated"><p>Success! Your MWS credentials are correct and the service is active!</p></div>', $this->text_domain );
			} else {
				$text = sprintf( __('<div class="error"><p>Uh-oh! There was a problem connecting: %s.</p></div>', $this->text_domain ), $status );
				echo $text;
			}
		}
	} 	
	 
	/**
	 * Initialize integration settings form fields.
	 */
	public function init_form_fields() {
		
		$this->form_fields = array(
		
			// SECTION Amazon Account and MWS Settings --------------------------------------------------------------------
		
			'ns_fba_title1' => array( 'title' => __( 'Amazon Account and MWS Settings', $this->text_domain ), 'type' => 'title', 'desc' => '', ),
			
			'ns_fba_registermws' => array(
				'title'             => __( 'Register for MWS', $this->text_domain ),
				'description'       => __( 'The below settings are all required and can be obtained by clicking the link for your region.', 'ns-fba-for-woocommerce' ),
				'desc_tip'          => true,
				'type'              => 'ns_fba_registermws',
			),
			
			'ns_fba_service_url' => array(
			    'title'    			=> __( 'Select Home Region', $this->text_domain ),			
			    'description'    	=> __( 'The default is set for North America, all available regions are options. You can only have 1 home region and it should match the region in which you opened your Seller Central account.', $this->text_domain ),	
			    'desc_tip' 			=> true,		
			    'std'     => 'https://mws.amazonservices.com', 			
			    'default' => 'https://mws.amazonservices.com', 			
			    'type'    => 'select',			
			    'options' => array(			
			    	'https://mws.amazonservices.com'	=> __( 'N. America (Default) - https://mws.amazonservices.com', $this->text_domain ),
			    	'https://mws-eu.amazonservices.com'	=> __( 'Europe - https://mws-eu.amazonservices.com', $this->text_domain ),
			    	'https://mws.amazonservices.in'		=> __( 'India - https://mws.amazonservices.in', $this->text_domain ),
			    	'https://mws.amazonservices.com.cn'	=> __( 'China - https://mws.amazonservices.com.cn', $this->text_domain ),
			    	'https://mws.amazonservices.jp'		=> __( 'Japan - https://mws.amazonservices.jp', $this->text_domain ),			    	
			    ),			
			  ),
			
			'ns_fba_aws_access_key_id' => array(
				'title'             => __( 'AWS Access Key ID', $this->text_domain ),
				'desc_tip'          => false,
				'default'           => '',
				'type'              => 'text',
			),
			
			'ns_fba_aws_secret_access_key' => array(
				'title'             => __( 'AWS Secret Access Key', $this->text_domain ),
				'desc_tip'          => false,
				'default'           => '',
				'type'              => 'text',
			),			
			
			'ns_fba_merchant_id' => array(
				'title'             => __( 'Amazon Merchant ID', $this->text_domain ),
				'desc_tip'          => false,
				'default'           => '',
				'type'              => 'text',
			),
			
			'ns_fba_marketplace_id' => array(
				'title'             => __( 'Amazon Marketplace ID', $this->text_domain ),
				'desc_tip'          => false,
				'default'           => '',
				'type'              => 'text',
			),
			
			'ns_fba_app_name' => array(
				'title'             => __( 'Application Name', $this->text_domain ),
				'description'       => __( 'Used for MWS-required user-agent header. It can be anything, but no spacess like: MyApp.', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => '',
				'type'              => 'text',
			),
			
			'ns_fba_app_version' => array(
				'title'             => __( 'Application Version', $this->text_domain ),
				'description'       => __( 'Used for MWS-required user-agent header. It can be any number, like: 1', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => '',
				'type'              => 'text',
			),
			
			'ns_fba_test_api'		=> array(
				'title'             => __( 'Test MWS Connection', $this->text_domain ),
				'label'             => __( 'Click to Test MWS Connection', $this->text_domain ),
				'description'       => __( 'This will check to see if you have a connection to Amazon and if your MWS Access Credentials are correct', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => '',
				'type'              => 'ns_fba_form_button',
			),			
		);
		
		if ( $this->nsfba->is_configured ) {
		
			$this->form_fields = array_merge( $this->form_fields, array (
			
			// SECTION FBA Inventory (Stock Level) Settings --------------------------------------------------------------------
			
			'ns_fba_title2' => array( 'title' => __( 'FBA Inventory (Stock Level) Settings', $this->text_domain ), 'type' => 'title', 'desc' => '', ),
			
			'ns_fba_update_inventory' => array(
				'title'             => __( 'Update WC levels from FBA', $this->text_domain ),
				'label'             => __( 'Update local stock levels for each Order item after sending to FBA', $this->text_domain ),
				'desc_tip'          => false,
				'default'           => 'no',
				'type'              => 'checkbox',
			),
			
			'ns_fba_sync_inventory' => array(
				'title'             => __( 'Sync WC levels from FBA', $this->text_domain ),
				'label'             => __( 'Sync local stock levels from FBA once per hour', $this->text_domain ),
				'description'       => __( 'NOTE: This will only sync products configured to fulfill through FBA', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => 'no',
				'type'              => 'checkbox',
			),
			
			'ns_fba_test_inventory_sku' => array(
				'title'             => __( 'Test Inventory SKU', $this->text_domain ),
				'description'       => __( 'Active SKU from your FBA inventory to test with the Test FBA Inventory Button Below', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => '',
				'type'              => 'text',
			),
			
			'ns_fba_test_inventory'	=> array(
				'title'             => __( 'Test Inventory Connection	', $this->text_domain ),
				'label'             => __( 'Click to Test Inventory Connection	', $this->text_domain ),
				'description'       => __( 'Fill in a valid SKU above in the Test Inventory SKU field and click to test a stock level request', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => '',
				'type'              => 'ns_fba_form_button',
			),			
			
			'ns_fba_sync_inventory_manually' => array(
				'title'             => __( 'Manually Sync Local Levels', $this->text_domain ),
				'label'             => __( 'Click to Sync ALL local levels of Stock to match FBA', $this->text_domain ),
				'description'       => __( 'Initiate FBA > WooCommerce Inventory Sync. NOTE: Use sparingly. Syncing inventory this way can have performance implications and impact live traffic depending on multiple factors', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => '',
				'type'              => 'ns_fba_form_button',
			),
						
			// SECTION FBA Order Fulfillment Settings --------------------------------------------------------------------
			
			'ns_fba_title3' => array( 'title' => __( 'FBA Order Fulfillment Settings', $this->text_domain ), 'type' => 'title', 'desc' => '', ),
			
			'ns_fba_order_prefix' 	=> array(
				'title'             => __( 'Order Prefix (Recommended)', $this->text_domain ),
				'description'       => __( 'This will add a prefix to the order number ID that is sent to Amazon for fulfillment. If it is blank, only the WooCommerce Order Number will be sent. It is recommended to specify a short value (no spaces) to give all FBA requests a unique order identifier.', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => '',
				'type'              => 'text',
			),
			
			'ns_fba_shipping_speed' => array(
			    'title'    			=> __( 'DEFAULT Shipping Speed', $this->text_domain ),			
			    'description'    	=> __( 'This will be used when the shipping method chosen by the customer for their order does NOT match ANY of the mappings below', $this->text_domain ),	
			    'desc_tip' 			=> true,		
			    'std'    			=> 'Standard', 			
			    'default' 			=> 'Standard', 			
			    'type'    			=> 'select',			
			    'options' 			=> array(			
			    	'Standard'		=> __( 'Standard (Default)', $this->text_domain ),
			    	'Expedited'		=> __( 'Expedited', $this->text_domain ),
			    	'Priority'		=> __( 'Priority', $this->text_domain ),
			    ),			
			  ),
			
			'ns_fba_shipping_speed_standard' => array(
				'title'             => __( 'Shipping for STANDARD', $this->text_domain ),
				'description'       => __( 'Orders with the selected shipping method will use Amazon STANDARD Shipping Speed. <strong>IMPORTANT:</strong> There are extra fees associated with using different Amazon Shipping Speeds. Check with Amazon for specifics related to your region.', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => '',
				'type'              => 'ns_fba_map_shipping',
			),
			
			'ns_fba_shipping_speed_expedited' => array(
				'title'             => __( 'Shipping for EXPEDITED', $this->text_domain ),
				'description'       => __( 'Orders with the selected shipping method will use Amazon EXPEDITED Shipping Speed. <strong>IMPORTANT:</strong> There are extra fees associated with using different Amazon Shipping Speeds. Check with Amazon for specifics related to your region.', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => '',
				'type'              => 'ns_fba_map_shipping',
			),
			
			'ns_fba_shipping_speed_priority' => array(
				'title'             => __( 'Shipping for PRIORITY', $this->text_domain ),
				'description'       => __( 'Orders with the selected shipping method will use Amazon PRIORITY Shipping Speed. <strong>IMPORTANT:</strong> There are extra fees associated with using different Amazon Shipping Speeds. Check with Amazon for specifics related to your region.', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => '',
				'type'              => 'ns_fba_map_shipping',
			),
			
			'ns_fba_fulfillment_policy' => array(
			    'title'    			=> __( 'FBA Fulfillment Policy', $this->text_domain ),			
			    'description'    	=> __( 'More info about each option: <a href="http://docs.developer.amazonservices.com/en_US/fba_outbound/FBAOutbound_CreateFulfillmentOrder.html" target="_blank">CreateFulfillmentOrder MWS Documentation</a>', $this->text_domain ),	
			    'desc_tip' 			=> false,		
			    'std'    			=> 'FillOrKill', 			
			    'default' 			=> 'FillOrKill', 			
			    'type'    			=> 'select',			
			    'options' 			=> array(			
			    	'FillOrKill'		=> __( 'FillOrKill (Default)', $this->text_domain ),
			    	'FillAll'			=> __( 'FillAll', $this->text_domain ),
			    	'FillAllAvailable'	=> __( 'FillAllAvailable', $this->text_domain ),
			    ),			
			  ),
			
			// SECTION General Plugin Settings 					--------------------------------------------------------------------
			
			'ns_fba_title4' => array( 'title' => __( 'General Plugin Settings', $this->text_domain ), 'type' => 'title', 'desc' => '', ),
			
			'ns_fba_notify_email' 	=> array(
				'title'             => __( 'Notification Email', $this->text_domain ),
				'description'       => __( 'NS FBA adds the WP admin email address to the Amazon notification list for each order. Leave this setting BLANK to keep that default behavior. Or, specify a valid email address here to override that. This will also be used as the TO: address if the Email on Error setting is ON.', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => '',
				'type'              => 'text',
			),
			
			'ns_fba_email_on_error' => array(
				'title'             => __( 'Email on Error', $this->text_domain ),
				'label'             => __( 'Send Error Notifications', $this->text_domain ),
				'description'       => __( 'Send the email address above (or the site admin email) a message every time an order fails to be sent to FBA.', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => 'no',
				'type'              => 'checkbox',
			),
			
			'ns_fba_encode_convert_bypass' => array(
				'title'             => __( 'Encoding Convert BYPASS', $this->text_domain ),
				'label'             => __( 'Bypass automatic encoding conversion', $this->text_domain ),
				'description'       => __( 'This will bypass NS FBAs normal attempt to convert customer name and address characters into a format that FBA will always accept. Sometimes there is a problem with the conversion which results in [?] characters. If you see this with your FBA orders in Seller Central, try turning this option ON to bypass the conversion completely and pass the raw data directly to Amazon. Note: this might cause FBA to reject orders in certain situations.', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => 'no',
				'type'              => 'checkbox',
			),
			
			'ns_fba_encode_check_override' => array(
				'title'             => __( 'Encoding Check OVERRIDE', $this->text_domain ),
				'label'             => __( 'Override normal encoding conversion validation checking for unconverted characters', $this->text_domain ),
				'description'       => __( 'This will override NS FBAs final check on character encodings in the shipping address and allow the order to be sent to FBA even if it cannot convert some characters successfully. This might result in some addresses containing [?] characters.', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => 'no',
				'type'              => 'checkbox',
			),
			
			'ns_fba_automatic_completion' => array(
				'title'             => __( 'Auto-Complete Order Status', $this->text_domain ),
				'label'             => __( 'Automatically mark successful orders complete', $this->text_domain ),
				'description'       => __( 'Instantly set orders successfully received by FBA to the standard WooCommerce Completed status instead of the custom NS FBA status.', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => 'no',
				'type'              => 'checkbox',
			),
			
			'ns_fba_sync_ship_status' => array(
				'title'             => __( 'Sync Shipping Status', $this->text_domain ),
				'label'             => __( 'Automatically sync order status based on Amazon shipping status', $this->text_domain ),
				'description'       => __( 'Check for updates to shipping status once per hour on orders that have been successfully Sent to FBA (including Partial to FBA). This will also automatically update the order status to Completed if FBA reports the order has shipped. If this option is ON then the Mark Orders Complete option should be OFF.', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => 'no',
				'type'              => 'checkbox',
			),
			
			'ns_fba_disable_shipping_email' => array(
				'title'             => __( 'Disable Shipping Email', $this->text_domain ),
				'label'             => __( 'Prevent Amazon from emailing the customer directly with order information', $this->text_domain ),
				'description'       => __( 'Do NOT allow Amazon to send the customer a shipping notice email. Most stores should leave this option OFF. However, some might find this option useful when Amazon is sending confusing messages to the customer (like in the wrong language). When this option is ON the shipping notices will ONLY be sent to the admin email address. Changing this will NOT affect any orders already placed.', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => 'no',
				'type'              => 'checkbox',
			),
			
			'ns_fba_display_order_tracking' => array(
				'title'             => __( 'Display Order Tracking', $this->text_domain ),
				'label'             => __( 'Show order information from Amazon on your customer view order page', $this->text_domain ),
				'description'       => __( 'Show Order Shipping and Tracking information on the customer Order View Page pulled directly from Amazon including the latest status and tracking number. It can take up to an hour for tracking info to be retrieved and updated.', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => 'no',
				'type'              => 'checkbox',
			),
			
			'ns_fba_debug_mode' => array(
				'title'             => __( 'Enable DEBUG mode', $this->text_domain ),
				'label'             => __( 'Capture additional info to help with support cases', $this->text_domain ),
				'description'       => __( 'Turn on additional logging for support cases. Normally, leave this turned OFF.', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => 'no',
				'type'              => 'checkbox',
			),
			
			// SECTION Smart Fulfillment Settings 				--------------------------------------------------------------------
			
			'ns_fba_title5' => array( 'title' => __( 'Order Level Processing Rules', $this->text_domain ), 'type' => 'title', 'desc' => '', ),
			
			'ns_fba_manual_order_override' => array(
				'title'             => __( 'Manual Order OVERRIDE', $this->text_domain ),
				'label'             => __( 'Skip all other processing rules below when manually submitting an order to Amazon', $this->text_domain ),
				'description'       => __( 'This will bypass ALL other Order Level Processing Rules below <b>when manually sending an order to FBA</b> and force NS FBA to try to send it through. Normally leave this turned OFF. This setting does NOT bypass the rules below for automatic fulfillment.', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => 'no',
				'type'              => 'checkbox',
			),
			
			'ns_fba_disable_international' => array(
				'title'             => __( 'Disable for International', $this->text_domain ),
				'label'       		=> __( 'ONLY Send Orders to FBA for addresses inside your <a href="/wp-admin/admin.php?page=wc-settings" target="_blank">Base Location Country</a>', $this->text_domain ),
				'description'       => __( 'Prevent orders from other countries from being sent to Amazon for fulfillment', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => 'no',
				'type'              => 'checkbox',
			),
			
			'ns_fba_disable_shipping' => array(
				'title'             => __( 'Disable for Shipping Methods', $this->text_domain ),
				'description'       => __( 'ONLY Send Orders to FBA that do not use any of the selected Shipping methods below (CTL+Click to Select Multiple Items).', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => 'no',
				'type'              => 'ns_fba_exclude_shipping',
			),
					
			'ns_fba_title6' => array( 'title' => __( 'Order Item (Product) Level Processing Rules', $this->text_domain ), 'type' => 'title', 'desc' => '', ),
			
			'ns_fba_manual_item_override' => array(
				'title'             => __( 'Manual Order Item OVERRIDE', $this->text_domain ),
				'label'             => __( 'Skip all other item processing rules below when manually submitting an order to Amazon', $this->text_domain ),
				'description'       => __( 'This will bypass ALL other Order Item Level Processing Rules below <b>when manually sending an order to FBA</b> and force NS FBA to try to send ALL items in an order regardless of their individual Product settings. Normally leave this turned ON. This setting does NOT bypass the rules below for automatic fulfillment.', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => 'no',
				'type'              => 'checkbox',
			),
			
			'ns_fba_vacation_mode' => array(
				'title'             => __( 'Vacation Mode', $this->text_domain ),
				'label'             => __( 'Force all items in all order to go to Amazon for fulfillment', $this->text_domain ),
				'description'       => __( 'Send ALL Order Items to FBA Regardless of their individual Product Settings. You can also use this to avoid turning ON the Fulfill with Amazon FBA setting in every single product, but this is not recommended unless every SKU has a match in FBA.', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => 'no',
				'type'              => 'checkbox',
			),
			
			'ns_fba_perfection_mode' => array(
				'title'             => __( 'Perfection Mode', $this->text_domain ),
				'label'             => __( 'Do NOT send partially fulfillable orders to Amazon', $this->text_domain ),
				'description'       => __( 'ONLY Send Orders to FBA if ALL order item products are set to Fulfill with Amazon FBA.', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => 'no',
				'type'              => 'checkbox',
			),
			
			'ns_fba_quantity_max_filter' 	=> array(
				'title'             => __( 'Quantity Max Filter', $this->text_domain ),
				'description'       => __( 'This is the maximum quantity per item that will be allowed to go to FBA. If the ordered quantity is more than this number for an item, it will NOT be sent to FBA. Leave this setting BLANK to send items to FBA regardless of the quantities ordered.', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => '',
				'type'              => 'text',
			),
			
			// SECTION Configuration for Multiple Currencies 	--------------------------------------------------------------------
			
			'ns_fba_title7' => array( 'title' => __( 'Configuration for Multiple Currencies - Normally NOT Used', $this->text_domain ), 'type' => 'title', 'desc' => '', ),
			
			'ns_fba_currency_code' 	=> array(
				'title'             => __( 'Currency Code OVERRIDE', $this->text_domain ),
				'description'       => __( 'Manually Override the WooCommerce with a value like USD or GBP or EUR, etc. Leave this BLANK unless you know exactly what you are doing.</strong> Normally, NS FBA will use the currency configured in WooCommerce. This setting is ONLY if your store (WooCommerce) currency is different than you default Amazon Marketplace currency.', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => '',
				'type'              => 'text',
			),
			
			'ns_fba_currency_conversion' 	=> array(
				'title'             => __( 'Currency Conversion Value', $this->text_domain ),
				'description'       => __( 'Rate used to calculate Amazon PerUnitDeclaredValue. This is ONLY used if Currency Override is set. The formula is: Product Price * Currency Conversion = PerUnitDeclaredValue sent to Amazon', $this->text_domain ),
				'desc_tip'          => true,
				'default'           => '',
				'type'              => 'text',
			),
		)); //end array and array_merge
		} // end if is_configured
	}
	
	/**
	 * Generate Register for MWS Credentials links
	 */
	public function generate_ns_fba_registermws_html( $key, $data ) {
		$field_name = $this->plugin_id . $this->id . '_' . $key;
		$defaults = array();
		$data = wp_parse_args( $data, $defaults );
		ob_start();
		?>
		<tr valign="top">
			<th scope="row" class="titledesc">
				<label for="<?php echo esc_attr( $field_name ); ?>"><?php echo wp_kses_post( $data['title'] ); ?></label>
				<?php echo $this->get_tooltip_html( $data ); ?>
			</th>
			<td class="forminp" style="padding-top: 0px !important;">
				<span style="color: #777777; font-style: italic;">
					<table>
						<tr>
							<td><b><a href="https://sellercentral.amazon.com/gp/mws/registration/register.html" target="_blank"><?php _e( 'N. America', $this->text_domain ); ?></b></a></td>
							<td><b><a href="https://sellercentral-europe.amazon.com/gp/mws/registration/register.html" target="_blank"><?php _e( 'Europe', $this->text_domain ); ?></b></a></td>
							<td><b><a href="https://developer.amazonservices.in/gp/mws/registration/register.html" target="_blank"><?php _e( 'India', $this->text_domain ); ?></b></a></td>
							<td><b><a href="https://developer.amazonservices.com.cn/gp/mws/registration/register.html" target="_blank"><?php _e( 'China', $this->text_domain ); ?></b></a></td>
							<td><b><a href="https://sellercentral-japan.amazon.com/gp/mws/registration/register.html" target="_blank"><?php _e( 'Japan', $this->text_domain ); ?></b></a></td>
						</tr>
					</table>
				</span>
			</td>
		</tr>		
		<?php
		return ob_get_clean();
	}

	/**
	 * Generate Form Action Buttons
	 */
	public function generate_ns_fba_form_button_html( $key, $data ) {
		$field = $this->plugin_id . $this->id . '_' . $key;
		$data = wp_parse_args( $data, $this->button_defaults );
		ob_start();
		?>
		<tr valign="top">
			<th scope="row" class="titledesc">
				<label for="<?php echo esc_attr( $field ); ?>"><?php echo wp_kses_post( $data['title'] ); ?></label>
				<?php echo $this->get_tooltip_html( $data ); ?>
			</th>
			<td class="forminp">
				<fieldset>
					<input type="submit" name="<?php esc_attr_e( $key, $this->text_domain );?>" value="<?php esc_attr_e( $data['label'], $this->text_domain );?>"/>
					<?php echo $this->get_description_html( $data ); ?>
				</fieldset>
			</td>
		</tr>
		<?php
		return ob_get_clean();
	}
	
	/**
	 * Generate Shipping Map Dropdown
	 */
	public function generate_ns_fba_map_shipping_html( $key, $data ) {
		$field_name = $this->plugin_id . $this->id . '_' . $key;
		$defaults = array();
		$data = wp_parse_args( $data, $defaults );
		
		// Set up all our active shipping methods
		$shipping_methods = array();
		$shipping_methods = $this->nsfba->wc->get_active_shipping_methods();
		if ( empty( $shipping_methods ) ) {
			$shipping_methods[0] = 'No Active Shipping Methods Found';
		} else {
			// Add a disabled choice in case they don't want to use a shipping speed
			array_unshift( $shipping_methods, 'Disabled' );
		}
		
		ob_start();
		?>
		<tr valign="top">
			<th scope="row" class="titledesc">
				<label for="<?php echo esc_attr( $field_name ); ?>"><?php echo wp_kses_post( $data['title'] ); ?></label>
				<?php echo $this->get_tooltip_html( $data ); ?>
			</th>
			<td class="forminp">
				<select class="select" name="<?php esc_attr_e( $field_name, $this->text_domain );?>" id="<?php esc_attr_e( $field_name, $this->text_domain );?>">
					<?php foreach ( $shipping_methods as $method ): ?>
						<option value="<?php echo $method; ?>" <?php echo (( ! empty ($this->nsfba->options[$key]) && $this->nsfba->options[$key] == $method ) ? 'selected="selected"' : '' ); ?>><?php echo $method; ?></option>										
					<?php endforeach; ?>
				</select>
			</td>
		</tr>		
		<?php
		return ob_get_clean();
	}

	/**
	 * Generate Shipping Exclusion Multiple Select
	 */
	public function generate_ns_fba_exclude_shipping_html( $key, $data ) {
		$field_name = $this->plugin_id . $this->id . '_' . $key;
		$defaults = array();
		$data = wp_parse_args( $data, $defaults );
		
		// Set up all our active shipping methods
		$shipping_methods = array();
		$shipping_methods = $this->nsfba->wc->get_active_shipping_methods();
		if ( empty( $shipping_methods ) ) {
			$shipping_methods[0] = 'No Active Shipping Methods Found';
		} else {
			// Add a disabled choice in case they don't want to use a shipping speed
			array_unshift( $shipping_methods, 'Disabled' );
		}
		
		ob_start();
		?>
		<tr valign="top">
			<th scope="row" class="titledesc">
				<label for="<?php echo esc_attr( $field_name ); ?>"><?php echo wp_kses_post( $data['title'] ); ?></label>
				<?php echo $this->get_tooltip_html( $data ); ?>
			</th>
			<td class="forminp">
				<select name="woocommerce_fba_ns_fba_disable_shipping[]" id="woocommerce_fba_ns_fba_disable_shipping" multiple>
					<?php 
					// Update the default item to make more sense for this setting since we're reusing the active shipping methods
					if ( count( $shipping_methods ) > 1 ) $shipping_methods[0] = 'None (Allow Orders with ANY Shipping Method to be sent to FBA)';
					foreach ( $shipping_methods as $method ): ?>
						<option value="<?php echo $method; ?>" <?php echo (( ! empty( $this->nsfba->options['ns_fba_disable_shipping'] ) && in_array( $method, $this->nsfba->options['ns_fba_disable_shipping'] ) ) ? 'selected' : '' ); ?>><?php echo $method; ?></option>										
					<?php endforeach; ?>
				</select>
			</td>
		</tr>		
		<?php
		return ob_get_clean();
	}
	
	/**
	 * Validate Shipping Exclusions Field
	 */
	public function validate_ns_fba_exclude_shipping_field( $key, $value ) {
		// override the default text field validation for our custom field because it tries to run stripslashes on our array
		return $value;
	}
	
} //class
