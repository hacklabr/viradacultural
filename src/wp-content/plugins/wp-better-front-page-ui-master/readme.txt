=== Force Front Page ===
Contributors: viniciusmassuchetto, leogermani
Tags: rewrite rules, templates, home page
Requires at least: 3.0
Tested up to: 3.4
Stable tag: 0.01
License: GPLv2 or later

Lets you specify the URL for your blog when you have a front-page.php file in
your theme so you dont have to create two dummy pages as placeholders for your
Home and your Blog.

This plugin does not touch the Template hierarchy. All it does is setup an URL
to access your blog (is_home()) when you have a front_page.php file in your
theme. It also removes the "Front Page Displays" option from the Reading
Settings.

Note: This plugin will only work if you have a front-page.php file in your
theme

== Description ==

Lets you specify the URL for your blog when you have a front-page.php file in
your theme so you dont have to create two dummy pages as placeholders for your
Home and your Blog.

This plugin does not touch the Template hierarchy. All it does is setup an URL
to access your blog (is_home()) when you have a front_page.php file in your
theme. It also removes the "Front Page Displays" option from the Reading
Settings.

WordPress should deal with the site home page. The supported way today is:

1. Define a `front-page.php` for the site home and (optionally) a `home.php`
for the posts home.
2. Go to the site admin and create two dummy page.
3. Set this page as the front and posts pages in the reading settings.

This approach is too sensible, and will let users delete this dummy pages,
possibily breaking the site.

With this plugin, the same procedure will be:

1. Define a `front-page.php` for the site home and (optionally) a `home.php`
for the posts home.
2. Set what URL will point to the posts home in the permalink settings (default
is to /blog)

Note: This plugin will only work if you have a front-page.php file in your
theme

This plugin idea came from a discussion
[here](http://lists.automattic.com/pipermail/wp-hackers/2012-August/044235.html),
[here](http://core.trac.wordpress.org/ticket/16379) and
[here](http://core.trac.wordpress.org/ticket/18705) (so far).

== Installation ==

Upload the plugin to your `wp-content/plugins` directory and optionally go to
`Settings -> Permalink`.

== TODO ==

* Adds the possibility to users add links to home and blog to the menu

== Changelog ==

= 0.02 =

* Better options handling.
* Flush on activate and deactivate.
* Template functions.

= 0.01 =

* First version with some functional code.
