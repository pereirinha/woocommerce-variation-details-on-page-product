=== WooCommerce Variation Details on Page Product ===
Contributors: pereirinha
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=S626RA3BPS74S
Tags: variation details, variation, dimensions, size, weight, woocommerce, woothemes
Requires at least: 3.4.1 and WooCommerce 1.6.3
Tested up to: 3.5.1
Stable tag: 2.0.3.2
License: GPLv3 or later
License URI: http://www.opensource.org/licenses/gpl-license.php

Displays physical size and/or weight within meta details of product with variations.

== Description ==

With this plugin you can display size and/or weight details of your variable products based defined attributes of WooCommerce.

It creates a new class called product_details inside product_meta, so you can easily custom on CSS.

= Features =
* If your product is set to be variable and you have also set size and/or weight on each your predefined attributes, this plugin will show those details within other meta details.

= Feedback =
* Will try to help on issues pointed on http://wordpress.org/support/plugin/woocommerce-variation-details-on-page-product and https://github.com/pereirinha/woocommerce-variation-details-on-page-product/issues
* Fell free to suggest or contribute
* Can find me on twitter @porreirinha

== Installation ==

1. Upload the entire 'woocommerce-variation-details-on-page_product' folder to the '/wp-content/plugins/' directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to Variation settings tab, within WooCommerce settings and define which attributes you want to handle

== Frequently Asked Questions ==

= After upgrading to version 2.0 I'm not able to show my details =
Due to internal changes, all of the previous definitions of attribute keys were lost. You should go to Variation settings' tab, within WooCommerce settings and define again which attributes you want to handle.

= Despite all have been defined, I'm still not able to show my details =
At this point, vdopp plugin doesn't support "Custom product attributes". You will need to define attributes under Products tab.

== Screenshots ==

1. The settings' page is where you define which attributes will display variations on page product. [Click for larger image view](http://www.wordpress.org/extend/plugins/woocommerce-variation-details-on-page-product/screenshot-1.jpg)
1. Bi-dimensional metric system details. [Click for larger image view](http://www.wordpress.org/extend/plugins/woocommerce-variation-details-on-page-product/screenshot-2.jpg)
1. Imperial system dimensions and weight. [Click for larger image view](http://www.wordpress.org/extend/plugins/woocommerce-variation-details-on-page-product/screenshot-3.jpg)
1. Volumetric dimensions and weight. [Click for larger image view](http://www.wordpress.org/extend/plugins/woocommerce-variation-details-on-page-product/screenshot-4.jpg)

== Changelog ==

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

1. Go to Products > Attributes page and define a new Attribute, size for instance, with several Terms as you like: small, medium, large;
1. Create a product on WooCommerce;
1. Define it as a Variable Product on Product Data tab;
1. On Attributes tab within Product Data tab add the Attribute created on step 1, in this case Size;
1. On the new form, where asked for values, click on 'Select all'. It should map all terms: small, medium, large; and check Visible on the product page and Used for variations;
1. Save a draft, in order to Variations become available;
1. On Variations tab you can Link all variations, or, add one by one your Variation Size, selecting one of default selections and fill the desired fields. Be sure to setup dimensions;
1. Add information for the remaining selections;
1. Publish your product;
1. Find the product page on your shop;
1. Select one off your sizes and notice that dimension information will be shown bellow your add to cart button;
1. Select any other size and notice that dimension information will automatically will change.

Quick step-by-step video tutorial.
[vimeo http://vimeo.com/51533811]

== Plugin Links ==
* [Developers: reports bugs & issues](https://github.com/pereirinha/woocommerce-variation-details-on-page-product/issues)
* [Developers: contribute](https://github.com/pereirinha/woocommerce-variation-details-on-page-product)