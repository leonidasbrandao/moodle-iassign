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


/**
 * iassign question editing form definition.
 */
class qtype_iassign_edit_form extends question_edit_form {

    protected function definition_inner($mform) {
        $this->add_interactive_settings();
    }

    protected function data_preprocessing($question) {
        $question = parent::data_preprocessing($question);
        $question = $this->data_preprocessing_hints($question);

        return $question;
    }

    public function qtype() {
        return 'iassign';
    }
}
