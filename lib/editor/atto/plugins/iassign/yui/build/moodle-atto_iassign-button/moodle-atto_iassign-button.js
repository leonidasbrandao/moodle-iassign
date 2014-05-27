YUI.add('moodle-atto_iassign-button', function (Y, NAME) {

/*
 * @package    atto_iassign
 * @copyright  2014
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Atto text editor iAssign plugin.
 *
 * @module moodle-atto_iassign-button
 * @namespace M.atto_iassign
 * @class button
 * @extends M.editor_atto.EditorPlugin
 */

var PLUGINNAME = 'atto_iassign';	
	
Y.namespace('M.atto_iassign').Button = Y.Base.create('button', Y.M.editor_atto.EditorPlugin, [], {
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


}, '@VERSION@', {"requires": ["moodle-editor_atto-plugin"]});
