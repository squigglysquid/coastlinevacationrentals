<?php
date_default_timezone_set('America/Chicago');
if($_POST && $_POST['secu'] == '' && $_POST['form_id'] == 'full-contact'){ 

	$postvars = array(
		'Name' => $_POST['fullname'],
		'Phone Number' => $_POST['phonenum'],
		'Email Address' => $_POST['emailaddr'],
        'How did you hear about us?' => $_POST['yaheard'],
		'Message' => $_POST['contactmessage'],
	);
	
	$successmessage = '<span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span><span class="sr-only">Success:</span> Your message has been received, so expect a fast followup. If you don’t hear from us within 24 hours, be sure to check your spam folder or just give us a call.';
	$errormessage = '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only">Error:</span> Errors were found. Please correct the indicated fields below.';

	//BEGIN CHECKS
	$passCheck = TRUE;
	
	if($_POST['emailaddr'] == ''){ 
		$passCheck = FALSE;
	}elseif(!filter_var($_POST['emailaddr'], FILTER_VALIDATE_EMAIL) && !preg_match('/@.+\./', $_POST['emailaddr'])) {
		$passCheck = FALSE;
	}
	if($_POST['phonenum'] == ''){ 
		$passCheck = FALSE;
	}
	if($_POST['fullname'] == ''){ 
		$passCheck = FALSE;
	}


	
	$headline = 'Contact request from website';
	
	$sendadmin = array(
		'to'		=> 'elizabeth@coastlinevacationrentals.net',
		'from'		=> 'Coastline VR Website <noreply@coastlinevacationrentals.net>',
		'subject'	=> $headline,
		'bcc'		=> 'support@kerigan.com',
        'replyto'	=> $_POST['emailaddr']
	);
	
	include('emailtemplate.php');
	
	$fontstyle = 'font-family: Tahoma; color:#555;';
	$headlinestyle = 'sytle="font-size:16px;'.$fontstyle.'"';
	$labelstyle = 'style="padding:4px 8px; background:#f3f3f3; border:1px solid #FFF; font-weight:bold;'.$fontstyle.' font-size:14px;"';
	$datastyle = 'style="padding:4px 8px; background:#f3f3f3; border:1px solid #FFF;'.$fontstyle.' font-size:14px;"';
	
	$submittedData = '<p '.$headlinestyle.'>You have received a "Contact Us" submission from the website. Details are below:</p>';
	$submittedData .= '<table cellpadding="0" cellspacing="0" border="0" style="width:100%" ><tbody>';
	foreach($postvars as $key => $var ){
		if(!is_array($var)){
			$submittedData .= '<tr><td '.$labelstyle.' >'.$key.'</td><td '.$datastyle.'>'.$var.'</td></tr>';
		}else{
			$submittedData .= '<tr><td '.$labelstyle.' >'.$key.'</td><td '.$datastyle.'>';
			foreach($var as $k => $v){
				$submittedData .= '<span style="display:block;width:100%;">'.$v.'</span><br>';
			}
			$submittedData .= '</ul></td></tr>';
		}
	}
	$submittedData .= '</tbody></table>';
	
	$emaildata = array(
		'headline'	=> $headline, 
		'introcopy'	=> $submittedData
	);
	
	if($passCheck){
		sendEmail($sendadmin, $templatetop, $emaildata, $templatebot);
	}
}

if($_POST['secu'] == '' && $_POST){
	if($_POST['secu'] == '' && $passCheck == FALSE && $_POST['form_id'] == 'full-contact') {
		echo '<div class="alert alert-danger" role="alert">'.$errormessage.'</div>';
	}
	if($_POST['secu'] == '' && $passCheck == TRUE && $_POST['form_id'] == 'full-contact') {
		echo '<div class="alert alert-success" role="alert">'.$successmessage.'</div>';
	}
}
?>
<a id="contact-form" class="pad-anchor"></a>
<form class="form form-horizontal" method="post" action="#contact-form" >
	<div class="row">
		<div class="col-md-6 col-xl-4" >
			<div class="form-group">
				<input type="text" class="form-control input-underline fullname <?php if($_POST['secu'] == '' && $_POST['form_id'] == 'full-contact' && $_POST && $_POST['fullname'] == ''){ echo 'has-error'; } ?>" placeholder="Name" name="fullname" value="<?php echo $fullname; ?>" required >
			</div>
		</div>
		<div class="col-md-6 col-xl-4" >
			<div class="form-group">
				<input type="text" class="form-control input-underline phonenum <?php if($_POST['secu'] == '' && $_POST['form_id'] == 'full-contact' && $_POST && $_POST['phonenum'] == ''){ echo 'has-error'; } ?>" placeholder="Phone" name="phonenum" value="<?php echo $phonenum; ?>" required >
			</div>
		</div>
		<div class="col-xl-4" >
			<div class="form-group">
				<input type="text" class="form-control input-underline emailaddr <?php if($_POST['secu'] == '' && $_POST['form_id'] == 'full-contact' && $_POST && $_POST['emailaddr'] == ''){ echo 'has-error'; } ?>" placeholder="Email" name="emailaddr" value="<?php echo $emailaddr; ?>" required>
			</div>
		</div>
        <div class="col-xs-12" >
			<div class="form-group">
				<select name="yaheard" class="form-control input-underline yaheard <?php if($_POST['secu'] == '' && $_POST['form_id'] == 'full-contact' && $_POST && $_POST['yaheard'] == ''){ echo 'has-error'; } ?>" required >
                    <option selected>How Did You Hear About Us?</option>
                    <option value="search engine">Found you on Google (or other search engine)</option>
                    <option value="social media">Facebook (or other social media)</option>
                    <option value="travel site">Travel site (VRBO, HomeAway, etc)</option>
                    <option value="other">Other</option>
                </select>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="form-group">
				<textarea name="contactmessage" class="form-control input-outline contactmessage" placeholder="Message..." ><?php if($_POST['secu'] == '' && $_POST['form_id'] == 'full-contact' && $_POST && $_POST['$contactmessage'] != ''){ echo $_POST['$contactmessage']; } ?></textarea>
			</div>
			<div class="form-group" style="margin-bottom:0;">
				<input type="hidden" name="form_id" value="full-contact" >
				<input type="text" name="secu" value="" style="position:absolute; height:1px; width:1px; top:-10000px; left:-10000px;" >
				<button type="submit" class="btn btn-info" >Submit</button>
			</div>
		</div>
	</div>

</form>