<?php
/** 
 * This file keeps track of upgrades to the lams module.
 * 
 * Sometimes, changes between versions involve
 * alterations to database structures and other
 * major things that may break installations.
 * The upgrade function in this file will attempt
 * to perform all the necessary actions to upgrade
 * your older installtion to the current version.
 * If there's something it cannot do itself, it
 * will tell you what you need to do.
 * The commands in here will all be database-neutral,
 * using the functions defined in lib/ddllib.php
 * 
 * - v 1.4 2013/09/19
 * 		+ Insert general fields for iassign statement (grade, timeavaliable, timedue, preventlate, test, max_experiment).
 * 		+ Change index field 'name' in 'iassign_ilm' table to index field 'name,version'.
 * - v 1.2 2013/08/30
 * 		+ Change 'filearea' for new concept for files.
 * 		+ Change path file for ilm, consider version in pathname.
 * 
 * @author Patricia Alves Rodrigues
 * @author Leônidas O. Brandão
 * @author Luciano Oliveira Borges
 * @version v 1.4 2013/09/19
 * @package mod_iassign_db
 * @since 2010/12/21
 * @copyright iMatica (<a href="http://www.matematica.br">iMath</a>) - Computer Science Dep. of IME-USP (Brazil)
 * 
 * <b>License</b> 
 *  - http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *  
 * @param $oldversion Number of the old version. 
 */

require_once ($CFG->dirroot . '/mod/iassign/locallib.php');

