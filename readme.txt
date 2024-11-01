=== Plugin Name ===
Contributors: sojweb
Tags: tags, rss
Requires at least: 2.5.1
Tested up to: 2.7.1
Stable tag: 1.2

Creates a template tag that generates a link to an RSS feed for any given tag, optionally allows the inclusion of copyright information into RSS feeds.

== Description ==

I discovered someone ripping off the content of my site through the RSS feed, so this plugin now optionally inserts a copyright claim at the beginnging of each post in the feed. The text is included whether the feed is accessed through this plugin's tag or through the normal WordPress feed address. This only affects the RSS feeds, not the actual Web pages.

This is otherwise a very basic plugin. Unless you don't have at least version 2.6.3 of WordPress, it assumes a few things, including:

* WordPress is installed at the root level of your Web site. If it is not, edit the `$path_to_wordpress` variable in `soj-tag-feed-rss.php` to point to the appropriate location
* You want to use RSS2 feeds. If you want to use RSS, uncomment the RSS feed type in `soj-tag-feed-rss.php`.

Let me know of any problems: jj56@indiana.edu

== Installation ==

1. Upload the `soj-tag-feed` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Use `<?php soj_tag_feed_href('tag_name'); ?>` in your templates. Ex: `<a href="<?php soj_tag_feed_href('tag_name'); ?>">Tag Feed Link</a>`

== Frequently Asked Questions ==

Nothing here yet.

== Screenshots ==

Nothing here yet.