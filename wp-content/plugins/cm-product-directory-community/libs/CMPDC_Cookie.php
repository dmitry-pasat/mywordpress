<?php
class CMPD_Cookie
{

	/**
	 * CMPD_Cookie name
	 * 
	 * @var string
	 */
	const COMMUNITYPRODUCT_COOKIE_NAME = 'cmpdc_data';
	
	/**
	 * CMPD_Cookie data array
	 * 
	 * @var array
	 */
	private $_data = array();
	
	/**
	 * Save data to cookie.
	 */
	public function save()
	{
		setcookie(self::COMMUNITYPRODUCT_COOKIE_NAME, json_encode($this->_data));
	}
	
	/**
	 * Get data from cookie
	 * @return array
	 */
	public function getData()
	{
		$data_string = (!empty($_COOKIE[self::COMMUNITYPRODUCT_COOKIE_NAME])?$_COOKIE[self::COMMUNITYPRODUCT_COOKIE_NAME]:'');
		return json_decode(stripslashes($data_string), true);
	}
	
	/**
	 * Save value in data array.
	 * 
	 * @param string $key
	 * @param mixed $value
	 */
	public function __set($key, $value)
	{
		$this->_data[$key] = $value;
	}
	
	/**
	 * Clear cookie data.
	 */
	public function clear()
	{
		// Set expired cookie
		setcookie(self::COMMUNITYPRODUCT_COOKIE_NAME, 0, time() - 3600);
	}
}