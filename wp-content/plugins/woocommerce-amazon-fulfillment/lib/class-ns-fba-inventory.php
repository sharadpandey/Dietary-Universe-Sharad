<?php
/**
 * Inventory class for integrating with the Amazon Inventory API
 *
 * @package NeverSettle\WooCommerce-Amazon-Fulfillment
 * @since 2.0.0
 */

if ( ! class_exists( 'NS_FBA_Inventory' ) ) {

	class NS_FBA_Inventory {

		private $ns_fba;
		
		function __construct( $ns_fba ) {
			// local reference to the main ns_fba object
			$this->ns_fba = $ns_fba;
			
		}
		
		/**
		 * Builds an MWS inventory service request
		 * 
		 * @return FBAInventoryServiceMWS_Client
		 */
		function create_service_inventory() {
			$config = array (
				'ServiceURL' => $this->ns_fba->options['ns_fba_service_url'] . '/FulfillmentInventory/2010-10-01',
				'ProxyHost' => null,
				'ProxyPort' => -1,
				'MaxErrorRetry' => 3,
			);
			$service = new FBAInventoryServiceMWS_Client (
				NS_AWS_ACCESS_KEY_ID,
				NS_AWS_SECRET_ACCESS_KEY,
				$config,
				NS_APPLICATION_NAME,
				NS_APPLICATION_VERSION
			);
			return $service;
		}
		
		/**
		 * Get Inventory level for a given SKU
		 *
		 * @param 	string	SKU
		 * @return 	array	number = -1 for error otherwise number in inventory
		 * 					message = '' if success or error message if fail
		 */
		function get_sku_inventory ( $service, $sku ) {
			$skus = new FBAInventoryServiceMWS_Model_SellerSkuList();
			$skus->setmember( $sku );
			$request = new FBAInventoryServiceMWS_Model_ListInventorySupplyRequest();
			$request->setSellerId( NS_MERCHANT_ID );
			$request->setMarketplaceId( NS_MARKETPLACE_ID );
			$request->setSellerSkus( $skus );
			$inventory = array();
			$inventory['number'] = -1;
			$inventory['message'] = __('Inventory Response from FBA not Initialized or Received', $this->ns_fba->text_domain);
			try {
				$response = $service->listInventorySupply($request);
				if ($response->isSetListInventorySupplyResult()) {
					$listInventorySupplyResult = $response->getListInventorySupplyResult();
					if ($listInventorySupplyResult->isSetInventorySupplyList()) {
						$inventorySupplyList = $listInventorySupplyResult->getInventorySupplyList();
						$memberList = $inventorySupplyList->getmember();
						// we're only checking a single SKU at a time, so we know any result will be at [0]
						$member = $memberList[0];
						if ($member->isSetInStockSupplyQuantity()) {
							$inventory['number'] = $member->getInStockSupplyQuantity();
							$inventory['message'] = '';
						}
					}
				}
			} catch (FBAInventoryServiceMWS_Exception $ex) {
				$inventory['number'] = -1;
				$inventory['message'] = $ex->getMessage();
			}
			return $inventory;
		}
		
		/**
		 * Sync ALL Inventory levels for ALL products
		 *
		 * Works recursively when Amazon returns a NextToken. $next is usually empty, unless it gets set by recursion with NextToken
		 */
		function sync_all_inventory( $next = '' ) {
			// special log for inventory
			error_log(
				"---------------------------------------------------------------------<br />\n" .
				"Inventory Sync Running on " . date( "c", time() ) . "<br />\n" .
				"---------------------------------------------------------------------<br />\n",
				3, $this->ns_fba->inv_log_path
			);
			$service_inventory = $this->create_service_inventory();
			$inventory = $this->get_updated_inventory( $service_inventory, $next );
			$i = 0;
			// test for errors
			if ( $inventory['number'] > 0 && '' == $inventory['message'] ) {
				$items = $inventory['data'];
				foreach ( $items as $sku => $stock ) {
					$args = array(
						'posts_per_page'   	=> 1,
						'post_type' 		=> array( 'product', 'product_variation'),
						'meta_key'  		=> '_sku',
						'meta_value'		=> $sku,
					);
					$products = get_posts( $args );
					foreach ( $products as $product ) {
						$product_id = $product->ID;
                        $current_product = wc_get_product ( $product_id );
                        if ( $current_product ) {
                        	if ( $this->ns_fba->wc->is_woo_version( '3.0' ) ) {
                        		wc_update_product_stock( $current_product, $stock );
                        	} else {
                            	$current_product->set_stock( $stock );
							}
                            error_log( $i++ . ': >> Updated ' . $sku . ' stock to ' . $stock . "<br />\n", 3, $this->ns_fba->inv_log_path );
                        } else {
                            error_log( $i++ . ': >> SKIPPED ' . $sku . " because it does not exist in WooCommerce or there was another problem with it.<br />\n", 3, $this->ns_fba->inv_log_path );
                        }
                    }
				}
				if ( $inventory['next'] != '' ) {
					// Call recursively with the next token until we're done getting all inventory
					error_log( $i++ . ': >> Detected next token: ' . $inventory['next'] . " - calling recursively to complete sync.<br />\n", 3, $this->ns_fba->inv_log_path );
					$this->sync_all_inventory( $inventory['next'] );
				}
			} else {
				error_log( $i++ . ': <span style="color:red;"> >> Error updating stock' .
				           ' with FBA message: ' . $inventory['message'] . "</span><br />\n", 3, $this->ns_fba->inv_log_path );
			}
		}

		/**
		 * Get Inventory level for all items with recent inventory changes
		 *
		 * @return 	array	number = -1 for error otherwise number in inventory
		 * 					message = '' if success or error message if fail
		 */
		function get_updated_inventory ( $service, $next = '' ) {
			if ( '' == $next ) {
				$request = new FBAInventoryServiceMWS_Model_ListInventorySupplyRequest();
				$request->setMarketplaceId( NS_MARKETPLACE_ID );
				// if the manual sync button was used, adjust the timeframe to include all inventory
				// default is updates within the last day
				$timeframe = ' - 1 days';
				if ( isset ( $_POST['ns_fba_sync_inventory_manually'] ) ) {
					$timeframe = ' - 365 days';
				}
				// ISO 8601 date
				$request->setQueryStartDateTime(date( 'c', strtotime( date( "Y-m-d" ) . $timeframe ) ) );;
				if ( $this->ns_fba->is_debug ) {
					error_log( 'Set request for FBAInventoryServiceMWS_Model_ListInventorySupplyRequest ' . "<br />\n", 3, $this->ns_fba->inv_log_path );
				}
			} else {
				$request = new FBAInventoryServiceMWS_Model_ListInventorySupplyByNextTokenRequest();
				$request->setMarketplace( NS_MARKETPLACE_ID );
				$request->setNextToken( $next );
				if ( $this->ns_fba->is_debug ) {
					error_log( 'Set request for FBAInventoryServiceMWS_Model_ListInventorySupplyByNextTokenRequest ' . "<br />\n", 3, $this->ns_fba->inv_log_path );
					error_log( 'Next Token is: ' . $next . "<br />\n", 3, $this->ns_fba->inv_log_path );
				}
			}
			$request->setSellerId( NS_MERCHANT_ID );
			$inventory = array();
			$stock_data = array();
			$inventory['number'] = 0;
			$inventory['message'] = __('Inventory Response from FBA not Initialized or Received', $this->ns_fba->text_domain);
			$response = '';
			$results_available = false;
			try {
				if ( '' == $next ) {
					$response = $service->listInventorySupply($request);
					if ( $response->isSetListInventorySupplyResult() ) {
						$results_available = true;
					}
				} else {
					$response = $service->listInventorySupplyByNextToken($request);
					if ( $response->isSetListInventorySupplyByNextTokenResult() ) {
						$results_available = true;
					}
				}
				if ( $results_available ) {
					if ( '' == $next ) {
						$listInventorySupplyResult = $response->getListInventorySupplyResult();
					} else {
						$listInventorySupplyResult = $response->getListInventorySupplyByNextTokenResult();
					}
					if ( $listInventorySupplyResult->isSetInventorySupplyList() ) {
						$inventorySupplyList = $listInventorySupplyResult->getInventorySupplyList();
						$memberList = $inventorySupplyList->getmember();
						foreach ( $memberList as $member ) {
							if ( $member->isSetSellerSKU() && $member->isSetInStockSupplyQuantity() ) {
								// use the SKU for the key and stock number for the VALUE
								$stock_data[$member->getSellerSKU()] = $member->getInStockSupplyQuantity();
								$inventory['number'] = $inventory['number'] + 1;
							}
						}
					}
					if ($listInventorySupplyResult->isSetNextToken())
					{
						$inventory['next'] = $listInventorySupplyResult->getNextToken();
					} else {
						$inventory['next'] = '';
					}
					$inventory['data'] = &$stock_data;
					$inventory['message'] = '';
					$inventory['response'] = $response;
				}
			} catch (FBAInventoryServiceMWS_Exception $ex) {
				$inventory['number'] = -1;
				$inventory['message'] = $ex->getMessage();
				$inventory['response'] = $response;
			}
			return $inventory;
		}
	}
}