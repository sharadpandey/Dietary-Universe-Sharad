<?php 
include('../../../../wp-config.php');
global $wpdb;
//User Details
$reg_username  = $_POST['reg_username'];
$reg_useremail=$_POST['reg_useremail'];
$reg_userpassword = $_POST['reg_userpassword'];
$reg_user_conf_pass = $_POST['reg_user_conf_pass'];
// confirm password
if($reg_userpassword == $reg_user_conf_pass){
	if (!email_exists( $reg_useremail ) ){
		$userdata = array(
		'user_login' =>  $reg_useremail,
		'user_email'   =>  $reg_useremail,
		'user_pass'  =>  $reg_userpassword,
		'first_name' =>$reg_username,
		'last_name' =>''
			);
		$user_id = wp_insert_user( $userdata ) ;
		$user = new WP_User( $user_id );
		$user->set_role( 'customer' );
		//send email to user
		 $headers = 'From: Dietary Universe <noreply@dietary-universe.com>' . "\r\n";
			$to      = $reg_useremail;
			$subject = 'Registered Successfully';
			$body    = '<table cellspacing="0" border="0" align="center" cellpadding="0" width="600" style="border:1px solid">
					<tr>
						<td>
							<table cellspacing="0" border="0" align="center" cellpadding="0" width="600" style="border:0px solid #ccc; margin-top:0px;">
								<!-- -->
								<tr align="center" >
									<td style="font-family:arial;  "><strong>
									Registered Successfully
									</strong></td>
								</tr><!-- -->
							</table>
							<table cellspacing="0" border="0" align="center" cellpadding="10" width="90%" style="border:0px solid">
								<tr>
								<td><h3>Hello, '.$reg_username.'</h3></td>
								</tr>
								<tr>
									<td>
										<table cellspacing="0" border="0" cellpadding="0" width="100%">
											<tr><td>You have successfully Registered.</td>
											</tr>
										</table>
									</td>
									<td width="30"></td> 
								</tr>
							</table>
							<table cellspacing="0" border="0" align="center" cellpadding="0" width="100%" style="border:0px solid #efefef; margin-top:20px; padding:0px;">
								<tr>
									<td align="center" style="font-family:PT Sans,sans-serif; font-size:13px; padding:15px 0; border-top:1px solid;"> 
									<b>Dietary Universe</b></strong></td> 
								</tr>
							</table>
						</td>   
					</tr>
				</table>
		<style>
			td{width:100%;}

		</style>';
		wp_mail( $to, $subject, $body, $headers );

		echo "1";
	}else{
		echo"2";
	}
}else{
echo '3';
}

?>