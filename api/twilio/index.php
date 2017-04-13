<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(-1);
require '../app.php';
$app->config(array(
	'templates.path' => './',
));
$app->map('/smsModal', function () use ($app, $settings, $mongo){
	$leadId = $_GET['leadId'];
	if(!empty($_GET['selectedNumber'])){
		$selectedNumber = $_GET['selectedNumber'];
	}else{
		$selectedNumber=null;
	}
	$apiObj = new apiclass($settings);
	$apiObj->mongoSetDB($settings['database']);
	$apiObj->mongoSetCollection("leads");
	$leadCursor = $apiObj->mongoFindOne(array('_id'=>$leadId));
	$templates=array();
	$apiObj->mongoSetCollection("smsTemplate");
	$templateCursor=$apiObj->mongoFind();
	foreach($templateCursor as $temp){
		$b = $temp;
		array_push($templates, $b);
	}
	$app->render('message.php', array("apiObj"=>$apiObj, 'phone'=>$leadCursor['phone_number'], 'settings'=>$settings,'templates'=>$templates, 'leadId'=>$leadId, 'selectedNumber'=>$selectedNumber));
})->via('GET','POST');
/*
****************************************************************************************
 --------------------------------------------------------------------------------------
 Send a predefined SMS to inputed Number
 --------------------------------------------------------------------------------------
****************************************************************************************
*/
$app->map('/sms', function() use ($twilioObj, $client, $app, $settings){
	$twilioObj = new twilioPlugin($settings);
	$number = $_REQUEST['to_number'];
	$message = $_REQUEST['message'];
        $leadId = $_REQUEST['lead_id'];
        
	$twilioObj->servies_twilio = new Services_Twilio($twilioObj->accountSid, $twilioObj->authToken);
	$twilioObj->servies_twilio->account->messages->sendMessage(
		$twilioObj->callerId, '+1' . $number, $message
	);
        $apiObj = new apiclass($settings);
	$apiObj->mongoSetDB($settings['database']);
        $sms = new stdClass();
        $sms->to_number = $number;
        $sms->message = $message;
        $sms->lead_id = $leadId;

        $apiObj->saveSMS($sms);
})->via('GET', 'POST');
$app->map('/messageManager', function() use ($twilioObj, $client, $app, $settings){
	$apiObj = new apiclass($settings);
	$apiObj->mongoSetDB($settings['database']);
	$apiObj->mongoSetCollection("smsTemplate");
	$templates=array();
	$templateCursor=$apiObj->mongoFind();
	foreach($templateCursor as $temp){
		$a = $temp;
		array_push($templates, $a);
	}
	$app->render('templates.php', array("apiObj"=>$apiObj, 'templates'=>$templates, 'settings'=>$settings));
})->via('GET', 'POST');
$app->map('/templateModal', function() use ($twilioObj, $client, $app, $settings){
	if(!empty($_POST['templateId'])){
		$templateId = $_POST['templateId'];
		$apiObj = new apiclass($settings);
		$apiObj->mongoSetDB($settings['database']);
		$apiObj->mongoSetCollection("smsTemplate");
		$template=$apiObj->mongoFindOne(array('_id'=>$templateId));
	}
	$apiObj = new apiclass($settings);
	$app->render('tmplModal.php', array("apiObj"=>$apiObj, 'settings'=>$settings, 'templateId'=>$templateId, 'template'=>$template));
})->via('GET', 'POST');
$app->map('/receivesms', function() use ($twilioObj, $client, $app, $settings){
	
})->via('GET', 'POST');
$app->map('/dialer', function() use ($twilioObj, $client, $app, $settings){
	$apiObj = new apiclass($settings);
	$apiObj->mongoSetDB($settings['database']);
	$apiObj->mongoSetCollection("smsTemplate");
	$app->render('dialerInterface.php', array("apiObj"=>$apiObj, 'settings'=>$settings));
})->via('GET', 'POST');
$app->run();