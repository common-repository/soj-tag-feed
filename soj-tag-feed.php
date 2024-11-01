<?php
/*
Plugin Name: SoJ Tag Feed
Plugin URI: http://journalism.indiana.edu/apps/mediawiki-1.10.1/index.php/Wp_soj-tag-feed
Description: Generate an RSS feed for any given tag, and optionally include copyright information in RSS feeds
Version: 1.2
Author: Jeff Johnson
*/

/**
 * Generate admin panel for plugin
 */
function soj_tag_feed_subpanel()
{
	// Make sure options are set
	if($tmp=get_option('soj_tag_feed'));
	else
		add_option('soj_tag_feed',array('include'=>FALSE,'text'=>''));

	// Handle updates
	if(isset($_POST['action']))
	{
		switch($_POST['action'])
		{
			case 'copyright':
				$include = isset($_POST['includeCopyright']) ? TRUE : FALSE;
				$text = htmlspecialchars(stripslashes(trim($_POST['copyright'])), ENT_QUOTES);
				update_option('soj_tag_feed',array('include'=>$include,'text'=>$text));
				$message = 'Copyright updated.';
				break;
		}
	}
	
	// Get option information
	$soj_tag_feed_option = get_option('soj_tag_feed');
?>
	<?php if(isset($message)) { ?>
	<div id="message" class="updated fade">
		<p><?php _e($message); ?></p>
	</div>
	<?php } ?>
	<div class="wrap"> 
		<h2><?php _e('How to use the SoJ Tag Feed plugin') ?></h2>
		<p>
			Use this template tag to get the address to a tag feed:
			<br /><br />
			&lt;?php soj_tag_feed_href('tag_name'); ?&gt;
			<br />
			&lt;?php soj_tag_feed_href('tag_name', TRUE); ?&gt;
			<br /><br />
			The second one returns the value instead of echoing it.
		</p>
		<h2>Find someone stealing your content?</h2>
		<p>Include copyright information at the beginning of your feeds.</p>
		<form action="" method="post">
		<div><input type="checkbox" name="includeCopyright" <?php echo $soj_tag_feed_option['include'] ? 'checked="checked" ' : ''; ?>/> Check this box to include copyright information at the beginning of feeds.</div>
		<div><br />Enter copyright attribution here (if left blank, "This content copyright &copy; [SITE_NAME] <?php echo date('Y'); ?>" will be used):</div>
		<div><input type="text" name="copyright" size="60" value="<?php echo $soj_tag_feed_option['text']; ?>" /></div>
		<div>
			<input type="hidden" name="action" value="copyright" />
			<input type="submit" value="Submit" />
		</div>
		</form>
	</div>
<?php
}

/**
 * Add copyright notice to feeds
 */
function soj_add_copyright_to_feeds($str='')
{
	if(is_feed())
	{
		if($soj_tag_feed_option=get_option('soj_tag_feed'))
		{
			if($soj_tag_feed_option['include'])
			{
				if(empty($soj_tag_feed_option['text']))
					return '<p class="feedCopyright">This content copyright &copy; '.get_bloginfo('name').' '.date('Y').'</p>'.$str;
				else
					return '<p class="feedCopyright">'.$soj_tag_feed_option['text'].'</p>'.$str;
			}
		}
	}

	return $str;
}
add_filter('the_content','soj_add_copyright_to_feeds');

/**
 * Add admin panel for plugin
 */
function soj_tag_feed_panel()
{
	if (function_exists('add_options_page')) {
		add_options_page('SoJ Tag Feed', 'SoJ Tag Feed', 'edit_posts', __FILE__, 'soj_tag_feed_subpanel');
	}
}
add_action('admin_menu', 'soj_tag_feed_panel');
 
/**
 * The feed generator
 *
 * @param {string} $tag_name The tag you're generating a feed from
 * @param {boolean} $return Whether or not to return the value or echo it; defaults to FALSE
 */
function soj_tag_feed_href($tag='', $return=FALSE)
{
	global $wp_version;

	// If nothing was specified, we're done
	if(empty($tag)) return '';

	// Get web link to this directory
	if(isset($wp_version) && strcmp($wp_version,'2.6.3')==0)
		$path = get_bloginfo('home').'/wp-rss2.php?tag='.$tag;
	else
		$path = substr(ABSPATH,strlen($_SERVER['DOCUMENT_ROOT'])).'wp-content/plugins/soj-tag-feed/soj-tag-feed-rss.php?tag='.$tag;

	// Return href to tag feed href builder
	if($return)
		return $path;
	echo $path;
}

?>