=== Better Front Page UI ===

Contributors: vmassuchetto, leogermani
Tags: rewrite rules, templates, home page, front page
Requires at least: 3.0
Tested up to: 3.5
Stable tag: 0.04
License: GPLv2 or later

Lets you specify the URL for your posts home, so there's no need for dummy
pages as placeholders of home.php and front-page.php.

== Description ==

The default way of defining a front page in WordPress is:

1. Create a `front-page.php` for the site home and (optionally) a `home.php`
for the posts home.
2. Go to the site admin and create two dummy pages.
3. Select these dummy pages in the reading settings for the front page and the
posts home.

We think this approach is very sensible as users will be able to delete these
dummy pages and crash an entire website. This plugin lets you specify the URL
for your blog when you have a `front-page.php` file in your theme so you don't
have to create two dummy pages as placeholders for your posts home and front
page.

This plugin won't modify the template hierarchy, it will only set an URL to
access your posts home when you have a `front-page.php` file in your theme. It
will also remove the "Front Page Displays" option from the "Reading Settings".

So, the same procedure to set a front page with this plugin will be:

1. Define a `front-page.php` for the site home and (optionally) a `home.php`
for the posts home.
2. Set which URL will point to the posts home in the "Permalink Settings"
(defaults to `/blog`).

Note: This plugin will only work if you have a `front-page.php` file in your
theme.

This plugin idea came from a discussion
[here](http://lists.automattic.com/pipermail/wp-hackers/2012-August/044235.html),
[here](http://core.trac.wordpress.org/ticket/16379) and
[here](http://core.trac.wordpress.org/ticket/18705) (so far).

== Installation ==

Upload the plugin to your `wp-content/plugins` directory and optionally go to
`Settings -> Permalinks` and choose the URL for your posts home.

== TODO ==

* Create menu link items (in progress on GitHub).

== Changelog ==

= 0.03 =

* Changed plugin name.
* Documentation reviewed.

= 0.02 =

* Better options handling.
* Flush on activate and deactivate.
* Template functions.

= 0.01 =

* First version with some functional code.
