<?php
/** 
 * Form to add and edit iLM params.
 * 
 * Release Notes:
 * - v1.2 2014/02/24
 * 		+ Insert new type in params.
 * - v 1.1 2014/01/24
 * 		+ Allow select type of params.
 * 
 * @author Patricia Alves Rodrigues
 * @author Leônidas O. Brandão
 * @author Luciano Oliveira Borges
 * @version v 1.2 2014/02/24
 * @package mod_iassign_settings
 * @since 2010/09/11
 * @copyright iMatica (<a href="http://www.matematica.br">iMath</a>) - Computer Science Dep. of IME-USP (Brazil)
 * 
 * <b>License</b> 
 *  - http://opensource.org/licenses/gpl-license.php GNU Public License
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
class param_ilm_form extends moodleform {
	
	/**
	 * Add elements to form
	 */
    function definition() {
        global $CFG, $COURSE, $USER, $DB;
        
        $action = optional_param('action', NULL, PARAM_TEXT);
        $ilm_id = optional_param('ilm_id', 0, PARAM_INT);
        $ilm_param_id = optional_param('ilm_param_id', 0, PARAM_INT);
        $type = optional_param('type', 'static', PARAM_TEXT);

        $mform = & $this->_form;
        
        $code_javascript = "
        <script type='text/javascript'>
        	//<![CDATA[
        		function select_type(type) {
        			window.location='$CFG->wwwroot/mod/iassign/settings_params.php?action=$action&ilm_id=$ilm_id&ilm_param_id=$ilm_param_id&type='+type;
        		}
        	//]]>
        </script>";

        //-------------------------------------------------------------------------------

        $mform->addElement('header', 'data_param', get_string('data_param', 'iassign'));
        
        $param_type = array('static' => get_string('param_type_static', 'iassign'), 
        					'value' => get_string('param_type_value', 'iassign'), 
        					'boolean' => get_string('param_type_boolean', 'iassign'),
        					'choice' => get_string('param_type_choice', 'iassign'),
        					'multiple' => get_string('param_type_multiple', 'iassign'));
        
        $mform->addElement('select', 'param_type', get_string('choose_type_param', 'iassign'), $param_type, array('onChange' => 'select_type(this.value);'));
        $mform->setDefault('param_type', $type);
        $mform->addHelpButton('param_type', 'type_param', 'iassign');

        $mform->addElement('text', 'param_name', get_string('config_param_name', 'iassign'), array('size' => '55'));
        $mform->setType('param_name', PARAM_TEXT);
        $mform->addRule('param_name', get_string('required', 'iassign'), 'required');
        $mform->addHelpButton('param_name', 'name_param', 'iassign');
        
        if($type == 'static'){
        	$mform->addElement('text', 'param_value', get_string('config_param_value', 'iassign'), array('size' => '55'));
        	$mform->setType('param_value', PARAM_TEXT);
        	$mform->addRule('param_value', get_string('required', 'iassign'), 'required');
        	$mform->addHelpButton('param_value', 'param_type_static', 'iassign');
        } else if($type == 'value'){
        	$mform->addElement('text', 'param_value', get_string('config_param_value', 'iassign'), array('size' => '55'));
        	$mform->setType('param_value', PARAM_TEXT);
        	$mform->addRule('param_value', get_string('required', 'iassign'), 'required');
        	$mform->addHelpButton('param_value', 'param_type_value', 'iassign');
        } else if($type == 'boolean'){
        	$mform->addElement('selectyesno', 'param_value', get_string('config_param_value', 'iassign'));
        	$mform->setDefault('param_value', 1);
        	$mform->addHelpButton('param_value', 'param_type_boolean', 'iassign');
        } else if($type == 'choice'){
        	$mform->addElement('textarea', 'param_value', get_string('config_param_value', 'iassign'), 'rows="4" cols="30"');
        	$mform->addHelpButton('param_value', 'param_type_choice', 'iassign');
        } else if($type == 'multiple'){
        	$mform->addElement('textarea', 'param_value', get_string('config_param_value', 'iassign'), 'rows="4" cols="30"');
        	$mform->addHelpButton('param_value', 'param_type_multiple', 'iassign');
        }
        
        $mform->addElement('htmleditor', 'description', get_string('config_param_description', 'iassign'));
        $mform->setType('description', PARAM_RAW);
        $mform->addRule('description', get_string('required', 'iassign'), 'required');
        $mform->addHelpButton('description', 'config_param_description', 'iassign');

        $mform->addElement('selectyesno', 'visible', get_string('visible', 'iassign'));
        $mform->setDefault('visible', 1);
        
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'iassign_ilmid');
        $mform->setType('iassign_ilmid', PARAM_INT);
        $mform->addElement('hidden', 'action');
        $mform->setType('action', PARAM_TEXT);
        
        $mform->addElement('html', $code_javascript);
        
        $mform->disable_form_change_checker();
                
        $this->add_action_buttons(true, get_string('write_form', 'iassign'));
        
    }

}
?>


