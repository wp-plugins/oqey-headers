=== Plugin Name ===
Plugin Name: oQey Headers
Version: 0.1
Contributors: Dorin , Victor
Donate link: http://www.qusites.com/oqey-headers-plugin/
Tags: headers
Requires at least: 2.0.2
Description: oQey Headers plugin, the header manager for your blog.
Author: Dorin D. | www.qusites.com
Author URI: http://www.qusites.com
Tested up to: 2.9
Stable tag: 0.1

== Description ==


oQey Headers plugin is a Wordpress Plugin that allows easy to add and manage images for blog header.

To insert image  in blog header use this line of code, this function get random image on refresh:

`<?php if (function_exists('oQeyRandomImage')) { oQeyRandomImage("", ""); } ?>`

Ex:

`<ul>

oQeyRandomImage("<li>", "</li>");

</ul>`

you can use this to display

`<ul>

<li><img src="example.jpg" width="x" height="y" alt="text"  /> </li>

</ul>`

or you can get all images and process how you whant:

`<?php if (function_exists('oQeyAllImages')) { oQeyAllImages(); } ?>`

You can download plugin from www.qusites.com


== Installation ==

1. Upload plugin files to the `/wp-content/plugins/oqey_headers` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place `<?php if (function_exists('oQeyRandomImage')) { oQeyRandomImage("", ""); } ?>  in your templates header.php file

== Frequently Asked Questions ==

= The plugin need a special setup? =

No.


== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the directory of the stable readme.txt, so in this case, `/trunk/screenshot-1.jpg` (or jpg, jpeg, gif)

== Changelog ==

= 0.1=
* First stable version.

== Upgrade Notice ==

= 0.1 =
First version.

== Arbitrary section ==

Later.

== A brief Markdown ==

Ordered list:

1. Easy to upload header images.
1. Easy to order images.
3. Easy to install the plugin.


