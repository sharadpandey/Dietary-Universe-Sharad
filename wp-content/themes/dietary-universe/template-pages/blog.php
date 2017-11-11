<?php 
/* Template Name: Blog  */
get_header();
?>
<?php $blog_banner = get_the_post_thumbnail_url($post_id,'full'); ?>
<section class="heading-div" style="background-image:url(<?php echo $blog_banner; ?>);">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><?php the_title(); ?></h1>
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li><a href="#" class="active"><?php the_title(); ?></a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="blog">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
				<?php 
				global $post;
				global $wpdb;
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$blog_post = array('post_type'=>'post',
								   'posts_per_page'=> 4,
								   'paged' => $paged); 
			    $blog_data = query_posts($blog_post);
				if ( have_posts() ) {
				while (have_posts() ) { the_post();
				?>
				
                    <div class="inner-blog">
					  <?php $blog_img = get_the_post_thumbnail_url($post_id,'full'); ?>
                        <a href="<?php echo get_permalink(); ?>"><img src="<?php echo $blog_img; ?>" alt="image" /></a>
                        <div class="blog-text">
                            <h3><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <ul>
                                <li>Posted by <a href="#"><?php echo get_author_name(); ?></a><strong>|</strong></li>
                                <li><?php echo get_the_date( 'F d Y'); ?><strong>|</strong> </li>
								<?php $my_var = get_comments_number( $post_id ); ?>
                                <li><?php if($my_var==""){echo "0";}else {echo $my_var; } ?> Comments</li>
                            </ul>
                            <div class="clearfix"></div>
                            <?php $blog_content = get_the_content(); ?>
                             <p><?php echo wp_trim_words($blog_content, $num_words = 50); ?></p>  
						</div>
                    </div>
						 <?php } 
						  if ( $wp_query->max_num_pages > 1 ) : 
						  $my_pages=my_pagination();
						?>
					
                    <nav aria-label="Page navigation ">
                        <ul class="pagination btm-nav">
                            
                            <?php
								foreach($my_pages as $my_page){
								 ?>
								<li><?php echo $my_page; ?></li>
								<?php
								}
							?>
                           
                        </ul>
                    </nav>
						<?php
					 endif;	
					  wp_reset_query();     
					} ?>
                </div>
                <div class="col-md-4 blog-rytdv">
                    <div class="searchbar">
                        <div class="input-group">
                            <input class="form-control" placeholder="Search for..."> <span class="input-group-btn"> <button class="btn btn-default" type="button"><i class="fa fa-search" aria-hidden="true"></i></button> </span> </div>
                    </div>
                    <div class="categories">
                        <h4>Categories</h4>				
                        <ul class="list-group">
							<?php  
							$argg=array('taxonomies'=>'category',
									   ); 
							$cat=get_categories($argg);
							foreach($cat as $cats)
									 {
						   $cname=$cats->name;  
						   $category_link = get_category_link($cats->cat_ID);
						?>
                            <li class="list-group-item"><a href="<?php echo $category_link; ?>"><?php echo $cname;  ?></a></li>
						<?php 
									 }
						?>
                        </ul>
                    </div>
                    <div class="archieves">
                        <h4>Archives</h4>
                        <ul class="list-group">
                            <li class="list-group-item"><a href="#">January 2017</a></li>
                            <li class="list-group-item"><a href="#">March 2017</a></li>
                            <li class="list-group-item"><a href="#">April 2017</a></li>
                            <li class="list-group-item"><a href="#">May 2017</a></li>
                            <li class="list-group-item"><a href="#">June 2017</a></li>
                        </ul>
                    </div>
                    <div class="tags">
                        <h4>Tags</h4>
                        <ul>
						 <?php
					
					$tags = get_tags(array(
					  'hide_empty' => false
					));
					//print_r($tags);
					foreach ($tags as $tag) {
				     ?>
                          
                            <li><a href="<?php echo get_term_link($tag); ?>"><?php echo $tag->name ?></a></li>
					<?php } ?>  
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php 
get_footer();
?>