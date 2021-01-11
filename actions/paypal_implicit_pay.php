<?php

function AdaptiveCall($bodyparams, $method) {

    try {
        $body_data = http_build_query($bodyparams, "", chr(38));
        $url = trim("https://svcs.sandbox.paypal.com/AdaptivePayments/" . $method . "");
        $params = array(
            "http" => array(
                "method" => "POST",
                "content" => $body_data,
                "header" => "X-PAYPAL-SECURITY-USERID: centx.app_api1.gmail.com\r\n" .
                    "X-PAYPAL-SECURITY-SIGNATURE: AGYVyZWqa4Oe.-gbVfF54kS0WjsiArBHYjDPKOrcgntgz3aQsY8UnIJ4\r\n" .
                    "X-PAYPAL-SECURITY-PASSWORD: TMEGE32VFB4TMBBC\r\n" .
                    "X-PAYPAL-APPLICATION-ID: APP-80W284485P519543T\r\n" .
                    "X-PAYPAL-REQUEST-DATA-FORMAT: NV\r\n" .
                    "X-PAYPAL-RESPONSE-DATA-FORMAT: NV\r\n"
            )
        );

        //create stream context
        $ctx = stream_context_create($params);

        //open the stream and send request
        $fp = @fopen($url, "r", false, $ctx);

        //get response
        $response = stream_get_contents($fp, -1, -1);

        //check to see if stream is open
        if ($response == false) {
            throw new Exception("php error message = " . "$php_errormsg");
        }

        //close the stream
        fclose($fp);

        //parse the ap key from the response
        $keyArray = explode("&", $response);

        foreach ($keyArray as $rVal) {
            list($qKey, $qVal) = explode("=", $rVal);
            $kArray[$qKey] = $qVal;
        }

        //print the response to screen for testing purposes
        if ($kArray["responseEnvelope.ack"] == "Success") {
            echo "<strong>". $method ."</strong><br>";
            foreach ($kArray as $key => $value) {
                echo $key . ": " . $value . "<br/>";
            }
            //Return payKey
            global $payKey;
            if (!empty($kArray['payKey'])) {
                $payKey = $kArray['payKey'];
                return $payKey;
            }
        }
        else {
            echo 'ERROR Code: ' .  $kArray["error(0).errorId"] . " <br/>";
            echo 'ERROR Message: ' .  urldecode($kArray["error(0).message"]) . " <br/>";
        }

    }

    catch (Exception $e) {
        echo "Message: ||" . $e->getMessage(). "||";
    }

}

//Create Pay body
$bodyparams = array ("requestEnvelope.errorLanguage" => "en_US",
    'actionType' => 'PAY',
    'currencyCode' => 'USD',
    'receiverList.receiver(0).email' => 'sb-fjgsr4043884@personal.example.com',
    'receiverList.receiver(0).amount' => '10',
    'senderEmail' => 'sb-awull4048758@business.example.com',
    'memo' => 'Test memo',
//    'ipnNotificationUrl' => 'http://xxxxxxxx',
    'cancelUrl' => 'https://centx.app/paypal_cancel.php',
    'returnUrl' => 'https://centx.app/paypal_success.php'
);

// Call Pay API
AdaptiveCall($bodyparams, "Pay");

?>