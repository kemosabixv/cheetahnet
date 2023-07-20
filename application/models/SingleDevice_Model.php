<?php

class SingleDevice_Model extends CI_Model
{

    public function getdeviceconnectionstatus($ipaddress) {
        // Get connection_status for the associated IP address in tbl_devices
        $this->db->select('connection_status');
        $this->db->from('tbl_devices');
        $this->db->where('ip_address', $ipaddress);
        $query = $this->db->get();
        $result = $query->row_array(); // Use row_array() to return a single row as an array
        return $result;
    }

    public function getdevicedata($ipaddress) {
       // Get connection_status for the associated IP address in tbl_devices
       $this->db->select('*');
       $this->db->from('tbl_devices');
       $this->db->where('ip_address', $ipaddress);
       $query = $this->db->get();
       $result = $query->row_array(); // Use row_array() to return a single row as an array
       return $result;
   }
   public function update_notifications($ipaddress) {
       $this->db->set('connection_status', 'Online');
       $this->db->where('ip_address', $ipaddress);
       $this->db->update('tbl_devices');
   }
   public function delete_past_notifications($ipaddress){
         $this->db->where('ip_address', $ipaddress);
         $this->db->delete('tbl_notifications');
   }
}