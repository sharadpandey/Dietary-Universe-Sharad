<?php
	/**
		* The Template for displaying products in a product category. Simply includes the archive template
		*
		* This template can be overridden by copying it to yourtheme/woocommerce/taxonomy-product_cat.php.
		*
		* HOWEVER, on occasion WooCommerce will need to update template files and you
		* (the theme developer) will need to copy the new files to your theme to
		* maintain compatibility. We try to do this as little as possible, but it does
		* happen. When this occurs the version of the template file will be bumped and
		* the readme will list any important changes.
		*
		* @see 	    https://docs.woocommerce.com/document/template-structure/
		* @package 	WooCommerce/Templates
		* @version     1.6.4
	*/
	get_header();
	
?>
<section class="heading-div" style="background-image:url(<?php echo esc_url(get_template_directory_uri());?>/images/privacy-back.jpg);">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>Products</h1>
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#" class="active">Products</a></li>
				</ol>
			</div>
		</div>
	</div>
</section>
<section class="products-page">
		<div class="container">
			<div class="row">
				<h2>FEATURED PRODUCTS</h2>
				<?php
				$args = array( 'post_type' => 'product', 'posts_per_page' => -1, 'orderby' => 'title' );
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
				
				<div class="col-md-3 col-sm-4 products">
					<div class="pro-sec">
						<a href="<?php the_permalink();?>">
							<?php 
								if ( has_post_thumbnail() ) 
								{
									$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
								?>
								<img src="<?php echo $image[0]; ?>" alt="imgae" class="product-img" />
								<?php
								} 
								else 
								{ 
								?>
								<img src="http://placehold.it/200x200&amp;text=No image found" alt="<?php the_title(); ?>" alt="imgae" class="product-img"/>
								<?php 
								}
							?>
						</a>
						<div class="pro-text">
							<h4><a href="<?php the_permalink();?>"><?php $trimtitle = get_the_title();echo $trimtitle = substr($trimtitle, 0, 60);?>...</a></h4>
							<?php the_excerpt();?>
							<strong><?php echo $product->get_price_html(); ?></strong>
							<!--<span class="rate">$<?php //echo $product->get_regular_price(); ?> </span>--> 
							<span class="stars"><img src="<?php echo esc_url(get_template_directory_uri());?>/images/ratingimg.png" alt=""/></span>
							<div class="pro-btns"> 
								<a href="<?php the_permalink();?>" class="main-btn">Buy from website</a> 
								<a href="<?php the_field('amazon_product_link',$post->ID);?>" class="main-btn pull-right">Buy from Amazon</a> 
							</div>
						</div>
					</div>
				</div>
				
				
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
				
			</div>
		</div>
</section>


<?php get_footer();?>