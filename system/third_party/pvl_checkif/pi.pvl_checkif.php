<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$plugin_info = array(
	'pi_name' => 'Pvl - checkif',
	'pi_version' =>'0.1',
	'pi_author' =>'Pierre-Vincent Ledoux',
	'pi_author_email' =>'ee-addons@pvledoux.be',
	'pi_author_url' => 'http://twitter.com/pvledoux/',
	'pi_description' => 'Check if a value is in a list',
	'pi_usage' => Pvl_checkif::usage()
);

/**
 * Pvl_checkif
 *
 * @copyright	Pv Ledoux 2011
 * @since		25 Aug 2011
 * @author		Pierre-Vincent Ledoux <ee-addons@pvledoux.be>
 * @link		http://www.twitter.com/pvledoux/
 *
 */
class Pvl_checkif
{

	/**
	* Data returned from the plugin.
	*
	* @access	public
	* @var		array
	*/
	public $return_data = '';


	private $_ee = NULL;

	/**
	* Constructor.
	*
	* @access	public
	* @return	void
	*/
	public function __construct()
	{
		$this->_ee =& get_instance();
		$this->return_data = $this->_output();
	}


	/**
	* Annoyingly, the supposedly PHP5-only EE2 still requires this PHP4
	* constructor in order to function.
	* method first seen used by Stephen Lewis (https://github.com/experience/you_are_here.ee2_addon)
	*
	* @access public
	* @return void
	*/
	public function Pvl_checkif()
	{
		$this->__construct();
	}


	/**
	 * Check if a value is part of a list,
	 * and parse the template tag if positive.
	 *
	 * @access	private
	 * @return	string
	 */
	private function _output()
	{
		//Get parameter
    	$value		= $this->_ee->TMPL->fetch_param('value', '');
    	$is_in		= $this->_ee->TMPL->fetch_param('is_in', '');
     	$separator	= $this->_ee->TMPL->fetch_param('separator', '|');

     	// We parse global vars because we are very kind!
		$value = $this->_ee->TMPL->parse_globals($value);
		$is_in = $this->_ee->TMPL->parse_globals($is_in);

    	if ($value !== '' && $is_in !== '') {

			$is_in = explode($separator, $is_in);

			if (is_array($is_in) && count($is_in)) {

				if (in_array($value, $is_in)) {

					return $this->_ee->TMPL->tagdata;

				}

			}

    	} else {

    		return '';

    	}

	}

	/**
	 * Usage
	 *
	 * This function describes how the plugin is used.
	 *
	 * @access	public
	 * @return	string
	 */
	static function usage()
	{
		ob_start();
		?>

			Description:

			Check if a value is in a list (default separator: |)

			------------------------------------------------------

			Examples:
			{exp:pvl_checkif value="123" is_in="1|12|123"}
				<p>Yes Sir!</p>
			{/exp:pvl_checkif}

			------------------------------------------------------

		<?php
		$buffer = ob_get_contents();

		ob_end_clean();

		return $buffer;
	}
	  // END

	}


/* End of file pi.pvl_checkif.php */
/* Location: ./system/expressionengine/third_party/pvl_checkif/pi.pvl_checkif.php */