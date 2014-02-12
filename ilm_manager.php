<?php
/**
 * iLM manager
 * 
 * Release Notes
 * - v 2.4 2013/10/24
 * 		+ Insert function for recover iassign file in course.
 * - v 2.3 2013/08/26
 * 		+ Fix bug to upload file from block.
 * - v 2.2 2013/08/23
 * 		+ Fix bug to import zip files.
 * - v 2.1 2013/08/22
 * 		+ Merge for import zip files and iassign files.
 * 		+ Insert function for rename iassign file.
 * - v 2.0 2013/08/21
 * 		+ Change title link with message for get file for donwload file.
 * 		+ Manage import files.
 * 		+ Rename files for format accepted.
 * 		+ Change position of close and return buttons.
 * - v 1.9 2013/08/15
 * 		+ Insert functions for import files, export files and remove selected files.
 * - v 1.8 2013/08/02
 * 		+ Insert return button for block view.
 * 		+ Insert close button for iassign view.
 * - v 1.7 2013/07/03
 * 		+ Replace var 'DIRECTORY_SEPARATOR' for '/' (Server on Windows error of section)
 * 		+ Diferent view of block and iassign in files views.
 *		+ Change button of open online editor.
 *		+ View modified and created date in files views.
 * - v 1.3 2013/06/28
 * 		+ Correction function delete and duplicate.
 * 		+ Allow copying the file from another user.
 * - v 1.1 2013/06/26
 * 		+ Filter file extension for permission only compatilbe with iLM and block view all user files.
 * 
 * @author Patricia Alves Rodrigues
 * @author Leônidas O. Brandão
 * @author Luciano Oliveira Borges
 * @version v 2.4 2013/10/24
 * @package mod_iassign_ilm
 * @since 2012/01/10
 * @copyright iMatica (<a href="http://www.matematica.br">iMath</a>) - Computer Science Dep. of IME-USP (Brazil)
 * 
 * <b>License</b> 
 *  - http://opensource.org/licenses/gpl-license.php GNU Public License
 */
require_once("../../config.php");
require_once ($CFG->dirroot . '/mod/iassign/lib.php');
require_once ($CFG->dirroot . '/mod/iassign/locallib.php');
require_once ($CFG->dirroot . '/mod/iassign/ilm_manager_form.php');

require_login();
if (isguestuser()) {
    die();
}

if(session_id() === "")
	session_start();

//Parameters GET e POST (parâmetros GET e POST)
$id = optional_param('id', 0, PARAM_INT); // Course Module ID
$action = optional_param('action', NULL, PARAM_TEXT);
$from = optional_param('from', NULL, PARAM_TEXT);
$ilmid = optional_param('ilmid', 1, PARAM_INT);

$contextuser = context_user::instance($USER->id);
$context = context_course::instance($id);

$url = "$CFG->wwwroot/mod/iassign/ilm_manager.php?from=$from&id=$id";
$course = $DB->get_record('course', array('id' => $id), '*', MUST_EXIST);
$iassign_ilm = $DB->get_record('iassign_ilm', array('id' => $ilmid));
if (empty($iassign_ilm)) {
	$iassign_ilm = new stdClass();
	$iassign_ilm->name = "";
	$iassign_ilm->extension = "";
}

if(!isset($_SESSION['returnurl']))
	$_SESSION['returnurl'] = optional_param('returnurl', "$CFG->wwwroot/course/view.php?id=$id", PARAM_TEXT);

$title = get_string('ilm_manager_title', 'iassign');

$PAGE->set_url($url);
$PAGE->set_context($context);

$PAGE->set_course($course);
$PAGE->blocks->show_only_fake_blocks(); //
$PAGE->navbar->add($title);
$PAGE->set_title($course->fullname);