function xmldb_iassign_upgrade($oldversion) {

   global $CFG, $DB, $USER;

    $dbman = $DB->get_manager();

    if ($oldversion < 2014012100) {

  	
    	// Define field and index in ilm table to be added.
    	$table = new xmldb_table('iassign_ilm');
    	$index_name = new xmldb_index('name');
    	$index_name->set_attributes(XMLDB_INDEX_UNIQUE, array('name'));
    	if ($dbman->index_exists($table, $index_name)) {
    		$dbman->drop_index($table, $index_name, $continue=true, $feedback=true);
    	}
    	$index_name_version = new xmldb_index('name_version');
    	$index_name_version->set_attributes(XMLDB_INDEX_UNIQUE, array('name', 'version'));
    	if (!$dbman->index_exists($table, $index_name_version)) {
    		$dbman->add_index($table, $index_name_version, $continue=true, $feedback=true);
    	}
    	
    	// Fix field name in ilm table to be added.
    	$table = new xmldb_table('iassign_ilm');
    	$field_height = new xmldb_field('heigth', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '600', 'width');
    	if ($dbman->field_exists($table, $field_height))
    		$dbman->rename_field($table, $field_height, 'height');


    	// Define fields in iassign table to be added.
    	$table = new xmldb_table('iassign');
    	$field_intro = new xmldb_field('intro', XMLDB_TYPE_TEXT, 'medium', null, null, null, null, 'name');
    	if (!$dbman->field_exists($table, $field_intro))
    		$dbman->add_field($table, $field_intro);
    	$field_introformat = new xmldb_field('introformat', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, '0', 'intro');
    	if (!$dbman->field_exists($table, $field_introformat))
    		$dbman->add_field($table, $field_introformat);
    	$field_grade = new xmldb_field('grade', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, null, '0', 'activity_group');
    	if (!$dbman->field_exists($table, $field_grade))
    		$dbman->add_field($table, $field_grade);
    	$field_timeavailable = new xmldb_field('timeavailable', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'grade');
    	if (!$dbman->field_exists($table, $field_timeavailable))
    		$dbman->add_field($table, $field_timeavailable);
    	$field_timedue = new xmldb_field('timedue', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'timeavailable');
    	if (!$dbman->field_exists($table, $field_timedue))
    		$dbman->add_field($table, $field_timedue);
    	$field_preventlate = new xmldb_field('preventlate', XMLDB_TYPE_INTEGER, '2', XMLDB_UNSIGNED, null, null, '1', 'timedue');
    	if (!$dbman->field_exists($table, $field_preventlate))
    		$dbman->add_field($table, $field_preventlate);
    	$field_test = new xmldb_field('test', XMLDB_TYPE_INTEGER, '1', XMLDB_UNSIGNED, null, null, '0', 'preventlate');
    	if (!$dbman->field_exists($table, $field_test))
    		$dbman->add_field($table, $field_test);
    	$field_max_experiment = new xmldb_field('max_experiment', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'test');
    	if (!$dbman->field_exists($table, $field_max_experiment))
    		$dbman->add_field($table, $field_max_experiment);
    	
		if(!$dbman->table_exists($table)){
    	
	    	$field_id = new xmldb_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE);
	    	$field_time = new xmldb_field('time', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'id');
	    	$field_userid = new xmldb_field('userid', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'time');
	    	$field_ip = new xmldb_field('ip', XMLDB_TYPE_CHAR, '255', null, null, null, null, 'userid');
	    	$field_course = new xmldb_field('course', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'ip');
	    	$field_cmid = new xmldb_field('cmid', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'course');
	    	$field_ilmid = new xmldb_field('ilmid', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'cmid');
	    	$field_action = new xmldb_field('action', XMLDB_TYPE_CHAR, '255', null, null, null, null, 'ilmid');
	    	$field_info = new xmldb_field('info', XMLDB_TYPE_TEXT, 'medium', null, null, null, null, 'action');
	    	$field_language = new xmldb_field('language', XMLDB_TYPE_CHAR, '10', null, null, null, null, 'info');
	    	$field_user_agent = new xmldb_field('user_agent', XMLDB_TYPE_TEXT, 'medium', null, null, null, null, 'language');
	    	$field_javascript = new xmldb_field('javascript', XMLDB_TYPE_INTEGER, '1', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'user_agent');
	    	$field_java = new xmldb_field('java', XMLDB_TYPE_INTEGER, '1', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'javascript');
	    	
	    	$key = new xmldb_key('primary');
	    	$key->set_attributes(XMLDB_KEY_PRIMARY, array('id'), null, null);
	    	
	    	$index = new xmldb_index('course');
	    	$index->set_attributes(XMLDB_INDEX_NOTUNIQUE, array('course'));
	    	
	    	
	    	$table->addField($field_id);
	    	$table->addField($field_time);
	    	$table->addField($field_userid);
	    	$table->addField($field_ip);
	    	$table->addField($field_course);
	    	$table->addField($field_cmid);
	    	$table->addField($field_ilmid);
	    	$table->addField($field_action);
	    	$table->addField($field_info);
	    	$table->addField($field_language);
	    	$table->addField($field_user_agent);
	    	$table->addField($field_javascript);
	    	$table->addField($field_java);
	    	
	    	$table->addKey($key);
	    	
	    	$table->addIndex($index);
	    	
	    	$status = $dbman->create_table($table);
    	}
    	
		
    	$fs = get_file_storage();
    	$is_delete = true;
    	$ilm_path = $CFG->dirroot . "/mod/iassign/ilm/";
    	
    	$exercise_files = $DB->get_records('files', array ("component" => "mod_iassign", "filearea" => "activity"));
    	foreach ($exercise_files as $exercise_file) {
    		$exercise_file->filearea = "exercise";
    		$DB->update_record('files', $exercise_file);
    	}
    	
    	$activity_files = $DB->get_records('files', array ("component" => "mod_iassign", "filearea" => "ilm"));
    	foreach ($activity_files as $activity_file) {
    		$activity_file->filearea = "activity";
    		$DB->update_record('files', $activity_file);
    	}
		
    	// Assign savepoint reached.
    	upgrade_mod_savepoint(true, 2014012100, 'iassign');
    }
    
    // log event -----------------------------------------------------
    if(class_exists('plugin_manager'))
		$pluginman = plugin_manager::instance();
	else
		$pluginman = core_plugin_manager::instance();
    $plugins = $pluginman->get_plugins();
    log::add_log('upgrade', 'version: '.$plugins['mod']['iassign']->versiondisk);
    // log event -----------------------------------------------------
    
    return true;
}