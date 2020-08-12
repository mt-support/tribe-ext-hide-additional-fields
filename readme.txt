=== Events Calendar PRO Extension: Hide Additional Fields ===
Contributors: ModernTribe
Donate link: http://m.tri.be/29
Tags: events, calendar
Requires at least: 4.5
Tested up to: 5.4.2
Requires PHP: 5.6
Stable tag: 1.0.1
License: GPL version 3 or any later version
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Provides the option to hide additional fields from the front end of events

== Description ==

Provides the option to hide additional fields from the front end of events

== Installation ==

Install and activate like any other plugin!

* You can upload the plugin zip file via the *Plugins ‣ Add New* screen
* You can unzip the plugin and then upload to your plugin directory (typically _wp-content/plugins)_ via FTP
* Once it has been installed or uploaded, simply visit the main plugin list and activate it

== Frequently Asked Questions ==

= Where can I find more extensions? =

Please visit our [extension library](https://theeventscalendar.com/extensions/) to learn about our complete range of extensions for The Events Calendar and its associated plugins.

= What if I experience problems? =

We're always interested in your feedback and our [premium forums](https://theeventscalendar.com/support-forums/) are the best place to flag any issues. Do note, however, that the degree of support we provide for extensions like this one tends to be very limited.

== Changelog ==

= 1.0.1 2020-08-12 =

* Fix - Protect against using `in_array()` on non-array and other "undefined index" PHP notices. [EXT-202]
* Fix - Support hiding Additional Fields that had punctuation that gets converted to HTML entities, such as `&#039;` vs `'`. [EXT-202]
* Fix - Remove post meta entry from database if all boxes are unchecked to keep database clean. [EXT-202]

= 1.0.0 2018-06-18 =

* Initial release
