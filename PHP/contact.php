<?php
// Import PHP Mailer
use PHPMailer\ PHPMailer\ PHPMailer;
use PHPMailer\ PHPMailer\ SMTP;
use PHPMailer\ PHPMailer\ Exception;  

// Load Composer's autoloader
require '../vendor/autoload.php';

// Import credentials for the DB
include 'Include/credentials.php';

// Get the variables posted from JS
$name = ($_POST['name']);
$email = ($_POST['email']);
$comment = ($_POST['comment']);
$signInStatus = ($_POST['signInStatus']);

// Create an array of form data
$formData = array($name, $email, $comment);
// Create an array of form data names
$formDataNames = array("Name", "Email", "Comment");
// Create an array to store errors
$errorArray = array();
// This var stores whether the  comment data has passed the tests, defaults to true
$passed = TRUE;

// Loop through each form data
foreach($formData as $key => $data) {
		// If there is no comment data
		if (empty($data)) {
				array_push($errorArray, $formDataNames[$key].
				"|This Is A Required Field¦");
				$passed = FALSE;
		} elseif (!preg_match('/^[a-zA-Záéíóú0-9 \s @.€$£()\/:]+$/', $data))  {				
					array_push($errorArray, $formDataNames[$key].
					"|Only letters, brackets, whitespace, currency symbols, brackets, @ , :, / and . are allowed¦");
					$passed = FALSE;
		}
}

// Encode the error array as JSON and send it back to JS
echo json_encode($errorArray);

