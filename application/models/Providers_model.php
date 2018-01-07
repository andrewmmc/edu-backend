<?php

class Providers_model extends CI_Model
{
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    /* 	Columns of providers:
     * 	providers_id
     * 	username
     * 	password
     * 	title
     * 	description
     * 	city_id
     * 	phone
     * 	email
     * 	office_address
     * 	gov_registered
     * 	logo_path
     * 	created_at
     * 	updated_at
     * 	remember_token
     */

    public function get_all_providers()
    {
        $this->db->select('providers_id, username, title, description, city_id, phone, email, office_address, gov_registered, logo_path');
        $query = $this->db->get('providers');
        return $query->result();
    }

    public function get_providers($providers_id)
    {
        $this->db->select('providers_id, username, title, description, city_id, phone, email, office_address, gov_registered, logo_path');
        $this->db->where('providers_id', $providers_id);
        $this->db->limit(1);
        $query = $this->db->get('providers');
        return $query->result();
    }

    public function login_providers($data)
    {
        $this->db->where('username', $data['username']);
        $this->db->limit(1);
        $query = $this->db->get('providers');
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

    public function check_username_exists($username)
    {
        $this->db->where('username', $username);
        $this->db->limit(1);
        $query = $this->db->get('providers');
        return $query->result();
    }

    public function insert_providers($data)
    {
        $this->username = $data['username'];
        $this->password = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->city_id = $data['city_id'];
        $this->phone = $data['phone'];
        $this->email = $data['email'];
        $this->office_address = $data['office_address'];
        $this->gov_registered = $data['gov_registered'];

        $this->db->insert('providers', $this);
        return $this->db->insert_id();
    }

    public function update_providers($data)
    {
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->city_id = $data['city_id'];
        $this->phone = $data['phone'];
        $this->email = $data['email'];
        $this->office_address = $data['office_address'];
        $this->gov_registered = $data['gov_registered'];

        $this->db->where('providers_id', $data['providers_id']);
        $this->db->limit(1);
        $this->db->update('providers', $this);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function update_providers_password($providers_id, $new_password)
    {
        $this->password = password_hash($new_password, PASSWORD_DEFAULT);

        $this->db->where('providers_id', $providers_id);
        $this->db->limit(1);
        $this->db->update('providers', $this);
        return ($this->db->affected_rows() != 1) ? false : true;
    }
}

?>
