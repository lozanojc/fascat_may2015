=== CFS Custom Category Fields ===
Contributors: GatorDog
Donate link: http://gatordev.com/
Tags: category meta data, category custom fields, custom field suite addon
Requires at least: 3.6
Tested up to: 3.9
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A Custom Field Suite Addon that provides custom meta data for categories and custom taxonomies.

== Description ==

CFS Category Fields is a Custom Field Suite addon that provides meta data or custom fields for categories and custom taxonomies. Key features are as follows:

*   Apply Custom Fields to Categories and Custom Taxonomies
*   Requires the Custom Field Suite Plugin

== Screenshots ==

1. Apply Field Group to Category or Taxonomy

== Installation ==

1. Upload `cfs-taxonomy.zip` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Install and activate Custom Field Suite if not already installed
4. On the Field Group editor you will see a box to apply the Field Group to a Category or Taxonomy
5. Update the Field Group and the fields will be editable on the Wordpress Category Editor

== Frequently Asked Questions ==

= How do I retrieve custom fields for display on a category page? =

Use the function get_category_meta('field_name'), or alternatively, call CfsTaxonomy::get('field_name') directly, in your php.

== Changelog ==

= 1.0.1 =
* Flatten field data returned by get_category_meta() when all fields are returned.
= 1.0 =
* Initial Release.
