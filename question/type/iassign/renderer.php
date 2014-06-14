<?php
/**
 * iassign question renderer class.
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


/**
 * Generates the output for iassign questions.
 */
class qtype_iassign_renderer extends qtype_renderer {
	public function formulation_and_controls(question_attempt $qa, question_display_options $options) {
		global $CFG, $DB;
    require_once ($CFG->dirroot . '/mod/iassign/locallib.php');
    $fs = get_file_storage();
    	
    $question = $qa->get_question();
    $questiontext = $question->format_questiontext($qa);
        
    $question_iassign = $DB->get_record('question_iassign', array('question' => $question->id));
    
    $view = 1;
    $ilm = new ilm($question_iassign->ilmid);
    $id_iLM_security = $ilm->write_iLM_security($question->id, addslashes($question_iassign->file));
    $iassign_iLM_security = $DB->get_record("iassign_security", array ("id" => $id_iLM_security));
    $token = md5($iassign_iLM_security->timecreated);
    $end_file = $CFG->wwwroot . '/mod/iassign/ilm_security.php?id=' . $id_iLM_security . '&token=' . $token . '&view=' . $view;
    
    $options = array("type" => "qtype", "notSEND" => "false", "Proposition" => $end_file);
    $questiontext .= ilm_settings::applet_ilm($question_iassign->ilmid, $options);;

    $result = html_writer::tag('div', $questiontext, array('class' => 'qtext'));

    return $result;
	}

	public function specific_feedback(question_attempt $qa) {
  
		return '';
	}

	public function correct_response(question_attempt $qa) {
		return '';
	}
}
