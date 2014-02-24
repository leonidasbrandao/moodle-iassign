<?php
/** 
 * Form to add and edit interactive activities
 * 
 * 
 * Release Notes:
 * - v 1.5 2013/09/19
 * 		+ Insert function for validation form (mod_iassign_form::validation).
 * 		+ Fix bugs in download exercise file.
 * - v 1.4 2013/08/21
 * 		+ Change title link with message for get file for donwload file.
 * - v 1.3 2013/08/15
 * 		+ Change view file for allow download file.
 * - v 1.2 2013/08/01
 * 		+ Fix error in sql query for var $igeom.
 * - v 1.1 2013/07/12
 * 		+ Fix error messages of 'setType' in debug mode for hidden fields.
 * 
 * @author Patricia Alves Rodrigues
 * @author Leônidas O. Brandão
 * @author Luciano Oliveira Borges
 * @version v 1.5 2013/09/19
 * @package mod_iassign
 * @since 2010/09/27
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
class mod_iassign_form extends moodleform {

    /**
     * Add elements to form
     */
    function definition() {
        global $CFG, $COURSE, $USER, $DB, $OUTPUT;
        $mform = & $this->_form;
        $instance = $this->_customdata;
        $id = $COURSE->cm;
        $iassignid = optional_param('iassignid', 0, PARAM_INT);
        $iassign_ilmid = optional_param('iassign_ilmid', 0, PARAM_INT); 

        $params = array('name' => '%iGeom%');
        $igeom = $DB->get_records_sql('SELECT s.id, s.name, s.parent 
              							FROM {iassign_ilm} s
              							WHERE s.name LIKE :name', $params);
        $idigeom = array();
        foreach ($igeom as $item)
            $idigeom[] = $item->id;
        
        $iassign_ilm = $DB->get_record ( "iassign_ilm", array('id' => $iassign_ilmid));
        if(!$iassign_ilm) {
        	$iassign_ilm = new stdClass ();
        	$iassign_ilm->evaluate = 1;
        }

        /// @todo Código Javascript, verificar alternativa.
        
		$code_javascript = "
        <script type='text/javascript'>
        //<![CDATA[
        
            document.forms['mform1'].filename.disabled=1;  
              
            function config_ilm(id){
            	var action = document.forms['mform1'].action.value;
            	var iassign_ilmid = document.forms['mform1'].iassign_ilmid.value;
            	window.location='$CFG->wwwroot/mod/iassign/view.php?id=$id&action='+action+'&iassignid=$iassignid&iassign_ilmid='+iassign_ilmid;
            }
        
            function view_ilm_manager(){
            	document.forms['mform1'].filename.disabled=1;    
	      		open_ilm_manager=window.open('$CFG->wwwroot/mod/iassign/ilm_manager.php?id=$COURSE->id&from=iassign&ilmid='+document.forms['mform1'].iassign_ilmid.value,'','width=1000,height=880,menubar=0,location=0,scrollbars,status,fullscreen,resizable');
	      	}
        //]]>
        </script>";

        //-------------------------------------------------------------------------------
        /// Adding the "title_type_iassign" fieldset, where all the common settings are showed

        $mform->addElement('header', 'title_type_iassign', get_string('type_iassign', 'iassign'));
        $type_iassign = array();
        $type_iassign[1] = get_string('example', 'iassign');
        $type_iassign[2] = get_string('test', 'iassign');
        $type_iassign[3] = get_string('exercise', 'iassign');

        $mform->addElement('select', 'type_iassign', get_string('choose_type_activity', 'iassign'), $type_iassign);
        $mform->setDefault('type_iassign', 3); // default type_iassign = 3
        $mform->addHelpButton('type_iassign', 'helptypeiassign', 'iassign');
        //-------------------------------------------------------------------------------
        /// Adding the "data_activity" fieldset, where all the common settings are showed

        $mform->addElement('header', 'data_activity', get_string('data_activity', 'iassign'));
        $mform->addElement('static', 'author', get_string('author_id', 'iassign'));
        $mform->addElement('static', 'author_modified', get_string('author_id_modified', 'iassign'));

        /// Adding the standard "name" field
        $mform->addElement('text', 'name', get_string('iassigntitle', 'iassign'), array('size' => '55'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', get_string('required', 'iassign'), 'required');

        /// Adding the standard "proposition" field
        $mform->addElement('htmleditor', 'proposition', get_string('proposition', 'iassign'));
        $mform->setType('proposition', PARAM_RAW);
        $mform->addRule('proposition', get_string('required', 'iassign'), 'required');

        ///-----------------------------------------------------------------------------
        /// Adding the "interactivy_learning_module" fieldset, where all the common settings are showed
        $mform->addElement('header', 'interactivy_learning_module', get_string('interactivy_learning_module', 'iassign'));
        //$mform->setExpanded('interactivy_learning_module');

        // Search imas registered in the database
        $ilms = search_iLM(1);
        
        $applets = array();
        foreach ($ilms as $ilm)
            $applets[$ilm->id] = $ilm->name.' '.$ilm->version;
        $mform->addElement('select', 'iassign_ilmid', get_string('choose_iLM', 'iassign'), $applets, array('onChange' => 'config_ilm(this.value);'));
        $mform->addHelpButton('iassign_ilmid', 'helpchoose_ilm', 'iassign');
        if($iassign_ilmid != 0)
        	$mform->setDefault('iassign_ilmid', $iassign_ilmid);
        
        $fileurl = "";
        $filename = "";
        if(!is_null($COURSE->iassign_file_id)) {
        	$fs = get_file_storage();
        	$file = $fs->get_file_by_id( $COURSE->iassign_file_id );
        	$fileurl = "{$CFG->wwwroot}/pluginfile.php/{$file->get_contextid()}/mod_iassign/exercise" . '/' . $file->get_itemid () . $file->get_filepath () . $file->get_filename ();
        	$filename = $file->get_filename();
        }
        $html_div  = '<div id="fitem_id_iassign_file_id" class="fitem required fitem_fgroup">';
        $html_div .= '<div class="fitemtitle"><label for="id_iassign_file_id">'.get_string('choose_file', 'iassign');
        $html_div .= '<img class="req" title="'.get_string('requiredelement', 'form').'" alt="'.get_string('requiredelement', 'form').'" src="'.$CFG->wwwroot.'/theme/image.php/standard/core/1379534589/req"></label></div>';        
        $html_div .= '<div class="felement fselect">';
        $html_div .= '<span id="iassign_file_link" style="color:#000000;"><a href="'.$fileurl.'" target="_blank" title="'.get_string ( 'download_file', 'iassign' ).$filename.'">'.$filename.'</a></span>';
        if($fileurl != "")
        	$html_div .= '&nbsp;&nbsp;&nbsp;';
        $html_div .= '<input onclick="view_ilm_manager()" name="add_ilm" value="'.get_string('add_ilm', 'iassign').'" type="button" id="id_add_ilm"/>';
        $html_div .= '</div>';
        $html_div .= '</div>';
        $mform->addElement('html', $html_div);
        
        $mform->setType('file', PARAM_INT);
        $mform->addElement('hidden', 'filename');

        //Applies only iLM iGeom
        if(in_array($iassign_ilmid, $idigeom) || $iassign_ilmid == 0) {
        	$mform->addElement('selectyesno', 'special_param1', get_string('special_param', 'iassign')); //$ynoptions
        	$mform->setDefault('special_param1', 0);
        	$mform->addHelpButton('special_param1', 'helpspecial_param', 'iassign');
        } else {
        	$mform->addElement('hidden', 'special_param1');
        	$mform->setType('special_param1', PARAM_TEXT);
        	$mform->setDefault('special_param1', 0);
        }

        ///-----------------------------------------------------------------------------
        //Applies only when the iLM is automatic evaluate.
        if($iassign_ilm->evaluate == 1) {
	        $mform->addElement('header', 'id_automatic_evaluate', get_string('only_automatic_evaluate', 'iassign'));
	
	        // Using automatic evaluation activity? 0 - no / 1 – yes
	        $mform->addElement('selectyesno', 'automatic_evaluate', get_string('automatic_evaluate', 'iassign'));
	        $mform->disabledIf('automatic_evaluate', 'type_iassign', 'eq', 1); //activity does not display if the type example
	        $mform->setDefault('automatic_evaluate', 1);
	
	        //Show automatic evaluation results to students? 0 - no / 1 - yes
	        $mform->addElement('selectyesno', 'show_answer', get_string('show_answer', 'iassign'));
	        $mform->disabledIf('show_answer', 'type_iassign', 'eq', 1); //activity does not display if the type example
	        $mform->disabledIf('show_answer', 'automatic_evaluate', 'eq', 0);
	        $mform->setDefault('show_answer', 1);
        } else {
        	$mform->addElement('hidden', 'automatic_evaluate');
        	$mform->setType('automatic_evaluate', PARAM_TEXT);
        	$mform->setDefault('automatic_evaluate', 0);
        	
        	$mform->addElement('hidden', 'show_answer');
        	$mform->setType('show_answer', PARAM_TEXT);
        	$mform->setDefault('show_answer', 0);
        }

        ///-----------------------------------------------------------------------------
        /// Adding the "duration_activity" fieldset, where all the common settings are showed
        $mform->addElement('header', 'duration_activity', get_string('duration_activity', 'iassign'));

        $mform->addElement('date_time_selector', 'timeavailable', get_string('availabledate', 'iassign'));
        $mform->setDefault('timeavailable', time());
        $mform->disabledIf('timeavailable', 'type_iassign', 'eq', 1); ///activity does not display if the type example
        $mform->addElement('date_time_selector', 'timedue', get_string('duedate', 'iassign'));
        $mform->setDefault('timedue', time() + 7 * 24 * 3600);
        $mform->disabledIf('timedue', 'type_iassign', 'eq', 1); //activity does not display if the type example
        //
    	//Allow sending late? 0 - no or unlocked / 1 - yes or locked
        $mform->addElement('selectyesno', 'preventlate', get_string('preventlate', 'iassign'));
        $mform->setDefault('preventlate', 0);
        $mform->addHelpButton('preventlate', 'helppreventlate', 'iassign');

        $mform->disabledIf('preventlate', 'type_iassign', 'eq', 1); //activity does not display if the type example
        $mform->disabledIf('preventlate', 'type_iassign', 'eq', 2); //activity does not display if the type test
        
        //Allow test after delivery? 0 - no or unlocked / 1 - yes or locked
        $mform->addElement('selectyesno', 'test', get_string('permission_test', 'iassign'));
        $mform->setDefault('test', 0);
        $mform->addHelpButton('test', 'helptest', 'iassign');

        $mform->disabledIf('test', 'type_iassign', 'eq', 1); //activity does not display if the type example
        $mform->disabledIf('test', 'type_iassign', 'eq', 2); //activity does not display if the type test
        ///--------------
        $mform->addElement('header', 'op_val', get_string('op_val', 'iassign'));

        $mform->addElement('modgrade', 'grade', get_string('grade', 'iassign'));
        $mform->setDefault('grade', 100);
        $mform->disabledIf('grade', 'type_iassign', 'eq', 1); //activity does not display if the type example
        $mform->disabledIf('grade', 'type_iassign', 'eq', 2); //activity does not display if the type test

        $max_experiment_options = array(0 => get_string('ilimit', 'iassign'));
        for ($i = 1; $i <= 20; $i++)
            $max_experiment_options[$i] = $i;

        $mform->addElement('select', 'max_experiment', get_string('experiment', 'iassign'), $max_experiment_options);
        $mform->setDefault('max_experiment', 0);
        $mform->addHelpButton('max_experiment', 'helpexperiment', 'iassign');
        $mform->disabledIf('max_experiment', 'type_iassign', 'eq', 1); //activity does not display if the type example
        $mform->disabledIf('max_experiment', 'type_iassign', 'eq', 2); //activity does not display if the type test

        if ($COURSE->iassign_list) {
            ///-------------- dependency
            $mform->addElement('header', 'headerdependency', get_string('dependency', 'iassign'));
            $mform->addHelpButton('headerdependency', 'helpdependency', 'iassign');

            foreach ($COURSE->iassign_list as $iassign) {
                $tmp = 'iassign_list[' . $iassign->id . ']';
                if ($iassign->enable == 1)
                    $mform->addElement('checkbox', $tmp, $iassign->name);
            } //foreach ($COURSE->iassign_list as $iassign)
        } //if ($COURSE->iassign_list)

        $mform->addElement('hidden', 'dependency');
        $mform->setType('dependency', PARAM_RAW);

        ///-------------- params
        if($iassign_ilmid == 0)
        	$iassign_ilmid = $idigeom[0];
        $iassign_ilm_configs = $DB->get_records ( 'iassign_ilm_config', array ('iassign_ilmid' => $iassign_ilmid, 'visible' => '1' ) );
        if($iassign_ilm_configs) {
        	$mform->addElement('header', 'params', get_string('param_header', 'iassign').$OUTPUT->help_icon('param_header', 'iassign'));
        	foreach ($iassign_ilm_configs as $iassign_ilm_config) {
        		
        		$url_help = new moodle_url ( '/mod/iassign/settings_params.php', array ('action' => 'help','ilm_param_id' => $iassign_ilm_config->id ) );
        		$action_help = new popup_action ( 'click', $url_help, 'iplookup', array ('title' => $iassign_ilm_config->param_name,'width' => 300,'height' => 300 ) );
        		$image_help = "<img src='".$OUTPUT->pix_url('help')."' alt='".$iassign_ilm_config->param_name."' title='".$iassign_ilm_config->param_name."' />";
        		$link_help = '<span class="helplink">'.$OUTPUT->action_link ( $url_help, $image_help , $action_help ).'</span>';
        		
        	    if($iassign_ilm_config->param_type == 'static') {
        			$mform->addElement('static', 'param_'.$iassign_ilm_config->id, $iassign_ilm_config->param_name.$link_help);
        			$mform->setDefault('param_'.$iassign_ilm_config->id, $iassign_ilm_config->param_value);
        		} else if($iassign_ilm_config->param_type == 'value') {
        			$mform->addElement('text', 'param_'.$iassign_ilm_config->id, $iassign_ilm_config->param_name.$link_help);
        			$mform->setDefault('param_'.$iassign_ilm_config->id, $iassign_ilm_config->param_value);
        		} else if($iassign_ilm_config->param_type == 'boolean') {
        			$mform->addElement('selectyesno', 'param_'.$iassign_ilm_config->id, $iassign_ilm_config->param_name.$link_help);
        			$mform->setDefault('param_'.$iassign_ilm_config->id, $iassign_ilm_config->param_value);
        		} else if($iassign_ilm_config->param_type == 'choice') {
        			$choices = explode(", ", $iassign_ilm_config->param_value);
        			$choices = array_combine($choices, $choices);
        			$mform->addElement('select', 'param_'.$iassign_ilm_config->id, $iassign_ilm_config->param_name.$link_help, $choices);
        		} else if($iassign_ilm_config->param_type == 'multiple') {
        			$choices = explode(", ", $iassign_ilm_config->param_value);
        			$choices = array_combine($choices, $choices);
        			$select = $mform->addElement('select', 'param_'.$iassign_ilm_config->id, $iassign_ilm_config->param_name.$link_help, $choices, true);
        			$select->setMultiple(true);
        		}
        	}
        }
        	
        ///-------------- config
       	$mform->addElement('header', 'config', get_string('general', 'iassign'));
       	$visibleoptions = array(1 => get_string('show'), 0 => get_string('hide'));

       	$mform->addElement('select', 'visible', get_string('visible', 'iassign'), $visibleoptions);
       	$mform->setDefault('visible', 0);

        //-------------------------------------------------------------------------------
        // Hidden fields
        $mform->addElement('hidden', 'action');
        $mform->setType('action', PARAM_TEXT);
        $mform->addElement('hidden', 'oldname');
        $mform->setType('oldname', PARAM_TEXT);
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_TEXT);
        $mform->addElement('hidden', 'iassign_id');
        $mform->setType('iassign_id', PARAM_TEXT);
        $mform->addElement('hidden', 'file', '0');
        $mform->setType('filename', PARAM_TEXT);
        $mform->addElement('hidden', 'fileold');
        $mform->setType('fileold', PARAM_TEXT);
        $mform->addElement('hidden', 'iassignid');
        $mform->setType('iassignid', PARAM_TEXT);
        $mform->addElement('hidden', 'author_name');
        $mform->setType('author_name', PARAM_TEXT);
        $mform->addElement('hidden', 'author_modified_name');
        $mform->setType('author_modified_name', PARAM_TEXT);
        $mform->addElement('hidden', 'timecreated');
        $mform->setType('timecreated', PARAM_TEXT);
        $mform->addElement('hidden', 'position');
        $mform->setType('position', PARAM_TEXT);
        
        $mform->addElement('html', $code_javascript);
        
        $mform->disable_form_change_checker();
        
        // add standard elements, common to all modules
        $this->add_action_buttons(true, get_string('write_form', 'iassign'));
    }
    
    function validation($data, $files) {
    	global $COURSE, $DB;
    	$errors = parent::validation($data, $files);
    	
    	//print_r($data);
    
    	$mform =& $this->_form;
    
    	$errors = array();
    
    	if ($mform->elementExists('name')) {
    		$value = trim($data['name']);
    		if ($value == '') {
    			$errors['name'] = get_string('required', 'iassign');
    		}
    	}
    	
    	if ($mform->elementExists('name')) {
    		$iassign_statements = $DB->get_records ( "iassign_statement", array('iassignid' => $COURSE->iassignid)); 
    		$action = trim($data['action']);
			$name = trim($data['name']);
			$oldname = trim($data['oldname']);
    		if ($iassign_statements) {
    			foreach ($iassign_statements as $iassign_statement) {
    				if($action == 'add') {
    					if($iassign_statement->name == $name)
    						$errors['name'] = get_string('error_iassign_name', 'iassign');
    				} else if($action == 'edit') {
    					if($iassign_statement->name == $name && $name != $oldname)
    						$errors['name'] = get_string('error_iassign_name', 'iassign');
    				}
    			}
    		}
    	}
    	
    	if ($mform->elementExists('proposition')) {
    		$value = trim($data['proposition']);
    		if ($value == '') {
    			$errors['proposition'] = get_string('required', 'iassign');
    		}
    	}
    	
    	if ($mform->elementExists('file')) {
    		$value = trim($data['file']);
    		if ($value == 0) {
    			$errors['iassign_ilmid'] = get_string('required_iassign_file', 'iassign');
    		}
    	}
    	
    	return $errors;
    }
    
}

?>
