<?php
/** 
 * Settings iLM manager.
 * 
 * Release Notes:
 * - v 1.7 2014/01/23
 * 		+ Insert function for move activities for other iLM.
 * - v 1.6 2013/10/31
 * 		+ Insert support of import iLM from zip packages.
 * - v 1.5 2013/10/24
 * 		+ Insert function for upgrade an iLM.
 * - v 1.4 2013/08/02
 * 		+ Insert list of iLMs informations for teacher view.
 * - v 1.3 2013/07/12
 * 		+ Insert actions: copy (new version from an iLM) and new version (empty new version).
 * 
 * @author Patricia Alves Rodrigues
 * @author Leônidas O. Brandão
 * @author Luciano Oliveira Borges
 * @version v 1.7 2014/01/23
 * @package mod_iassign_settings
 * @since 2013/01/29
 * @copyright iMatica (<a href="http://www.matematica.br">iMath</a>) - Computer Science Dep. of IME-USP (Brazil)
 * 
 * <b>License</b> 
 *  - http://opensource.org/licenses/gpl-license.php GNU Public License
 */

global $CFG, $USER, $PAGE, $OUTPUT, $DB;

require_once("../../config.php");
require_once ($CFG->dirroot . '/mod/iassign/locallib.php');
require_once ($CFG->dirroot . '/mod/iassign/settings_form.php');


require_login();
 if (isguestuser()) {
     die();
 }
//Parameters GET e POST (parâmetros GET e POST)
$ilm_id = optional_param('ilm_id', 0, PARAM_INT);
$ilm_parent = optional_param('ilm_parent', 0, PARAM_INT);
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
    $title = get_string('edit_ilm', 'iassign').$OUTPUT->help_icon ( 'add_ilm_iassign', 'iassign' );
    $PAGE->set_title($title);
    $param = ilm_settings::add_edit_copy_ilm($ilm_id, $action);
	
    $mform = new mod_ilm_form();
    $mform->set_data($param);
    if ($mform->is_cancelled()) {
        close_window();
        die;
    } else if ($formdata = $mform->get_submitted_data()) {
        ilm_settings::edit_ilm($formdata);
        close_window(0, true);
        die;
    }

    echo $OUTPUT->header();
    echo $OUTPUT->heading($title);
    $mform->display();
    echo $OUTPUT->footer();
    die;
}

