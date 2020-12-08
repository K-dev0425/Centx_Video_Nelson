<?php

#Including Main file and checking user level
require'../includes/admin_config.php';
$userquery->admin_login_check();
$pages->page_redir();

global $Cbucket;

/* Assigning page and subpage */
if(!defined('MAIN_PAGE')){
    define('MAIN_PAGE', 'General Configurations');
}
if(!defined('SUB_PAGE')){
    define('SUB_PAGE', 'Manage Banner');
}

$userquery->login_check('admin_access');

if ($_FILES['banner_image']) {

    $extension = getExt($_FILES['banner_image']['name']);

    $content_type = get_mime_type($_FILES['banner_image']['tmp_name']);

    if ($content_type != 'image') {
        echo "<script>alert('The chosen file is not image. Please upload image file.');</script>";
        exit();
    }

    $tempFile = $_FILES['banner_image']['tmp_name'];
    $file_name = 'banner';
    $targetFileName = $file_name . '.' . getExt($_FILES['banner_image']['name']);
    $target = IMAGES_DIR . '/banner/' . $targetFileName;
    $targetUrl = IMAGES_URL . '/banner/' . $targetFileName;

    if (file_exists($target)) {
        unlink($target);
    }

    move_uploaded_file($tempFile, $target);

    $query = "UPDATE " . tbl("config") . " SET value = '" . $targetUrl . "' where name = 'banner_url'";
    $db->Execute($query);

    echo $query;
    exit();

}

$banner_header = isset($_POST['banner_header']) ? $_POST['banner_header'] : '';
$banner_text = isset($_POST['banner_text']) ? $_POST['banner_text'] : '';

if ($banner_header != '') {
    $hader_query = "UPDATE " . tbl("config") . " SET value = '" . $banner_header . "' where name = 'banner_header'";
    $db -> Execute($hader_query);
}

if ($banner_text != '') {
    $text_query = "UPDATE " . tbl("config") . " SET value = '" . $banner_text . "' where name = 'banner_text'";
    $db -> Execute($text_query);
}


subtitle("Manage Banner");
template_files('manage_banner.html');
display_it();

?>