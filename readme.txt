=== WP Editor Widget ===
Contributors: feedmeastraycat
Tags: widget, wysiwyg, editor
Requires at least: 3.5.1
Tested up to: 3.5.2
Stable tag: 0.2.1
License: MIT

	WP Editor Widget adds a WYSIWYG widget using the wp_editor().

== Description ==

This plugin adds a WYSIWYG widget using the WP core function wp_editor() without
adding a custom post type for each widget.

== Screenshots ==

1. The plugin adds a widget called "WP Editor Widget".
2. In the widget you can add a title, edit the content through a link and choose to output the title or not.
3. When you click the "Edit content" link the WP Editor appears above the content, much like the Add media button. Click "Update and close" and then "Save" to save your content in the widget.
4. The widget as displayed in Twenty Twelve.
5. You can choose to display the title.
6. The widget as displayed in Twenty Twelve with title output turned on.

== Installation ==

1. Extract the ZIP file and move the folder "wp-editor-widget", with it contents, 
   to `/wp-content/plugins/` in your WordPress installation
2. Activate the pluing under 'Plugins' in the WordPress admin area

== Changelog ==

= 0.2.1 =
* CSS bug fix for hide button on WYSIWYG overlay
* JS bug fix on get and set wpeditor content

= 0.2.0 =
* Changed the WYSIWYG overlay button from "Update and close" to a primary button called "Save and close"
* Changed so that the widget is saved when closing the WYSIWYG overlay
* Added pot translation file and Swedish translation (contact me if you wish to help translate, david.martensson@gmail.com)

= 0.1.1 =
* CSS fix for widget editor close button

= 0.1.0 =
* First stable proof of concept version.