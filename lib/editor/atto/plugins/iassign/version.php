<?php
/**
 * Atto text editor integration version file.
 *
 * @package    atto_iassign
 * @copyright  2014
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->component = 'atto_iassign';  // Full name of the plugin (used for diagnostics).
$plugin->release = '1.0.47 (Build: 2014051400)';	// Human-readable version name
$plugin->version   = 2014051400;        // The current plugin version (Date: YYYYMMDDXX).
$plugin->requires  = 2013111800;        // Requires this Moodle version.
$plugin->maturity = MATURITY_BETA;	// How stable the plugin is: MATURITY_ALPHA, MATURITY_BETA, MATURITY_RC, MATURITY_STABLE (Moodle 2.0 and above)
$plugin->dependencies = array('mod_iassign' => 2014041600);
?>