=== Plugin Name ===
Plugin Name: oQey Headers
Version: 0.3
Contributors: oQeySites.com
Donate link: http://www.qusites.com/oqey-headers-plugin/
Tags: headers, flash headers, images, manage, image with text, header + description
Requires at least: 3.0.0
Tested up to: 3.0.0
Stable tag: 0.5

== Description ==


oQey Headers plugin is a Wordpress Plugin that allows to add and manage images for blog header easily.

NEW: Add image description, you can add some text to your images.
 - suport for flash header. 

For instruction on how to insert the plugin into wp template, please visit www.oqeysites.com


== Installation ==

1. Unzip the plugin archive and put oqey-headers folder into your plugins directory (wp-content/plugins/)
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place `<?php if (function_exists("oQeyRandomImage")) { oQeyRandomImage("", ""); } ?>` in your templates
4. Place `<?php if (function_exists("oQeyFlashImages")) { oQeyFlashImages(); } ?>` in your templates if you want a flash header, the header is set to show 900 x 300 px, so upload images on this size
5. Create a folder named "oqey_headers_images" with 775 permission, this is required if the folder was not created automatically by the plugin; may be safe_mode restriction. Please be sure that safe_mode=off.


== Frequently Asked Questions ==

= The plugin need a special setup? =

No.


== Screenshots ==

1. Manage page

== Changelog ==

= 0.3=

* You can add descriptions for the images.


= 0.2=

* Second stable version, flash support.

= 0.1=

* First stable version.


== Upgrade Notice ==

= 0.3=

* You can add descriptions for the images.

= 0.2 =
*Support flash header.

= 0.1=

* First stable version.


== A brief Markdown ==

1. Easy to upload header images.
1. Easy to order images.
3. Easy to install the plugin.