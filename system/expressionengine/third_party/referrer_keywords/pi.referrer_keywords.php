<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Referrer Keywords Plugins - Saves the keywords from a referring search engine
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Plugin
 * @version		1.0.0
 * @author		John Faulds ~ <enquiries@tyssendesign.com.au>
 * @link		http://www.tyssendesign.com.au
 * @license		http://creativecommons.org/licenses/by-sa/3.0/
 */

 /**
* Changelog
* 
* Version 1.0.0 20120224
* --------------------
* Initial public release
*
*/

$plugin_info = array(
  'pi_name' => 'Referrer Keywords',
  'pi_version' =>'1.0.0',
  'pi_author' =>'John Faulds',
  'pi_author_url' => 'http://www.tyssendesign.com.au',
  'pi_description' => 'Referrer Keywords Plugin - Extracts the keywords from a referring search engine querstring captured with EE’s first party Referrer module',
  'pi_usage' => Referrer_keywords::usage()
  );

class Referrer_keywords {

	var $return_data = '';

	public function __construct()
	{
		$this->EE =& get_instance();

		$str = $this->EE->TMPL->tagdata;

		// Remove HTML from around the URL
		preg_match('/\>(.*)<\/a>/', $str, $referrer);

		// Parse the referrer URL
		$parsed_url = parse_url($referrer[1]);
		if (empty($parsed_url['host']))
			return false;
		$host = $parsed_url['host'];

		// Parse the querystring
		$query_str = (!empty($parsed_url['query'])) ? $parsed_url['query'] : '';
		$query_str = (empty($query_str) && !empty($parsed_url['fragment'])) ? $parsed_url['fragment'] : $query_str;

		// Start the output with the referrer
		$output = 'Referrer: '. $host;

		// If the referrer is a search engine output the value of the search query
		if($query_str)
		{
			parse_str($query_str);
			$keywords = $q;
			$output .= '; Keywords: '. $q;
		}

		$this->return_data = $output;

	}

	/* END */	

	// --------------------------------------------------------------------
	/**
	 * Usage
	 *
	 * This function describes how the plugin is used.
	 *
	 * @access	public
	 * @return	string
	 */	
	  public static function usage()
	  {
	  ob_start(); 
	  ?>
		Usage example:
		
		This plugin is to be used in conjunction with ExpressionEngine's first party Referrer module. You could just do this:

		{exp:referrer limit="1"}{ref_from}{/exp:referrer}

		but because the module automatically outputs {ref_from} with an anchor tag wrapped around it, if you try to use that in a hidden form input in a contact form, it'll break your page.

		So this plugin just strips out the unnecessary HTML and returns a string including the referrer and the keywords (if the referrer is a search engine).

		Place {exp:referrer limit="1"}{exp:referrer_keywords}{ref_from}{/exp:referrer_keywords}{/exp:referrer} somewhere in your template.
				
	  <?php
	  $buffer = ob_get_contents();
		
	  ob_end_clean(); 
	
	  return $buffer;
	  }
	  // END

}

/* End of file pi.ress.php */
/* Location: ./system/expressionengine/third_party/ress/pi.ress.php */