if ($action == 'new_version') {
	$title = get_string('new_version_ilm', 'iassign').$OUTPUT->help_icon ( 'add_ilm_iassign', 'iassign' );
	$PAGE->set_title($title);
	$param = ilm_settings::add_edit_copy_ilm($ilm_id, $action);

	$mform = new mod_ilm_form();
	$mform->set_data($param);
	if ($mform->is_cancelled()) {
		close_window();
		die;
	} else if ($formdata = $mform->get_data()) {

		ilm_settings::copy_new_version_ilm($formdata);
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
	$title = get_string('copy_ilm', 'iassign').$OUTPUT->help_icon ( 'add_ilm_iassign', 'iassign' );
	$PAGE->set_title($title);
	$param = ilm_settings::add_edit_copy_ilm($ilm_id, $action);

	$mform = new mod_ilm_form();
	$mform->set_data($param);
	if ($mform->is_cancelled()) {
		close_window();
		die;
	} else if ($formdata = $mform->get_data()) {

		ilm_settings::copy_new_version_ilm($formdata);
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
    $title = get_string('add_ilm_iassign', 'iassign').$OUTPUT->help_icon ( 'add_ilm_iassign', 'iassign' );
    $PAGE->set_title($title);
    $param = ilm_settings::add_edit_copy_ilm($ilm_id, $action);

    $mform = new mod_ilm_form();
    $mform->set_data($param);
    if ($mform->is_cancelled()) {
        close_window();
        die;
    } else if ($formdata = $mform->get_data()) {
        ilm_settings::new_ilm($formdata);
        close_window(0, true);
        die;
    }
    echo $OUTPUT->header();
    echo $OUTPUT->heading($title);
    $mform->display();
    echo $OUTPUT->footer();
    die;
}

if ($action == 'import') {
	$title = get_string('import_ilm', 'iassign').$OUTPUT->help_icon ( 'import_ilm', 'iassign' );
	$PAGE->set_title($title);
	$param = new object ();
	$param->action = $action;
	$CFG->action_ilm = $action;

	$mform = new mod_ilm_form();
	$mform->set_data($param);
	if ($mform->is_cancelled()) {
		close_window();
		die;
	} else if ($formdata = $mform->get_data()) {
		$extension = explode(".", $mform->get_new_filename('file'));
		if($extension[count($extension)-1] == 'ipz'){
			ilm_settings::import_ilm($formdata->file);
			close_window(5, true);
			die;
		} else
			echo($OUTPUT->notification(get_string ( 'error_upload_ilm', 'iassign' ), 'notifyproblem'));
	}
	echo $OUTPUT->header();
	echo $OUTPUT->heading($title);
	$mform->display();
	echo $OUTPUT->footer();
	die;
}

if ($action == 'confirm_delete_ilm') {
 	$title = get_string('delete_ilm', 'iassign');
 	$PAGE->set_title($title);
 	$PAGE->set_pagelayout('base');
 	$delete_ilm = ilm_settings::confirm_delete_ilm($ilm_id, $ilm_parent);
 	echo $OUTPUT->header();
 	echo $OUTPUT->heading($title);
 	echo $delete_ilm;
 	echo $OUTPUT->footer();
	die;
}

if ($action == 'delete') {
	$title = get_string('delete_ilm', 'iassign');
	$PAGE->set_title($title);
	$PAGE->set_pagelayout('redirect');
	$parent = ilm_settings::delete_ilm ($ilm_id);
	if($parent == 0)
		redirect(new moodle_url('/admin/settings.php?', array ('section' => 'modsettingiassign','action' => 'view')));
	else
		redirect(new moodle_url('/admin/settings.php?', array ('section' => 'modsettingiassign','action' => 'config','ilm_id' => $ilm_parent)));
}

if ($action == 'confirm_default_ilm') {
	$title = get_string('confirm_default', 'iassign');
	$PAGE->set_title($title);
	$PAGE->set_pagelayout('base');
	$default_ilm = ilm_settings::confirm_default_ilm($ilm_id, $ilm_parent);
	
	echo $OUTPUT->header();
	echo $default_ilm;
	echo $OUTPUT->footer();
	die;
}

if ($action == 'default') {
	$title = get_string('default_ilm', 'iassign');
	$PAGE->set_title($title);
	$PAGE->set_pagelayout('redirect');
	ilm_settings::default_ilm ($ilm_id);
	redirect(new moodle_url('/admin/settings.php?', array ('section' => 'modsettingiassign','action' => 'config','ilm_id' => $ilm_parent)));
}

if ($action == 'list') {
	$title = get_string('list_ilm', 'iassign');
	$PAGE->set_title($title);
	$list_ilm = ilm_settings::list_ilm();
	echo $OUTPUT->header();
	echo $OUTPUT->heading($title.$OUTPUT->help_icon ( 'list_ilm', 'iassign' ));
	echo $list_ilm;
	echo $OUTPUT->footer();
	die;
}

if ($action == 'upgrade') {
	$title = get_string('upgrade_ilm_title', 'iassign');
	$PAGE->set_title($title);
	$PAGE->set_pagelayout('redirect');

	$ilm = ilm_settings::upgrade_ilm ($ilm_id);
	if($ilm == 0)
		redirect(new moodle_url('/admin/settings.php?', array ('section' => 'modsettingiassign','action' => 'view')));
	else
		redirect(new moodle_url('/admin/settings.php?', array ('section' => 'modsettingiassign','action' => 'config', 'ilm_id' => $ilm)));
}

if ($action == 'confirm_move_iassign') {
	$title = get_string('move_iassign', 'iassign');
	$PAGE->set_title($title);
	$PAGE->set_pagelayout('admin');

	$confirm_move_iassign = ilm_settings::confirm_move_iassign($ilm_id, $ilm_parent);
	
	echo $OUTPUT->header();
	echo $confirm_move_iassign;
	echo $OUTPUT->footer();
	die;
}

if ($action == 'move_iassign') {
	$title = get_string('move_iassign', 'iassign');
	$PAGE->set_title($title);
	$PAGE->set_pagelayout('redirect');
	ilm_settings::move_iassign ($ilm_id);
	redirect(new moodle_url('/admin/settings.php?', array ('section' => 'modsettingiassign','action' => 'config','ilm_id' => $ilm_parent)));
}


if ($action == 'view') {
	$iassign_ilm = $DB->get_record ( 'iassign_ilm', array ('id' => $ilm_id ) );
    $title = get_string('view_ilm', 'iassign').$OUTPUT->help_icon ( 'add_ilm_iassign', 'iassign' );
    $PAGE->set_title($title.': '.$iassign_ilm->name.' '.$iassign_ilm->version);
    $view_ilm = ilm_settings::view_ilm($ilm_id, $from);
    echo $OUTPUT->header();
    echo $OUTPUT->heading($title.': '.$iassign_ilm->name.' '.$iassign_ilm->version);
    echo $view_ilm;
    echo $OUTPUT->footer();
    die;
}
?>