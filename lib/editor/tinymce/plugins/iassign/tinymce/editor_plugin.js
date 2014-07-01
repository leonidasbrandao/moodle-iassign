/**
 * @author Luciano Oliveira Borges
 */

(function() {

    tinymce.create('tinymce.plugins.iassignPlugin', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(ed, url) {
            // Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceiAssign');
            ed.addCommand('mceiAssign', function() {
				
				open_ilm_manager = window.open(ed.getParam("iassign_wwwroot")+'?id='+ed.getParam("iassign_course")+'&from=tinymce','','width=1000,height=880,menubar=0,location=0,scrollbars,status,fullscreen,resizable');

            });
            ed.addCommand('mceiAssignReturn', function(tag_filter) {
            	
            	ed.selection.setContent(tag_filter);

            });
            ed.addCommand('mceiAssignClean', function() {
            	
            	ed.selection.setContent(tag_filter);

            });
            // Register iassign button
            ed.addButton('iassign', {
                title : 'iassign.desc',
                cmd : 'mceiAssign',
                image : url + '/img/iassign.gif'
            });

        },

        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo : function() {
            return {
                longname : 'iAssign plugin',
                author : 'Luciano Oliveira Borges',
                authorurl : 'http://www.matematica.br/tinymce_iassign',
                infourl : 'http://docs.moodle.org/en/TinyMCE',
                version : "1.25"
            };
        }
    });

    // Register plugin.
    tinymce.PluginManager.add('iassign', tinymce.plugins.iassignPlugin);
})();
