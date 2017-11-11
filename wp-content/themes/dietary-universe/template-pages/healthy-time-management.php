<?php
/* Template Name: Healthy Time Management  */
get_header();
 ?>
 <?php $health_time_banner = get_the_post_thumbnail_url($post_id,'full'); ?>
 <section class="heading-div" style="background-image:url(<?php echo $health_time_banner; ?>);">
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
                <div class="col-md-12 abt-div content-sec sec-cnt">
				      <?php
					  $health_content = get_post($post_id);
					  echo $health_content->post_content;
					  ?>
                      <div class="outer-sec1 order-list">
					  <?php $health = get_field('health_time_management_content_image',$post_id); ?>
                        <h4>Path to improved health<img src="<?php echo $health; ?>" alt="image"/> </h4><br />
                        <?php the_field('health_path_to_improved',$post_id); ?>
                    </div>
                    <div class="outer-sec1 ">
                         <?php the_field('health_privacy_policy_1',$post_id); ?>
				    </div>
                    <div class="outer-sec1">
                       <?php the_field('health_privacy_policy_2',$post_id); ?>
					 </div>
                </div>
            </div>
        </div>
        </div>
    </section>
 
 <?php 
 get_footer();
 ?>