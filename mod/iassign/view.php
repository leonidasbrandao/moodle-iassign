<?php
/** 
 * This php script contains all the stuff to display iAssign.
 * 
 * @author Patricia Alves Rodrigues
 * @author Leônidas O. Brandão
 * @version v 1.0 2012/10/16
 * @package mod_iassign
 * @since 2010/09/27
 * @copyright iMatica (<a href="http://www.matematica.br">iMath</a>) - Computer Science Dep. of IME-USP (Brazil)
 * 
 * <b>License</b> 
 *  - http://opensource.org/licenses/gpl-license.php GNU Public License
 */
require_once("../../config.php");
require_once("lib.php");
require_once($CFG->libdir . '/completionlib.php');
require_once($CFG->libdir . '/plagiarismlib.php');

//Parameters GET e POST (parâmetros GET e POST)
$id = optional_param('id', 0, PARAM_INT); // Course Module ID
$a = optional_param('a', 0, PARAM_INT); //  iassign id

$url = new moodle_url('/mod/iassign/view.php'); // novo


if ($id) {
    if (!$cm = get_coursemodule_from_id('iassign', $id)) {
        print_error('invalidcoursemodule');
    }

    if (!$iassign = $DB->get_record("iassign", array("id" => $cm->instance))) {
        print_error('invalidid', 'iassign');
    }

    if (!$course = $DB->get_record("course", array("id" => $iassign->course))) {
        print_error('coursemisconf', 'iassign');
    }
    $url->param('id', $id);
} else {
    if (!$iassign = $DB->get_record("iassign", array("id" => $a))) {
        print_error('invalidid', 'iassign');
    }
    if (!$course = $DB->get_record("course", array("id" => $iassign->course))) {
        print_error('coursemisconf', 'iassign');
    }
    if (!$cm = get_coursemodule_from_instance("iassign", $iassign->id, $course->id)) {
        print_error('invalidcoursemodule');
    }
    $url->param('a', $a);
}

$PAGE->set_url($url);

// tracking
// author: Tulio Faria (tuliofaria@usp.br)
if(isset($_GET["track"])){

    $record = new stdClass();
    $record->course = $course->id;
    $record->user = $USER->id;
    $record->cmid = $cm->id;

    $record->created = date('Y-m-d H:i:s');

    $record->tracking_data = $_POST["trackingData"];
    
    $DB->insert_record('iassign_tracking', $record, false);

    exit;
}



require_login($course, true, $cm);

$PAGE->set_title(format_string($iassign->name));
$PAGE->set_heading($course->fullname);

// Mark viewed by user (if required)
$completion = new completion_info($course);
$completion->set_module_viewed($cm);

$iassigninstance = new iassign($iassign, $cm, $course);
$iassigninstance->view();   // Actually display the iassign!
?>
