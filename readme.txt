=== Custom Functions ===

Contributors: littlebizzy
Donate link: https://www.patreon.com/littlebizzy
Tags: custom, functions, filters, settings, wp-config
Requires at least: 4.4
Tested up to: 4.9
Requires PHP: 7.2
Multisite support: No
Stable tag: 1.0.0
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Prefix: CSTMFN

Enables the ability to input custom WordPress functions such as filters in a centralized place to avoid the dependence on a theme functions.php file.

== Description ==

Enables the ability to input custom WordPress functions such as filters in a centralized place to avoid the dependence on a theme functions.php file.

* [**Join our FREE Facebook group for support!**](https://www.facebook.com/groups/littlebizzy/)
* [**Worth a 5-star review? Thank you!**](https://wordpress.org/support/plugin/custom-functions-littlebizzy/reviews/?rate=5#new-post)
* [Plugin Homepage](https://www.littlebizzy.com/plugins/custom-functions)
* [Plugin GitHub](https://github.com/littlebizzy/custom-functions)

*Our related OSS projects:*

* [SlickStack (LEMP stack automation)](https://slickstack.io)
* [WP Lite boilerplate](https://wplite.org)
* [Starter Theme](https://starter.littlebizzy.com)

#### The Long Version ####

Some custom functions plugins rely on the database, which is very unstable and doesn't allow proper debug checks. This plugin integrates the new code (syntax) editor API from WordPress COre to edit an actual PHP file where all your custom WordPress functions and filters can be stored as a physical file on the server. This way, the syntax editor can do its job properly, the functions/filters are parsed faster (e.g. via PHP Opcache) and no reliance on database is needed, meaning no database queries or possible fatal errors/crashes scenario.

Current version edits the following file (do not edit/delete via SFTP):

    `wp-content/functions.php`
    
To access visit WP Admin > Plugins Submenu > Custom Functions link
    
In the future we may have a include line at the very top of wp-config.php to prioritize loading order, as certain defined constants (etc) are better loaded prior to the mu-plugins / plugins / theme load sequence.

Dev team notes (1.0.0): the plugin editor integration has been a bit complicated because to be executed outside of the plugin/theme editor it needed several adjustments in javascript, replacing event handlers, overwrite some part of the code, etc. The server side code (managed via an AJAX action) to validate the submitted code uses functions copied from the WP core instead of calling their functions because the code does not allow to change default paths and URLs (no functions params or available filters). When the code is submitted, the wp-content/custom-functions.php file is saved directly without any validation. After that, the plugin sets a WP internal status in 'scrape mode' to detect PHP fatal errors, and performs two remote calls, one to the same plugin page emulating current logged user status (same cookies and headers emitted by browsers), and one to the homepage. If any of them produces a code exception, then error info is captured and makes a roll-back to the previous custom-functions.php code.

Last minute tweaks:

- Create file on plugin activation starting with <?php and also two line breaks.

- Changed target filename from custom-functions to functions.php

- Set sslverify to false in remote requests to avoid false positives in code validation checks due certificates issues (detected on temp.littelbizzy.com)

- Improved crap code removing its own plugin ajax requests via two ways:

a) Attemp to remove any previous existing buffer with ob_start, but it does not work on temp.littlebizzy.com, it is possible output_buffering = off in php.ini ?

b) Just if buffering fails, also it does not execute (include_once) the functions.php file from the plugin (this will not work if functions.php is included from other PHP script)

Why 1.0.0 doesn't include_once in wp-config file:

- WP functions does not exists yet at the wp-config.php level, so except for non-dependant functions it will generate warnings (include_once generates warnings instead of fatal errors of require_once)

- Code before <?php is considered HTML, but yes it is a problem too.

#### Compatibility ####

This plugin has been designed for use on LEMP (Nginx) web servers with PHP 7.0 and MySQL 5.7 to achieve best performance. All of our plugins are meant for single site WordPress installations only; for both performance and security reasons, we highly recommend against using WordPress Multisite for the vast majority of projects.

Note: Any WordPress plugin may also be loaded as "Must-Use" by using the [Autoloader](https://github.com/littlebizzy/autoloader) script within the `mu-plugins` directory.

#### Defined Constants ####

The following defined constants are supported by this plugin:

* `define('DISABLE_NAG_NOTICES', true);`

#### Plugin Features ####

* Premium Version: [**SEO Genius**](https://www.littlebizzy.com/plugins/seo-genius)
* Settings Page: No
* PHP Namespaces: Yes
* Object-Oriented Code: Yes
* Includes Media (images, icons, etc): No
* Includes CSS: No
* Database Storage: Yes
  * Transients: No
  * Options: Yes
  * Table Data: Yes
  * Creates New Tables: No
* Database Queries: Backend Only 
  * Query Types: Options API
* Multisite Support: No
* Uninstalls Data: Yes

#### Nag Notices ####

This plugin generates multiple [Admin Notices](https://codex.wordpress.org/Plugin_API/Action_Reference/admin_notices) in the WP Admin dashboard. The first is a notice that fires during plugin activation which recommends several related free plugins that we believe will enhance this plugin's features; this notice will re-appear approximately once every 6 months as our code and recommendations evolve. The second is a notice that fires a few days after plugin activation which asks for a 5-star rating of this plugin on its WordPress.org profile page. This notice will re-appear approximately once every 9 months. These notices can be dismissed by clicking the **(x)** symbol in the upper right of the notice box. These notices may annoy or confuse certain users, but are appreciated by the majority of our userbase, who understand that these notices support our free contributions to the WordPress community while providing valuable (free) recommendations for optimizing their website.

If you feel that these notices are too annoying, than we encourage you to consider one or more of our upcoming premium plugins that combine several free plugin features into a single control panel, or even consider developing your own plugins for WordPress, if supporting free plugin authors is too frustrating for you. A final alternative would be to place the defined constant mentioned below inside of your `wp-config.php` file to manually hide this plugin's nag notices:

    define('DISABLE_NAG_NOTICES', true);

Note: This defined constant will only affect the notices mentioned above, and will not affect any other notices generated by this plugin or other plugins, such as one-time notices that communicate with admin-level users.

#### Inspiration ####

* n/a

#### Free Plugins ####

* [404 To Homepage](https://wordpress.org/plugins/404-to-homepage-littlebizzy/)
* [Autoloader](https://github.com/littlebizzy/autoloader)
* [CloudFlare](https://wordpress.org/plugins/cf-littlebizzy/)
* [Custom Functions](https://wordpress.org/plugins/custom-functions-littlebizzy/)
* [Delete Expired Transients](https://wordpress.org/plugins/delete-expired-transients-littlebizzy/)
* [Disable Admin-AJAX](https://wordpress.org/plugins/disable-admin-ajax-littlebizzy/)
* [Disable Author Pages](https://wordpress.org/plugins/disable-author-pages-littlebizzy/)
* [Disable Cart Fragments](https://wordpress.org/plugins/disable-cart-fragments-littlebizzy/)
* [Disable Embeds](https://wordpress.org/plugins/disable-embeds-littlebizzy/)
* [Disable Emojis](https://wordpress.org/plugins/disable-emojis-littlebizzy/)
* [Disable Empty Trash](https://wordpress.org/plugins/disable-empty-trash-littlebizzy/)
* [Disable Image Compression](https://wordpress.org/plugins/disable-image-compression-littlebizzy/)
* [Disable jQuery Migrate](https://wordpress.org/plugins/disable-jq-migrate-littlebizzy/)
* [Disable Search](https://wordpress.org/plugins/disable-search-littlebizzy/)
* [Disable WooCommerce Status](https://wordpress.org/plugins/disable-wc-status-littlebizzy/)
* [Disable WooCommerce Styles](https://wordpress.org/plugins/disable-wc-styles-littlebizzy/)
* [Disable XML-RPC](https://wordpress.org/plugins/disable-xml-rpc-littlebizzy/)
* [Download Media](https://wordpress.org/plugins/download-media-littlebizzy/)
* [Download Plugin](https://wordpress.org/plugins/download-plugin-littlebizzy/)
* [Download Theme](https://wordpress.org/plugins/download-theme-littlebizzy/)
* [Duplicate Post](https://wordpress.org/plugins/duplicate-post-littlebizzy/)
* [Enable Subtitles](https://wordpress.org/plugins/enable-subtitles-littlebizzy/)
* [Export Database](https://wordpress.org/plugins/export-database-littlebizzy/)
* [Facebook Pixel](https://wordpress.org/plugins/fb-pixel-littlebizzy/)
* [Force HTTPS](https://wordpress.org/plugins/force-https-littlebizzy/)
* [Force Strong Hashing](https://wordpress.org/plugins/force-strong-hashing-littlebizzy/)
* [Google Analytics](https://wordpress.org/plugins/ga-littlebizzy/)
* [Header Cleanup](https://wordpress.org/plugins/header-cleanup-littlebizzy/)
* [Index Autoload](https://wordpress.org/plugins/index-autoload-littlebizzy/)
* [Maintenance Mode](https://wordpress.org/plugins/maintenance-mode-littlebizzy/)
* [Profile Change Alerts](https://wordpress.org/plugins/profile-change-alerts-littlebizzy/)
* [Remove Category Base](https://wordpress.org/plugins/remove-category-base-littlebizzy/)
* [Remove Query Strings](https://wordpress.org/plugins/remove-query-strings-littlebizzy/)
* [Server Status](https://wordpress.org/plugins/server-status-littlebizzy/)
* [StatCounter](https://wordpress.org/plugins/sc-littlebizzy/)
* [View Defined Constants](https://wordpress.org/plugins/view-defined-constants-littlebizzy/)
* [Virtual Robots.txt](https://wordpress.org/plugins/virtual-robotstxt-littlebizzy/)

#### Premium Plugins ####

* [**Members Only**](https://www.littlebizzy.com/members)
* [Dunning Master](https://www.littlebizzy.com/plugins/dunning-master)
* [Genghis Khan](https://www.littlebizzy.com/plugins/genghis-khan)
* [Great Migration](https://www.littlebizzy.com/plugins/great-migration)
* [Security Guard](https://www.littlebizzy.com/plugins/security-guard)
* [SEO Genius](https://www.littlebizzy.com/plugins/seo-genius)
* [Speed Demon](https://www.littlebizzy.com/plugins/speed-demon)

#### Special Thanks ####

* [Alex Georgiou](https://www.alexgeorgiou.gr)
* [Automattic](https://automattic.com)
* [Brad Touesnard](https://bradt.ca)
* [Daniel Auener](http://www.danielauener.com)
* [Delicious Brains](https://deliciousbrains.com)
* [Greg Rickaby](https://gregrickaby.com)
* [Matt Mullenweg](https://ma.tt)
* [Mika Epstein](https://halfelf.org)
* [Mike Garrett](https://mikengarrett.com)
* [Samuel Wood](http://ottopress.com)
* [Scott Reilly](http://coffee2code.com)
* [Jan Dembowski](https://profiles.wordpress.org/jdembowski)
* [Jeff Starr](https://perishablepress.com)
* [Jeff Chandler](https://jeffc.me)
* [Jeff Matson](https://jeffmatson.net)
* [Jeremy Wagner](https://jeremywagner.me)
* [John James Jacoby](https://jjj.blog)
* [Leland Fiegel](https://leland.me)
* [Paul Irish](https://www.paulirish.com)
* [Rahul Bansal](https://profiles.wordpress.org/rahul286)
* [Roots](https://roots.io)
* [rtCamp](https://rtcamp.com)
* [Ryan Hellyer](https://geek.hellyer.kiwi)
* [WP Chat](https://wpchat.com)
* [WP Tavern](https://wptavern.com)

#### Disclaimer ####

We released this plugin in response to our managed hosting clients asking for better access to their server, and our primary goal will remain supporting that purpose. Although we are 100% open to fielding requests from the WordPress community, we kindly ask that you keep the above-mentioned goals in mind... thanks!

== Installation ==

1. Upload to `/wp-content/plugins/custom-functions-littlebizzy`
2. Activate via WP Admin > Plugins
3. Edit file under WP Admin > Plugins Menu > Custom Functions submenu
4. Do not edit/delete via SFTP or otherwise: `wp-content/custom-functions.php`

== Frequently Asked Questions ==

= How can I change this plugin's settings? =

There is a settings page where you can add custom WordPress functions/filters or defined constants.

= I have a suggestion, how can I let you know? =

Please avoid leaving negative reviews in order to get a feature implemented. Instead, we kindly ask that you post your feedback on the wordpress.org support forums by tagging this plugin in your post. If needed, you may also contact our homepage.

== Changelog ==

= 1.0.0 =
* initial release
* tested with PHP 7.0
* tested with PHP 7.1
* tested with PHP 7.2
* object-oriented codebase
* plugin uses PHP namespaces
* creates/edits `wp-content/functions.php`
