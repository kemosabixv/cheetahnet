<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	function __construct()
	{
		parent::__construct();
		$this->load->model('login_model','loginModel');
	}

	public function index()
	{
		if ($this->session->userdata('logged_in')) 
		{
			redirect('home');
		} 
		$this->load->view('authentication/login');
	}



	public function authenticate_user()
	{
		$username = $this->input->post('username', TRUE);
		$password = md5($this->input->post('password', TRUE));
		$validate = $this->loginModel->authUser($username, $password);
		if($validate->num_rows() > 0){
			$data = $validate->row_array();
			$usid = $data['user_id'];
			$name = $data['user_name'];
			$full_names = $data['full_names'];
			$email = $data['user_email'];
			$level = $data['user_level'];
			$active = $data['active'];
			$isFirsTimeLogin = $data['isFirstTimeLogin'];
			$uphone = $data['phonenumber'];
			$sesdata = array(
				'username' => $name,
				'full_names' => $full_names,
				'level_name' => $this->getUserLevel($level),
				'email' => $email,
				'uid' => $usid,
				'level' => $level,
				'isFirstTimeLogin' => $isFirsTimeLogin,
				'uphone' => $uphone,
				'logged_in' => TRUE
			);
			$this->session->set_userdata($sesdata);
			$response = array(
				'error' => 0,
				'message' => "Welcome!"
			);
			
		} else {
           $response = array(
				'error' => 1,
				'message' => "Username or Password is Wrong!!"
			);			
		}
		header('Content-Type: application/json');
		echo json_encode($response);
		
	}

	function getUserLevel($level_id)
	{

		$level_data = $this->loginModel->getUserLevel($level_id);
		$data = $level_data->row_array();
		$level_name = $data['level_name'];

		return $level_name;
	}

	public function signout(){

      $this->session->sess_destroy();
      redirect('home');

	}

	public function forgotpassword(){

		$this->load->view('authentication/forgotpassword');

	}

	
	public function resetPassword(){

		$user_data['user_name'] = $this->input->post('userName',TRUE);

		$userData = $this->loginModel->resetPassword($user_data);

		if($userData){
			$response = array(
			 		'error' => 0,
			 		'message' => "A password has been sent to the associated email!",
			 	);
		}
		 else{
		 	$response = array(
			 		'error' => 1,
			 		'message' => "Oops! An error occured!"
			 	);
		 }

		 header('Content-Type: application/json');
		 echo json_encode($response);

	}



}
