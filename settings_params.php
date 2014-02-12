<?php
/** 
 * Settings iLM params manager.
 * 
 * Release Notes:
 * - v 1.1 2014/01/24
 * 		+ Insert help view in params.
 * 
 * @author Patricia Alves Rodrigues
 * @author Leônidas O. Brandão
 * @author Luciano Oliveira Borges
 * @version v 1.1 2014/01/24
 * @package mod_iassign_settings
 * @since 2013/09/11
 * @copyright iMatica (<a href="http://www.matematica.br">iMath</a>) - Computer Science Dep. of IME-USP (Brazil)
 * 
 * <b>License</b> 
 *  - http://opensource.org/licenses/gpl-license.php GNU Public License
 */

global $CFG, $USER, $PAGE, $OUTPUT, $DB;

require_once("../../config.php");
require_once ($CFG->dirroot . '/mod/iassign/locallib.php');
require_once ($CFG->dirroot . '/mod/iassign/params_form.php');


require_login();
 if (isguestuser()) {
     die();
 }
//Parameters GET e POST (parâmetros GET e POST)
$ilm_param_id = optional_param('ilm_param_id', 0, PARAM_INT);
$ilm_id = optional_param('ilm_id', 0, PARAM_INT);
$status = optional_param('status', 0, PARAM_INT);
$action = optional_param('action', NULL, PARAM_TEXT);
$url = new moodle_url('/admin/settings.php', array('section' => 'modsettingiassign'));
$from = optional_param('from', NULL, PARAM_TEXT);

$contextuser = context_user::instance($USER->id);

$PAGE->set_url($url);
$PAGE->set_context($contextuser);
$PAGE->blocks->show_only_fake_blocks(); //
$PAGE->set_pagelayout('popup');

if ($action == 'edit') {
    $title = get_string('edit_param', 'iassign').$OUTPUT->help_icon ( 'config_param', 'iassign' );
    $PAGE->set_title($title);
    $param = ilm_settings::add_edit_copy_param($ilm_param_id, $action);
	
    $mform = new param_ilm_form();
    $mform->set_data($param);
    if ($mform->is_cancelled()) {
        close_window();
        die;
    } else if ($formdata = $mform->get_submitted_data()) {
        ilm_settings::edit_param($formdata);
        close_window(0, true);
        die;
    }

    echo $OUTPUT->header();
    echo $OUTPUT->heading($title);
    $mform->display();
    echo $OUTPUT->footer();
    die;
}

if ($action == 'copy') {
	$title = get_string('copy_param', 'iassign').$OUTPUT->help_icon ( 'config_param', 'iassign' );
	$PAGE->set_title($title);
	$param = ilm_settings::add_edit_copy_param($ilm_param_id, $action);

	$mform = new param_ilm_form();
	$mform->set_data($param);
	if ($mform->is_cancelled()) {
		close_window();
		die;
	} else if ($formdata = $mform->get_data()) {

		ilm_settings::copy_param($formdata);
		close_window(0, true);
		die;
	}

	echo $OUTPUT->header();
	echo $OUTPUT->heading($title);
	$mform->display();
	echo $OUTPUT->footer();
	die;
}

if ($action == 'add') {
    $title = get_string('add_param', 'iassign').$OUTPUT->help_icon ( 'config_param', 'iassign' );
    $PAGE->set_title($title);
    $param = ilm_settings::add_edit_copy_param($ilm_id, $action);

    $mform = new param_ilm_form();
    $mform->set_data($param);
    if ($mform->is_cancelled()) {
        close_window();
        die;
    } else if ($formdata = $mform->get_data()) {
        ilm_settings::add_param($formdata);
        close_window(0, true);
        die;
    }
    echo $OUTPUT->header();
    echo $OUTPUT->heading($title);
    $mform->display();
    echo $OUTPUT->footer();
    die;
}

if ($action == 'delete') {
	$title = get_string('delete_param', 'iassign');
	$PAGE->set_title($title);
	$PAGE->set_pagelayout('redirect');
	ilm_settings::delete_param ($ilm_param_id);
	redirect(new moodle_url('/admin/settings.php?', array ('section' => 'modsettingiassign','action' => 'config','ilm_id' => $ilm_id)));
}

if ($action == 'help') {
	
	$PAGE->set_url('/help.php');
	$PAGE->set_pagelayout('popup');
	
	echo $OUTPUT->header();
	
	$options = new stdClass();
	$options->trusted = false;
	$options->noclean = false;
	$options->smiley = false;
	$options->filter = false;
	$options->para = true;
	$options->newlines = false;
	$options->overflowdiv = 1;
	
	$iassign_ilm_config = $DB->get_record ( 'iassign_ilm_config', array ('id' => $ilm_param_id ) );
	
	echo $OUTPUT->heading(format_string( $iassign_ilm_config->param_name), 1, 'helpheading');
	// Should be simple wiki only MDL-21695
	echo format_text($iassign_ilm_config->description, FORMAT_MARKDOWN, $options);
	
	if($iassign_ilm_config->param_type == 'value')
		$param_value = $iassign_ilm_config->param_value;
	else if($iassign_ilm_config->param_type == 'boolean')
		$param_value = $iassign_ilm_config->param_value == 1 ? get_string('yes', 'iassign') : get_string('no', 'iassign');
	else if($iassign_ilm_config->param_type == 'choice') {
		$tmp = explode(",", $iassign_ilm_config->param_value);
		$param_value = $tmp[0];
	}
	
	if($iassign_ilm_config->param_type != 'static')
		echo '<font size="-1" color="#cccccc">'.get_string('param_default', 'iassign').$param_value.'</font>';
	else 
		echo '<font size="-1" color="#cccccc">'.get_string('param_default_static', 'iassign').'</font>';
	
	echo $OUTPUT->footer();
}

?>