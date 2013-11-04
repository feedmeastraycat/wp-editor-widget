/**
 * WP Editor Widget object
 */
WPEditorWidget = {
	
	/** 
	 * @var string
	 */
	currentContentId: '',

	/**
	 * Show the editor
	 * @param string contentId
	 */
	showEditor: function(contentId) {
		jQuery('#wp-editor-widget-backdrop').show();
		jQuery('#wp-editor-widget-container').show();
		
		this.currentContentId = contentId;
		
		this.setEditorContent(contentId);
	},
	
	/**
	 * Hide editor
	 */
	hideEditor: function() {
		jQuery('#wp-editor-widget-backdrop').hide();
		jQuery('#wp-editor-widget-container').hide();
	},
	
	/**
	 * Set editor content
	 */
	setEditorContent: function(contentId) {
		var editor = tinyMCE.EditorManager.get('wp-editor-widget');
		if (typeof editor == "undefined") {
			jQuery('#wp-editor-widget').val(jQuery('#'+ contentId).val());
		}
		else {
			editor.setContent(jQuery('#'+ contentId).val());
		}
	},
	
	/**
	 * Update widget and close the editor
	 */
	updateWidgetAndCloseEditor: function() {
		var editor = tinyMCE.EditorManager.get('wp-editor-widget');
		if (typeof editor == "undefined") {
			jQuery('#'+ this.currentContentId).val(jQuery('#wp-editor-widget').val());
		}
		else {
			jQuery('#'+ this.currentContentId).val(editor.getContent());
		}
		wpWidgets.save(jQuery('#'+ this.currentContentId).closest('div.widget'), 0, 1, 0);
		this.hideEditor();
	}
	
};