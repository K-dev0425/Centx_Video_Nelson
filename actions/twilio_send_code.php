<?php

include('../includes/config.inc.php');

require '../includes/libraries/twilio/twilio-php-main/src/Twilio/autoload.php';

use Twilio\Rest\Client;

$sid = TWILIO_SID;
$token = TWILIO_TOKEN;
$twilio = new Client($sid, $token);

//$service = $twilio->verify->v2->services->create("My First Verify Service");
//$service_sid = $service->sid;

if (isset($_POST['phone_number'])) {
    $phone_number = "+" . $_POST['phone_number'];
    $verification = $twilio->verify->v2->services("VA61dd1db7184062a12b4f4fb92004626a")->verifications->create($phone_number, "sms");
}

if($verification->status == 'pending') {
    echo 'success';
}
else {
    echo 'failed';
}



