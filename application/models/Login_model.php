<?php

class Login_model extends CI_Model
{


	public function __construct()
     {
        parent::__construct();
        $this->load->library('email');
     }


    public function authUser($username, $password){
        $active = "1";
		$this->db->where('user_name', $username);
		$this->db->where('user_password', $password);
		$this->db->where('active', $active);
		$result = $this->db->get('tbl_users', 1);
		return $result;
    }

    function getUserLevel($level_id)
	{

		$this->db->where('id', $level_id);
		$result = $this->db->get('tbl_levels', 1);

		return $result;
	}

	public function resetPassword($user_data){

         $this->db->where("user_name", $user_data["user_name"]);
         $q = $this->db->get("tbl_users");
         
        //  var_dump($q->num_rows());

         if ($q->num_rows() > 0) {

            $resEmail = $q->row()->user_email;
            $resName = $q->row()->user_name;

            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $passwordplain = "";
            $passwordplain  = substr(str_shuffle($permitted_chars), 0, 8);

            $newpass['user_password'] = md5($passwordplain);
            $this->db->where("user_name", $user_data["user_name"]);
            $this->db->update('tbl_users', $newpass);

            $sendEmail = $this->sendEmail($resEmail,$passwordplain,$resName);

            if ($sendEmail) {
                return true;
            }
            else{
                return false;
            }

         }else{

            return false;
         }
    }

    public function sendEmail($resEmail,$resPassword,$resName){ 

        $mail_message = "Hello " . $resName. "," . "\n";
        $mail_message .=
        "A password reset request has been created for your account." .
        "\n" .
        "Use this password to login ".
        $resPassword.
        "\n";

        $this->email->from('no-reply@cheetahnet.co.ke', 'CheetahNet');
        $this->email->to($resEmail);
        $this->email->subject('Password Reset!');
        $this->email->message($mail_message);

        if ($this->email->send()) {
           return true;
       } else {
           return false;
       }
    }
}