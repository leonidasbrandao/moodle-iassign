<?php
/**
 * Defines the editing form for the iassign question type.
 *
 * @package    qtype
 * @subpackage iassign
 * @copyright iMatica (<a href="http://www.matematica.br">iMath</a>) - Computer Science Dep. of IME-USP (Brazil)
 * 
 * <b>License</b> 
 *  - http://opensource.org/licenses/gpl-license.php GNU Public License
 *  
 *  <br><br><a href="../index.html"><b>Return to iAssign Documentation</b></a>
 */


defined('MOODLE_INTERNAL') || die();

require_once ($CFG->dirroot . '/mod/iassign/lib.php');


/**
 * iassign question editing form definition.
 */
class qtype_iassign_edit_form extends question_edit_form {

	protected function definition_inner($mform) {
		global $CFG, $COURSE;
		
		$mform->addElement('header', 'interactivy_learning_module', get_string('interactivy_learning_module', 'iassign'));
		//$mform->setExpanded('interactivy_learning_module');
		
		$code_javascript = "
		<script type='text/javascript'>
		//<![CDATA[
		
			document.forms['mform1'].filename.disabled=1;
			
			function view_ilm_manager(){
				document.forms['mform1'].filename.disabled=1;
				open_ilm_manager=window.open('$CFG->wwwroot/mod/iassign/ilm_manager.php?id=$COURSE->id&from=qtype&ilmid='+document.forms['mform1'].ilmid.value,'','width=1000,height=880,menubar=0,location=0,scrollbars,status,fullscreen,resizable');
			}
			
		//]]>
		</script>";

		// Search imas registered in the database
		$ilms = search_iLM(1);
		
		$applets = array();
		foreach ($ilms as $ilm)
			$applets[$ilm->id] = $ilm->name.' '.$ilm->version;
		$mform->addElement('select', 'ilmid', get_string('choose_iLM', 'iassign'), $applets);
		$mform->addHelpButton('ilmid', 'helpchoose_ilm', 'iassign');
		
		$fileurl = "";
		$filename = "";
		$fileid = 0;
		if(property_exists($COURSE, 'question_iassign_file')) {
			$fileid = $COURSE->question_iassign_file;
			$fs = get_file_storage();
			$file = $fs->get_file_by_id( $COURSE->question_iassign_file );
			$fileurl = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), $file->get_itemid(), $file->get_filepath(), $file->get_filename());
			//$fileurl = "{$CFG->wwwroot}/pluginfile.php/{$file->get_contextid()}/question_iassign/activity" . '/' . $file->get_itemid () . $file->get_filepath () . $file->get_filename ();
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
		
		$mform->addElement('html', $code_javascript);
		
		$mform->addElement('hidden', 'file', $fileid);
		$mform->setType('file', PARAM_INT);
		$mform->addElement('hidden', 'filename', $filename);
		$mform->setType('filename', PARAM_TEXT);
		
		$this->add_interactive_settings();
	}
	protected function data_preprocessing($question) {
		$question = parent::data_preprocessing($question);
		$question = $this->data_preprocessing_hints($question);
		return $question;
	}
	public function validation($data, $files) {
		$errors = parent::validation($data, $files);
		 
		$mform =& $this->_form;
		
		if ($mform->elementExists('file')) {
			$value = trim($data['file']);
			if ($value == 0) {
				$errors['ilmid'] = get_string('required_iassign_file', 'iassign');
			}
		}
		
		return $errors;
	}
	public function qtype() {
		return 'iassign';
	}
}
