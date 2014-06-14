<?php
/**
 * Question type class for the iassign question type.
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

require_once($CFG->libdir . '/questionlib.php');
require_once($CFG->dirroot . '/question/engine/lib.php');
require_once($CFG->dirroot . '/question/type/iassign/question.php');


/**
 * The iassign question type.
 */
class qtype_iassign extends question_type {
	
	public function get_question_options($question) {
		global $COURSE, $DB;
		
		$question_iassign = $DB->get_record('question_iassign', array('question' => $question->id));
		if($question_iassign)
				$COURSE->question_iassign_file = $question_iassign->file;
		
		return true;
	}

  public function move_files($questionid, $oldcontextid, $newcontextid) {
    parent::move_files($questionid, $oldcontextid, $newcontextid);
    $this->move_files_in_hints($questionid, $oldcontextid, $newcontextid);
	}

  protected function delete_files($questionid, $contextid) {
    parent::delete_files($questionid, $contextid);
    $this->delete_files_in_hints($questionid, $contextid);
  }

	public function save_question_options($question) {
		global $DB, $COURSE, $USER;
    	
    $fs = get_file_storage ();
    $context = context_course::instance($COURSE->id);
    $file = $fs->get_file_by_id($question->file);
    	
    $storedfile = array(
    		'userid' => $USER->id,
    		'contextid' => $context->id,
    		'component' => 'qtype_iassign',
    		'filearea' => 'activity',
    		'itemid' => 0,
    		'filepath' => '/',
    		'filename' => $file->get_filename());
    	
    if($question_iassign = $DB->get_record('question_iassign', array('question' => $question->id))) {
    	$question_iassign_file = $fs->get_file_by_id($question_iassign->file);
    	if($question_iassign_file)
    		$question_iassign_file->delete();
    	$newfile = @$fs->create_file_from_string($storedfile, $file->get_content());
    	$question_iassign->ilmid  = $question->ilmid;
    	$question_iassign->file = $newfile->get_id();
    	$DB->update_record('question_iassign', $question_iassign);
    } else {
    	$newfile = @$fs->create_file_from_string($storedfile, $file->get_content());
    	$question_iassign = new stdClass();
    	$question_iassign->question    = $question->id;
    	$question_iassign->ilmid  = $question->ilmid;
    	$question_iassign->file = $newfile->get_id();
    	$DB->insert_record('question_iassign', $question_iassign);
    }
    	
    $this->save_hints($question);
	}
    
  public function delete_question($questionid, $contextid) {
  	global $DB;
    	
    $fs = get_file_storage ();
    $question_iassign = $DB->get_record('question_iassign', array('question' => $questionid));
    $question_iassign_file = $fs->get_file_by_id($question_iassign->file);
    if($question_iassign_file)
    	$question_iassign_file->delete();

    $DB->delete_records('question_iassign', array('question' => $questionid));
    
    parent::delete_question($questionid, $contextid);
  }

  protected function initialise_question_instance(question_definition $question, $questiondata) {
   	parent::initialise_question_instance($question, $questiondata);
  }

  public function get_random_guess_score($questiondata) {
  	return 0.5;
  }

  public function get_possible_responses($questiondata) {
  	return array();
  }
}
?>