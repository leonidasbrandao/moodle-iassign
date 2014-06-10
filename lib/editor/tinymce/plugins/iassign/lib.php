<?php

defined('MOODLE_INTERNAL') || die();

/**
 * Plugin for Moodle insert 'iassign' button.
 *
 * @author Luciano Oliveira Borges
 * @package   tinymce_iassign_lib
 * @copyright 2013 iMatica (<a href="http://www.matematica.br">iMath</a>) - Computer Science Dep. of IME-USP (Brazil)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tinymce_iassign extends editor_tinymce_plugin {
    /** @var array list of buttons defined by this plugin */
    protected $buttons = array('iassign');

    protected function update_init_params(array &$params, context $context,
            array $options = null) {
		global $CFG, $COURSE;

        // Add button after 'table' in advancedbuttons3.
        $this->add_button_after($params, 3, 'iassign', 'table');

        // Add JS file, which uses default name.
        $this->add_js_plugin($params);
		
		$params['iassign_course'] = $COURSE->id;
		$params['iassign_wwwroot'] = $CFG->wwwroot."/mod/iassign/ilm_manager.php";
    }
}
