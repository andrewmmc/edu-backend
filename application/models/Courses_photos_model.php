<?php

class Courses_photos_model extends CI_Model
{
	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}

	/* 	Columns of courses_photos:
	 * 	photos_id
	 * 	courses_id
	 * 	path
	 * 	description
	 * 	created_at
	 * 	updated_at
	 */

	public function get_all_courses_photos()
	{
		$query = $this->db->get('courses_photos');
		return $query->result();
	}

	public function get_courses_photos($courses_id)
	{
		$this->db->where('courses_id', $courses_id);
		$query = $this->db->get('courses_photos');
		return $query->result();
	}

	public function get_courses_single_photo($photos_id)
	{
		$this->db->where('photos_id', $photos_id);
		$this->db->limit(1);
		$query = $this->db->get('courses_photos');
		return $query->result();
	}

	public function insert_courses_photos($data)
	{
		$this->courses_id = $data['courses_id'];
		$this->path = $data['path'];
		$this->description = '';

		$this->db->insert('courses_photos', $this);
		return $this->db->insert_id();
	}
}

?>
