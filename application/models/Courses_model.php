<?php

class Courses_model extends CI_Model
{
	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}

	/* 	Columns of courses:
	 * 	courses_id
	 * 	providers_id
	 * 	title
	 * 	short_description
	 * 	full_description
	 * 	city_id
	 * 	full_address
	 * 	teacher
	 * 	total_seats
	 * 	taken_seats
	 * 	category_id
	 * 	price
	 * 	remarks
	 * 	status
	 * 	created_at
	 * 	updated_at
	 */

	public function get_all_courses()
	{
		$query = $this->db->get('courses');
		// where status = 1
		return $query->result();
	}

	public function get_courses_category($category_id)
	{
		$this->db->where('category_id', $category_id);
		$query = $this->db->get('courses');
		return $query->result();
	}

	public function search_courses($data)
	{
		if (isset($data['title'])) {
			$this->db->like('title', $data['title']);
		}
		if (isset($data['city_id'])) {
			$this->db->where('city_id', $data['city_id']);
		}
		if (isset($data['category_id'])) {
			$this->db->where('category_id', $data['category_id']);
		}
		$query = $this->db->get('courses');
		return $query->result();
	}

	public function get_courses($courses_id)
	{
		$this->db->where('courses_id', $courses_id);
		$this->db->limit(1);
		$query = $this->db->get('courses');
		return $query->result();
	}

	public function get_courses_price($courses_id)
	{
		$this->db->select('price');
		$this->db->where('courses_id', $courses_id);
		$this->db->limit(1);
		$query = $this->db->get('courses');
		return $query->result();
	}

	public function get_providers_courses($providers_id)
	{
		$this->db->where('providers_id', $providers_id);
		$query = $this->db->get('courses');
		return $query->result();
	}

	public function insert_courses($data)
	{
		$this->providers_id = $data['providers_id'];
		$this->title = $data['title'];
		$this->short_description = $data['short_description'];
		$this->full_description = $data['full_description'];
		$this->city_id = $data['city_id'];
		$this->full_address = $data['full_address'];
		$this->teacher = $data['teacher'];
		$this->total_seats = $data['total_seats'];
		$this->taken_seats = 0;
		$this->category_id = $data['category_id'];
		$this->price = $data['price'];
		$this->remarks = $data['remarks'];
		$this->status = /*$data['status']*/
			1;

		$this->db->insert('courses', $this);
		return $this->db->insert_id();
	}

	public function update_courses($data)
	{
		$this->title = $data['title'];
		$this->short_description = $data['short_description'];
		$this->full_description = $data['full_description'];
		$this->city_id = $data['city_id'];
		$this->full_address = $data['full_address'];
		$this->teacher = $data['teacher'];
		$this->total_seats = $data['total_seats'];
		$this->category_id = $data['category_id'];
		$this->price = $data['price'];
		$this->remarks = $data['remarks'];
		$this->status = $data['status'];

		$this->db->where('courses_id', $data['courses_id']);
		$this->db->limit(1);
		$this->db->update('courses', $this);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
}

?>
