<?php

class Courses_lessons_model extends CI_Model
{
	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}

	/* 	Columns of courses_lessons:
	 * 	lessons_id
	 * 	courses_id
	 * 	start_time
	 * 	end_time
	 * 	status
	 * 	created_at
	 * 	updated_at
	 */

	public function get_all_courses_lessons()
	{
		$query = $this->db->get('courses_lessons');
		// where status = 1
		return $query->result();
	}

	public function get_courses_lessons($courses_id)
	{
		$this->db->where('courses_id', $courses_id);
		//$this->db->limit(1);
		// where status = 1
		$query = $this->db->get('courses_lessons');
		return $query->result();
	}

	/*public function get_lessons($lessons_id)
	{
		$this->db->where('lessons_id', $lessons_id);
		$this->db->limit(1);
		$query = $this->db->get('courses_lessons');
		return $query->result();
	}*/

	public function insert_lessons($data)
	{
		$this->courses_id = $data['courses_id'];
		$this->start_time = $data['start_time'];
		$this->end_time = $data['end_time'];
		$this->status = $data['status'];

		$this->db->insert('courses_lessons', $this);
		return $this->db->insert_id();
	}

	public function update_lessons($lessons_id, $start_time, $end_time, $status)
	{
		$this->start_time = $start_time;
		$this->end_time = $end_time;
		$this->status = $status;

		$this->db->where('lessons_id', $lessons_id);
		$this->db->limit(1);
		$this->db->update('courses_lessons', $this);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
}

?>
