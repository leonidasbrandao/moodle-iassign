<?php
/**
 * This class provides all the functionality for an ia (interactive activities).
 *
 * Release Notes:
 * - v 4.6.1 2014/10/10
 * 		+ Fix flaw in POST (now check if 'REMOTE_ADDR' and 'HTTP_USER_AGENT' is defined)
 * - v 4.6 2014/02/25
 * 		+ Fix bugs in filter function for open applets.
 * - v 4.5 2014/02/24
 * 		+ Fix bugs in params.
 * 		+ Insert new param type.
 * - v 4.4 2014/01/24
 * 		+ Allow select type of params.
 * 		+ Insert the use of applet params specific for activities.
 * - v 4.3 2014/01/23
 * 		+ Insert function for move activities for other iLM (ilm_settings::confirm_move_iassign, ilm_settings::move_iassign).
 * - v 4.2 2014/01/20
 * 		+ Fix bugs in editor layout.
 * 		+ Insert new applet tags 'MA_POST_ArchiveTeacher' and 'MA_PARAM_Proposition'.
 * 		+ Change button label 'save' to 'write' in forms.
 * - v 4.1 2013/12/13
 * 		+ Insert log in iAssign actions.
 * 		+ Allow use the language in iLM description (ilm_settings::new_file_ilm, ilm_settings::new_ilm, ilm_settings::edit_ilm, ilm_settings::copy_new_version_ilm, ilm_settings::add_edit_copy_ilm, language::get_description_lang, language::get_all_lang).
 * 		+ Insert class for Log actions in system.
 * - v 4.0 2013/10/31
 * 		+ Insert support of export iLM in zip packages (ilm_settings::export_ilm).
 * 		+ Insert support of import iLM from zip packages (ilm_settings::import_ilm).
 * 		+ Fix bugs in message alert in iassign title and remove message alert of the description by cache error.
 * - v 3.9 2013/10/25
 * 		+ Insert support of upgrade iLM.
 * 		+ Insert support for more than one extension in iLM.
 * 		+ Fix bugs in verion control.
 * - v 3.8 2013/09/19
 * 		+ Get data of general fields in iassign statement table (iassign::add_edit_iassign).
 * - v 3.7 2013/09/12
 * 		+ Change tag APPLET in all funcions of module (ilm::view_iLM, ilm_manager::ilm_editor_new, ilm_manager::ilm_editor_update).
 * 		+ Insert tool for manage aditional params for iLM (ilm_settings::add_edit_copy_param, ilm_settings::visible_param, ilm_settings::add_param, ilm_settings::edit_param, ilm_settings::copy_param, ilm_settings::delete_param).
 * - v 3.6 2013/09/05
 * 		+ Insert function ilm_settings::applet_ilm for create APPLET html tag.
 * 		+ Insert function ilm_settings::applet_filetime for get modified date of iLM file.
 * 		+ Change tag APPLET in funcion ilm_settings::view_ilm.
 * - v 3.5 2013/08/26
 * 		+ Fix bug in download package iassign without answers (iassign::report).
 * - v 3.4 2013/08/23
 * 		+ Fix bug in export package iassign.
 * - v 3.3 2013/08/22
 * 		+ Insert functions for export users answer in iassign (iassign::export_file_answer, iassign::export_package_answer, iassign::view_iassign_current, iassign::report).
 * 		+ Insert function for rename iassign file (ilm_manager::rename_file_ilm, ilm_manager::view_files_ilm).
 * - v 3.2 2013/08/21
 * 		+ Change title link with message for get file for donwload file (ilm_manager::view_files_ilm).
 * 		+ Change functions for import files for ilm_manager.php.
 * 		+ Create static utils class for functions system utils (utils::format_filename, utils::version_filename).
 * - v 3.1 2013/08/15
 * 		+ Change return file selected (ilm_manager::add_ilm).
 * 		+ Insert functions for import files, export files and remove selected files (ilm_manager::view_files_ilm, ilm_manager::import_files_ilm, ilm_manager::export_files_ilm, ilm_manager::delete_selected_ilm).
 * - v 3.0 2013/08/02
 * 		+ Insert link for view informations of iLMs in teacher view, same screen of admin view but wiht some features hide (ilm_settings::list_ilm, ilm_settings::view_ilm, iassign::view_iassigns).
 * - v 2.9 2013/08/01
 * 		+ Fix bugs in functions ilm_settings::new_file_ilm, ilm_settings::copy_new_version_ilm, ilm_settings::add_edit_copy_ilm.
 * - v 2.8 2013/07/25
 * 		+ Insert the activity name in header of view (activity::view_dates).
 * 		+ Set function default iLM in view iLMs versions (ilm_settings::default_ilm and ilm_settings::confirm_default_ilm).
 * - v 2.7 2013/07/24
 * 		+ Create link previous and next for student view in one activity (activity::view_dates).
 * 		+ Fix bugs for view error in iLM not on DB in function iassign::view_iassign_current.
 * - v 2.6 2013/07/23
 * 		+ Fix bugs for view files in function ilm_manager::view_files_ilm.
 * 		+ Fix bugs for comment on teacher view in function iassign::view_iassign_current.
 * - v 2.5 2013/07/12
 * 		+ Change iLM settings for accept versions (ilm_settings::new_file_ilm, ilm_settings::new_ilm, ilm_settings::edit_ilm, ilm_settings::copy_new_version_ilm).
 * 		+ Insert new informations in iLMs table: created date, modified date, author, version, modified date of JAR (ilm_settings::view_ilm).
 *
 * @author Patricia Alves Rodrigues
 * @author Leônidas O. Brandão
 * @author Luciano Oliveira Borges
 * @version v 4.6 2014/02/25
 * @package mod_iassign_lib
 * @since 2010/09/27
 * @copyright iMatica (<a href="http://www.matematica.br">iMath</a>) - Computer Science Dep. of IME-USP (Brazil)
 *
 * <b>License</b>
 *  - http://opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * Standard base class for all iAssign.
 */
class iassign {
 var $cm;
 var $course;
 var $iassign;
 var $striassign;
 var $striassigns;
 var $context;
 var $activity;
 var $iassign_up;
 var $iassign_down;
 var $action;
 var $iassign_submission_current;
 var $userid_iassign;
 var $bottonPost;
 var $write_solution;
 var $view_iassign;

 /**
  * Constructor for the base iassign class
  */
 function iassign($iassign, $cm, $course) {
  global $COURSE, $CFG, $USER, $DB;

  $botton = optional_param ( 'botton', NULL, PARAM_TEXT );
  if (! is_null ( $botton ))
   $USER->iassignEdit = $botton;

  $this->userid_iassign = optional_param ( 'userid_iassign', 0, PARAM_INT );
  $this->iassign_up = optional_param ( 'iassign_up', 0, PARAM_INT );
  $this->iassign_down = optional_param ( 'iassign_down', 0, PARAM_INT );
  $this->iassign_submission_current = optional_param ( 'iassign_submission_current', 0, PARAM_INT );
  $this->write_solution = optional_param ( 'write_solution', 0, PARAM_INT );
  $this->action = optional_param ( 'action', NULL, PARAM_TEXT );

  if ($cm) {
   $this->cm = $cm;
   } else if (! $this->cm = get_coursemodule_from_id ( 'iassign', $cmid )) {
   print_error ( 'invalidcoursemodule' );
  }

  $this->context = context_module::instance($this->cm->id );

  if ($course) {
   $this->course = $course;
   } else if ($this->cm->course == $COURSE->id) {
   $this->course = $COURSE;
   } else if (! $this->course = $DB->get_record ( 'course', array ('id' => $this->cm->course ) )) {
   print_error ( 'invalidid', 'iassign' );
   }
  $this->coursecontext = context_course::instance($this->course->id );
  $courseshortname = format_text ( $this->course->shortname, true, array ('context' => $this->coursecontext ) );

  if ($iassign) {
   $this->iassign = $iassign;
   } else if (! $this->iassign = $DB->get_record ( 'iassign', array ('id' => $this->cm->instance ) )) {
   print_error ( 'invalidid', 'iassign' );
   }
  $USER->context = context_module::instance($this->cm->id );
  $USER->cm = $this->cm->id;

  $this->iassign->cmidnumber = $this->cm->idnumber; // compatibility with modedit ia obj
  $this->iassign->courseid = $this->course->id; // compatibility with modedit ia obj
  $this->context = context_module::instance($this->cm->id );
  $this->striassign = get_string ( 'modulename', 'iassign' );
  $this->striassigns = get_string ( 'modulenameplural', 'iassign' );
  $this->return = $CFG->wwwroot . "/mod/iassign/view.php?id=" . $this->cm->id;
  $this->bottonPost = 0;
  $this->view_iassign = optional_param ( 'action', false, PARAM_BOOL );
  $this->activity = new activity ( optional_param ( 'iassign_current', NULL, PARAM_TEXT ) );
  $this->view ();
   }

 /**
  * Display the iAssign, used by view.php
  *
  * This in turn calls the methods producing individual parts of the page
  */
 function view() {
  global $USER, $DB, $OUTPUT;

  // If this user has no capability to View 'iassign': stop here
  require_capability ( 'mod/iassign:view', $this->context );

  add_to_log ( $this->course->id, "iassign", "view", "view.php?id={$this->cm->id }", utils::remove_code_message($this->iassign->name), $this->cm->id, $USER->id );

  if ($this->action) {
   $this->action();
   } else {
   echo $OUTPUT->header();
   $this->view_iassigns();
   echo $OUTPUT->footer();
   } // if ($this->action)
    // security: delete all records with an error loading IMA
  $DB->delete_records ( "iassign_security", array ("userid" => $USER->id,"view" => 1 ) );
  die ();
   }

 /**
  * Limited access
  */
 function action() {
  global $USER;

  // action:
  // up - move up activity (mover atividade para cima)
  // down - move down activity (mover atividade para baixo)
  // visible - view/hide activity (exibir/ocultar atividade)
  // delete - delete activity (excluir atividade)
  // deleteyes - confirms exclusion of activity (confirma exclusÃ£o de atividade)
  // deleteno - does not erase activity (nÃ£o apaga atividade)
  // add - add activity (adicionar atividade)
  // edit - edit activity (modificar atividade)

  $action_iassign = array ('newcomment' => '$this->get_answer ();','view' => '$this->view_iassign_current ();','get_answer' => '$this->get_answer ();','repeat' => '$this->view_iassign_current ();','overwrite' => '$this->get_answer ();','stats_student' => '$this->stats_students ();', 'download_answer' => '$this->export_file_answer();', 'download_all_answer' => '$this->export_package_answer();' );

  $action_iassign_limit = array ('view' => '$this->view_iassign_current();','newcomment' => '$this->get_answer ();','viewsubmission' => '$this->view_iassign_current();','edit_status' => '$this->edit_status ();','edit_grade' => '$this->edit_grade ();','report' => '$this->report ();','print' => '$this->report ();','stats' => '$this->stats ();','printstats' => '$this->stats ();' );

  $restricted = array ('up' => '$this->activity->move_iassign ($this->iassign_up,$this->return);','down' => '$this->activity->move_iassign ($this->iassign_down,$this->return);','visible' => '$this->activity->visible_iassign ($this->return);','delete' => '$this->activity->delete ($this->return);','deleteno' => '$this->return_home_course("confirm_not_delete_iassign");','deleteyes' => '$this->activity->deleteyes($this->return, $this);','add' => '$this->add_edit_iassign ();','edit' => '$this->add_edit_iassign ();','get_answer' => '$this->get_answer ();' );

  $action_iassign_restricted = array_merge ( $restricted, $action_iassign_limit, $action_iassign );

  if (has_capability ( 'mod/iassign:editiassign', $this->context, $USER->id ))
   eval ( $action_iassign_restricted [$this->action] );
  elseif (has_capability ( 'mod/iassign:evaluateiassign', $this->context, $USER->id ))
   eval ( $action_iassign_limit [$this->action] );
  else
   eval ( $action_iassign [$this->action] );
   }

 /**
  * receives the return of iLM
  */
 function get_answer() {
  global $USER, $CFG, $DB, $OUTPUT;
  $id = $this->cm->id;
  $submission_comment = optional_param ( 'submission_comment', NULL, PARAM_TEXT );
  $comment = false;
  if ($submission_comment)
   $comment = $this->write_comment_submission ();

   // receives data of iLM using the current activity
  $iassign_ilm = $DB->get_record ( "iassign_ilm", array ("id" => $this->activity->get_activity ()->iassign_ilmid ) );
  $iassign = $DB->get_record ( "iassign", array ("id" => $this->activity->get_activity ()->iassignid ) );
  // receives data of submission of current activity
  $iassign_submission = $DB->get_record ( "iassign_submission", array ("iassign_statementid" => $this->activity->get_activity ()->id,"userid" => $this->userid_iassign ) ); // data about student solution
                                                                                                                                                                       // receives post and get
  $MA_POST_Value = optional_param ( 'MA_POST_Value', 0, PARAM_INT ); // 1 - activity evaluated as correct / 0 - activity evaluated as incorrect
  $MA_POST_Archive = optional_param ( 'MA_POST_Archive', NULL, PARAM_TEXT ); // answer file (string)
  $MA_POST_Info = optional_param ( 'MA_POST_Info', NULL, PARAM_FORMAT );
  $MA_POST_SystemData = optional_param ( 'MA_POST_SystemData', NULL, PARAM_FORMAT );
  $return_get_answer = optional_param ( 'return_get_answer', 0, PARAM_INT );
  $msg = '';

  // feedback
  /*
   * status of activities: 0 â€“ not post 1 â€“ post 2 â€“ evaluated as incorrect 3 â€“ evaluated as correct
   */

  $title = get_string ( 'evaluate_iassign', 'iassign' );
  echo $OUTPUT->header ();
  echo $OUTPUT->box_start ();
  $return = "" . $CFG->wwwroot . "/mod/iassign/view.php?action=view&id=" . $id . "&iassign_submission_current=" . $this->iassign_submission_current . "&userid_iassign=" . $this->userid_iassign . "&iassign_current=" . $this->activity->get_activity ()->id;

  // icons::insert ($icon)
  // $return_last = "&nbsp;<a href='" . $return . "'>" . $this->icon_return . '&nbsp;' . get_string('return_iassign', 'iassign') . "</a>";
  $return_last = "&nbsp;<a href='" . $return . "'>" . icons::insert ( 'return_home' ) . '&nbsp;' . get_string ( 'return_iassign', 'iassign' ) . "</a>";

  $link_return = "&nbsp;<a href='" . $this->return . "'>" . icons::insert ( 'home' ) . '&nbsp;' . get_string ( 'activities_page', 'iassign' ) . "</a>";
  echo '<table  width=100% >';

  if ($MA_POST_Archive == - 1 or empty ( $MA_POST_Archive )) { // if ($MA_POST_Value == -1) {
   $this->write_solution = 0; // necessary in order to take note in Moodle 'grade' system
   if ($comment)
    echo '<tr><td colspan=2><br>' . get_string ( 'empty_answer_post', 'iassign' ) . '</br>' . get_string ( 'confirm_add_comment', 'iassign' ) . '</td>';
   else
    echo '<tr><td colspan=2><br>' . get_string ( 'empty_answer_post', 'iassign' ) . '</td>';
   echo '<tr><td width=40% align=right>' . $return_last . '&nbsp;' . $link_return . '</td></tr>';
   } else {
   if ($iassign_ilm->evaluate == 1 and $this->activity->get_activity ()->automatic_evaluate == 1) { // iLM with automatic evaluator
    if (intval ( $MA_POST_Value ) == 1) {
     $status = 3;
     $grade_student = $this->activity->get_activity ()->grade; // evaluated as correct solution submitted is assigned the note pattern of activity
     $msg = '<tr><td colspan=2>' . icons::insert ( 'feedback_correct' ) . '<br>' . get_string ( 'get_answer_correct', 'iassign' ) . '</td>';

     // log record
     $info = $iassign->name . "&nbsp;-&nbsp;" . $this->activity->get_activity ()->name . "&nbsp;-&nbsp;" . get_string ( 'feedback_correct', 'iassign' ) . "&nbsp;-&nbsp;" . get_string ( 'grade_iassign', 'iassign' ) . ":" . $grade_student;
     add_to_log ( $this->course->id, "iassign", "add submission", "view.php?id={$this->cm->id }", $info, $this->cm->id, $USER->id );
     } else {
     $status = 2;
     $grade_student = 0; // evaluated as incorrect solution
     $msg = '<tr><td colspan=2>' . icons::insert ( 'feedback_incorrect' ) . '<br>' . get_string ( 'get_answer_incorrect', 'iassign' ) . '</td>';

     // log record
     $info = $iassign->name . "&nbsp;-&nbsp;" . $this->activity->get_activity ()->name . "&nbsp;-&nbsp;" . get_string ( 'feedback_incorrect', 'iassign' ) . '&nbsp;-&nbsp;' . get_string ( 'grade_iassign', 'iassign' ) . $grade_student;
     add_to_log ( $this->course->id, "iassign", "add submission", "view.php?id={$this->cm->id }", $info, $this->cm->id, $USER->id );
     } // if ($MA_POST_Value == 1)

    if ($this->activity->get_activity ()->show_answer == 0) { // not automatic evaluate
     echo '<tr><td width=60% ><strong>' . icons::insert ( 'post' ) . get_string ( 'get_answer', 'iassign' ) . '</strong></td>';
     echo '<tr><td width=40% align=right>' . $return_last . '&nbsp;' . $link_return . '</td></tr>';
     echo '<tr>';
     // log record
     $info = $iassign->name . "&nbsp;-&nbsp;" . $this->activity->get_activity ()->name . "&nbsp;-&nbsp;" . get_string ( 'get_answer', 'iassign' );
     add_to_log ( $this->course->id, "iassign", "add submission", "view.php?id={$this->cm->id }", $info, $this->cm->id, $USER->id );
     } else {
     echo '<tr><td width=60% ><strong>' . get_string ( 'auto_result', 'iassign' ) . '</strong></td>';
     echo '<td width=40% align=right>' . $return_last . '&nbsp;' . $link_return . '</td></tr>';
     echo '<tr>';
     echo $msg;
     }
    } else {
    $status = 1;
    $grade_student = 0; // iLM not have automatic evaluator
    echo '<tr><td colspan=2>' . icons::insert ( 'post' ) . get_string ( 'get_answer_post', 'iassign' ) . '</td>';
    echo '<tr><td width=40% align=right>' . $return_last . '&nbsp;' . $link_return . '</td></tr>';
    echo '<tr>';

    // log record
    $info = $iassign->name . "&nbsp;-&nbsp;" . $this->activity->get_activity ()->name . "&nbsp;-&nbsp;" . get_string ( 'get_answer_post', 'iassign' );
    add_to_log ( $this->course->id, "iassign", "add submission", "view.php?id={$this->cm->id }", $info, $this->cm->id, $USER->id );
    } // if ($iassign_ilm->evaluate == 1)
   } // if ($MA_POST_Value == -1)
  echo '</tr></table>';
  echo $OUTPUT->box_end ();

  // add or update evaluate
  if ($this->write_solution == 1) {
   $timenow = time ();

   // new record
   if (! $iassign_submission) {
    $newentry = new stdClass ();
    $newentry->userid = $this->userid_iassign;
    $newentry->iassign_statementid = $this->activity->get_activity ()->id;
    $newentry->timecreated = $timenow;
    $newentry->timemodified = $timenow;
    $newentry->answer = $MA_POST_Archive;
    $newentry->grade = $grade_student;
    $newentry->status = $status;
    $newentry->experiment = 1;
    if (! $newentry->id = $DB->insert_record ( "iassign_submission", $newentry )) {
     print_error ( 'error_insert', 'iassign' );
     } else {
     add_to_log ( $this->course->id, "iassign", "add submission", "view.php?id={$this->iassign->id }", $this->activity->get_activity ()->name, $this->cm->id, $USER->id );
     $this->update_grade_student ( $newentry->userid, $newentry->iassign_statementid, $this->iassign->id );
     }
    } elseif ($iassign_submission->status != 3) {
    $newentry = new stdClass ();
    $newentry->id = $iassign_submission->id;
    $newentry->iassign_statementid = $iassign_submission->iassign_statementid;
    $newentry->userid = $iassign_submission->userid;
    $newentry->timecreated = $iassign_submission->timecreated;
    $newentry->timemodified = $timenow;
    $newentry->answer = $MA_POST_Archive;
    $newentry->grade = $grade_student;
    $newentry->status = $status;
    $newentry->experiment = $iassign_submission->experiment + 1;
    if (! $DB->update_record ( "iassign_submission", $newentry )) {
     print_error ( 'error_update', 'iassign' );
     //D depurar...
     //D $stringAux = "ia.class.php: ".$MA_POST_Archive."<br/> ".utf8_encode($MA_POST_Archive)."<br/>".utf8_encode(utf8_encode($MA_POST_Archive))."<br/>";
     //D $fp = fopen("teste1.txt","w");
     //D fwrite($fp,$stringAux);
     } else {
     add_to_log ( $this->course->id, "iassign", "update submission", "view.php?id={$this->iassign->id }", $this->activity->get_activity ()->name, $this->cm->id, $USER->id );
     $this->update_grade_student ( $newentry->userid, $newentry->iassign_statementid, $this->iassign->id );
     }
    } else {
    if ($return_get_answer == 1) {
     $newentry = new stdClass ();
     $newentry->id = $iassign_submission->id;
     $newentry->iassign_statementid = $iassign_submission->iassign_statementid;
     $newentry->userid = $iassign_submission->userid;
     $newentry->timecreated = $iassign_submission->timecreated;
     $newentry->timemodified = $timenow;
     $newentry->answer = $MA_POST_Archive;
     $newentry->grade = $grade_student;
     $newentry->status = $status;
     $newentry->experiment = $iassign_submission->experiment + 1;
     if (! $DB->update_record ( "iassign_submission", $newentry ))
      print_error ( 'error_update', 'iassign' );
     else {
      add_to_log ( $this->course->id, "iassign", "update submission", "view.php?id={$this->iassign->id }", $this->activity->get_activity ()->name, $this->cm->id, $USER->id );
      $this->update_grade_student ( $newentry->userid, $newentry->iassign_statementid, $this->iassign->id );
      echo $OUTPUT->box_start ();
      echo "<p>" . get_string ( 'iassign_update', 'iassign' ) . "</p>";
      echo $OUTPUT->box_end ();
      }
     } elseif ($return_get_answer == 2) {
     echo $OUTPUT->box_start ();
     echo "<p>" . get_string ( 'iassign_cancel', 'iassign' ) . "</p>";
     echo $OUTPUT->box_end ();
     } else {
     echo $OUTPUT->box_start ();
     echo "
 <script type='text/javascript'>
  //<![CDATA[
  function overwrite () {
    document.formEnvio.return_get_answer.value = 1;
    document.formEnvio.submit();
    }

  function nooverwrite () {
    document.formEnvio.return_get_answer.value = 2;
    document.formEnvio.submit();
    }
  //]]>
 </script>";
     $param_aux = "action=overwrite&iassign_submission_current=" . $iassign_submission->id . "&id=" . $id . "&iassign_current=" . $this->activity->get_activity ()->id . "&write_solution=" . $this->write_solution . "&userid_iassign=" . $USER->id;
     $get_answer_overwrite = $CFG->wwwroot . "/mod/iassign/view.php?" . $param_aux;
     echo "<form name='formEnvio' method='post' action='$get_answer_overwrite' enctype='multipart/form-data'>";
     echo "<p>" . get_string ( 'last_iassign_correct', 'iassign' ) . "</p>";
     echo "<p>" . get_string ( 'update_iassign', 'iassign' ) . "</p>";
     echo "<input type='hidden' name='MA_POST_Archive' value='$MA_POST_Archive'/>
           <input type='hidden' name='MA_POST_Value' value='$MA_POST_Value'/>
           <input type='hidden' name='MA_POST_Info' value='$MA_POST_Info'/>
           <input type='hidden' name='MA_POST_SystemData' value='$MA_POST_SystemData'/>
           <input type='hidden' name='return_get_answer'/> ";
     echo "<input type=button value='" . get_string ( 'yes', 'iassign' ) . "' onClick = 'overwrite()'
            title='" . get_string ( 'message_update_iassign', 'iassign' ) . "'/>&nbsp;&nbsp;";
     echo "<input type=button value='" . get_string ( 'no', 'iassign' ) . "' onClick = 'nooverwrite()'
            title='" . get_string ( 'message_no_update_iassign', 'iassign' ) . "'/>";
     echo " </form>";
     echo $OUTPUT->box_end ();
     }
    }
   } // if ($this->write_solution == 1)

  echo $OUTPUT->footer();
  die ();
  }

 /**
  * Export in file the answer of student.
  */
 function export_file_answer() {
  global $DB;

  $iassign_submission_id = optional_param ( 'iassign_submission_id', NULL, PARAM_INT );

  $iassign_submission = $DB->get_record ( "iassign_submission", array ("id" => $iassign_submission_id ) );
  $iassign_statement = $DB->get_record ( "iassign_statement", array ("id" => $iassign_submission->iassign_statementid ) );
  $name = utils::format_filename(strip_tags($iassign_statement->name));

  $iassign_ilm = $DB->get_record ( "iassign_ilm", array ("id" => $iassign_statement->iassign_ilmid ) );
  $extensions = explode(",", $iassign_ilm->extension);

  $iassign_user = $DB->get_record ( "user", array ("id" => $iassign_submission->userid ) );
  $username = utils::format_filename($iassign_user->firstname.' '.$iassign_user->lastname);

  $name_answer = $username.'-'.$name.'-'.userdate($iassign_submission->timemodified, '%Y%m%d-%H%M').'.'.$extensions[0];

  header("Pragma: public");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Cache-Control: private",false);
  header("Content-Type: document/unknown");
  header("Content-Disposition: attachment; filename=\"".$name_answer."\";");
  set_time_limit(0);
  echo($iassign_submission->answer);
  exit;
  }

 /**
  * Export an package (zip) with all answer of students.
  */
 function export_package_answer() {
  global $DB, $CFG;

  $iassign_id = optional_param ( 'iassign_id', NULL, PARAM_INT );
  $iassign = $DB->get_record ( "iassign", array ("id" => $iassign_id ) );
  $iassign_name = utils::format_filename($iassign->name);

  $userid = optional_param ( 'userid', NULL, PARAM_INT );
  $iassign_user = $DB->get_record ( "user", array ("id" => $userid ) );
  $username = utils::format_filename($iassign_user->firstname.' '.$iassign_user->lastname);

  $zip_filename = $CFG->dataroot.'/temp/package-iassign-'.$username.'-'.$iassign_name.'-'.date('Ymd-Hi').'.zip';
  $zip = new zip_archive();
  $zip->open($zip_filename);

  $iassign_statements = $DB->get_records ( "iassign_statement", array ("iassignid" => $iassign_id ) );
  foreach ($iassign_statements as $iassign_statement) {
   $name = utils::format_filename(strip_tags($iassign_statement->name));

   $iassign_ilm = $DB->get_record ( "iassign_ilm", array ("id" => $iassign_statement->iassign_ilmid ) );
   $extensions = explode(",", $iassign_ilm->extension);

   $timemodified = "";
   $answer = "";
   $iassign_submission = $DB->get_record ( "iassign_submission", array ("iassign_statementid" => $iassign_statement->id, "userid" => $userid ) );
   if ($iassign_submission) {
    $timemodified = '-'.userdate($iassign_submission->timemodified, '%Y%m%d-%H%M');
    $answer = $iassign_submission->answer;
    $name_answer = $name.$timemodified.'.'.$extensions[0];
    $zip->add_file_from_string($name_answer, $answer);
    }
  }

  $zip->close();

  header("Pragma: public");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Cache-Control: private",false);
  header("Content-Type: application/zip");
  header("Content-Disposition: attachment; filename=\"".basename($zip_filename)."\";");
  header("Content-Transfer-Encoding: binary");
  header("Content-Length: ".@filesize($zip_filename));
  set_time_limit(0);
  @readfile("$zip_filename") or die("File not found.");
  unlink($zip_filename);
  exit;
  }

 /**
  * Editing status of interactive activities
  */
 function edit_status() {
  global $USER, $DB, $OUTPUT;

  $newentry->id = $this->iassign_submission_current;
  $newentry->status = optional_param ( 'return_status', 0, PARAM_INT );

  $iassign_submission = $DB->get_record ( 'iassign_submission', array ('id' => $this->iassign_submission_current ) );
  if ($iassign_submission->status != 0 and $newentry->status == 0)
   $newentry->status = $iassign_submission->status;

  $newentry->teacher = $USER->id;
  if (! $DB->update_record ( 'iassign_submission', $newentry ))
   print_error ( 'error_update', 'iassign' );
  else {
   add_to_log ( $this->course->id, "iassign", "update", "view.php?id={$this->iassign->id }", $newentry->id, $this->cm->id, $USER->id );
   $this->action = 'viewsubmission';
   $this->view_iassign_current ();
   } // if (!$DB->update_record('iassign_submission', $newentry))
   }

 /**
  * Editing grade of interactive activities
  */
 function edit_grade() {
  global $USER, $DB, $OUTPUT;

  $newgrade = optional_param ( 'return_grade', 0, PARAM_INT );
  if ($newgrade and $newgrade >= 0) {
   $newentry->id = $this->iassign_submission_current;
   $newentry->grade = optional_param ( 'return_grade', 0, PARAM_INT );
   $newentry->teacher = $USER->id;
   if (! $DB->update_record ( 'iassign_submission', $newentry ))
    print_error ( 'error_update', 'iassign' );
   else
    add_to_log ( $this->course->id, "iassign", "update", "view.php?id={$this->iassign->id }", $newentry->id, $this->cm->id, $USER->id );
   } // if ($newgrade >= 0)
  $this->action = 'viewsubmission';
  $this->view_iassign_current ();
   }

