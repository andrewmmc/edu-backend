<?php

class Courses_documents_model extends CI_Model
{
	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}

	/* 	Columns of courses_documents:
	 * 	documents_id
	 * 	courses_id
	 * 	path
	 * 	description
	 * 	created_at
	 * 	updated_at
	 */

	public function get_all_courses_documents()
	{
		$query = $this->db->get('courses_documents');
		return $query->result();
	}

	public function get_courses_documents($courses_id)
	{
		$this->db->where('courses_id', $courses_id);
		$query = $this->db->get('courses_documents');
		return $query->result();
	}

	public function get_courses_single_document($documents_id)
	{
		$this->db->where('documents_id', $documents_id);
		$this->db->limit(1);
		$query = $this->db->get('courses_documents');
		return $query->result();
	}

	public function insert_courses_documents($data)
	{
		$this->courses_id = $data['courses_id'];
		$this->path = $data['path'];
		$this->description = '';

		$this->db->insert('courses_documents', $this);
		return $this->db->insert_id();
	}
}

?>
