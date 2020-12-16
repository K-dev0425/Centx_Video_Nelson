<?php

define('THIS_PAGE','paypal_cancel');
//define("PARENT_PAGE","deposit_fund");
require 'includes/config.inc.php';
//$pages->page_redir();
subtitle('Paypal Cancel');

template_files('paypal_cancel.html');
display_it();

?>