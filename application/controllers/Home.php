<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home extends CI_Controller
{

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
    }

    public function index()
    {
        echo "For API access only.";
    }
}

?>
