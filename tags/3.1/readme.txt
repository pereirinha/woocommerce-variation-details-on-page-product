=== WooCommerce Variation Details on Page Product ===
Contributors: pereirinha
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=S626RA3BPS74S
Tags: variation details, variation, dimensions, size, weight, woocommerce, woothemes
Requires at least: 3.4.1 and WooCommerce 1.6.3
Tested up to: 3.5.1
Stable tag: 3.1
License: GPLv3 or later
License URI: http://www.opensource.org/licenses/gpl-license.php

Displays physical size and/or weight within meta details of product with variations.

== Description ==

With this plugin you can display size and/or weight details of your variable products based on defined attributes of your WooCommerce products.

On default environments, this plugin works out of the box.

= Features =
* Your can use the shortcode [mp_wc_vdopp_variations] and hook there the visibility of your details.
* If your product is set to be variable and you have also set size and/or weight on each your predefined attributes, this plugin will show those details within other meta details.
* Support version WooCommerce 2.0.*
* Choose the place holder to show variations.
* Choose data id/class of displayed data for CSS design.
* Choose the selector that triggers show data event.

= Feedback =
* Will try to help on issues pointed on http://wordpress.org/support/plugin/woocommerce-variation-details-on-page-product and https://github.com/pereirinha/woocommerce-variation-details-on-page-product/issues
* Fell free to suggest or contribute
* Can find me on twitter @porreirinha

== Installation ==

1. Upload the entire 'woocommerce-variation-details-on-page_product' folder to the '/wp-content/plugins/' directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to Variation settings tab, within WooCommerce settings and define which attributes you want to handle

== Frequently Asked Questions ==

= Is there any shortcode that I can use to hook the details? =
Now there is, hurray. Just use the shortcode [mp_wc_vdopp_variations].

= After upgrading to version 2.0 I'm not able to show my details =
Due to internal changes, all of the previous definitions of attribute keys were lost. You should go to Variation settings' tab, within WooCommerce settings and define again which attributes you want to handle.

== Screenshots ==

1. The settings' page is where you define which attributes will display variations on page product. [Click for larger image view](http://www.wordpress.org/extend/plugins/woocommerce-variation-details-on-page-product/screenshot-1.jpg)
1. Bi-dimensional metric system details. [Click for larger image view](http://www.wordpress.org/extend/plugins/woocommerce-variation-details-on-page-product/screenshot-2.jpg)
1. Imperial system dimensions and weight. [Click for larger image view](http://www.wordpress.org/extend/plugins/woocommerce-variation-details-on-page-product/screenshot-3.jpg)
1. Volumetric dimensions and weight. [Click for larger image view](http://www.wordpress.org/extend/plugins/woocommerce-variation-details-on-page-product/screenshot-4.jpg)

== Changelog ==

= 3.1 =
* Added shortcode feature. Using the shortcode [mp_wc_vdopp_variations] will replace any settings defined on the hook

= 3.0.2 =
* Fix a JavaScript bug that could limit the appearance of upper limits of variable attributes, as pointed in http://wordpress.org/support/topic/strange-behavior-2. Thank you Eran for reporting this issue.

= 3.0.1 =
* Fix a syntax error, unexpected T_PAAMAYIM_NEKUDOTAYIM

= 3.0.0 =
* Support Custom Attributes. Hurray.
* Sucessfully tested on nightly WooCommerce 2.0.0 RC2.
* You'll not be required to define which attributes to handle, as this plugin will track them for you. As a consequence, old data will be removed from your database.
* You can choose which DOM object will be used to hook product attributes.
* You can choose which DOM object will be used to trigger action. This is a cool feature as I've faced themes that redefine DOM elements.
* You can choose id/class for theming.
* These settings are defined out of the box so most users don't need to bother defining them.
* Minified version of javascript.
* Javascript improvement.

= 2.0.3.2 =
* Minor error fix when Debug Mode is on.

= 2.0.3.1 =
* Minor code cleanup.

= 2.0.3 =
* Support products that only have variations on weight.

= 2.0.2 =
* Fix a issue that would result on PHP Warning on implode() function in cases where products have any attributes.

= 2.0.1 =
* Fix a bug that could result on jQuery unexpected results.

= 2.0 =
* New Variation settings tab within WooCommerce settings.
* Added the Donation button. Have a wife and a dog to support.

= 1.1 =
* Fix a bug to remove empty classes product_details created after each change.
* Fix the following error: Parse error: syntax error, unexpected '[' in ../woocommerce-variation-details-on-page-product/wc-attributes-on-page.php on line 31

= 1.0 =
* Just unleash the first version.

== Basic Setup ==

This is a step-by-step that might help you on your setup.

1. Activate WooCommerce Variation Details on Page Product plugin and ta-da, that's it. It should work in most cases.
1. Use a front-end development tool — like firebug — to track selectors on your DOM. Map them on WooCommerce > Settings > Variations according your needs.
1. Alternatively, you can use the shortcode [mp_wc_vdopp_variations] to hook variation details.

== Plugin Links ==
* [Developers: reports bugs & issues](https://github.com/pereirinha/woocommerce-variation-details-on-page-product/issues)
* [Developers: contribute](https://github.com/pereirinha/woocommerce-variation-details-on-page-product)