if (has_capability('mod/iassign:editiassign', $context, $USER->id)) {
	
    $ilm_manager_instance = new ilm_manager($id, $url, $from);
    $dirid = $ilm_manager_instance->get_dir_ilm('dirid');
    
    switch ($action) {
        case 'new':
            $ilm_manager_instance->ilm_editor_new();
            break;
        case 'update':
            $ilm_manager_instance->ilm_editor_update();
            break;
        case 'delete':
            $ilm_manager_instance->delete_file_ilm();
            break;
        case 'duplicate':
            $ilm_manager_instance->duplicate_file_ilm();
            break;
        case 'rename':
          	$ilm_manager_instance->rename_file_ilm();
           	break;
        case 'preview':
            $ilm_manager_instance->preview_ilm();
            break;
        case 'addilm':
            $ilm_manager_instance->add_ilm();
            break;
        case 'tinymceilm':
        	$fileid = optional_param ( 'fileid', NULL, PARAM_INT );
            $ilm_manager_instance->tinymce_ilm($fileid);
            break;
        case 'export':
            $ilm_manager_instance->export_files_ilm();
            break;
        case 'import':
            $ilm_manager_instance->import_files_ilm();
            break;
        case 'selected_delete':
            $ilm_manager_instance->delete_selected_ilm();
            break;
        case 'new_dir':
           	$ilm_manager_instance->new_dir_ilm();
            break;
            die;
        case 'delete_dir':
          	$ilm_manager_instance->delete_dir_ilm();
           	break;
        case 'rename_dir':
        	$ilm_manager_instance->rename_dir_ilm();
        	break;
        case 'selected_move':
        	$ilm_manager_instance->selected_move_ilm();
        	break;
        case 'move':
        	$ilm_manager_instance->move_files_ilm();
        	break;
        case 'recover':
        	$ilm_manager_instance->recover_files_ilm();
        	break;
    }
    
    if ($from == 'block')
        $PAGE->set_heading($title);

    if ($from == 'iassign' || $from == 'tinymce')
        $PAGE->set_pagelayout('popup');

    $mform = new ilm_manager_form();
    $param = new object();
    $param->id = $id; // oculto
    $param->from = $from;
    $param->ilmid = $ilmid;
    $param->dirid = $dirid;
    $mform->set_data($param);

    if ($mform->is_cancelled()) {
        redirect(new moodle_url("/course/view.php?id=$id"));
    } else if ($formdata = $mform->get_data()) {
        $fs = get_file_storage();
        if($formdata->dirid == 0)
        	$dir_base = '/';
        else {
        	$dir_base = $fs->get_file_by_id($formdata->dirid);
        	$dir_base = $dir_base->get_filepath();
        }
        if ($newfilename = $mform->get_new_filename('file')) {

        	$url = "$CFG->wwwroot/mod/iassign/ilm_manager.php?from=$formdata->from&id=$id&ilmid=$ilmid&dirid=$formdata->dirid";
        	$extension = explode(".", $newfilename);
        	
        	if(strtolower($extension[1]) != 'zip') {
	            $filename = $newfilename;
	
	            $files_course = $fs->get_directory_files($context->id, 'mod_iassign', 'activity', 0, $dir_base, false, true, 'filename');
	
	            if ($files_course) {
	                foreach ($files_course as $value) {
	                    if ($value->get_filename() == utils::format_filename($newfilename))
	                    	$filename = utils::version_filename($value->get_filename());
	                }
	            }
	            $extensions = explode(",", $iassign_ilm->extension);
	            if(in_array($extension[1], $extensions))
            		$file = $mform->save_stored_file('file', $context->id, 'mod_iassign', 'activity', 0, $dir_base, utils::format_filename($filename), 0, $USER->id);
	            else 
	            	$url .= "&error=incompatible_extension_file";
        	} else {
        	
        		$zip_filename = $CFG->dataroot.'/temp/'.$newfilename;
	        	$zip = new zip_packer();
	        	$mform->save_file('file', $zip_filename, true) or die("Save file not found");
	        	$zip_files = $zip->list_files($zip_filename);
	        	$files = $fs->get_directory_files($context->id, 'mod_iassign', 'activity', 0, $dir_base, false, true, 'filename');
	        	
	        	$rename_files = array();
	        	foreach($zip_files as $zip_file) {
	        		foreach($files as $file) {
	        			if(utils::format_filename($zip_file->original_pathname) == $file->get_filename())
	        				$rename_files = array_merge($rename_files, array(utils::version_filename(utils::format_filename($zip_file->original_pathname)) => utils::format_filename($zip_file->original_pathname)));
	        		}
	        	
	        	}
	        	
	        	$zip->extract_to_storage($zip_filename, $context->id, 'mod_iassign', 'activity', 0, $dir_base, $USER->id); 
	        	$files = $fs->get_area_files($context->id, 'mod_iassign', 'activity', 0, 'filename');
	        	foreach($files as $file) {
	        		if($file->get_author() == "") {
	        			$file->set_author($USER->firstname.' '.$USER->lastname);
	        			if($new_name = array_search($file->get_filename(), $rename_files))
	        				$file->rename($dir_base, $new_name);
	        			else if($file->get_filename() != '.' && $file->get_filename() != utils::format_filename($file->get_filename()))
	        				$file->rename($dir_base, utils::format_filename($file->get_filename()));
	        		}
	        	}
	        	unlink($zip_filename);
        	}
        	
        	
        	
        	$fs->delete_area_files($contextuser->id, 'user', 'draft', $formdata->file);
        }
        redirect(new moodle_url($url));
    }
    if ($from == 'iassign') {
    	echo $OUTPUT->header();
    	echo $OUTPUT->heading($title." - ".$iassign_ilm->name);
    	echo('<div width=100% align=right style="margin: 20px 20px 20px 20px;"><input type=button value="' . get_string ( 'close', 'iassign' ) . '"  onclick="javascript:window.close ();"></div>');
    } else if ($from == 'block') {
    	echo $OUTPUT->header();
    	if(isset($_SERVER['HTTP_REFERER']))
    		echo('<div width=100% align=right style="margin: 20px 20px 20px 20px;"><input type=button value="' . get_string ( 'return', 'iassign' ) . '"  onclick="javascript:window.location = \''.$_SESSION['returnurl'].'\';"></div>');
    } else if ($from == 'tinymce') {
    	echo $OUTPUT->header();
    	echo $OUTPUT->heading($title);
    	echo('<div width=100% align=right style="margin: 20px 20px 20px 20px;"><input type=button value="' . get_string ( 'close', 'iassign' ) . '"  onclick="javascript:window.close ();"></div>');
    }
    
    if(!is_null($error = optional_param('error', NULL, PARAM_TEXT)))
    	echo($OUTPUT->notification(get_string ( $error, 'iassign' ), 'notifyproblem'));
    
    $mform->display();
    $ilm_manager_instance->view_files_ilm($iassign_ilm->extension);
    echo $OUTPUT->footer();
    die;
}
?>