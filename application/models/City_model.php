<?php

class City_model extends CI_Model
{
	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}

	/* 	Columns of city:
	 * 	city_id
	 * 	name
	 */

	public function get_all_city()
	{
		$query = $this->db->get('city');
		return $query->result();
	}
}

?>
