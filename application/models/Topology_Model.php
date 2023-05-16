<?php

class Topology_Model extends CI_Model{
    
    public function getAllMasts() {
        $this->db->where('mast_name !=', 'Client');
        $query = $this->db->get('tbl_masts');
        return $query->result();
    }
    
}