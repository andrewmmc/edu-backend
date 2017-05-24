<?php

class Courses_registration_model extends CI_Model
{
	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}

	/* 	Columns of courses_registration:
	 * 	registration_id
	 * 	courses_id
	 *  transaction_id
	 * 	members_id
	 * 	status
	 * 	created_at
	 * 	updated_at
	 */

	public function get_all_registration()
	{
		$query = $this->db->get('courses_registration');
		return $query->result();
	}

	public function get_courses_registration($courses_id)
	{
		$this->db->where('courses_id', $courses_id);
		$query = $this->db->get('courses_registration');
		return $query->result();
	}

	public function get_members_registration($members_id)
	{
		$this->db->where('members_id', $members_id);
		$query = $this->db->get('courses_registration');
		return $query->result();
	}

	public function get_courses_members_registration($courses_id, $members_id)
	{
		$this->db->where('courses_id', $courses_id);
		$this->db->where('members_id', $members_id);
		$query = $this->db->get('courses_registration');
		$this->db->limit(1);
		return $query->result();
	}

	public function insert_courses_registration($courses_id, $transaction_id, $members_id)
	{
		$this->courses_id = $courses_id;
		$this->transaction_id = $transaction_id;
		$this->members_id = $members_id;
		$this->status = 1;

		$this->db->insert('courses_registration', $this);
		return $this->db->insert_id();
	}
}

?>
