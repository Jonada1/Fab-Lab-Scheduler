<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	public function get_autocomplete($search_data, $offset=0)
    {
		$this->db->select('main.id, main.email, main.name, extra.phone_number, extra.surname, extra.student_number');
		$this->db->from('aauth_users as main');
		$this->db->join('extended_users_information as extra', 'main.id = extra.id');
		$this->db->like('main.email', $search_data);
        $this->db->or_like('main.name', $search_data);
		$this->db->or_like('extra.phone_number', $search_data);
		$this->db->or_like('extra.surname', $search_data);
		$this->db->or_like('extra.student_number', $search_data);
		$this->db->limit(10);
		$this->db->offset($offset);
		return $this->db->get();
    }
	
	public function get_user_data($user_id) {
		$this->db->select('main.id, main.email, main.name, 
			main.banned, extra.phone_number, extra.surname, 
			extra.student_number, extra.address_street, extra.address_postal_code, 
			extra.company');
		$this->db->from('aauth_users as main');
		$this->db->join('extended_users_information as extra', 'main.id = extra.id');
		$this->db->where('main.id', $user_id);
		return $this->db->get();
	}
	
	public function update_user_data($user_data) {
		$data = array(
			'surname' => $user_data['surname'],
			'address_street' => $user_data['surname'],
			'address_postal_code' => $user_data['address_postal_code'],
			'phone_number' => $user_data['phone_number'],
			'student_number' => $user_data['student_number']
		);
		$this->db->trans_start();
		$this->db->where('id', $user_data['user_id']);
		$this->db->update('extended_users_information', $data);
		$this->db->trans_complete();
		if ($this->db->affected_rows() == '1') {
			return true;
		} else {
			if ($this->db->trans_status() === FALSE) {
				return false;
			}
			return true;
		}
	}
}