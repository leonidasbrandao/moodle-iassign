<?php

/**
 * Definition of log events
 *
 * @author Patricia Alves Rodrigues
 * @author Leônidas O. Brandão
 * @version v 1.0 2010/09/27
 * @package mod_iassign_db
 * @since 2010/09/27
 * @copyright iMatica (<a href="http://www.matematica.br">iMath</a>) - Computer Science Dep. of IME-USP (Brazil)
 * 
 * <b>License</b> 
 *  - http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
/**
 * Moodle core defines constant MOODLE_INTERNAL which shall be used to make sure that the script is included and not called directly.
 */
defined('MOODLE_INTERNAL') || die();

/**
 * Array of log events.
 */
$logs = array(
    array('module'=>'iassign', 'action'=>'view', 'mtable'=>'iassign', 'field'=>'name'),
    array('module'=>'iassign', 'action'=>'add', 'mtable'=>'iassign', 'field'=>'name'),
    array('module'=>'iassign', 'action'=>'update', 'mtable'=>'iassign', 'field'=>'name'),
    array('module'=>'iassign', 'action'=>'view submission', 'mtable'=>'iassign', 'field'=>'name'),
    array('module'=>'iassign', 'action'=>'upload', 'mtable'=>'iassign', 'field'=>'name'),
    array('module'=>'iassign', 'action'=>'update comment', 'mtable'=>'iassign', 'field'=>'name'),
    array('module'=>'iassign', 'action'=>'update submission', 'mtable'=>'iassign', 'field'=>'name'),
    array('module'=>'iassign', 'action'=>'delete iassign', 'mtable'=>'iassign', 'field'=>'name'),
    array('module'=>'iassign', 'action'=>'add comment', 'mtable'=>'iassign', 'field'=>'name'),
    array('module'=>'iassign', 'action'=>'add submission', 'mtable'=>'iassign', 'field'=>'name'),

);