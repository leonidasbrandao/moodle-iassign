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
 *  - http://opensource.org/licenses/gpl-license.php GNU Public License
 *  
 * @param $oldversion Number of the old version. 
 */

require_once ($CFG->dirroot . '/mod/iassign/locallib.php');

function xmldb_iassign_upgrade($oldversion) {

   global $CFG, $DB, $USER;

    $dbman = $DB->get_manager();

    if ($oldversion < 2014011600) {
    	//TODO Retirar assim que atualizar o DEV SAW.
    	
    	$table = new xmldb_table('iassign_log');
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
	    	
	    	// Assign savepoint reached.
	    	upgrade_mod_savepoint(true, 2014011600, 'iassign');
    	}
    }
    
    if ($oldversion < 2014020600) {
    	//TODO Retirar assim que atualizar no DEV SAW.
    	
    	$table = new xmldb_table('iassign_ilm_config');
    	$field_param_type = new xmldb_field('param_type', XMLDB_TYPE_CHAR, '100', null, null, null, null, 'iassign_ilmid');
    	if (!$dbman->field_exists($table, $field_param_type))
    		$dbman->add_field($table, $field_param_type);
    	 
    	$table = new xmldb_table('iassign_statement_config');
    	if(!$dbman->table_exists($table)){
    		 
    		$field_id = new xmldb_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE);
    		$field_iassign_statementid = new xmldb_field('iassign_statementid', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'id');
    		$field_iassign_ilm_configid = new xmldb_field('iassign_ilm_configid', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'iassign_statementid');
    		$field_param_name = new xmldb_field('param_name', XMLDB_TYPE_CHAR, '100', null, null, null, null, 'iassign_ilm_configid');
    		$field_param_value = new xmldb_field('param_value', XMLDB_TYPE_CHAR, '100', null, null, null, null, 'param_name');
    
    		$key = new xmldb_key('primary');
    		$key->set_attributes(XMLDB_KEY_PRIMARY, array('id'), null, null);
    
    		$table->addField($field_id);
    		$table->addField($field_iassign_statementid);
    		$table->addField($field_iassign_ilm_configid);
    		$table->addField($field_param_name);
    		$table->addField($field_param_value);
    
    		$table->addKey($key);
    
    		$status = $dbman->create_table($table);
    		
    		// Assign savepoint reached.
    		upgrade_mod_savepoint(true, 2014020600, 'iassign');
    	}
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

?>
