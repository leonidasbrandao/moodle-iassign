<?php
/**
 * @mainpage
 * This is the iAssign (Interactive Assignment) package, an iMath free system to enrich activities in Moodle.
 * It is created by Patricia Rodrigues and Leônidas de Oliveira Brandão.
 *
 * iAssign's goal is to increase interactivity in activities related to specific subjects (such as Geometry, Functions, Programming,...)
 * in a flexible way.
 *
 * In order to improve interactivity, iAssign makes use of iLM (interactive Learning Module),
 * that is any interactive tool that runs under a Web browser.
 * Typically an iLM is a Java applet with a few (mandatory) communication methods, all based on HTTP protocol.
 * This implies that any applet can easily became an iLM and can be integrated to Moodle under iAssign package.
 *
 * If the iLM offers automatic assessment functionality, iAssign is able
 * to deal with it. Under such iLM, iAssign provides immediate feedback to
 * the student, and the teachers can get instant information about their
 * activities (including reports about the student performance).
 *
 * It can be added new iLM into iAssign, at any time, but (for security
 * reason), only the administrator has the privilege of integrating new iLM into iAssign.
 * Once integrated, an iLM can be used by anyone registered in its Moodle.
 * For instance, an user with privileges of "teacher" is allowed to use
 * the iAssign authoring tools to create activities with any iLM
 * (like iGeom, iGraf, or iVprog, respectively to related to the subjects, Geometry, Functions and Programming).
 *
 * The main features of iAssign package are:
 * - The authoring tool to allow any teacher to easily prepare activities to students. Activities can be:
 *    + an exercise (the student must send an answer, and if the iLM has automatic assessment, its results (right/wrong) is also registered);
 *    + a test (the student does the activity, if iLM has automatic assessment, the student gets immediate feedback, but no data is recorded in Moodle's database);
 *    + an example (the student can interact with the example, but nothing is recorded).
 *  - Reports about students activities:
 *    + teachers can see, e.g., a survey or statistics about student's answers and can have quick access to any submited answer;
 *    + the students have a survey of their activities (including their grades)
 *  - Integration with general Moodle grades
 *  - A filter that allows the insertion of iLM content into any (asynchronous) Moodle text.
 *
 * @author Patricia Alves Rodrigues <<patricnet@ig.com.br>>
 * @author Leônidas O. Brandão  <<leo@ime.usp.br>>
 *
 * @version v 2.1.16 2013/10/31
 * @since 2010/09/27
 * @copyright iMatica (<a href="http://www.matematica.br">iMath</a>) - Computer Science Dep. of IME-USP (Brazil)
 *
 * <b>License</b>
 *  - http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 *  <br><br><a href="../index.html"><b>Return to iAssign Documentation</b></a>
 */
/**
 * Version File
 * @author Patricia Alves Rodrigues
 * @author Leônidas O. Brandão
 * @version v 1.0 2012/01/10
 * @package iassign_filter_version
 * @since 2012/10/10
 * @copyright iMatica (<a href="http://www.matematica.br">iMath</a>) - Computer Science Dep. of IME-USP (Brazil)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Moodle core defines constant MOODLE_INTERNAL which shall be used to make sure that the script is included and not called directly.
 */
defined('MOODLE_INTERNAL') || die();

$plugin->component = 'filter_iassign_filter'; // Full name of the plugin (used for diagnostics)
$plugin->release = '2.1.87 (Build: 2014070100)';	// Human-readable version name
$plugin->version  = 2014070100;    // The current module version (Date: YYYYMMDDXX)
$plugin->requires = 2012112900;    // Requires this Moodle version
$plugin->maturity = MATURITY_STABLE;	// How stable the plugin is: MATURITY_ALPHA, MATURITY_BETA, MATURITY_RC, MATURITY_STABLE (Moodle 2.0 and above)
$plugin->dependencies = array('mod_iassign' => 2014012100);