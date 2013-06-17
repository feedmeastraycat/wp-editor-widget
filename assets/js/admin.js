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
		tinyMCE.editors['wp-editor-widget'].setContent(jQuery('#'+ contentId).val());
	},
	
	/**
	 * Update widget and close the editor
	 */
	updateWidgetAndCloseEditor: function() {
		jQuery('#'+ this.currentContentId).val(tinyMCE.editors['wp-editor-widget'].getContent());
		this.hideEditor();
	}
	
};