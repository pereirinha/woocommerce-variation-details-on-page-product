# WooCommerce Variation Details on Page Product

Contributors: pereirinha  
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=S626RA3BPS74S  
Tags: variation details, variation, dimensions, size, weight, woocommerce, woothemes  
Requires at least: 4.3 and WooCommerce 2.4  
Tested up to: 4.7.3  
Stable tag: 3.4.0  
License: GPLv3 or later  
License URI: http://www.opensource.org/licenses/gpl-license.php

Displays physical size and/or weight within meta details of product with variations.

## Description

With this plugin you can display size and/or weight details of your variable products based on defined attributes of your WooCommerce products.

On default environments, this plugin works out of the box.

## Features
* Your can use the shortcode `[mp_wc_vdopp_variations]` and hook there the visibility of your details.
* If your product is set to be variable and you have also set size and/or weight on each your predefined attributes, this plugin will show those details within other meta details.
* Choose the place holder to show variations.
* Choose data id/class of displayed data for CSS design.
* Choose the selector that triggers show data event.

## Feedback

* Will try to help on issues pointed on [Support forum](http://wordpress.org/support/plugin/woocommerce-variation-details-on-page-product) and [GitHub](https://github.com/pereirinha/woocommerce-variation-details-on-page-product/issues)
* Fell free to suggest or contribute
* Can find me on twitter [@porreirinha](https://twitter.com/porreirinha)

## Installation

1. Upload the entire `woocommerce-variation-details-on-page_product` folder to the `/wp-content/plugins/ directory`
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to Variations section under Product tab, within WooCommerce settings and define which attributes you want to handle

## Frequently Asked Questions

Q. Is there any shortcode that I can use to hook the details?  
A. Now there is, hurray. Just use the shortcode `[mp_wc_vdopp_variations]`.

Q. After upgrading to version 2.0 I'm not able to show my details  
A. Due to internal changes, all of the previous definitions of attribute keys were lost. You should go to Variation settings' tab, within WooCommerce settings and define again which attributes you want to handle.

## Screenshots

* The settings' page is where you define which attributes will display variations on page product. [Click for larger image view](http://www.wordpress.org/extend/plugins/woocommerce-variation-details-on-page-product/screenshot-1.jpg)
* Volumetric dimensions and weight. [Click for larger image view](http://www.wordpress.org/extend/plugins/woocommerce-variation-details-on-page-product/screenshot-2.jpg)

## Upgrade Notice

* Information prior to `3.4.0` about DOM selector will be removed from database. The plugin will find them for you;

## Changelog

### 3.4.0

+ Tested with WooCommerce 2.7.0 RC1;
* You don't need to set DOM selector anymore. The plugin will find it for you;
* Hook logic only to selectors that impact with variations;
* JavaScript refactor to ditch jQuery dependency;

### 3.3.1

* Make sure that front end only runs on variable products

### 3.3.0

* Move options within Product tab
* Add option for adding text before and after physical size and weight.
* Add filters `mp_wc_vdopp_before_size`, `mp_wc_vdopp_before_weight`, `mp_wc_vdopp_after_size` and `mp_wc_vdopp_after_weight` so it can be easily replaced

### 3.2.1

* Add support for multiple selectors
* Add debug mode
* Add translations support
* Add Portuguese translation

### 3.2

* Support for radio button selectors
* Data sanitization

### 3.1.2.2

* Automatically display variation details if default selection is defined
* Fix a bug that would cause display weight unit even if there was no weight variation set

### 3.1.2.1

* Bring back PHP 5.2 support
* Fix a bug pointed out by @seanph when saving settings, which required to refresh the settings page after saving to get right values

### 3.1.2

* Fix an issue caused by WooCommerce deprecated methods
* When defined DOM objects don't exist, console will log helping debugging
* Slimmer JavaScript overhead

### 3.1.1

* Fix sorting L x W x H

### 3.1

* Added shortcode feature. Using the shortcode `[mp_wc_vdopp_variations]` will replace any settings defined on the hook

### 3.0.2

* Fix a JavaScript bug that could limit the appearance of upper limits of variable attributes, as pointed [here](http://wordpress.org/support/topic/strange-behavior-2). Thank you Eran for reporting this issue.

### 3.0.1

* Fix a syntax error, `unexpected T_PAAMAYIM_NEKUDOTAYIM`

### 3.0.0

* Support Custom Attributes. Hurray.
* Successfully tested on nightly WooCommerce 2.0.0 RC2.
* You'll not be required to define which attributes to handle, as this plugin will track them for you. As a consequence, old data will be removed from your database.
* You can choose which DOM object will be used to hook product attributes.
* You can choose which DOM object will be used to trigger action. This is a cool feature as I've faced themes that redefine DOM elements.
* You can choose id/class for theming.
* These settings are defined out of the box so most users don't need to bother defining them.
* Minified version of javascript.
* Javascript improvement.

### 2.0.3.2

* Minor error fix when Debug Mode is on.

### 2.0.3.1

* Minor code cleanup.

### 2.0.3

* Support products that only have variations on weight.

### 2.0.2

* Fix a issue that would result on PHP Warning on implode() function in cases where products have any attributes.

### 2.0.1

* Fix a bug that could result on jQuery unexpected results.

### 2.0

* New Variation settings tab within WooCommerce settings.

* Added the Donation button. Have a wife and a dog to support.

### 1.1

* Fix a bug to remove empty classes product_details created after each change.
* Fix the following error: `Parse error: syntax error, unexpected '[' in ../woocommerce-variation-details-on-page-product/wc-attributes-on-page.php on line 31`

### 1.0

* Just unleash the first version.

## Basic Setup

This is a step-by-step that might help you on your setup.

1. Activate WooCommerce Variation Details on Page Product plugin and ta-da, that's it. It should work in most cases.
1. Use a front-end development tool — like Chrome Developer Tools — to track selectors on your DOM. Map them on WooCommerce > Settings > Variations according your needs.
1. Alternatively, you can use the shortcode `[mp_wc_vdopp_variations]` to hook variation details.

## Plugin Links

* [Developers: reports bugs & issues](https://github.com/pereirinha/woocommerce-variation-details-on-page-product/issues)
* [Developers: contribute](https://github.com/pereirinha/woocommerce-variation-details-on-page-product)
