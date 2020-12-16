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
    define('SUB_PAGE', 'paypal');
}

$userquery->login_check('admin_access');

$query = "SELECT * FROM ".tbl("paypal_payment")." WHERE id > 0";

$username = '';
$date = '';
$list_per_page = 20;
$page = 1;

if (isset($_GET['username']) && $_GET['username'] != '') {
    $username = $_GET['username'];
    $query .= " AND username like '".$username."'";
}

if (isset($_GET['date']) && $_GET['date'] != 'all') {
    $date = $_GET['date'];
    switch ($date)
    {
        case 'today': {
            $query .= " AND DATE(start_time) = DATE(NOW())";
        }
            break;

        case 'yesterday':{
            $query .= " AND DATE(start_time) = DATE(NOW()) - INTERVAL 1 DAY";
        }
            break;

        case 'this_week': {
            $query .= " AND DATE(start_time) > DATE(NOW()) - INTERVAL 7 DAY";
        }
            break;

        case 'this_month': {
            $query .= " AND DATE(start_time) > DATE(NOW()) - INTERVAL 32 DAY AND MONTH(start_time) = MONTH(NOW())";
        }
            break;

        case 'this_year': {
            $query .= " AND YEAR(start_time) = YEAR(NOW())";
        }
            break;
    }
}

$query .= " ORDER BY id DESC";

$query1 = $query;
$all_deposit_conds = db_select($query1);

$count = count($all_deposit_conds);
$last_page = ceil($count/$list_per_page);

if (isset($_GET['page']) && (int)$_GET['page'] != 1) {
    $page = (int)$_GET['page'];
    $offset = ($page - 1) * $list_per_page;
    $query .= " LIMIT ". $offset . ", ". $list_per_page;
}
else {
    $query .= " LIMIT ". $list_per_page;
}

$paypal_transfers = db_select($query);

Assign('deposit_fund', $paypal_transfers);
Assign('userInput', $username);
Assign('dateInput', $date);
Assign('page', $page);
Assign('last_page', $last_page);

subtitle("Paypal Transfer");
template_files('paypal_transfer.html');
display_it();
?>