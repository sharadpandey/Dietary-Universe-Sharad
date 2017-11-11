<?php 
/* Template Name: Faq  */
get_header();
?>
<?php $faq_banner = get_the_post_thumbnail_url($post_id,'full'); ?>
<section class="heading-div" style="background-image:url(<?php echo $faq_banner; ?>);">
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
    <section class="FAQ">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="about-page-content testimonial-page">
                        <h2> General Questions</h2>
                        <div class="faq-content">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
							<?php
							$i=1;
							if(have_rows('faq_contents')): 
                            while(have_rows('faq_contents')): the_row('faq_contents');
							?>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab">
                                        <h4 class="panel-title">
											<a class="<?php if($i>1){ echo "collapsed"; } ?>" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq<?php echo $i; ?>">
											  <span class="pnael-text"><?php the_sub_field('question'); ?></span>
											</a>
										  </h4>
										</div>
                                    <div id="faq<?php echo $i; ?>" class="panel-collapse collapse <?php if($i==1){ echo "in"; } ?>" role="tabpanel" aria-labelledby="heading<?php echo $i; ?>">
                                        <div class="panel-body"><?php the_sub_field('answer'); ?></div>
                                    </div>
                                </div>
								<?php 
								      $i++;
								      endwhile; 
							          endif; 
							   ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php 
get_footer();
?>