// If all the comment data passed the tests
if ($passed == TRUE) {

	// Create a new instance of PHP mailer and pass true to allow exceptions
	$mail = new PHPMailer(true);

	// Thank you message for user
	$ThankYouMessage = '
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html style="width:100%;font-family:arial, "helvetica neue", helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;">
		<head> 
		<meta charset="UTF-8"> 
		<meta content="width=device-width, initial-scale=1" name="viewport"> 
		<meta name="x-apple-disable-message-reformatting"> 
		<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
		<meta content="telephone=no" name="format-detection"> 
		<title>Thanks For Contacting Us - Anseo Digital Passport</title> 
		<!--[if (mso 16)]>
			<style type="text/css">
			a {text-decoration: none;}
			</style>
			<![endif]--> 
		<!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--> 
		<style type="text/css">
	@media only screen and (max-width:600px) {p, ul li, ol li, a { font-size:16px!important; line-height:150%!important } h1 { font-size:30px!important; text-align:center; line-height:120%!important } h2 { font-size:26px!important; text-align:center; line-height:120%!important } h3 { font-size:20px!important; text-align:center; line-height:120%!important } h1 a { font-size:30px!important } h2 a { font-size:26px!important } h3 a { font-size:20px!important } .es-menu td a { font-size:16px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:16px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:block!important } a.es-button { font-size:20px!important; display:block!important; border-width:10px 0px 10px 0px!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } .es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } .es-desk-menu-hidden { display:table-cell!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } }
	#outlook a {
		padding:0;
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
		<body style="width:100%;font-family:arial, "helvetica neue" , helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;"> 
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
												<td align="center" style="padding:0;Margin:0;padding-top:15px;padding-bottom:15px;padding-right:15px;font-size:0px;"><a target="_blank" href="https://anseodigitalpassport.com" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#2CB543;"><img class="adapt-img" src="https://fxpokz.stripocdn.email/content/guids/CABINET_a378b6ecb57582c3f05e183b185a7377/images/65341590823127560.png" alt="Anseo Digital Passport" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;" width="165" title="Anseo Digital Passport"></a></td> 
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
												<td align="center" class="es-m-txt-c" style="padding:0;Margin:0;padding-bottom:10px;padding-top:20px;"><h1 style="Margin:0;line-height:52px;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;font-size:26px;font-style:normal;font-weight:normal;color:#333333;text-align:right;"><strong>Thank you for contacting us</strong></h1></td> 
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
												<td align="left" style="padding:0;Margin:0;"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:21px;color:#333333;">Hello ' . $name . ',<br><br>Thank you for contacting us. We will respond as soon as we can.<br><br>Many Thanks,<br>&nbsp; &nbsp; Dillon Lynch<br></p></td> 
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
	</html>';
	
	// Message to be sent to the admin
	$NotifyMessage = "
	<p>$name has contacted Anseo Digital Passport.</p>
	<h3>Details</h3> 
	<ul>
		<li>Name: $name</li> 
		<li>Email: $email</li> 
		<li>Message: $comment</li> 
		<li>Sign In Status: $signInStatus</li> 
	</ul>";

	// Set the timezone to Dublin
	date_default_timezone_set("Europe/Dublin");
	// Get the current time
	$currentTime = date("Y-m-d h:i:s");
	
	// Try to send the thank you message to the user
	try {
		// Set the server settings

		// Debug settings: 0 is disabled, 2 is enabled
		$mail -> SMTPDebug = 0; 
		// Send using SMTP
		$mail -> isSMTP();
		// Set the SMTP server to send through
		$mail -> Host = 'XXXXXXXXXXXXXXXXX';
		// Enable SMTP authentication
		$mail -> SMTPAuth = true; 
		// SMTP username
		$mail -> Username = 'XXXXXXXXXXXXXXXXXXX'; 
		// SMTP password
		$mail -> Password = 'XXXXXXXXXXXXXXXXXXXXXX'; 
		$mail -> SMTPAutoTLS = true;
		// Set the port to 587
		$mail -> Port = 587;
		// Set the SMTP options
		$mail -> SMTPOptions = array(
			'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
			)
		);

		// Set the sender and recipient
		$mail -> setFrom('server@anseodigitalpassport.com', 'Anseo Digital Passport');
		$mail -> addAddress($email, $name); // Add a recipient;               // Name is optional
		$mail -> addReplyTo('info@anseodigitalpassport.com', 'Information');

		// Set the content
		// Set email format to HTML
		$mail -> isHTML(true); 
		// Set the subject
		$mail -> Subject = 'Thank you for contacting us!!!';
		// Set the email body
		$mail -> Body = $ThankYouMessage;
		// Set the body for clients where HTML is not supported
		$mail -> AltBody = " 
			$name,
			Thank you
			for contacting us.We will respond as soon as we can.

			Many thanks,
			Dillon Lynch ";

		// Send the email
		$mail -> send();
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}

	// Try to send the email with the contact data to the admin
	try {
		
		// Set the sender and recipient
		$mail -> setFrom('server@anseodigitalpassport.com', 'Anseo Digital Passport');
		$mail -> addAddress("dillonkdy@gmail.com", "Dillon Lynch"); // Add a recipient;               // Name is optional
		$mail -> addReplyTo('noreply@anseodigitalpassport.com', 'No Reply');

		// Set the content

		// Set email format to HTML
		$mail -> isHTML(true); 
		// Set the subject
		$mail -> Subject = $name . ' Has Contacted Anseo Digital Passport';
		// Set the email body
		$mail -> Body = $NotifyMessage;
		// Set the body for clients where HTML is not supported
		$mail -> AltBody = "View in a browser that supports html.";

		// Send the message
		$mail -> send();
	} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}

	// Connect to the DB to insert form data
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);

	// Check to make sure that the connection was not unsuccessful
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	// SQL statement to insert the form data into DB
	$sql = "
	INSERT INTO 
		contact_submissions(
		cs_name,
		cs_email,
		cs_message,
		cs_time,
		cs_sign_in_status
		)
		VALUES(
		'$name',
		'$email',
		'$comment',
		'$currentTime',
		'$signInStatus'
		);"
	;
	
	// Run the SQL
	if (!mysqli_query($conn, $sql)) {
			echo("Error: ".$sql.
					"<br>".mysqli_error($conn));
	}
	
	// Close the connection to the DB
	mysqli_close($conn);
}
?>