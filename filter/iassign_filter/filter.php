<?php
/**
 * Filter iAssign
 * 
 * Release Notes:
 * - v 1.3 2014/02/25
 * 		+ Fix bugs in open filter for applet function in locallib.
 * - v 1.2 2014/01/10
 * 		+ Remove comment unread function of filter module.
 * - v 1.1 2013/10/31
 * 		+ Fix bugs in message alert in iassign title and remove message alert of the description by cache error.
 *
 * @author Patricia Alves Rodrigues
 * @author Leônidas O. Brandão
 * @author Luciano Oliveira Borges
 * @version v 1.2 2014/01/10
 * @package iassign_filter
 * @since 2010/09/27
 * @copyright iMatica (<a href="http://www.matematica.br">iMath</a>) - Computer Science Dep. of IME-USP (Brazil)
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @see moodle_text_filter
 */

/**
 * Moodle core defines constant MOODLE_INTERNAL which shall be used to make sure that the script is included and not called directly.
 */
defined('MOODLE_INTERNAL') || die();

/**
 * This class looks for email addresses in Moodle text and
 * hides them using the Moodle obfuscate_text function.
 * @see moodle_text_filter
 */
class filter_iassign_filter extends moodle_text_filter {

    /**
     * This takes the HTML to be filtered as an argument
     * @param string $text The text for filter
     * @param array $options An array for option in the filter
     * @return string Return the text with filter
     */
    function filter($text, array $options = array()) {

        global $CFG, $DB, $USER, $COURSE;

        if(file_exists($CFG->dirroot . '/mod/iassign/version.php')){
        	
	        $strs = explode("&lt;/ia&gt;", $text); // < (&lt;) - >(&gt;)
	        if (count($strs) > 1) {
	            $expressions = array();
	            foreach ($strs as $str) {
	                $tmp = explode("&lt;ia", $str); // < (&lt;) - / (&frasl;) >(&gt;)
	                if (count($tmp) > 1)
	                    $expressions[] = trim($tmp[1]);
	            } //foreach($strs as $str)
	
	            $text = str_replace("&lt;/ia&gt;", "<br/>", $text);
	            $text = str_replace("&lt;ia", "<br/>", $text);
	
	            foreach ($expressions as $expression) {
	                // default
	                $toolbar = 'disable'; // enable (habilita a barra de botões) disable (desabilita a barra de botões)
	                $width = 800;
	                $height = 600;
	
	                $tmp = explode("&gt;", $expression); //  >(&gt;)
	                $params = trim($tmp[0]);
	                $fileid = trim($tmp[1]);
	
	                $params = str_replace("'", "", $params);
	                $params = str_replace("&quot;", "", $params);
	                $params = explode(" ", $params);
	
	                foreach ($params as $param) {
	                    $tmp1 = explode("=", $param);
	
	                    if ($tmp1[0] == "toolbar")
	                        $toolbar = $tmp1[1];
	
	                    if ($tmp1[0] == "width")
	                        $width = $tmp1[1];
	
	                    if ($tmp1[0] == "height")
	                        $height = $tmp1[1];
	                } //foreach($params as $param)
	
	
	                $fs = get_file_storage();
	                $file = $fs->get_file_by_id($fileid);
	                $ia_content = '';
	                $filename = '';
	                $output = '';
	                if ($file) {
	                    $filename = $file->get_filename();
	                    $ia_content = $file->get_content();
	                    $file_string = utf8_encode($ia_content);
	                    $output = $this->convert_applet($filename, $width, $height, $toolbar, $file_string, $fileid);
	                } else {
	                    $output = "<strong>" . get_string('filenotfound', 'filter_iassign_filter') . "</strong>";
	                }
	
	                $text = str_replace($expression, $output, $text);
	            } // foreach($expressions as $expression)
	        } // if (count($strs)>1)
	        	
	        //TODO Retirar quando atualizar todo os iassign que estão com a tag &lt;ia_uc&gt;
	        $strs = explode("&lt;ia_uc&gt;", $text);
	        if (count($strs) > 1) {
	        	$tmp = explode("&lt;/ia_uc&gt;", $strs[1]);
	        	$expression = trim($tmp[0]);
	        	$text = $strs[0];
	        }
	        	
        }

        return $text;
    }

    /**
     * Convert paramms to html tag for applet
     * @param string $file Filename of applet
     * @param string $width Width of applet in html page
     * @param string $height Height of applet in html page
     * @param string $toolbar Enable toolbar of applet
     * @param string $file_string The content for applet load
     * @param string $fileid Id for identify of applet
     * @return string Return html tag with a string  
     */
    function convert_applet($file, $width, $height, $toolbar, $file_string, $fileid) {
        global $CFG, $DB;

        $tmp = explode(".", $file);
        $extension = $tmp[1];

        $iassign_ilms = $DB->get_records("iassign_ilm", array('enable' => 1, 'parent' => 0));
        foreach($iassign_ilms as $value) {
			$extensions = explode(",", $value->extension);
			if(in_array($extension, $extensions))   
				$iassign_ilm = $value;
        }

        $output = '';
        if (empty($iassign_ilm)) {
            $output = "<strong>" . $extension . ": " . get_string('extensionnotfound', 'filter_iassign_filter') . "</strong>";
        } else {

        	$view = -1;
        	$token = '';
        	$end_file = $CFG->wwwroot .  '/mod/iassign/ilm_security.php?id=' . $fileid . '&token=' . $token . '&view=' . $view;
        	
        	$output .= ilm_settings::applet_ilm($iassign_ilm->id, array( "type" => "filter", "notSEND" => "false", "Proposition" => $end_file, "width" => $width, "height" => $height, "toolbar" => $toolbar));
        }
        return $output;
    }
}
?>
