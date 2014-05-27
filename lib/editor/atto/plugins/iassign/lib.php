<?php
/**
 * Atto text editor iAssign plugin lib.
 *
 * @package    atto_iassign
 * @copyright  2014
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Function for send strings for JS. 
 */
function atto_iassign_strings_for_js() {
	global $PAGE;
	
}
/**
 * Function for send params for JS.
 * @param unknown $elementid
 * @param unknown $options
 * @param unknown $fpoptions
 * @return multitype:string NULL 
 */
function atto_iassign_params_for_js($elementid, $options, $fpoptions) {
	global $CFG, $COURSE;
	
	$params = array('iassign_wwwroot' => $CFG->wwwroot."/mod/iassign/ilm_manager.php", 'iassign_course' => $COURSE->id);
	
	return $params;
}
?>