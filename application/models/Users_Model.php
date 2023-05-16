<?php

class Users_Model extends CI_Model
{
    public function getAllUsers()
    {
        return $this->db->get("tbl_users");
    }

    public function insertUserData($user_data){

        $this->db->where("user_id", $user_data["user_id"]);
        $q = $this->db->get("tbl_users");

        if ($q->num_rows() > 0) {

            $this->db->where("user_id", $user_data["user_id"]);
            $this->db->update("tbl_users", $user_data);
            return true;

        } else {

            $this->db->insert('tbl_users',$user_data);
            return true;
        }

    }

      public function get_all_roles(){

       $query = $this->db->get('tbl_levels');
        return $query->result();

   }

   public function deleteUser($userData){

        $this->db->where("user_id", $userData["user_id"]);
        $this->db->delete('tbl_users');

        if ($this->db->error()['message']) {
            return false;
        } else if (!$this->db->affected_rows()) {
            return false;
        } else {
            return true;
        }
}

    public function changePassword($user_data) {
        
        $this->db->where("user_id", $this->session->userdata('uid'));
        $this->db->where("user_password", md5($user_data["currentpassword"]));
        $q = $this->db->get("tbl_users");

        $new_pass['user_password'] = md5($user_data["newpassword"]);


        if ($q->num_rows() > 0) {

            if ($user_data['newpassword']===$user_data['renewpassword']){
                $this->db->where("user_id", $this->session->userdata('uid'));
                $this->db->update("tbl_users", $new_pass);
                return true;
            }
            else{
                return false;
            }

        } else {

            
        }
    }

    public function editProfile($user_data) {
        
        $this->db->where("user_id", $this->session->userdata('uid'));
        $q = $this->db->get("tbl_users");


        if ($q->num_rows() > 0) {

            
                $this->db->where("user_id", $this->session->userdata('uid'));
                $this->db->update("tbl_users", $user_data);
                return true;  
        } 
        else {
            return false; 
        }

    }

   
    

}