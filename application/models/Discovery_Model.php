<?php

class Discovery_Model extends CI_Model
{

    public function get_interface(){
        $query = $this->db->get('tbl_interfaces');
        return $query->result();
    }

    public function insertInterfaceData($interface_data)
    {
        $this->db->where("id", 1);
        $query = $this->db->get("tbl_interfaces");

        if ($query->num_rows() > 0) {
            $this->db->where("id", 1);
            $this->db->update("tbl_interfaces", $interface_data);
        } else {
            $interface_data['id'] = 1;
            $this->db->insert('tbl_interfaces', $interface_data);
        }

        if ($this->db->affected_rows() >= 0) {
            return true;
        } else {
            $error_message = $this->db->error()['message'];
            $response = array(
                'error' => 1,
                'message' => "Database Error: $error_message"
            );
            header('Content-Type: application/json');
            echo json_encode($response);
            return false;
        }
}





}