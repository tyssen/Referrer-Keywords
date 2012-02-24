<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * Referrer Keywords Extension
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Extension
 * @author		John Faulds
 * @link		http://www.tyssendesign.com.au
 */

class Referrer_keywords_ext {
	
	public $settings 		= array();
	public $description		= 'Returns the keywords visitors from Google used to find your site';
	public $docs_url		= '';
	public $name			= 'Referrer Keywords';
	public $settings_exist	= 'n';
	public $version			= '1.0';
	
	private $EE;
	
	/**
	 * Constructor
	 *
	 * @param 	mixed	Settings array or empty string if none exist.
	 */
	public function __construct($settings = '')
	{
		$this->EE =& get_instance();
		$this->settings = $settings;
	}// ----------------------------------------------------------------------
	
	/**
	 * Activate Extension
	 *
	 * This function enters the extension into the exp_extensions table
	 *
	 * @see http://codeigniter.com/user_guide/database/index.html for
	 * more information on the db class.
	 *
	 * @return void
	 */
	public function activate_extension()
	{
		// Setup custom settings in this array.
		$this->settings = array();
		
		$data = array(
			'class'		=> __CLASS__,
			'method'	=> 'referrer_keywords',
			'hook'		=> 'sessions_start',
			'settings'	=> serialize($this->settings),
			'version'	=> $this->version,
			'enabled'	=> 'y'
		);

		$this->EE->db->insert('extensions', $data);			
		
	}	

	// ----------------------------------------------------------------------
	
	/**
	 * referrer_keywords
	 *
	 * @param 
	 * @return 
	 */
	public function referrer_keywords()
	{
		$keywords="";

		// Get the full referring URL
		$referrer = ( ! isset($_SERVER['HTTP_REFERER'])) ? '' : $this->EE->security->xss_clean($_SERVER['HTTP_REFERER']);

		if (eregi("www.google",$referrer)) {
			preg_match("'q=(.*?)(&| )'si", " $referrer ", $keywords);
		}

		if (($keywords[1]!="") and ($keywords[1]!=" ")) {
			$keywords=eregi_replace("/+/"," ",$keywords[1]);
			$keywords=eregi_replace("%2B"," ",$keywords);
			$keywords=eregi_replace("%2E",".",$keywords);
			$keywords=trim(eregi_replace('%22','"',$keywords));
		}
		
		$this->EE->config->_global_vars['keywords'] = $keywords; 
	}

	// ----------------------------------------------------------------------

	/**
	 * Disable Extension
	 *
	 * This method removes information from the exp_extensions table
	 *
	 * @return void
	 */
	function disable_extension()
	{
		$this->EE->db->where('class', __CLASS__);
		$this->EE->db->delete('extensions');
	}

	// ----------------------------------------------------------------------

	/**
	 * Update Extension
	 *
	 * This function performs any necessary db updates when the extension
	 * page is visited
	 *
	 * @return 	mixed	void on update / false if none
	 */
	function update_extension($current = '')
	{
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}
	}	
	
	// ----------------------------------------------------------------------
}

/* End of file ext.referrer_keywords.php */
/* Location: /system/expressionengine/third_party/referrer_keywords/ext.referrer_keywords.php */