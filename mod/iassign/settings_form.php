<?php
/** 
 * Form to add and edit interactive Learning Module (iLM).
 * 
 * Release Notes:
 * - v 1.6 2013/12/12
 * 		+ Insert support of import iLM from zip packages.
 * - v 1.5 2013/10/31
 * 		+ Insert support of import iLM from zip packages.
 * - v 1.4 2013/10/24
 * 		+ Fix required upload an file for new iLM.
 * - v 1.3 2013/07/12
 * 		+ Fix error messages of 'setType' in debug mode for hidden fields.
 * 		+ Form now accept actions: add, edit, copy (new version from an iLM), and new version (empty new version).
 * 
 * @author Patricia Alves Rodrigues
 * @author Leônidas O. Brandão
 * @author Luciano Oliveira Borges
 * @version v 1.6 2013/12/12
 * @package mod_iassign_settings
 * @since 2010/09/27
 * @copyright iMatica (<a href="http://www.matematica.br">iMath</a>) - Computer Science Dep. of IME-USP (Brazil)
 * 
 * <b>License</b> 
 *  - http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
/**
 * Moodle core defines constant MOODLE_INTERNAL which shall be used to make sure that the script is included and not called directly.
 */
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

require_once ($CFG->libdir . '/formslib.php');
require_once ($CFG->dirroot . '/course/moodleform_mod.php');
require_once ($CFG->dirroot . '/mod/iassign/lib.php');
/**
 * This class create form based moodleform.
 * @see moodleform
 */
class mod_ilm_form extends moodleform {
	
