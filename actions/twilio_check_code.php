<?php

include('../includes/config.inc.php');

require '../includes/libraries/twilio/twilio-php-main/src/Twilio/autoload.php';

use Twilio\Rest\Client;

$sid = TWILIO_SID;
$token = TWILIO_TOKEN;
$twilio = new Client($sid, $token);

if (isset($_POST['verification_code'])) {
    $code = $_POST['verification_code'];
    $phone_number = $_POST['phone_number'];
    $verification_check = $twilio->verify->v2->services("VA61dd1db7184062a12b4f4fb92004626a")->verificationChecks->create($code, ["to" => "+" . $phone_number]);
    if ($verification_check->status == 'approved') {

        $userid = userid();

        $query = "UPDATE " . tbl("users") . " SET phone_number = ".$phone_number."  WHERE userid = ".(int)$userid;
        $db->Execute($query);

        echo 'success';
    }
    else {
        echo 'failed';
    }
}






