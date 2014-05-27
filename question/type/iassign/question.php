<?php
/**
 * iassign question definition class.
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
 * Represents a iassign question.
 */
class qtype_iassign_question extends question_graded_automatically_with_countback {

    public function get_expected_data() {
        return array();
    }

    public function summarise_response(array $response) {
        return null;
    }

    public function is_complete_response(array $response) {
        return true;
    }

    public function get_validation_error(array $response) {
        return '';
    }

    public function is_same_response(array $prevresponse, array $newresponse) {
        return question_utils::arrays_same_at_key_missing_is_blank($prevresponse, $newresponse, 'answer');
    }


    public function get_correct_response() {
        return array();
    }


    public function check_file_access($qa, $options, $component, $filearea, $args, $forcedownload) {
    	if ($component == 'qtype_iassign' && $filearea == 'activity') {
      	return $this->check_hint_file_access($qa, $options, $args);

      } else {
      	return parent::check_file_access($qa, $options, $component, $filearea, $args, $forcedownload);
      }
    }

    public function grade_response(array $response) {
        $fraction = 1;
        return array($fraction, question_state::graded_state_for_fraction($fraction));
    }

    public function compute_final_grade($responses, $totaltries) {
        return 0;
    }
}
