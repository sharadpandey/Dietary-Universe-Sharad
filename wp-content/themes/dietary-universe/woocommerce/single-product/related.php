<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
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
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : 



$terms = get_the_terms( get_the_ID(), 'product_cat' );

$term_id = $terms[0]->term_id;
$term_slug = $terms[0]->slug;
$term_name = $terms[0]->name;

?>
<section class="related-products">
		<div class="container">
			<h2 class="head2"><?php esc_html_e( 'Related products', 'woocommerce' ); ?></h2>
			<div class="row">
		
		<?php
        $args = array( 'post_type' => 'product', 'posts_per_page' => 4, 'product_cat' => $term_slug, 'order' =>'DESC' );
        $loop = new WP_Query( $args );
		if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>

             
			<div class="col-sm-6 col-md-3">
				<div class="single-pro">
					<a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
					<?php 
						if ( has_post_thumbnail() ) 
						{
							$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
					?>
							<span class="hover-box" style="background-image: url('<?php echo $image[0]; ?>');"></span>
					<?php
						} 
						else 
						{ 
					?>
							<span class="hover-box" style="background-image: url('http://placehold.it/262x240&amp;text=No image found');" alt="<?php the_title(); ?>" class="img-responsive"></span>
					<?php 
						}
					?>	
					</a>
					<h3 class="pro-title"><?php the_title(); ?></h3>
					<div class="pro-content">

						<p><?php the_excerpt(); ?></p>

					</div>
					<div class="pro-bottom">
						<span><span class="price-green"><?php echo $product->get_price_html(); ?></span></span>
						<a href="<?php echo get_permalink( $loop->post->ID ) ?>" class="btn pro-link">view product</a>
					</div>
				</div>
			</div>
					
			<?php endwhile; 
			wp_reset_query();  
			else: ?>
				    <div class="col-sm-12 col-md-12">
						<div class="single-pro">
							<h2 class="pro-title cls-no-product">NO PRODUCT AVAILABLE...</h2>
						</div>
					</div>	
			<?php endif; ?>
			
			
		</div><!--row--> 
		</div>
	</section>




<!--<section id="product-<?php //the_ID(); ?>" class="related products">
	<div class="container">
		<h2 class="head2"><?php// esc_html_e( 'Related products', 'woocommerce' ); ?></h2>
		<div class="row">
			<?php //woocommerce_product_loop_start(); ?>

				<?php //foreach ( $related_products as $related_product ) : ?>

					<?php
						//$post_object = get_post( $related_product->get_id() );

						//setup_postdata( $GLOBALS['post'] =& $post_object );						
						
						//wc_get_template_part( 'content', 'product' ); ?>

				<?php// endforeach; ?>

			<?php //woocommerce_product_loop_end(); ?>
		</div>
	</div>
</section>-->

<?php endif;

wp_reset_postdata();
