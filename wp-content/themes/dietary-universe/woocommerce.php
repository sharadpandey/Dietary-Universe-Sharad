<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); 
?>
<div class="woocommerce">
<?php
	
	if ( is_singular('product') ) 
	{
		woocommerce_content();
       //include(ABSPATH.'wp-content/themes/ibreeze/woocommerce/product_single_page.php');
    }
	elseif(is_shop())
	{
		include(ABSPATH.'wp-content/themes/dietary-universe/woocommerce/showProduct.php');
		/* $queried_object = get_queried_object();
		$term_id = $queried_object->term_id;
		$parent = $queried_object->parent;
	
		if($parent==0)
		{
			include(ABSPATH.'wp-content/themes/ibreeze/woocommerce/product_sub_cat.php');
			
		}
		else
		{
			include(ABSPATH.'wp-content/themes/ibreeze/woocommerce/show_product_per_category.php');
			//woocommerce_content();
		} */
	}
	
	
?>
</div>
<?php
 get_footer(); ?>