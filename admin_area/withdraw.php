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
    define('SUB_PAGE', 'withdraw');
}

$userquery->login_check('admin_access');

if (isset($_POST['withdraw_max_price'])) {

    $withdraw_max_price = $_POST['withdraw_max_price'];
    $withdraw_min_price = $_POST['withdraw_min_price'];

    $query = "UPDATE " . tbl("config") . " SET value = '".$withdraw_max_price."'  WHERE name = 'withdraw_max_price'";
    $db->Execute($query);

    $query1 = "UPDATE " . tbl("config") . " SET value = '".$withdraw_min_price."'  WHERE name = 'withdraw_min_price'";
    $db->Execute($query1);

    echo $query;

    exit();

}

subtitle("withdraw");
template_files('withdraw.html');
display_it();
?>