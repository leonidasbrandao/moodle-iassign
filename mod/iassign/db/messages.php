<?php
/**
 * Defines message providers (types of message sent) for the iassign module.
 * 
 * 	Type	 						 						| Constants
 *  Permissions					 					|  MESSAGE_DISALLOWED | MESSAGE_PERMITTED | MESSAGE_FORCED
 *  Defaults for loggedin state	 	|  MESSAGE_DEFAULT_LOGGEDIN
 *  Defaults for loggedoff state 	|  MESSAGE_DEFAULT_OFFLINE
 *  
 *
 * @author Luciano Oliveira Borges
 * @author Patricia Alves Rodrigues
 * @author Leônidas O. Brandão
 * @version v 1.7 2014/04/15
 * @package mod_iassign_db
 * @since 2014/02/06
 * @see http://docs.moodle.org/dev/Message_API
 * @see http://docs.moodle.org/dev/Messaging_2.0
 * @copyright iMatica (<a href="http://www.matematica.br">iMath</a>) - Computer Science Dep. of IME-USP (Brazil)
 * 
 * <b>License</b> 
 *  - http://opensource.org/licenses/gpl-license.php GNU Public License
 */

defined('MOODLE_INTERNAL') || die();

$messageproviders = array(
	// Notify student that has submitted a activity attempt.
	'activity' => array(
		'capability' => 'mod/iassign:emailnotifyactivity',
		'defaults' => array(
				'popup' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_LOGGEDIN,
				'email' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_LOGGEDOFF
		)
	),
	// Notify teacher that a student has submitted a iassign attempt.
  'submission' => array(
		'capability' => 'mod/iassign:emailnotifysubmission',
		'defaults' => array(
			'popup' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_LOGGEDIN,
			'email' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_LOGGEDOFF
    )
  ),
	// Notify teacher/student that has submitted a message attempt.
	'comment' => array(
		'capability' => 'mod/iassign:emailnotifycomment',
		'defaults' => array(
				'popup' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_LOGGEDIN,
				'email' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_LOGGEDOFF
    )
  )
);
