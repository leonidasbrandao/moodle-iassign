var PLUGINNAME = 'atto_iassign';
YUI.add("moodle-atto_iassign-button",function(e,t){
	e.namespace("M.atto_iassign").Button=e.Base.create("button",e.M.editor_atto.EditorPlugin,[],{
		_currentSelection: null,
		/**
		 * Function for initialize namespace.
		 */
	    initializer: function() {
	    	
	        this.addButton({
	            icon: M.util.image_url('icon', PLUGINNAME),
	            callback: this._selectFile
	        });
	    },
	    /**
	     * Function for callback button in editor.
	     */
	    _selectFile: function() {
	    	this._currentSelection = this.get('host').getSelection();
	    	
	    	open_ilm_manager = window.open(this.get('iassign_wwwroot')+'?id='+this.get('iassign_course')+'&from=atto','','width=1000,height=880,menubar=0,location=0,scrollbars,status,fullscreen,resizable');
	    }
	}, {
	    ATTRS: {
	    	iassign_wwwroot: {
	            value: null
	        },
	        iassign_course: {
	            value: null
	        }
	    }
	});
},"@VERSION@",{requires:["moodle-editor_atto-plugin"]});
