<?php 
/* Template Name: Healty Food Choices */
get_header();
?>
<?php $healthy_food_banner = get_the_post_thumbnail_url($post_id,'full'); ?>
<section class="heading-div" style="background-image:url(<?php echo $healthy_food_banner; ?>);">
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
    <section class="about-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 abt-div content-sec ">
				    <?php $content_img = get_field('healthy_food_content_image',$post_id); ?>
                    <h2>Healthy Food Choices<img src="<?php echo $content_img; ?>" alt="image"/> </h2>
					<?php 
					$health_food = get_post($post_id);
					echo "<p>".$health_food->post_content ."</p>";
					?>
				
                    <div class="outer-sec1">
                      <?php the_field('path_to_improve_content',$post_id); ?>  
					</div>
                    <div class="outer-sec1 order-list">
                       <?php the_field('grains',$post_id); ?>  
                    </div>
                    <div class="outer-sec1">
                        <?php the_field('formating_privacy_policy_1',$post_id); ?>  
					</div>
                    <div class="outer-sec1">
                        <?php the_field('formating_privacy_policy_2',$post_id); ?> 
					</div>
                </div>
            </div>
        </div>
        </div>
    </section>


<?php 
get_footer();
?>