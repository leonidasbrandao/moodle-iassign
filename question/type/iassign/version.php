<?php
/**
 * IAssign question type version information.
 * 
 * @version v1.1.23 2014/02/27
 * @package    qtype
 * @subpackage iassign
 * @since 2014/02/27
 * @copyright iMatica (<a href="http://www.matematica.br">iMath</a>) - Computer Science Dep. of IME-USP (Brazil)
 * 
 * <b>License</b> 
 *  - http://opensource.org/licenses/gpl-license.php GNU Public License
 *  
 *  <br><br><a href="../index.html"><b>Return to iAssign Documentation</b></a>
 */

defined('MOODLE_INTERNAL') || die();

$plugin->component = 'qtype_iassign';
$plugin->version   = 2014022700;
$plugin->release = '1.1.23 (Build: 2014022700)';
$plugin->requires  = 2012120300;
$plugin->maturity  = MATURITY_ALPHA;
$plugin->dependencies = array('mod_iassign' => 2014022600);
