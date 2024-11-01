<?php
	// Update this as appropriate
	$path_to_wordpress = $_SERVER['DOCUMENT_ROOT'];
	
	// Feed type
	$feed_type = 'rss2';
	//$feed_type = 'rss';
	
	// Only proceed if a tag was specified
	if(!empty($_GET['tag']))
	{
		$tag = $_GET['tag'];
		if(empty($wp))
		{
			require_once $path_to_wordpress.'/wp-config.php';
			wp('feed='.$feed_type);
		}
		
		query_posts('tag='.$tag);
	
		require ABSPATH.WPINC.'/feed-'.$feed_type.'.php';
	}
?>