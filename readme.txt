=== WP Editor Widget ===
Contributors: feedmeastraycat
Tags: widget, wysiwyg, editor, rich text
Requires at least: 3.5.1
Tested up to: 4.5.2
Stable tag: 0.5.5
License: MIT

	WP Editor Widget adds a rich text widget where the content is edited using the standard WordPress visual editor.

== Description ==

This plugin adds a rich text widget where the content is edited using the standard WordPress visual editor which most users already are familiar with. 
It uses the WP core function wp_editor() without adding a custom post type post for each widget making the widget quicker and simpler to edit.

Feel free to help with developement or issue reporting on [Github](https://github.com/feedmeastraycat/wp-editor-widget)!

= Languages =
* English
* Swedish
* German
* Danish
* [More translations](https://translate.wordpress.org/projects/wp-plugins/wp-editor-widget)

== Screenshots ==

1. The plugin adds a widget called "Rich text".
2. In the widget you can add a title, edit the content through a link and choose to output the title or not.
3. When you click the "Edit content" link the WP Editor appears above the content, much like the Add media button. Click "Save and close" to save your content in the widget.
4. The widget as displayed in Twenty Fourteen.
5. You can choose to display the title.
6. The widget as displayed in Twenty Fourteen with title output turned on.

== Installation ==

1. Extract the ZIP file and move the folder "wp-editor-widget", with it contents, 
   to `/wp-content/plugins/` in your WordPress installation
2. Activate the pluing under 'Plugins' in the WordPress admin area

== Changelog ==

= 0.5.5 =
* Added Danish translation *(Thanks to [@docryan](https://github.com/docryan))*

= 0.5.4 =
* Added German translation *(Thanks to [@ohaucke](https://github.com/ohaucke))*
* Renamed the editor id to comply with WP Codex tips *(Might help with [Issue #3](https://github.com/feedmeastraycat/wp-editor-widget/issues/3))*

= 0.5.3 =
* Bugfix: [Issue #8](https://github.com/feedmeastraycat/wp-editor-widget/issues/8) - Filters for WP Editor Widget content wasn't always loaded *(since 0.5.0)*

= 0.5.2 =
* [WP Core Issue #27853](https://core.trac.wordpress.org/ticket/27853) has been fixed in WP 3.9.1, this change makes sure that the fix from last version only is active on WP 3.9 and earlier

= 0.5.1 =
* Bugfix: Couldn't switch to plain text on customize.php ([Issue #27853](https://core.trac.wordpress.org/ticket/27853))
* Bugfix: JS errors that could appear depending on if you loaded the editor in wysiwyg or plain text
* Bugfix: Didn't store plain text widget content correctly

= 0.5.0 =
* *This is a big change, please file an issue on [Github](https://github.com/feedmeastraycat/wp-editor-widget) if you find anything weird!*
* Changes for WP 3.9.0 (editor now works on the admin customization page as well as on the admin widgets page)
* *Most of the following changes thanks to [@cfoellmann](https://github.com/cfoellmann):*
* Added filter `wp_editor_widget_ops`
* Added filter `wp_editor_widget_update_instance`
* Added action `wp_editor_widget_update`
* Removed constant variable textdomain
* Changed textdomain to wordpress.org plugin id name
* Split widget class into it's own file
* Limited asset loading to widgets.php
* Changed PHP code style to WP standard

= 0.4.1 =
* Lowered the z-index of the WP Editor overlay modal because image buttons (in the editor) wasn't showing because they had lower z-index (thanks nbspjr on WordPress.org http://wordpress.org/support/topic/edit-mediagallery-buttons-are-not-shown-1)

= 0.4.0 =
* Added standard WP functions wptexturize, convert_smilies, convert_chars, wpautop, shortcode_unautop, prepend_attachment, do_shortcode to the wp_editor_widget_content filter (thanks danieliser on WordPress.org http://profiles.wordpress.org/danieliser/)

= 0.3.1 =
* Updated the Swedish translation
* Moved load_plugin_textdomain() for translation to the plugins_loaded action to make sure the widget is correctly translated.

= 0.3.0 =
* Changed the name of the widget to "Rich text" and the description to a less "techy" text (thanks /u/actionscripted on Reddit http://tinyurl.com/lnm99yj) for a UI more similar to the core widgets
* Tested in WP 3.6

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