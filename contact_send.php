<?php

if(isAjax()){
		define('TO_EMAIL', '"Contact Kraftives" <support@kraftives.com>');
		$contact_details = $_POST;
		$validation_errors = Validate($contact_details);
		if($validation_errors !== false){
			OnError($validation_errors);
		}else{
			sending_email($contact_details);
		}
		die();
}else{
		echo "Access Restricted";
		
		//die();
}

function sending_email($details){
	$to	= TO_EMAIL;
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; cha	rset=iso-8859-1\r\n";
	$headers .= 'To: '.TO_EMAIL . "\r\n";
	$headers .= "From: <".$details['email'].">\r\n";
	$subject = "Message send via Design 360 Contact Form";
	$message = "<strong>Full Name:</strong> ".$details['full_name']."<br />
				<strong>Email:</strong> ".$details['email']."<br />
				<strong>Phone Number:</strong> ".$details['phone']."<br />
				<strong>Message:</strong> ".$details['message']."<br /><br />
				<small><em>The message is send via Contact Form, Powered by kraftives.com</em></small>";
	if (mail($to, $subject, $message, $headers)) {
		echo '{"success": true}';

	}else{
		echo '{"success": false, "errors": [{ "field": "form_main", "error": "mail_error"}]}';
	}
}

function isAjax() {  
	return ( isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');  
}
function Validate($params=array()){
	$error = array();
	if(!(isset($params['full_name']) && ($params['full_name'] != '')))
		$error['name'] = 'empty_name';
	if(!(isset($params['email']) && $params['email'] != ''))
		$error['email'] = 'empty_email';
	else{
		$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
		if(!preg_match($email_exp,$params['email']))
			$error['email'] = 'invalid';
	}
	if(!(isset($params['message']) && $params['message'] != ''))
		$error['message'] = 'empty_message';
	if(!(isset($params['phone']) && $params['phone'] != ''))
		$error['phone'] = 'empty_phone';

		if(count($error) == 0){
			return false;
		}
		else{
			return $error;
		}
}

function OnError($error_params){
	$response = '{';
	$response .= '"success": false, "errors": [';
	
	foreach($error_params as $key => $value) {  
		$response .= "{ \"field\": \"$key\", \"error\": \"$value\"},";
	}
	if(count($error_params) > 0)
		$response = substr($response, 0, -1);
	$response .= ']}';
	
	echo $response;
}