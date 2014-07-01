<?php
/**
 * Script for install iassign filter in moodle.
 *
 * Release Notes:
 * - v 1.0 2013/11/28
 * 		+ Enable by default filter
 * 		+ Enable filter content and titles.
 *
 * @author Luciano Oliveira Borges
 * @author Patricia Alves Rodrigues
 * @author Leônidas O. Brandão
 * @version v 1.0 2013/11/28
 * @package iassign_filter
 * @since 2010/11/28
 * @copyright iMatica (<a href="http://www.matematica.br">iMath</a>) - Computer Science Dep. of IME-USP (Brazil)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @see moodle_text_filter
 */

/**
 * Moodle core defines constant MOODLE_INTERNAL which shall be used to make sure that the script is included and not called directly.
 */
defined('MOODLE_INTERNAL') || die();

function xmldb_filter_iassign_filter_install() {
	global $CFG;
	require_once("$CFG->libdir/filterlib.php");

	filter_set_global_state('filter/iassign_filter', TEXTFILTER_ON);
	filter_set_applies_to_strings('filter/iassign_filter', true);
}