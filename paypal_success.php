<?php

define('THIS_PAGE','paypal_success');
//define("PARENT_PAGE","deposit_fund");
require 'includes/config.inc.php';
//$pages->page_redir();
subtitle('Paypal Success');

$userid = userid();

$user_det = $userquery->get_user_details(userid());
$user_name = $user_det['username'];

$assign_array = array();

if (!empty($_GET['item_number']) && !empty($_GET['tx']) && !empty($_GET['amt']) && !empty($_GET['cc']) && !empty($_GET['st'])){
//    Get transaction information from URL
    $item_number = $_GET['item_number'];
    $txn_id = $_GET['tx'];
    $payment_gross = $_GET['amt'];
    $currency_code = $_GET['cc'];
    $payment_status = $_GET['st'];

    // Check if transaction data exists with the same TXN ID.
    $query = "SELECT * FROM ".tbl("paypal_payment")." WHERE txn_id = '". $txn_id ."'";
    $prevPaymentResult = db_select($query);

    if (count($prevPaymentResult) > 0) {
        $payment_id = $prevPaymentResult['id'];
        $payment_gross = $prevPaymentResult['amount'];
        $payment_status = $prevPaymentResult['status'];
    } else {
        // Insert transaction data into the database
        $insert_query = "INSERT INTO " . tbl("paypal_payment") . "(txn_id, user_id, user_name, transfer_type, amount, status) VALUES("
        . $userid .", '". $user_name ."', 'deposit', ". $payment_gross .", '". $payment_status ."')";
        $db->Execute($insert_query);
    }

    $assign_array['txn_id'] = $txn_id;
//    $assign_array['payment_id'] = $payment_id;
    $assign_array['payment_gross'] = $payment_gross;
    $assign_array['payment_status'] = $payment_status;
}

array_val_assign($assign_array);

template_files('paypal_success.html');
display_it();

?>