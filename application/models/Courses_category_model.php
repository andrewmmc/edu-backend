<?php

class Courses_category_model extends CI_Model
{
	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}

	/* 	Columns of courses_category:
	 * 	category_id
	 * 	name
	 * 	color
	 */

	public function get_all_courses_category()
	{
		$query = $this->db->get('courses_category');
		return $query->result();
	}

	public function get_courses_category($category_id)
	{
		$this->db->where('category_id', $category_id);
		$this->db->limit(1);
		$query = $this->db->get('courses_category');
		return $query->result();
	}
}

?>
