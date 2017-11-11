<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>
 <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-3 ftr-text">
                    <h4>About you business</h4>
                    <p><?php the_field('about_your_bussiness','options'); ?></p>
                </div>
                <div class="col-md-3 qick-links">
                    <h4>Quick Links</h4>
						<ul class="left-links">
						<?php
							$defaults = array(
							'theme_location'  => '',
							'menu'            => 'Footer_menu',
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
						
						</ul>
                     
                </div>
                <div class="col-md-3 contct-info">
                   <?php the_field('footer_address','options'); ?>
                </div>
                <div class="col-md-3 subscribe">
                    <h4>Subscribe</h4>
                    <form>
                        <label>Enter your email to subscirbe for the Newsletter</label>
                        <div class="input-group">
                            <input class="form-control" placeholder=""> <span class="input-group-btn"> <button class="btn btn-default" type="button">Submit</button> </span> </div>
                    </form>
                    <ul class="social-blog">
                        <li><a href="<?php the_field('facebook_link','options'); ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="<?php the_field('twitter_link','options'); ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="<?php the_field('google_plus_link','options'); ?>" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                        <li><a href="<?php the_field('linkedin_link','options'); ?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <div class="sm-ftr">
        <div class="container">
            <div class="row">
                <div class="col-md-12 small-ftr"> <strong>Powered By - <a href="https://www.imarkinfotech.com" target="_blank">iMark Infotech</a></strong> </div>
            </div>
        </div>
    </div>


    <!-- Model -->

<div class="modal fade custom-modal" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header close-btn">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<img src="<?php the_field('site_logo','options'); ?>"/>
			</div>
			<div class="modal-body">
				<div>

					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#signin" aria-controls="signin" role="tab" data-toggle="tab">Log In</a></li>
						<li role="presentation"><a href="#join" aria-controls="join" role="tab" data-toggle="tab">Register</a></li>
					</ul>
					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="signin">
							<form role="form" id="user_login" action="" method="post">
								<div class="form-group">
									<i class="fa fa-user" aria-hidden="true"></i>
									<input class="form-control" type="text"  id="username" name="username" placeholder="User email address">
								</div>
								<div class="form-group">
									<i class="fa fa-lock" aria-hidden="true"></i>
									<input type="password" id="user_pass" name="user_pass" placeholder="Password" class="form-control">
									<input type="hidden" name="action" value="wpLoginForm" />
									<?php wp_nonce_field( 'wpLoginForm_html', 'wpLoginForm_nonce' ); ?>
									</div>
								<div class="form_btm">
									<a class="frgt_pwd" data-dismiss="modal" aria-label="Close" data-target="#frgtpwd" data-toggle="modal" href="javascript:void(0)">Forgot password?</a>
								</div>
								<input type="submit" value="Log in" name="submit" class="login_btn">
							</form>
							<div id="result" style="display:none;">
							</div>

						</div>

						<div role="tabpanel" class="tab-pane" id="join">
							<form name="register_userform" id="registeruser" enctype="multipart/form-data" method="post" action="">
							
							<span class="erors_msg"></span>
							
								<div class="form-group">
									<i class="fa fa-user" aria-hidden="true"></i>
									<input type="text" value="" placeholder="Name" name="reg_username" class="form-control">
								</div>
								<div class="form-group">
									<i class="fa fa-envelope" aria-hidden="true"></i>
									<input type="email" value="" placeholder="Email" name="reg_useremail" class="form-control">
								</div>
								<div class="form-group">
									<i class="fa fa-lock" aria-hidden="true"></i>
									<input type="password" value="" placeholder="Password" name="reg_userpassword" class="password form-control" >
								</div>
								<div class="form-group">
									<i class="fa fa-lock" aria-hidden="true"></i>
									<input type="password" value="" placeholder="Confirm-Password" name="reg_user_conf_pass" class="form-control">
								</div>
								<input class="login_btn register_btn" type="submit" value="Register My Account">
								
							</form>
							<div id="resultreg" style="display:none;">
							</div>

						</div>
					</div>

				</div>
			</div>
			<div class="modal-footer">

			</div>
		</div>
	</div>
</div>

<!--
<div class="modal fade custom-modal" id="frgtpwd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header close-btn">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<img src="<?//php the_field('site_logo','options'); ?>"/>
			</div>
			<div class="modal-body">
				<div>

				</div>
			</div>
			<div class="modal-footer">

			</div>
		</div>
	</div>
</div>
-->


    <div id="search">
        <button type="button" class="close">×</button>
        <form>
            <input type="search" value="" placeholder="SEARCH KEYWORD(s)" />
            <button type="submit" class="main-btn">Search</button>
        </form>
    </div>
   <?php  wp_footer(); ?>	
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/form.js"></script>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/jquery.validate.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/owl.carousel.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/custom.js"></script>

</body>
</html>
