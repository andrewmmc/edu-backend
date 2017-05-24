<?php

class Transaction_records_model extends CI_Model
{
	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}

	/* 	Columns of transaction_records:
	 * 	transaction_id
	 *  registration_id
	 * 	courses_id
	 *  providers_id
	 * 	members_id
	 * 	amounts
	 * 	status
	 * 	created_at
	 * 	updated_at
	 */

	public function get_all_transaction_records()
	{
		$query = $this->db->get('transaction_records');
		return $query->result();
	}

	public function get_providers_transaction_records($providers_id)
	{
		$this->db->where('providers_id', $providers_id);
		$query = $this->db->get('transaction_records');
		return $query->result();
	}

	public function get_members_transaction_records($members_id)
	{
		$this->db->where('members_id', $members_id);
		$query = $this->db->get('transaction_records');
		return $query->result();
	}

	public function get_courses_transaction_records($courses_id)
	{
		$this->db->where('courses_id', $courses_id);
		$query = $this->db->get('transaction_records');
		return $query->result();
	}

	public function get_transaction_records($transaction_id)
	{
		$this->db->where('transaction_id', $transaction_id);
		$this->db->limit(1);
		$query = $this->db->get('transaction_records');
		return $query->result();
	}

	public function insert_paypal_records($courses_id, $providers_id, $members_id, $amounts, $ref_id)
	{
		$this->courses_id = $courses_id;
		$this->providers_id = $providers_id;
		$this->members_id = $members_id;
		$this->amounts = $amounts;
		$this->ref_id = $ref_id;
		$this->status = 0;

		$this->db->insert('transaction_records', $this);
		return $this->db->insert_id();
	}

	public function paypal_successful($transaction_id)
	{
		$data = array('status' => 1);
		$this->db->where('transaction_id', $transaction_id);
		$this->db->limit(1);
		$this->db->update('transaction_records', $data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
}

?>
