<?php
/**
 * iAssign question type files
 *
 * @package    qtype_iassign
 * @copyright iMatica (<a href="http://www.matematica.br">iMath</a>) - Computer Science Dep. of IME-USP (Brazil)
 * 
 * <b>License</b> 
 *  - http://opensource.org/licenses/gpl-license.php GNU Public License
 */


defined('MOODLE_INTERNAL') || die();


/**
 * Checks file access for iassign questions.
 * @package  qtype_iassign
 * @category files
 * @param stdClass $course course object
 * @param stdClass $cm course module object
 * @param stdClass $context context object
 * @param string $filearea file area
 * @param array $args extra arguments
 * @param bool $forcedownload whether or not force download
 * @param array $options additional options affecting the file serving
 * @return bool
 */
function qtype_iassign_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    global $CFG, $DB;

    require_course_login($course, true, $cm);
    
    $fileareas = array('activity');
    if (!in_array($filearea, $fileareas)) {
        return false;
    }
    $fs = get_file_storage();
    $postid = (int) array_shift($args);
    $relativepath = implode('/', $args);
    $fullpath = "/$context->id/qtype_iassign/$filearea/$postid/$relativepath";

    if (!$file = $fs->get_file_by_hash(sha1($fullpath)) or $file->is_directory()) {
        return false;
    }
    send_stored_file($file, 0, 0, true);

    return false;
}
