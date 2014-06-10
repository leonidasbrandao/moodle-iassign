<?php
/**
 * Block iLM manager
 * 
 * Release Notes:
 * - v 1.1 2013/11/01
 * 		+ Fix bug in access when the iassign module not install.
 * 
 * @author Patricia Alves Rodrigues
 * @author Leônidas O. Brandão
 * @author Luciano Oliveira Borges
 * @version v 1.1 2013/11/01
 * @package iassign_block
 * @since 2012/01/10
 * @copyright iMatica (<a href="http://www.matematica.br">iMath</a>) - Computer Science Dep. of IME-USP (Brazil)
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @see block_base
 */

defined('MOODLE_INTERNAL') || die();

class block_iassign_block extends block_base {
	
	/**
	 * Initialize funcion of class.
	 */
	function init() {
		$this->title = get_string('blocktitle', 'block_iassign_block');
		$this->blockname = get_string('pluginname', 'block_iassign_block');
	}

	/**
	 * Overwrite specialization function (Inheritance).
	 */
	function specialization() {

	}

	/**
	 * Function for allow applicable formats.
	 * @return array Return an array with the formats.
	 */
	function applicable_formats() {
		return array('all' => true);
	}

	/**
	 * Function for allow multiple instances.
	 * @return boolean Return false for multple instances.
	 */
	function instance_allow_multiple() {
		return false;
	}

	/**
	 * Function for return the content the block in page.
	 * @return stdClass|NULL Return content or null.
	 */
	function get_content() {
		global $USER, $CFG, $COURSE, $PAGE, $OUTPUT;
		
		if ($this->content !== NULL) {
			return $this->content;
		}
		if (empty($this->instance)) {
			return null;
		}

		if (isloggedin() && !isguestuser()) {   // Show the block
			$this->content = new stdClass();
			if ($PAGE->pagelayout != 'frontpage') {
				if (has_capability('mod/iassign:editiassign', $this->context)) {//
					
					$code_javascript = "
					<script type='text/javascript'>
						//<![CDATA[
						function alert_iassign() {
							alert('".get_string('alert_iassign', 'block_iassign_block')."');
						}
						//]]>
					</script>";
 					$this->content->text = $code_javascript;
					
					if(!file_exists($CFG->dirroot . '/mod/iassign/version.php')) {
						$options = array('id' => $COURSE->id);
						$url = "#";
						$confirmaction = new component_action('click', 'alert_iassign', array());
					} else {
						$options = array('id' => $COURSE->id, 'from' => 'block', 'returnurl' => $PAGE->url->out());
						$url = "$CFG->wwwroot/mod/iassign/ilm_manager.php";
						$confirmaction = '';
					}
					$button = new single_button(new moodle_url($url, $options), get_string('new_edit', 'block_iassign_block'), 'GET');
					if(!empty($confirmaction))
						$button->add_action($confirmaction);
					
					$this->content->text .= '<CENTER>'.$OUTPUT->render($button).'</CENTER>';
				} 
				return $this->content;
			}
		}
	}

}

?>
