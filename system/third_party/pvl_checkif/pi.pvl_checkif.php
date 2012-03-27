<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$plugin_info = array(
	'pi_name' => 'Pvl - checkif',
	'pi_version' =>'0.3',
	'pi_author' =>'Pierre-Vincent Ledoux',
	'pi_author_email' =>'ee-addons@pvledoux.be',
	'pi_author_url' => 'http://twitter.com/pvledoux/',
	'pi_description' => 'Check if a value is in a list, or if it contains an other value',
	'pi_usage' => Pvl_checkif::usage()
);


/**
 * Copyright (c) 2011, Pv Ledoux
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *	* Redistributions of source code must retain the above copyright
 *	   notice, this list of conditions and the following disclaimer.
 *	* Redistributions in binary form must reproduce the above copyright
 *	   notice, this list of conditions and the following disclaimer in the
 *	   documentation and/or other materials provided with the distribution.
 *	* Neither the name of the <organization> nor the
 *	   names of its contributors may be used to endorse or promote products
 *	   derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

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
		$contains	= $this->_ee->TMPL->fetch_param('contains', '');
		$is_in		= $this->_ee->TMPL->fetch_param('is_in', '');
		$is_not_in	= $this->_ee->TMPL->fetch_param('is_not_in', '');
	 	$separator	= $this->_ee->TMPL->fetch_param('separator', '|');

	 	// We parse global vars because we are very kind!
		$value		= $this->_ee->TMPL->parse_globals($value);
		$is_in		= $this->_ee->TMPL->parse_globals($is_in);
		$is_not_in	= $this->_ee->TMPL->parse_globals($is_not_in);

		if ($value !== '') {
			if ($is_in !== '') {
				$is_in = explode($separator, $is_in);
				if (is_array($is_in) && count($is_in)) {
					if (in_array($value, $is_in)) {
						if (strpos($this->_ee->TMPL->tagdata, '{else}')) {
							return substr($this->_ee->TMPL->tagdata, 0, strpos($this->_ee->TMPL->tagdata, '{else}'));
						} else {
							return $this->_ee->TMPL->tagdata;
						}
					} else {
						if (strpos($this->_ee->TMPL->tagdata, '{else}')) {
							return substr($this->_ee->TMPL->tagdata, strpos($this->_ee->TMPL->tagdata, '{else}')+6, strlen($this->_ee->TMPL->tagdata));
						} else {
							return $this->_ee->TMPL->tagdata;
						}
					}
				}
			} elseif ($is_not_in !== '') {
				$is_not_in = explode($separator, $is_not_in);
				if (is_array($is_not_in) && count($is_not_in)) {
					if (!in_array($value, $is_not_in)) {
						if (strpos($this->_ee->TMPL->tagdata, '{else}') !== FALSE) {
							return substr($this->_ee->TMPL->tagdata, 0, strpos($this->_ee->TMPL->tagdata, '{else}'));
						} else {
							return $this->_ee->TMPL->tagdata;
						}
					} else {
						if (strpos($this->_ee->TMPL->tagdata, '{else}')) {
							return substr($this->_ee->TMPL->tagdata, strpos($this->_ee->TMPL->tagdata, '{else}')+6, strlen($this->_ee->TMPL->tagdata));
						} else {
							return $this->_ee->TMPL->tagdata;
						}
					}
				}
			} elseif ($contains !== '') {
				if (strpos($value, $contains) !== FALSE) {
					if (strpos($this->_ee->TMPL->tagdata, '{else}') !== FALSE) {
						return substr($this->_ee->TMPL->tagdata, 0, strpos($this->_ee->TMPL->tagdata, '{else}'));
					} else {
						return $this->_ee->TMPL->tagdata;
					}
				} else {
					if (strpos($this->_ee->TMPL->tagdata, '{else}')) {
						return substr($this->_ee->TMPL->tagdata, strpos($this->_ee->TMPL->tagdata, '{else}')+6, strlen($this->_ee->TMPL->tagdata));
					} else {
						return $this->_ee->TMPL->tagdata;
					}
				}
			}
		}
		return '';

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

			Check if a value is in a list (default separator: |) or if it isn't.

			Parameters:

				- value: required
				- is_in: required if is_not_in is not set
				- is_not_in: required if is_in is not set
				- contains: required if is_in or is_not_in are not set

			------------------------------------------------------

			Examples:
			IS IN condition:
			{exp:pvl_checkif value="123" is_in="1|12|123"}
					<p>Yes Sir!</p>
				{else}
					<p>No Sir!</p>
			{/exp:pvl_checkif}

			IS NOT IN condition:
			{exp:pvl_checkif value="123" is_not_in="1|12"}
					<p>Yes Sir!</p>
				{else}
					<p>No Sir!</p>
			{/exp:pvl_checkif}

			CONTAINS condition:
			{exp:pvl_checkif value="123" contains="12"}
					<p>Yes Sir!</p>
				{else}
					<p>No Sir!</p>
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