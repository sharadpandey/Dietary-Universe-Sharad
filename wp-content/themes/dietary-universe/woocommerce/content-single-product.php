<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
global $product;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>
<section class="heading-div" style="background-image:url(<?php echo esc_url(get_template_directory_uri());?>/images/privacy-back.jpg);">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>Products</h1>
				<ol class="breadcrumb">
					<li><a href="#" class="active"><?php echo $product->name;?></a></li>
				</ol>
			</div>
		</div>
	</div>
</section>
	<section class="single-product">
		<div class="container">
			<div class="row">
				<?php 	global $product;	?>
				<div class="col-md-6 col-sm-6">
				<div class="product-gallery">
					<div id="custom_carousel" class="carousel slide" data-ride="carousel" data-interval="0">
						
						<div class="row clearfix">
						
							<div class="col-md-2 col-sm-3 col-xs-3 column">
								<div class="controls">
									<ul class="nav">
									<?php
									$i=0; 
									$attachment_ids = $product->get_gallery_attachment_ids();

									foreach( $attachment_ids as $attachment_id ) 
									{
									   $image_link = wp_get_attachment_url( $attachment_id );
									?>
										<li data-target="#custom_carousel" data-slide-to="<?php echo $i;?>" class="<?php if($i==0){ echo 'active';}?>">
											<a href="#"><img src="<?php echo $image_link;?>"></a>
										</li>
									<?php
									$i++;
									}
									wp_reset_query();
									?>
									</ul>
								</div>
							</div>
							
							<div class="col-md-10 col-sm-9 col-xs-9 column">
								<!-- Wrapper for slides -->
								<div class="carousel-inner">
									<?php 
									$j=0; 
									$attachment_ids = $product->get_gallery_attachment_ids();
									foreach( $attachment_ids as $attachment_id ) 
									{
										$image_links = wp_get_attachment_url( $attachment_id );
									?>	
										<div class="item <?php if($j==0){ echo 'active'; }?>">
											<div class="graph">
												<div class="graph-content"><img src="<?php echo $image_links;?>" alt="product-gallery"></div>
											</div>
										</div>
									<?php 
									$j++;
									}
									wp_reset_query();
									?>
								</div>
								<!-- End Carousel Inner -->
							</div>
						</div><!--row clearfix-->
					</div><!--carousel slide-->
				</div><!--product-gallery-->
			</div><!--col-md-6-->
				<div class="col-md-6 col-sm-6">
					<div class="product-description">
							<?php do_action( 'woocommerce_single_product_summary' );?>					
					</div>
				</div>
			</div>
		</div>
	</section>	
	

	<?php do_action( 'woocommerce_after_single_product_summary' );  	?> 

<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		/**
		 * woocommerce_before_single_product_summary hook.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		/* do_action( 'woocommerce_before_single_product_summary' ); */
	?>

	<div class="summary entry-summary">

		<?php
			/**
			 * woocommerce_single_product_summary hook.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
			/* do_action( 'woocommerce_single_product_summary' ); */
		?>

	</div><!-- .summary -->

	<?php
		/**
		 * woocommerce_after_single_product_summary hook.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		/*  do_action( 'woocommerce_after_single_product_summary' );  */
	?>

</div><!-- #product-<?php the_ID(); ?> -->

<?php /* do_action( 'woocommerce_after_single_product' ); */ ?>
