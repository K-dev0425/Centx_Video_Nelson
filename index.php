<?php

	define('THIS_PAGE','index');
	require 'includes/config.inc.php';
	$pages->page_redir();
	if(is_installed('editorspick')) {
		assign('editor_picks',get_ep_videos());
	}

	//Displaying The Template
	template_files('index.html');
	display_it();

?>
