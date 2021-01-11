<?php

include('../includes/config.inc.php');

if (isset($_POST['withdraw_amount'])) {
    $withdraw_amount = $_POST['withdraw_amount'];
    $paypal_email_address = $_POST['paypal_email_address'];
    $userid = userid();

    $user_det = $userquery->get_user_details(userid());
    $user_name = $user_det['username'];

    $query = "INSERT INTO " . tbl('withdrawal_list') . " (receiver_id, receiver_name receiver_paypal, amount, status) VALUES(". (int)$userid .", '". $user_name ."', '". $paypal_email_address ."', ".
        $withdraw_amount .", 'pending')";
    $db->Execute($query);

    echo $query;
}
?>