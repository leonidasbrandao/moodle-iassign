<?php
/**
 * Script for install all ilm in iassign table.
 *
 * This file replaces:
 * STATEMENTS section in db/install.xml
 * lib.php/modulename_install() post installation hook partially defaults.php.
 *
 * Release Notes:
 * * - v 1.3 2013/12/12
 * 		+ Language support in iLM.
 * - v 1.2 2013/09/19
 * 		+ Change path file for ilm, consider version in pathname.
 *
 * @author Patricia Alves Rodrigues
 * @author Leônidas O. Brandão
 * @author Luciano Oliveira Borges
 * @version v 1.2 2013/09/19
 * @package mod_iassign_db
 * @since 2010/09/27
 * @copyright iMatica (<a href="http://www.matematica.br">iMath</a>) - Computer Science Dep. of IME-USP (Brazil)
 *
 * <b>License</b>
 *  - http://opensource.org/licenses/gpl-license.php GNU Public License
 */
require_once ($CFG->dirroot . '/mod/iassign/locallib.php');

function xmldb_iassign_install() {
	global $DB, $USER, $CFG;
	

	$records = array(
			array_combine(	array('name', 'url', 'version', 'description', 'extension', 'file_jar', 'file_class', 'width', 'height', 'enable','timemodified', 'author', 'timecreated', 'evaluate', 'tags'),
					array('iGeom', 'http://www.matematica.br/igeom', '5.9.12', '{"en":"Interactive Geometry on the Internet.","pt_br":"Geometria Interativa na Internet."}', 'geo', 'iGeom_new.jar', 'IGeomApplet.class', 800, 600, 1, time(), $USER->id, time(), 1, array())
			),
			array_combine(	array('name', 'url', 'version', 'description', 'extension', 'file_jar', 'file_class', 'width', 'height', 'enable','timemodified', 'author', 'timecreated', 'evaluate', 'tags'),
					array('iGraf', 'http://www.matematica.br/igraf', '4.4.0.10', '{"en":"Interactive Graphic on the Internet.","pt_br":"Gráficos Interativos na Internet."}', 'grf', 'iGraf_new.jar', 'igraf.IGraf.class', 840, 600, 1, time(), $USER->id, time(), 1, array())
			),
			array_combine(	array('name', 'url', 'version', 'description', 'extension', 'file_jar', 'file_class', 'width', 'height', 'enable','timemodified', 'author', 'timecreated', 'evaluate', 'tags'),
					array('iComb', 'http://www.matematica.br/icomb', '0.9.0', '{"en":"Combinatorics Interactive on the Internet.","pt_br":"Combinatória Interativa na Internet."}', 'icb,cmb', 'iComb_new.jar', 'icomb.IComb.class', 750, 685, 1, time(), $USER->id, time(), 1, array())
			),
			array_combine(	array('name', 'url', 'version', 'description', 'extension', 'file_jar', 'file_class', 'width', 'height', 'enable','timemodified', 'author', 'timecreated', 'evaluate', 'tags'),
					array('iVProg', 'http://www.matematica.br/ivprog', '0.3.1', '{"en":"Visual Interactive Programming on the Internet.","pt_br":"Programação visual interativa na Internet."}', 'ivp', 'iVprog_new.jar', 'edu.cmu.cs.stage3.alice.authoringtool.JAlice.class', 800, 600, 1, time(), $USER->id, time(), 0, array())
			),
			array_combine(	array('name', 'url', 'version', 'description', 'extension', 'file_jar', 'file_class', 'width', 'height', 'enable','timemodified', 'author', 'timecreated', 'evaluate', 'tags'),
					array('iTangram2', 'http://www.matematica.br/itangram', '0.4.3', '{"en":"The Objective of the game is to reproduce the form of the model using all 7 pieces of iTangram.","pt_br":"O Objetivo do jogo é reproduzir a forma do modelo usando todas as 7 peças do iTangram."}', 'itg2', 'iTangram2_new.jar', 'ilm.line.itangram2.Tangram', 800, 600, 1, time(), $USER->id, time(), 1, array())
			),
			array_combine(	array('name', 'url', 'version', 'description', 'extension', 'file_jar', 'file_class', 'width', 'height', 'enable','timemodified', 'author', 'timecreated', 'evaluate', 'tags'),
					array('Risko', 'http://risko.pcc.usp.br/', '2.1.94', '{"en":"Interactive computational tool for teaching geometry.","pt_br":"Ferramenta computacional interativa para o ensino de geometria."}', 'rsk', 'Risko_new.jar', 'RiskoApplet.class', 800, 600, 1, time(), $USER->id, time(), 0, array('iassign_ilmid' => '', 'param_type' => 'value', 'param_name' => 'MA_PARAM_noInstruments', 'param_value' => '', 'description' => '<p>Insira o código dos instrumentos que não deseja utilizar na atividade.</p><p>Códigos:  <b>pencil</b>(Lápis) <b>compass</b>(Compasso) <b>triangle_45</b>(Esquadro de 45º) <b>triangle_60</b>(Esquadro de 60º) <b>magnifier</b>(Lupa) <b>color_pens</b>(Caixa de Lápis) <b>player</b>(Player)</p>', 'visible' => '1'))
			)
	);

	$fs = get_file_storage();
	$is_delete = true;
	$context = context_system::instance();
	$ilm_path = $CFG->dirroot . "/mod/iassign/ilm/";

	foreach ($records as $record) {

		$iassign_ilm_parent = $DB->get_record('iassign_ilm', array('name' => $record['name'], 'parent' => 0));
			
		$ilm_exists = false;
		if($iassign_ilm_parent) {
			if($iassign_ilm_parent->version != $record['version'])
				$record['parent'] = $iassign_ilm_parent->id;
			else
				$ilm_exists = true;
		}
			
		$filenames = explode(",", $record['file_jar']);
		$file_jar = array();
		foreach($filenames as $filename) {
			if(!$ilm_exists) {

				$name_ilm = $record['name'];
				$version_ilm = $record['version'];

				$file_ilm = array(
						'userid' => $USER->id, // ID of context
						'contextid' => $context->id, // ID of context
						'component' => 'mod_iassign',     // usually = table name
						'filearea' => 'ilm',     // usually = table name
						'itemid' => 0,               // usually = ID of row in table
						'filepath' => '/iassign/ilm/'.utils::format_pathname($name_ilm).'/'.utils::format_pathname($version_ilm).'/',           // any path beginning and ending in /
						'filename' => str_replace('_new', '', $filename)); // any filename
				$file_ilm = @$fs->create_file_from_string($file_ilm, file_get_contents($ilm_path.$filename));

				if($file_ilm)
					$is_delete &= @unlink($ilm_path.$filename);

				array_push($file_jar, $file_ilm->get_id());
			} else
				$is_delete &= @unlink($ilm_path.$filename);
		}
		if(!empty($file_jar)){
			$record['file_jar'] = implode(",", $file_jar);
			$ilm_id = $DB->insert_record('iassign_ilm', $record);
			if(!empty($record['tags'])) {
				$record['tags']['iassign_ilmid'] = $ilm_id;
				$DB->insert_record('iassign_ilm_config', $record['tags']);
			}
		}
	}

	$is_delete &= @unlink($ilm_path . "index.html");

	if($is_delete && is_dir($ilm_path))
		@rmdir($ilm_path);
	
	
	// log event -----------------------------------------------------
	if(class_exists('plugin_manager'))
		$pluginman = plugin_manager::instance();
	else
		$pluginman = core_plugin_manager::instance();
	$plugins = $pluginman->get_plugins();
	log::add_log('install', 'version: '.$plugins['mod']['iassign']->versiondb);
	// log event -----------------------------------------------------

}
