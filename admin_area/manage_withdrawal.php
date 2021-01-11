<?php


#Including Main file and checking user level
require'../includes/admin_config.php';
$userquery->admin_login_check();
$pages->page_redir();


/* Assigning page and subpage */
if(!defined('MAIN_PAGE')){
    define('MAIN_PAGE', 'payment');
}
if(!defined('SUB_PAGE')){
    define('SUB_PAGE', 'manage_withdrawal');
}

$userquery->login_check('admin_access');

if (isset($_POST['deposit_max_price'])) {

    $deposit_max_price = $_POST['deposit_max_price'];
    $deposit_min_price = $_POST['deposit_min_price'];

    $query = "UPDATE " . tbl("config") . " SET value = '".$deposit_max_price."'  WHERE name = 'deposit_max_price'";
    $db->Execute($query);

    $query1 = "UPDATE " . tbl("config") . " SET value = '".$deposit_min_price."'  WHERE name = 'deposit_min_price'";
    $db->Execute($query1);

    echo $query;

    exit();

}

subtitle("Manage Withdrawal");
template_files('manage_withdrawal.html');
display_it();
?>