<?php 
/*  Template Name: About us */
get_header();
?>
 <?php 
  $about_banner = get_the_post_thumbnail_url($post_id , 'full');
 ?>
 <section class="heading-div" style="background-image:url(<?php echo $about_banner; ?>);">
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
                <div class="col-md-12 abt-div">
				     <?php $about_content_img = get_field('about_us_content_image',$post_id); ?>
                    <h2>About Zone365<img src="<?php echo $about_content_img; ?>" alt="image"/> </h2>
                    <?php
 					$about = get_post($post_id); 
					//print_r($about);
					echo $about->post_content;
					?>
			   </div>
            </div>
        </div>
    </section>
    <section class="btm-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="outer-sec1">
                        <h2>Our Vision</h2>
						<p><?php the_field('our_vision',$post_id); ?></p>
                     </div>
                    <div class="outer-sec1">
                        <h2>Our Mission</h2>
						<p><?php the_field('our_vision',$post_id); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php 
get_footer();
?>