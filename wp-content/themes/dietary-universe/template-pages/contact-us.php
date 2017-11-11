<?php 
/* Template Name: Contact Us  */
get_header();
?>
 <?php $contact_banner = get_the_post_thumbnail_url($post_id,"full"); ?>
   <section class="heading-div" style="background-image:url(<?php echo $contact_banner; ?>);">
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
    <section class="Contactus">
        <div class="map-div">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2980.1413239033436!2d-88.00089148505533!3d41.67429118612361!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x880e44bb3bd2d6a9%3A0x4ecb7b0b7ccb0edd!2s202+Stephen+St%2C+Lemont%2C+IL+60439%2C+USA!5e0!3m2!1sen!2sin!4v1503399673171" style="border:0" allowfullscreen></iframe>
        </div>
        <div class="inner-div">
            <?php 
			$contact_data = get_post($post_id); 
			echo $contact_data->post_content;
			?>
        </div>
        </div>
    </section>
    <section class="contact-form">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                      <?php echo do_shortcode('[contact-form-7 id="68" title="Contact form 1"]'); ?>
                </div>
            </div>
        </div>
    </section>
<?php 
get_footer();
?>