# WooCommerce Amazon Fulfillment
An integration between WooCommerce and Fulfillment by Amazon (FBA) by Never Settle.

## Description
This plugin integrates Amazon Fulfillment (FBA) with WooCommerce to provide a powerful automated shipping solution to store owners. It requires an active Amazon Pro Seller account and FBA service as well as MWS credentials which you can generate in your Seller Central dashboard. The plugin includes links to register for MWS credentials in the settings.

## Features 
* Ultimate flexibility: Select which individual products you want to be handled by FBA and which ones you want to manually fulfill
* Map Amazon Shipping Speeds to WooCommerce shipping methods (massively improved in version 1.1.0.1)!
* Automatically sends orders to FBA for fulfillment when payment is received
* Manually submit orders to FBA if necessary
* Easily track the current status of fulfillment orders on the normal Orders screen with support for both full and partial fulfillment (orders can be mixed)
* Fully integrated into standard WooCommerce conventions and processes like order status, order notes, etc.
* Supports THREE inventory sync modes: Update local product stock numbers from FBA inventory every time an order is placed; and/or update local stock numbers automatically on an hourly schedule; and/or manually trigger a full inventory sync from Amazon stock level numbers (also a good idea to do when setting up the integration)
* Supports international fulfillment through FBA as long as your FBA policy allows it, but also now supports turning OFF fulfillment for international shipping addresses as of version 1.1.0.1
* The customer receives a shipping notice from FBA when the order actually ships (this can be disabled as of version 1.1.0.2)
* The customer can access shipping and tracking information right from their View Order page in their My Account area
* Receive shipping notifications to your WP admin email address or set a different address to receive notifications
* Receive email notifications at the site admin address when an FBA submission fails and optionally turn those notifications OFF
* As of version 1.1.0.1 – ALL new Smart Fulfillment decision engine with granular control of when NS FBA should or should not send fulfillment requests to Amazon at both the order and the item level
* Manual override settings to bypass other active conditions when an order is Manually sent to FBA
* Option to disable sending orders to FBA that match specific shipping methods
* Vacation Mode to enable sending to FBA regardless of product settings
* Perfection Mode to disable sending to FBA if ALL products in an order are not set to Fulfill with Amazon FBA
* Option to monitor for shipping status from Amazon and set the order status to Completed when shipping status has been detected
* And more!

## How it Works
* NS FBA adds a new option in the product settings shipping tab to turn on "Fulfill with Amazon FBA" per product
* NS FBA adds 3 new order statuses to WooCommerce: sent-to-fba, part-to-fba, and fail-to-fba
* These new statuses will be set automatically based on the results of the order submission to FBA. These statuses will also show unique icons in the Orders view so that you can quickly see where things are at. 
* Once everything is configured correctly per the instructions in the Installation section, NS FBA works automatically behind the scenes to send all order items marked for fulfillment to FBA when WooCommerce detects that the order payment is complete.
* Important note: This event is only automatically triggered with electronic payment gateways like Stripe, and PayPal. If you are accepting manual forms of payment like checks, the process will not be completely automatic. You will need to manually send the order to FBA using the new custom Order Action "Send to Amazon FBA" when you have received payment.  
* NS FBA also includes minor style tweaks to the existing Order Status icons to make them larger and easier to see based on Danny Santoro's post here: http://danielsantoro.com/customize-woocommerce-order-status-icons/
* The fulfillment request sends the proper data to trigger a shipping notification email from Amazon when it is actually shipped. This email will go to the customer's email address and the site's WordPress admin email address.
* Whether the fulfillment request is successfully submitted to FBA or not, in both cases, it will add an order note to the order with details and a link to the full log.
* If there is an error with an order submission to FBA it will also email the site admin a notification. NOTE: this functionality depends on a properly configured environment for PHP error_log() with the email parameter set to work.
* Note: NS FBA currently only syncs stock levels between Amazon and WooCommerce depending on your settings. It cannot sync or import other product data from Amazon (although that is on our radar to build)

## Installation
1. Install like any other plugin by uploading the zip through the WordPress dashboard and activating it on your WooCommerce site
2. Configure your MWS settings and options on the new Amazon Fulfillment menu item under the main WooCommerce menu
3. Test your API credentials with the test button to make sure your connection is working
4. Make 100% sure that all your SKUs in WooCommerce that you want to fulfill through FBA match your Seller SKUs inside FBA
5. Go through every product in WooCommerce that you want to send to FBA, check the new "Fulfill with Amazon FBA" option in the product general tab, and save
6. NS FBA for WooCommerce works behind the scenes to send all order's shipping information to Amazon
7. For manual forms of payment like checks, or to manually re-submit an order to fulfillment, you can use the new custom order Action "Send to Amazon FBA" (but use that carefully)

## Frequently Asked Questions

Available at https://neversettle.it/documentation/ns-fba-woocommerce/

## Screenshots

Available at https://neversettle.it/documentation/ns-fba-woocommerce/

## Changelog

### 3.0.7
* Initial release on Woo Market
* Removed legacy plugin license and updating mechanisms
* Added support for WooCommerce updates via Woo header
* Shifted Order-level rule checking to come after all individual order items have been checked for FBA fulfillment setting

### 3.0.6
* Added Multisite support for the licensing and updates components 

### 3.0.5
* Additional WC3 fixes

### 3.0.4
* Fixed issue with international shipping setting on/off not being honored

### 3.0.3
* Added ability for the new version to automatically backup and pull in settings from v2 format
* Updated several deprecated calls to their WC 3.0 equivalent
* Fixed timing sequence of manual inventory sync to ensure it happens after woocommerce_init since it calls wc_get_product

