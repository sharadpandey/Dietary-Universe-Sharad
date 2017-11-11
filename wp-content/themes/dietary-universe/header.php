<?php
	/**
		* The template for displaying the header
		*
		* Displays all of the head element and everything up until the "site-content" div.
		*
		* @package WordPress
		* @subpackage Twenty_Sixteen
		* @since Twenty Sixteen 1.0
	*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php wp_head(); ?>
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.png" type="image/x-icon">
		<!-- Bootstrap -->
		<link href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo get_template_directory_uri(); ?>/css/font-awesome.min.css" rel="stylesheet">
		<link href="<?php echo get_template_directory_uri(); ?>/css/owl.carousel.min.css" rel="stylesheet">
		<link href="<?php echo get_template_directory_uri(); ?>/style.css" rel="stylesheet">
        <link href="<?php echo get_template_directory_uri(); ?>/css/style.css" rel="stylesheet">
		
	</head>
	<body>
		<header>
			<nav class="navbar navbar-default">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
						<a class="navbar-brand" href="<?php echo site_url(); ?>"><img src="<?php the_field('site_logo','options'); ?>" alt="image"></a>
					</div>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="top-link-menu">
						<ul>
							<li><a href="#" data-toggle="modal" data-target="#login"><i class="fa fa-lock" aria-hidden="true"></i> LogIn/Register</a></li>
							
							
						</ul>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav navbar-right">
						
						<!--START CODE USE FOR GETTING Header Menu-->
						<?php

							$defaults = array(
							'theme_location'  => '',
							'menu'            => 'Header Menu',
							'container'       => '',
							'container_class' => '',
							'container_id'    => '',
							'menu_class'      => 'menu',
							'menu_id'         => '',
							'echo'            => true,
							'fallback_cb'     => 'wp_page_menu',
							'before'          => '',
							'after'           => '',
							'link_before'     => '',
							'link_after'      => '',
							'items_wrap'      => '%3$s',
							'depth'           => 0,
							'walker'          => ''
							);

							wp_nav_menu( $defaults );
						?>
						<!--END OF CODE USE FOR GETTING Header Menu-->
						
							<?php /* <li><a href="index.html" class="active">Home</a></li>
							<li><a href="about-us.html" >About Us</a></li>
							<li><a href="healthy-food-choices.html">Healthy Food Choices</a></li>
							<li><a href="healty-time-management.html">Healthy Time Management</a></li>
							<li><a href="products.html">Products</a></li>
							<li><a href="blog.html">Blog</a></li>
							<li><a href="faq.html"> FAQ</a></li>
							<li><a href="contact-us.html">Contact Us</a></li> */?>
							
							
							<li class="nav-search"><a href="#search"><i class="fa fa-search" aria-hidden="true"></i></a></li>
							<li class="cart-icon "><a href="<?php echo get_permalink(132);?>">Cart / <?php echo WC()->cart->get_cart_total(); ?><span><?php echo WC()->cart->get_cart_contents_count();?></span><svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
								viewBox="64.97 0 382.076 512" enable-background="new 64.97 0 382.076 512" xml:space="preserve">
									<g>
										<path fill="#26B8C5" d="M439.28,512H72.735c-2.125,0-4.158-0.869-5.616-2.405c-1.458-1.535-2.234-3.599-2.141-5.725l17.455-366.545
										c0.202-4.143,3.6-7.385,7.757-7.385h331.637c4.143,0,7.556,3.243,7.758,7.385l17.454,366.545c0.093,2.126-0.667,4.189-2.142,5.725
										C443.423,511.131,441.391,512,439.28,512z M80.865,496.484h350.27l-16.71-351.03H97.575L80.865,496.484z"/>
										<path fill="#26B8C5" d="M339.859,176.485c-4.282,0-7.758-3.476-7.758-7.757v-77.11c0-41.953-34.133-76.102-76.102-76.102
										c-41.968,0-76.102,34.149-76.102,76.102v77.11c0,4.282-3.475,7.757-7.757,7.757s-7.758-3.476-7.758-7.757v-77.11
										C164.383,41.1,205.483,0,256,0c50.518,0,91.617,41.1,91.617,91.617v77.11C347.617,173.009,344.157,176.485,339.859,176.485z"/>
									</g>
								</svg>
							</a></li>
						</ul>
						<?php //wp_nav_menu(array('menu'=>'Header Menu', 'menu_class'=>'nav navbar-nav navbar-right' ,'theme_location'=>'Primary Menu'));?>
						
						
						
					</div>
					<!-- /.navbar-collapse -->
                        <div class="search"><a href="#search"><i class="fa fa-search" aria-hidden="true"></i></a></div>
                	<div class="cart-icon">
                        
                        <a href="<?php echo get_permalink(132);?>">Cart / <?php echo WC()->cart->get_cart_total(); ?><span><?php echo WC()->cart->get_cart_contents_count();?></span>

                            <svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
								viewBox="64.97 0 382.076 512" enable-background="new 64.97 0 382.076 512" xml:space="preserve">
									<g>
										<path fill="#26B8C5" d="M439.28,512H72.735c-2.125,0-4.158-0.869-5.616-2.405c-1.458-1.535-2.234-3.599-2.141-5.725l17.455-366.545
										c0.202-4.143,3.6-7.385,7.757-7.385h331.637c4.143,0,7.556,3.243,7.758,7.385l17.454,366.545c0.093,2.126-0.667,4.189-2.142,5.725
										C443.423,511.131,441.391,512,439.28,512z M80.865,496.484h350.27l-16.71-351.03H97.575L80.865,496.484z"/>
										<path fill="#26B8C5" d="M339.859,176.485c-4.282,0-7.758-3.476-7.758-7.757v-77.11c0-41.953-34.133-76.102-76.102-76.102
										c-41.968,0-76.102,34.149-76.102,76.102v77.11c0,4.282-3.475,7.757-7.757,7.757s-7.758-3.476-7.758-7.757v-77.11
										C164.383,41.1,205.483,0,256,0c50.518,0,91.617,41.1,91.617,91.617v77.11C347.617,173.009,344.157,176.485,339.859,176.485z"/>
									</g>
								</svg>


