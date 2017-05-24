<?php

class Courses_attendance_model extends CI_Model
{
	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}

	/* 	Columns of courses_attendance:
	 * 	attendance_id
	 * 	courses_id
	 * 	lessons_id
	 * 	members_id
	 * 	status
	 * 	created_at
	 * 	updated_at
	 */

	public function get_all_courses_attendance()
	{
		$query = $this->db->get('courses_attendance');
		return $query->result();
	}

	public function get_courses_attendance($courses_id)
	{
		$this->db->where('courses_id', $courses_id);
		$query = $this->db->get('courses_attendance');
		return $query->result();
	}

	public function get_lessons_attendance($lessons_id)
	{
		$this->db->where('lessons_id', $lessons_id);
		$query = $this->db->get('courses_attendance');
		return $query->result();
	}

	public function get_members_attendance($members_id)
	{
		$this->db->where('members_id', $members_id);
		$query = $this->db->get('courses_attendance');
		return $query->result();
	}

	public function get_members_courses_attendance($members_id, $courses_id)
	{
		$this->db->where('members_id', $members_id);
		$this->db->where('courses_id', $courses_id);
		$query = $this->db->get('courses_attendance');
		return $query->result();
	}

	public function get_members_lessons_attendance($members_id, $lessons_id)
	{
		$this->db->where('members_id', $members_id);
		$this->db->where('lessons_id', $lessons_id);
		$query = $this->db->get('courses_attendance');
		return $query->result();
	}
	
	public function update_attendance($data)
	{
		$this->db->where('courses_id', $data['courses_id']);
		$this->db->where('lessons_id', $data['lessons_id']);
		$this->db->where('members_id', $data['members_id']);
		$this->db->limit(1);
		$q = $this->db->get('courses_attendance');
		if ($q->num_rows() > 0) {
			$this->courses_id = $data['courses_id'];
			$this->lessons_id = $data['lessons_id'];
			$this->members_id = $data['members_id'];
			$this->status = $data['status'];
			$this->db->update('courses_attendance', $this);
		} else {
			$this->courses_id = $data['courses_id'];
			$this->lessons_id = $data['lessons_id'];
			$this->members_id = $data['members_id'];
			$this->status = $data['status'];
			$this->db->insert('courses_attendance', $this);
		}
		return ($this->db->affected_rows() != 1) ? false : true;
	}
}

?>