	/**
	 * Add elements to form
	 */
    function definition() {
        global $CFG, $COURSE, $USER, $DB;

        $mform = & $this->_form;
        
        if($CFG->action_ilm != 'import') {

	        if ($CFG->action_ilm == 'add') {
	            /* $params = array('parent' => '0');
	            $tmps = $DB->get_records_sql("SELECT s.id, s.name, s.extension, s.file_jar
	                                           FROM {iassign_ilm} s
	                                           WHERE s.parent = :parent", $params); // " - jed/emacs */
	            $tmps = $DB->get_records('iassign_ilm', array('parent' => 0));
	        } else {
	            /* $params = array('id' => $CFG->ilm_id);
	            $tmps = $DB->get_records_sql("SELECT s.id, s.name, s.extension, s.file_jar
	                                           FROM {iassign_ilm} s
	                                           WHERE s.id != :id AND s.parent = 0", $params); // " - jed/emacs */
	            $tmps = $DB->get_records('iassign_ilm', array('id' => $CFG->ilm_id));
	        }
	        $extensions = "";
	        $names = "";
	        $versions = "";
	        $filejars = "";
	        foreach ($tmps as $tmp) {
	        	$exts = explode(",", $tmp->extension);
	        	foreach ($exts as $ext)
	            	$extensions .="'" . $ext . "',";
	            $names .="'" . $tmp->name . "',";
	            $filejars .="'" . $tmp->file_jar . "',";
	        }
			
	        $iassign_ilm = $DB->get_record('iassign_ilm', array('id' => $CFG->ilm_id));
	        if(!$iassign_ilm){
	        	$iassign_ilm = new stdClass();
	        	$iassign_ilm->parent = 0;
	        }
	        
	        /// @todo Código Javascript, verificar alternativa. 
	        $code_javascript = "
	             <script type='text/javascript'>
	             //<![CDATA[
	
	             function search_name(name){
	               var i;
	               var names = new Array(";
	        $code_javascript .=$names . "'');" . chr(13);
	        $code_javascript .="
	               for (i=0;i<names.length;i++){
	                   if(names[i].toLowerCase()==name.toLowerCase()){
	                      document.forms['mform1'].name.value='';
	                      confirm('" . get_string('invalid_name_ilm', 'iassign') . " '+names[i]+'!');
	                    }
	                }";
	        $code_javascript .= "}
	        		
	
	             function search_extension(extensions){
	               var i;
	        	   var ext_inserteds = extensions.split(',');
	               var ext_exists = new Array(";
	        $code_javascript .=$extensions . "'');" . chr(13);
	        $code_javascript .="
	               for (k=0;k<ext_inserteds.length;k++){
	        		   for (i=0;i<ext_exists.length;i++){
	                   		if(ext_exists[i].toLowerCase()==ext_inserteds[k].toLowerCase()){
	                      		document.forms['mform1'].extension.value='';
	                      		confirm('" . get_string('invalid_extension_ilm', 'iassign') . " '+ext_exists[i]+'!');
	                    	}
	                   }
	                }";
	        $code_javascript .= "}
	
	             function search_filejar(fullfilejar){
	               var i;
	               var tmp=fullfilejar.split('/');
	               var filejar=tmp[tmp.length-1];
	                                  
	               var filejars = new Array(";
	        $code_javascript .=$filejars . "'');" . chr(13);
	        $code_javascript .="
	               for (i=0;i<filejars.length;i++){
	                   if(filejars[i].toLowerCase()==filejar.toLowerCase()){
	                      document.forms['mform1'].file_jar[0].value='';
	                      confirm('" . get_string('invalid_filejar_ilm', 'iassign') . " '+filejars[i]+'!');
	                    }
	                }";
	
	        $code_javascript .= "}
	        		
	        		function change_language(lang){
	        			if(document.forms['mform1'].description_lang.value != '') {
	        				descriptions = eval('(' + document.forms['mform1'].description_lang.value + ')');
        					descriptions[document.forms['mform1'].set_lang.value] = tinyMCE.activeEditor.getContent();
	        				document.forms['mform1'].description_lang.value = JSON.stringify(descriptions);
	        				if(descriptions[lang] != undefined)
	        					tinyMCE.activeEditor.setContent(descriptions[lang]);
	        				else
	        					tinyMCE.activeEditor.setContent('');
	        			} else {
	        				document.forms['mform1'].description_lang.value = '{ \"' + document.forms['mform1'].set_lang.value + '\" : \"' + tinyMCE.activeEditor.getContent() + '\" }';
        					tinyMCE.activeEditor.setContent('');
	        			}
	        			document.forms['mform1'].set_lang.value = lang;
	        		}
	        		
	               //]]>
	               </script>";
	
	        //-------------------------------------------------------------------------------
	        /// Adding the "data_ilm" fieldset, where all the common settings are showed
	
	        $mform->addElement('header', 'data_ilm', get_string('data_ilm', 'iassign'));
	
	        /// Adding the standard "name" field
	        if ($CFG->action_ilm != 'add') {
		        $mform->addElement('static', 'name_ilm', get_string('name_ilm', 'iassign'));
		        $mform->addElement('hidden', 'name');
		        $mform->setType('name', PARAM_TEXT);
	        } else {
	        	$mform->addElement('text', 'name', get_string('name_ilm', 'iassign'), array('size' => '55', 'onchange' => 'search_name(this.value);'));
	        	$mform->setType('name', PARAM_TEXT);
	        	$mform->addRule('name', get_string('required', 'iassign'), 'required');
	        }
	        
	        /// Adding the standard "version" field
	        $mform->addElement('text', 'version', get_string('version_ilm', 'iassign'), array('size' => '55'));
	        $mform->setType('version', PARAM_TEXT);
	        $mform->addRule('version', get_string('required', 'iassign'), 'required');
	        $mform->addHelpButton('version', 'version_ilm', 'iassign');
	        
	        /// Adding the standard "url" field
	        $mform->addElement('text', 'url', get_string('url_ilm', 'iassign'), array('size' => '55'));
	        $mform->setType('url', PARAM_TEXT);
	
	        $mform->addElement('select', 'lang', get_string('language_label', 'iassign'), get_string_manager()->get_list_of_translations(), array('onChange' => 'change_language(this.value);'));
	        $mform->setDefault('lang', current_language());
	        /// Adding the standard "description" field
	        $mform->addElement('htmleditor', 'description', get_string('description', 'iassign'));
	        $mform->setType('description', PARAM_RAW);
	        $mform->addRule('description', get_string('required', 'iassign'), 'required');
	
	        /// Adding the "data_file_jar" fieldset, where all the common settings are showed
	        $mform->addElement('header', 'data_file_jar', get_string('data_file_jar', 'iassign'));
	
	
	        $mform->addElement('static', 'file_jar_static', get_string('file_jar', 'iassign'));
	
	        /// Adding the standard "file_class" field
	        $mform->addElement('text', 'file_class', get_string('file_class', 'iassign'), array('size' => '55'));
	        $mform->setType('file_class', PARAM_TEXT);
	        $mform->addRule('file_class', get_string('required', 'iassign'), 'required');
	
	        /// Adding the standard "extension" field
	        $mform->addElement('text', 'extension', get_string('extension', 'iassign'), array('size' => '30', 'onchange' => 'search_extension(this.value);'));
	        $mform->setType('extension', PARAM_TEXT);
	        $mform->addRule('extension', get_string('required', 'iassign'), 'required');
	        $mform->addHelpButton('extension', 'extension', 'iassign');
	
	        /// Adding the standard "width" field
	        $mform->addElement('text', 'width', get_string('width', 'iassign'), array('size' => '10'));
	        $mform->setType('width', PARAM_TEXT);
	        $mform->addRule('width', get_string('required', 'iassign'), 'required');
	
	        /// Adding the standard "height" field
	        $mform->addElement('text', 'height', get_string('height', 'iassign'), array('size' => '10'));
	        $mform->setType('height', PARAM_TEXT);
	        $mform->addRule('height', get_string('required', 'iassign'), 'required');
	
	        /// Adding the standard "evaluate" field
	        $mform->addElement('selectyesno', 'evaluate', get_string('auto_evaluate', 'iassign'));
	        $mform->setDefault('evaluate', 1);
	        $mform->addRule('evaluate', get_string('required', 'iassign'), 'required');
	        $mform->addHelpButton('evaluate', 'auto_evaluate', 'iassign');
	        
	        /// Upload file ilm
	
	        $mform->addElement('header', 'upload_jar', get_string('upload_jar', 'iassign'));
	        //$mform->setExpanded('upload_jar');
	        $options = array('subdirs' => 0, 'maxbytes' => $CFG->userquota, 'maxfiles' => -1, 'accepted_types' => '*');
	        $mform->addElement('filemanager', 'file', null, null, $options);
	        if ($CFG->action_ilm == 'add' || $CFG->action_ilm == 'copy' || $CFG->action_ilm == 'new_version')
	        	$mform->addRule('file', get_string('required', 'iassign'), 'required');
	        
	        /// Adding the standard "hidden" field
	        if ($CFG->action_ilm == 'edit') {
	            $mform->addElement('hidden', 'id');
	            $mform->setType('id', PARAM_INT);
	        }
	        $mform->addElement('hidden', 'set_lang');
	        $mform->setType('set_lang', PARAM_TEXT);
	        $mform->setDefault('set_lang', current_language());
	        $mform->addElement('hidden', 'description_lang');
	        $mform->setType('description_lang', PARAM_TEXT);
	        $mform->addElement('hidden', 'file_jar');
	        $mform->setType('file_jar', PARAM_TEXT);
	        $mform->addElement('hidden', 'author');
	        $mform->setType('author', PARAM_TEXT);
	        $mform->addElement('hidden', 'action');
	        $mform->setType('action', PARAM_TEXT);
	        $mform->addElement('hidden', 'timecreated');
	        $mform->setType('timecreated', PARAM_TEXT);
	        $mform->addElement('hidden', 'timemodified');
	        $mform->setType('timemodified', PARAM_TEXT);
	        $mform->addElement('hidden', 'parent');
	        $mform->setType('parent', PARAM_INT);
	        $mform->addElement('hidden', 'enable');
	        $mform->setType('enable', PARAM_INT);
	        
	        $mform->addElement('html', $code_javascript);
        } else {
        	$mform->addElement('header', 'upload_ilm', get_string('upload_ilm', 'iassign'));
        	//$mform->setExpanded('upload_ilm');
        	$options = array('subdirs' => 0, 'maxbytes' => $CFG->userquota, 'maxfiles' => 1, 'accepted_types' => array('*'));
        	$mform->addElement('filepicker', 'file', null, null, $options);
        	$mform->addRule('file', get_string('required', 'iassign'), 'required');
        	
        	$mform->addElement('hidden', 'action');
        	$mform->setType('action', PARAM_TEXT);
        }
        
        $this->add_action_buttons();
    }

}