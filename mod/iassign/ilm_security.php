<?php
/** 
 * This php script contains all the stuff to secure access to interactive activities.
 * 
 * @author Patricia Alves Rodrigues
 * @author Leônidas O. Brandão
 * @version v 1.0 2010/12/10
 * @package mod_iassign_ilm
 * @since 2012/03/10
 * @copyright iMatica (<a href="http://www.matematica.br">iMath</a>) - Computer Science Dep. of IME-USP (Brazil)
 * 
 * <b>License</b> 
 *  - http://opensource.org/licenses/gpl-license.php GNU Public License
 */
require_once("../../config.php");

global $DB;
//Debug: debug iLM security scheme
//Debug: ATTENTION, this requests the directory './mod/iassign/ilm_debug/' with write permition to www-data !!!!
$DEBUG = 0; //Debug: help to debug, take note of file em 'MOODLE/mod/iassign/ilm_debug/YYYY_mm_dd_m_s_int'

$view = $_GET['view'];
$token = $_GET['token'];
$id = $_GET['id']; //id of the table iassign_security
// Debug
if ($DEBUG) {
    $file_name = "ilm_debug/" . date('Y') . "_" . date('m') . "_" . date('d') . "_" . date('H_i') . "_" . $id;
    $file_debug = "id=" . $id . "<br/>\nview=" . $view . "<br/>\ntoken=" . $token;
}

$stringDebugAux = "";

if ($view == -1) { //view free
    $fs = get_file_storage();
    $file = $fs->get_file_by_id($id);
    $string = $file->get_content();
    $stringDebugAux .= "file content:" . $string;
    echo $string;
} else {

// Get data from table 'iassign_security'
    $iassign_security = $DB->get_record("iassign_security", array("id" => $id));

//      $iassign->annotate_files('mod_iassign', 'exercise', null); // This file area hasn't itemid

    if ($iassign_security) {

        $fileid = $iassign_security->file;

        if ($iassign_security) {
            $update = new object();
            $update->id = $iassign_security->id;
            $update->view = $iassign_security->view + 1;
            $DB->update_record("iassign_security", $update);

            if ($update->view == 2 && $token == md5($iassign_security->timecreated)) { //
                //Security iLM: remove the entry
                $DB->delete_records("iassign_security", array("id" => $id));

                if ($view) {
                    $stringDebugAuxFile = ""; //Debug
                    //
        			$fs = get_file_storage();
                    $file = $fs->get_file_by_id($fileid);
                    $string = $file->get_content();
                    $stringDebugAuxFile .= $file->get_filename() . "/"; //Debug
                    if ($DEBUG) {
                        $stringDebugAux .= "1: SIM: update->view=" . $update->view . "\n" . $token . "=" . md5($iassign_security->timecreated) . "?\n";
                        $stringDebugAux .= "File: $stringDebugAuxFile\n" . $string;
                    }
                } else { // not view - get the student content answer
                    // saw_213_ia_assign_security : file  longtext utf8_unicode_ci
                    // passei para 'blob'
                    $string = $iassign_security->file; //ERROR: usa algum filtro, elimina '.', '/' e outros caracteres
                    //$string = $contextid; - tb nao funciona!!

                    if ($DEBUG) {
                        $stringDebugAux .= "2: NAO: update->view=" . $update->view . "\n" . $token . "=" . md5($iassign_security->timecreated) . "?";
                        $stringDebugAux .= "File:\n" . $string;
                    }
                }
                echo $string;
            } else {
                if ($DEBUG) {
                    $stringDebugAux .= "3: NAO: update->view=" . $update->view . "\n" . $token . "=" . md5($iassign_security->timecreated) . "?";
                    $stringDebugAuxFile = ""; //Debug
                    foreach ($files as $file) {
                        $stringDebugAuxFile .= $file->get_filename() . "/"; //Debug
                        if ($file->get_filename() != '.') {
                            $string = $file->get_content();
                        }
                    }
                    $stringDebugAux .= "File: $stringDebugAuxFile";
                }
            }
        } // if($iassign_security)
    }
}
if ($DEBUG) {
    $fpointer = fopen($file_name, "w");
    $file_debug .= "\nAuxiliary information: " . $stringDebugAux . "";
    $file_debug .= "\nContent iLM file: |" . $string . "|";
    fwrite($fpointer, "From: ./mod/iassign/ilm_security.php<br/>\n" . $file_debug);
    fclose($fpointer);
}

//mysql_query("FLUSH TABLES WITH READ LOCK");
?>