### 3.0.2
* Fixed issue introduced by WC 3.0 which breaks returning a WC_Product directly for inventory updates

### 3.0.1 
* Documentation updates and file name changes for Woo

### 3.0.0.1 
* Major overhaul for WooCommerce Marketplace
* Converted all settings to WC Integration implementation
* Hide other settings until the integration is properly configured
* Added FBA on/off toggle to the WooCommerce product list table

### 2.0.0.5 
* Added support for Amazon India Region

### 2.0.0.4 
* Put back old behavior of saving the settings and then running inventory test when test is clicked

### 2.0.0.3 
* Fix to amazon bug with marketplace ID not working on FulfillmentOrderRequest for US + CAD consolidated accounts

### 2.0.0.1 
* Fix for scenario that can lead to a fatal error with simple products getting submitted to FBA

### 2.0.0.0  
* Major version bump that should have happened instead of 1.1.0.0
* Obfuscated log file names
* Updated to latest marketplace ID distinction for inventory checks to fix US vs Canada inventory discrepency

### 1.1.0.3 
* Added feature to send parent SKU instead of variation SKU per product 

### 1.1.0.2 
* Added option to disable Amazon shipping notice email to customer email address
* Added logging for character encoding conversions
* Added option to override encoding character check and pass the order to FBA regardless
* Added new icon to highlight new features as they are released
* Added new option to sync fulfillment status from FBA and automatically update order status to Completed
* Added new option to bypass encoding conversion completely

### 1.1.0.1 
* Moved product setting Fulfill with Amazon FBA to the Product Shipping tab
* Massive code cleanup and refactor
* Added option to turn error email messages ON/OFF when an order fails to send to FBA
* All new smart fulfillment decision engine with granular control at the order and item level
* Added manual override settings to bypass other conditions when order is manually sent to FBA
* Added setting to disable sending to FBA for international orders
* Added setting to disable sending to FBA for specific shipping methods
* Added Vacation Mode to enable sending to FBA regardless of product settings
* Added Perfection Mode to disable sending to FBA if ALL products in an order are not set to Fulfill with Amazon FBA
* Added option and features to display shipping and tracking information to the customer order view page

### 1.1.0.0 
* Massive overhaul of settings and many improvements
* Reorganized order of settings to be more intuitive
* Converted all applicable settings to multi-select with pre-filled values
* Dynamically pulling all active shipping methods now for mapping to Amazon Shipping Speeds 

### 1.0.9.1 
* Added failsafe to catch orders that have un-convertable encodings and notify admin so they can edit the address before sending
* Updated to remove WC deprecated parameters in email_order_items_table()

### 1.0.9.0 
* Added full international translation support

### 1.0.8.7 
* Added support for the Sequential Order Numbers Pro extension. NS FBA now sends this value to Amazon instead of the internal ID. 

### 1.0.8.6 
* Fixed bug in Wordpress 4.6 when querying terms

### 1.0.8.5 
* Fixed bug in Amazon PHP library in later versions of PHP with duplicated parameters in function

### 1.0.8.4 
* Added conversion for non-Latin-1 characters to prevent Amazon from rejecting orders

### 1.0.8.3 
* Added new custom status "Partial to FBA" for tracking mixed orders
* Added conditions, handling, and new icon for Partial to FBA status

### 1.0.8.2 
* Added additional param for Kint check to deconflict with other plugins
* Added experimental param to allow manual order send to override product fulfillment setting

### 1.0.8.1 
* Updated to latest Amazon API PHP Library versions

### 1.0.8.0 
* Modified Address handling to dynamically set Name to Company name if specified and Line 1 to Person name

### 1.0.7.9 
* Modified Amazon PHP Library constant names to deconflict with other plugins that use the same library

### 1.0.7.8 
* Modified the behavior of the manual inventory sync button to pull in all items that had inventory levels change in last 365 days

### 1.0.7.7 
* Fixed custom statuses and call to woocommerce_reports_order_statuses filter that WooCommerce broke in 2.2.10

### 1.0.7.6 
* Added custom currency override for stores selling in a different currency than their default Amazon Marketplace currency
* Improved stock level sync support for stores with large inventories (many skus) 

### 1.0.7.5 
* Added backwards compatibility with PHP 5.2 and earlier which does not support anonymous functions
* Added new DEBUG mode with additional checking and logging to help troubleshoot problematic edge cases
* Added new order note in scenarios where no products in the order are set to fulfill with FBA

### 1.0.7.4 
* Added setting to specify a different email address to include in Amazon's notify list for order events. Default is still to use the WP admin email address for this. 

### 1.0.7.3 
* Added button to manually initiate full inventory sync

### 1.0.7.2 
* Fixed bug introduced by 1.0.7.1 because Amazon was returning an error about perUnitPrice only being for Cash on Delivery orders  

### 1.0.7.1 
* Added support for international orders by adding Amazon's required declared value properties in the fulfillment API requests  

### 1.0.7 
* Added automated hourly inventory sync functionality and option 
* Added logging for inventory sync updates 

### 1.0.6.1 
* Fixed bug with inventory sync on variations

### 1.0.6 
* Added 1-way inventory sync feature from Amazon > WooCommerce
* Fixed bug with WooCommerce reporting leaving out custom FBA status orders

### 1.0.5.1 
* Added variation support

### 1.0.5 
* Added per-order shipping speed settings to map to Flat Rate methods

### 1.0.4 
* Updated for WooCommerce 2.2 to work with new custom statuses structure

### 1.0.3  
* Added side-bar

### 1.0.2 
* First public release
