<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsersController extends CI_Controller {


public function __construct()
{
    parent::__construct();
    $this->load->model('Users_Model','users_model');
    $this->load->model('Login_Model','login_model');
   
}

public function index(){
    $all_roles = $this->users_model->get_all_roles();
    $pagedata['all_roles'] = $all_roles;
    $page = 'Users';
        $this->load->view('includes/header');
        $this->load->view('includes/topbar');
        $this->load->view('includes/sidebar');
        $this->load->view('pages/'.$page,$pagedata);
        $this->load->view('includes/footer');
        $this->load->view('includes/js/users_script');
        
    }


    public function account(){
    
    $page = 'account';
        $this->load->view('includes/header');
        $this->load->view('includes/topbar');
        $this->load->view('includes/sidebar');
        $this->load->view('pages/'.$page);
        $this->load->view('includes/footer');
        $this->load->view('includes/js/users_script');
        
    }



    public function getAllUsers(){
            // Datatables Variables
            $draw = intval($this->input->get("draw"));
            $start = intval($this->input->get("start"));
            $length = intval($this->input->get("length"));


            $all_users = $this->users_model->getAllUsers();

            $data = array();

            foreach($all_users->result() as $r) {

                $data[] = array(
                    
                    $r->user_id,
                    $r->user_name,
                    $r->full_names,
                    $r->phonenumber,
                    $r->user_email,
                    $this->getUserLevel($r->user_level),
                   
                );
            }

            $output = array(
                "draw" => $draw,
                "recordsTotal" => $all_users->num_rows(),
                "recordsFiltered" => $all_users->num_rows(),
                "data" => $data
            );
            echo json_encode($output);
            exit();
    }


    function getUserLevel($level_id)
    {

        $level_data = $this->login_model->getUserLevel($level_id);
        $data = $level_data->row_array();
        $level_name = $data['level_name'];

        return $level_name;
    }

    public function insertUserData(){

    $user_data['user_id'] = $this->input->post('user_id',TRUE);
    $user_data['user_name'] = $this->input->post('user_name',TRUE);
    $user_data['full_names'] = $this->input->post('full_name',TRUE);
    $user_data['phonenumber'] = $this->input->post('phone_number',TRUE);
    $user_data['user_email'] = $this->input->post('email',TRUE);
    $user_data['user_password']  = md5("12345678");
    $user_data['user_level']  = $this->input->post('user_role',TRUE);

    $user_data = $this->users_model->insertUserData($user_data);
    if ($user_data){

        $response=array(
            'error'=>0,
            'message' => "Saved Succcessfully!!"
        );
        
    }
    else{

        $response=array(
            'status'=>1,
            'message' => "Failed! Please try again!"
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

public function deleteUser(){

    $user_data['user_id'] = $this->input->post('user_id',TRUE);

    $user_data = $this->users_model->deleteUser($user_data);
    if ($user_data){

        $response=array(
            'error'=>0,
            'message' => "User Deleted Succcessfully!!"
        );
        
    }
    else{

        $response=array(
            'status'=>1,
            'message' => "Failed! Please try again!"
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

public function changePassword(){

    $user_data['currentpassword'] = $this->input->post('currentPassword',TRUE);
    $user_data['newpassword'] = $this->input->post('newPassword',TRUE);
    $user_data['renewpassword'] = $this->input->post('renewPassword',TRUE);

    $user_data = $this->users_model->changePassword($user_data);
    if ($user_data){

        $response=array(
            'error'=>0,
            'message' => "Saved Succcessfully!!"
        );
        
    }
    else{

        $response=array(
            'status'=>1,
            'message' => "Failed! Please try again!"
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}




public function editProfile(){

    $user_data['full_names'] = $this->input->post('fullName',TRUE);
    $user_data['phonenumber'] = $this->input->post('phone',TRUE);
    $user_data['user_email'] = $this->input->post('email',TRUE);

    $userData = $this->users_model->editProfile($user_data);
    if ($userData){

        $sesdata = array(
                'full_names' => $user_data['full_names'],
                'email' => $user_data['user_email'],
                'uphone' => $user_data['phonenumber']
            );
            $this->session->set_userdata($sesdata);

        $response=array(
            'error'=>0,
            'message' => "Saved Succcessfully!!"
        );
        
    }
    else{

        $response=array(
            'status'=>1,
            'message' => "Failed! Please try again!"
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

}