<!--
                            <style>
                                .cart-icon a span {background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="64.97 0 382.076 512"><g><path fill="#26B8C5" d="M439.28,512H72.735c-2.125,0-4.158-0.869-5.616-2.405c-1.458-1.535-2.234-3.599-2.141-5.725l17.455-366.545 c0.202-4.143,3.6-7.385,7.757-7.385h331.637c4.143,0,7.556,3.243,7.758,7.385l17.454,366.545c0.093,2.126-0.667,4.189-2.142,5.725 C443.423,511.131,441.391,512,439.28,512z M80.865,496.484h350.27l-16.71-351.03H97.575L80.865,496.484z"></path><path fill="#26B8C5" d="M339.859,176.485c-4.282,0-7.758-3.476-7.758-7.757v-77.11c0-41.953-34.133-76.102-76.102-76.102 c-41.968,0-76.102,34.149-76.102,76.102v77.11c0,4.282-3.475,7.757-7.757,7.757s-7.758-3.476-7.758-7.757v-77.11 C164.383,41.1,205.483,0,256,0c50.518,0,91.617,41.1,91.617,91.617v77.11C347.617,173.009,344.157,176.485,339.859,176.485z"/></g></svg><svg id="Capa_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 56.966 56.966">')}
                            </style>
-->
							</a></div>
				</div>
                 
				<!-- /.container -->
			</nav>
		</header>
<script type="text/javascript">

jQuery(function($) {
	jQuery('#user_login').validate({
		
		rules: {
			username: {
				required: true
			},
			
			user_pass: {
				required: true
			}
		},
		messages: {
			username: {
				required: "<?php _e( 'Please provide an Email', 'agrg' ); ?>",
			},
			
			user_pass: {
				required: "<?php _e( 'Please provide a password', 'agrg' ); ?>",
			}
			
		},
		
		submitHandler: function(form) {
			jQuery("#loading").show();		
				jQuery(form).ajaxSubmit({
				type: "POST",
				data: jQuery(form).serialize(),
				url: '<?php echo admin_url('admin-ajax.php'); ?>', 
				success: function(data) 
				{
				
				    if(data==1)
					{
						jQuery("#loading").hide();
						jQuery('#result').empty().append('<div class="alert alert-danger">Email does not exists.</div>').show();
					}
					if(data==2)
					{
						jQuery("#loading").hide();
						jQuery('#result').empty().append('<div class="alert alert-danger">Password doesn’t match our records</div>').show();
					}
					if(data==3)
					{
						jQuery("#loading").hide();
						window.location.href="<?php echo get_permalink(134); ?>"; 
					}
						
				}
			});
		}
		
	});
});
jQuery(function ($) {
    /*-------------------Registration form Vendor-----------------------*/
    jQuery('#registeruser').validate({
        rules: {
            reg_username: {
                required: true,
                number: false
            },
            reg_useremail: {
                required: true,
                email: true,
            },
            reg_userpassword: {
                required: true
            },
            reg_user_conf_pass: {
                required: true,
            },
        },

        submitHandler: function (form) {
            jQuery("#load_user").show();
            jQuery(form).ajaxSubmit({
                type: "POST",
                data: jQuery(form).serialize(),
				url:"<?php bloginfo('template_url'); ?>/ajax/registerUser.php",
                success: function (data) {
                    if (data == 1) {
                        jQuery("#registeruser")[0].reset();
						jQuery('#resultreg').empty().append('<div class="alert alert-success">Registered successfully.</div>').show();
                    } else if (data == 2) {
                        jQuery('#resultreg').empty().append('<div class="alert alert-danger">Email already exists.</div>').show();
                    }else if (data == 3) {
                        jQuery('#resultreg').empty().append('<div class="alert alert-warning">Password Mismatch.</div>').show();
                    }
                }
            });
        }
    });
});
</script>