<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_user_data($id) 
    {
    	$sql = "select * from extended_users_information where id=?";
    	$query = $this->db->query($sql, array($id));
    	var_dump($id);
    	var_dump($query);
    	die();
    	return $query->row();
    }

}