 /**
  * Add or Edit interactive activities
  */
 function add_edit_iassign() {
  global $USER, $CFG, $COURSE, $DB, $OUTPUT;
  require_once ('iassign_form.php');

  $id = $this->cm->id;
  $iassignid = $this->iassign->id;

  $param = new object ();
  $param->action = $this->action; // oculto
  $param->id = $id; // oculto
  $COURSE->cm = $id;
  $COURSE->iassignid = $iassignid;
  $COURSE->iassign_file_id = NULL;

  $context = context_module::instance($this->cm->id );

  $contextuser = context_user::instance($USER->id );

  $component = 'mod_iassign';
  $filearea = 'exercise';

  if (! empty ( $this->iassign_current ))
   $COURSE->iassign_id = $this->iassign_current;
  else
   $COURSE->iassign_id = 0;

  if ($this->action == 'add') {

   $iassign_data = $DB->get_record ( "iassign", array('id' => $iassignid));

   $params = array ('iassignid' => $iassignid );
   $iassign_statement = $DB->get_records_sql ( "SELECT s.id, s.name, s.dependency
                             FROM {iassign_statement } s
                             WHERE s.iassignid = :iassignid
                             ORDER BY `s`.`position` ASC", $params ); // " - jed/excs

   $param->iassignid = $iassignid;
   $param->name = "";
   $param->oldname = "";
   $param->type_iassign = 3;
   $param->proposition = "";
   $author = $DB->get_record ( "user", array ("id" => $USER->id ) );
   $param->author_name = $author->firstname . '&nbsp;' . $author->lastname;
   $param->author_modified_name = $author->firstname . '&nbsp;' . $author->lastname;
   $param->author = $param->author_name;
   $param->author_modified = $param->author_modified_name;
   $COURSE->iassign_list = array ();
   $param->iassign_list = array ();
   if ($iassign_statement) {
    foreach ( $iassign_statement as $iassign ) {
     $param->iassign_list [$iassign->id] = 0;
     $COURSE->iassign_list [$iassign->id] = new stdClass ();
     $COURSE->iassign_list [$iassign->id]->id = $iassign->id;
     $COURSE->iassign_list [$iassign->id]->name = $iassign->name;
     $COURSE->iassign_list [$iassign->id]->enable = 1;
     } // foreach ($iassign_statement as $iassign)
    }
   $param->file = 0;
   $param->fileold = 0;
   $param->filename = "";
   $param->grade = $iassign_data->grade;
   $param->timemodified = time ();
   $param->timecreated = time ();
   $param->timeavailable = $iassign_data->timeavailable;
   $param->timedue = $iassign_data->timedue;
   $param->preventlate = $iassign_data->preventlate;
   $param->test = $iassign_data->test;
   $param->special_param1 = 0;
   $param->visible = 1;
   $param->max_experiment = $iassign_data->max_experiment;
   $param->dependency = 0;
   }   // if ($this->action == 'add')
  elseif ($this->action == 'edit') {

   $COURSE->iassign_list = array ();

   if ($this->activity->get_activity () != null) {
    $iassign_statement_current = $DB->get_record ( "iassign_statement", array ("id" => $this->activity->get_activity ()->id ) );

    $iassign_statement = $DB->get_records_sql ( "SELECT *
                             FROM {$CFG->prefix }iassign_statement s
                             WHERE s.iassignid = '$iassignid'
                             AND s.id!='$iassign_statement_current->id'
                             ORDER BY `s`.`position` ASC" );

    $param->iassign_id = $iassign_statement_current->id; // oculto
    $param->iassignid = $iassign_statement_current->iassignid; // oculto
    $param->name = $iassign_statement_current->name;
    $param->oldname = $iassign_statement_current->name;
    $param->type_iassign = $iassign_statement_current->type_iassign;
    $param->proposition = $iassign_statement_current->proposition;
    $param->author_name = $iassign_statement_current->author_name; // oculto
    $param->author = $iassign_statement_current->author_name;
    $author = $DB->get_record ( "user", array ('id' => $USER->id ) );
    $param->author_modified_name = $author->firstname . '&nbsp;' . $author->lastname;
    $param->author_modified = $param->author_modified_name;
    $dependency = explode ( ';', $iassign_statement_current->dependency );
    $param->iassign_list = array ();
    $inter = array ();
    if ($iassign_statement)
     foreach ( $iassign_statement as $iassign )
      if (in_array ( $iassign->id, $dependency ))
       $inter [] = $iassign->id;

    $iassign_statement_dependency = $DB->get_records_sql ( "SELECT *
                             FROM {$CFG->prefix }iassign_statement s
                             WHERE s.iassignid = '$iassignid'
                             AND s.id!='$iassign_statement_current->id'
                             AND s.dependency!=0" );

    $array_dependency = array ();
    $subdependency = "";
    $sub_subdependency = "";
    // dependent on this exercise
    if ($iassign_statement_dependency) {
     $subdependency .= $this->search_dependency ( $iassign_statement_current->id, $iassign_statement_dependency );

     // to whom this exercise depends
     foreach ( $inter as $tmp )
      $sub_subdependency .= $this->search_sub_dependency ( $tmp );

     $list_dependency = $subdependency . $sub_subdependency;
     $array_dependency = explode ( ";", $list_dependency );
     }

    if ($iassign_statement) {
     foreach ( $iassign_statement as $iassign ) {

      $COURSE->iassign_list [$iassign->id] = new stdClass ();
      $COURSE->iassign_list [$iassign->id]->name = $iassign->name;
      $COURSE->iassign_list [$iassign->id]->id = $iassign->id;

      if (in_array ( $iassign->id, $dependency ))
       $param->iassign_list [$iassign->id] = 1;
      else
       $param->iassign_list [$iassign->id] = 0;

      if (in_array ( $iassign->id, $array_dependency ))
       $COURSE->iassign_list [$iassign->id]->enable = 0;
      else
       $COURSE->iassign_list [$iassign->id]->enable = 1;
      } // foreach ($iassign_statement as $iassign)
     }
    $param->iassign_ilmid = $iassign_statement_current->iassign_ilmid;
    $param->fileold = 0;
    $param->file = 0;
    $param->filename = '';
    $param->grade = $iassign_statement_current->grade;
    $param->timecreated = $iassign_statement_current->timecreated; // oculto
    $param->timeavailable = $iassign_statement_current->timeavailable;
    $param->timedue = $iassign_statement_current->timedue;
    $param->preventlate = $iassign_statement_current->preventlate;
    $param->test = $iassign_statement_current->test;
    $param->special_param1 = $iassign_statement_current->special_param1;
    $param->position = $iassign_statement_current->position; // oculto
    $param->visible = $iassign_statement_current->visible;
    $param->max_experiment = $iassign_statement_current->max_experiment;
    $param->automatic_evaluate = $iassign_statement_current->automatic_evaluate;
    $param->show_answer = $iassign_statement_current->show_answer;
    $fs = get_file_storage ();

    $files = $fs->get_area_files ( $context->id, $component, $filearea, $iassign_statement_current->file );
    if ($files) {
     foreach ( $files as $file ) {
      if ($file->get_filename () != '.') {
       $param->filename = $file->get_filename ();
       $param->file = $file->get_id ();
       $param->fileold = $file->get_id ();
       $COURSE->iassign_file_id = $file->get_id ();
       }
      }
     }

    $iassign_ilm_configs = $DB->get_records ( 'iassign_statement_config', array('iassign_statementid' => $iassign_statement_current->id ) );
    if ($iassign_ilm_configs) {
     foreach ($iassign_ilm_configs as $iassign_ilm_config)
      $param->{'param_'.$iassign_ilm_config->iassign_ilm_configid } = $iassign_ilm_config->param_value;
     }
    } // elseif ($this->action == 'edit')
   }
  // search position
  $iassign_list = $DB->get_records_list ( 'iassign_statement', 'iassignid', array ($this->iassign->id ), 'position ASC' );

  if ($iassign_list) {
   $end_list = array_pop ( $iassign_list );
   $param->position = $end_list->position + 1;
   }   // if ($iassign_list)
  else
   $param->position = 1;

  $mform = new mod_iassign_form ();
  $mform->set_data ( $param );

  if ($mform->is_cancelled ()) {
   $this->return_home_course ( 'iassign_cancel' );
   exit;
   } else if ($result = $mform->get_data ()) {



   $result->context = $context;

   if ($result->type_iassign == 1 or $result->type_iassign == 2)
    $result->grade = 0;
   if ($result->type_iassign == 1) {
    $result->automatic_evaluate = 0;
    $result->show_answer = 0;
    } elseif ($result->automatic_evaluate == 0)
    $result->show_answer = 0;

    // $result->iassign_list = $_POST['iassign_list'];
    // $result_assign_list = $_GET['iassign_list'];

   $result->iassign_list = optional_param_array ( 'iassign_list', array (), PARAM_RAW );
   if ($result->iassign_list) {
    foreach ( $result->iassign_list as $key => $value )
     $result->dependency .= $key . ';';
    }    // if ($result_assign_list)
   else
    $result->dependency = 0;

   $iassign_ilm = $DB->get_record ( "iassign_ilm", array ("id" => $result->iassign_ilmid ) );

   if ($this->action == 'add') {
    $iassign_statement_name = $DB->get_records_sql ( "SELECT *
                             FROM {$CFG->prefix }iassign_statement s
                             WHERE s.iassignid = '$result->iassignid'
                             AND s.name = '$result->name'" );
    if ($iassign_statement_name) {
     $this->return_home_course ( 'error_iassign_name' );
     die ();
     }

    $iassignid = $this->activity->new_iassign ( $result );

    $this->activity->add_calendar ( $iassignid );
    add_to_log ( $this->course->id, "iassign", "add", "view.php?id=$id", $result->name, $this->cm->id, $USER->id );
    $this->return_home_course ( 'iassign_add' );
    }    // if ($this->action == 'add')
   elseif ($this->action == 'edit') {

    $iassignid = $this->activity->update_iassign ( $result );
    $this->activity->update_calendar ( $iassignid, $result->oldname );

    add_to_log ( $this->course->id, "iassign", "update", "view.php?id=$id", $result->name, $this->cm->id, $USER->id );
    $this->return_home_course ( 'iassign_update' );
    } // elseif ($this->action == 'edit')

   die ();
   } // elseif ($mform->get_data())

  echo $OUTPUT->header ();

  $mform->display ();

  echo $OUTPUT->footer ();

  die ();
  }

 /**
  * Search dependency
  */
 function search_dependency($search_iassing_id, $iassign_statement) {
  global $DB, $OUTPUT;
  $dependency = "";
  if ($iassign_statement)
   foreach ( $iassign_statement as $iassign ) {
    $inter_dependency = explode ( ';', $iassign->dependency );
    if (in_array ( $search_iassing_id, $inter_dependency )) {
     $dependency .= $iassign->id . ";";
     $dependency .= $this->search_dependency ( $iassign->id, $iassign_statement );
     } // if (in_array($search_iassing_id, $inter_dependency))
    } // foreach ($iassign_statement as $iassign)
  return $dependency;
   }

 /**
  * Search subdependency
  */
 function search_sub_dependency($search_iassing_id) {
  global $DB, $OUTPUT;

  // $iassign_statement = $DB->get_record('iassign_statement', 'id', $search_iassing_id);
  $iassign_statement = $DB->get_record ( "iassign_statement", array ("id" => $search_iassing_id ) );

  $dependency = "";
  if ($iassign_statement) {
   $inter_dependency = explode ( ';', $iassign_statement->dependency );

   foreach ( $inter_dependency as $tmp ) {
    if ($tmp != 0)
     $dependency .= $tmp . ";";
    $dependency .= $this->search_sub_dependency ( $tmp );
    } // foreach ($inter_dependency as $tmp)
   } // if ($iassign_statement)
  return $dependency;
   }

 /**
  * Update grade of iAssign
  */
 static function update_grade_iassign($iassignid) {
  global $USER, $CFG, $COURSE, $DB, $OUTPUT;
  require_once ($CFG->libdir . '/gradelib.php');
  $sum_grade = $DB->get_records_sql ( "SELECT SUM(grade) as total
                             FROM {$CFG->prefix }iassign_statement s
                             WHERE s.iassignid = '$iassignid'
                             AND s.type_iassign=3" );

  $grade_iassign = $DB->get_record ( "iassign", array ("id" => $iassignid ) );
  $grades = NULL;
  $params = array ('itemname' => $grade_iassign->name );
  $params ['iteminstance'] = $iassignid;
  $params ['gradetype'] = GRADE_TYPE_VALUE;
  if (key ( $sum_grade )) {
   $params ['grademax'] = key ( $sum_grade );
   $params ['rawgrademax'] = key ( $sum_grade );
   } else {
   $params ['grademax'] = 0;
   $params ['rawgrademax'] = 0;
   }
  $params ['grademin'] = 0;
  grade_update ( 'mod/iassign', $grade_iassign->course, 'mod', 'iassign', $iassignid, 0, $grades, $params );
   }

 /**
  * Update grade of student
  */
 function update_grade_student($userid, $iassign_statementid, $iassignid) {
  global $CFG, $DB, $OUTPUT;
  require_once ($CFG->libdir . '/gradelib.php');
  $grade_iassign = $DB->get_record ( 'iassign', array ('id' => $iassignid ) );
  $grade_iassign_statements = $DB->get_records ( 'iassign_statement', array ('iassignid' => $iassignid ) );
  $total_grade = 0;

  foreach ( $grade_iassign_statements as $grade_iassign_statement ) {
   $iassign_submission = $DB->get_record ( 'iassign_submission', array ('iassign_statementid' => $grade_iassign_statement->id,'userid' => $userid ) );
   if ($iassign_submission)
    $total_grade += $iassign_submission->grade;
   } // foreach ($grade_iassign_statements as $grade_iassign_statement)
  $sum_grade = $DB->get_records_sql ( "SELECT SUM(grade) as total
                             FROM {$CFG->prefix }iassign_statement s
                             WHERE s.iassignid = '$iassignid'
                             AND s.type_iassign=3" );

  $grades ['userid'] = $userid;
  $grades ['rawgrade'] = $total_grade;
  $params = array ('itemname' => $grade_iassign->name );
  $params ['iteminstance'] = $iassignid;
  $params ['gradetype'] = GRADE_TYPE_VALUE;

  if (key ( $sum_grade )) {
   $params ['grademax'] = key ( $sum_grade );
   $params ['rawgrademax'] = key ( $sum_grade );
   } else {
   $params ['grademax'] = 0;
   $params ['rawgrademax'] = 0;
   }
  grade_update ( 'mod/iassign', $grade_iassign->course, 'mod', 'iassign', $iassignid, 0, $grades, $params );
   }

 /**
  * Display caption of icons
  */
 function view_legend_icons() {
  global $USER, $CFG, $DB, $OUTPUT;
  $id = $this->cm->id;

  if ($this->action == 'print')
   echo '<table border=1 width=100%><tr>';
  else
   echo '<table width=100%><tr>';
  echo '<td >';
  if ($this->action != 'print')
   echo $OUTPUT->help_icon ( 'legend', 'iassign' );

   // helpbutton('legend', get_string('legend', 'iassign'), 'iassign', $image = true, $linktext = false, $text = '', $return = false,
   // $imagetext = '');
  echo '<strong>' . get_string ( 'legend', 'iassign' ) . '</strong>';
  echo '&nbsp;' . icons::insert ( 'correct' ) . '&nbsp;' . get_string ( 'correct', 'iassign' );
  echo '&nbsp;' . icons::insert ( 'incorrect' ) . '&nbsp;' . get_string ( 'incorrect', 'iassign' );
  echo '&nbsp;' . icons::insert ( 'post' ) . '&nbsp;' . get_string ( 'post', 'iassign' );
  echo '&nbsp;' . icons::insert ( 'not_post' ) . '&nbsp;' . get_string ( 'not_post', 'iassign' );
  echo '&nbsp;' . icons::insert ( 'comment_unread' ) . '&nbsp;' . get_string ( 'comment_unread', 'iassign' );

  if (has_capability ( 'mod/iassign:viewreport', $this->context, $USER->id ) && $this->action == 'report') {
   echo '&nbsp;' . icons::insert ( 'comment_read' ) . '&nbsp;' . get_string ( 'comment_read', 'iassign' );
   echo '</td>' . "\n";
   if ($this->action != 'print') {
    $link_print = "<a href='" . $CFG->wwwroot . "/mod/iassign/view.php?id=" . $id . "&action=print&iassignid=" . $this->iassign->id . "'>" . icons::insert ( 'print' ) . '&nbsp;' . get_string ( 'print', 'iassign' ) . "</a>";
    $link_stats = "<a href='" . $CFG->wwwroot . "/mod/iassign/view.php?id=" . $id . "&action=stats&iassignid=" . $this->iassign->id . "'>" . icons::insert ( 'results' ) . '&nbsp;' . get_string ( 'graphic', 'iassign' ) . "</a>";
    echo '<td width=15% align="right">' . $link_stats . '</td>' . "\n";
    echo '<td width=15% align="right">' . $link_print . '</td>' . "\n";
    } // if ($this->action != 'print')
   echo '</tr></table>' . "\n";
   }   // if (has_capability('mod/iassign:viewreport', $this->context, $USER->id) and $this->action == 'report')
  elseif (has_capability ( 'mod/iassign:submitiassign', $this->context, $USER->id )) {
   $link_stats = "<a href='" . $CFG->wwwroot . "/mod/iassign/view.php?id=" . $id . "&action=stats_student&iassignid=" . $this->iassign->id . "'>" . icons::insert ( 'results' ) . '&nbsp;' . get_string ( 'results', 'iassign' ) . "</a>";
   echo '<td width=15% align="right">' . $link_stats . '</td>' . "\n";
   echo '</tr></table>' . "\n";
   }   // elseif (has_capability('mod/iassign:submitiassign', $this->context, $USER->id))
  else
   echo '</td></tr></table>' . "\n";
   }

 /**
  * Display activity current
  */
 function view_iassign_current() {
  global $USER, $CFG, $COURSE, $DB, $OUTPUT;
  $id = $this->cm->id;
  $iassignid = $this->iassign->id;

  // search data of current activity
  $iassign_statement = $this->activity->get_activity (); // search data of current activity
  $ilm = new ilm ( $iassign_statement->iassign_ilmid );
  $iassign = $DB->get_record ( "iassign", array ("id" => $iassignid ) );

  // log record
  $info = $iassign->name . ":" . $iassign_statement->name;
  add_to_log ( $this->course->id, "iassign", "view", "view.php?id={$this->cm->id }", $info, $this->cm->id, $USER->id );

  echo $OUTPUT->header ();

  // Search of iLM data used in the current activity
  $iassign_ilm = $DB->get_record ( "iassign_ilm", array ("id" => $iassign_statement->iassign_ilmid ) );

  if ($this->action == 'viewsubmission') {
   if (! empty ( $this->iassign_submission_current ) or $this->iassign_submission_current != 0)
    $iassign_submission = $DB->get_record ( "iassign_submission", array ("id" => $this->iassign_submission_current ) ); // data about activity current
   else
    $iassign_submission = $DB->get_record ( "iassign_submission", array ("iassign_statementid" => $this->activity->get_activity ()->id,"userid" => $this->userid_iassign ) ); // data about student solution
   } else {
   $iassign_submission = $DB->get_record ( "iassign_submission", array ("iassign_statementid" => $this->activity->get_activity ()->id,"userid" => $this->userid_iassign ) ); // data about student solution
  }

  if ($iassign_submission)
   $this->update_comment ( $iassign_submission->id );

  $file = $iassign_statement->file;
  $this->bottonPost = 0; // hide submit button
  $this->write_solution = 0; // disable recording solution
  $this->view_iassign = false; // disable visualization of activity
  $repeat = "";
  $last_iassign = "";
  $answer = "";
  $comment = "";

  // leo
  // TODO Verificar se o correto eh '$this->context' ou '$USER->context' como deixei
  if (($this->action != 'viewsubmission') && has_capability ( 'mod/iassign:evaluateiassign', $USER->context, $USER->id )) {

   // ---> access teacher for test

   if ($iassign_statement->type_iassign != 1) // activity of type example - not submit button for submission
    $this->bottonPost = 1;

   echo $OUTPUT->box ( '<p><strong>' . get_string ( 'area_specific_teacher', 'iassign' ) . '</strong></p>' );
   $this->activity->view_dates ();
   $USER->iassignEdit = $this->bottonPost;
   $this->activity->show_info_iassign ();

   if ($iassign_submission)
    $param_aux = "action=get_answer&iassign_submission_current=" . $iassign_submission->id . "&id=" . $id . "&iassign_current=" . $this->activity->get_activity ()->id . "&write_solution=" . $this->write_solution . "&userid_iassign=" . $USER->id;
   else
    $param_aux = "action=get_answer&id=" . $id . "&iassign_current=" . $this->activity->get_activity ()->id . "&write_solution=" . $this->write_solution . "&userid_iassign=" . $USER->id;

   $enderecoPOST = "" . $CFG->wwwroot . "/mod/iassign/view.php?" . $param_aux;
   //if ($ilm->confirms_jar ( $iassign_statement->file, $iassign_ilm->file_jar, $this->cm->id ))
    echo $OUTPUT->box ( $ilm->view_iLM ( $iassign_statement, $answer, $enderecoPOST, true ) );
   }   // if (($this->action != 'viewsubmission') && has_capability('mod/iassign:evaluateiassign', $USER->context, $USER->id))
  elseif (($this->action == 'viewsubmission') && has_capability ( 'mod/iassign:evaluateiassign', $USER->context, $USER->id )) { // teacher can evaluate
                                                                                                                             // ----> area teacher evaluate
   $row = optional_param ( 'row', 0, PARAM_INT );
   $column = optional_param ( 'column', 0, PARAM_INT );

   $link_next = icons::insert ( 'right_disable' );
   $link_previous = icons::insert ( 'left_disable' );
   $link_up = icons::insert ( 'up_disable' );
   $link_down = icons::insert ( 'down_disable' );

   // next_activity
   if ($USER->matrix_iassign [$row] [$column]->iassign_next != - 1) {
    $url_next = "view.php?action=viewsubmission&id=$id&iassign_submission_current=" . $USER->matrix_iassign [$row] [$column + 1]->iassign_submission_current . "&userid_iassign=$this->userid_iassign&iassign_current=" . $USER->matrix_iassign [$row] [$column]->iassign_next . "&view_iassign=report&row=" . ($row) . "&column=" . ($column + 1);
    $link_next = "<a href='" . $url_next . "'>" . (icons::insert ( 'next_activity' )) . "</a>";
    }
   // previous_activity
   if ($USER->matrix_iassign [$row] [$column]->iassign_previous != - 1) {
    $url_previous = "view.php?action=viewsubmission&id=$id&iassign_submission_current=" . $USER->matrix_iassign [$row] [$column - 1]->iassign_submission_current . "&userid_iassign=$this->userid_iassign&iassign_current=" . $USER->matrix_iassign [$row] [$column]->iassign_previous . "&view_iassign=report&row=" . ($row) . "&column=" . ($column - 1);
    $link_previous = "<a href='" . $url_previous . "'>" . (icons::insert ( 'previous_activity' )) . "</a>";
    }
   // previous_student
   if ($USER->matrix_iassign [$row] [$column]->user_next != - 1) {
    $url_down = "view.php?action=viewsubmission&id=$id&iassign_submission_current=" . $USER->matrix_iassign [$row + 1] [$column]->iassign_submission_current . "&userid_iassign=" . $USER->matrix_iassign [$row] [$column]->user_next . "&iassign_current=" . $this->activity->get_activity ()->id . "&view_iassign=report&row=" . ($row + 1) . "&column=" . ($column);
    $link_down = "<a href='" . $url_down . "'>" . (icons::insert ( 'previous_student' )) . "</a>";
    }
   // next_student
   if ($USER->matrix_iassign [$row] [$column]->user_previous != - 1) {
    $url_up = "view.php?action=viewsubmission&id=$id&iassign_submission_current=" . $USER->matrix_iassign [$row - 1] [$column]->iassign_submission_current . "&userid_iassign=" . $USER->matrix_iassign [$row] [$column]->user_previous . "&iassign_current=" . $this->activity->get_activity ()->id . "&view_iassign=report&row=" . ($row - 1) . "&column=" . ($column);
    $link_up = "<a href='" . $url_up . "'>" . (icons::insert ( 'next_student' )) . "</a>";
    }
   if ($iassign_submission)
    $answer = $iassign_submission->answer;
   $last_iassign = get_string ( 'last_iassign', 'iassign' );

   $user_answer = $DB->get_record ( "user", array ('id' => $this->userid_iassign ) );

   // Messages related to due date (and user role)
   $this->activity->view_dates ();

   echo $OUTPUT->box_start ();
   echo '<table width=100% border=0 valign="top"><tr>' . "\n";
   echo '<td width=80%><font color="blue"><strong>' . get_string ( 'area_available', 'iassign' ) . '</strong></font><br>' . "\n";
   echo $OUTPUT->user_picture ( $user_answer );
   echo '&nbsp;' . $user_answer->firstname . '&nbsp;' . $user_answer->lastname;
   echo '</td>' . "\n";
   echo '<td width=20% align=right>' . "\n";
   echo '<table width=50 cellpadding="0">';
   echo '<tr><td colspan=2 align=center>' . $link_up . '</td></tr>' . "\n";
   echo '<tr><td align=center>' . $link_previous . '</td>' . "\n";
   echo '<td align=center>' . $link_next . '</td></tr>' . "\n";
   echo '<td colspan=2 align=center>' . $link_down . '</td></tr>' . "\n";
   echo '</table>' . "\n";
   echo '</td></tr></table>' . "\n";
   echo $OUTPUT->box_end ();

   echo $OUTPUT->box_start ();
   echo '<table width=100% border=0 valign="top"><tr>' . "\n";
   echo '<td width=60% valign="top">' . "\n";
   echo '<strong>' . get_string ( 'proposition', 'iassign' ) . '</strong>' . "\n";
   echo '<p>' . $iassign_statement->proposition . '</p>' . "\n";

   if ($iassign_statement->automatic_evaluate == 1)
    $resp = get_string ( 'yes' );
   else
    $resp = get_string ( 'no' );
   echo '<p>' . get_string ( 'automatic_evaluate', 'iassign' ) . '&nbsp;' . $resp . '</p>' . "\n";
   if ($iassign_statement->show_answer == 1)
    $resp = get_string ( 'yes' );
   else
    $resp = get_string ( 'no' );
   echo '<p>' . get_string ( 'show_answer', 'iassign' ) . '&nbsp;' . $resp . '</p>' . "\n";
   echo '</td>';

   if ($iassign_statement->type_iassign == 3) {
    echo '<td width=40% valign="top" align="left">';
    echo '<strong>' . get_string ( 'status', 'iassign' ) . '</strong>' . "\n";

    // check status of solution sent by the student
    if ($iassign_submission) {
     switch ($iassign_submission->status) {
      case 3 :
       echo icons::insert ( 'correct' ) . '&nbsp;' . get_string ( 'correct', 'iassign' ) . '&nbsp;' . $comment;
       break;
      case 2 :
       echo icons::insert ( 'incorrect' ) . '&nbsp;' . get_string ( 'incorrect', 'iassign' ) . '&nbsp;' . $comment;
       break;
      case 1 :
       echo icons::insert ( 'post' ) . '&nbsp;' . get_string ( 'post', 'iassign' ) . '&nbsp;' . $comment;
       break;
      default :
       echo icons::insert ( 'not_post' ) . '&nbsp;' . get_string ( 'not_post', 'iassign' ) . '&nbsp;' . $comment;
       $last_iassign = get_string ( 'no_MA_POST_Archive', 'iassign' );
      } // switch ($iassign_submission->status)
     } else {
     echo icons::insert ( 'not_post' ) . '&nbsp;' . get_string ( 'not_post', 'iassign' ) . '&nbsp;' . $comment;
     $last_iassign = get_string ( 'no_MA_POST_Archive', 'iassign' );
     }

    // update_status
    if ($iassign_submission && $iassign_submission->experiment > 0) {
     $edit_status = $CFG->wwwroot . "/mod/iassign/view.php?action=edit_status&id=" . $id . "&userid_iassign=" . $this->userid_iassign . "&iassign_current=" . $this->activity->get_activity ()->id . "&iassign_submission_current=" . $this->iassign_submission_current . "&row=" . ($row) . "&column=" . ($column);

     echo "
  <script type='text/javascript'>
   //<![CDATA[
   function overwriteStatus (newstatus) {
     if (confirm('" . get_string ( 'confirm_change_situation', 'iassign' ) . "')) {
        document.formEditStatus.return_status.value=newstatus;
        document.formEditStatus.submit();
        }
     else
        document.formEditStatus.return_status.value=-1;
     }
   //]]>
   </script>";

     echo "<form name='formEditStatus' method='post' action='$edit_status' enctype='multipart/form-data'>\n";
     echo ' <font color="blue"><strong>' . get_string ( 'changeto', 'iassign' ) . "</strong></font>\n";
     echo " <select name='status' onchange= 'overwriteStatus(this.value)'>\n" . " <option value=\"3\">" . get_string ( 'correct', 'iassign' ) . "</option>\n" . " <option value=\"2\">" . get_string ( 'incorrect', 'iassign' ) . "</option>\n" . " <option value=\"1\">" . get_string ( 'post', 'iassign' ) . "</option>\n" . " <option value=\"0\">" . get_string ( 'not_post', 'iassign' ) . "</option>\n" . " <option value=\"-1\" selected>" . get_string ( 'newsituation', 'iassign' ) . "</option>\n" . " </select>\n";
     echo " <input type='hidden' name='return_status'>\n";
     echo "</form>\n";

     echo '<p><strong>' . get_string ( 'grade_student', 'iassign' ) . '</strong>&nbsp;' . $iassign_submission->grade . "</p>\n";
     echo '<p><strong>' . get_string ( 'grade_iassign', 'iassign' ) . '</strong>&nbsp;' . $iassign_statement->grade . "</p>\n";
     $edit_grade = $CFG->wwwroot . "/mod/iassign/view.php?action=edit_grade&id=" . $id . "&userid_iassign=" . $this->userid_iassign . "&iassign_current=" . $this->activity->get_activity ()->id . "&iassign_submission_current=" . $this->iassign_submission_current . "&row=" . ($row) . "&column=" . ($column);
     echo "
           <script type='text/javascript'>
           //<![CDATA[
           function overwriteGrade (newgrade,maxgrade) {
            if (newgrade<0 || newgrade>maxgrade) {
              alert('" . get_string ( 'erro_grade', 'iassign' ) . " '+maxgrade)
              document.formEditGrade.return_grade.value=-1;
              document.formEditGrade.submit();
             }
            else {
              document.formEditGrade.return_grade.value=newgrade;
              document.formEditGrade.submit();
             }
            }
           //]]>
           </script>";
     echo "<form name='formEditGrade' method='post' action='$edit_grade' enctype='multipart/form-data'>\n";
     echo ' <font color="blue"><strong>' . get_string ( 'changeto', 'iassign' ) . "</strong></font>" . "\n";
     echo " <input type='text' name='grade' size='6'>";
     echo " <input type='hidden' name='return_grade'> ";
     echo " <input type=button value='" . get_string ( 'confirm', 'iassign' ) . "' onClick = 'overwriteGrade(grade.value," . $iassign_statement->grade . ")' " . "  title='" . get_string ( 'confirm_new_grade', 'iassign' ) . "'>\n";
     echo "</form>";

     $url_answer = "" . $CFG->wwwroot . "/mod/iassign/view.php?" . "action=download_answer&iassign_submission_id=" . $iassign_submission->id. "&id=" . $id;
     echo '<p><strong>' . get_string ( 'experiment', 'iassign' ) . '</strong>&nbsp;' . $iassign_submission->experiment . ' <a href="' . $url_answer . '">' . icons::insert ( 'download_assign' ) . '</a></p>';

     echo '<p><strong>' . get_string ( 'timemodified', 'iassign' ) . '</strong>&nbsp;' . userdate ( $iassign_submission->timemodified ) . '</p>';
     $teacher = $DB->get_record ( "user", array ('id' => $iassign_submission->teacher ) );
     if ($teacher)
      echo '<p><strong>' . get_string ( 'last_modification', 'iassign' ) . '</strong>&nbsp;' . $teacher->firstname . '</p>' . "\n";
     } // if ($iassign_submission->experiment > 0)
    echo '</td>';
    } // if ($iassign_statement->type_iassign == 3)

   echo '</tr></table>';
   echo $OUTPUT->box_end ();
   $USER->iassignEdit = $this->bottonPost;

   if ($iassign_submission && $iassign_submission->experiment > 0) {

    echo $OUTPUT->box_start ();
    echo '<p><strong>' . $last_iassign . '</strong></p>';
    //if ($ilm->confirms_jar ( $iassign_statement->file, $iassign_ilm->file_jar, $this->cm->id )) {
     $enderecoPOST = "";
     echo $ilm->view_iLM ( $iassign_statement, $answer, $enderecoPOST, false );
    // } // if ($this->confirms_jar($iassign_statement->file, $iassign_ilm->file_jar))
    echo $OUTPUT->box_end ();
    } else {
    echo $OUTPUT->box ( '<p><strong>' . $last_iassign . '</strong></p>' );
    }

   if ($iassign_statement->type_iassign == 3) {
    $output = '';
    $history_comment = '';
    if ($iassign_submission) {
     $enderecoPOSTcomment = "" . $CFG->wwwroot . "/mod/iassign/view.php?id=" . $id . "&action=newcomment&iassign_current=" . $this->activity->get_activity ()->id . "&iassign_submission_current=" . $iassign_submission->id . "&userid_iassign=" . $this->userid_iassign . "&row=" . ($row) . "&column=" . ($column);
     $history_comment = $this->search_comment_submission ( $iassign_submission->id );
     } else {
     $enderecoPOSTcomment = "" . $CFG->wwwroot . "/mod/iassign/view.php?id=" . $id . "&action=newcomment&iassign_current=" . $this->activity->get_activity ()->id . "&userid_iassign=" . $this->userid_iassign . "&row=" . ($row) . "&column=" . ($column);
     }

    $output .= $OUTPUT->box_start ();

    $output .= "<center><form name='formEnvioComment' id='formEnvioComment1' method='post' action='$enderecoPOSTcomment' enctype='multipart/form-data'>\n<p>\n";
    $output .= "<textarea rows='2' cols='60' name='submission_comment'></textarea>";
    $output .= "</p><p><input type=submit value='" . get_string ( 'submit_comment', 'iassign' ) . "'\></p>\n";
    $output .= "</form></center>\n";
    if (! empty ( $history_comment )) {
     $output .= "  <table id='outlinetable' class='generaltable boxaligncenter' cellpadding='5' width='100%'> \n";
     $output .= "     <tr><th>" . get_string ( 'history_comments', 'iassign' ) . "</th></tr>";
     $output .= $history_comment;
     $output .= "</table>";
     }
    $output .= $OUTPUT->box_end ();

    echo $output;
    } // if ($iassign_statement->type_iassign == 3)
   }  // elseif (($this->action == 'viewsubmission')
  elseif (has_capability ( 'mod/iassign:submitiassign', $USER->context, $USER->id )) { // access student

   // ---> access student
   if ($iassign_statement->type_iassign == 1) {
    // // activity of type example - not submit button for submission
    $this->view_iassign = true;
    //TODO rever esta condiÃ§Ã£o para iMA que nÃ£o fazem autoavaliaÃ§Ã£o
    } elseif ($iassign_statement->type_iassign == 2 and $iassign_ilm->evaluate == 1) {
    // // activity of type test - iLM automatic evaluator - submit button for submission
    if ($iassign_statement->timeavailable < time () and $iassign_statement->timedue > time ()) { // activity within of deadline
     $this->bottonPost = 1;
     $this->view_iassign = true;
     } else
     $this->view_iassign = false;

    } elseif ($iassign_statement->type_iassign == 3) {

    // //atividade do tipo exercicio
    $this->view_iassign = true;
    if ($iassign_statement->timeavailable > time ())
     $this->view_iassign = false;
    elseif ($iassign_statement->timedue > time () or $iassign_statement->preventlate == 1) { // activity within of deadline
     $this->bottonPost = 1; // mudei aqui para deixar o botÃ£o de envio
     if ((! $iassign_submission) or $this->action == 'repeat' or ($iassign_submission and $iassign_submission->experiment < 1)) {
      $this->bottonPost = 1;
      $this->write_solution = 1;
      } else {
      $last_iassign = get_string ( 'last_iassign', 'iassign' );
      if ($iassign_submission) {
       $repeat = "<a href='view.php?action=repeat&id=" . $id . "&userid_iassign=$USER->id&iassign_current=" . $this->activity->get_activity ()->id . "&iassign_submission_current=" . $iassign_submission->id . "'>" . icons::insert ( 'repeat' ) . '&nbsp;' . get_string ( 'repeat', 'iassign' ) . "</a>";
       $answer = $iassign_submission->answer;
       } else {
       $repeat = "<a href='view.php?action=repeat&id=" . $id . "&userid_iassign=$USER->id&iassign_current=" . $this->activity->get_activity ()->id . "'>" . icons::insert ( 'repeat' ) . '&nbsp;' . get_string ( 'repeat', 'iassign' ) . "</a>";
       }
      }
     } elseif ($iassign_statement->test == 1) { // allowed to test after of deadline
     if ($this->action == 'repeat' or ($iassign_submission and $iassign_submission->experiment < 1)) {
      $this->bottonPost = 1;
      $this->write_solution = 0;
      } else {
      $last_iassign = get_string ( 'last_iassign', 'iassign' );
      if ($iassign_submission) {
       $repeat = "<a href='view.php?action=repeat&id=" . $id . "&userid_iassign=$USER->id&iassign_current=" . $this->activity->get_activity ()->id . "&iassign_submission_current=" . $iassign_submission->id . "'>" . icons::insert ( 'repeat' ) . '&nbsp;' . get_string ( 'repeat', 'iassign' ) . "</a>";
       $answer = $iassign_submission->answer;
       } else {
       $repeat = "<a href='view.php?action=repeat&id=" . $id . "&userid_iassign=$USER->id&iassign_current=" . $this->activity->get_activity ()->id . "'>" . icons::insert ( 'repeat' ) . '&nbsp;' . get_string ( 'repeat', 'iassign' ) . "</a>";
       }
      }
     }    // elseif ($iassign_statement->test == 1)
    elseif ($iassign_statement->test == 0)
     $this->view_iassign = false;
    } // elseif ($iassign_statement->type_iassign == 3)

   if ($iassign_submission)
    $param_aux = "action=get_answer&iassign_submission_current=" . $iassign_submission->id . "&id=" . $id . "&iassign_current=" . $this->activity->get_activity ()->id . "&write_solution=" . $this->write_solution . "&userid_iassign=" . $USER->id;
   else
    $param_aux = "action=get_answer&id=" . $id . "&iassign_current=" . $this->activity->get_activity ()->id . "&write_solution=" . $this->write_solution . "&userid_iassign=" . $USER->id;
   $enderecoPOST = "" . $CFG->wwwroot . "/mod/iassign/view.php?" . $param_aux;

   $this->view_legend_icons ();
   $this->activity->view_dates ();

   if ($this->view_iassign) {

    echo $OUTPUT->box_start ();

    echo '<table width=100% border=0 valign="top">' . "\n";
    echo '<tr><td width=60% valign="top">' . "\n";
    echo '<strong>' . get_string ( 'proposition', 'iassign' ) . '</strong>' . "\n";
    echo '<p>' . $iassign_statement->proposition . '</p>' . "\n";
    $flag_dependency = true;

    if ($iassign_statement->type_iassign == 3) {
     if ($iassign_statement->dependency == 0) {
      echo '<strong>' . get_string ( 'independent_activity', 'iassign' ) . '</strong>' . "\n";
      } else {
      $dependencys = explode ( ';', $iassign_statement->dependency );
      echo '<p><strong>' . get_string ( 'dependency', 'iassign' ) . '</strong></p>' . "\n";

      foreach ( $dependencys as $dependency ) {
       if ($dependency) {
        $dependencyiassign = $DB->get_record ( "iassign_statement", array ("id" => $dependency ) );
        $dependencysubmissions = $DB->get_record ( "iassign_submission", array ("iassign_statementid" => $dependencyiassign->id,'userid' => $USER->id ) );
        if ($dependencysubmissions) {
         if ($dependencysubmissions->status == 3)
          $icon = icons::insert ( 'correct' );
         elseif ($dependencysubmissions->status == 2) {
          $icon = icons::insert ( 'incorrect' );
          $flag_dependency = false;
          } elseif ($dependencysubmissions->status == 1) {
          $icon = icons::insert ( 'post' );
          $flag_dependency = false;
          } elseif ($dependencysubmissions->status == 0) {
          $icon = icons::insert ( 'not_post' );
          $flag_dependency = false;
          }
         } else {
         $icon = icons::insert ( 'not_post' );
         $flag_dependency = false;
         } // if ($dependencysubmissions)

        echo '<p>&nbsp;' . $icon . $dependencyiassign->name . '</p>' . "\n";
        } // if ($dependency)
       } // foreach ($dependencys as $dependency)
      } // if ($iassign_statement->dependency == 0)
     } // if ($iassign_statement->type_iassign == 3)

    if ($flag_dependency == false) {
     echo '<strong>' . get_string ( 'message_dependency', 'iassign' ) . '</strong>' . "\n";
     $this->view_iassign = false;
     echo '</tr></table>' . "\n";
     } else {
     $this->view_iassign = true;
     echo '</td>' . "\n";
     } // if ($flag_dependency == false)

    if ($this->view_iassign) {
     if ($iassign_statement->type_iassign == 3) { // activity is present only if exercise
                                                  // receiver=1 - message to teacher
                                                  // receiver=2 - message to student
      if ($iassign_submission) {
       $verify_message = $DB->get_record ( 'iassign_submission_comment', array ('iassign_submissionid' => $iassign_submission->id,'return_status' => 0,'receiver' => 2 ) );
       if ($verify_message)
        $comment = icons::insert ( 'comment_unread' );
       }
      echo '<td width=40% valign="top" align="left">';
      echo '<strong>' . get_string ( 'status', 'iassign' ) . '</strong>' . "\n";

      if ($iassign_statement->show_answer == 1) {

       // check status of solution sent by the student
       if ($iassign_submission) {
        switch ($iassign_submission->status) {
         case 3 :
          echo icons::insert ( 'correct' ) . '&nbsp;' . get_string ( 'correct', 'iassign' ) . '&nbsp;' . $comment;
          break;
         case 2 :
          echo icons::insert ( 'incorrect' ) . '&nbsp;' . get_string ( 'incorrect', 'iassign' ) . '&nbsp;' . $comment;
          break;
         case 1 :
          echo icons::insert ( 'post' ) . '&nbsp;' . get_string ( 'post', 'iassign' ) . '&nbsp;' . $comment;
          break;
         default :
          echo icons::insert ( 'not_post' ) . '&nbsp;' . get_string ( 'not_post', 'iassign' ) . '&nbsp;' . $comment;
          $repeat = "";
          $last_iassign = "";
         } // switch ($iassign_submission->status)
        } else {
        echo icons::insert ( 'not_post' ) . '&nbsp;' . get_string ( 'not_post', 'iassign' ) . '&nbsp;' . $comment;
        $repeat = "";
        $last_iassign = "";
        }

       if ($iassign_submission and $iassign_submission->experiment > 0) {
        echo '<p><strong>' . get_string ( 'grade_student', 'iassign' ) . ':</strong>&nbsp;' . $iassign_submission->grade;
        echo '&nbsp;&nbsp;(' . get_string ( 'grade_iassign', 'iassign' ) . ':&nbsp;' . $iassign_statement->grade . ')</p>' . "\n";

        echo '<p><strong>' . get_string ( 'experiment_student', 'iassign' ) . '</strong>&nbsp;' . $iassign_submission->experiment;

        if ($iassign_statement->max_experiment == 0)
         echo '&nbsp;&nbsp(' . get_string ( 'experiment_iassign', 'iassign' ) . '&nbsp;' . get_string ( 'ilimit', 'iassign' ) . ')</p>' . "\n";
        else {
         echo '&nbsp;&nbsp(' . get_string ( 'experiment_iassign', 'iassign' ) . '&nbsp;' . $iassign_statement->max_experiment . ')</p>' . "\n";
         if ($iassign_submission->experiment >= $iassign_statement->max_experiment) {
          $repeat = "";
          $last_iassign .= "&nbsp;<font color=red>" . get_string ( 'attempts_exhausted', 'iassign' ) . '</font>' . "\n";
          $this->bottonPost = 0;
          $this->write_solution = 0;
          } // if ($iassign_submission->experiment >= $iassign_statement->max_experiment)
         } // if ($iassign_statement->max_experiment == 0)

        echo '<p><strong>' . get_string ( 'timemodified', 'iassign' ) . '</strong>&nbsp;' . userdate ( $iassign_submission->timemodified ) . '</p>' . "\n";
        $teacher = $DB->get_record ( "user", array ('id' => $iassign_submission->teacher ) );
        if ($teacher)
         echo '<p><strong>' . get_string ( 'last_modification', 'iassign' ) . '</strong>&nbsp;' . $teacher->firstname . '</p>' . "\n"; // "
        } // if ($iassign_submission->experiment > 0)
       }       // if ($iassign_statement->show_answer==1)
      else {
       if (!$iassign_submission or $iassign_submission->status == 0) {
        echo icons::insert ( 'not_post' ) . '&nbsp;' . get_string ( 'not_post', 'iassign' ) . '&nbsp;' . $comment;
        $repeat = "";
        $last_iassign = "";
        } elseif ($iassign_submission->status == 1) {
        echo icons::insert ( 'post' ) . '&nbsp;' . get_string ( 'post', 'iassign' ) . '&nbsp;' . $comment;
        }
       }

      echo '</td>';
      } // if ($iassign_statement->type_iassign == 3)

     echo '</tr></table>' . "\n";

     // show iLM
     echo '<table width=100% border=0 valign="top">' . "\n";
     echo '<td width=80% align="left">';
     echo '<strong>' . $last_iassign . '</strong></td>' . "\n";
     echo '<td width=20% align="rigth">';
     echo $repeat;
     echo '</td></tr></table>' . "\n";
     echo $OUTPUT->box_end ();

     $output = '';

     if (! $iassign_ilm) {
      $iassign_ilm = new stdClass ();
      $iassign_ilm->file_jar = "";
      }

     $output .= $OUTPUT->box_start ();

     $USER->iassignEdit = $this->bottonPost;
     if (! $iassign_submission or $this->action == 'repeat') { // or $iassign_submission->answer==0
      $output .= $ilm->view_iLM ( $iassign_statement, $answer, $enderecoPOST, true );
      } elseif ($iassign_submission and $iassign_submission->answer == '0') {
      $answer = "";
      $output .= $ilm->view_iLM ( $iassign_statement, $answer, $enderecoPOST, true );
      } else
      $output .= $ilm->view_iLM ( $iassign_statement, $answer, $enderecoPOST, false );

     if ($iassign_statement->type_iassign == 3) {

      $history_comment = '';
      if ($iassign_submission) {
       $history_comment = $this->search_comment_submission ( $iassign_submission->id );
       }

      if (! empty ( $history_comment )) {
       $output .= "
                      <table id='outlinetable' class='generaltable boxaligncenter' cellpadding='5' width='100%'>
                      <tr><th>" . get_string ( 'history_comments', 'iassign' ) . "</th></tr>"; //
       $output .= $history_comment;
       $output .= "</table>";
       }
      $output .= "</form></center>";
      $output .= $OUTPUT->box_end ();
      echo $output;
      } else {// if ($iassign_statement->type_iassign == 3)
      $output .= $OUTPUT->box_end ();
      echo $output;
      }
     } // if ($this->view_iassign)
    } // if ($this->view_iassign)
   } else if (isguestuser()) {
   echo($OUTPUT->notification ( get_string ( 'no_permission_iassign', 'iassign' ), 'notifyproblem' ));
   echo '<table width=100% border=0 valign="top">' . "\n";
   echo '<tr><td width=60% valign="top">' . "\n";
   echo '<strong>' . get_string ( 'proposition', 'iassign' ) . '</strong>' . "\n";
   echo '<p>' . $iassign_statement->proposition . '</p>' . "\n";
   echo '</tr></table>' . "\n";
   $answer = "";
   $enderecoPOST = "";
   $output = $ilm->view_iLM ( $iassign_statement, $answer, $enderecoPOST, true );
   echo $output;
   }
    // final block 'studant'
  echo $OUTPUT->footer ();
  die ();
   }

 /**
  * Display report of performance
  */
 function report() {
  global $USER, $CFG, $DB, $OUTPUT;
  $id = $this->cm->id;
  $iassign_list = $DB->get_records_list ( 'iassign_statement', 'iassignid', array ('iassignid' => $this->iassign->id ), "position ASC" );

  if ($this->action != 'print') {
   $title = get_string ( 'report', 'iassign' );
   echo $OUTPUT->header ();
   } // if ($this->action != 'print')
  echo $OUTPUT->box_start ();

  $this->view_legend_icons ();
  echo '<p>' . get_string ( 'ps_experiment', 'iassign' ) . '</p>';
  echo '<p>' . get_string ( 'ps_comment', 'iassign' ) . '</p>';
  echo $OUTPUT->box_end ();

  if ($this->action == 'print')
   echo '<table border=1 width="100%">' . "\n";
  else
   echo '<table id="outlinetable" class="generaltable boxaligncenter" cellpadding="5" width="100%">' . "\n";
  echo '<tr><th colspan=2 class="header c1">' . utils::remove_code_message($this->iassign->name) . '</th></tr>' . "\n";
  // $num = array();
  $i = 1;
  $num = array ();

  foreach ( $iassign_list as $iassign ) {
   $test_exercise = "";
   $iassign_submission = $DB->get_records ( "iassign_submission", array ("iassign_statementid" => $iassign->id ) );
   if (($iassign_submission) && $iassign->type_iassign < 3) {
    $test_exercise = "&nbsp;<b>(" . get_string ( 'iassign_exercise', 'iassign' ) . ")</b>";
    } // if (($iassign_submission) && $iassign->type_iassign < 3)
   if ($iassign->type_iassign == 3 || ($iassign_submission)) {
    $num [$i] = new object ();
    $num [$i]->name = $iassign->name;
    $num [$i]->id = $i;
    $num [$i]->iassignid = $iassign->id;
    echo ' <tr >' . "\n";
    echo "  <td class=\"cell c1 numviews\" width=5% align='center'><strong>" . $num [$i]->id . "</strong></td>\n";
    echo "<td class=\"cell c0 actvity\">";
    echo '&nbsp;' . $num [$i]->name . '&nbsp;' . $test_exercise . "</td>";
    echo ' </tr>' . "\n";
    $i ++;
    } // if ($iassign->type_iassign == 3 || ($iassign_submission))
   } // foreach ($iassign_list as $iassign)
  echo "</table>";
  echo "<p></p>";
  if ($this->action == 'print')
   echo '<table border=1 width="100%">' . "\n";
  else
   echo '<table id="outlinetable" class="generaltable boxaligncenter" cellpadding="5" width="100%">' . "\n";
  $context = context_course::instance($this->course->id );
  if ($i > 1) {

   /*
    * $role = $DB->get_record_sql("SELECT s.id, s.shortname FROM {$CFG->prefix }role s WHERE s.shortname = 'student'");
    */
   $params = array ('shortname' => 'student' );
   $role = $DB->get_record_sql ( 'SELECT s.id, s.shortname
              FROM {role } s
              WHERE s.shortname = :shortname', $params ); // " - jed/emacs

   /*
    * $students = $DB->get_records_sql("SELECT s.userid, a.firstname, a.lastname FROM {$CFG->prefix }role_assignments s, {$CFG->prefix }user a WHERE s.contextid = '$context->id' AND s.userid = a.id AND s.roleid = '$role->id' ORDER BY `a`.`firstname` ASC,`a`.`lastname` ASC");
    */
   $params = array ('contextid' => $context->id,'roleid' => $role->id );
   $students = $DB->get_records_sql ( 'SELECT s.userid, a.firstname, a.lastname
                             FROM {role_assignments } s, {user } a
                             WHERE s.contextid = :contextid
                             AND s.userid = a.id
                             AND s.roleid = :roleid
                             ORDER BY `a`.`firstname` ASC,`a`.`lastname` ASC', $params ); // " - jed/emacs

   echo '<tr><th class="header c1">' . get_string ( 'students', 'iassign' ) . '</th>' . "\n";
   for ($j = 1; $j < $i; $j ++) {
    $sum_iassign_correct [$j] = 0;
    echo '<th class="header c1" scope="col">' . $num [$j]->id . '</th>' . "\n"; // <th class="header c1" scope="col">
    }
   echo '<th class="header c1" width=5%> ' . get_string ( 'functions', 'iassign' ) . '</th>';
   $sum_iassign = $j - 1;
   echo '</tr>' . "\n";
   $total = 0;
   $sum_student = 0;
   $comment = icons::insert ( 'comment_read' );
   $sum_comment = 0;
   $sum_correct_iassign = array ();
   $sum_correct_student = array ();

   $USER->matrix_iassign = array ();
   if ($students) {
    $w = 0;
    foreach ( $students as $tmp ) {
     $users_array [$w] = $tmp;
     $w ++;
     }

    for ($x = 0; $x < $w; $x ++) {

     echo '<tr>' . "\n";
     $sum_student ++;
     $name = $users_array [$x]->firstname . '&nbsp;' . $users_array [$x]->lastname;
     echo '  <td >' . $name . '</td>' . "\n";
     $total_student = 0;
     $tentativas = 0;

     for ($j = 1; $j < $i; $j ++) {
      $sum_comment = 0;

      $student_submissions = $DB->get_record ( "iassign_submission", array ('iassign_statementid' => $num [$j]->iassignid,'userid' => $users_array [$x]->userid ) ); // data about student solution

      echo '  <td valign="bottom" align="center">' . "\n";
      if ($student_submissions) {
       $last_solution_submission = " title=\"" . userdate ( $student_submissions->timemodified ) . "\" "; // timemodified: time of the last student solution
       $tentativas = $student_submissions->experiment;

       /*
        * $student_submissions_comment = $DB->get_record_sql("SELECT COUNT(iassign_submissionid) FROM {$CFG->prefix }ia_assign_submissions_comment WHERE iassign_submissionid = '$student_submissions->id'");
        */
       $params = array ('iassign_submissionid' => $student_submissions->id );
       $student_submissions_comment = $DB->get_record_sql ( 'SELECT COUNT(iassign_submissionid)
                           FROM {iassign_submission_comment }
                           WHERE iassign_submissionid = :iassign_submissionid', $params ); // " - jed/emacs

       if ($student_submissions_comment)
        foreach ( $student_submissions_comment as $tmp )
         $sum_comment = $tmp;

        // informations to nagevacao between activities
        // previous
       if ($j - 1 < 1 or $j == $i)
        $iassign_previous = "-1";
       else
        $iassign_previous = $num [$j - 1]->iassignid;

       if ($x - 1 < 0 or $x == $w)
        $user_previous = "-1";
       else
        $user_previous = $users_array [$x - 1]->userid;

        // next
       if ($i - 1 > $j)
        $iassign_next = $num [$j + 1]->iassignid;
       else
        $iassign_next = "-1";

       if ($w - 1 > $x)
        $user_next = $users_array [$x + 1]->userid;
       else
        $user_next = "-1";

       $position = "&row= $x&column=$j";

       $url = "" . $CFG->wwwroot . "/mod/iassign/view.php?action=viewsubmission&id=" . $id . "&iassign_submission_current=" . $student_submissions->id . "&userid_iassign=" . $users_array [$x]->userid . "&iassign_current=" . $num [$j]->iassignid . "&view_iassign=" . $this->view_iassign;
       $url .= $position;

       // receiver=1 - message to teacher
       // receiver=2 - message to student

       /*
        * $verify_message = $DB->get_record_sql("SELECT COUNT(iassign_submissionid) FROM {$CFG->prefix }ia_assign_submissions_comment WHERE iassign_submissionid = '$student_submissions->id' AND return_status='0' AND receiver='1'");
        */

       $params = array ('iassign_submissionid' => $student_submissions->id,'return_status' => '0','receiver' => '1' );
       $verify_message = $DB->get_record_sql ( 'SELECT COUNT(iassign_submissionid)
                             FROM {iassign_submission_comment }
                             WHERE iassign_submissionid = :iassign_submissionid
                             AND return_status= :return_status
                             AND receiver= :receiver', $params ); // " - jed/emacs

       if ($verify_message)
        foreach ( $verify_message as $tmp )
         $sum_verify_message = $tmp;

       if ($sum_verify_message > 0)
        $comment = icons::insert ( 'comment_unread' );
       else
        $comment = icons::insert ( 'comment_read' );

       if ($student_submissions->status == 3) {
        $sum_iassign_correct [$j] ++;
        $total_student++;
        $feedback = icons::insert ( 'correct' );
        }        // if ($student_submissions->status == 3)
       elseif ($student_submissions->status == 2) {
        $feedback = icons::insert ( 'incorrect' );
        }       // elseif ($student_submissions->status == 2)
       elseif ($student_submissions->status == 1) {
        $feedback = icons::insert ( 'post' );
        }       // elseif ($student_submissions->status == 1)
       elseif ($student_submissions->status == 0) {
        $feedback = icons::insert ( 'not_post' );
        } // elseif ($student_submissions->status == 0)

       if ($this->action != 'print') {
        echo '<table><tr>';
        if ($tentativas > 0)
         echo '<td> <a href="' . $url . '" ' . $last_solution_submission . '>' . $feedback . '</a> &nbsp;(' . $tentativas . ')</td>' . chr ( 13 );
        else
         echo '<td> <a href="' . $url . '" ' . $last_solution_submission . '>' . $feedback . '</a> </td>' . chr ( 13 );
        echo '<td> &nbsp; </td>';
        echo '</tr><tr>';
        echo '<td> &nbsp;</td>';
        if ($sum_comment > 0 && $sum_verify_message > 0)
         echo '<td>  <a href="' . $url . '"> ' . $comment . '</a> &nbsp;(' . $sum_verify_message.'/'.$sum_comment . ') </td>' . chr ( 13 );
        else if ($sum_comment > 0)
         echo '<td>  <a href="' . $url . '"> ' . $comment . '</a> &nbsp;(' . $sum_comment . ') </td>' . chr ( 13 );
        else
         echo '<td> &nbsp;</td>';
        echo '</tr></table>';
        }

       if ($this->action == 'print')
        echo $feedback . '&nbsp;(' . $tentativas . ')<br>' . $comment . '&nbsp;(' . $sum_comment . ')&nbsp;' . "\n";
       }       // if ($student_submissions)
      else {

       // informations to nagevacao between activities
       // previous
       if ($j - 1 < 1 or $j == $i)
        $iassign_previous = "-1";
       else
        $iassign_previous = $num [$j - 1]->iassignid;

       if ($x - 1 < 0 or $x == $w)
        $user_previous = "-1";
       else
        $user_previous = $users_array [$x - 1]->userid;

        // next
       if ($i - 1 > $j)
        $iassign_next = $num [$j + 1]->iassignid;
       else
        $iassign_next = "-1";

       if ($w - 1 > $x)
        $user_next = $users_array [$x + 1]->userid;
       else
        $user_next = "-1";

       $position = "&row= $x&column=$j";

       $url = "" . $CFG->wwwroot . "/mod/iassign/view.php?action=viewsubmission&id=" . $id . "&userid_iassign=" . $users_array [$x]->userid . "&iassign_current=" . $num [$j]->iassignid . "&view_iassign=" . $this->view_iassign;
       $url .= $position;
       $feedback = icons::insert ( 'not_post' );
       if ($this->action == 'print')
        echo $feedback . '&nbsp;(0)<br>' . $comment . '&nbsp;(' . $sum_comment . ')&nbsp;' . "\n";
       else {
        echo '<table><tr>';
        echo '<td> <a href="' . $url . '">' . $feedback . '</a> </td>' . chr ( 13 );
        echo '<td> &nbsp; </td>';
        echo '</tr><tr>' . chr ( 13 );
        echo '<td> &nbsp;</td>';
        if ($sum_comment > 0)
         echo '<td> <a href="' . $url . '">' . $comment . '</a> &nbsp;(' . $sum_comment . ') </td>' . chr ( 13 );
        else
         echo '<td> &nbsp;</td>';
        echo '</tr></table>';
        }
       } // else if ($student_submissions)
      $USER->matrix_iassign [$x] [$j] = new object ();
      $USER->matrix_iassign [$x] [$j]->iassign_previous = $iassign_previous;
      $USER->matrix_iassign [$x] [$j]->user_previous = $user_previous;
      $USER->matrix_iassign [$x] [$j]->iassign_next = $iassign_next;
      $USER->matrix_iassign [$x] [$j]->user_next = $user_next;

      if ($student_submissions)
       $USER->matrix_iassign [$x] [$j]->iassign_submission_current = $student_submissions->id;
      else
       $USER->matrix_iassign [$x] [$j]->iassign_submission_current = 0;
      echo '</td>' . "\n";
      } // for ($j=1; $j<$i; $j++)

     $total = $total + $total_student;
     $porcentagem = ($total_student / ($j - 1)) * 100;

     if ($tentativas != 0 && $tentativas != null) {
      $url_answer = "" . $CFG->wwwroot . "/mod/iassign/view.php?"."action=download_all_answer&iassign_id=" . $this->iassign->id. "&userid=" . $users_array [$x]->userid. "&id=" . $id;
      echo '  <td  align="center"><a href="' . $url_answer . '">' . icons::insert ( 'download_all_assign' ) . '</a></td>' . "\n";
      } else {
      echo '  <td  align="center">' . icons::insert ( 'download_all_assign_disabled' ) . '</td>' . "\n";
      }

     echo '</tr>' . "\n";
     $sum_correct_student [$sum_student] = new object ();
     $sum_correct_student [$sum_student]->name = $name;
     $sum_correct_student [$sum_student]->sum = $total_student;
     } // foreach ($students as $users_array[$x])
      //  }
    for ($i = 1; $i < $j; $i ++) {

     if (is_null ( $sum_iassign_correct [$i] ))
      $sum_iassign_correct [$i] = 0;

     $sum_correct_iassign [$i] = new object ();
     $sum_correct_iassign [$i]->sum = $sum_iassign_correct [$i];
     $sum_correct_iassign [$i]->name = $num [$i]->name;
     } // for ($i = 1; $i < $j; $i++)
       // echo '</tr></table>' . "\n";
    }
   }   // if ($i>1)
  else {
   print_string ( 'no_activity', 'iassign' );
   } // if ($i>1)
  echo "</table>";

  if ($this->action != 'print')
   echo $OUTPUT->footer ();
  die ();
   }

 /**
  * Display graphics of performance
  */
 function stats() {
  global $USER, $CFG, $DB, $OUTPUT;
  $id = $this->cm->id;
  $iassign_list = $DB->get_records_list ( 'iassign_statement', 'iassignid', array ('iassignid' => $this->iassign->id ), "position ASC" );

  if ($this->action != 'printstats')
   $title = get_string ( 'graphic', 'iassign' );

  $num = array ();
  $sum_correct_iassign = array ();
  $sum_correct_student = array ();
  $sum_student = 0;
  $i = 1;
  foreach ( $iassign_list as $iassign ) {
   $iassign_submission = $DB->get_records ( "iassign_submission", array ("iassign_statementid" => $iassign->id ) );
   if ($iassign->type_iassign == 3) { // || ($iassign_submission)
    $sum_iassign_correct [$i] = 0;

    $num [$i] = new object ();
    $num [$i]->name = $iassign->name;
    $num [$i]->id = $i;
    $num [$i]->iassignid = $iassign->id;
    $i ++;
    } // if ($iassign->type_iassign == 3)
   } // foreach ($iassign_list as $iassign)
  $sum_iassign = $i - 1;

  $context = context_course::instance($this->course->id );

  if ($i > 1) {
   /*
    * $role = $DB->get_record_sql("SELECT s.id, s.shortname FROM {$CFG->prefix }role s WHERE s.shortname = 'student'");
    */
   $params = array ('shortname' => 'student' );
   $role = $DB->get_record_sql ( 'SELECT s.id, s.shortname
              FROM {role } s
              WHERE s.shortname = :shortname', $params ); // " - jed/emacs

   /*
    * $students = $DB->get_records_sql("SELECT s.userid, a.firstname, a.lastname FROM {$CFG->prefix }role_assignments s, {$CFG->prefix }user a WHERE s.contextid = '$context->id' AND s.userid = a.id AND s.roleid = '$role->id' ORDER BY `a`.`firstname` ASC,`a`.`lastname` ASC");
    */

   $params = array ('contextid' => $context->id,'roleid' => $role->id );
   $students = $DB->get_records_sql ( 'SELECT s.userid, a.firstname, a.lastname
                             FROM {role_assignments } s, {user } a
                             WHERE s.contextid = :contextid
                             AND s.userid = a.id
                             AND s.roleid = :roleid
                             ORDER BY `a`.`firstname` ASC,`a`.`lastname` ASC', $params ); // " - jed/emacs

   $total = 0;
   $sum_student = 0;
   $j = 0;
   $sum_correct_iassign = array ();
   $sum_correct_student = array ();
   $sum_experiment = array ();
   if ($students) {
    foreach ( $students as $users ) {
     $sum_student ++;
     $name = $users->firstname . '&nbsp;' . $users->lastname;
     // rows
     $total_student = 0;

     for ($j = 1; $j < $i; $j ++) {
      $total_experiment = 0;
      $student_submissions = $DB->get_record ( "iassign_submission", array ('iassign_statementid' => $num [$j]->iassignid,'userid' => $users->userid ) ); // data about student solution

      if ($student_submissions) {
       if ($student_submissions->status == 3) {
        $sum_iassign_correct [$j] ++;
        $total_student ++;
        } // if ($student_submissions->status == 3)
       $total_experiment += $student_submissions->experiment;
       }
      $sum_experiment [$j] = $total_experiment;
      } // for ($j=1; $j<$i; $j++)

     $total = $total + $total_student;
     $sum_correct_student [$sum_student] = new object ();
     $sum_correct_student [$sum_student]->name = $name;
     $sum_correct_student [$sum_student]->sum = $total_student;
     } // foreach ($students as $users)
    }
   for ($i = 1; $i < $j; $i ++) {
    if (is_null ( $sum_iassign_correct [$i] ))
     $sum_iassign_correct [$i] = 0;
    $sum_correct_iassign [$i] = new object ();
    $sum_correct_iassign [$i]->sum = $sum_iassign_correct [$i];
    $sum_correct_iassign [$i]->name = $num [$i]->name;
    $sum_correct_iassign [$i]->experiment = $sum_experiment [$i];
    } // for ($i = 1; $i < $j; $i++)
   } // if ($i > 1)

  if ($this->action != 'printstats') {
   $title = get_string ( 'graphic', 'iassign' );
   echo $OUTPUT->header ();
   $link_report = "<a href='" . $CFG->wwwroot . "/mod/iassign/view.php?id=" . $id . "&action=report&iassignid=" . $this->iassign->id . "'>" . icons::insert ( 'view_report' ) . '&nbsp;' . get_string ( 'report', 'iassign' ) . "</a>";
   $link_print_stats = "<a href='" . $CFG->wwwroot . "/mod/iassign/view.php?id=" . $id . "&action=printstats&&iassignid=" . $this->iassign->id . "'>" . icons::insert ( 'print' ) . '&nbsp;' . get_string ( 'print', 'iassign' ) . "</a>";
   echo '<table width=100%><tr>';
   echo '<td align="right">' . $link_print_stats . '</td>' . "\n";
   echo '<td width=15% align="right">' . $link_report . '</td>';
   echo '</td></tr></table>' . "\n";

   echo "<br><br>";
   echo '<table id="outlinetable" class="generaltable boxaligncenter" cellpadding="5" width="100%">' . "\n";
   echo '<tr><th colspan=5 class="header c1">' . get_string ( 'distribution_activity', 'iassign' ) . '</th></tr>' . "\n";
   echo '<tr><td class=\'cell c0 actvity\' width=35%><strong>' . utils::remove_code_message($this->iassign->name) . '</strong></td>' . "\n";
   echo '<td class=\'cell c0 actvity\' width=35%><strong>' . get_string ( 'percentage_correct', 'iassign' ) . '</strong></td>';
   echo '<td class=\'cell c0 actvity\' width=10% align="right"><strong>' . get_string ( 'proportion_correct', 'iassign' ) . '</strong>';
   echo '<td class=\'cell c0 actvity\' width=10% align="right"><strong>' . get_string ( 'sum_experiment', 'iassign' ) . '</strong></td>';
   echo '<td class=\'cell c0 actvity\' width=10% align="right"><strong>' . get_string ( 'avg_experiment', 'iassign' ) . '</strong></td>';
   echo '</tr>' . "\n";
   $sum_correct = 0;
   if ($sum_correct_iassign) {
    foreach ( $sum_correct_iassign as $iassign ) {
     if (is_null ( $iassign->experiment ))
      $iassign->experiment = 0;
     $bar = "";
     $sum = $iassign->sum;
     $percent = ($sum / $sum_student) * 100;
     $text = number_format ( $percent, 1 ) . '%';
     $sum_correct += $sum;
     if ($sum > 0) {
      for ($i = 1; $i < $percent * 2; $i ++)
       $bar .= icons::insert ( 'hbar_blue' );
      $bar .= icons::insert ( 'hbar_blue_r' );
      } // if ($sum > 0)
     echo '<tr ><td class=\'cell c0 actvity\'width=35%>' . $iassign->name . '</td>' . "\n";
     echo '<td class=\'cell c0 actvity\' width=35%>' . $bar . '&nbsp;' . $text . '</td>';
     echo '<td class=\'cell c0 actvity\' width=10% align="right">' . $sum . '/' . $sum_student . '</td>';
     echo '<td class=\'cell c0 actvity\' width=10% align="right">' . $iassign->experiment . '</td>';
     echo '<td class=\'cell c0 actvity\' width=10% align="right">' . number_format ( $iassign->experiment / $sum_iassign, 1 ) . '</td>';
     echo '</tr>' . "\n";
     } // foreach ($sum_correct_iassign as $iassign)
    }
   echo "</table>";
   echo "<br><br>";
   echo '<table id="outlinetable" class="generaltable boxaligncenter" cellpadding="5" width="100%">' . "\n";
   echo '<tr><th colspan=3 class="header c1">' . get_string ( 'distribution_student', 'iassign' ) . '</th></tr>' . "\n";
   echo '<tr><td class=\'cell c0 actvity\' width=50%><strong>' . utils::remove_code_message($this->iassign->name) . '</strong></td>' . "\n";
   echo '<td class=\'cell c0 actvity\' width=40%><strong>' . get_string ( 'percentage_correct', 'iassign' ) . '</strong></td>';
   echo '<td class=\'cell c0 actvity\' width=10% align="right"><strong>' . get_string ( 'sum_correct', 'iassign' ) . '</strong></td>';
   echo '</tr>' . "\n";
   $sum_correct = 0;
   foreach ( $sum_correct_student as $student ) {
    $bar = "";
    $sum = $student->sum;
    $percent = ($sum / $sum_iassign) * 100;
    $text = number_format ( $percent, 1 ) . '%';
    $sum_correct += $sum;
    if ($sum > 0) {
     for ($i = 1; $i < $percent * 2; $i ++)
      $bar .= icons::insert ( 'hbar_blue' );
     $bar .= icons::insert ( 'hbar_blue_r' );
     } // if ($sum > 0)
    echo '<tr ><td class=\'cell c0 actvity\'width=50%>' . $student->name . '</td>' . "\n";
    echo '<td class=\'cell c0 actvity\' width=40%>' . $bar . '&nbsp;' . $text . '</td>';
    echo '<td class=\'cell c0 actvity\' width=10% align="right">' . $sum . '/' . $sum_iassign . '</td>';
    echo '</tr>' . "\n";
    } // foreach ($sum_correct_student as $student)
   echo "</table>";
   echo "<br><br>";

   $var = 0;
   $cv = 0;
   $dv = 0;
   $avg = 0;
   if ($sum_correct_student) {
    $avg = $sum_correct / $sum_student;
    if ($avg > 0) {
     foreach ( $sum_correct_student as $student )
      $var += pow ( $student->sum - $avg, 2 );

     $var = $var / $sum_student;
     $dv = sqrt ( $var );
     $cv = ($dv / $avg) * 100;
     }
    }

   echo '<table id="outlinetable" class="generaltable boxaligncenter" cellpadding="5" width="100%">' . "\n";
   echo '<tr><th colspan=5 class="header c1">' . get_string ( 'statistics', 'iassign' ) . '</th></tr>' . "\n";
   echo '<tr><td class=\'cell c0 actvity\' width=20% align="center"><strong>' . get_string ( 'sum_activity', 'iassign' ) . '</strong></td>';
   echo '<td class=\'cell c0 actvity\' width=20% align="center"><strong>' . get_string ( 'sum_student', 'iassign' ) . '</strong></td>';
   echo '<td class=\'cell c0 actvity\' width=20% align="center"><strong>' . get_string ( 'mean_score', 'iassign' ) . '</strong></td>';
   echo '<td class=\'cell c0 actvity\' width=20% align="center"><strong>' . get_string ( 'standard_deviation', 'iassign' ) . '</strong></td>';
   echo '<td class=\'cell c0 actvity\' width=20% align="center"><strong>' . get_string ( 'coefficient_variation', 'iassign' ) . '</strong></td></tr>';
   echo '<tr><td class=\'cell c0 actvity\' width=20% align="center">' . $sum_iassign . '</td>';
   echo '<td class=\'cell c0 actvity\' width=20% align="center">' . $sum_student . '</td>';
   echo '<td class=\'cell c0 actvity\' width=20% align="center">' . number_format ( $avg, 1 ) . '</td>';
   echo '<td class=\'cell c0 actvity\' width=20% align="center">' . number_format ( $dv, 1 ) . '</td>';
   echo '<td class=\'cell c0 actvity\' width=20% align="center">' . number_format ( $cv, 1 ) . '%</td></tr>';
   echo "</table>";

   echo $OUTPUT->footer ();
   } else {

   echo '<STYLE TYPE="text/css">
            <!--
             .boldtable
             {
             font-family:sans-serif;
             font-size:10pt;
              }
           -->
          </STYLE>'; // "

   echo '<table border=1 width=100%>' . "\n";
   echo '<tr><td colspan=3 align="center"><strong>' . get_string ( 'distribution_activity', 'iassign' ) . '</strong></td></tr>' . "\n";
   echo '<tr><td width=50%><strong>' . utils::remove_code_message($this->iassign->name) . '</strong></td>' . "\n";
   echo '<td width=40%><strong>' . get_string ( 'percentage_correct', 'iassign' ) . '</strong></td>';
   echo '<td width=10% align="right"><strong>' . get_string ( 'sum_correct', 'iassign' ) . '</strong></td>';
   echo '</tr>' . "\n";
   $sum_correct = 0;
   foreach ( $sum_correct_iassign as $iassign ) {
    $bar = "";
    $sum = $iassign->sum;
    $percent = ($sum / $sum_student) * 100;
    $text = number_format ( $percent, 1 ) . '%';
    $sum_correct += $sum;
    if ($sum > 0) {
     for ($i = 1; $i < $percent * 2; $i ++)
      $bar .= icons::insert ( 'hbar_blue' );
     $bar .= icons::insert ( 'hbar_blue_r' );
     } // if ($sum > 0)
    echo '<tr><td width=50%>' . $iassign->name . '</td>' . "\n";
    echo '<td width=40%>' . $bar . '&nbsp;' . $text . '</td>';
    echo '<td width=10% align="right">' . $sum . '/' . $sum_student . '</td>';
    echo '</tr>' . "\n";
    } // foreach ($sum_correct_iassign as $iassign)
   echo "</table>";
   echo "<br><br>";
   echo '<table border=1 class="boldtable" width=100%>' . "\n";
   echo '<tr><td colspan=3 align="center" ><strong>' . get_string ( 'distribution_student', 'iassign' ) . '</strong></td></tr>' . "\n";
   echo '<tr><td width=50%><strong>' . utils::remove_code_message($this->iassign->name) . '</strong></td>' . "\n";
   echo '<td  width=40%><strong>' . get_string ( 'percentage_correct', 'iassign' ) . '</strong></td>';
   echo '<td  width=10% align="right"><strong>' . get_string ( 'sum_correct', 'iassign' ) . '</strong></td>';
   echo '</tr>' . "\n";
   $sum_correct = 0;
   foreach ( $sum_correct_student as $student ) {
    $bar = "";
    $sum = $student->sum;
    $percent = ($sum / $sum_iassign) * 100;
    $text = number_format ( $percent, 1 ) . '%';
    $sum_correct += $sum;
    if ($sum > 0) {
     for ($i = 1; $i < $percent * 2; $i ++)
      $bar .= icons::insert ( 'hbar_blue' );
     $bar .= icons::insert ( 'hbar_blue_r' );
     } // if ($sum > 0)
    echo '<tr><td width=50%>' . $student->name . '</td>' . "\n";
    echo '<td width=40%>' . $bar . '&nbsp;' . $text . '</td>';
    echo '<td width=10% align="right">' . $sum . '/' . $sum_iassign . '</td>';
    echo '</tr>' . "\n";
    } // foreach ($sum_correct_student as $student)
   echo "</table>";
   echo "<br><br>";

   $var = 0;
   $cv = 0;
   $dv = 0;
   $avg = 0;
   if ($sum_correct_student) {
    $avg = $sum_correct / $sum_student;
    if ($avg > 0) {
     foreach ( $sum_correct_student as $student )
      $var += pow ( $student->sum - $avg, 2 );
     $var = $var / $sum_student;
     $dv = sqrt ( $var );
     $cv = ($dv / $avg) * 100;
     }
    }

   echo '<table border=1 class="boldtable" width=100%>' . "\n";
   echo '<tr><td colspan=5 align="center"><strong>' . get_string ( 'statistics', 'iassign' ) . '</strong></th></tr>' . "\n";
   echo '<tr><td width=20% align="center"><strong>' . get_string ( 'sum_activity', 'iassign' ) . '</strong></td>' . "\n";
   echo '<td  width=20% align="center"><strong>' . get_string ( 'sum_student', 'iassign' ) . '</strong></td>' . "\n";
   echo '<td  width=20% align="center"><strong>' . get_string ( 'mean_score', 'iassign' ) . '</strong></td>' . "\n";
   echo '<td  width=20% align="center"><strong>' . get_string ( 'standard_deviation', 'iassign' ) . '</strong></td>' . "\n";
   echo '<td  width=20% align="center"><strong>' . get_string ( 'coefficient_variation', 'iassign' ) . '</strong></td></tr>' . "\n";
   echo '<tr><td  width=20% align="center">' . $sum_iassign . '</td>' . "\n";
   echo '<td  width=20% align="center">' . $sum_student . '</td>' . "\n";
   echo '<td  width=20% align="center">' . number_format ( $avg, 1 ) . '</td>' . "\n";
   echo '<td  width=20% align="center">' . number_format ( $dv, 1 ) . '</td>' . "\n";
   echo '<td  width=20% align="center">' . number_format ( $cv, 1 ) . '%</td></tr>' . "\n";
   echo "</table>\n";
   } // if ($this->action != 'printstats')
  die ();
   }

 /**
  * Display graphics of performance for students
  */
 function stats_students() {
  global $USER, $CFG, $DB, $OUTPUT;
  $id = $this->cm->id;
  $iassign_statement = $DB->get_records_sql ( "SELECT *
                             FROM {$CFG->prefix }iassign_statement s
                             WHERE s.iassignid = '{$this->iassign->id }'
                             AND s.type_iassign=3
                             ORDER BY `s`.`position`" );

  $title = get_string ( 'results', 'iassign' );
  // echo $OUTPUT->header();

  $sum_correct = 0;
  $sum_incorrect = 0;
  $sum_post = 0;
  $sum_nopost = 0;
  $sum_iassign = count ( $iassign_statement );
  $bar_nopost = "";
  $bar_correct = "";
  $bar_incorrect = "";
  $bar_post = "";
  $text_nopost = "";
  $text_correct = "";
  $text_incorrect = "";

  foreach ( $iassign_statement as $iassign ) {
   $iassign_submission = $DB->get_record ( "iassign_submission", array ('iassign_statementid' => $iassign->id,'userid' => $USER->id ) ); // data about student solution
   if ($iassign_submission) {
    if ($iassign_submission->status == 3)
     $sum_correct ++;
    elseif ($iassign_submission->status == 2)
     $sum_incorrect ++;
    elseif ($iassign_submission->status == 1)
     $sum_post ++;
    elseif ($iassign_submission->status == 0 or (! $iassign_submission))
     $sum_nopost ++;
    } // if ($iassign_submission)
   } // foreach ($iassign_statement as $iassign)

  if ($sum_iassign > 0) {
   $percent_correct = ($sum_correct / $sum_iassign) * 100;
   $text_correct = number_format ( $percent_correct, 1 ) . '%';
  }

  if ($sum_correct > 0) {
   for ($i = 1; $i < $percent_correct * 2; $i ++)
    $bar_correct .= icons::insert ( 'hbar_green' );
   $bar_correct .= icons::insert ( 'hbar_green_r' );
   } // if ($sum_correct > 0)

  if ($sum_iassign > 0) {
   $percent_incorrect = ($sum_incorrect / $sum_iassign) * 100;
   $text_incorrect = number_format ( $percent_incorrect, 1 ) . '%';
  }

  if ($sum_incorrect > 0) {
   for ($i = 1; $i < $percent_incorrect * 2; $i ++)
    $bar_incorrect .= icons::insert ( 'hbar_red' );
   $bar_incorrect .= icons::insert ( 'hbar_red_r' );
   } // if ($sum_incorrect > 0)

  if ($sum_iassign > 0) {
   $percent_post = ($sum_post / $sum_iassign) * 100;
   $text_post = number_format ( $percent_post, 1 ) . '%';
   }
  if ($sum_post > 0) {
   for ($i = 1; $i < $percent_post * 2; $i ++)
    $bar_post .= icons::insert ( 'hbar_blue' );
   $bar_post .= icons::insert ( 'hbar_blue_r' );
   } // if ($sum_post > 0)

  if ($sum_iassign > 0) {
   $percent_nopost = ($sum_nopost / $sum_iassign) * 100;
   $text_nopost = number_format ( $percent_nopost, 1 ) . '%';
   }
  if ($sum_nopost > 0) {
   for ($i = 1; $i < $percent_nopost * 2; $i ++)
    $bar_nopost .= icons::insert ( 'hbar_orange' );
   $bar_nopost .= icons::insert ( 'hbar_orange_r' );
   } // if ($sum_nopost > 0)

  echo $OUTPUT->header ();
  $link_return = "&nbsp;<a href='" . $this->return . "'>" . icons::insert ( 'home' ) . get_string ( 'activities_page', 'iassign' ) . "</a>";
  echo '<table width=100%><tr>';
  echo '<td align="right">' . $link_return . '</td>' . "\n";
  echo '</td></tr></table>' . "\n";

  echo "<br><br>";
  echo '<table id="outlinetable" class="generaltable boxaligncenter" cellpadding="5" width="100%">' . "\n";

  echo '<tr><th colspan=3 class="header c1">';
  // helpbutton('legend', get_string('legend', 'iassign'), 'iassign', $image = true, $linktext = false, $text = '', $return = false,
  // $imagetext = '');
  echo utils::remove_code_message($this->iassign->name) . '</th></tr>' . "\n";

  echo '<tr ><td class=\'cell c0 actvity\'width=50%>' . get_string ( 'correct', 'iassign' ) . '</td>' . "\n";
  echo '<td class=\'cell c0 actvity\' width=40%>' . $bar_correct . '&nbsp;' . $text_correct . '</td>';
  echo '<td class=\'cell c0 actvity\' width=10% align="right">' . $sum_correct . '/' . $sum_iassign . '</td>';
  echo '</tr>' . "\n";
  echo '<tr ><td class=\'cell c0 actvity\'width=50%>' . get_string ( 'incorrect', 'iassign' ) . '</td>' . "\n";
  echo '<td class=\'cell c0 actvity\' width=40%>' . $bar_incorrect . '&nbsp;' . $text_incorrect . '</td>';
  echo '<td class=\'cell c0 actvity\' width=10% align="right">' . $sum_incorrect . '/' . $sum_iassign . '</td>';
  echo '</tr>' . "\n";
  if ($sum_post) {
   echo '<tr ><td class=\'cell c0 actvity\'width=50%>' . get_string ( 'post', 'iassign' ) . '</td>' . "\n";
   echo '<td class=\'cell c0 actvity\' width=40%>' . $bar_post . '&nbsp;' . $text_post . '</td>';
   echo '<td class=\'cell c0 actvity\' width=10% align="right">' . $sum_post . '/' . $sum_iassign . '</td>';
   echo '</tr>' . "\n";
   } // if ($sum_post)
  echo '<tr ><td class=\'cell c0 actvity\'width=50%>' . get_string ( 'not_post', 'iassign' ) . '</td>' . "\n";
  echo '<td class=\'cell c0 actvity\' width=40%>' . $bar_nopost . '&nbsp;' . $text_nopost . '</td>';
  echo '<td class=\'cell c0 actvity\' width=10% align="right">' . $sum_nopost . '/' . $sum_iassign . '</td>';
  echo '</tr>' . "\n";
  echo "</table>";
  echo "<br><br>";
  echo '<table id="outlinetable" class="generaltable boxaligncenter" cellpadding="5" width="100%">' . "\n";
  echo '<tr><th colspan=3 class="header c1">' . get_string ( 'grades', 'iassign' ) . '</th></tr>' . "\n";
  echo '<tr><td class=\'cell c0 actvity\' width=50%><strong>' . utils::remove_code_message($this->iassign->name) . '</strong></td>' . "\n";
  echo '<td class=\'cell c0 actvity\' width=25% align=right><strong>' . get_string ( 'grade_student', 'iassign' ) . '</strong></td>' . "\n";
  echo '<td class=\'cell c0 actvity\' width=25% align=right><strong>' . get_string ( 'grade_iassign', 'iassign' ) . '</strong></tr>' . "\n";

  $sum_grade = 0;
  $sum_grade_student = 0;
  $avg = 0;
  foreach ( $iassign_statement as $iassign ) {
   $iassign_submission = $DB->get_record ( "iassign_submission", array ('iassign_statementid' => $iassign->id,'userid' => $USER->id ) );
   if (! $iassign_submission) {
    $iassign_submission = new object ();
    $iassign_submission->grade = 0;
    }
   echo '<tr ><td class=\'cell c0 actvity\'width=50%>' . $iassign->name . '</td>' . "\n";
   echo '<td class=\'cell c0 actvity\' width=25% align=right>' . $iassign_submission->grade . '</td>';
   echo '<td class=\'cell c0 actvity\' width=25% align=right>' . $iassign->grade . '</td>';
   echo '</tr>' . "\n";

   $sum_grade += $iassign->grade;
   $sum_grade_student += $iassign_submission->grade;
   } // foreach ($iassign_statement as $iassign)
  if ($sum_grade > 0)
   $avg = $sum_grade_student / $sum_grade * 100;

  echo '<tr><td class=\'cell c0 actvity\' width=50%><strong>' . get_string ( 'total', 'iassign' ) . '</strong></td>' . "\n";
  echo '<td class=\'cell c0 actvity\' width=25% align=right><strong>' . $sum_grade_student . '</strong></td>' . "\n";
  echo '<td class=\'cell c0 actvity\' width=25% align=right><strong>' . $sum_grade . '</strong></tr>' . "\n";
  echo '<tr><td class=\'cell c0 actvity\' width=25% align=left><strong>' . get_string ( 'percentage_correct', 'iassign' ) . '</strong></td>' . "\n";
  echo '<td colspan=2 class=\'cell c0 actvity\' align=right><strong>' . number_format ( $avg, 1 ) . '%</strong></tr>' . "\n";
  echo "</table>";

  echo $OUTPUT->footer ();
  die ();
   }

 /**
  * Display page of iAssigns
  */
 function view_iassigns() {
  global $USER, $CFG, $COURSE, $DB, $OUTPUT;
  $id = $this->cm->id;

  $iassign_list = $DB->get_records_list ( 'iassign_statement', 'iassignid', array ('iassignid' => $this->iassign->id ), 'position ASC' );

  $notice= optional_param('notice', '', PARAM_TEXT);
  if (strpos($notice, 'error'))
   echo($OUTPUT->notification(get_string ( $notice, 'iassign' ), 'notifyproblem'));
  else if ($notice != '')
   echo($OUTPUT->notification(get_string ( $notice, 'iassign' ), 'notifysuccess'));

  echo $OUTPUT->box_start ();

  echo '<table width=100% border=0><tr>' . "\n";
  $url_help = new moodle_url ( '/mod/iassign/settings_ilm.php', array ('action' => 'list','ilm_id' => 1 ) );
  $action_help = new popup_action ( 'click', $url_help, 'iplookup', array ('title' => get_string ( 'help_ilm', 'iassign' ),'width' => 1200,'height' => 700 ) );

  $link_help = $OUTPUT->action_link ( $url_help, icons::insert ( 'help_ilm' ) . get_string ( 'help_ilm', 'iassign' ), $action_help );
  $link_add = "<a href='" . $CFG->wwwroot . "/mod/iassign/view.php?id=" . $id . "&action=add&iassignid=" . $this->iassign->id . "'>" . icons::insert ( 'add_iassign' ) . get_string ( 'add_iassign', 'iassign' ) . "</a>";
  $link_report = "<a href='" . $CFG->wwwroot . "/mod/iassign/view.php?id=" . $id . "&action=report&iassignid=" . $this->iassign->id . "'>" . icons::insert ( 'view_report' ) . get_string ( 'report', 'iassign' ) . "</a>";

  // TODO: esta consulta esta sendo feita novamente na linha +/- 2258
  if (has_capability ( 'mod/iassign:viewiassignall', $this->context, $USER->id )) { // could be "has_capability('mod/iassign:viewiassignall', $this->context, $USER->id)"
                                                                                 // Has capability to see "report": teacher or up
   echo '<td width=10% align="left">' . "\n";
   echo $link_help;
   echo '</td>' . "\n";
   echo '<td width=10% align="left">' . "\n";
   echo $link_report;
   echo '</td>' . "\n";
   } // if (has_capability('mod/iassign:viewiassignall', $this->context, $USER->id))
  if (has_capability ( 'mod/iassign:editiassign', $this->context, $USER->id )) {
   echo '<td width=15% align="left">' . "\n";
   echo $link_add;
   echo "</td>\n";
   } // if (has_capability('mod/iassign:editiassign', $this->context, $USER->id))
  if (has_capability ( 'mod/iassign:editiassign', $this->context, $USER->id )) {
   if ($iassign_list) {
    echo '<td align="right">' . "\n";

    // $USER->iassignEdit == 0 view 'Turn editing off'
    // $USER->iassignEdit == 1 view 'Turn editing on'
    if (! isset ( $USER->iassignEdit ))
     $USER->iassignEdit = 0;

    if ($USER->iassignEdit == 0) {
     $bottonEdit_message = get_string ( 'turneditingon', 'iassign' );
     $botton = 1;
     }     // if ($USER->iassignEdit == 0)
    elseif ($USER->iassignEdit == 1) {
     $bottonEdit_message = get_string ( 'turneditingoff', 'iassign' );
     $botton = 0;
     } // elseif ($USER->iassignEdit == 1)
    $editPost = "" . $CFG->wwwroot . "/mod/iassign/view.php?id=" . $id . "&botton=" . $botton;
    echo "\n<form name='formEditPost' id='formEditPost' method='post' action='$editPost' enctype='multipart/form-data'>\n";
    echo " <input type=submit value='$bottonEdit_message'/>\n";
    echo "</form>\n";
    echo "</td>\n";
    } // if ($iassign_list)
   }
  echo '</tr></table>' . "\n";

  if (has_capability ( 'mod/iassign:submitiassign', $this->context, $USER->id ))
   $this->view_legend_icons ();

  echo $OUTPUT->box_end ();

  $iassign_array_exercise = array ();
  $i_exercise = 0;
  $iassign_array_test = array ();
  $i_test = 0;
  $iassign_array_example = array ();
  $i_example = 0;
  $iassign_array_general = array ();
  $i_general = 0;

  if ($iassign_list) {

   if ($this->iassign->activity_group == 0) {
    // if ($iassign_list) {
    foreach ( $iassign_list as $iassign ) {
     $iassign_array_general [$i_general] = $iassign;
     $i_general ++;
     } // foreach ($iassign_list as $iassign)
       //  }
    }    // if ($this->iassign->activity_group == 0)
   else {

    // if ($iassign_list) {
    foreach ( $iassign_list as $iassign ) {
     if ($iassign->type_iassign == 3) {
      $iassign_array_exercise [$i_exercise] = $iassign;
      $i_exercise ++;
      } // if ($iassign->type_iassign == 3)
     if ($iassign->type_iassign == 2) {
      $iassign_array_test [$i_test] = $iassign;
      $i_test ++;
      } // if ($iassign->type_iassign == 2)
     if ($iassign->type_iassign == 1) {
      $iassign_array_example [$i_example] = $iassign;
      $i_example ++;
      } // if ($iassign->type_iassign == 1)
     } // foreach ($iassign_list as $iassign)
       //  }
    }

   if ($iassign_array_exercise) {
    $title = get_string ( 'exercise', 'iassign' );
    $this->show_iassign ( $title, $iassign_array_exercise, $i_exercise );
    } // if ($iassign_array_exercise)
   if ($iassign_array_test) {
    $title = get_string ( 'test', 'iassign' );
    $this->show_iassign ( $title, $iassign_array_test, $i_test );
    } // if ($iassign_array_test)
   if ($iassign_array_example) {
    $title = get_string ( 'example', 'iassign' );
    $this->show_iassign ( $title, $iassign_array_example, $i_example );
    } // if ($iassign_array_example)
   if ($iassign_array_general) {
    $title = "";
    $this->show_iassign ( $title, $iassign_array_general, $i_general );
    } // if ($iassign_array_general)
   } else {
   echo $OUTPUT->notification ( get_string ( 'no_activity', 'iassign' ), 'notifysuccess' );
   }
  if (count ( $iassign_list ) > 5 and ! (has_capability ( 'mod/iassign:submitiassign', $this->context, $USER->id ))) {
   if (has_capability ( 'mod/iassign:viewiassignall', $this->context, $USER->id )) {
    echo $OUTPUT->box_start ();
    echo '<table width=100% border=0><tr>' . "\n";
    echo '<td width=10% align="left">' . "\n";
    echo $link_report;
    echo '</td>' . "\n";
    echo '</tr></table>' . "\n";
    echo $OUTPUT->box_end ();
    } // if (has_capability('mod/iassign:viewiassignall', $this->context, $USER->id))
   if (has_capability ( 'mod/iassign:editiassign', $this->context, $USER->id )) {
    echo $OUTPUT->box_start ();
    echo '<table width=100% border=0><tr>' . "\n";
    echo '<td align="left">' . "\n";
    echo $link_add;
    echo '</td>' . "\n";
    echo '</tr></table>' . "\n";
    echo $OUTPUT->box_end ();
    } // if (has_capability('mod/iassign:editiassign', $this->context, $USER->id))
   } // if (count($iassign_list) > 5 and !(has_capability('mod/iassign:submitiassign', $this->context, $USER->id)))
   }

 /**
  * Display all iAssigns
  */
 function show_iassign($title, $iassign_array, $i) {
  global $USER, $CFG, $DB, $OUTPUT;

  $id = $this->cm->id;
  echo $OUTPUT->box_start ();
  if (has_capability ( 'mod/iassign:viewiassignall', $this->context, $USER->id )) {
   echo "<p><font color='#0000aa'><strong>" . $title . "</strong></font></p>";
   for ($j = 0; $j < $i; $j ++) {
    $iassign_current = $iassign_array [$j]->id;

    // receiver=1 - message to teacher
    // receiver=2 - message to student
    $sum_comment = 0;
    $iassign_submissions = $DB->get_records ( 'iassign_submission', array ('iassign_statementid' => $iassign_current ) );
    foreach($iassign_submissions as $iassign_submission) {
     $params = array ('iassign_submissionid' => $iassign_submission->id,'return_status' => '0','receiver' => '1' );
     $verify_message = $DB->get_record_sql ( 'SELECT COUNT(iassign_submissionid)
                              FROM {iassign_submission_comment }
                              WHERE iassign_submissionid = :iassign_submissionid
                              AND return_status= :return_status
                              AND receiver= :receiver', $params );
     if ($verify_message)
      foreach ( $verify_message as $tmp )
       $sum_comment += $tmp;
     }
    if ($sum_comment == 0)
     $comment_unread = "";
    else {
     $comment_unread_message = get_string ( 'comment_unread', 'iassign' );
     if ($sum_comment == 1)
      $comment_unread_message = get_string ( 'comment_unread_one', 'iassign' );
     $comment_unread = "&nbsp;<a href='" . $CFG->wwwroot . "/mod/iassign/view.php?id=" . $id . "&action=report&iassignid=" . $this->iassign->id . "'><font color='red'>" . icons::insert ( 'comment_unread' ) ."&nbsp;($sum_comment&nbsp;". $comment_unread_message . ")</font></a>";
     }

    if ($j == $i - 1)
     $iassign_down = $iassign_array [$j]->id;
    else
     $iassign_down = $iassign_array [$j + 1]->id;
    if ($j > 0)
     $iassign_up = $iassign_array [$j - 1]->id;
    else
     $iassign_up = $iassign_array [$j]->id;
    if ($iassign_array [$j]->visible == 0)
     $links = "&nbsp;<a href='view.php?id=$id&userid_iassign=$USER->id&action=view&iassign_current=$iassign_current'><font color='#bbbbbb'>" . $iassign_array [$j]->name . "</font></a>";
    else
     $links = "&nbsp;<a href='view.php?id=$id&userid_iassign=$USER->id&action=view&iassign_current=$iassign_current'>" . $iassign_array [$j]->name . "</a>";
    $links .= $comment_unread;
    if (has_capability ( 'mod/iassign:editiassign', $this->context, $USER->id ) and $USER->iassignEdit == 1) {
     $aux = "&id=$id&iassign_current=$iassign_current&iassign_up=$iassign_up&iassign_down=$iassign_down&iassign_ilmid=".$iassign_array [$j]->iassign_ilmid;
     $link_up = "&nbsp;<a href='view.php?action=up$aux'>" . icons::insert ( 'move_up_iassign' ) . "</a>";
     $link_down = "&nbsp;<a href='view.php?action=down$aux'>" . icons::insert ( 'move_down_iassign' ) . "</a>";
     $link_delete = "&nbsp;<a href='view.php?action=delete$aux'>" . icons::insert ( 'delete_iassign' ) . "</a>";
     $link_visible_hide = "&nbsp;<a href='view.php?action=visible$aux'>" . icons::insert ( 'hide_iassign' ) . "</a>";
     $link_visible_show = "&nbsp;<a href='view.php?action=visible$aux'>" . icons::insert ( 'show_iassign' ) . "</a>";
     $link_edit = "&nbsp;<a href='view.php?action=edit$aux'>" . icons::insert ( 'edit_iassign' ) . "</a>";
     if (count ( $iassign_array ) > 1) {
      if ($j == 0)
       $links .= $link_down;
      elseif ($j == $i - 1)
       $links .= $link_up;
      else
       $links .= $link_up . $link_down;
      } // if (count($iassign_array) > 1)
     $links .= $link_edit . $link_delete;

     if ($iassign_array [$j]->visible == 0)
      $links .= $link_visible_show;
     else
      $links .= $link_visible_hide;
     } // if ($USER->iassignEdit == 1 && has_capability('mod/iassign:editiassign', $this->context, $USER->id))

    echo '<p>' . $links . '</p>' . "\n";
    }
   }   // if (has_capability('mod/iassign:viewiassignall', $this->context, $USER->id))
  elseif (has_capability ( 'mod/iassign:submitiassign', $this->context, $USER->id )) { // student
   echo '<table width=100% ><tr>' . "\n";
   echo "<td width=70% align='left'><font color='#0000aa'><strong>" . $title . "</strong></font></td>" . "\n";
   echo '</tr></table>' . "\n";

   for ($j = 0; $j < $i; $j ++) {
    $icon_status = "";
    $icon_comment = "";
    if ($iassign_array [$j]->visible == 1) {
     $iassign_current = $iassign_array [$j]->id;
     $iassign_submission = $DB->get_record ( 'iassign_submission', array ('iassign_statementid' => $iassign_current,'userid' => $USER->id ) );
     $links = "&nbsp;<a href='view.php?id=$id&userid_iassign=$USER->id&action=view&iassign_current=$iassign_current'>" . $iassign_array [$j]->name . "</a>";
     $icon_status = "";
     $icon_comment = "";
     if ($iassign_submission) {

      // receiver=1 - message to teacher
      // receiver=2 - message to student

      /*
       * $verify_message = $DB->get_record_sql("SELECT COUNT(iassign_submissionid) FROM {$CFG->prefix }ia_assign_submissions_comment WHERE iassign_submissionid = '$iassign_submission->id' and return_status= 0 and receiver=2");
       */

      $params = array ('iassign_submissionid' => $iassign_submission->id,'return_status' => '0','receiver' => '2' );
      $verify_message = $DB->get_record_sql ( 'SELECT COUNT(iassign_submissionid)
                             FROM {iassign_submission_comment }
                             WHERE iassign_submissionid = :iassign_submissionid
                             AND return_status= :return_status
                             AND receiver= :receiver', $params ); // " - jed/emacs

      if ($verify_message)
       foreach ( $verify_message as $tmp )
        $sum_comment = $tmp;

      if ($sum_comment > 0) {
       $comment_unread_message = get_string ( 'comment_unread', 'iassign' );
       if ($sum_comment == 1)
        $comment_unread_message = get_string ( 'comment_unread_one', 'iassign' );
       $icon_comment = "&nbsp;<font color='red'>" . icons::insert ( 'comment_unread' ) ."&nbsp;($sum_comment&nbsp;". $comment_unread_message . ")</font>";
       }
       //$icon_comment = icons::insert ( 'comment_unread' );

      if ($iassign_array [$j]->type_iassign == 3) {
       if ($iassign_array [$j]->show_answer == 1) {
        if ($iassign_submission->status == 3)
         $icon_status = icons::insert ( 'correct' );
        elseif ($iassign_submission->status == 2)
         $icon_status = icons::insert ( 'incorrect' );
        elseif ($iassign_submission->status == 1)
         $icon_status = icons::insert ( 'post' );
        elseif ($iassign_submission->status == 0)
         $icon_status = icons::insert ( 'not_post' );
        }        // if ($iassign_array[$j]->show_answer==1)
       else {
        if ($iassign_submission->status == 0)
         $icon_status = icons::insert ( 'not_post' );
        else
         $icon_status = icons::insert ( 'post' );
        }
       } // if ($iassign_array[$j]->type_iassign == 3)
      }      // if ($iassign_submission)
     elseif ($iassign_array [$j]->type_iassign == 3) {
      $icon_status = icons::insert ( 'not_post' );
      } // if ($iassign_array[$j]->type_iassign == 3)
     echo '<p>' . $icon_status . '&nbsp;' . $links . '&nbsp;' . $icon_comment . '</p>' . "\n";
     } // if ($iassign_array[$j]->visible == 1)
    } // for ($j = 0; $j < $i; $j++)
   } else if (isguestuser()) {
   echo($OUTPUT->notification ( get_string ( 'no_permission_iassign', 'iassign' ), 'notifyproblem' ));
   echo '<table width=100% ><tr>' . "\n";
   echo "<td width=70% align='left'><font color='#0000aa'><strong>" . $title . "</strong></font></td>" . "\n";
   echo '</tr></table>' . "\n";

   for ($j = 0; $j < $i; $j ++) {
    $icon_status = "";
    $icon_comment = "";
    if ($iassign_array [$j]->visible == 1) {
     $iassign_current = $iassign_array [$j]->id;
     $links = "&nbsp;<a href='view.php?id=$id&userid_iassign=$USER->id&action=view&iassign_current=$iassign_current'>" . $iassign_array [$j]->name . "</a>";
     echo '<p>' . $links . '</p>' . "\n";
     } // if ($iassign_array[$j]->visible == 1)
    }
   }
  echo $OUTPUT->box_end ();
   }

 // show_iassign($title, $iassign_array, $i)

 /**
  * Show message of return
  */
 function return_home_course($message) {
//   global $DB, $OUTPUT;
//   $link_return = "&nbsp;<a href='" . $this->return . "'>" . icons::insert ( 'home' ) . get_string ( 'activities_page', 'iassign' ) . "</a>";
//   echo $OUTPUT->box_start ();
//   echo '<table width=100% border=0 valign="top">' . "\n";
//   echo '<tr><td align="left"><strong>' . "\n";
//   print_string ( $message, 'iassign' );
//   echo '</strong></td>' . "\n";
//   echo '<td width=20% align="right">' . "\n";
//   echo $link_return;
//   echo '</td></tr></table>' . "\n";
//   echo $OUTPUT->box_end ();
//   // echo $OUTPUT->footer();
  redirect ( new moodle_url ( $this->return.'&notice='.$message ) );
  exit;
   }

 /**
  * Search comment of activity
  */
 function search_comment_submission($iassign_submissionid) {
  global $USER, $DB, $OUTPUT, $COURSE;
  $context = context_course::instance($COURSE->id );

  $comments = $DB->get_records_list ( 'iassign_submission_comment', 'iassign_submissionid', array ('iassign_submissionid' => $iassign_submissionid ), 'timecreated DESC' ); // 'ORDER BY "timecreated" ASC'
  $text = "";
  if ($comments) {

   foreach ( $comments as $tmp ) {
    $user_answer = $DB->get_record ( "user", array ('id' => $tmp->comment_authorid ) );
    if (has_capability ( 'mod/iassign:editiassign', $context, $tmp->comment_authorid )) {
     $text .= "<tr><td bgcolor='#fee7ae'><b> $user_answer->firstname</b>&nbsp;(" . userdate ( $tmp->timecreated ) . "</br>";
     $text .= "$tmp->comment</td></tr>";
     } else {
     $text .= "<tr><td bgcolor='#dce7ec'>&raquo;<b> $user_answer->firstname</b>&nbsp;(" . userdate ( $tmp->timecreated ) . "</br>";
     $text .= "$tmp->comment</td></tr>";
     }
    } // foreach ($comments as $tmp)
   }
  return $text;
   }

 /**
  * Update comment of activity
  */
 function update_comment($iassign_submissionid) {
  global $USER, $DB, $OUTPUT;
  if (! has_capability ( 'mod/iassign:submitiassign', $this->context, $USER->id ) or is_siteadmin())
   $receiver = 1; // student message to teacher
  else
   $receiver = 2; // teacher message to student

  $verify_message = $DB->get_records ( 'iassign_submission_comment', array ('iassign_submissionid' => $iassign_submissionid ) ); //

  if ($verify_message) {
   foreach ( $verify_message as $message ) {
    if ($message->receiver == $receiver) {
     $newentry = new stdClass ();
     $newentry->id = $message->id;
     $newentry->return_status = 1;
     if (! $DB->update_record ( 'iassign_submission_comment', $newentry )) {
      print_error ( 'error_update', 'iassign' );
      } // if (!$DB->update_record('iassign_submission_comment', $newentry))
     } // if ($message->receiver == $receiver)
    add_to_log ( $this->course->id, "iassign", "update comment", "view.php?id={$this->iassign->id }", $iassign_submissionid, $this->cm->id, $USER->id );
    } // foreach ($verify_message as $message)
   }
   }

 /**
  * Record comment of activity
  */
 function write_comment_submission() {
  global $USER, $CFG, $DB, $OUTPUT;
  $id = $this->cm->id;
  $submission_comment = optional_param ( 'submission_comment', NULL, PARAM_TEXT );
  $row = optional_param ( 'row', 0, PARAM_INT );
  $column = optional_param ( 'column', 0, PARAM_INT );

  $sum_comment = 0;

  $return = "" . $CFG->wwwroot . "/mod/iassign/view.php?action=viewsubmission&id=" . $id . "&iassign_submission_current=" . $this->iassign_submission_current . "&userid_iassign=" . $this->userid_iassign . "&iassign_current=" . $this->activity->get_activity ()->id . "&row=" . ($row) . "&column=" . ($column);

  $link_return = "&nbsp;<a href='" . $return . "'>" . icons::insert ( 'return_home' ) . get_string ( 'return', 'iassign' ) . "</a>";

  $str1 = trim ( $submission_comment );
  $str2 = trim ( get_string ( 'box_comment_message', 'iassign' ) );

  if (! empty ( $submission_comment ) and (strcmp ( $str1, $str2 ) != 0)) {

   $iassign_submission = $DB->get_record ( "iassign_submission", array ("id" => $this->iassign_submission_current ) );

   if (has_capability ( 'mod/iassign:submitiassign', $this->context, $USER->id ) && !is_siteadmin()) {
    $receiver = 1; // student message to teacher
    $this->action = 'view';

    $iassign_statement = $DB->get_record ( "iassign_statement", array ("id" => $iassign_submission->iassign_statementid ) );
    $tousers = get_users_by_capability($this->context, 'mod/iassign:evaluateiassign');
    } else {
    $receiver = 2; // teacher message to student
    $this->action = 'viewsubmission';

    $tousers = array();
    $tousers[] = $DB->get_record ( "user", array ("id" => $iassign_submission->userid ) );

    } // if (has_capability('mod/iassign:submitiassign', $this->context, $USER->id))

   if (! $iassign_submission) {
    $iassign_statement = $DB->get_record ( "iassign_statement", array ("id" => $this->activity->get_activity ()->id ) );

    $id_submission = $this->new_submission ( $iassign_statement->id, $this->userid_iassign, $receiver );
    $this->iassign_submission_current = $id_submission;
    } else {
    $id_submission = $iassign_submission->id;
    } // if (!$iassign_submission)
     // $comments = $DB->get_record_sql("SELECT COUNT(iassign_submissionid) FROM {$CFG->prefix }ia_assign_submissions_comment
     // WHERE iassign_submissionid = '$id_submission' and comment='$submission_comment' and comment_authorid='$USER->id'"); //
     // Attention: this Moodle function 'get_record_sql' makes a replace in ':comment'
   $params = array ("iassign_submissionid" => $id_submission,"comment" => $submission_comment,"comment_authorid" => $USER->id );
   $comments = $DB->get_record_sql ( 'SELECT COUNT(iassign_submissionid)
                        FROM {iassign_submission_comment }
                        WHERE iassign_submissionid = :iassign_submissionid AND comment= :comment
                        AND comment_authorid= :comment_authorid', $params ); // " - jed/emacs

   if ($comments)
    foreach ( $comments as $tmp )
     $sum_comment = $tmp;

   if ($sum_comment == 0) {
    $newentry = new stdClass ();
    $newentry->iassign_submissionid = $id_submission;
    $newentry->comment_authorid = $USER->id;
    $newentry->timecreated = time ();
    $newentry->comment = $submission_comment;
    $newentry->receiver = $receiver;
    $ia_assign_submissions_comment_id = $DB->insert_record ( 'iassign_submission_comment', $newentry );

    foreach ($tousers as $touser) {
     $eventdata = new stdClass();
     $eventdata->component         = 'mod_iassign'; //your component name
     $eventdata->name              = 'comment'; //this is the message name from messages.php
     $eventdata->userfrom          = $USER;
     $eventdata->userto            = $touser;
     $eventdata->subject           = "Teste de Subject";
     $eventdata->fullmessage       = "Teste de Mensagem...";
     $eventdata->fullmessageformat = FORMAT_PLAIN;
     $eventdata->fullmessagehtml   = "<b>Teste de Mensagem...</b>";
     $eventdata->smallmessage      = "Teste de Mensagem";
     $eventdata->notification      = 1; //this is only set to 0 for personal messages between users
     message_send($eventdata);
     }

    add_to_log ( $this->course->id, "iassign", "add comment", "view.php?id={$this->iassign->id }", $ia_assign_submissions_comment_id, $this->cm->id, $USER->id );
    }
   } // if (!empty($submission_comment) and (strcmp($str1, $str2) != 0))
    // if ($this->action=='viewsubmission') {
    // echo $OUTPUT->header();
    // $this->return_last('confirm_add_comment', $link_return);
    // die;
    //  }

  return true;
   }

 /**
  * Writes a new submission
  */
 function new_submission($iassignid, $id_user, $receiver) {
  global $USER, $DB, $OUTPUT;
  $newentry = new stdClass ();
  $newentry->iassign_statementid = $iassignid;
  $newentry->userid = $id_user;
  $newentry->timecreated = time ();
  $newentry->timemodified = time ();
  $newentry->answer = 0; // student only submit message
  if ($receiver == 2) // teacher message to student (write id teacher)
   $newentry->teacher = $USER->id;

  if (! $newentry->id = $DB->insert_record ( "iassign_submission", $newentry ))
   return_home_course ( 'error_insert_submissions');
  else
   add_to_log ( $this->course->id, "iassign", "add submission", "view.php?id={$this->iassign->id }", $newentry->id, $this->cm->id, $USER->id );

  return $newentry->id;
   }

 /**
  * Return to a specific address of page
  */
 function return_last($message, $link_return) {
  global $DB, $OUTPUT;
  echo $OUTPUT->box_start ();
  echo '<table width=100% border=0 valign="top">' . "\n";
  echo '<tr><td align="left"><strong>' . "\n";
  print_string ( $message, 'iassign' );
  echo '</strong></td>' . "\n";
  echo '<td width=20% align="right">' . "\n";
  echo $link_return;
  echo '</td></tr></table>' . "\n";
  echo $OUTPUT->box_end ();
  echo $OUTPUT->footer ();
  die ();
   }
 }


/**
 * Class for manage activities.
 *
 */
class activity {
 var $activity;
 /**
  * Constructor of class.
  * @param int $id Id of activity
  */
 function activity($id) {
  global $DB;
  $this->activity = $DB->get_record ( "iassign_statement", array ("id" => $id ) );
  if (empty ( $this->activity ))
   $this->activity = null;

  }

 /**
  * Get an activity.
  * @return NULL
  */
 function get_activity() {
  if ($this->activity != null)
   return $this->activity;
  else
   return null;
  }

 /**
  * Delete interactive activities
  */
 function delete($return) {
  global $USER, $CFG, $DB, $OUTPUT;

  $iassign_submission_currents = $DB->get_records ( "iassign_submission", array ("iassign_statementid" => $this->activity->id ) );

  $output = $OUTPUT->header ();
  $output .= $OUTPUT->box_start ();
  $output .= "<p>" . get_string ( 'delete_activity', 'iassign' ) . "&nbsp;<strong>" . $this->activity->name . "</strong></p>";
  if ($iassign_submission_currents) {
   $output .= "<p>" . get_string ( 'number_submissions', 'iassign' ) . "&nbsp;<strong>" . count ( $iassign_submission_currents ) . "</strong></p>";
   if (! has_capability ( 'mod/iassign:deleteiassignnotnull', $USER->context, $USER->id )) {
    $output .= $OUTPUT->heading ( get_string ( 'delete_activity_permission_adm', 'iassign' ) );
    $output .= $OUTPUT->single_button ( $return, get_string ( 'return', 'iassign' ), 'get' );
    $output .= $OUTPUT->box_end ();
    $output .= $OUTPUT->footer ();
    echo $output;
    die ();
    } // if (!has_capability('mod/iassign:deleteiassignnotnull', $this->context, $USER->id))
   }   // if ($iassign_submission_currents)
  else
   $output .= "<p>" . get_string ( 'not_submissions_activity', 'iassign' ) . "</p>";
  $output .= '<table width=50% border=0>';
  $output .= '<tr valign="top"><td>';
  $output .= "<p>" . get_string ( 'what_do', 'iassign' ) . "</p>";
  $output .= '</td><td>';

  $bottonDelete_yes = get_string ( 'delete_iassign', 'iassign' );
  $deleteiassignyes = $CFG->wwwroot . "/mod/iassign/view.php?id=" . $USER->cm . "&action=deleteyes&iassign_current=" . $this->activity->id;
  $output .= "<form name='formDelete' id='formDelete' method='post' action='$deleteiassignyes' enctype='multipart/form-data'>";
  $output .= " <input type=submit value='$bottonDelete_yes'/>\n";
  $output .= "</form>\n";
  $output .= '</td><td>';
  $bottonDelete_no = get_string ( 'delete_cancel', 'iassign' );
  $deleteiassignno = $CFG->wwwroot . "/mod/iassign/view.php?id=" . $USER->cm . "&action=deleteno&iassign_current=" . $this->activity->id;
  $output .= "<form name='formDelete' id='formDelete' method='post' action='$deleteiassignno' enctype='multipart/form-data'>\n";
  $output .= " <p><input type=submit value='$bottonDelete_no'/></p>\n";
  $output .= "</form>\n";
  $output .= '</td></tr></table>' . "\n";
  $output .= $OUTPUT->box_end ();
  $output .= $OUTPUT->footer ();
  echo $output;
  }

 /**
  * Function for confirm the delete of activity
  * @param String $return Url of return
  * @param Object $iassign Object content an activity.
  */
 function deleteyes($return, $iassign) {
  global $USER, $CFG, $DB, $OUTPUT;
  $msg = '';

  if (! empty ( $this->activity->id )) {
   $iassign_submission_currents = $DB->get_records ( "iassign_submission", array ("iassign_statementid" => $this->activity->id ) );
   if ($iassign_submission_currents) {
    if (has_capability ( 'mod/iassign:deleteassignnull', $USER->context, $USER->id )) {
     foreach ( $iassign_submission_currents as $iassign_submission )
      $DB->delete_records ( 'iassign_submission_comment', array ('iassign_submissionid' => $iassign_submission->id ) );
     $delete_iassign_submission_currents = $DB->delete_records ( "iassign_submission ", array ("iassign_statementid" => $this->activity->id ) );
     } // if ($iassign_submission_currents)
    }

   $delete_iassign_statement_config = $DB->delete_records ( 'iassign_statement_config', array ('iassign_statementid' => $this->activity->id) );

   $this->delete_calendar ( $this->activity->id );
   $delete_iassign_current = $DB->delete_records ( 'iassign_statement', array ('id' => $this->activity->id ) );
   iassign::update_grade_iassign ( $this->activity->iassignid );

   if ($delete_iassign_current) {
    $iassign->return_home_course('confirm_delete_iassign');
    //$msg = get_string ( 'confirm_delete_iassign', 'iassign' );
    } else {
    $iassign->return_home_course('error_confirm_delete_iassign');
    //$msg = get_string ( 'error_confirm_delete_iassign', 'iassign' );
    }
   // if (($this->action == 'deleteyes') and (has_capability('mod/iassign:deleteassignnull', $this->context, $USER->id)))
   }
  }

 /**
  * Changes position within of interactive group activity
  */
 function move_iassign($target, $return) {
  global $DB, $OUTPUT;
  $iassign_target = $DB->get_record ( "iassign_statement", array ("id" => $target ) );
  $aux = $this->activity->position;
  $newentry = new stdClass ();
  $newentry->id = $this->activity->id;
  $newentry->position = $iassign_target->position;

  if (! $DB->update_record ( 'iassign_statement', $newentry )) {
   print_error ( 'error_update_move_iassign', 'iassign' );
  }

  $newentry->id = $iassign_target->id;
  $newentry->position = $aux;
  if (! $DB->update_record ( 'iassign_statement', $newentry ))
   print_error ( 'error_update_move_iassign', 'iassign' );
  redirect ( $return );
   }

 /**
  * Enable or disable the display of interactive activities
  */
 function visible_iassign($return) {
  global $DB;
  $newentry = new stdClass ();
  $newentry->id = $this->activity->id;
  $newentry->visible = $this->activity->visible == 0 ? 1 : 0;
  if (! $DB->update_record ( 'iassign_statement', $newentry ))
   print_error ( 'error_update_visible_iassign', 'iassign' );
  redirect ( $return );
   }

 /**
  * Add news interactive activities
  */
 function new_iassign($param) {
  global $DB;

  $newentry = new stdClass ();
  $newentry->iassignid = $param->iassignid;
  $newentry->name = $param->name;
  $newentry->type_iassign = $param->type_iassign;
  $newentry->proposition = $param->proposition;
  $newentry->author_name = $param->author_name;
  $newentry->author_modified_name = $param->author_modified_name;
  $newentry->iassign_ilmid = $param->iassign_ilmid;
  $newentry->file = $param->file;
  $newentry->grade = $param->grade;
  $newentry->timemodified = time ();
  $newentry->timecreated = time ();
  if ($param->type_iassign == 1) {
   $newentry->timedue = 0;
   $newentry->timeavailable = 0;
   }   // if ($param->type_iassign == 1)
  else {
   $newentry->timedue = $param->timedue;
   $newentry->timeavailable = $param->timeavailable;
   }
  $newentry->preventlate = $param->preventlate;
  $newentry->test = $param->test;
  $newentry->special_param1 = $param->special_param1;
  $newentry->visible = $param->visible;
  $newentry->position = $param->position;
  $newentry->max_experiment = $param->max_experiment;
  $newentry->dependency = $param->dependency;
  $newentry->automatic_evaluate = $param->automatic_evaluate;
  $newentry->show_answer = $param->show_answer;

  if ($id = $DB->insert_record ( "iassign_statement", $newentry )) {

   $component = 'mod_iassign';
   $filearea = 'exercise';
   $fs = get_file_storage ();
   $file = $fs->get_file_by_id ( $param->file );
   $itemid = $file->get_itemid () + $id;
   $newfile = $fs->create_file_from_storedfile ( array ('contextid' => $param->context->id,'component' => $component,'filearea' => $filearea,'itemid' => $itemid ), $file );
   $updateentry = new stdClass ();
   $updateentry->id = $id;
   $updateentry->file = $newfile->get_itemid ();
   if (! $DB->update_record ( "iassign_statement", $updateentry ))
    print_error ( 'error_add', 'iassign' );

   if ($param->type_iassign == 3)
    iassign::update_grade_iassign ( $param->iassignid );

   $iassign_ilm_configs = $DB->get_records ( 'iassign_ilm_config', array ('iassign_ilmid' => $param->iassign_ilmid, 'visible' => '1' ) );
   if ($iassign_ilm_configs) {
    foreach ($iassign_ilm_configs as $iassign_ilm_config) {
     if ($iassign_ilm_config->param_type != 'static') {
      $newentry = new stdClass ();
      $newentry->iassign_statementid = $id;
      $newentry->iassign_ilm_configid = $iassign_ilm_config->id;
      $newentry->param_name = $iassign_ilm_config->param_name;
      $newentry->param_value = (is_array($param->{'param_'.$iassign_ilm_config->id }) ? implode(",", $param->{'param_'.$iassign_ilm_config->id }) : $param->{'param_'.$iassign_ilm_config->id });

      if (!$DB->insert_record ( "iassign_statement_config", $newentry ))
       print_error ( 'error_add_param', 'iassign' );
      }
     }
    }

   // log event --------------------------------------------------------------------------------------
   log::add_log('add_iassign_exercise', 'name: '.$param->name, $id, $param->iassign_ilmid);
   // log event --------------------------------------------------------------------------------------

   return $id;
   } else
   print_error ( 'error_add', 'iassign' );

   }

 /**
  * Add the calendar entries for this iassign
  *
  * @param int $coursemoduleid
  *         - Required to pass this in because it might not exist in the database yet
  * @return bool
  */
 static function add_calendar($iassignid) {
  global $DB, $CFG;
  require_once ($CFG->dirroot . '/calendar/lib.php');

  $iassign_statement = $DB->get_record ( "iassign_statement", array ("id" => $iassignid ) );
  $iassign = $DB->get_record ( "iassign", array ("id" => $iassign_statement->iassignid ) );

  $event = new stdClass ();
  $event->name = $iassign->name . '&nbsp;-&nbsp;' . $iassign_statement->name;
  $event->description = $iassign_statement->name;
  $event->courseid = $iassign->course;
  $event->groupid = 0;
  $event->userid = 0;
  $event->modulename = 'iassign';
  $event->instance = $iassign->id;
  $event->eventtype = 'due';
  $event->timestart = $iassign_statement->timeavailable;
  $event->timeduration = ($iassign_statement->timedue - $iassign_statement->timeavailable);
  calendar_event::create ( $event );
   }

 /**
  * Update the calendar entries for this iassign
  *
  * @param int $coursemoduleid
  *         - Required to pass this in because it might not exist in the database yet
  * @return bool
  */
 function update_calendar($iassignid, $olddescription) {
  global $DB, $CFG;
  require_once ($CFG->dirroot . '/calendar/lib.php');

  $iassign_statement = $DB->get_record ( "iassign_statement", array ("id" => $iassignid ) );
  $iassign = $DB->get_record ( "iassign", array ("id" => $iassign_statement->iassignid ) );

  $event = new stdClass ();
  $event->id = 0;
  $events = $DB->get_records ( 'event', array ('modulename' => 'iassign','instance' => $iassign->id ) );
  if ($events) {
   foreach ( $events as $value ) {
    if ($value->description == $olddescription) {
     $event->id = $value->id;
     }
    }
   }
  if ($event->id != 0) {
   $event->name = $iassign->name . '&nbsp;-&nbsp;' . $iassign_statement->name;
   $event->description = $iassign_statement->name;
   $event->timestart = $iassign_statement->timeavailable;
   $event->timeduration = ($iassign_statement->timedue - $iassign_statement->timeavailable);

   $calendarevent = calendar_event::load ( $event->id );
   $calendarevent->update ( $event );
   } else
   $this->add_calendar ( $iassignid );
   }

 /**
  * Update the calendar entries for this iassign
  *
  * @param int $coursemoduleid
  *         - Required to pass this in because it might not exist in the database yet
  * @return bool
  */
 function delete_calendar($iassignid) {
  global $DB, $CFG;
  require_once ($CFG->dirroot . '/calendar/lib.php');

  $iassign_statement = $DB->get_record ( "iassign_statement", array ("id" => $iassignid ) );
  $iassign = $DB->get_record ( "iassign", array ("id" => $iassign_statement->iassignid ) );
  $events = $DB->get_records ( 'event', array ('modulename' => 'iassign','instance' => $iassign->id ) );
  if ($events) {
   foreach ( $events as $value ) {
    if ($value->description == $iassign_statement->name) {
     $DB->delete_records ( 'event', array ('id' => $value->id ) );
     }
    }
   }
   }

 /**
  * Update interactive activities
  */
 function update_iassign($param) {
  global $DB;

  $component = 'mod_iassign';
  $filearea = 'exercise';
  $fs = get_file_storage ();
  $file = $fs->get_file_by_id ( $param->file );
  $fileold = $fs->get_file_by_id ( $param->fileold );

  if ($param->file != $param->fileold) {

   if (! $fs->file_exists ( $param->context->id, $component, $filearea, $file->get_itemid (), $file->get_filepath (), $file->get_filename () )) {
    $itemid = $file->get_itemid () + $param->iassign_id;
    $newfile = $fs->create_file_from_storedfile ( array ('contextid' => $param->context->id,'component' => $component,'filearea' => $filearea,'itemid' => $itemid ), $file );
    $param->file = $newfile->get_itemid ();
    } else
    $param->file = $file->get_itemid ();

   if ($fileold) {
    $fileoldarea = $fs->get_area_files ( $fileold->get_contextid (), $fileold->get_component (), $fileold->get_filearea (), $fileold->get_itemid () );
    foreach ( $fileoldarea as $value ) {
     $value->delete ();
     }
    }
   } else {
   $param->file = $file->get_itemid ();
  }

  $newentry = new stdClass ();
  $newentry->id = $param->iassign_id;
  $newentry->name = $param->name;
  $newentry->type_iassign = $param->type_iassign;
  $newentry->proposition = $param->proposition;
  $newentry->iassign_ilmid = $param->iassign_ilmid;

  $newentry->file = $param->file;
  $newentry->grade = $param->grade;
  $newentry->author_modified_name = $param->author_modified_name;

  $newentry->timemodified = time ();
  if ($param->type_iassign == 1) {
   $newentry->timedue = 0;
   $newentry->timeavailable = 0;
   }   // if ($param->type_iassign == 1)
  else {
   $newentry->timedue = $param->timedue;
   $newentry->timeavailable = $param->timeavailable;
   }
  $newentry->preventlate = $param->preventlate;
  $newentry->test = $param->test;
  $newentry->special_param1 = $param->special_param1;
  $newentry->visible = $param->visible;
  $newentry->max_experiment = $param->max_experiment;
  $newentry->dependency = $param->dependency;
  $newentry->automatic_evaluate = $param->automatic_evaluate;
  $newentry->show_answer = $param->show_answer;

  if (! $DB->update_record ( "iassign_statement", $newentry ))
   print_error ( 'error_update', 'iassign' );

  if ($param->type_iassign == 3) {
   iassign::update_grade_iassign ( $param->iassignid );
  }

  $id = $newentry->id;

  $iassign_statement_configs = $DB->get_records ( 'iassign_statement_config', array ('iassign_statementid' => $newentry->id) );
  if ($iassign_statement_configs) {
   foreach ($iassign_statement_configs as $iassign_statement_config) {
    $newentry = new stdClass ();
    $newentry->id = $iassign_statement_config->id;
    $newentry->param_value = (is_array($param->{'param_'.$iassign_statement_config->iassign_ilm_configid }) ? implode(",", $param->{'param_'.$iassign_statement_config->iassign_ilm_configid }) : $param->{'param_'.$iassign_statement_config->iassign_ilm_configid });

    if (!$DB->update_record ( "iassign_statement_config", $newentry ))
     print_error ( 'error_edit_param', 'iassign' );

    }
  }

  // log event --------------------------------------------------------------------------------------
  log::add_log('update_iassign_exercise', 'name: '.$param->name, $param->iassign_id, $param->iassign_ilmid);
  // log event --------------------------------------------------------------------------------------

  return $id;
  // if ($param->type_iassign==3)
  // $this->update_grade_iassign($param->iassignid);
  }

 /**
  * Show information of activity.
  */
 function show_info_iassign() {
  global $DB, $OUTPUT;

  $output = '<p><strong>' . get_string ( 'proposition', 'iassign' ) . ':</strong>&nbsp;' . $this->activity->proposition . '</p>' . "\n";
  if ($this->activity->type_iassign == 3) {
   if ($this->activity->dependency == 0) {
    $output .= '<p><strong>' . get_string ( 'independent_activity', 'iassign' ) . '</strong></p>' . "\n";
    } else {
    $dependencys = explode ( ';', $this->activity->dependency );
    $output .= '<p><strong>' . get_string ( 'dependency', 'iassign' ) . '</strong></p>';
    foreach ( $dependencys as $dependency ) {
     $dependencyiassign = $DB->get_record ( "iassign_statement", array ("id" => $dependency ) );
     if ($dependencyiassign)
      $output .= '<p>' . $dependencyiassign->name . '</p>' . "\n";
     } // foreach ($dependencys as $dependency)
    } // if ($iassign_statement->dependency == 0)
   if ($this->activity->max_experiment == 0)
    $output .= '<p><strong>' . get_string ( 'experiment', 'iassign' ) . '</strong>&nbsp;' . get_string ( 'ilimit', 'iassign' );
   else
    $output .= '<p><strong>' . get_string ( 'experiment_iassign', 'iassign' ) . '</strong>&nbsp;' . $this->activity->max_experiment . "\n";
   $output .= '&nbsp;&nbsp;&nbsp;<strong>' . get_string ( 'grade_iassign', 'iassign' ) . '</strong>&nbsp;' . $this->activity->grade . '</p>' . "\n";
   } // if ($iassign_statement->type_iassign == 3)

  echo $OUTPUT->box ( $output );
   }

 /**
  * Shows date of opening and closing activities
  */
 function view_dates() {
  global $USER, $CFG, $DB, $OUTPUT;

  $return = $CFG->wwwroot . "/mod/iassign/view.php?id=" . $USER->cm;
  $link_return = "&nbsp;<a href='" . $return . "'>" . icons::insert ( 'home' ) . get_string ( 'activities_page', 'iassign' ) . "</a>";
  $status_iassign = "";
  $status_iassign1 = "";
  $status_iassign2 = "";
  if ($this->activity->type_iassign == 1) // activity of type example
   $type_iassign = get_string ( 'example_iassign', 'iassign' );
  elseif ($this->activity->type_iassign == 2) { // activity of type test
   $type_iassign = get_string ( 'test_iassign', 'iassign' );
   if ($this->activity->timeavailable > time ()) {
    $status_iassign = get_string ( 'previous_timeavailable', 'iassign' );
    } elseif ($this->activity->timedue < time ()) {
    $status_iassign = get_string ( 'last_timedue', 'iassign' );
    }
   } elseif ($this->activity->type_iassign == 3) { // activity of type exercise
   $type_iassign = get_string ( 'exercise_iassign', 'iassign' );
   if ($this->activity->timeavailable > time ()) {
    $status_iassign = get_string ( 'previous_timeavailable', 'iassign' ); // before of deadline
    } elseif ($this->activity->timedue < time ()) { // after delivery
    $status_iassign = get_string ( 'last_timedue', 'iassign' );
    if ($this->activity->preventlate == 1) // permitted to submit after the deadline
     $status_iassign1 = get_string ( 'duedate_preventlate_enable', 'iassign' );
    elseif ($this->activity->preventlate == 0) { // not permitted to submit after the deadline
     $status_iassign1 = get_string ( 'duedate_preventlate_desable', 'iassign' );
     if ($this->activity->test == 1) // allowed to test after of deadline
      $status_iassign2 = get_string ( 'test_preventlate', 'iassign' );
     elseif ($this->activity->test == 0) { // not allowed to test after of deadline
      $status_iassign2 = get_string ( 'test_preventlate_no', 'iassign' );
      } // elseif ($iassign_statement->test == 0)
     } // elseif ($iassign_statement->preventlate == 0)
    } // elseif ($iassign_statement->timedue < time())
   } // elseif ($iassign_statement->type_iassign == 3)

  $output = '<table  width=100% >' . "\n";
  $output .= '<tr><td colspan=2><h4>' . $this->activity->name . '</h4></td></tr>' . "\n";
  $output .= '<tr>' . "\n";

  // TODO duvida: como permitir ao admin,professor,monitor ver a atividade mesmo apos prazo???
  // Leo testes para passar por cima com 'has_capability('mod/iassign:...', $this->context, $USER->id)
  $output .= '<td width=60%>' . $type_iassign . '</td>' . "\n";
  // leo $output .= '<td width=80%>' . $type_iassign;
  // $output .= $auxStr . " - status_assign=$status_iassign - this->activity->type_iassign=" . $this->activity->type_iassign. "<br/>"; // Period ended.
  // $output .= '</td>' . "\n";

  if (has_capability ( 'mod/iassign:viewiassignall', $USER->context, $USER->id ) && ($this->activity->type_iassign == 3)) {

   // Link (with icon) to report survey of this batch of these insteractivy exercises
   $link_report = "<a href='" . $CFG->wwwroot . "/mod/iassign/view.php?id=" . $USER->cm . "&action=report&iassignid=" . $this->activity->iassign_ilmid . "'>" . icons::insert ( 'view_report' ) . '&nbsp;' . get_string ( 'report', 'iassign' ) . "</a>";
   $output .= '<td width=40% align="right">' . '&nbsp;' . $link_report . '</td>' . "\n";
   } else {

   $link_next = "";
   $link_previous = "";

   $iassign_previous = $DB->get_record ( 'iassign_statement', array ('iassignid' => $this->activity->iassignid,'position' => $this->activity->position - 1 ) );
   $iassign_next = $DB->get_record ( 'iassign_statement', array ('iassignid' => $this->activity->iassignid,'position' => $this->activity->position + 1 ) );

   // previous_activity
   if ($iassign_previous) {
    $url_previous = "view.php?id=$USER->cm&userid_iassign=$USER->id&action=view&iassign_current=$iassign_previous->id";
    $link_previous = "<a href='" . $url_previous . "'>" . (icons::insert ( 'previous_student_activity' )) . "</a>";
    } // next_activity
   if ($iassign_next) {
    $url_next = "view.php?id=$USER->cm&userid_iassign=$USER->id&action=view&iassign_current=$iassign_next->id";
    $link_next = "<a href='" . $url_next . "'>" . (icons::insert ( 'next_student_activity' )) . "</a>";
    }

   $output .= '<td width=40% align="right">' . $link_previous . '&nbsp;&nbsp;&nbsp;' . $link_return . '&nbsp;&nbsp;&nbsp;' . $link_next . '</td>' . "\n";
   } // if (has_capability('mod/iassign:viewiassignall', $this->context, $USER->id) && ($iassign_statement->type_iassign == 3))
  $output .= '</tr></table>' . "\n";
  $output .= '<table  width=100% >' . "\n";
  if ($this->activity->type_iassign > 1) {
   if ($this->activity->timeavailable)
    $output .= '<tr><td width=50% align="left"> <strong>' . get_string ( 'availabledate', 'iassign' ) . ':</strong>&nbsp;' . userdate ( $this->activity->timeavailable ) . '</td>' . "\n";
   if ($this->activity->timedue)
    $output .= '<td width=50% align="left"><strong>' . get_string ( 'duedate', 'iassign' ) . ':</strong>&nbsp;' . userdate ( $this->activity->timedue ) . '</td>' . "\n";
   } // if ($iassign_statement->type_iassign > 1)
  if ($status_iassign != "" && $status_iassign1 != "" && $status_iassign2 != "")
   $output .= '<tr><td><font color="red">' . $status_iassign . '&nbsp;' . $status_iassign1 . '&nbsp;' . $status_iassign2 . '</font></td></tr>' . "\n";

  $output .= '</table>' . "\n";

  echo $OUTPUT->box ( $output );
   }
 }

/**
 * Class to manage Interactive Learning Module (iLM)
 */
class ilm {
 var $ilm;

 /**
  * Constructor of class.
  * @param int $id Id of iLM.
  */
 function ilm($id) {
  global $DB;
  $this->ilm = $DB->get_record ( "iassign_ilm", array ("id" => $id ) );
  if (empty ( $this->ilm ))
   $this->ilm = null;
  }

 /**
  * Shows activity in iLM
  */
 function view_iLM($iassign_statement, $student_answer, $enderecoPOST, $view) {
  global $USER, $CFG, $COURSE, $DB, $OUTPUT;


  $special_param1 = $iassign_statement->special_param1;


  $this->context = context_module::instance($USER->cm );

  $fs = get_file_storage ();
  $files = $fs->get_area_files ( $this->context->id, 'mod_iassign', 'exercise', $iassign_statement->file );
  if ($files) {
   foreach ( $files as $value ) {
    if ($value->get_filename () != '.')
     $fileid = $value->get_id ();
    }
  }

  if ($this->ilm->name == "iGeom") { // is iGeom exercise of script
   $file = $fileid; // $iassign_statement->file;
   if ($special_param1 == 1 and ! empty ( $student_answer ) and (! $view))
    $view = 1;
   elseif (! $view)
    $file = $student_answer;
   } else {
   if ($view)
    // $file = $this->context->id;
    $file = $fileid; // $iassign_statement->file;
   else
    $file = $student_answer;
  }

  $id_iLM_security = $this->write_iLM_security ( $iassign_statement->id, addslashes ( $file ) );
  $iassign_iLM_security = $DB->get_record ( "iassign_security", array ("id" => $id_iLM_security ) );
  $token = md5 ( $iassign_iLM_security->timecreated );
  // $end_file = $CFG->wwwroot . DIRECTORY_SEPARATOR . 'mod' . DIRECTORY_SEPARATOR . 'iassign' . DIRECTORY_SEPARATOR . 'ilm_security.php?id=' . $id_iLM_security . '&token=' . $token . '&view=' . $view;
  $end_file = $CFG->wwwroot . '/mod/iassign/ilm_security.php?id=' . $id_iLM_security . '&token=' . $token . '&view=' . $view;
  $iassign = "
        <script type='text/javascript'>
          //<![CDATA[
         function resp () {
           var strAnswer = document.applets[0].getAnswer();
           var value = document.applets[0].getEvaluation();
           var comment = document.formEnvio.submission_comment.value;
           if ((strAnswer==null || strAnswer=='' || strAnswer==-1) && (comment==null || comment=='')) { // undefined
              alert('" . get_string ( 'activity_empty', 'iassign' ) . "');
              return false; // sem erro
               }
           else {
              document.formEnvio.MA_POST_Archive.value = strAnswer;
              document.formEnvio.MA_POST_Value.value = value;
              document.formEnvio.submit();
              return true; // com erro
               }
            }
       //]]>
       </script>"; //

  $iassign .= "<center><form name='formEnvio' id='formEnvio' method='post' action='$enderecoPOST' enctype='multipart/form-data'>";

  $iassign .= ilm_settings::applet_ilm($this->ilm->id, array(
    "type" => "activity",
    "notSEND" => "false",
    "addresPOST" => $enderecoPOST,
    "Proposition" => $end_file,
    "special_param" => $special_param1,
    "student_answer" => $student_answer,
    "iassign_statement" => $iassign_statement->id
  ));

  if (!isguestuser() && $iassign_statement->type_iassign != 1) {
   $iassign .= "<input type='hidden' name='MA_POST_Archive'>";
   $iassign .= "<input type='hidden' name='MA_POST_Value'>";

   if (! has_capability ( 'mod/iassign:evaluateiassign', $USER->context, $USER->id ))
    $iassign .= "<p><textarea rows='2' cols='60' name='submission_comment'></textarea></p>";
   else
    $iassign .= "<input type='hidden' name='submission_comment'>";

   if ($USER->iassignEdit == 1)
    $iassign .= "<center>
             <input type=button value='" . get_string ( 'submit_iassign', 'iassign' ) . "' onClick = 'resp()'
                  title='" . get_string ( 'message_submit_iassign', 'iassign' ) . "'>
             </center>";
   }
  $iassign .= "</form></center>";
  return $iassign;
  }

 /**
  * Function for log access in activity file.
  * @param int $iassign_statementid Id of iassign statement.
  * @param Object $file File in use in activity.
  * @return int Return the id of log.
  */
 function write_iLM_security($iassign_statementid, $file) {
  global $CFG, $USER, $COURSE, $DB, $OUTPUT;
  $newentry = new stdClass ();
  $newentry->iassign_statementid = $iassign_statementid;
  $newentry->userid = $USER->id;
  $newentry->file = $file;
  $newentry->timecreated = time ();
  $newentry->view = 1;
  $id_iLM_security = $DB->insert_record ( "iassign_security", $newentry );
  if (! $id_iLM_security) {
   print_error ( 'error_security', 'iassign' );
   } // if (!$DB->insert_record("iassign_security", $newentry))

  return $id_iLM_security;
   }
 }

/**
 * Class to manage settings of iLM.
 */
class ilm_settings {
 /**
  * Function for create the tag html APPLET from filesystem of Moodle.
  * @param int $ilm_id Id of iLM.
  * @param array $options An array with options for create dynamic tag html APPLET.
  * @return string Return with a tag html APPLET created.
  */
 static function applet_ilm($ilm_id, $options = array()) {

  global $DB, $OUTPUT;
  $html = "";
  $iassign_ilm = $DB->get_record ( 'iassign_ilm', array ('id' => $ilm_id ) );
  if ($iassign_ilm) {
   $file_url = array();
   $fs = get_file_storage();
   $files_jar = explode(",", $iassign_ilm->file_jar);
   foreach($files_jar as $fj) {
    $file = $fs->get_file_by_id($fj);
    if (!$file)
     echo($OUTPUT->notification ( get_string ( 'error_confirms_jar', 'iassign' ), 'notifyproblem' ));
    else {
     $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), $file->get_itemid(), $file->get_filepath(), $file->get_filename());
     array_push($file_url, $url);
     }
    }

   $lang = substr (current_language(), 0, 2);

   if (! empty ($file_url)) {

    if ($options['type'] == "filter") {
     $iassign_ilm->width = $options['width'];
     $iassign_ilm->height = $options['height'];
     }
    // TODO: Change to object, tag applet was deprecated.
    if ($iassign_ilm->extension=="html") {
     $paramsStr = "?1=1&";
     switch($options['type']) {
      case "view":
       $paramsStr.= "&MA_PARAM_notSEND=true";
       $iassign_ilm_config = $DB->get_records('iassign_ilm_config', array ('iassign_ilmid' => $ilm_id ));
       foreach ($iassign_ilm_config as $ilm_config) {
        if (array_key_exists($ilm_config->param_name, $options)) {
         $ilm_config->param_value = $options[$ilm_config->param_name];
         $paramsStr.= "&".$ilm_config->param_name."=".urlencode($ilm_config->param_value);
         }
        }
       break;
      case "filter":
       if ($options['toolbar'] == "disable")
        $paramsStr.= "&SOH_ADD=ADD";
       $paramsStr.= "&MA_PARAM_PropositionURL=true";
       $paramsStr.= "&MA_PARAM_notSEND=".urlencode($options['notSEND']);
       $paramsStr.= "&MA_PARAM_addresPOST=".urlencode($ilm_config->param_value);
       $paramsStr.= "&MA_PARAM_PropositionURL=".urlencode($ilm_config->param_value);
       $paramsStr.= "&MA_PARAM_Proposition=".urlencode($options['Proposition']);
       $paramsStr.= "&MA_PARAM_Proposition=".urlencode($options['Proposition']);
       break;
      case "activity":
       $paramsStr.= "&MA_PARAM_PropositionURL=true";
       $paramsStr.= "&MA_PARAM_notSEND=".urlencode($options['notSEND']);
       $paramsStr.= "&MA_PARAM_addresPOST=".urlencode($options['addresPOST']);
       $paramsStr.= "&MA_PARAM_Proposition=".urlencode($options['Proposition']);
       $paramsStr.= "&MA_POST_ArchiveTeacher=true");
       $paramsStr.= "&iLM_PARAM_Authoring=true";

       if ($options['special_param'] == 1) {
        $paramsStr.= "&TIPO_SCRIPT=1";
        $paramsStr.= "&MA_PARAM_Proposition=".urlencode($options['student_answer']);
        }

       $iassign_statement_configs = $DB->get_records('iassign_statement_config', array ('iassign_statementid' => $options['iassign_statement'] ));
       if ($iassign_statement_configs) {
        foreach ($iassign_statement_configs as $iassign_statement_config)
         $paramsStr.= "&".$iassign_statement_config->param_name."=".urlencode($iassign_statement_config->param_value);
        }

       break;
      case "editor_new":
        $paramsStr.= "&MA_PARAM_PropositionURL=true";
        $paramsStr.= "&MA_PARAM_notSEND=".urlencode($options['notSEND']);
        break;
      case "editor_update":
       $paramsStr.= "&MA_PARAM_PropositionURL=true";
       $paramsStr.= "&MA_PARAM_Proposition=".urlencode($options['Proposition']);
       $paramsStr.= "&MA_PARAM_notSEND=".urlencode($options['notSEND']);
       break;
      default:
       print_error("ERROR: type of params not found!");
      }

     $html .='<iframe frameborder="0" name="iLM" src="ilm/'.$iassign_ilm->file_class.$paramsStr.'" style="width: '.$iassign_ilm->width.'px; height: '.$iassign_ilm->height.'px;" id="iLM" name="iLM"></iframe>';
     }else{
     $html .= '<applet name="iLM" archive="'.implode(",", $file_url).'" code="' . $iassign_ilm->file_class . '" width="' . $iassign_ilm->width . '" height="' . $iassign_ilm->height . '" vspace=10 hspace=10>' . chr ( 13 );
     $html .= '<param name="lang" value="' . $lang . '"/>' . chr ( 13 );

     switch($options['type']) {
      case "view":
       $html .= '<param name="MA_PARAM_notSEND" value="true"/>' . chr ( 13 );
       $iassign_ilm_config = $DB->get_records('iassign_ilm_config', array ('iassign_ilmid' => $ilm_id ));
       foreach ($iassign_ilm_config as $ilm_config) {
        if (array_key_exists($ilm_config->param_name, $options)) {
         $ilm_config->param_value = $options[$ilm_config->param_name];
         $html .= '<param name="'.$ilm_config->param_name.'" value="'.$ilm_config->param_value.'"/>' . chr ( 13 );
         }
        }
       break;
      case "filter":
       if ($options['toolbar'] == "disable")
        $html .="<param name='SOH_ADD' value='ADD'>";
       $html .= '<param name="MA_PARAM_PropositionURL" value="true"/>' . chr ( 13 );
       $html .= '<param name="MA_PARAM_notSEND" value="'.$options['notSEND'].'"/>' . chr ( 13 );
       $html .= '<param name="MA_PARAM_addresPOST" value>' . chr ( 13 );
       $html .= '<param name="MA_PARAM_Proposition" value="'.$options['Proposition'].'">' . chr ( 13 );
       break;
      case "activity":
       $html .= '<param name="MA_PARAM_PropositionURL" value="true"/>' . chr ( 13 );
       $html .= '<param name="MA_PARAM_notSEND" value="'.$options['notSEND'].'"/>' . chr ( 13 );
       $html .= '<param name="MA_PARAM_addresPOST" value="'.$options['addresPOST'].'">' . chr ( 13 );
       $html .= '<param name="MA_PARAM_Proposition" value="'.$options['Proposition'].'">' . chr ( 13 );
       $html .= '<param name="MA_POST_ArchiveTeacher" value="true"/>';
       $html .= '<param name="iLM_PARAM_Authoring" value="true"/>';
       if ($options['special_param'] == 1) {
        $html .= '<param name="TIPO_SCRIPT" value="1">' . chr ( 13 );
        $html .= '<param name="BOTAOSCR1" value="'.$options['student_answer'].'" />' . chr ( 13 );
        }

       $iassign_statement_configs = $DB->get_records('iassign_statement_config', array ('iassign_statementid' => $options['iassign_statement'] ));
       if ($iassign_statement_configs) {
        foreach ($iassign_statement_configs as $iassign_statement_config)
         $html .= '<param name="'.$iassign_statement_config->param_name.'" value="'.$iassign_statement_config->param_value.'"/>' . chr ( 13 );
        }

       break;
      case "editor_new":
        $html .= '<param name="MA_PARAM_PropositionURL" value="true"/>' . chr ( 13 );
        $html .= '<param name="MA_PARAM_notSEND" value="'.$options['notSEND'].'"/>' . chr ( 13 );
        break;
      case "editor_update":
       $html .= '<param name="MA_PARAM_PropositionURL" value="true"/>' . chr ( 13 );
       $html .= '<param name="MA_PARAM_Proposition" value="'.$options['Proposition'].'">' . chr ( 13 );
       $html .= '<param name="MA_PARAM_notSEND" value="'.$options['notSEND'].'"/>' . chr ( 13 );
       break;
      default:
       print_error("ERROR: type of params not found!");
      }
     }
    if ($iassign_ilm->extension!="html") {

     $iassign_ilm_config = $DB->get_records('iassign_ilm_config', array ('iassign_ilmid' => $ilm_id, 'visible' => 1, 'param_type' => 'static' ));
     foreach ($iassign_ilm_config as $ilm_config) {
      //if (array_key_exists($ilm_config->param_name, $options))
       //$ilm_config->param_value = $options[$ilm_config->param_name];
      $html .= '<param name="'.$ilm_config->param_name.'" value="'.$ilm_config->param_value.'"/>' . chr ( 13 );
      }

     $html .= '</applet>';
     }
    }
   }
  return $html;
  }

 /**
  * Function for get modified date of iLM file.
  * @param string $file_jar String with Ids of iLM files.
  * @return string Return with the filenames and modified date.
  */
 static function applet_filetime($file_jar) {
  $filetime = "";
  $fs = get_file_storage();
  $files_jar = explode(",", $file_jar);
  foreach($files_jar as $fj) {
   $file = $fs->get_file_by_id($fj);
   if ($file)
    $filetime .= chr ( 13 ) . $file->get_filename() . ' (' . userdate($file->get_timemodified()) . ')'.'</br>';
   }
  return $filetime;
  }

 /**
  * Function for verify an default applet.
  * @param String $file_jar String containing an list de ids of applet files.
  * @return boolean Return true or fale if applet is default.
  */
 static function applet_default($file_jar) {
  $is_default = true;
  $fs = get_file_storage();
  $files_jar = explode(",", $file_jar);
  foreach($files_jar as $fj) {
   $file = $fs->get_file_by_id($fj);
   if ($file)
    $is_default &= ($file->get_itemid() == 0);
   }
  return $is_default;
  }

 /**
  * Function for get form variables for add, edit, or copy iLM.
  * @param int $ilm_id Id of iLM.
  * @param string $action String with the action
  * @return object Return an object with forms variables.
  */
 static function add_edit_copy_ilm($ilm_id, $action) {
  global $USER, $DB, $CFG;

  require_once ('settings_form.php');
  $iassign_ilm = $DB->get_record ( 'iassign_ilm', array ('id' => $ilm_id ) );
  $param = new object ();
  $param->action = $action;
  $param->ilm_id = $ilm_id;
  $CFG->action_ilm = $action;
  $CFG->ilm_id = $ilm_id;

  if ($action == 'add') {
   $param->title = get_string ( 'add_ilm', 'iassign' );
   $param->name = "";
   $param->version = "";
   $param->url = "";
   $param->description = "";
   $param->extension = "";
   $param->author = $USER->id;
   $param->file_jar = "";
   $param->file_jar_static = "";
   $param->file_class = "";
   $param->width = 800;
   $param->height = 600;
   $param->enable = 0; // 0 - hide / 1 - show
   $param->timecreated = time ();
   $param->timemodified = time ();
   $param->evaluate = 0;
   $param->parent = 0;
   } elseif ($action == 'edit') {
   if ($iassign_ilm) {
    $description = json_decode($iassign_ilm->description);
    $param->title = get_string ( 'edit_ilm', 'iassign' );
    $param->id = $iassign_ilm->id;
    $param->name_ilm = $iassign_ilm->name;
    $param->name = $iassign_ilm->name;
    $param->version = $iassign_ilm->version;
    $param->url = $iassign_ilm->url;
    $param->description = $description->{current_language() };
    $param->description_lang = $iassign_ilm->description;
    $param->extension = $iassign_ilm->extension;
    $param->author = $iassign_ilm->author;
    $param->file_jar = $iassign_ilm->file_jar;
    $param->file_jar_static = ilm_settings::applet_filetime($iassign_ilm->file_jar);
    $param->file_class = $iassign_ilm->file_class;
    $param->width = $iassign_ilm->width;
    $param->height = $iassign_ilm->height;
    $param->enable = $iassign_ilm->enable;
    $param->timecreated = $iassign_ilm->timecreated;
    $param->timemodified = time ();
    $param->evaluate = $iassign_ilm->evaluate;
    $param->parent = $iassign_ilm->parent;
    }
   } elseif ($action == 'new_version') {
   $description = json_decode($iassign_ilm->description);
   if ($iassign_ilm) {
    if ($iassign_ilm->parent == 0)
     $iassign_ilm->parent = $ilm_id;
    $param->title = get_string ( 'new_version_ilm', 'iassign' );
    $param->name_ilm = $iassign_ilm->name;
    $param->name = $iassign_ilm->name;
    $param->version = "";
    $param->url = $iassign_ilm->url;
    $param->description = $description->{current_language() };
    $param->description_lang = $iassign_ilm->description;
    $param->extension = $iassign_ilm->extension;
    $param->author = $USER->id;
    $param->file_jar = '';
    $param->file_jar_static = '';
    $param->file_class = $iassign_ilm->file_class;
    $param->width = $iassign_ilm->width;
    $param->height = $iassign_ilm->height;
    $param->enable = 0;
    $param->timecreated = time ();
    $param->timemodified = time ();
    $param->evaluate = $iassign_ilm->evaluate;
    $param->parent = $iassign_ilm->parent;
    }
   } elseif ($action == 'copy') {
   $description = json_decode($iassign_ilm->description);
   if ($iassign_ilm) {
    if ($iassign_ilm->parent == 0)
     $iassign_ilm->parent = $ilm_id;
    $param->title = get_string ( 'copy_ilm', 'iassign' );
    $param->id = $iassign_ilm->id;
    $param->name_ilm = $iassign_ilm->name;
    $param->name = $iassign_ilm->name;
    $param->version = "";
    $param->url = $iassign_ilm->url;
    $param->description = $description->{current_language() };
    $param->description_lang = $iassign_ilm->description;
    $param->extension = $iassign_ilm->extension;
    $param->author = $USER->id;
    $param->file_jar = '';
    $param->file_jar_static = '';
    $param->file_class = $iassign_ilm->file_class;
    $param->width = $iassign_ilm->width;
    $param->height = $iassign_ilm->height;
    $param->enable = 0;
    $param->timecreated = time ();
    $param->timemodified = time ();
    $param->evaluate = $iassign_ilm->evaluate;
    $param->parent = $iassign_ilm->parent;
    }
   }
  return $param;
  }

 /**
  * Function for save iLM file in moodledata.
  * @param int $itemid Itemid of file save in draft (upload file).
  * @param int $ilm_id Id of iLM.
  * @return string Return an string with ids of iLM files.
  */
 static function new_file_ilm($itemid, $iassign_ilm) {
  global $CFG, $USER, $DB;

  $return = null;
  $file_jar = array ();
  $fs = get_file_storage ();
  $contextuser = context_user::instance($USER->id );
  $contextsystem = context_system::instance();
  $files_ilm = $fs->get_area_files ( $contextuser->id, 'user', 'draft', $itemid );

  if ($files_ilm) {
   foreach ( $files_ilm as $value ) {
    if ($value->get_filename () != '.') {

     $file_ilm = array(
       'userid' => $USER->id,
       'contextid' => $contextsystem->id,
       'component' => 'mod_iassign',
       'filearea' => 'ilm',
       'itemid' => rand(1, 999999999),
       'filepath' => '/iassign/ilm/'.utils::format_pathname($iassign_ilm->name).'/'.utils::format_pathname($iassign_ilm->version).'/',
       'filename' => $value->get_filename ());

     $file_ilm = $fs->create_file_from_storedfile($file_ilm, $value);

     array_push ( $file_jar, $file_ilm->get_id() );

     }
    }

   if (!empty ( $file_jar )) {

    $return = implode ( ",", $file_jar );

    $old_file_jar = explode ( ",", $iassign_ilm->file_jar );
    foreach ( $old_file_jar as $value ) {
     $file = $fs->get_file_by_id($value);
     if ($file)
      $fs->delete_area_files($contextsystem->id, 'mod_iassign', 'ilm', $file->get_itemid());
     }
    }
   } else
   $return = $iassign_ilm->file_jar;

  $delete_file = $fs->delete_area_files ( $contextuser->id, 'user', 'draft', $itemid );

  return $return;
  }

 /**
  * Function for save in database an new iLM.
  * @param object $param An object with iLM params.
  */
 static function new_ilm($param) {
  global $DB;

  $iassign_ilm = new stdClass ();
  $iassign_ilm->name = $param->name;
  $iassign_ilm->version = $param->version;
  $iassign_ilm->file_jar = null;

  $file_jar = ilm_settings::new_file_ilm ( $param->file, $iassign_ilm );

  if (empty ( $file_jar ))
   print_error ( 'error_add_ilm', 'iassign' );
  else {
   $description = json_decode($param->description_lang);
   $description->{$param->set_lang } = $param->description;

   $newentry = new stdClass ();
   $newentry->name = $param->name;
   $newentry->version = $param->version;
   $newentry->url = $param->url;
   $newentry->description = json_encode($description);
   $newentry->extension = strtolower($param->extension);
   $newentry->file_jar = $file_jar;
   $newentry->file_class = $param->file_class;
   $newentry->width = $param->width;
   $newentry->height = $param->height;
   $newentry->enable = $param->enable;
   $newentry->timemodified = $param->timemodified;
   $newentry->author = $param->author;
   $newentry->timecreated = $param->timecreated;
   $newentry->evaluate = $param->evaluate;
   $newentry->parent = $param->parent;

   $newentry->id = $DB->insert_record ( "iassign_ilm", $newentry );

   // log event --------------------------------------------------------------------------------------
   log::add_log('add_iassign_ilm', 'name: '.$param->name.' '.$param->version, 0, $newentry->id);
   // log event --------------------------------------------------------------------------------------
   }
  }

 /**
  * Function for save in database an iLM edit.
  * @param object $param An object with iLM params.
  */
 static function edit_ilm($param) {
  global $DB;

  $iassign_ilm = new stdClass ();
  $iassign_ilm->name = $param->name;
  $iassign_ilm->version = $param->version;
  $iassign_ilm->file_jar = $param->file_jar;

  $file_jar = ilm_settings::new_file_ilm ( $param->file, $iassign_ilm );

  if (is_null ( $file_jar ))
   print_error ( 'error_edit_ilm', 'iassign' );
  else {
   $description = json_decode($param->description_lang);
   $description->{$param->set_lang } = $param->description;

   $updentry = new stdClass ();
   $updentry->id = $param->id;
   $updentry->version = $param->version;
   $updentry->url = $param->url;
   $updentry->description = json_encode($description);
   $updentry->extension = strtolower($param->extension);
   $updentry->file_class = $param->file_class;
   $updentry->width = $param->width;
   $updentry->height = $param->height;
   $updentry->enable = $param->enable;
   $updentry->timemodified = $param->timemodified;
   $updentry->evaluate = $param->evaluate;
   $updentry->file_jar = $file_jar;

   $DB->update_record ( "iassign_ilm", $updentry );

   // log event --------------------------------------------------------------------------------------
   log::add_log('update_iassign_ilm', 'name: '.$param->name.' '.$param->version, 0, $param->id);
   // log event --------------------------------------------------------------------------------------
  }

   }

 /**
  * Function for save in database an iLM copy.
  * @param object $param An object with iLM params.
  */
 static function copy_new_version_ilm($param) {
  global $USER, $DB;

  $iassign_ilm = new stdClass ();
  $iassign_ilm->name = $param->name;
  $iassign_ilm->version = $param->version;
  $iassign_ilm->file_jar = null;

  $file_jar = ilm_settings::new_file_ilm ( $param->file, $iassign_ilm );

  if (empty ( $file_jar ))
   print_error ( 'error_add_ilm', 'iassign' );
  else {
   $description = json_decode($param->description_lang);
   $description->{$param->set_lang } = $param->description;

   $newentry = new stdClass ();
   $newentry->name = $param->name;
   $newentry->version = $param->version;
   $newentry->url = $param->url;
   $newentry->description = json_encode($description);
   $newentry->extension = strtolower($param->extension);
   $newentry->file_jar = $file_jar;
   $newentry->file_class = $param->file_class;
   $newentry->width = $param->width;
   $newentry->height = $param->height;
   $newentry->enable = 0;
   $newentry->timemodified = $param->timemodified;
   $newentry->timecreated = $param->timecreated;
   $newentry->evaluate = $param->evaluate;
   $newentry->author = $param->author;
   $newentry->parent = $param->parent;

   $newentry->id = $DB->insert_record ( "iassign_ilm", $newentry );

   // log event --------------------------------------------------------------------------------------
   log::add_log('copy_iassign_ilm', 'name: '.$param->name.' '.$param->version, 0, $newentry->id);
   // log event --------------------------------------------------------------------------------------
   }
  }

 /**
  * Function for change visibility of iLM.
  * @param int $ilm_id Id of iLM.
  * @param int $status Indicator of change vibility (0 = hide, 1 = show).
  */
 static function visible_ilm($ilm_id, $status) {
  global $DB;
  if ($status == 0)
   $visible = 1;
  else
   $visible = 0;
  $newentry = new stdClass ();
  $newentry->id = $ilm_id;
  $newentry->enable = $visible;

  if (! $DB->update_record ( "iassign_ilm", $newentry ))
   error ( get_string ( 'error_edit_ilm', 'iassign' ) );
  }

 /**
  * Function for confirm change default iLM.
  * @param int $ilm_id Id of iLM.
  * @param int $ilm_parent Id of parent iLM.
  * @return string Return with an string for create default page confirmation.
  */
 static function confirm_default_ilm($ilm_id, $ilm_parent) {
  global $OUTPUT, $DB;

  $iassign_ilm = $DB->get_record ( 'iassign_ilm', array ('id' => $ilm_id ) );

  $optionsno = new moodle_url ( '/admin/settings.php', array ('section' => 'modsettingiassign','action' => 'config','ilm_id' => $ilm_parent ) );
  $optionsyes = new moodle_url ( '/mod/iassign/settings_ilm.php', array ('action' => 'default','ilm_id' => $ilm_id,'ilm_parent' => $ilm_parent ) );

  $return = $OUTPUT->heading ( get_string ( 'confirm_default', 'iassign' ) . ': ' . $iassign_ilm->name );
  $return .= $OUTPUT->confirm ( get_string ( 'confirm_default_ilm', 'iassign' ) . $OUTPUT->help_icon ( 'confirm_default_ilm', 'iassign' ), $optionsyes, $optionsno );
  return $return;
  }

 /**
  * Function for change default iLM.
  * @param int $ilm_id Id of iLM.
  * @return int Return Id of default iLM.
  */
 static function default_ilm($ilm_id) {
  global $DB;

  $iassign_ilm_default = $DB->get_record ( "iassign_ilm", array ('id' => $ilm_id ) );

  $iassign_ilm = $DB->get_record ( "iassign_ilm", array ('id' => $iassign_ilm_default->parent ) );

  $DB->delete_records ( "iassign_ilm", array ('id' => $iassign_ilm_default->id ) );

  $iassign_ilm_default->id = $iassign_ilm->id;
  $iassign_ilm_default->parent = 0;
  $iassign_ilm->parent = $iassign_ilm_default->id;
  $iassign_ilm->id = 0;
  $iassign_ilm_default->enable = 1;

  if (! $DB->update_record ( "iassign_ilm", $iassign_ilm_default ))
   print_error ( 'error_edit_ilm', 'iassign' );

  if (! $DB->insert_record ( "iassign_ilm", $iassign_ilm ))
   print_error ( 'error_add_ilm', 'iassign' );

  return $iassign_ilm_default->id;
  }

 /**
  * Function for confirm delete iLM.
  * @param int $ilm_id Id of iLM.
  * @param int $ilm_parent Id of parent iLM.
  * @return string Return with an string for create delete page confirmation.
  */
 static function confirm_delete_ilm($ilm_id, $ilm_parent) {
  global $OUTPUT, $DB;

  $iassign_ilm = $DB->get_record ( 'iassign_ilm', array ('id' => $ilm_id ) );

  $optionsno = new moodle_url ( '/admin/settings.php', array ('section' => 'modsettingiassign','action' => 'config','ilm_id' => $ilm_parent ) );
  $optionsyes = new moodle_url ( '/mod/iassign/settings_ilm.php', array ('action' => 'delete','ilm_id' => $ilm_id,'ilm_parent' => $ilm_parent ) );

  return $OUTPUT->confirm ( get_string ( 'confirm_delete_ilm', 'iassign', $iassign_ilm->name.' '.$iassign_ilm->version ), $optionsyes, $optionsno );
  }

 /**
  * Function for delete iLM.
  * @param int $ilm_id Id of iLM.
  * @return int Return Id of parent iLM.
  */
 static function delete_ilm($ilm_id) {
  global $DB, $CFG;

  $iassign_ilm = $DB->get_record ( 'iassign_ilm', array ('id' => $ilm_id ) );

  $fs = get_file_storage ();
  $contextsystem = context_system::instance();

  $files_jar = explode ( ",", $iassign_ilm->file_jar );
  foreach ( $files_jar as $file_jar ) {
   $file = $fs->get_file_by_id($file_jar);
   if ($file)
    $fs->delete_area_files($contextsystem->id, 'mod_iassign', 'ilm', $file->get_itemid());
  }

  $DB->delete_records ( "iassign_ilm", array ('id' => $ilm_id ) );

  $DB->delete_records ( "iassign_ilm_config", array ('iassign_ilmid' => $ilm_id ) );

  // log event --------------------------------------------------------------------------------------
  log::add_log('delete_iassign_ilm', 'name: '.$iassign_ilm->name.' '.$iassign_ilm->version, 0, $iassign_ilm->id);
  // log event --------------------------------------------------------------------------------------

  return $iassign_ilm->parent;
   }

 /**
  * Function for export iLM package for install in other Moodle.
  * @param int $ilm_id Id of iLM.
  */
 static function export_ilm($ilm_id) {
  global $DB, $CFG;

  $iassign_ilm = $DB->get_record ( 'iassign_ilm', array ('id' => $ilm_id ) );

  $iassign_ilm_configs = $DB->get_records ( 'iassign_ilm_config', array ('iassign_ilmid' => $ilm_id ) );

  $zip_filename = $CFG->dataroot.'/temp/ilm-'.utils::format_pathname($iassign_ilm->name.'-v'.$iassign_ilm->version).'.ipz';
  $zip = new zip_archive();
  $zip->open($zip_filename);
  $fs = get_file_storage ();
  $files_id = explode(',',$iassign_ilm->file_jar);
  $files_jar = "";
  foreach($files_id as $file_id) {
   $file = $fs->get_file_by_id($file_id);
   if (!$file->is_directory()) {
    $zip->add_file_from_string($file->get_filename(), $file->get_content());
    $files_jar .= $file->get_filename();
    }
   }
  $application_descriptor = '<?xml version="1.0" encoding="utf-8"?>'."\n";
  $application_descriptor .= '<application xmlns="http://line.ime.usp.br/application/1.5">'."\n";
  $application_descriptor .= "\t".'<name>'.$iassign_ilm->name.'</name>'."\n";
  $application_descriptor .= "\t".'<url>'.$iassign_ilm->url.'</url>'."\n";
  $application_descriptor .= "\t".'<version>'.$iassign_ilm->version.'</version>'."\n";
  $application_descriptor .= "\t".'<description>'.html_entity_decode(str_replace(array('<p>','</p>'), array('',''), $iassign_ilm->description)).'</description>'."\n";
  $application_descriptor .= "\t".'<extension>'.$iassign_ilm->extension.'</extension>'."\n";
  $application_descriptor .= "\t".'<file_jar>'.$files_jar.'</file_jar>'."\n";
  $application_descriptor .= "\t".'<file_class>'.$iassign_ilm->file_class.'</file_class>'."\n";
  $application_descriptor .= "\t".'<width>'.$iassign_ilm->width.'</width>'."\n";
  $application_descriptor .= "\t".'<height>'.$iassign_ilm->height.'</height>'."\n";
  $application_descriptor .= "\t".'<evaluate>'.$iassign_ilm->evaluate.'</evaluate>'."\n";
  if ($iassign_ilm_configs) {
   $application_descriptor .= "\t".'<params>'."\n";
   foreach($iassign_ilm_configs as $iassign_ilm_config) {
    $application_descriptor .= "\t\t".'<param>'."\n";
    $application_descriptor .= "\t\t\t".'<type>'.$iassign_ilm_config->param_type.'</type>'."\n";
    $application_descriptor .= "\t\t\t".'<name>'.$iassign_ilm_config->param_name.'</name>'."\n";
    $application_descriptor .= "\t\t\t".'<value>'.$iassign_ilm_config->param_value.'</value>'."\n";
    $application_descriptor .= "\t\t\t".'<description>'.htmlentities(str_replace("\n", "", $iassign_ilm_config->description)).'</description>'."\n";
    $application_descriptor .= "\t\t\t".'<visible>'.$iassign_ilm_config->visible.'</visible>'."\n";
    $application_descriptor .= "\t\t".'</param>'."\n";
    }
   $application_descriptor .= "\t".'</params>'."\n";
   }
  $application_descriptor .= '</application>'."\n";
  $zip->add_file_from_string('ilm-application.xml', $application_descriptor);
  $zip->close();

  header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        header("Content-Type: application/zip");
        header("Content-Disposition: attachment; filename=\"".basename($zip_filename)."\";");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".@filesize($zip_filename));
        set_time_limit(0);
        @readfile("$zip_filename") or die("File not found.");
        unlink($zip_filename);
     exit;
  }

 /**
  * Function for export iLM package descriptor for allow online update.
  * @param int $ilm_id Id of iLM.
  */
 static function export_update_ilm($ilm_id) {
  global $DB, $CFG;

  $iassign_ilm = $DB->get_record ( 'iassign_ilm', array ('id' => $ilm_id ) );

  $xml_filename = $CFG->dataroot.'/temp/ilm-upgrade_'.utils::format_pathname($iassign_ilm->name).'.xml';
  $zip_filename = 'ilm-'.utils::format_pathname($iassign_ilm->name.'-v'.$iassign_ilm->version).'.ipz';

  $upgrade_descriptor = '<?xml version="1.0" encoding="utf-8"?>'."\n";
  $upgrade_descriptor .= '<upgrade xmlns="http://line.ime.usp.br/application/1.5">'."\n";
  $upgrade_descriptor .= "\t".'<version>'.$iassign_ilm->version.'</version>'."\n";
  $upgrade_descriptor .= "\t".'<file>'.$zip_filename.'</file>'."\n";
  $upgrade_descriptor .= "\t".'<description>'.language::json_to_xml($iassign_ilm->description)."\n\t".'</description>'."\n";
  $upgrade_descriptor .= '</upgrade>'."\n";

  file_put_contents($xml_filename, $upgrade_descriptor);

  header("Pragma: public");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Cache-Control: private",false);
  header('Content-Type: application/xml; charset=utf-8');
  header("Content-Disposition: attachment; filename=\"".basename($xml_filename)."\";");
  header("Content-Length: ".@filesize($xml_filename));
  set_time_limit(0);
  @readfile("$xml_filename") or die("File not found.");
  unlink($xml_filename);
  exit;
  }

 /**
  * Function for save iLM from XML descriptor.
  * @param array $application_xml Data of XML descriptor.
  * @param array $files_extract Filenames of extract files.
  * @return array Return an array content id of JAR files.
  */
 static function save_ilm_by_xml($application_xml, $files_extract) {
  global $CFG, $USER;

  $fs = get_file_storage ();
  $file_jar = array();
  $files_ilm = explode(",", $application_xml->file_jar);
  $contextsystem = context_system::instance();

  foreach ( $files_ilm as $value ) {
   $file_ilm = array(
     'userid' => $USER->id,
     'contextid' => $contextsystem->id,
     'component' => 'mod_iassign',
     'filearea' => 'ilm',
     'itemid' => rand(1, 999999999),
     'filepath' => '/iassign/ilm/'.utils::format_pathname($application_xml->name).'/'.utils::format_pathname($application_xml->version).'/',
     'filename' => $value);

   $file_ilm = $fs->create_file_from_pathname($file_ilm, $CFG->dataroot.'/temp/'.$value);

   array_push ( $file_jar, $file_ilm->get_id() );
   }

  foreach ( $files_extract as $key => $value ) {
   $file = $CFG->dataroot.'/temp/'.$key;
   if (file_exists($file))
    unlink($file);
   }
  return $file_jar;
   }

 /**
  * Function for import the iLM from an package.
  * @param int $itemid Itemid of zip file.
  */
 static function import_ilm($itemid) {
  global $DB, $CFG, $USER, $OUTPUT;

  $pathtemp = $CFG->dataroot.'/temp/';

   $contextuser = context_user::instance($USER->id);

   $fs = get_file_storage ();
   $zip = new zip_packer();
   $files = $fs->get_directory_files($contextuser->id, 'user', 'draft', $itemid, '/');
   foreach($files as $file) {
    if (!$file->is_directory())
     $files_extract = $zip->extract_to_pathname($file, $pathtemp);
    }

   $application_xml = @simplexml_load_file($CFG->dataroot.'/temp/'.'ilm-application.xml', null, LIBXML_NOCDATA);

   $iassign_ilm = $DB->get_record ( 'iassign_ilm', array ("name" => (String) $application_xml->name, "version" => (String) $application_xml->version) );
   if ($iassign_ilm) {
    foreach ( $files_extract as $key => $value ) {
     $file = $CFG->dataroot.'/temp/'.$key;
     if (file_exists($file))
      unlink($file);
     }

    echo($OUTPUT->notification(get_string ( 'error_import_ilm_version', 'iassign' ), 'notifyproblem'));
    } else {

    $file_jar = self::save_ilm_by_xml($application_xml, $files_extract);

    if (empty ( $file_jar ))
     print_error ( 'error_add_ilm', 'iassign' );
    else {
     $description_str = html_entity_decode((String) $application_xml->description);

     $iassign_ilm = $DB->get_record ( 'iassign_ilm', array ("parent" => 0, "name" => (String) $application_xml->name) );
     if (!$iassign_ilm) {
      $iassign_ilm = new stdClass ();
      $iassign_ilm->id = 0;
      }

     $newentry = new stdClass ();
     $newentry->name = (String) $application_xml->name;
     $newentry->version = (String) $application_xml->version;
     $newentry->url = (String) $application_xml->url;
     $newentry->description = $description_str;
     $newentry->extension = strtolower((String) $application_xml->extension);
     $newentry->file_jar = implode(",", $file_jar);
     $newentry->file_class = (String) $application_xml->file_class;
     $newentry->width = (String) $application_xml->width;
     $newentry->height = (String) $application_xml->height;
     $newentry->enable = 0;
     $newentry->timemodified = time ();;
     $newentry->author = $USER->id;
     $newentry->timecreated = time ();;
     $newentry->evaluate = (String) $application_xml->evaluate;
     $newentry->parent = $iassign_ilm->id;

     $iassign_ilmid = $DB->insert_record ( "iassign_ilm", $newentry );

     foreach ( $application_xml->params->param as $value ) {

      $newentry = new stdClass ();
      $newentry->iassign_ilmid = $iassign_ilmid;
      $newentry->param_type = (String) $value->type;
      $newentry->param_name = (String) $value->name;
      $newentry->param_value = (String) $value->value;
      $newentry->description =  html_entity_decode((String) $value->description);
      $newentry->visible = (String) $value->visible;

      $newentry->id = $DB->insert_record ( "iassign_ilm_config", $newentry );
      if (! $newentry->id) {
       print_error ( 'error_add_param', 'iassign' );
       }
      }
     }
    echo($OUTPUT->notification(get_string ( 'ok_import_ilm_version', 'iassign' ), 'notifysuccess'));
    }

   $fs->delete_area_files($contextuser->id, 'user', 'draft', $itemid);
  }

 /**
  * Function for list iLM defaults.
  * @return string Return an string with a table of iLM.
  */
 static function list_ilm() {
  global $DB, $OUTPUT;

  $iassign_ilm = $DB->get_records ( 'iassign_ilm', array ("enable" => 1 ) );

  $str = '';
  $str .= '<table id="outlinetable" cellpadding="5" width="100%" >' . chr ( 13 );
  $str .= '<tr><td align=right><input type=button value="' . get_string ( 'close', 'iassign' ) . '"  onclick="javascript:window.close ();"></td></tr>';

  if ($iassign_ilm) {
   foreach ( $iassign_ilm as $ilm ) {

    $url_view = new moodle_url ( '/mod/iassign/settings_ilm.php', array ('action' => 'view','ilm_id' => $ilm->id ) );
    $link_view = $OUTPUT->action_link ( $url_view, icons::insert ( 'view_ilm' ).' '.get_string ( 'read_more', 'iassign' ) );

    $str .= '<tr><td>';
    $str .= '<table class="generaltable boxaligncenter" width="100%">';

    $str .= '<tr>';
    $str .= '<td class=\'cell c0 actvity\' width=40%><strong>' . get_string ( 'name_ilm', 'iassign' ) . ':</strong>&nbsp;' . $ilm->name . '</td>' . chr ( 13 );
    $str .= '<td><strong>' . get_string ( 'version_ilm', 'iassign' ) . ':</strong>&nbsp;' . $ilm->version . '</td>' . chr ( 13 );
    $str .= '<td align=right>' . $link_view . '</td>' . chr ( 13 );
    $str .= '</tr>';
    $str .= '<tr><td colspan=3>' . language::get_description_lang(current_language(), $ilm->description) . '</td></tr>';
    $str .= '<tr><td colspan=3><a href="'.$ilm->url.'">' . $ilm->url . '</a></td></tr>';

    $str .= '</table>';
    $str .= '</td></tr>';
    }
   }
  $str .= '</table>';

  return $str;
   }

 /**
  * Function for download and install an upgrade of an iLM.
  * @param int $ilm_id Id of iLM.
  */
 static function upgrade_ilm($ilm_id) {
  global $DB, $CFG, $USER;

  $iassign_ilm = $DB->get_record ( 'iassign_ilm', array ('id' => $ilm_id ) );

  $upgrade_file = $iassign_ilm->url.'ilm-upgrade_'.strtolower($iassign_ilm->name).'.xml';

  $update_xml = @simplexml_load_file($upgrade_file, null, LIBXML_NOCDATA);

  $result = file_put_contents($CFG->dataroot.'/temp/'.$update_xml->file, fopen($iassign_ilm->url.$update_xml->file, 'r'));

  if (!$result)
   print_error ( 'error_upgrade_ilm', 'iassign' );
  else {
   $zip_filename = $CFG->dataroot.'/temp/'.$update_xml->file;
   $extension = explode(".", $zip_filename);
   if ($extension[count($extension)-1] != 'ipz') {
    echo($OUTPUT->notification(get_string ( 'error_upload_ilm', 'iassign' ), 'notifyproblem'));
    die;
    }
   $zip = new zip_packer();
   $fs = get_file_storage();
   $contextuser = context_user::instance($USER->id);
   $files_extract = $zip->extract_to_pathname($zip_filename, $CFG->dataroot.'/temp/');

   $application_xml = @simplexml_load_file($CFG->dataroot.'/temp/'.'ilm-application.xml', null, LIBXML_NOCDATA);
   $description_str = htmlentities(str_replace(array('<description>','</description>'), array('',''), $application_xml->description->asXML()));

   $file_jar = self::save_ilm_by_xml($application_xml, $files_extract);

   if (file_exists($zip_filename))
    unlink($zip_filename);

   if (empty ( $file_jar ))
    print_error ( 'error_add_ilm', 'iassign' );
   else {
    $newentry = new stdClass ();
    $newentry->name = (String) $application_xml->name;
    $newentry->version = (String) $application_xml->version;
    $newentry->url = (String) $application_xml->url;
    $newentry->description = $description_str;
    $newentry->extension = strtolower((String) $application_xml->extension);
    $newentry->file_jar = implode(",", $file_jar);
    $newentry->file_class = (String) $application_xml->file_class;
    $newentry->width = (String) $application_xml->width;
    $newentry->height = (String) $application_xml->height;
    $newentry->enable = 0;
    $newentry->timemodified = time ();;
    $newentry->author = $USER->id;
    $newentry->timecreated = time ();;
    $newentry->evaluate = (String) $application_xml->evaluate;
    $newentry->parent = $ilm_id;

    $newentry->id = $DB->insert_record ( "iassign_ilm", $newentry );
    }

   }

  return $iassign_ilm->id;
  }

 /**
  * Function for select activities for move for other iLM.
  */
 static function confirm_move_iassign($ilmid, $ilm_parent) {
  global $PAGE, $OUTPUT, $CFG, $DB;

  $code_javascript_ilm = "
  <script type='text/javascript'>
   //<![CDATA[
       function getRadiobutton() {
        var radioButtons = document.getElementsByTagName('input');
             var param = '';
             for (var counter=0; counter < radioButtons.length; counter++) {
              if (radioButtons[counter].type.toUpperCase()=='RADIO' && radioButtons[counter].checked == true && radioButtons[counter].name == 'selected_ilm')
                  param = radioButtons[counter].value;
              }
             return param;
           }
   function move_selected_ilm () {
        var resp;
        if (getRadiobutton() != '') {
         resp=confirm('" . get_string ( 'question_move_iassign', 'iassign' ) . "');
         if (resp)
          window.location='$CFG->wwwroot/mod/iassign/settings_ilm.php?action=move_iassign&ilm_id=$ilmid&ilm_parent=$ilm_parent&ilmselected='+getRadiobutton();
       } else
       alert('" . get_string ( 'error_ilm_not_selected_to_move', 'iassign' ) . "');
    }
   function cancel_selected_ilm () {
    window.location='$CFG->wwwroot/admin/settings.php?section=modsettingiassign&action=config&ilm_id=$ilm_parent';
    }
  //]]>
  </script>";

  $str = "";

  $str .= $OUTPUT->heading(get_string('move_iassign', 'iassign'));
  $str .= $OUTPUT->box_start();

  $str .= "<center>";

  $ilm = $DB->get_record ( 'iassign_ilm', array ("id" => $ilmid ) );

  $iassign_statements = $DB->get_records ( 'iassign_statement', array ("iassign_ilmid" => $ilmid ) );
  if ($iassign_statements)
   $total = count ( $iassign_statements );
  else
   $total = 0;

  $str .= "<p>$total&nbsp;".get_string ( 'activities', 'iassign' )." - ".$ilm->name." ".$ilm->version."</p>";

  $str .= $OUTPUT->heading(get_string ( 'select_move_iassign', 'iassign' ), 3, 'move', 'move_iassign');

  $iassign_ilms = $DB->get_records ( 'iassign_ilm' );
  if ($iassign_ilms) {
   foreach ($iassign_ilms as $iassign_ilm) {
    if ($iassign_ilm->name == $ilm->name && $iassign_ilm->id != $ilm->id ) {
     $check_select = "<input name='selected_ilm' type='radio' value='".$iassign_ilm->id."'/>";
     $str .= "<p>".$check_select."&nbsp;".icons::insert ('icon' )."&nbsp;".$iassign_ilm->name." ".$iassign_ilm->version."</p>";
     }
    }
  }

  $str .= "<p><input type='button' value='".get_string ( 'ok' )."' onclick='move_selected_ilm();'/>&nbsp;&nbsp;&nbsp;&nbsp;";
  $str .= "<input type='button' value='".get_string ( 'cancel' )."' onclick='cancel_selected_ilm();'/></p>";
  $str .= "</center>";
  $str .= $code_javascript_ilm;
  $str .= $OUTPUT->box_end();

  return $str;
  }

 /**
  * Function for move activities for other iLM.
  * @param int $ilm_id Id of iLM.
  * @return int Return Id of parent iLM.
  */
 static function move_iassign($ilm_id) {
  global $DB, $CFG;

  $ilmselected = optional_param('ilmselected', 0, PARAM_INT);

  $iassign_statements = $DB->get_records ( 'iassign_statement', array ("iassign_ilmid" => $ilm_id ) );
  if ($iassign_statements) {
   foreach ($iassign_statements as $iassign_statement) {
    if ($ilmselected != 0) {
     $iassign_statement->iassign_ilmid = $ilmselected;
     if (! $DB->update_record ( "iassign_statement", $iassign_statement ))
      print_error ( 'error_update_move_iassign', 'iassign' );
     }
    }
   }
  }

 /**
  * Function for list iLM versions with all informations.
  * @return string Return an string with a table of iLM.
  */
 static function view_ilm($ilmid, $from) {
  global $CFG, $DB;

  $param_enable = optional_param_array('enable', array(), PARAM_TEXT);
  $param_value = (empty($_POST['value']) ? array() : $_POST['value']);

  //print_r($param_enable);
  //print_r($param_value);

  $url = new moodle_url ( '/admin/settings.php', array ('section' => 'modsettingiassign' ) );
  $iassign_ilm = $DB->get_record ( 'iassign_ilm', array ('id' => $ilmid ) );

  $str = "";
  $str .= '<table id="outlinetable" cellpadding="5" width="100%" >' . chr ( 13 );
  $str .= '<tr>';
  $str .= '<td colspan=3 align=right>';
  if ($from != 'admin')
   $str .= '<input type=button value="' . get_string ( 'return', 'iassign' ) . '"  onclick="javascript:window.location = \''.$_SERVER['HTTP_REFERER'].'\';">';
  $str .= '<input type=button value="' . get_string ( 'close', 'iassign' ) . '"  onclick="javascript:window.close ();">';
  $str .= '</td>' . chr ( 13 );
  $str .= '</tr>';

  if ($iassign_ilm) {
   $iassign_statement = $DB->get_records ( 'iassign_statement', array ("iassign_ilmid" => $iassign_ilm->id ) );
   if ($iassign_statement)
    $total = count ( $iassign_statement );
   else
    $total = 0;

   if ($from == 'admin') {
    $str .= '<tr><td colspan=2>';
    $str .= '<table width="100%" class="generaltable boxaligncenter" >';
    $str .= '<tr>' . chr ( 13 );
    $str .= '<td class=\'cell c0 actvity\' ><strong>' . get_string ( 'activities', 'iassign' ) . ':</strong>&nbsp;' . $total . '</td>' . chr ( 13 );
    $str .= '<td><strong>' . get_string ( 'url_ilm', 'iassign' ) . ':</strong>&nbsp;<a href="' . $iassign_ilm->url . '">' . $iassign_ilm->url . '</a></td>';
    $str .= '</tr>' . chr ( 13 );
    $str .= '<tr><td colspan=2><strong>' . get_string ( 'description', 'iassign' ) . ':</strong>&nbsp;' . language::get_description_lang(current_language(), $iassign_ilm->description) . '</td></tr>';
    $str .= '<tr><td width="50%"><strong>' . get_string ( 'extension', 'iassign' ) . ':</strong>&nbsp;' . $iassign_ilm->extension . '</td>';
    $str .= '<td width="50%"><strong>' . get_string ( 'width', 'iassign' ) . ':</strong>&nbsp;' . $iassign_ilm->width;
    $str .= '&nbsp;&nbsp;<strong>' . get_string ( 'height', 'iassign' ) . ':</strong>&nbsp;' . $iassign_ilm->height . '</td></tr>';
    //$files_jar = explode ( ",", $iassign_ilm->file_jar );
    $date_jar = ilm_settings::applet_filetime($iassign_ilm->file_jar);
    //foreach ( $files_jar as $files )
     //$date_jar .= '</br>' . chr ( 13 ) . $files . ' (' . userdate ( filemtime ( $CFG->dirroot . '/mod/iassign/ilm/' . $files ) ) . ')';

    $str .= '<tr><td><strong>' . get_string ( 'file_jar', 'iassign' ) . '</strong>&nbsp;' . $date_jar . '</td>';
    $str .= '<td ><strong>' . get_string ( 'file_class', 'iassign' ) . ':</strong>&nbsp;' . $iassign_ilm->file_class . '</td></tr>';
    if ($iassign_ilm->evaluate == 1)
     $evaluate = get_string ( 'yes', 'iassign' );
    else
     $evaluate = get_string ( 'no', 'iassign' );

    $str .= '<tr><td width="50%"><strong>' . get_string ( 'evaluate', 'iassign' ) . ':</strong>&nbsp;' . $evaluate . '</td>';
    if ($iassign_ilm->enable == 1)
     $enable = get_string ( 'yes', 'iassign' );
    else
     $enable = get_string ( 'no', 'iassign' );
    $str .= '<td width="50%"><strong>' . get_string ( 'enable', 'iassign' ) . ':</strong>&nbsp;' . $enable . '</td></tr>';
    $str .= '<tr>' . chr ( 13 );
    $str .= '<td width="50%"><strong>' . get_string ( 'file_created', 'iassign' ) . ':</strong>&nbsp;' . userdate ( $iassign_ilm->timecreated ) . '</td>';
    $str .= '<td width="50%"><strong>' . get_string ( 'file_modified', 'iassign' ) . ':</strong>&nbsp;' . userdate ( $iassign_ilm->timemodified ) . '</td>' . chr ( 13 );
    $str .= '</tr>' . chr ( 13 );
    $user_ilm = $DB->get_record ( 'user', array ('id' => $iassign_ilm->author ) );
    $str .= '<tr>' . chr ( 13 );
    $str .= '<td colspan=2><strong>' . get_string ( 'author', 'iassign' ) . ':</strong>&nbsp;' . $user_ilm->firstname . '&nbsp;' . $user_ilm->lastname . '</td>';
    $str .= '</tr>' . chr ( 13 );
    $str .= '</table>';
    $str .= '</td></tr>';
    }


   if (! empty ( $iassign_ilm->file_jar )) {

    $options = array("type" => "view");
    foreach($param_enable as $key => $value) {
     $param_options = (!empty($param_value[$key]) ? $param_value[$key] : '0');
     $param_options = (is_array($param_options) ? implode(",", $param_options) : $param_options);
     $options[$key] = $param_options;
     }

    //print_r($options);

    $str .= '<tr class=\'cell c0 actvity\'><td  colspan=3 align=center bgcolor="#F5F5F5">';
    $str .= ilm_settings::applet_ilm($iassign_ilm->id, $options);


    $conditions = array ('iassign_ilmid' => $iassign_ilm->id );
    if ($from != 'admin')
     $conditions['visible'] = '1';

    $iassign_ilm_config = $DB->get_records('iassign_ilm_config', $conditions);

    if ($iassign_ilm_config) {

     $str .= '<form  method="POST">';

     $str .= '<table width="100%" class="generaltable boxaligncenter" >';
     $str .= '<tr>' . chr ( 13 );
     $str .= '<th colspan=5><center><strong>' . get_string ( 'config_param', 'iassign' ) . '</strong></center></th>';
     $str .= '</tr>' . chr ( 13 );

     $str .= '<tr>' . chr ( 13 );
     $str .= '<td width="5%"><strong>' . get_string ( 'enable', 'iassign' ) . '</strong></td>';
     $str .= '<td width="5%"><strong>' . get_string ( 'choose_type_param', 'iassign' ) . '</strong></td>';
     $str .= '<td width="10%"><strong>' . get_string ( 'config_param_name', 'iassign' ) . '</strong></td>';
     $str .= '<td width="20%"><strong>' . get_string ( 'config_param_value', 'iassign' ) . '</strong></td>';
     $str .= '<td><strong>' . get_string ( 'config_param_description', 'iassign' ) . '</strong></td>';
     $str .= '</tr>' . chr ( 13 );


     foreach ($iassign_ilm_config as $ilm_config) {

      $selected = '';
      if (!empty($param_enable))
      if (array_key_exists($ilm_config->param_name, $param_enable))
       $selected = ' checked';

      $value = $ilm_config->param_value;
      if (!empty($param_value))
       if (array_key_exists($ilm_config->param_name, $param_enable))
        $value = (!empty($param_value[$ilm_config->param_name]) ? $param_value[$ilm_config->param_name] : '0');

      $str .= '<tr>' . chr ( 13 );
      if ($ilm_config->param_type != 'static')
       $str .= '<td><center><input type="checkbox" name="enable['.$ilm_config->param_name.']" '.$selected.'/></center></td>';
      else if ($from == 'admin')
       $str .= '<td><center>-</center></td>';
      if ($from == 'admin' || $ilm_config->param_type != 'static') {
       $str .= '<td>' . get_string ( 'param_type_'.$ilm_config->param_type, 'iassign' ) . '</td>';
       $str .= '<td>' . $ilm_config->param_name . '</td>';
       }
      if ($ilm_config->param_type == 'static' && $from == 'admin')
       $str .= '<td>' . $ilm_config->param_value . '</td>';
      else if ($ilm_config->param_type == 'value') {
       $default = ' <b>('.get_string ( 'param_default', 'iassign' ).' '.$ilm_config->param_value.')</b>';
       $str .= '<td><input type="text" name="value['.$ilm_config->param_name.']" size="5" value="' . $value . '"/>'.$default.'</td>';
       } else if ($ilm_config->param_type == 'boolean') {
       $default = ' <b>('.get_string ( 'param_default', 'iassign' ).' '.($ilm_config->param_value == '1' ? get_string('yes'): get_string('no')).')</b>';
       $str .= '<td><input type="checkbox" name="value['.$ilm_config->param_name.']" value="1"'. ($value == '1' ? ' checked' : '') . '/>'.$default.'</td>';
       } else if ($ilm_config->param_type == 'choice') {

       $str .= '<td><select name="value['.$ilm_config->param_name.']">';
       $options = explode(", ", $ilm_config->param_value);
       $default = ' <b>('.get_string ( 'param_default', 'iassign' ).' '.$options[0].')</b>';
       foreach ($options as $option) {
        $selected = '';
        if ($option == $value)
         $selected = ' selected';
        $str .= '<option value="' . $option . '"'.$selected.'>'.$option.'</option>';
        }
       $str .= '</select>'.$default.'</td>';
       } else if ($ilm_config->param_type == 'multiple') {

       $value = array();
       if (!empty($param_value))
        if (array_key_exists($ilm_config->param_name, $param_enable))
         $value = $param_value[$ilm_config->param_name];

       $str .= '<td><select name="value['.$ilm_config->param_name.'][]" multiple style="width:100%">';
       $options = explode(", ", $ilm_config->param_value);
       foreach ($options as $option) {
        $selected = '';
        if (in_array($option, $value))
         $selected = ' selected';
        $str .= '<option value="' . $option . '"'.$selected.'>'.$option.'</option>';
        }
       $str .= '</select></td>';
       }
      if ($from == 'admin' || $ilm_config->param_type != 'static')
       $str .= '<td>' . $ilm_config->description . '</td>';
      $str .= '</tr>' . chr ( 13 );
      }

     $str .= '<tr><td colspan=5><input type="submit" value="Atualizar"/></td></tr>';

     $str .= '</form>';
     }

    } else {

    $str .= '<tr class=\'cell c0 actvity\'>';
    $str .= '<td colspan=2 align=center>' . get_string ( 'null_file', 'iassign' ) . '</td>';
    $str .= '<td align=center><a href="' . $url . '</a></td>';
    $str .= '</tr>';
    }
   $str .= '</td></tr>';

   $str .= '</td>' . chr ( 13 );
   $str .= '</tr>';

  }

  $str .= '</table>';

  return $str;
  }

 /**
  * Function for get form variables for add, edit, or copy iLM params.
  * @param int $ilm_param_id Id of iLM param.
  * @param string $action String with the action
  * @return object Return an object with forms variables.
  */
 static function add_edit_copy_param($ilm_param_id, $action) {
  global $DB;

  require_once ('params_form.php');
  $iassign_ilm_config = $DB->get_record ( 'iassign_ilm_config', array ('id' => $ilm_param_id ) );
  $param = new object ();
  $param->action = $action;
  $param->ilm_param_id = $ilm_param_id;

  $type = optional_param('type', NULL, PARAM_TEXT);
  if ($type == NULL && $iassign_ilm_config)
   $type = $iassign_ilm_config->param_type;

  if ($action == 'add') {
   $param->title = get_string ( 'add_ilm', 'iassign' );
   $param->iassign_ilmid = $ilm_param_id;
   $param->param_name = "";
   $param->param_value = "";
   $param->description = "";
   $param->visible = 1;
   } elseif ($action == 'edit') {
   if ($iassign_ilm_config) {
    $param->title = get_string ( 'edit_ilm', 'iassign' );
    $param->id = $iassign_ilm_config->id;
    $param->iassign_ilmid = $iassign_ilm_config->iassign_ilmid;
    $param->param_type = $type;
    $param->param_name = $iassign_ilm_config->param_name;
    if ($type != 'choice' && $type != 'multiple')
     $param->param_value = $iassign_ilm_config->param_value;
    else
     $param->param_value = str_replace(", ", "\n", $iassign_ilm_config->param_value);
    $param->description = $iassign_ilm_config->description;
    $param->visible = $iassign_ilm_config->visible;
    }
   } elseif ($action == 'copy') {
   if ($iassign_ilm_config) {
    $param->title = get_string ( 'copy_ilm', 'iassign' );
    $param->iassign_ilmid = $iassign_ilm_config->iassign_ilmid;
    $param->param_type = $type;
    $param->param_name = $iassign_ilm_config->param_name;
    if ($type != 'choice' && $type != 'multiple')
     $param->param_value = $iassign_ilm_config->param_value;
    else
     $param->param_value = str_replace(", ", "\n", $iassign_ilm_config->param_value);
    $param->description = $iassign_ilm_config->description;
    $param->visible = $iassign_ilm_config->visible;
    }
   }
  return $param;
  }

 /**
  * Function for change visibility of iLM param.
  * @param int $ilm_param_id Id of iLM param.
  * @param int $status Indicator of change vibility (0 = hide, 1 = show).
  */
 static function visible_param($ilm_param_id, $status) {
  global $DB, $CFG;
  if ($status == 0)
   $visible = 1;
  else
   $visible = 0;
  $newentry = new stdClass ();
  $newentry->id = $ilm_param_id;
  $newentry->visible = $visible;

  if (! $DB->update_record ( "iassign_ilm_config", $newentry ))
   error ( get_string ( 'error_edit_param', 'iassign' ) );
  }

 /**
  * Function for save in database an new iLM param.
  * @param object $param An object with iLM params.
  */
 static function add_param($param) {
  global $DB;

  $newentry = new stdClass ();
  $newentry->iassign_ilmid = $param->iassign_ilmid;
  $newentry->param_type = $param->param_type;
  $newentry->param_name = utils::format_filename($param->param_name);
  if ($newentry->param_type != 'choice' && $newentry->param_type != 'multiple')
   $newentry->param_value = $param->param_value;
  else
   $newentry->param_value = str_replace("\r\n", ", ", $param->param_value);
  $newentry->description = $param->description;
  $newentry->visible = $param->visible;

  $newentry->id = $DB->insert_record ( "iassign_ilm_config", $newentry );
  if (! $newentry->id) {
   print_error ( 'error_add_param', 'iassign' );
   }
  }

 /**
  * Function for save in database a iLM param edit.
  * @param object $param An object with iLM params.
  */
 static function edit_param($param) {
  global $DB;

  $updentry = new stdClass ();
  $updentry->id = $param->id;
  $updentry->iassign_ilmid = $param->iassign_ilmid;
  $updentry->param_type = $param->param_type;
  $updentry->param_name = utils::format_filename($param->param_name);
  if ($updentry->param_type != 'choice' && $updentry->param_type != 'multiple')
   $updentry->param_value = $param->param_value;
  else
   $updentry->param_value = str_replace("\r\n", ", ", $param->param_value);
  $updentry->description = $param->description;
  $updentry->visible = $param->visible;

  if (! $DB->update_record ( "iassign_ilm_config", $updentry )) {
   error ( get_string ( 'error_edit_param', 'iassign' ) );
   }
  }

 /**
  * Function for save in database a iLM param copy.
  * @param object $param An object with iLM params.
  */
 static function copy_param($param) {
  global $DB;

  $newentry = new stdClass ();
  $newentry->iassign_ilmid = $param->iassign_ilmid;
  $newentry->param_type = $param->param_type;
  $newentry->param_name = utils::format_filename($param->param_name);
  if ($newentry->param_type != 'choice' && $newentry->param_type != 'multiple')
   $newentry->param_value = $param->param_value;
  else
   $newentry->param_value = str_replace("\r\n", ", ", $param->param_value);
  $newentry->description = $param->description;
  $newentry->visible = $param->visible;

  $newentry->id = $DB->insert_record ( "iassign_ilm_config", $newentry );
  if (! $newentry->id) {
   print_error ( 'error_add_param', 'iassign' );
   }
  }

 /**
  * Function for delete iLM param of database.
  * @param int $param_id Id of iLM param.
  */
 static function delete_param($param_id) {
  global $DB;

  if (! $DB->delete_records( "iassign_ilm_config", array ('id' => $param_id ) )) {
   print_error ( 'error_delete_param', 'iassign' );
   }
   }
 }

/**
 * Class for manage iLM files (editor).
 *
 */
class ilm_manager {
 var $id; // course id
 var $url;
 var $from;

 /**
  * Constructor for the base ilm_manager class
  */
 function ilm_manager($id, $url, $from) {
  $this->id = $id; // course id
  $this->url = $url;
  $this->from = $from;
   }

 /**
  * Function for creating an new file in online editor
  */
 function ilm_editor_new() {
  global $CFG, $DB, $OUTPUT, $PAGE;

  $ilmid = optional_param ( 'ilmid', NULL, PARAM_INT ); // iAssign ID
  $dirid = optional_param ( 'dirid', NULL, PARAM_INT );
  $iassign = $DB->get_record ( "iassign_ilm", array ("id" => $ilmid ) );
  $context = context_course::instance($this->id );
  $returnurl = "$CFG->wwwroot/mod/iassign/ilm_manager.php?from=$this->from&id=$this->id&dirid=$dirid&ilmid=$ilmid";

  // verifica se o arquivo jar estÃ¡ cadastrado no BD
  if (! $iassign) {
   echo $OUTPUT->notification ( get_string ( 'error_confirms_ilm', 'iassign' ), 'notifysuccess' );
   die ();
  }

  $temp = explode(",", $iassign->extension);
        $extension = $temp[0];

  if (! empty ( $_POST )) {
   $string = $_POST ['MA_POST_Archive'];
   $filename = optional_param ( 'filename', NULL, PARAM_TEXT );
   $filename = utils::format_filename ( $filename );
   $arrayfilename = explode ( ".", $filename );
   if (count ( $arrayfilename ) == 1)
    $filename = $arrayfilename [0] . '.' . $extension;
   $this->write_file_iassign ( $string, $filename );
   die ();
   } else {
   $fs = get_file_storage();
   $files = $fs->get_area_files ( $context->id, 'mod_iassign', 'activity' );
   $files_array = '';
   foreach ( $files as $value ) {
    if ($value->get_filename () != ".")
     $files_array .= "'" . $value->get_filename () . "',";
    }

   $files_array .= "''";

   $file = null;
   $ia_content = "";
   $filename = "";
   $error_files_exists = get_string ( 'error_file_exists', 'iassign' );

   $output = "<script type='text/javascript'>
             //<![CDATA[
             function submit_MA_Answer () {
               var docForm = document.formEnvio;
               var resposta_exerc = new Array(3);
               var valor_resposta = new Array(3);
               var sessao = new Array(3);
               var doc = window.iLM;
               resposta_exerc[0] = doc.getAnswer();
               valor_resposta[0] = doc.getEvaluation();
               docForm.MA_POST_Value.value = valor_resposta[0];
               docForm.MA_POST_Archive.value = resposta_exerc[0];
               var files = new Array(" . $files_array . ");
               var filename=docForm.filename.value+'.'+'$extension';

               if (resposta_exerc[0] == -1) {
                 alert('" . get_string ( 'error_null_iassign', 'iassign' ) . "');
                 return false\n;
                }
               else{
                if (docForm.filename.value=='') {
                  alert('" . get_string ( 'error_file_null_iassign', 'iassign' ) . "');
                  return false;
                 }
               }
              for (i=0;i<files.length;i++) {
                if (files[i]==docForm.filename.value || files[i]==filename) {
                  alert('" . $error_files_exists . "');
                  return false;\n
                 }
               }
              docForm.submit();
              return true;
             }
            //]]>
            </script>";

   $output .= "
            <form name='formEnvio' id='formEnvio' method='post' enctype='multipart/form-data'> ";
   $output .= $OUTPUT->box_start ();
   $output .= "
              <table width='100%' cellpadding='20'>
              <tr><td>" . get_string ( 'label_file_iassign', 'iassign' ) . " <input type='text' name='filename' size=50/>
                <input type=button value='" . get_string ( 'label_write_iassign', 'iassign' ) . "' title='' onclick='submit_MA_Answer();'/></td>
              <td><input type=button value='" . get_string ( 'close', 'iassign' ) . "' title='' onclick='javascript:window.location = \"$returnurl\";'/></td>
              </tr>
              </table>";

   $output .= "<center>";
   $output .= ilm_settings::applet_ilm($ilmid, array( "type" => "editor_new", "notSEND" => "true"));

   $output .= "   <input type='hidden' name='MA_POST_Archive' value='" . $ia_content . "'>
   <input type='hidden' name='MA_POST_Value'>
   </center>
   </form>\n";

   $output .= $OUTPUT->box_end ();

   $title = get_string ( 'title_editor_iassign', 'iassign' )." - ".$iassign->name." ".$iassign->version;

   $PAGE->set_title($title);
   $PAGE->navbar->add($title);
   $PAGE->set_cacheable ( false );

   echo $OUTPUT->header ();
   echo $OUTPUT->heading ( $title );
   echo $output;
   echo $OUTPUT->footer ();
   }
  die ();
  }

 /**
  * Function for editing an file in online editor
  */
 function ilm_editor_update() {
  global $CFG, $DB, $OUTPUT, $PAGE;

  $ilmid = optional_param ( 'ilmid', NULL, PARAM_INT ); // iAssign ID
  $dirid = optional_param ( 'dirid', NULL, PARAM_INT );
  $fileid = optional_param ( 'fileid', NULL, PARAM_TEXT );
  $iassign = $DB->get_record ( "iassign_ilm", array ("id" => $ilmid ) );
  $returnurl = "$CFG->wwwroot/mod/iassign/ilm_manager.php?from=$this->from&id=$this->id&dirid=$dirid&ilmid=$ilmid";

  // verifica se o iMA nÃ£o estÃ¡ estÃ¡ cadastrado no BD
  if (!$iassign) {
   echo $OUTPUT->notification ( get_string ( 'error_confirms_ilm', 'iassign' ), 'notifyproblem' );
   die;
  }

  $fs = get_file_storage();
  $filename = '';
  $end_file = '';
  $file = $fs->get_file_by_id ( $fileid );
  if ($file)
   $filename = utils::format_filename ( $file->get_filename () );

  if (! empty ( $_POST )) {
   $string = $_POST ['MA_POST_Archive'];
   $this->update_file_iassign ( $string, $filename, $fileid );
   die ();
   } else {

   $end_file = '';
   if ($file) {
    $token = '';
    $view = - 1;
    $end_file = $CFG->wwwroot . '/mod/iassign/ilm_security.php?id=' . $fileid . '&token=' . $token . '&view=' . $view;
    }


   $output = "<script type='text/javascript'>
  //<![CDATA[
  function submit_MA_Answer () {
    var docForm = document.formEnvio;
    var resposta_exerc = new Array(3);
    var valor_resposta = new Array(3);
    var sessao = new Array(3);
    var doc = document.iLM;
    resposta_exerc[0] = doc.getAnswer();
    valor_resposta[0] = doc.getEvaluation();
    docForm.MA_POST_Value.value = valor_resposta[0];
    docForm.MA_POST_Archive.value = resposta_exerc[0];
    if (resposta_exerc[0] == -1) {
      alert('" . get_string ( 'error_null_iassign', 'iassign' ) . "');
      return false\n;
     }
    docForm.submit();
    return true;
   }
  //]]>
  </script>";

   $output .= "
            <form name='formEnvio' id='formEnvio' method='post' enctype='multipart/form-data'> ";
   $output .= $OUTPUT->box_start ();
   $output .= "
   <table width='100%' cellpadding='20'>
     <tr><td width='75%'>" . get_string ( 'label_file_iassign', 'iassign' ) . "<b>$filename</b></td>
      <td align='right' width='25%'><input type=button value='" . get_string ( 'label_write_iassign', 'iassign' ) . "' title='' onclick='submit_MA_Answer();'/>
        <input type='hidden' name='filename' value='$filename'/></td>
      <td>     <input type=button value='" . get_string ( 'close', 'iassign' ) . "' title='' onclick='javascript:window.location = \"$returnurl\";'/></td>
    </tr>      
   </table>";

   $output .= "<center>";
   $output .= ilm_settings::applet_ilm($ilmid, array( "type" => "editor_update", "notSEND" => "false", "Proposition" => $end_file));

   $output .= "  <input type='hidden' name='MA_POST_Archive' >
   <input type='hidden' name='MA_POST_Value'>
   </form>
   </center>";
    
   $output .= $OUTPUT->box_end ();
    
   $title = get_string ( 'title_editor_iassign', 'iassign' );

   $PAGE->set_title($title);
   $PAGE->navbar->add($title);
   $PAGE->set_cacheable ( false );

   echo $OUTPUT->header ();
   echo $OUTPUT->heading ( $title );
   echo $output;
   echo $OUTPUT->footer ();
   }
  die ();
  }

 /**
  * Function for write iassign file.
  * @param string $string Content of iassign file.
  * @param string $filename Filename of iassign file
  */
 function write_file_iassign($string, $filename) { //
  global $USER;

  $ilmid = optional_param ( 'ilmid', NULL, PARAM_INT );
  $context = context_course::instance($this->id );
  $fs = get_file_storage();
  $dirid = $this->get_dir_ilm('dirid');
  $dir = $fs->get_file_by_id ( $dirid );

  $fileinfo = array ('contextid' => $context->id,  // ID of course
  'component' => 'mod_iassign',  // usually = table name
  'filearea' => 'activity',  // usually = table name
  'itemid' => 0,  // usually = ID of row in table
  'filepath' => $dir->get_filepath(),  // any path beginning and ending in /
  'userid' => $USER->id,
  'author' => $USER->firstname . ' ' . $USER->lastname,'license' => 'allrightsreserved',  // allrightsreserved
  'filename' => $filename ); // Create file containing text. '$string'
  $file_course = $fs->create_file_from_string ( $fileinfo, $string );
  $output = "<script type='text/javascript'>
       //<![CDATA[
       alert('" . get_string ( 'sucess_write', 'iassign' ) . "');\n
       window.location='" . $this->url . "&dirid=$dirid&ilmid=$ilmid';
       //]]>
       </script>";
  echo $output;
  die ();
  }

 /**
  * Function for update iassign file.
  * @param string $string Content of iassign file.
  * @param string $filename Filename of iassign file
  * @param int $itemid Itemid of iassign file.
  */
 function update_file_iassign($string, $filename, $fileid) { //
  global $OUTPUT, $USER;

  $ilmid = optional_param ( 'ilmid', NULL, PARAM_INT );

  $fs = get_file_storage ();
  $file = $fs->get_file_by_id ( $fileid );
  if (!$file) {
   echo $OUTPUT->notification ( get_string ( 'error_view_ilm', 'iassign' ), 'notifyproblem' );
   die;
  }

  $context = context_course::instance($this->id );
  $dirid = $this->get_dir_ilm('dirid');

  $fileinfo = array ('contextid' => $context->id,  // ID of context
  'component' => 'mod_iassign',  // usually = table name
  'filearea' => 'activity',  // usually = table name
  'itemid' => 0,  // usually = ID of row in table
  'filepath' => $file->get_filepath(),  // any path beginning and ending in /
  'userid' => $USER->id,
  'author' => $USER->firstname . ' ' . $USER->lastname,
  'license' => 'allrightsreserved',  // allrightsreserved
  'timecreated' => $file->get_timecreated (),
  'filename' => $file->get_filename () ); // any filename
  $file->delete();
  $file_course = $fs->create_file_from_string ( $fileinfo, $string );

  $output = "<script type='text/javascript'>
       //<![CDATA[
       alert('" . get_string ( 'sucess_update', 'iassign' ) . "');\n
       window.location='" . $this->url . "&dirid=$dirid&ilmid=$ilmid';
       //]]>
       </script>";
  echo $output;
  die ();
  }

 /**
  * Function for create an tag for iassign filter.
  * @param int $fileid Id of file.
  * @return string Return an string with an tag of iassign filter.
  */
 function tag_ilm($fileid) {
  global $DB;

  $fs = get_file_storage();
  $width = '600';
  $height = '400';
  $file = $fs->get_file_by_id($fileid);
  $filetype = explode(".", $file->get_filename());
  $iassign_ilm = $DB->get_records ( 'iassign_ilm', array ("enable" => 1, "parent" => 0) );
  foreach ($iassign_ilm as $value) {
   $extensions = explode(",", $value->extension);
   if ( in_array($filetype[1], $extensions) ) {
    $width = $value->width;
    $height = $value->height;
    }
   }
  return("<p>&lt;ia toolbar=disable width=$width height=$height &gt;$fileid&lt;/ia&gt;</p>");
  }

 /**
  * Function for delete iassign file.
  */
 function delete_file_ilm() { //
  $ilmid = optional_param ( 'ilmid', NULL, PARAM_INT );

  $fs = get_file_storage ();
  $fileid = optional_param ( 'fileid', NULL, PARAM_TEXT );
  $file = $fs->get_file_by_id ( $fileid );
  if ($file)
   $file->delete();
  redirect ( new moodle_url ( $this->url."&dirid=".$this->get_dir_ilm('dirid')."&ilmid=$ilmid" ) );
  die ();
  }

 /**
  * Function for delete selected iassign file.
  */
 function delete_selected_ilm() { //
  $ilmid = optional_param ( 'ilmid', NULL, PARAM_INT );
  $fs = get_file_storage ();
  $context = context_course::instance($this->id );
  $files_id = explode(",", optional_param ( 'files_id', '', PARAM_TEXT ));
  $dirid = $this->get_dir_ilm('dirid');
  foreach ($files_id as $file_id) {
   $file = $fs->get_file_by_id ($file_id);
   if ($file) {
    if (!$file->is_directory())
     $file->delete();
    else {
     $files_delete = $fs->get_directory_files($context->id, 'mod_iassign', 'activity', 0, $file->get_filepath(), true, true);
     foreach ($files_delete as $value)
      $value->delete();
     $file->delete();
     }
    }
   }
  redirect ( new moodle_url ( $this->url."&dirid=".$dirid.'&ilmid=$ilmid' ) );
  die ();
  }

 /**
  * Function for duplicate iassign file.
  */
 function duplicate_file_ilm() {
  global $USER, $COURSE;

  $ilmid = optional_param ( 'ilmid', NULL, PARAM_INT );
  $fs = get_file_storage ();
  $fileid = optional_param ( 'fileid', NULL, PARAM_INT );
  $filename = optional_param ( 'filename', NULL, PARAM_TEXT );

  $file = $fs->get_file_by_id ( $fileid );
  $context = context_course::instance($this->id );

  $fileinfo = array ('contextid' => $context->id,  // ID of context
  'component' => 'mod_iassign',  // usually = table name
  'filearea' => 'activity',  // usually = table name
  'itemid' => 0,  // usually = ID of row in table
  'filepath' => $this->get_dir_ilm('dir_base'),  // any path beginning and ending in /
  'userid' => $USER->id,
  'author' => $USER->firstname . ' ' . $USER->lastname,'license' => 'allrightsreserved',  // allrightsreserved
  'timecreated' => $file->get_timecreated (),'filename' => $filename ); // any filename
  $newfile = $fs->create_file_from_string ( $fileinfo, $file->get_content () );

  redirect ( new moodle_url ( $this->url."&dirid=".$this->get_dir_ilm('dirid').'&ilmid=$ilmid' ) );
  die ();
  }

 /**
  * Function for rename iassign file.
  */
 function rename_file_ilm() {
  $ilmid = optional_param ( 'ilmid', NULL, PARAM_INT );
  $fs = get_file_storage ();
  $fileid = optional_param ( 'fileid', NULL, PARAM_INT );
  $filename = optional_param ( 'filename', NULL, PARAM_TEXT );

  $file = $fs->get_file_by_id ( $fileid );

  $file->rename($this->get_dir_ilm('dir_base'), $filename);

  redirect ( new moodle_url ( $this->url."&dirid=".$this->get_dir_ilm('dirid').'&ilmid=$ilmid' ) );
  die ();
  }

 /**
  * Function for get iassign file for iassign form.
  */
 function add_ilm() {
  $fileid = optional_param ( 'fileid', NULL, PARAM_INT );
  $filename = optional_param ( 'filename', NULL, PARAM_TEXT );

  $output = "<script type='text/javascript'>
  //<![CDATA[
  var iassign_file_link = window.opener.document.getElementById('iassign_file_link');
  iassign_file_link.innerHTML = '$filename';
  window.opener.document.forms['mform1'].file.value='$fileid';
  window.opener.document.forms['mform1'].filename.value='$filename';
  window.close();
  //]]>
  </script>";
  echo $output;
  die ();
  }

 /**
  * Function for preview iassign file from iassign filter.
  */
 function preview_ilm() {

  $fileid = optional_param ( 'fileid', NULL, PARAM_TEXT );

  $tag_filter = format_text($this->tag_ilm($fileid));

  $javascript = "<script type='text/javascript'>
   //<![CDATA[
   function submit_close() {
    window.opener.location.reload();
    window.close();
    }
   //]]>
</script>";

  $html = "<html><head></head><body> $javascript
  <form name='formEnvio' id='formEnvio' method='post' enctype='multipart/form-data'>
  <table border='1'>
  <tr><td>$tag_filter</td></tr>
  </table>
  <table>
  <tr><td align='center'><input type=button value='" . get_string ( 'close', 'iassign' ) . "' title='' onclick='submit_close();'/></td></tr>
  </table>
  </form>
  </body>
  </html>";

  echo $html;
  die;
  }

 /**
  * Function for export an package (zip) of iassign files.
  */
 function export_files_ilm() {
  global $CFG;
  $context = context_course::instance($this->id );

  $files_id = explode(",", optional_param ( 'files_id', '', PARAM_TEXT ));

  $zip_filename = $CFG->dataroot.'/temp/backup-iassign-files-'.date("Ymd-Hi").'.zip';
  $zip = new zip_archive();
  $zip->open($zip_filename);
  $fs = get_file_storage ();
  foreach($files_id as $file_id) {
   $file = $fs->get_file_by_id($file_id);
   if (!$file->is_directory())
    $zip->add_file_from_string($file->get_filename(), $file->get_content());
   else {
    $zip->add_directory($file->get_filepath());
    $files_zip = $fs->get_directory_files($context->id, 'mod_iassign', 'activity', 0, $file->get_filepath(), true, true);
    foreach ($files_zip as $value) {
     if (!$value->is_directory())
      $zip->add_file_from_string($value->get_filepath().$value->get_filename(), $value->get_content());
     else
      $zip->add_directory($value->get_filepath());
     }
    }
   }
  $zip->close();

  header("Pragma: public");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Cache-Control: private",false);
  header("Content-Type: application/zip");
  header("Content-Disposition: attachment; filename=\"".basename($zip_filename)."\";");
  header("Content-Transfer-Encoding: binary");
  header("Content-Length: ".@filesize($zip_filename));
  set_time_limit(0);
  @readfile("$zip_filename") or die("File not found.");
  unlink($zip_filename);
  exit;
  }

 /**
  * Function of execute a command in button editor tinymce.
  * @param int $fileid Id of file.
  */
 function tinymce_ilm($fileid) {

  $tag_filter = $this->tag_ilm($fileid);

  $output = "<script type='text/javascript'>
  //<![CDATA[
  var tag_filter = '$tag_filter';
  window.opener.tinyMCE.execCommand('mceiAssignReturn', tag_filter);
  window.close();
  //]]>
  </script>";
  echo $output;
  die ();
  }

 /**
  * Function for get path and infos of dirs: dirid,  dir_base, dir_parent, dir_home.
  * @param string $key Key for return information.
  * @return Ambigous <unknown, number, string, NULL> Return an information requested.
  */
 function get_dir_ilm($key) {
  $fs = get_file_storage();
  $context = context_course::instance($this->id);
  $dirid = optional_param('dirid', 0, PARAM_INT);
  $dir_home = $fs->get_file($context->id, 'mod_iassign', 'activity', 0, $dir_base = '/', '.');
  if ($dirid == 0) {
   $dir = ($dir_home = $fs->create_directory($context->id, 'mod_iassign', 'activity', 0, $dir_base));
   $dirid = $dir->get_id();
   } else {
   $dir = $fs->get_file_by_id($dirid);
   $dir_base = $dir->get_filepath();
   }
  $dir_parent = $dir->get_parent_directory();
  $data = array('dirid' => $dirid, 'dir_base' => $dir_base, 'dir_parent' => ($dir_parent == NULL ? 0 : $dir_parent->get_id()), 'dir_home' => $dir_home->get_id());
  return $data[$key];
  }

 /**
  * Function for create an new dir.
  */
 function new_dir_ilm() {
  global $USER;

  $ilmid = optional_param ( 'ilmid', NULL, PARAM_INT );

  $dirname = optional_param ( 'dirname', NULL, PARAM_TEXT );
  $dir_base = $this->get_dir_ilm('dir_base');

  $context = context_course::instance($this->id );
  $fs = get_file_storage();

  $fs->create_directory($context->id, 'mod_iassign', 'activity', 0, $dir_base.$dirname."/", $USER->id);
  $dir_base = $fs->get_file($context->id, 'mod_iassign', 'activity', 0, $dir_base.$dirname."/", '.');
  $dir_base->set_author($USER->firstname.' '.$USER->lastname);

  redirect ( new moodle_url ( $this->url."&dirid=".$this->get_dir_ilm('dirid')."&ilmid=$ilmid" ) );
  }

 /**
  * Function for delete an dir.
  */
 function delete_dir_ilm() { //
  $fs = get_file_storage ();
  $ilmid = optional_param ( 'ilmid', NULL, PARAM_INT );
  $context = context_course::instance($this->id );
  $dir = $fs->get_file_by_id ( $this->get_dir_ilm('dirid') );
  $dir_parent = $this->get_dir_ilm('dir_parent');
  if ($dir) {
   if ($dir->is_directory()) {
    $files_delete = $fs->get_directory_files($context->id, 'mod_iassign', 'activity', 0, $dir->get_filepath(), true, true);
    foreach ($files_delete as $value)
     $value->delete();
    $dir->delete();
    }
   }
  redirect ( new moodle_url ( $this->url."&dirid=".$dir_parent."&ilmid=$ilmid" ) );
  die ();
  }

 /**
  * Function for rename an dir.
  */
 function rename_dir_ilm() {
  $fs = get_file_storage ();
  $ilmid = optional_param ( 'ilmid', NULL, PARAM_INT );
  $context = context_course::instance($this->id );
  $dir = $fs->get_file_by_id ( $this->get_dir_ilm('dirid') );
  $dir_parent = $this->get_dir_ilm('dir_parent');
  $dirname = optional_param ( 'dirname', NULL, PARAM_TEXT );

  $pathname = explode("/", substr($dir->get_filepath (), 0, strlen($dir->get_filepath ())-1));
  if ($dir->is_directory()) {
   $files_rename_path = $fs->get_directory_files($context->id, 'mod_iassign', 'activity', 0, $dir->get_filepath(), true, true);
   foreach ($files_rename_path as $value)
    $value->rename(str_replace($pathname[count($pathname)-1], $dirname, $value->get_filepath()), $value->get_filename());
   $dir->rename(str_replace($pathname[count($pathname)-1], $dirname, $dir->get_filepath()), $dir->get_filename());
   }

  redirect ( new moodle_url ( $this->url."&dirid=".$dir_parent."&ilmid=$ilmid" ) );
  die ();
  }

 /**
  * Function for move an dir and your content for other dir.
  */
 function selected_move_ilm() {
  global $PAGE, $OUTPUT, $CFG;
  $fs = get_file_storage();
  $context = context_course::instance($this->id);

  $ilmid = optional_param ( 'ilmid', NULL, PARAM_INT );
  $dirid = $this->get_dir_ilm('dirid');
  $dir_base = $this->get_dir_ilm('dir_base');
  $files_id = explode(",", optional_param ( 'files_id', '', PARAM_TEXT ));

  $code_javascript_ilm = "
  <script type='text/javascript'>
   //<![CDATA[
   function getRadiobutton() {
    var radioButtons = document.getElementsByTagName('input');
    var param = '';
    for (var counter=0; counter < radioButtons.length; counter++) {
      if (radioButtons[counter].type.toUpperCase()=='RADIO' && radioButtons[counter].checked == true && radioButtons[counter].name == 'selected_dir')
	 param = radioButtons[counter].value;
         }
      return param;
      }
   function move_selected_ilm () {
      var resp;
      if (getRadiobutton() != '') {
       resp=confirm('" . get_string ( 'question_move_dir', 'iassign' ) . "');
       if (resp)
          window.location='$CFG->wwwroot/mod/iassign/ilm_manager.php?from=$this->from&id=$this->id&action=move&ilmid=$ilmid&dirid=$dirid&files_id=".optional_param ( 'files_id', '', PARAM_TEXT )."&dir_move='+getRadiobutton();
       } else
         alert('" . get_string ( 'error_dir_not_selected_to_move', 'iassign' ) . "');
       }
     function cancel_selected_ilm () {
       window.location='$CFG->wwwroot/mod/iassign/ilm_manager.php?from=$this->from&id=$this->id&ilmid=$ilmid&dirid=$dirid';
       }
   //]]>
 </script>";

  $title = get_string('move_files', 'iassign');
  $PAGE->set_title($title);
  $PAGE->set_pagelayout('base');
  echo $OUTPUT->header();
  echo $OUTPUT->heading($title);
  $dir_paths = array();
  echo $OUTPUT->box_start();
  echo "<center>";
  foreach ($files_id as $file_id) {
   $file = $fs->get_file_by_id ($file_id);
   if ($file) {
    if (!$file->is_directory())
     echo "<p>".icons::insert ('file' )."&nbsp;".$file->get_filepath().$file->get_filename()."</p>";
    else {
     echo "<p>".icons::insert ('dir' )."&nbsp;".$file->get_filepath()."</p>";
     array_push($dir_paths, $file->get_filepath());
     }
    }
   }
  echo $OUTPUT->heading(get_string ( 'select_move_ilm', 'iassign' ), 3, 'move', 'move_files');
  if ($dir_base != '/') {
   $check_select = "<input name='selected_dir' type='radio' value='".$this->get_dir_ilm('dir_home')."'/>";
   echo $check_select."&nbsp;".icons::insert ('dir' )."&nbsp;/<br>";
   }
  $files_tree = $fs->get_directory_files($context->id, 'mod_iassign', 'activity', 0, '/', true, true, 'filepath');
  foreach ($files_tree as $file) {
   if ($file->is_directory() && $file->get_filepath() != $dir_base) {
    $is_parent = false;
    foreach ($dir_paths as $dir) {
     $path = explode("/", $dir);
     array_pop($path);
     $path[count($path)-1] = '';
     $path = implode("/", $path);
     $is_parent |= (strpos($file->get_filepath(), $dir) === false ? false : true);
     $is_parent |= ($file->get_filepath() != $path ? false : true);
     }
    if ($is_parent == false) {
     $check_select = "<input name='selected_dir' type='radio' value='".$file->get_id()."'/>";
     echo "<p>".$check_select."&nbsp;".icons::insert ('dir' )."&nbsp;".$file->get_filepath()."</p>";
     }
    }
   }
  echo "<p><input type='button' value='".get_string ( 'ok' )."' onclick='move_selected_ilm();'/>&nbsp;&nbsp;&nbsp;&nbsp;";
  echo "<input type='button' value='".get_string ( 'cancel' )."' onclick='cancel_selected_ilm();'/></p>";
  echo "</center>";
  echo $OUTPUT->box_end();
  echo $OUTPUT->footer();
  echo $code_javascript_ilm;
  die;
  }

 /**
  * Function for move files for an dir.
  */
 function move_files_ilm() {
  $fs = get_file_storage();
  $context = context_course::instance($this->id);

  $ilmid = optional_param ( 'ilmid', NULL, PARAM_INT );
  $dirid = $this->get_dir_ilm('dirid');
  $dir_move = $fs->get_file_by_id(optional_param ( 'dir_move', 0, PARAM_INT ));
  $files_id = explode(",", optional_param ( 'files_id', '', PARAM_TEXT ));

  foreach ($files_id as $file_id) {
   $file = $fs->get_file_by_id ($file_id);
   if ($file) {
    if ($file->is_directory()) {
     $pathname = explode("/", $file->get_filepath());
     $files_move_path = $fs->get_directory_files($context->id, 'mod_iassign', 'activity', 0, $file->get_filepath(), true, true);
     foreach ($files_move_path as $value) {
      $path_move = $dir_move->get_filepath().$pathname[count($pathname)-2].'/'.str_replace($file->get_filepath(), '', $value->get_filepath());
      $value->rename($path_move, $value->get_filename());
      //echo($value->get_filepath().$value->get_filename()." - $path_move".$value->get_filename()."<br>");
      }
     $path_move = $dir_move->get_filepath().$pathname[count($pathname)-2].'/';
     //echo($file->get_filepath().$file->get_filename()." - $path_move".$file->get_filename()."<br>");
     $file->rename($path_move, $file->get_filename());
     } else {
     //echo($file->get_filepath().$file->get_filename()." -> ".$dir_move->get_filepath().$file->get_filename()."<br>");
     $file->rename($dir_move->get_filepath(), $file->get_filename());
     }
    }
   }
  //die;

  redirect ( new moodle_url ( $this->url."&ilmid=".$ilmid."&dirid=".$dirid ) );
  die ();
  }

 /**
  * Function for recover files in use on all activities of a course.
  */
 function recover_files_ilm() {
  global $DB, $USER;

  $fs = get_file_storage ();
  $courseid = optional_param ( 'id', NULL, PARAM_INT );
  $dirid = $this->get_dir_ilm('dirid');
  $ilmid = optional_param ( 'ilmid', NULL, PARAM_INT );
  $contextfile = context_course::instance($this->id);

  $iassigns = $DB->get_records ( "iassign", array ("course" => $courseid ) );
  foreach ( $iassigns as $iassign ) {
   $iassign_statements = $DB->get_records ( "iassign_statement", array ("iassignid" => $iassign->id ) );
   foreach ( $iassign_statements as $iassign_statement ) {
    $cm = get_coursemodule_from_instance("iassign", $iassign->id, $courseid);
    $context = context_module::instance($cm->id);
    $files = $fs->get_area_files ( $context->id, 'mod_iassign', 'exercise', $iassign_statement->file);
    if ($files) {
     foreach ( $files as $value ) {
      $extension = explode(".", $value->get_filename());
      if (!$value->is_directory()) {
       $fileinfo = array ('contextid' => $contextfile->id,
         'component' => 'mod_iassign',
         'filearea' => 'activity',
         'itemid' => 0,
         'filepath' => $this->get_dir_ilm('dir_base'),
         'userid' => $USER->id,
         'author' => $USER->firstname . ' ' . $USER->lastname,
         'license' => 'allrightsreserved',
         'timecreated' => time(),
         'filename' => $iassign_statement->name.".".$extension[1] ); // any filename
       $newfile = $fs->create_file_from_string ( $fileinfo, $value->get_content() );
       }
      }
     }
    }
  }

  redirect ( new moodle_url ( $this->url."&dirid=".$dirid."&ilmid=$ilmid" ) );
  die ();
  }

 /**
  * List iassign files from course directory.
  */
 function view_files_ilm($extension) {
  global $CFG, $DB, $USER, $OUTPUT;
  $fs = get_file_storage();
  $context = context_course::instance($this->id);
  $ilmid = optional_param ( 'ilmid', NULL, PARAM_INT );
  $dirid = $this->get_dir_ilm('dirid');
  $dir_base = $this->get_dir_ilm('dir_base');

  $files_course = $fs->get_directory_files($context->id, 'mod_iassign', 'activity', 0, $dir_base, false, true, 'filename');
  $files_array = '';
  foreach ( $files_course as $value ) {
   if (!$value->is_directory())
    $files_array .= "'" . $value->get_filename () . "',";
   }
  $files_array .= "''";
  $error_files_exists = get_string ( 'error_file_exists', 'iassign' );

  $dirs_array = '';
  foreach ( $files_course as $value ) {
   if ($value->is_directory()) {
    $pathname = explode("/", substr($value->get_filepath (), 0, strlen($value->get_filepath ())-1));
    $dirs_array .= "'" . $pathname[count($pathname)-1] . "',";
    }
   }
  $dirs_array .= "''";
  $error_dir_exists = get_string ( 'error_dir_exists', 'iassign' );

  // TODO Rever o preview pois sÃ³ deixar ver uma vez.
  $code_javascript_ilm = "
    <script type='text/javascript'>
    //<![CDATA[
    function preview_ilm (fileid) {
      var preview_ilm=window.open('$CFG->wwwroot/mod/iassign/ilm_manager.php?from=$this->from&id=$this->id&action=preview&fileid='+fileid,'','menubar=0,location=0,scrollbars,status,resizable,width=900 height=700');
     }

    function update_ilm(ilmid, fileid) {
       window.location='$CFG->wwwroot/mod/iassign/ilm_manager.php?from=$this->from&id=$this->id&action=update&ilmid='+ilmid+'&dirid=$dirid&fileid='+fileid;
     }

    function delete_ilm (ilmid, fileid) {
      var resp;
      resp=confirm('" . get_string ( 'delete_file', 'iassign' ) . "');
      if (resp) {
         window.location='$CFG->wwwroot/mod/iassign/ilm_manager.php?from=$this->from&id=$this->id&action=delete&ilmid='+ilmid+'&dirid=$dirid&fileid='+fileid;
       }
     }

    function delete_selected_ilm () {
      var resp;
      var param = getCheckbox();
      if (param.join() != '') {
       resp=confirm('" . get_string ( 'delete_files', 'iassign' ) . "');
       if (resp)
          window.location='$CFG->wwwroot/mod/iassign/ilm_manager.php?from=$this->from&id=$this->id&action=selected_delete&dirid=$dirid&files_id='+param.join();
     } else
     alert('" . get_string ( 'error_file_not_selected_to_delete', 'iassign' ) . "');
     }

    function add_ilm_iassign (ilmid, filename, fileid) {
      window.location='$CFG->wwwroot/mod/iassign/ilm_manager.php?from=$this->from&id=$this->id&action=addilm&ilmid='+ilmid+'&fileid='+fileid+'&filename='+filename;
     }
    function duplicate_ilm (ilmid, filename, fileid) {
      var filenamecopy;
      var i;
      var files = new Array($files_array);
      do {
         filenamecopy = prompt ('" . get_string ( 'duplicate_file', 'iassign' ) . "',filename);
       } while (filenamecopy == '');
      if (filenamecopy == null)
        return false;\n
      else {
        for (i=0;i<files.length;i++) {
            if (files[i]==filenamecopy) {
              alert('$error_files_exists');
              return false;\n
             }
         }
        window.location='$CFG->wwwroot/mod/iassign/ilm_manager.php?from=$this->from&id=$this->id&action=duplicate&ilmid='+ilmid+'&dirid=$dirid&fileid='+fileid+'&filename='+filenamecopy;
       }

     }

    function rename_ilm (ilmid, filename, fileid) {
      var filenamecopy;
      var i;
      var files = new Array($files_array);
      do {
         filenamecopy = prompt ('" . get_string ( 'rename_file', 'iassign' ) . "',filename);
       } while (filenamecopy == '');
      if (filenamecopy == null)
        return false;\n
      else {
        for (i=0;i<files.length;i++) {
            if (files[i]==filenamecopy) {
              alert('$error_files_exists');
              return false;\n
             }
         }
        window.location='$CFG->wwwroot/mod/iassign/ilm_manager.php?from=$this->from&id=$this->id&action=rename&ilmid='+ilmid+'&dirid=$dirid&fileid='+fileid+'&filename='+filenamecopy;
       }

     }

    function export_files_ilm() {
       var param = getCheckbox();
   if (param.join() != '')
        window.location='$CFG->wwwroot/mod/iassign/ilm_manager.php?from=$this->from&id=$this->id&action=export&dirid=$dirid&files_id='+param.join();
       else
        alert('" . get_string ( 'error_file_not_selected_to_export', 'iassign' ) . "');
       }

      function select_all_ilm() {
       var checkBoxes = document.getElementsByTagName('input');
       var selectAll = document.getElementById('select_all');
       for (var counter=0; counter < checkBoxes.length; counter++) {
             if (checkBoxes[counter].type.toUpperCase()=='CHECKBOX' && checkBoxes[counter].name == 'selected_file')
              checkBoxes[counter].checked = selectAll.checked;
             }
       }
      function getCheckbox() {
       var checkBoxes = document.getElementsByTagName('input');
            var param = new Array();
            for (var counter=0; counter < checkBoxes.length; counter++) {
             if (checkBoxes[counter].type.toUpperCase()=='CHECKBOX' && checkBoxes[counter].checked == true && checkBoxes[counter].name == 'selected_file')
                 param.push(checkBoxes[counter].value);
             }
            return param;
          }
  
      function new_dir_ilm() {
       var dirname = '';
       var i;
       var dirs = new Array($dirs_array);
       do {
    var dirname = prompt ('" . get_string ( 'question_new_dir', 'iassign' ) . "', '');
    }  while (dirname == '');
       if (dirname == null)
          return false;\n
       else {
        for (i=0;i<dirs.length;i++) {
              if (dirs[i]==dirname) {
                alert('$error_dir_exists');
                return false;\n
               }
              }
             window.location='$CFG->wwwroot/mod/iassign/ilm_manager.php?from=$this->from&id=$this->id&action=new_dir&ilmid=$ilmid&dirid=$dirid&dirname='+dirname;
        }
       }
      function delete_dir_ilm (ilmid, dirid) {
       var resp;
       resp=confirm('" . get_string ( 'question_delete_dir', 'iassign' ) . "');
       if (resp) {
          window.location='$CFG->wwwroot/mod/iassign/ilm_manager.php?from=$this->from&id=$this->id&action=delete_dir&ilmid='+ilmid+'&dirid='+dirid;
        }
       }
      function rename_dir_ilm (ilmid, dirname, dirid) {
       var dirnamecopy;
       var i;
       var dirs = new Array($dirs_array);
       do {
          dirnamecopy = prompt ('" . get_string ( 'question_rename_dir', 'iassign' ) . "',dirname);
        } while (dirnamecopy == '');
       if (dirnamecopy == null)
          return false;\n
       else {
         for (i=0;i<dirs.length;i++) {
            if (dirs[i]==dirnamecopy) {
              alert('$error_dir_exists');
              return false;\n
             }
          }
         window.location='$CFG->wwwroot/mod/iassign/ilm_manager.php?from=$this->from&id=$this->id&action=rename_dir&ilmid='+ilmid+'&dirid='+dirid+'&dirname='+dirnamecopy;
       }

     }

    function move_selected_ilm (ilmid) {
       var param = getCheckbox();
       if (param.join() != '')
          window.location='$CFG->wwwroot/mod/iassign/ilm_manager.php?from=$this->from&id=$this->id&action=selected_move&ilmid='+ilmid+'&dirid=$dirid&files_id='+param.join();
    else
      alert('" . get_string ( 'error_file_not_selected_to_move', 'iassign' ) . "');

       }

  function recover_files_ilm () {
       var resp;
       resp=confirm('" . get_string ( 'question_recover_files_ilm', 'iassign' ) . "');
       if (resp) {
          window.location='$CFG->wwwroot/mod/iassign/ilm_manager.php?from=$this->from&id=$this->id&action=recover&ilmid=$ilmid&dirid=$dirid';
        }
       }

    //]]>
    </script>";

  $output = "";
  $select_all = "";
  $count_files = 0;

  $extensions_allow = array();
  $iassign_ilm = $DB->get_records ( 'iassign_ilm', array ("enable" => 1 ) );
  foreach ( $iassign_ilm as $value )
   $extensions_allow = array_merge($extensions_allow, explode(",", $value->extension));

  foreach ( $files_course as $value ) {

   $filename = $value->get_filename ();
   $filepath = $value->get_filepath ();
   $pathname = explode("/", substr($filepath, 0, strlen($filepath)-1));
   $pathname = $pathname[count($pathname)-1];
   $fileid = $value->get_id ();
   $tmp = explode ( ".", $filename );
                        $filetype = $tmp[1];
   $author = $value->get_author ();
   $timemodified = date ("d/m/Y H:i:s", $value->get_timemodified () );
   $timecreated = date ("d/m/Y H:i:s", $value->get_timecreated () );
   $extensions = explode(",", $extension);

   if (in_array(strtolower ( $filetype ), $extensions) || $value->is_directory() || $this->from == 'block' || $this->from == 'tinymce') {

    $count_files++;

    // buscar fileid nas tabelas do iassign
    $list_filein_use = "";
    $iassign_statements = $DB->get_records ( "iassign_statement", array ("file" => $fileid ) );
    if ($iassign_statements) {
     foreach ( $iassign_statements as $iassign_statement ) {
      $list_filein_use .= $iassign_statement->name . "</br>";
      }
     }

    $iassign_ilm = $DB->get_record ( "iassign_ilm", array ('extension' => $filetype, 'parent' => '0', 'enable' => '1' ) );
    if (!$iassign_ilm) {
     $iassign_ilm = new stdClass ();
     $iassign_ilm->id = $ilmid;
     }

    $url = "{$CFG->wwwroot }/pluginfile.php/{$value->get_contextid() }/mod_iassign/activity";
    $fileurl = $url . '/' . $value->get_itemid () . $filepath  . $filename;
    $dirurl = new moodle_url ( $this->url ).'&ilmid='.$iassign_ilm->id.'&dirid='.$fileid;

    $link_add_ilm_iassign = "&nbsp;&nbsp;<a href='$CFG->wwwroot/mod/iassign/ilm_manager.php?from=$this->from&id=$this->id&action=addilm&fileid=$fileid&filename=$filename&nbsp;&nbsp;&nbsp;'>" . icons::insert ( 'add_ilm_iassign' ) . "</a>";
    $link_add_ilm_tinymce = "&nbsp;&nbsp;<a href='$CFG->wwwroot/mod/iassign/ilm_manager.php?from=$this->from&id=$this->id&action=tinymceilm&fileid=$fileid'>" . icons::insert ( 'add_ilm_iassign' ) . "</a>";

    $check_select = "";
    $link_rename = "";
    $link_delete = "";
    $link_duplicate = "&nbsp;&nbsp;<a href='#' onclick='duplicate_ilm(\"$iassign_ilm->id\", \"$filename\"," . $fileid . ");'>" . icons::insert ( 'duplicate_iassign' ) . "</a>";
    $link_edit = "&nbsp;&nbsp;".icons::insert ( 'no_edit_iassign' );
    $link_filter = "&nbsp;&nbsp;<a href='#' onclick='preview_ilm(" . $fileid . ");'>" . icons::insert ( 'preview_iassign' ) . "</a>";

    if ($value->get_userid () == $USER->id) {
     if ($iassign_statements) {
      $check_select = "";
      $link_edit = icons::insert ( 'edit_iassign_disable' );
      $link_delete = "&nbsp;&nbsp;" . icons::insert ( 'delete_iassign_disable' );
      $link_rename = "";
     } else {
      $check_select = "<input name='selected_file' type='checkbox' value='$fileid'/>";
      $link_edit = "&nbsp;&nbsp;<a href='#' onclick='update_ilm(\"$iassign_ilm->id\", $fileid)'>" . icons::insert ( 'edit_iassign' ) . "</a>";
      $link_delete = "&nbsp;&nbsp;<a href='#' onclick='delete_ilm(\"$iassign_ilm->id\", $fileid);'>" . icons::insert ( 'delete_iassign' ) . "</a>";
      $link_rename = "&nbsp;&nbsp;<a href='#' onclick='rename_ilm(\"$iassign_ilm->id\", \"$filename\"," . $fileid . ");'>" . icons::insert ( 'rename_iassign' ) . "</a>";
      }
     }
    if (!in_array($filetype, $extensions_allow)) {
     $link_edit = "";
     $link_add_ilm_iassign = "";
     $link_add_ilm_tinymce = "";
     $link_filter = "";
     }

    if ($value->is_directory()) {
     $link_delete = "&nbsp;&nbsp;<a href='#' onclick='delete_dir_ilm(\"$iassign_ilm->id\", $fileid);'>" . icons::insert ( 'delete_dir' ) . "</a>";
     $link_rename = "&nbsp;&nbsp;<a href='#' onclick='rename_dir_ilm(\"$iassign_ilm->id\", \"" . $pathname . "\"," . $fileid . ");'>" . icons::insert ( 'rename_dir' ) . "</a>";
     $output .= "<tr><td>$check_select$link_rename$link_delete</td>
     <td><a href='$dirurl' title='".get_string ( 'dir', 'iassign' ).$pathname."'>".icons::insert ('dir' ).'&nbsp;'.$pathname."</a></td>
     <td><center>$author</center></td>
     <td><center>$timecreated</center></td>
     <td><center>$timemodified</center></td></tr>";
     } else if ($this->from == 'iassign') {
     $output .= "<tr><td>$check_select$link_rename$link_delete$link_duplicate$link_edit$link_filter$link_add_ilm_iassign</td>
        <td><a href='$fileurl' title='".get_string ( 'download_file', 'iassign' )."$filename'>$filename</a></td>
        <td><center>$author</center></td>
        <td><center>$timecreated</center></td>
        <td><center>$timemodified</center></td></tr>";
     } else if ($this->from == 'block') {
     $output .= "<tr><td>$check_select$link_rename$link_delete$link_duplicate$link_edit$link_filter</td>
     <td><a href='$fileurl' title='".get_string ( 'download_file', 'iassign' )."$filename'>$filename</a></td>
     <td><center>$author</center></td>
     <td><center>$timecreated</center></td>
     <td><center>$timemodified</center></td></tr>";
     } else if ($this->from == 'tinymce') {
     $output .= "<tr><td>$check_select$link_rename$link_delete$link_duplicate$link_edit$link_filter$link_add_ilm_tinymce</td>
     <td><a href='$fileurl' title='".get_string ( 'download_file', 'iassign' )."$filename'>$filename</a></td>
          <td><center>$author</center></td>
          <td><center>$timecreated</center></td>
          <td><center>$timemodified</center></td></tr>";
     }
    }
   }
  $basename = explode("/", substr($dir_base, 0, strlen($dir_base)-1));
  $dir_base = "";
  $header = "";
  foreach($basename as $value) {
   $dir_base .= "$value/";
   $dir_id = $fs->get_file($context->id, 'mod_iassign', 'activity', 0, $dir_base, '.');
   if ($dir_id) {
    if ($value == "") {
     $fileurl = new moodle_url ( $this->url ).'&dirid='.$dir_id->get_id()."&ilmid=$ilmid";
     $header .= "&nbsp;<a href='$fileurl' title='".get_string ( 'dir', 'iassign' )."Home'>Home</a>";
     } else {
     $fileurl = new moodle_url ( $this->url ).'&dirid='.$dir_id->get_id()."&ilmid=$ilmid";
     $header .= "&nbsp;".$OUTPUT->rarrow()."&nbsp;<a href='$fileurl' title='".get_string ( 'dir', 'iassign' )."$dir_base'>$value</a>";
     }
    }
   }
  $html =  $OUTPUT->heading(icons::insert ('open_dir' ).$header, 2, 'dirtitle', 'iassign');
  $select_all="<input id='select_all' type='checkbox' onclick='select_all_ilm();'/>";
  $html .= "
    <table id='outlinetable' class='generaltable boxaligncenter' cellpadding='5' width='100%'>
     <tr><th class='header c1' width='20%'>$select_all " . get_string ( 'functions', 'iassign' ) . "</th>
       <th class='header c1' width='*'>" . get_string ( 'file', 'iassign' ) . "</th>
       <th class='header c1' width='10%'>" . get_string ( 'author', 'iassign' ) . "</th>
       <th class='header c1' width='10%'>" . get_string ( 'file_created', 'iassign' ) . "</th>
       <th class='header c1' width='10%'>" . get_string ( 'file_modified', 'iassign' ) . "</th>
       $output
    </table>";
  //$url_form = "$CFG->wwwroot/mod/iassign/ilm_manager.php?from=$this->from&id=$this->id&action=import";
  //$html .= "<form action='$url_form' id='form' method='post' enctype='multipart/form-data'>";
  $html .= "<form id='form_buttons' method='post' enctype='multipart/form-data'>";
  $html .= "<table width='100%'><tr>";
  $html .= "<td width='80%'><input type='button' value='" . get_string ( 'new_dir', 'iassign' ) . "' onClick='new_dir_ilm();'>";
  if ($count_files != 0) {
   $html .= "&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<input type='button' value='" . get_string ( 'file_ilm_move', 'iassign' ) . "' onClick='move_selected_ilm(\"$iassign_ilm->id\");'/>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
   $html .= "<input type='button' value='" . get_string ( 'file_ilm_delete', 'iassign' ) . "' onClick='delete_selected_ilm(\"$iassign_ilm->id\");'>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
   $html .= "<input type='button' value='" . get_string ( 'file_ilm_export', 'iassign' ) . "' onClick='export_files_ilm();'>";
   }
  $html .= "</td><td  width='100%' align='right'><input type='button' value='" . get_string ( 'file_ilm_recover', 'iassign' ) . "' onClick='recover_files_ilm();'>";
  $html .= $OUTPUT->help_icon ( 'file_ilm_recover', 'iassign' )."</td></tr></table>";
  $html .= "</form>";
  echo $code_javascript_ilm;
  echo $html;
   }
 }

/**
 * Class to insert of icons
 */
class icons {
 static function insert($icon) {
  global $CFG;
  $string = '<img src="' . $CFG->wwwroot . '/mod/iassign/icon/' . $icon . '.gif" title="' . get_string ( $icon, 'iassign' ) . '" alt="' . get_string ( $icon, 'iassign' ) . '"/>';
  return $string;
   }
 }

/**
 * Class with util functions for plugin manage.
 */
class utils {
 /**
  * Function for format filename remove special caracters.
  * @param string $text String for clean.
  * @param boolean $is_lowercase Boolean for apply lowercase in filename.
  * @return string Return an string in clean format.
  */
 static function format_filename($text) {
  if ($text != '.') {
   $text = htmlspecialchars ( urldecode ( $text ) );
   $array1 = array ("Ã¡","Ã ","Ã¢","Ã£","Ã¤","Ã©","Ã¨","Ãª","Ã«","Ã­","Ã¬","Ã®","Ã¯","Ã³","Ã²","Ã´","Ãµ","Ã¶","Ãº","Ã¹","Ã»","Ã¼","Ã§","Ã","Ã€","Ã‚","Ãƒ","Ã„","Ã‰","Ãˆ","ÃŠ","Ã‹","Ã","ÃŒ","ÃŽ","Ã","Ã“","Ã’","Ã”","Ã•","Ã–","Ãš","Ã™","Ã›","Ãœ","Ã‡","@"," ","!","?" );
   $array2 = array ("a","a","a","a","a","e","e","e","e","i","i","i","i","o","o","o","o","o","u","u","u","u","c","A","A","A","A","A","E","E","E","E","I","I","I","I","O","O","O","O","O","U","U","U","U","C","-","_","","" );
   $ext = strrpos($text, ".");
   $text = str_replace(".", "", substr($text, 0, $ext)).substr($text, $ext);
   $text = str_replace ( $array1, $array2, $text );
   }
  return $text;
  }

 /**
  * Function for format pathname remove special caracters.
  * @param string $text String for clean.
  * @param boolean $is_lowercase Boolean for apply lowercase in pathname.
  * @return string Return an string in clean format.
  */
 static function format_pathname($text, $is_lowercase = true) {
  $array1 = array ("Ã¡","Ã ","Ã¢","Ã£","Ã¤","Ã©","Ã¨","Ãª","Ã«","Ã­","Ã¬","Ã®","Ã¯","Ã³","Ã²","Ã´","Ãµ","Ã¶","Ãº","Ã¹","Ã»","Ã¼","Ã§","Ã","Ã€","Ã‚","Ãƒ","Ã„","Ã‰","Ãˆ","ÃŠ","Ã‹","Ã","ÃŒ","ÃŽ","Ã","Ã“","Ã’","Ã”","Ã•","Ã–","Ãš","Ã™","Ã›","Ãœ","Ã‡","@"," ","!","?", "." );
  $array2 = array ("a","a","a","a","a","e","e","e","e","i","i","i","i","o","o","o","o","o","u","u","u","u","c","A","A","A","A","A","E","E","E","E","I","I","I","I","O","O","O","O","O","U","U","U","U","C","-","_","","", "" );
  $text = str_replace ( $array1, $array2, $text );
  if ($is_lowercase)
   $text = strtolower($text);
  return $text;
  }

 /**
  * Function for insert version in the filename.
  * @param string $filename Name of file.
  * @return string Return the filename with version.
  */
 static function version_filename($filename) {
  $array_filename = explode('.', $filename);
        if (count($array_filename) > 1)
         $filename = $array_filename[0] . '-' . date("Ymd-His") . '.' . $array_filename[1];
        else
         $filename = $array_filename[0] . '-' . date("Ymd-His");
  return $filename;
  }

 //TODO Retirar quando atualizar todo os iassign que estÃ£o com a tag &lt;ia_uc&gt;
 static function remove_code_message($string) {
  $array = explode("&lt;ia_uc&gt;", $string);
  return $array[0];
  }
 }

/**
 * Class with language functions for plugin manage.
 */
class language {
 /**
  * Function for return text in language or get default language (en).
  * @param string $lang Code of language
  * @param string $description JSON text content all languages.
  * @return string Return an string in the language selected.
  */
 static function get_description_lang($lang, $descriptions) {
  $description_lang = "";
  $description = json_decode($descriptions);
  if ($description == null) {
   $description_lang = $descriptions;
   } else {
   if (isset($description->{$lang }))
    $description_lang = $description->{$lang };
   else
    $description_lang = $description->en;
   }
  return $description_lang;
  }

 /**
  * Function for return all language supported by iLM.
  * @param string $descriptions JSON text content all languages.
  * @return string Return as string with all languages.
  */
 static function get_all_lang($descriptions) {
  $langs = "";
  $description = json_decode($descriptions);
  foreach ($description as $key => $value) {
   $langs .= $key." ";
   }
  return $langs;
  }

 /**
  * Function for convert json in xml.
  * @param string $json JSON text.
  * @return string Return as string with xml tags.
  */
 static function json_to_xml($json) {
  $xml = "";
  $json = json_decode($json);
  foreach ($json as $key => $value) {
   $xml .= "\n\t\t<".$key.">".$value."</".$key.">";
   }
  return $xml;
  }
 }

/**
 * Class with log functions for plugin manage.
 */
class log {
  /**
   * Function for insert log event.
   * @param string $action Code action of event.
   * @param string $information Text for describe action of event.
   * @param int $cmid Id of context module.
   * @param int $ilmid Id of iLM.
   */
  static function add_log($action, $information = "", $cmid = 0, $ilmid = 0) {
   global $COURSE, $CFG, $USER, $DB;

   $newentry = new stdClass ();
   $newentry->time = time();
   $newentry->userid = $USER->id;
   $newentry->ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : "127.0.0.1";
   $newentry->course = $COURSE->id;
   $newentry->cmid = $cmid;
   $newentry->ilmid = $ilmid;
   $newentry->action = $action;
   $newentry->info = $information;
   $newentry->language = current_language();
   $newentry->user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
   if (ini_get("browscap") && function_exists('get_browse')) {
    $browser = get_browse(null, true);
    $newentry->javascript = $browser['javascript'];
    $newentry->java = $browser['javaapplets'];
    }
   if (! $newentry->id = $DB->insert_record ( "iassign_log", $newentry ))
    print_error ( 'error_add_log', 'iassign' );
  }

 } // class log

