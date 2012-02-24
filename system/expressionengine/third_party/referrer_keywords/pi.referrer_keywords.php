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
  'pi_description' => 'Referrer Keywords Plugins - Saves the keywords from a referring search engine',
  'pi_usage' => Ress::usage()
  );

class Referrer_keywords {

	public function __construct()
	{
		$this->EE =& get_instance();
	}

	function set()
    {
		if(!isset $_SESSION['keywords'])
		{
			$keywords='';

			// Get the full referring URL
			$referrer = ( ! isset($_SERVER['HTTP_REFERER'])) ? '' : $this->EE->security->xss_clean($_SERVER['HTTP_REFERER']);
			$uri = parse_url($referrer);
			

			// Remove our own domain
			if($uri['host'] != 'www.tyssendesign.com.au')
			{
				// Get keywords from referrer
				$parsed = parse_url($referrer, PHP_URL_QUERY);
				parse_str($parsed, $query);
				$keywords = $query['q'];

				//if no active session we start a new one
				if (session_id() == "") 
				{
					session_start();
				}

				$_SESSION['keywords'] = $keywords;

			}
		}
	}
	/* END */

	// --------------------------------------------------------------------
	
	/**
	  *  Get session variable
	  */  
	function get()
	{		
		// if no active session we start a new one
		if (session_id() == "") 
		{
			session_start(); 
		}
		
		if (isset($_SESSION['keywords']))
		{
			return $_SESSION['keywords'];
		}
		
		else
		{
			return '';
		}
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
		
		Place {exp:ress:cookie} somewhere in the head of your template to set a cookie based on your window's width.

		The screen width will then be available as an ExpressionEngine variable {ress} which you can use anywhere in your templates.

		Possible scenarios include hiding or showing certain content based on screen size, e.g.: {if {ress} > 480} show larger screen content {/if}
				
	  <?php
	  $buffer = ob_get_contents();
		
	  ob_end_clean(); 
	
	  return $buffer;
	  }
	  // END

}

/* End of file pi.ress.php */
/* Location: ./system/expressionengine/third_party/ress/pi.ress.php */