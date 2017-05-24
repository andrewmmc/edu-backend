<?php

class Members_model extends CI_Model
{
	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}

	/* 	Columns of members:
	 * 	members_id
	 * 	username
	 * 	password
	 * 	name
	 * 	email
	 * 	phone
	 * 	birth_date
	 * 	edu_level
	 * 	address
	 * 	scores
	 * 	created_at
	 * 	updated_at
	 * 	remember_token
	 */

	public function get_all_members()
	{
		$this->db->select('members_id, username, name, email, phone, birth_date, edu_level, address, scores');
		$query = $this->db->get('members');
		return $query->result();
	}

	public function get_members($members_id)
	{
		$this->db->select('members_id, username, name, email, phone, birth_date, edu_level, address, scores');
		$this->db->where('members_id', $members_id);
		$this->db->limit(1);
		$query = $this->db->get('members');
		return $query->result();
	}

	public function check_username_exists($username)
	{
		$this->db->where('username', $username);
		$this->db->limit(1);
		$query = $this->db->get('members');
		return $query->result();
	}

	public function login_members($data)
	{
		$this->db->where('username', $data['username']);
		$this->db->limit(1);
		$query = $this->db->get('members');
		$result = $query->result();

		if (empty($result)) {
			return false;
		}

		// use password_verify here, php 5.5 or above
		if (!(password_verify($data['password'], $result[0]->password))) {
			return false;
		} else {
			return true;
		}
	}

	public function insert_members($data)
	{
		$this->username = $data['username'];
		$this->password = password_hash($data['password'], PASSWORD_DEFAULT);
		$this->name = $data['name'];
		$this->email = $data['email'];
		$this->phone = $data['phone'];
		$this->birth_date = $data['birth_date'];
		$this->edu_level = $data['edu_level'];
		$this->address = $data['address'];
		$this->scores = 0;

		$this->db->insert('members', $this);
		return $this->db->insert_id();
	}

	public function update_members($data)
	{
		$this->name = $data['name'];
		$this->email = $data['email'];
		$this->phone = $data['phone'];
		$this->birth_date = $data['birth_date'];
		$this->edu_level = $data['edu_level'];
		$this->address = $data['address'];

		$this->db->where('members_id', $data['members_id']);
		$this->db->limit(1);
		$this->db->update('members', $this);
		return ($this->db->affected_rows() != 1) ? false : true;
	}

	public function update_members_password($members_id, $new_password)
	{
		$this->password = password_hash($new_password, PASSWORD_DEFAULT);

		$this->db->where('members_id', $members_id);
		$this->db->limit(1);
		$this->db->update('members', $this);
		return ($this->db->affected_rows() != 1) ? false : true;
	}

}

?>
