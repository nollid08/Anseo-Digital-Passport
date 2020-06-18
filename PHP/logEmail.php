<?php
	// Import PHPMailer classes into the global namespace
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	// Load Composer's autoloader
	require '../vendor/autoload.php';

	// Load in the variables passed from JS
	$closestPoint = $_POST['cp'];
	$email = $_POST['ve'];
	$name = $_POST['dn'];

	// Create a new instanceof PHPMailer
	$mail = new PHPMailer(true);

	// HTML code for the email
	$congratsMessage = ('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html style="width:100%;font-family:arial, "helvetica neue", helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;">
	 <head> 
	  <meta charset="UTF-8"> 
	  <meta content="width=device-width, initial-scale=1" name="viewport"> 
	  <meta name="x-apple-disable-message-reformatting"> 
	  <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
	  <meta content="telephone=no" name="format-detection"> 
	  <title>log it</title> 
	  <!--[if (mso 16)]>
		<style type="text/css">
		a {text-decoration: none;}
		</style>
		<![endif]--> 
	  <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--> 
	  <!--[if !mso]><!-- --> 
	  <link href="https://fonts.googleapis.com/css?family=Lato:400,400i,700,700i" rel="stylesheet"> 
	  <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,700,700i" rel="stylesheet"> 
	  <!--<![endif]--> 
	  <style type="text/css">
	@media only screen and (max-width:600px) {p, ul li, ol li, a { font-size:16px!important; line-height:150%!important } h1 { font-size:30px!important; text-align:center; line-height:120%!important } h2 { font-size:26px!important; text-align:center; line-height:120%!important } h3 { font-size:20px!important; text-align:center; line-height:120%!important } h1 a { font-size:30px!important } h2 a { font-size:26px!important } h3 a { font-size:20px!important } .es-menu td a { font-size:16px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:16px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:block!important } a.es-button { font-size:20px!important; display:block!important; border-width:10px 0px 10px 0px!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } .es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } .es-desk-menu-hidden { display:table-cell!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } }
	#outlook a {
		padding:0;
	}

	btn{
		text-color: white;
	}
	.ExternalClass {
		width:100%;
	}
	.ExternalClass,
	.ExternalClass p,
	.ExternalClass span,
	.ExternalClass font,
	.ExternalClass td,
	.ExternalClass div {
		line-height:100%;
	}
	.es-button {
		mso-style-priority:100!important;
		text-decoration:none!important;
	}
	a[x-apple-data-detectors] {
		color:inherit!important;
		text-decoration:none!important;
		font-size:inherit!important;
		font-family:inherit!important;
		font-weight:inherit!important;
		line-height:inherit!important;
	}
	.es-desk-hidden {
		display:none;
		float:left;
		overflow:hidden;
		width:0;
		max-height:0;
		line-height:0;
		mso-hide:all;
	}
	</style> 
	 </head> 
	 <body style="width:100%;font-family:arial, "helvetica neue", helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;"> 
	  <div class="es-wrapper-color" style="background-color:#F6F6F6;"> 
	   <!--[if gte mso 9]>
				<v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
					<v:fill type="tile" color="#f6f6f6"></v:fill>
				</v:background>
			<![endif]--> 
	   <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;"> 
		 <tr style="border-collapse:collapse;"> 
		  <td valign="top" style="padding:0;Margin:0;"> 
		   <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;"> 
			 <tr style="border-collapse:collapse;"> 
			  <td align="center" style="padding:0;Margin:0;"> 
			   <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;"> 
				 <tr style="border-collapse:collapse;"> 
				  <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px;"> 
				   <!--[if mso]><table width="560" cellpadding="0"
								cellspacing="0"><tr><td width="180" valign="top"><![endif]--> 
				   <table cellpadding="0" cellspacing="0" class="es-left" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;"> 
					 <tr style="border-collapse:collapse;"> 
					  <td width="180" class="es-m-p0r es-m-p20b" valign="top" align="center" style="padding:0;Margin:0;"> 
					   <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
						 <tr style="border-collapse:collapse;"> 
						  <td align="center" style="padding:0;Margin:0;font-size:0px;"><img class="adapt-img" src="https://fxpokz.stripocdn.email/content/guids/CABINET_1c581fd6efdb44726532f355feb26c14/images/49111586465055134.png" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;" width="180"></td> 
						 </tr> 
					   </table></td> 
					 </tr> 
				   </table> 
				   <!--[if mso]></td><td width="20"></td><td width="360" valign="top"><![endif]--> 
				   <table cellpadding="0" cellspacing="0" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
					 <tr style="border-collapse:collapse;"> 
					  <td width="360" align="left" style="padding:0;Margin:0;"> 
					   <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
						 <tr style="border-collapse:collapse;"> 
						  <td align="left" style="padding:0;Margin:0;"><h1 style="Margin:0;line-height:72px;mso-line-height-rule:exactly;font-family:roboto, "helvetica neue", helvetica, arial, sans-serif;font-size:48px;font-style:normal;font-weight:normal;color:#333333;"><strong>Congratulations!</strong></h1></td> 
						 </tr> 
					   </table></td> 
					 </tr> 
				   </table> 
				   <!--[if mso]></td></tr></table><![endif]--></td> 
				 </tr> 
				 <tr style="border-collapse:collapse;"> 
				  <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px;"> 
				   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
					 <tr style="border-collapse:collapse;"> 
					  <td width="560" valign="top" align="center" style="padding:0;Margin:0;"> 
					   <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
						 <tr style="border-collapse:collapse;"> 
						  <td align="left" style="padding:0;Margin:0;"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:17px;font-family:roboto, "helvetica neue", helvetica, arial, sans-serif;line-height:26px;color:#333333;">Congrats!!!! You have just logged ' . $closestPoint . ' using Anseo Digital Passport. There are still lots of Discovery Points to explore along the Wild Atlantic Way so get out there and get logging!<br><br>Many Thanks,<br>&nbsp; &nbsp; Dillon Lynch</p></td> 
						 </tr> 
					   </table></td> 
					 </tr> 
				   </table></td> 
				 </tr> 
				 <tr style="border-collapse:collapse;"> 
				  <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px;"> 
				   <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
					 <tr style="border-collapse:collapse;"> 
					  <td width="560" align="center" valign="top" style="padding:0;Margin:0;"> 
					   <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
						 <tr style="border-collapse:collapse;"> 
						  <td align="center" style="padding:10px;Margin:0;"><span class="es-button-border" style="border-style:solid;border-color:#2CB543;background:#6FA8DC;border-width:0px;display:inline-block;border-radius:20px;width:auto;"><a href="https://anseodigitalpassport.com/Passport.php" class="es-button" target="_blank" style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:lato, "helvetica neue", helvetica, arial, sans-serif;font-size:22px;color:#FFFFFF;border-style:solid;border-color:#6FA8DC;border-width:10px 20px 10px 20px;display:inline-block;background:#6FA8DC;border-radius:20px;font-weight:bold;font-style:normal;line-height:26px;width:auto;text-align:center;border-left-width:20px;border-right-width:20px;">View your Passport</a></span></td> 
						 </tr> 
					   </table></td> 
					 </tr> 
				   </table></td> 
				 </tr> 
			   </table></td> 
			 </tr> 
		   </table></td> 
		 </tr> 
	   </table> 
	  </div>  
	 </body>
	</html>');





	try {
			// Server settings for PHPMailer
			// Disable debugging
			$mail->SMTPDebug = 0;	
			// Send using SMTP
			$mail->isSMTP();	
			// Set the SMTP server to send through
			$mail->Host       = 'XXXXXXXXXXXXXX';
			// Enable SMTP authentication
			$mail->SMTPAuth   = true;	
			// SMTP username
			$mail->Username   = 'XXXXXXXXXXXXXX';
			// SMTP password
			$mail->Password   = 'XXXXXXXXXXXXXX';
			$mail->SMTPAutoTLS = true;
			$mail->Port       = 587;   
			$mail->SMTPOptions = array(
				'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);

		// Set the recipients
		$mail->setFrom('server@anseodigitalpassport.com', 'Anseo Digital Passport');
		$mail->addAddress($email, $name);
		$mail->addReplyTo('info@anseodigitalpassport.com', 'Information');


		// Set the content
		// Set the email format to HTML
		$mail->isHTML(true);	
		// Set the email subject
		$mail->Subject = 'Discovery Point Logged - Anseo Digital Passport';
		// Set the email body
		$mail->Body = $congratsMessage;
		// Set the non-HTML email
		$mail->AltBody = "
		Hello $name,
		You have just logged $closestPoint using Anseo Digital Passport. There are lots of other intresting points in Ireland aswell, so get out there and enjoy it!
		Many thanks,
		    Dillon";

		// Send the email
		$mail->send();
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}



?>
